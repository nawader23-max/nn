<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $operations = ServiceRequest::where('user_id', $request->user()->id);

        return view('pages.dashboard.requests', [
            'requests' => $operations->latest('submitted_at')->latest()->get(),
            'summary' => [
                'total' => (clone $operations)->count(),
                'active' => (clone $operations)->whereNotIn('status', ['completed', 'cancelled'])->count(),
                'completed' => (clone $operations)->where('status', 'completed')->count(),
                'waiting' => (clone $operations)->where('status', 'waiting_documents')->count(),
            ],
        ]);
    }

    public function create()
    {
        $services = ServicesController::getCatalog();

        return view('pages.dashboard.request-create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => ['required', 'string', 'max:80'],
            'service_name' => ['required', 'string', 'max:255'],
            'entity_name' => ['required', 'string', 'max:255'],
            'target_market' => ['nullable', 'string', 'max:80'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'speed' => ['required', 'in:standard,priority,express'],
            'documents' => ['nullable', 'array', 'max:8'],
            'documents.*' => ['file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:10240'],
        ]);

        $operation = ServiceRequest::create([
            ...collect($data)->except('documents')->all(),
            'user_id' => $request->user()->id,
            'request_number' => $this->nextRequestNumber(),
            'status' => 'submitted',
            'progress' => 10,
            'submitted_at' => now(),
            'documents' => [],
        ]);

        $documents = collect($request->file('documents', []))->map(function ($file) use ($operation) {
            return [
                'name' => $file->getClientOriginalName(),
                'path' => $file->store("request-documents/{$operation->id}"),
                'uploaded_at' => now()->toIso8601String(),
            ];
        })->all();
        $operation->update(['documents' => $documents]);

        UserNotification::create([
            'user_id' => $request->user()->id,
            'type' => 'success',
            'title' => 'تم استلام طلبك',
            'body' => "تم إنشاء الطلب {$operation->request_number} وسيظهر مساره هنا عند بدء المراجعة.",
            'action_url' => route('dashboard.requests.show', $operation->request_number),
        ]);

        return redirect()->route('dashboard.requests.show', $operation->request_number)->with('success', 'تم استلام طلبك بنجاح.');
    }

    public function show(Request $request, string $id)
    {
        $operation = $this->operationFor($request, $id);

        return view('pages.dashboard.request-show', ['id' => $operation->request_number, 'operation' => $operation]);
    }

    public function track(Request $request, string $id)
    {
        $operation = $this->operationFor($request, $id);

        return view('pages.dashboard.request-track', ['id' => $operation->request_number, 'operation' => $operation]);
    }

    public function uploadDoc(Request $request, string $id)
    {
        $operation = $this->operationFor($request, $id);
        $request->validate(['document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:10240']]);
        $file = $request->file('document');
        $documents = $operation->documents ?? [];
        $documents[] = [
            'name' => $file->getClientOriginalName(),
            'path' => $file->store("request-documents/{$operation->id}"),
            'uploaded_at' => now()->toIso8601String(),
        ];
        $operation->update(['documents' => $documents]);

        return response()->json(['success' => true, 'file' => $file->getClientOriginalName()]);
    }

    private function operationFor(Request $request, string $requestNumber): ServiceRequest
    {
        return ServiceRequest::where('user_id', $request->user()->id)->where('request_number', $requestNumber)->firstOrFail();
    }

    private function nextRequestNumber(): string
    {
        do {
            $number = 'NW-RQ-'.now()->format('Ymd').'-'.strtoupper(Str::random(5));
        } while (ServiceRequest::where('request_number', $number)->exists());

        return $number;
    }
}
