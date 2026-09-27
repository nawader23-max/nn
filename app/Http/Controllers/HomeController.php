<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            ['value' => 15000, 'label' => 'طلب مُنجز', 'suffix' => '+'],
            ['value' => 98,    'label' => 'رضا العملاء', 'suffix' => '%'],
            ['value' => 20,    'label' => 'قطاع خدمي',  'suffix' => ''],
            ['value' => 500,   'label' => 'شريك حكومي', 'suffix' => '+'],
        ];

        $featuredServices = $this->getFeaturedServices();
        $testimonials = $this->getTestimonials();
        $partners = $this->getPartners();
        $categories = ServicesController::getCatalog();

        return view('pages.home', compact('stats', 'featuredServices', 'testimonials', 'partners', 'categories'));
    }

    private function getFeaturedServices(): array
    {
        return [
            [
                'slug' => 'company-formation',
                'category' => 'legal',
                'icon' => '🏛️',
                'color' => 'gold',
                'title' => 'تأسيس الشركات',
                'subtitle' => 'كيانات قانونية معتمدة',
                'description' => 'تأسيس شركات ذات مسؤولية محدودة، مساهمة، فردية وأجنبية في السعودية والولايات المتحدة بأسرع وأيسر طريقة.',
                'duration' => '7–14 يوم',
                'price_from' => 2500,
                'popular' => true,
            ],
            [
                'slug' => 'commercial-licenses',
                'category' => 'licenses',
                'icon' => '📋',
                'color' => 'teal',
                'title' => 'التراخيص التجارية',
                'subtitle' => 'كل الأنشطة والقطاعات',
                'description' => 'استخراج ومجددة التراخيص التجارية لجميع الأنشطة الاقتصادية مع ضمان التوافق التنظيمي الكامل.',
                'duration' => '3–7 أيام',
                'price_from' => 1500,
                'popular' => false,
            ],
            [
                'slug' => 'foreign-investment',
                'category' => 'investment',
                'icon' => '🌐',
                'color' => 'purple',
                'title' => 'الاستثمار الأجنبي',
                'subtitle' => 'جذب رأس المال العالمي',
                'description' => 'استقطاب وتسهيل الاستثمار الأجنبي المباشر بموجب نظام MISA في المملكة وقواعد SEC الأمريكية.',
                'duration' => '14–30 يوم',
                'price_from' => 5000,
                'popular' => true,
            ],
            [
                'slug' => 'intellectual-property',
                'category' => 'ip',
                'icon' => '⚡',
                'color' => 'teal',
                'title' => 'الملكية الفكرية',
                'subtitle' => 'حماية الابتكار',
                'description' => 'تسجيل العلامات التجارية وبراءات الاختراع وحقوق التأليف والنشر في أكثر من 50 دولة.',
                'duration' => '30–90 يوم',
                'price_from' => 1200,
                'popular' => false,
            ],
            [
                'slug' => 'residency-visas',
                'category' => 'expat',
                'icon' => '🌍',
                'color' => 'gold',
                'title' => 'الإقامة والتأشيرات',
                'subtitle' => 'للمغتربين والمستثمرين',
                'description' => 'استخراج الإقامات المميزة وتأشيرات العمل والزيارة وإقامة رجال الأعمال.',
                'duration' => '7–21 يوم',
                'price_from' => 800,
                'popular' => false,
            ],
            [
                'slug' => 'compliance',
                'category' => 'regulatory',
                'icon' => '🛡️',
                'color' => 'teal',
                'title' => 'الامتثال التنظيمي',
                'subtitle' => 'صفر مخالفات',
                'description' => 'ضمان التوافق الكامل مع اللوائح الهيئة العامة للاستثمار وأنظمة الجهات التنظيمية السعودية والأمريكية.',
                'duration' => 'مستمر',
                'price_from' => 3500,
                'popular' => false,
            ],
        ];
    }

    private function getTestimonials(): array
    {
        return [
            [
                'name' => 'م. خالد العمري',
                'title' => 'الرئيس التنفيذي، مجموعة التقنية السعودية',
                'avatar' => null,
                'rating' => 5,
                'text' => 'أسسنا شركتنا في الولايات المتحدة عبر نوادر خلال 10 أيام فقط. الشفافية والسرعة لم أجدهما في أي منصة أخرى.',
                'service' => 'تأسيس الشركات',
            ],
            [
                'name' => 'سارة Al-Rashid',
                'title' => 'مديرة التوسع الدولي، Halal Ventures',
                'avatar' => null,
                'rating' => 5,
                'text' => 'نوادر حولت عملية الاستثمار الأجنبي من كابوس بيروقراطي إلى تجربة سلسة. التحديثات اللحظية أزالت كل قلق.',
                'service' => 'الاستثمار الأجنبي',
            ],
            [
                'name' => 'Robert Chen',
                'title' => 'SVP Operations, Global Corp.',
                'avatar' => null,
                'rating' => 5,
                'text' => 'We registered our Saudi subsidiary through Nawader in record time. Their compliance expertise is unmatched.',
                'service' => 'Corporate Formation',
            ],
        ];
    }

    private function getPartners(): array
    {
        return [
            ['name' => 'وزارة التجارة',         'country' => 'SA'],
            ['name' => 'MISA',                    'country' => 'SA'],
            ['name' => 'هيئة السوق المالية',     'country' => 'SA'],
            ['name' => 'وزارة الاستثمار',        'country' => 'SA'],
            ['name' => 'SEC',                     'country' => 'US'],
            ['name' => 'U.S. Chamber',            'country' => 'US'],
            ['name' => 'USPTO',                   'country' => 'US'],
            ['name' => 'بنك التنمية السعودي',    'country' => 'SA'],
        ];
    }
}
