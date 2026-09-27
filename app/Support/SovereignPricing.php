<?php

namespace App\Support;

use App\Http\Controllers\ServicesController;

/**
 * Single authoritative pricing engine (server-side).
 * Base fees derive from the live service catalog; speed fees mirror the wizard UI.
 */
final class SovereignPricing
{
    public const VAT_RATE = 0.15;

    /** @var array<string, array{label: string, fee: float, sla: string}> */
    public const SPEEDS = [
        'standard' => ['label' => 'المسار القياسي', 'fee' => 0.0, 'sla' => '5 - 10 أيام عمل'],
        'express' => ['label' => 'المسار السريع VIP', 'fee' => 1200.0, 'sla' => '3 - 5 أيام عمل'],
        'sovereign' => ['label' => 'المسار السيادي الفوري', 'fee' => 2800.0, 'sla' => '24 - 48 ساعة'],
    ];

    private const FALLBACK_BASE = 3500.0;

    /** @return array<string, float> category slug => base fee (first catalog service price) */
    public static function baseFees(): array
    {
        static $cache = null;
        if ($cache !== null) {
            return $cache;
        }

        $fees = [];
        try {
            /** @var array<string, array{subcategories?: array<int, array{services?: array<int, array{name: string, price: string|int|float}>}>}> $catalog */
            $catalog = ServicesController::getCatalog();
            foreach ($catalog as $slug => $category) {
                foreach ($category['subcategories'] ?? [] as $subcategory) {
                    $firstPrice = $subcategory['services'][0]['price'] ?? null;
                    if ($firstPrice !== null) {
                        $numeric = (float) preg_replace('/[^\d.]/', '', (string) $firstPrice);
                        if ($numeric > 0) {
                            $fees[$slug] = round($numeric, 2);
                            break;
                        }
                    }
                }
            }
        } catch (\Throwable) {
            $fees = [];
        }

        return $cache = $fees;
    }

    public static function baseFee(string $category): float
    {
        return self::baseFees()[$category] ?? self::FALLBACK_BASE;
    }

    /** @return array{base: float, speed_fee: float, speed_label: string, sla: string, vat: float, total: float} */
    public static function quote(string $category, string $speed): array
    {
        $speedDef = self::SPEEDS[$speed] ?? self::SPEEDS['standard'];
        $base = self::baseFee($category);
        $speedFee = $speedDef['fee'];
        $vat = round(($base + $speedFee) * self::VAT_RATE, 2);

        return [
            'base' => $base,
            'speed_fee' => $speedFee,
            'speed_label' => $speedDef['label'],
            'sla' => $speedDef['sla'],
            'vat' => $vat,
            'total' => round($base + $speedFee + $vat, 2),
        ];
    }

    /** Map consumed by the wizard JS so client and server never diverge. */
    public static function jsMap(): array
    {
        $speeds = [];
        foreach (self::SPEEDS as $key => $def) {
            $speeds[$key] = $def['fee'];
        }

        return ['base' => self::baseFees(), 'speed' => $speeds, 'fallback' => self::FALLBACK_BASE];
    }
}
