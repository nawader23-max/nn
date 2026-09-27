<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRequest extends Model
{
    protected $fillable = [
        'request_number', 'user_id', 'category', 'service_name', 'entity_name',
        'target_market', 'notes', 'speed', 'status', 'progress', 'documents', 'submitted_at',
    ];

    protected $casts = [
        'documents' => 'array',
        'submitted_at' => 'datetime',
        'progress' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'submitted' => 'تم الاستلام',
            'in_review' => 'قيد المراجعة',
            'waiting_documents' => 'بانتظار مستندات',
            'processing' => 'قيد التنفيذ',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            default => 'قيد المتابعة',
        };
    }
}
