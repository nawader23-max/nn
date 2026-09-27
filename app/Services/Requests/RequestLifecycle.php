<?php

namespace App\Services\Requests;

use App\Models\RequestEvent;
use App\Models\ServiceRequest;
use App\Services\Notifications\SovereignNotifier;

/**
 * Single funnel for every service-request status transition:
 * authoritative progress + immutable event trail + client notification.
 */
final class RequestLifecycle
{
    public const PROGRESS = [
        'submitted' => 10,
        'escrow_locked' => 25,
        'contract_signed' => 40,
        'in_review' => 30,
        'waiting_documents' => 20,
        'in_progress' => 55,
        'processing' => 55,
        'completed' => 100,
        'cancelled' => 0,
    ];

    public function __construct(private readonly SovereignNotifier $notifier) {}

    public function transition(
        ServiceRequest $request,
        string $status,
        ?string $note = null,
        string $actor = 'system',
        ?string $notifyTitle = null,
    ): RequestEvent {
        $request->forceFill([
            'status' => $status,
            'progress' => self::PROGRESS[$status] ?? $request->progress,
        ])->save();

        $event = RequestEvent::create([
            'service_request_id' => $request->id,
            'status' => $status,
            'note' => $note ? mb_substr($note, 0, 480) : null,
            'actor' => $actor,
        ]);

        $this->notifier->notify(
            $request->user,
            $notifyTitle ?? 'تحديث جديد على طلبك',
            "طلبك {$request->request_number} — {$request->service_name}\n{$note}",
            url("/dashboard/requests/{$request->request_number}"),
        );

        return $event;
    }
}
