<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $plans = [
            ['name' => 'أساسي', 'price' => 'مجاني', 'period' => '', 'color' => 'teal', 'features' => ['كتالوج الخدمات', 'حاسبة الرسوم', 'دعم إلكتروني'], 'cta' => 'ابدأ مجاناً', 'popular' => false],
            ['name' => 'احترافي', 'price' => '299', 'period' => '/ شهر', 'color' => 'gold', 'features' => ['كل خدمات الأساسي', 'تتبع الطلبات لحظياً', 'رفع مستندات غير محدود', 'دعم أولوية 24/7', 'فاتورة إلكترونية رسمية'], 'cta' => 'اشترك الآن', 'popular' => true],
            ['name' => 'مؤسسي', 'price' => '999', 'period' => '/ شهر', 'color' => 'purple', 'features' => ['كل خدمات الاحترافي', 'مدير حساب مخصص', 'غرفة بيانات المستثمر', 'تقارير امتثال شهرية', 'SLA مضمون 99.9%', 'دعم API'], 'cta' => 'تواصل معنا', 'popular' => false],
        ];

        return view('pages.pricing', compact('plans'));
    }

    public function calculate(Request $r)
    {
        $base = ['company' => 2500, 'license' => 1500, 'property' => 3000, 'investment' => 5000, 'trademark' => 1200, 'visa' => 800, 'consulting' => 800][$r->service] ?? 2000;
        $tm = ['individual' => 1, 'enterprise' => 2.5, 'government' => 1.8][$r->type] ?? 1;
        $um = ['standard' => 1, 'express' => 1.5, 'priority' => 2.2][$r->urgency] ?? 1;
        $total = $base * $tm * $um;
        $vat = $total * 0.15;

        return response()->json(['subtotal' => $total, 'vat' => $vat, 'total' => $total + $vat, 'currency' => 'SAR']);
    }
}
