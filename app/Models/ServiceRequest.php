<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRequest extends Model
{
    protected $fillable = [
        'request_number', 'user_id', 'category', 'service_name', 'entity_name',
        'target_market', 'notes', 'speed', 'status', 'progress', 'documents', 'submitted_at',
        'price_base', 'price_speed_fee', 'price_vat', 'price_total',
        'escrow_reference', 'contract_id',
        'invoice_number', 'invoice_hash', 'invoice_issued_at',
    ];

    protected $casts = [
        'documents' => 'array',
        'submitted_at' => 'datetime',
        'invoice_issued_at' => 'datetime',
        'progress' => 'integer',
        'price_base' => 'decimal:2',
        'price_speed_fee' => 'decimal:2',
        'price_vat' => 'decimal:2',
        'price_total' => 'decimal:2',
    ];

    public function contract()
    {
        return $this->belongsTo(DigitalContract::class, 'contract_id');
    }

    public function events()
    {
        return $this->hasMany(RequestEvent::class)->latest('id');
    }


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
