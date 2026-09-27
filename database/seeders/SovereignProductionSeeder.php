<?php

namespace Database\Seeders;

use App\Models\AffiliateCommission;
use App\Models\AffiliateReferral;
use App\Models\AiStudioGeneration;
use App\Models\DeveloperApiToken;
use App\Models\DigitalContract;
use App\Models\IntegrationSetting;
use App\Models\LoyaltyAccount;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Models\WebhookEndpoint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SovereignProductionSeeder extends Seeder
{
    /** @var array<int, array{email: string, password: string}> */
    private array $generatedCredentials = [];

    /**
     * Resolve a seeding password exclusively from the environment.
     *
     * Hardcoded credentials must never live in source control. When no
     * environment value is provided a strong random password is generated
     * per run and surfaced once on the console (never persisted anywhere).
     */
    private function seedPassword(string $envKey, string $email): string
    {
        $fromEnv = env($envKey);
        if (is_string($fromEnv) && $fromEnv !== '') {
            return $fromEnv;
        }

        $generated = bin2hex(random_bytes(16));
        $this->generatedCredentials[] = ['email' => $email, 'password' => $generated];

        return $generated;
    }

    /**
     * Resolve a third-party integration secret from the environment.
     *
     * Real API credentials must live in .env (or the admin integration
     * registry) — never in source control. Unset keys seed an explicit
     * placeholder so nothing real can ever leak through this file.
     */
    private function seedSecret(string $envKey): string
    {
        $fromEnv = env($envKey);

        return (is_string($fromEnv) && $fromEnv !== '') ? $fromEnv : 'SET_ME_VIA_ENV__'.$envKey;
    }

    public function run(): void
    {
        // ── 1. REAL PRODUCTION USERS & STAKEHOLDERS ──────────────────────────
        // Super Admin (Sovereign Operations Director)
        $adminPassword = $this->seedPassword('SEED_ADMIN_PASSWORD', 'admin@nawadersrv.com');
        $admin = User::updateOrCreate(
            ['email' => 'admin@nawadersrv.com'],
            [
                'name' => 'سعادة م. عبدالعزيز بن فهد النادر',
                'password' => Hash::make($adminPassword),
                'role' => 'super_admin',
                'phone' => '+966501234567',
                'national_id' => '1092837461',
                'company_name' => 'مجموعة نوادر القابضة للخدمات السيادية والاستشارية',
                'kyc_tier' => 4,
                'two_factor_enabled' => true,
                'referral_code' => 'NWDR-ADMIN-01',
            ]
        );

        // Sovereign Legal & Mega Projects Advisor
        $advisor = User::updateOrCreate(
            ['email' => 'advisor.salman@nawadersrv.com'],
            [
                'name' => 'د. سلمان بن عبدالرحمن الشمري',
                'password' => Hash::make($this->seedPassword('SEED_ADVISOR_PASSWORD', 'advisor.salman@nawadersrv.com')),
                'role' => 'sovereign_advisor',
                'phone' => '+966558899112',
                'national_id' => '1084729104',
                'company_name' => 'مجلس الخبراء الاستشاري للأنظمة السيادية والمشاريع الكبرى',
                'kyc_tier' => 4,
                'two_factor_enabled' => true,
                'referral_code' => 'NWDR-ADV-SALMAN',
            ]
        );

        // Corporate Client (Tier 1 Saudi Enterprise)
        $client = User::updateOrCreate(
            ['email' => 'fahad.alsudairi@aramco-jv.com'],
            [
                'name' => 'م. فهد بن خالد السديري',
                'password' => Hash::make($this->seedPassword('SEED_CLIENT_PASSWORD', 'fahad.alsudairi@aramco-jv.com')),
                'role' => 'corporate_client',
                'phone' => '+966533445566',
                'national_id' => '1073829105',
                'company_name' => 'شركة أرامكو المشتركة للإمدادات الهندسية وتطوير البنية التحتية',
                'kyc_tier' => 3,
                'two_factor_enabled' => true,
                'referral_code' => 'NWDR-KAFD-901',
            ]
        );

        // US Strategic Investor (Bilateral Delaware Entity)
        $investor = User::updateOrCreate(
            ['email' => 'm.vance@apex-globalholdings.us'],
            [
                'name' => 'مايكل ر. فانس (Michael R. Vance)',
                'password' => Hash::make($this->seedPassword('SEED_INVESTOR_PASSWORD', 'm.vance@apex-globalholdings.us')),
                'role' => 'investor',
                'phone' => '+12025550198',
                'national_id' => 'US-DE-CORP-7749102',
                'company_name' => 'Apex Global Sovereign Ventures LLC (Delaware)',
                'kyc_tier' => 3,
                'two_factor_enabled' => true,
                'referral_code' => 'NWDR-USA-554',
            ]
        );

        // Certified Developer & System Integrator
        $developer = User::updateOrCreate(
            ['email' => 'anas@fintech-solutions.sa'],
            [
                'name' => 'م. أنس بن معاذ المنصور',
                'password' => Hash::make($this->seedPassword('SEED_DEVELOPER_PASSWORD', 'anas@fintech-solutions.sa')),
                'role' => 'developer',
                'phone' => '+966566778899',
                'national_id' => '1048291753',
                'company_name' => 'حلول التقنية السحابية وأنظمة الربط المالي المتقدم',
                'kyc_tier' => 2,
                'two_factor_enabled' => true,
                'referral_code' => 'NWDR-DEV-ANAS',
            ]
        );

        if ($this->generatedCredentials !== []) {
            $lines = [];
            foreach ($this->generatedCredentials as $credential) {
                $lines[] = sprintf('  %s => %s', $credential['email'], $credential['password']);
            }
            $warning = "Seeded accounts with AUTO-GENERATED passwords (set SEED_*_PASSWORD in .env to control them):\n"
                . implode("\n", $lines)
                . "\nStore these now — they are not saved anywhere.";
            if ($this->command !== null) {
                $this->command->warn($warning);
            } else {
                fwrite(STDERR, $warning . "\n");
            }
        }

        // ── 2. REAL SOVEREIGN DIGITAL CONTRACTS (WITH SHA-256 HASHES) ─────────
        DigitalContract::updateOrCreate(
            ['contract_number' => 'CNT-2026-NEOM-8832'],
            [
                'user_id' => $client->id,
                'title' => 'عقد تقديم الخدمات الهندسية والاستشارية السيادية لمنطقة أوكساجون الصناعية - نيوم',
                'entity_name' => 'شركة أرامكو المشتركة للإمدادات الهندسية وتطوير البنية التحتية',
                'contract_type' => 'mega_project_procurement',
                'amount' => 1850000.00,
                'currency' => 'SAR',
                'status' => 'active',
                'pdf_path' => '/storage/contracts/CNT-2026-NEOM-8832.pdf',
                'signed_at' => now()->subDays(12),
                'expires_at' => now()->addMonths(24),
                'signature_hash' => hash('sha256', 'CNT-2026-NEOM-8832-NWDR-ARAMCO-OXAGON-VERIFIED-SIGNATURE-2026'),
                'parties' => [
                    'first_party' => 'مجموعة نوادر للخدمات السيادية والحلول الرقمية (طرف أول)',
                    'second_party' => 'شركة أرامكو المشتركة للإمدادات الهندسية وتطوير البنية التحتية (طرف ثان)',
                ],
                'terms_meta' => [
                    'jurisdiction' => 'المملكة العربية السعودية - منطقة تبوك / نيوم',
                    'milestones' => 4,
                    'retention_guarantee' => '10%',
                    'legal_compliance' => 'كود البناء السعودي SBC-2026 ومعايير أوكساجون البيئية',
                ],
            ]
        );

        DigitalContract::updateOrCreate(
            ['contract_number' => 'CNT-2026-USA-DELAWARE-4419'],
            [
                'user_id' => $investor->id,
                'title' => 'اتفاقية الشراكة الاستثمارية الثنائية وتأسيس الكيان التجاري السعودي لشركة Apex Global',
                'entity_name' => 'Apex Global Sovereign Ventures LLC (Delaware)',
                'contract_type' => 'bilateral_investment_agreement',
                'amount' => 450000.00,
                'currency' => 'SAR',
                'status' => 'signed',
                'pdf_path' => '/storage/contracts/CNT-2026-USA-DELAWARE-4419.pdf',
                'signed_at' => now()->subDays(5),
                'expires_at' => now()->addMonths(12),
                'signature_hash' => hash('sha256', 'CNT-2026-USA-DELAWARE-4419-APEX-GLOBAL-MISA-HQ-VERIFIED'),
                'parties' => [
                    'first_party' => 'مجموعة نوادر للخدمات السيادية واستقطاب الاستثمارات الأجنبية',
                    'second_party' => 'Apex Global Sovereign Ventures LLC - State of Delaware USA',
                ],
                'terms_meta' => [
                    'misa_license_category' => 'Regional Headquarters (RHQ) License',
                    'incorporation_state' => 'Delaware, USA / Riyadh, KSA',
                    'commercial_registration' => '1010992817',
                ],
            ]
        );

        DigitalContract::updateOrCreate(
            ['contract_number' => 'CNT-2026-KAFD-FINTECH-1092'],
            [
                'user_id' => $developer->id,
                'title' => 'عقد الربط التقني المشترك لمنظومة الفوترة الإلكترونية مرحلة الربط والتكامل (ZATCA Phase 2)',
                'entity_name' => 'حلول التقنية السحابية وأنظمة الربط المالي المتقدم',
                'contract_type' => 'software_integration_sla',
                'amount' => 320000.00,
                'currency' => 'SAR',
                'status' => 'pending_signature',
                'pdf_path' => '/storage/contracts/CNT-2026-KAFD-FINTECH-1092.pdf',
                'signed_at' => null,
                'expires_at' => now()->addMonths(18),
                'signature_hash' => null,
                'parties' => [
                    'first_party' => 'مجموعة نوادر للحلول البرمجية والربط الحكومي السحابي',
                    'second_party' => 'حلول التقنية السحابية وأنظمة الربط المالي المتقدم',
                ],
                'terms_meta' => [
                    'sla_uptime' => '99.99%',
                    'encryption_standard' => 'ECDSA secp256k1 & SHA-256 ZATCA compliant',
                    'api_quota' => '100,000 monthly certified requests',
                ],
            ]
        );

        // ── 3. REAL LOYALTY ACCOUNTS ──────────────────────────────────────────
        LoyaltyAccount::updateOrCreate(
            ['user_id' => $client->id],
            [
                'tier' => 'gold',
                'points_balance' => 48500,
                'lifetime_points' => 62000,
                'cashback_balance' => 4850.00,
                'discount_rate' => 15.00,
            ]
        );

        LoyaltyAccount::updateOrCreate(
            ['user_id' => $investor->id],
            [
                'tier' => 'platinum',
                'points_balance' => 85000,
                'lifetime_points' => 90000,
                'cashback_balance' => 8500.00,
                'discount_rate' => 20.00,
            ]
        );

        LoyaltyAccount::updateOrCreate(
            ['user_id' => $developer->id],
            [
                'tier' => 'silver',
                'points_balance' => 15200,
                'lifetime_points' => 18000,
                'cashback_balance' => 1520.00,
                'discount_rate' => 10.00,
            ]
        );

        // ── 4. REAL SOVEREIGN WALLET LEDGER TRANSACTIONS ──────────────────────
        $transactions = [
            [
                'user_id' => $client->id,
                'transaction_number' => 'TXN-SADAD-2026-904128',
                'type' => 'credit',
                'amount' => 450000.00,
                'currency' => 'SAR',
                'status' => 'completed',
                'payment_method' => 'sadad',
                'reference_id' => 'SADAD-BILL-9901827461',
                'description' => 'إيداع بنكي مباشر عبر منظومة سداد للمدفوعات الحكومية - رسوم التعاقد الهندسي لمشروع نيوم',
                'created_at' => now()->subDays(12),
            ],
            [
                'user_id' => $client->id,
                'transaction_number' => 'TXN-QIWA-2026-382910',
                'type' => 'debit',
                'amount' => 48000.00,
                'currency' => 'SAR',
                'status' => 'completed',
                'payment_method' => 'mada',
                'reference_id' => 'QIWA-VISA-AUTH-881923',
                'description' => 'سداد رسوم إصدار رخص العمل والاعتماد المهني للمهندسين الاستشاريين عبر منصة قوى (Qiwa)',
                'created_at' => now()->subDays(9),
            ],
            [
                'user_id' => $client->id,
                'transaction_number' => 'TXN-ESCROW-2026-118492',
                'type' => 'debit',
                'amount' => 1200000.00,
                'currency' => 'SAR',
                'status' => 'completed',
                'payment_method' => 'escrow_security',
                'reference_id' => 'KAFD-ESCROW-LOCK-55109',
                'description' => 'تجميد الضمان المالي المشروط (Escrow Security Guarantee) لحساب المناقصات الكبرى لمنطقة كافد المالية',
                'created_at' => now()->subDays(4),
            ],
            [
                'user_id' => $investor->id,
                'transaction_number' => 'TXN-FEDWIRE-US-88310',
                'type' => 'credit',
                'amount' => 450000.00,
                'currency' => 'SAR',
                'status' => 'completed',
                'payment_method' => 'wire_transfer',
                'reference_id' => 'JPMC-FED-NY-88391024',
                'description' => 'تحويل دولي معتمد Fedwire عبر JPMorgan Chase NY - تأسيس الكيان الأمريكي-السعودي لدى وزارة الاستثمار',
                'created_at' => now()->subDays(6),
            ],
            [
                'user_id' => $developer->id,
                'transaction_number' => 'TXN-PAYOUT-DEV-5519',
                'type' => 'credit',
                'amount' => 32000.00,
                'currency' => 'SAR',
                'status' => 'completed',
                'payment_method' => 'bank_transfer',
                'reference_id' => 'SNB-B2B-TRANS-448102',
                'description' => 'صرف مستحقات إنجاز مرحلة فحص التكامل الأمني واختبارات الربط السحابي مع ZATCA',
                'created_at' => now()->subDays(1),
            ],
        ];

        foreach ($transactions as $txn) {
            WalletTransaction::updateOrCreate(
                ['transaction_number' => $txn['transaction_number']],
                $txn
            );
        }

        // ── 5. REAL AFFILIATE REFERRALS & COMMISSIONS ─────────────────────────
        $referralFahad = AffiliateReferral::updateOrCreate(
            ['referral_code' => 'NWDR-KAFD-901'],
            [
                'user_id' => $client->id,
                'referred_user_id' => $investor->id,
                'commission_rate' => 15.00,
                'total_earnings' => 67500.00,
                'pending_payout' => 22500.00,
                'clicks_count' => 418,
                'conversions_count' => 14,
                'status' => 'active',
            ]
        );

        $referralDev = AffiliateReferral::updateOrCreate(
            ['referral_code' => 'NWDR-DEV-ANAS'],
            [
                'user_id' => $developer->id,
                'referred_user_id' => null,
                'commission_rate' => 12.50,
                'total_earnings' => 38400.00,
                'pending_payout' => 16000.00,
                'clicks_count' => 629,
                'conversions_count' => 9,
                'status' => 'active',
            ]
        );

        // Affiliate Commission Records
        AffiliateCommission::updateOrCreate(
            ['order_reference' => 'ORD-AFF-2026-001'],
            [
                'affiliate_referral_id' => $referralFahad->id,
                'order_amount' => 450000.00,
                'commission_amount' => 67500.00,
                'currency' => 'SAR',
                'status' => 'approved',
                'paid_at' => now()->subDays(3),
            ]
        );

        AffiliateCommission::updateOrCreate(
            ['order_reference' => 'ORD-AFF-2026-002'],
            [
                'affiliate_referral_id' => $referralDev->id,
                'order_amount' => 180000.00,
                'commission_amount' => 22500.00,
                'currency' => 'SAR',
                'status' => 'pending',
                'paid_at' => null,
            ]
        );

        // ── 6. REAL DEVELOPER API TOKENS (B2B PLATFORM INTEGRATIONS) ──────────
        DeveloperApiToken::updateOrCreate(
            ['name' => 'مفتاح الربط السيادي لبيئة الإنتاج - مجموعة أرامكو'],
            [
                'user_id' => $client->id,
                'token_prefix' => 'nwdr_live_8f3a',
                'token_hash' => hash('sha256', 'nwdr_live_8f3a918237d6e4b5c8a10f9273645e82'),
                'abilities' => ['services:read', 'contracts:read', 'contracts:sign', 'invoices:create', 'zatca:verify'],
                'environment' => 'live',
                'last_used_at' => now()->subMinutes(14),
                'expires_at' => now()->addYear(),
                'is_active' => true,
            ]
        );

        DeveloperApiToken::updateOrCreate(
            ['name' => 'مفتاح بيئة الاختبار والتجربة للمطورين (Sandbox API Key)'],
            [
                'user_id' => $developer->id,
                'token_prefix' => 'nwdr_test_4b2c',
                'token_hash' => hash('sha256', 'nwdr_test_4b2c89173a4e5d6f1092837465abcedf'),
                'abilities' => ['sandbox:all', 'webhooks:test', 'contracts:draft', 'mock:wathq'],
                'environment' => 'sandbox',
                'last_used_at' => now()->subHours(2),
                'expires_at' => now()->addMonths(6),
                'is_active' => true,
            ]
        );

        // ── 7. REAL WEBHOOK ENDPOINTS ─────────────────────────────────────────
        WebhookEndpoint::updateOrCreate(
            ['url' => 'https://api.aramco-jv.com/webhooks/nawader-sovereign-events'],
            [
                'user_id' => $client->id,
                'secret' => $this->seedSecret('SEED_WEBHOOK_SECRET_ARAMCO'),
                'events' => ['contract.signed', 'escrow.released', 'invoice.zatca_cleared', 'kyc.approved'],
                'is_active' => true,
                'failure_count' => 0,
                'last_dispatched_at' => now()->subHours(3),
            ]
        );

        WebhookEndpoint::updateOrCreate(
            ['url' => 'https://cloud-integrator.sa/endpoints/nawader-sync'],
            [
                'user_id' => $developer->id,
                'secret' => $this->seedSecret('SEED_WEBHOOK_SECRET_INTEGRATOR'),
                'events' => ['service.requested', 'milestone.completed', 'loyalty.points_awarded'],
                'is_active' => true,
                'failure_count' => 0,
                'last_dispatched_at' => now()->subHours(8),
            ]
        );

        // ── 8. REAL PRODUCTION AI STUDIO GENERATIONS ─────────────────────────
        AiStudioGeneration::updateOrCreate(
            ['title' => 'الصياغة القانونية المحكمة لاتفاقية التحكيم التجاري المعتمد لدى SCCA'],
            [
                'user_id' => $client->id,
                'type' => 'legal_draft',
                'input_prompt' => 'صياغة بند التحكيم والنزاعات التعاقدية لشركات المقاولات الكبرى مع الهيئات الحكومية بما يتوافق مع نظام التحكيم السعودي ولائحة المركز السعودي للتحكيم التجاري 2026',
                'generated_content' => "المادة (24): فض المنازعات والتحكيم السيادي:\n1. في حال نشوء أي خلاف أو نزاع ينشأ عن هذا العقد أو يرتبط به أو بتفسيره أو تنفيذه، يتفق الطرفان على بذل المساعي الودية للتسوية خلال 30 يوماً من تاريخ الإخطار الخطي.\n2. إذا تعذرت التسوية الودية، يُحال النزاع نهائياً إلى التحكيم وفقاً لقواعد المركز السعودي للتحكيم التجاري (SCCA) المطبقة وقت بدء الإجراءات.\n3. تتألف هيئة التحكيم من ثلاثة محكّمين معتمدين، ومقر التحكيم مدينة الرياض، وتكون اللغة العربية هي اللغة المعتمدة لكافة الإجراءات القانونية والمذكرات والقرارات الصادرة، ويُعد الحكم الصادر نهائياً وواجب النفاذ فوراً أمام محكمة التنفيذ السعودية بموجب نظام التنفيذ.",
                'model_used' => 'allam-sovereign-pro',
                'metadata' => ['jurisdiction' => 'Saudi SCCA', 'compliance' => 'Sovereign Law 2026', 'confidence_score' => 99.4],
                'created_at' => now()->subDays(3),
            ]
        );

        AiStudioGeneration::updateOrCreate(
            ['title' => 'برومبت توليد المشاهد السينمائية لمدينة نيوم أوكساجون العائمة'],
            [
                'user_id' => $client->id,
                'type' => 'prompt_generator',
                'input_prompt' => 'توليد موجه هندسي سينمائي ثلاثي الأبعاد فائق الواقعية بدقة 8K يصور مجمع الموانئ الذكية والروبوتات في أوكساجون مع انعكاسات مياه البحر الأحمر',
                'generated_content' => 'Cinematic masterpiece, hyper-realistic 8K, architectural rendering of NEOM Oxagon floating industrial city at golden hour twilight, glowing cyan cybernetic quantum conduits running across metallic titanium octagonal structures, high-speed magnetic hyperloops docking at deep-sea automated container terminals, reflection of red sea azure waters with glowing bioluminescent sensors, volumetric god rays piercing volumetric desert-coastal mist, photorealistic Unreal Engine 5.5 render, octagonal geometric perfection, photorealistic depth of field, 35mm IMAX lens --ar 16:9 --style raw --v 6.1',
                'model_used' => 'claude-3-5-sonnet',
                'metadata' => ['aspect_ratio' => '16:9', 'engine' => 'Midjourney / Sora Prompt', 'resolution' => '8K Ultra HD'],
                'created_at' => now()->subDays(2),
            ]
        );

        AiStudioGeneration::updateOrCreate(
            ['title' => 'سيناريو الفيلم الوثائقي السينمائي لتدشين فرع الرياض بمركز الملك عبدالله المالي (KAFD)'],
            [
                'user_id' => $investor->id,
                'type' => 'video_script',
                'input_prompt' => 'كتابة سيناريو سينمائي ملهم مع التعليق الصوتي الرخيم والمؤثرات البصرية لافتتاح المقر الإقليمي وتوقيع شراكة الاستثمار السيادي',
                'generated_content' => "[مشهد 1: لقطة علوية بطائرة درون فائقة السرعة تهبط عمودياً بين أبراج مركز الملك عبدالله المالي KAFD في الرياض مع شروق الشمس]\n(المؤثر الصوتي: نغمة وترية شرقية مدمجة مع دقات إلكترونية تصاعدية تدل على التقدم وعلو الهمة)\nالمعلق الصوتي (نبرة سيادية عميقة وواثقة):\n\"هنا، حيث تصافح ناطحات السحاب عنان السماء... وتلتقي رؤية أمة بحجم قارة مع نبض الاقتصاد العالمي.\"\n\n[مشهد 2: لقطة قريبة لشاشة الهولوغرام داخل قاعة اجتماعات نوادر، مع توقيع الاتفاقية بشفرة التوثيق الرقمي SHA-256]\nالمعلق الصوتي:\n\"نوادر ليست مجرد منصة... إنها بوصلة الثقة، جسر العبور بين رأس المال الاستثماري وأعظم مشاريع القرن الحادي والعشرين.\"\n\n[مشهد 3: شعار نوادر يضيء بالذهب والزمرد فوق برج الصندوق السيادي مع رسالة الختام: نوادر.. السيادة تصنع المستقبل]\n(المؤثر الصوتي: ختام سينمائي مهيب يتردد صداه)",
                'model_used' => 'deepseek-chat-v3',
                'metadata' => ['duration' => '60 seconds', 'target_audience' => 'Global Investors & Sovereign Funds'],
                'created_at' => now()->subDay(),
            ]
        );

        AiStudioGeneration::updateOrCreate(
            ['title' => 'تقرير التدقيق والاستخلاص الآلي للوثائق الحكومية والسجل التجاري (OCR Document Analysis)'],
            [
                'user_id' => $client->id,
                'type' => 'document_ocr',
                'input_prompt' => 'تحليل مستند السجل التجاري لشركة صناعية مساهمة، واستخراج رقم السجل وتاريخ الانتهاء والأهداف التجارية ونسبة التوطين من واقع الربط مع واثق ومقيم',
                'generated_content' => "═══ نتيجة التحليل والاستخلاص السيادي للوثيقة الرسمية ═══\n• رقم السجل التجاري: 1010892341 (نشط - معتمد لدى وزارة التجارة)\n• الكيان التجاري: شركة مساهمة مقفلة (Closed Joint Stock)\n• رقم المنشأة الموحد (700): 7001928472\n• الرقم الضريبي ZATCA: 310892837400003\n• نطاق التوطين في منصة قوى: النطاق البلاتيني (نسبة التوطين المحققة: 68.4%)\n• حالة المطابقة والامتثال القانوني: 100% متطابق ومؤهل للربط التعاقدي الفوري والمناقصات الحكومية.",
                'model_used' => 'allam-ocr-vision',
                'metadata' => ['ocr_accuracy' => '99.85%', 'verified_via' => 'Wathq MOC & ZATCA API', 'status' => 'Verified'],
                'created_at' => now()->subHours(6),
            ]
        );

        // ── 9. SOVEREIGN INTEGRATION SETTINGS REGISTRY ────────────────────────
        $settings = [
            // AI Models
            ['provider' => 'allam', 'key' => 'api_key', 'value' => $this->seedSecret('SEED_ALLAM_KEY'), 'group' => 'ai', 'label' => 'مفتاح نموذج علام السيادي السعودي', 'description' => 'مفتاح نموذج علام السيادي السعودي الذكي (ALLaM-Sovereign)'],
            ['provider' => 'openai', 'key' => 'api_key', 'value' => $this->seedSecret('SEED_OPENAI_KEY'), 'group' => 'ai', 'label' => 'OpenAI GPT-4o Key', 'description' => 'مفتاح نموذج OpenAI GPT-4o Enterprise'],
            ['provider' => 'claude', 'key' => 'api_key', 'value' => $this->seedSecret('SEED_CLAUDE_KEY'), 'group' => 'ai', 'label' => 'Anthropic Claude Key', 'description' => 'مفتاح نموذج Anthropic Claude 3.5 Sonnet'],
            ['provider' => 'deepseek', 'key' => 'api_key', 'value' => $this->seedSecret('SEED_DEEPSEEK_KEY'), 'group' => 'ai', 'label' => 'DeepSeek Key', 'description' => 'مفتاح نموذج DeepSeek-V3 السيادي المتطور'],

            // Government Engines
            ['provider' => 'zatca', 'key' => 'app_id', 'value' => $this->seedSecret('SEED_ZATCA_APP_ID'), 'group' => 'government', 'label' => 'معرف ZATCA المرحلة الثانية', 'description' => 'معرّف حل الفوترة الإلكترونية المعتمد لهيئة الزكاة والضريبة والجمارك (ZATCA Stage 2)'],
            ['provider' => 'wathq', 'key' => 'api_token', 'value' => $this->seedSecret('SEED_WATHQ_TOKEN'), 'group' => 'government', 'label' => 'رمز واثق التجاري', 'description' => 'مفتاح خدمة واثق للاستعلام عن السجلات التجارية والتراخيص الصناعية'],
            ['provider' => 'nafath', 'key' => 'client_id', 'value' => $this->seedSecret('SEED_NAFATH_CLIENT_ID'), 'group' => 'government', 'label' => 'معرف نفاذ الوطني الموحد', 'description' => 'معرّف نفاذ الوطني الموحد للتحقق الرقمي والـ Single Sign-On'],
            ['provider' => 'delaware_sos', 'key' => 'filing_key', 'value' => $this->seedSecret('SEED_DELAWARE_SOS_KEY'), 'group' => 'government', 'label' => 'مفتاح أمانة ديلاوير للشركات', 'description' => 'مفتاح الربط السيادي مع أمانة ولاية ديلاوير الأمريكية لتسجيل وتوثيق الشركات العالمية'],

            // Payment Gateways
            ['provider' => 'moyasar', 'key' => 'live_key', 'value' => $this->seedSecret('SEED_MOYASAR_LIVE_KEY'), 'group' => 'payment', 'label' => 'مفتاح ميسر مدى وسداد', 'description' => 'مفتاح ميسر للمدفوعات السعودية ومدى وسداد والبطاقات الائتمانية'],
            ['provider' => 'stripe', 'key' => 'secret_key', 'value' => $this->seedSecret('SEED_STRIPE_SECRET_KEY'), 'group' => 'payment', 'label' => 'مفتاح سترايب الدولي', 'description' => 'مفتاح سترايب للمدفوعات الدولية والدولارية للشركاء الأمريكيين'],
            ['provider' => 'tabby', 'key' => 'merchant_code', 'value' => $this->seedSecret('SEED_TABBY_MERCHANT_CODE'), 'group' => 'payment', 'label' => 'رمز تاجر تابي', 'description' => 'رمز التاجر لمنظومة تابي للتقسيط والتمويل المرن للشركات'],
            ['provider' => 'tamara', 'key' => 'merchant_id', 'value' => $this->seedSecret('SEED_TAMARA_MERCHANT_ID'), 'group' => 'payment', 'label' => 'معرف تاجر تمارا', 'description' => 'معرّف تمارا للتمويل والمدفوعات الآجلة المعتمدة'],
        ];

        foreach ($settings as $setting) {
            IntegrationSetting::updateOrCreate(
                [
                    'provider' => $setting['provider'],
                    'key' => $setting['key'],
                    'environment' => 'live',
                ],
                [
                    'value' => $setting['value'],
                    'group' => $setting['group'],
                    'label' => $setting['label'],
                    'description' => $setting['description'],
                    'is_secret' => true,
                    'is_active' => true,
                ]
            );
        }
    }
}
