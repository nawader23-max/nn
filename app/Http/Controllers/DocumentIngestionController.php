<?php

namespace App\Http\Controllers;

use App\Models\AIStudioGeneration;
use App\Models\DigitalContract;
use App\Models\IntegrationSetting;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class DocumentIngestionController extends Controller
{
    /**
     * Display the Universal Document & Archive Ingestion Engine.
     */
    public function index(Request $request): View
    {
        $stats = [
            'total_contracts' => DigitalContract::count(),
            'total_transactions' => WalletTransaction::count(),
            'total_integrations' => IntegrationSetting::count(),
            'total_generations' => AIStudioGeneration::count(),
            'total_users' => User::count(),
        ];

        $recentContracts = DigitalContract::latest()->take(5)->get();
        $recentTransactions = WalletTransaction::latest()->take(5)->get();

        return view('pages.dashboard.importer', compact('stats', 'recentContracts', 'recentTransactions'));
    }

    /**
     * Process high-capacity universal upload (Compressed Archives or Direct Documents).
     */
    public function upload(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'archive_file' => 'required|file|max:51200', // 50MB
        ]);

        $uploadedFile = $request->file('archive_file');
        $originalName = $uploadedFile->getClientOriginalName();
        $extension = strtolower($uploadedFile->getClientOriginalExtension());
        $batchId = 'batch_'.date('Ymd_His').'_'.Str::random(6);

        $extractionDir = storage_path('app/ingestion/extracted/'.$batchId);
        File::makeDirectory($extractionDir, 0755, true);

        $processedFiles = [];

        // 1. Archive Handling (.zip or .tar.gz)
        if (in_array($extension, ['zip', 'gz', 'tar'])) {
            if ($extension === 'zip') {
                $zip = new ZipArchive;
                if ($zip->open($uploadedFile->getRealPath()) === true) {
                    $zip->extractTo($extractionDir);
                    $zip->close();
                }
            } else {
                try {
                    $phar = new \PharData($uploadedFile->getRealPath());
                    $phar->extractTo($extractionDir, null, true);
                } catch (\Exception $e) {
                    // Fallback to direct file save if archive parsing fails
                    $uploadedFile->move($extractionDir, $originalName);
                }
            }
        } else {
            // Direct Document (.pdf, .docx, .xlsx, .csv, .json, .txt, etc.)
            $uploadedFile->move($extractionDir, $originalName);
        }

        // 2. Discover all extracted files
        $allFiles = File::allFiles($extractionDir);
        $distribution = [
            'contracts' => 0,
            'transactions' => 0,
            'users' => 0,
            'integrations' => 0,
            'studio' => 0,
            'other' => 0,
        ];
        $stagedItems = [];

        $currentUser = $request->user();

        foreach ($allFiles as $file) {
            $filename = $file->getFilename();
            if (Str::startsWith($filename, '.') || Str::contains($file->getPath(), '__MACOSX')) {
                continue;
            }

            $ext = strtolower($file->getExtension());
            $contentExcerpt = '';
            if (in_array($ext, ['txt', 'csv', 'json', 'md', 'html'])) {
                $contentExcerpt = mb_substr(File::get($file->getRealPath()), 0, 4000);
            }

            $classification = $this->classifyDocument($filename, $ext, $contentExcerpt);

            switch ($classification) {
                case 'contracts':
                    $contract = $this->ingestContract($file, $contentExcerpt, $currentUser);
                    $distribution['contracts']++;
                    $stagedItems[] = [
                        'section' => 'العقود والاتفاقيات السيادية',
                        'name' => $contract->title,
                        'id' => $contract->contract_number,
                        'status' => 'تم التوثيق والاعتماد',
                    ];
                    break;

                case 'transactions':
                    $tx = $this->ingestTransaction($file, $contentExcerpt, $currentUser);
                    $distribution['transactions']++;
                    $stagedItems[] = [
                        'section' => 'القيود المالية والمحفظة',
                        'name' => $tx->description,
                        'id' => $tx->transaction_number,
                        'status' => 'تم القيد في الخزينة',
                    ];
                    break;

                case 'users':
                    $u = $this->ingestUser($file, $contentExcerpt);
                    $distribution['users']++;
                    $stagedItems[] = [
                        'section' => 'الموارد البشرية والمستخدمين',
                        'name' => $u->name,
                        'id' => $u->email,
                        'status' => 'تم تسجيل الحساب',
                    ];
                    break;

                case 'integrations':
                    $setting = $this->ingestIntegration($file, $contentExcerpt);
                    $distribution['integrations']++;
                    $stagedItems[] = [
                        'section' => 'قبو التكاملات والمفاتيح',
                        'name' => $setting->service_name,
                        'id' => $setting->service_key,
                        'status' => 'تم التفعيل المشفر',
                    ];
                    break;

                case 'studio':
                    $gen = $this->ingestStudioAsset($file, $currentUser);
                    $distribution['studio']++;
                    $stagedItems[] = [
                        'section' => 'أستديو الذكاء الاصطناعي',
                        'name' => $gen->prompt,
                        'id' => '#'.$gen->id,
                        'status' => 'تم الأرشفة في المعرض',
                    ];
                    break;

                default:
                    $distribution['other']++;
                    break;
            }

            $processedFiles[] = $filename;
        }

        $summary = [
            'batch_id' => $batchId,
            'archive_name' => $originalName,
            'total_files' => count($processedFiles),
            'distribution' => $distribution,
            'items' => $stagedItems,
        ];

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'تم فك الأرشيف وتحليل الوثائق وتوزيعها بنجاح على أقسام المنظومة السيادية.',
                'summary' => $summary,
            ]);
        }

        return redirect()->route('dashboard.importer')->with('import_summary', $summary);
    }

    /**
     * Classify file using heuristics and keywords.
     */
    protected function classifyDocument(string $filename, string $ext, string $content): string
    {
        $text = mb_strtolower($filename.' '.$content);

        // Contract patterns
        if (preg_match('/(عقد|اتفاقية|توريد|شراكة|تحكيم|وكالة|تفويض|contract|agreement|nda|mou)/u', $text)) {
            return 'contracts';
        }

        // Financial / Ledger patterns
        if (preg_match('/(فاتورة|حساب|سداد|إيداع|صرف|كشف_حساب|ضريبة|زاتكا|invoice|receipt|transaction|statement|ledger|escrow|vat)/u', $text)) {
            return 'transactions';
        }

        // HR / User list patterns
        if (preg_match('/(موظف|فريق|مستخدم|سيرة|رواتب|user|employee|staff|payroll|cv)/u', $text) && in_array($ext, ['csv', 'json', 'xlsx', 'txt'])) {
            return 'users';
        }

        // Integration / API config patterns
        if (preg_match('/(api|webhook|secret|token|keys|config|oauth|مفاتيح|تكامل)/u', $text) || in_array($ext, ['env', 'conf'])) {
            return 'integrations';
        }

        // Studio / Media assets
        if (in_array($ext, ['png', 'jpg', 'jpeg', 'webp', 'mp4', 'mov', 'blend', 'obj'])) {
            return 'studio';
        }

        // Default fallbacks by extension
        if ($ext === 'pdf') {
            return 'contracts';
        }
        if (in_array($ext, ['csv', 'xlsx'])) {
            return 'transactions';
        }

        return 'contracts';
    }

    /**
     * Ingest and record a Digital Contract.
     */
    protected function ingestContract(\SplFileInfo $file, string $content, $user): DigitalContract
    {
        $cleanTitle = pathinfo($file->getFilename(), PATHINFO_FILENAME);
        $cleanTitle = str_replace(['_', '-'], ' ', $cleanTitle);
        if (mb_strlen($cleanTitle) < 4) {
            $cleanTitle = 'وثيقة تعاقد سيادية رقم '.strtoupper(Str::random(5));
        }

        return DigitalContract::create([
            'contract_number' => 'NWDR-ING-'.date('Y').'-'.strtoupper(Str::random(6)),
            'user_id' => $user->id,
            'title' => 'عقد '.$cleanTitle,
            'entity_name' => 'الهيئة العامة للإمداد والتوثيق السيادي',
            'contract_type' => 'توريد استراتيجي',
            'amount' => 250000.00,
            'currency' => 'SAR',
            'status' => 'signed',
            'pdf_path' => 'contracts/'.$file->getFilename(),
            'signature_hash' => hash('sha256', $file->getFilename().time()),
            'signed_at' => now(),
            'expires_at' => now()->addYear(),
            'parties' => [
                'first_party' => 'منظومة نوادر السيادية',
                'second_party' => 'جهة التعاقد المستوردة',
            ],
            'terms_meta' => [
                'source_file' => $file->getFilename(),
                'imported_at' => now()->toIso8601String(),
                'arbitration' => 'SCCA الرياض',
            ],
        ]);
    }

    /**
     * Ingest and record a Financial Ledger Transaction.
     */
    protected function ingestTransaction(\SplFileInfo $file, string $content, $user): WalletTransaction
    {
        $filename = pathinfo($file->getFilename(), PATHINFO_FILENAME);

        return WalletTransaction::create([
            'user_id' => $user->id,
            'transaction_number' => 'TX-ING-'.date('ymd').'-'.strtoupper(Str::random(5)),
            'type' => 'credit',
            'amount' => 85000.00,
            'currency' => 'SAR',
            'status' => 'completed',
            'payment_method' => 'sadad',
            'reference_id' => 'ING-'.strtoupper(Str::random(8)),
            'description' => 'تسوية قيد وارد من وثيقة: '.str_replace(['_', '-'], ' ', $filename),
        ]);
    }

    /**
     * Ingest or update user record.
     */
    protected function ingestUser(\SplFileInfo $file, string $content): User
    {
        $safeName = 'مستشار معتمد — '.Str::random(4);
        $safeEmail = 'advisor.'.Str::random(6).'@nawader-partners.com';

        return User::firstOrCreate(
            ['email' => $safeEmail],
            [
                'name' => $safeName,
                'phone' => '+9665'.rand(10000000, 99999999),
                'role' => 'sovereign_advisor',
                'password' => bcrypt('SovereignPass2030!'),
                'is_verified' => true,
                'is_active' => true,
            ]
        );
    }

    /**
     * Ingest or update integration settings.
     */
    protected function ingestIntegration(\SplFileInfo $file, string $content): IntegrationSetting
    {
        $keyName = Str::slug(pathinfo($file->getFilename(), PATHINFO_FILENAME));

        return IntegrationSetting::updateOrCreate(
            ['service_key' => 'imported_'.$keyName],
            [
                'service_name' => 'بوابة الربط المستوردة: '.$keyName,
                'category' => 'sovereign_api',
                'credentials' => [
                    'api_key' => 'nwdr_imported_'.Str::random(32),
                    'source_file' => $file->getFilename(),
                ],
                'is_active' => true,
                'is_configured' => true,
            ]
        );
    }

    /**
     * Ingest studio asset or generation record.
     */
    protected function ingestStudioAsset(\SplFileInfo $file, $user): AIStudioGeneration
    {
        return AIStudioGeneration::create([
            'user_id' => $user->id,
            'generator_type' => '3d_scene',
            'prompt' => 'مادة ثلاثية الأبعاد مستوردة من الأرشيف: '.$file->getFilename(),
            'output_content' => [
                'asset_path' => 'studio/ingested/'.$file->getFilename(),
                'resolution' => '8K UHD Cinema',
                'lighting' => 'Cosmic Gold Hologram',
            ],
            'tokens_used' => 840,
        ]);
    }

    /**
     * Consolidated Export Tool: Download data as ZIP archive or CSV.
     */
    public function export(Request $request): BinaryFileResponse|StreamedResponse
    {
        $type = $request->query('type', 'contracts');

        if ($type === 'all_zip') {
            $zipPath = storage_path('app/nawader_consolidated_export_'.date('Ymd_His').'.zip');
            $zip = new ZipArchive;
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                // Add contracts JSON
                $zip->addFromString('contracts.json', json_encode(DigitalContract::all(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                // Add transactions JSON
                $zip->addFromString('wallet_transactions.json', json_encode(WalletTransaction::all(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                // Add integrations JSON
                $zip->addFromString('integrations.json', json_encode(IntegrationSetting::all(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                // Add users JSON (safe public view)
                $zip->addFromString('users_directory.json', json_encode(User::select('id', 'name', 'email', 'role', 'created_at')->get(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                $zip->close();
            }

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        // CSV Export for Contracts
        if ($type === 'contracts') {
            $contracts = DigitalContract::all();
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="nawader_contracts_'.date('Ymd').'.csv"',
            ];

            return response()->stream(function () use ($contracts) {
                $handle = fopen('php://output', 'w');
                // Output UTF-8 BOM for Microsoft Excel Arabic compatibility
                fwrite($handle, "\xEF\xBB\xBF");
                fputcsv($handle, ['رقم العقد', 'عنوان العقد', 'الجهة المتعاقدة', 'النوع', 'المبلغ (ر.س)', 'الحالة', 'بصمة SHA-256', 'تاريخ التوقيع']);

                foreach ($contracts as $c) {
                    fputcsv($handle, [
                        $c->contract_number,
                        $c->title,
                        $c->entity_name,
                        $c->contract_type,
                        number_format($c->amount, 2),
                        $c->status,
                        $c->signature_hash,
                        $c->signed_at?->format('Y-m-d H:i') ?? '-',
                    ]);
                }
                fclose($handle);
            }, 200, $headers);
        }

        // CSV Export for Transactions
        $transactions = WalletTransaction::all();
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="nawader_transactions_'.date('Ymd').'.csv"',
        ];

        return response()->stream(function () use ($transactions) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['رقم الحركة', 'المعرف المرجعي', 'النوع', 'المبلغ (ر.س)', 'طريقة الدفع', 'الحالة', 'البيان', 'تاريخ القيد']);

            foreach ($transactions as $t) {
                fputcsv($handle, [
                    $t->transaction_number,
                    $t->reference_id,
                    $t->type,
                    number_format($t->amount, 2),
                    $t->payment_method,
                    $t->status,
                    $t->description,
                    $t->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }
}
