<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ContentBlockService
{
    protected static ?string $storagePath = null;

    protected static function getStoragePath(): string
    {
        if (! self::$storagePath) {
            self::$storagePath = storage_path('app/content_blocks.json');
        }

        return self::$storagePath;
    }

    /**
     * Retrieve all custom content blocks.
     */
    public static function getAll(): array
    {
        $path = self::getStoragePath();
        if (! File::exists($path)) {
            return [];
        }

        $content = File::get($path);

        return json_decode($content, true) ?: [];
    }

    /**
     * Get customized content blocks for a specific page.
     */
    public static function getPageBlocks(string $page): array
    {
        $all = self::getAll();

        return $all[$page] ?? [];
    }

    /**
     * Get a specific field value with fallback default.
     */
    public static function get(string $page, string $key, mixed $default = null): mixed
    {
        $blocks = self::getPageBlocks($page);

        return $blocks[$key] ?? $default;
    }

    /**
     * Save/update customized blocks for a specific page.
     */
    public static function savePageBlocks(string $page, array $fields): array
    {
        $all = self::getAll();
        $all[$page] = array_merge($all[$page] ?? [], $fields);

        $path = self::getStoragePath();
        if (! File::isDirectory(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }

        File::put($path, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $all[$page];
    }

    /**
     * Reset custom blocks for a specific page back to default.
     */
    public static function resetPage(string $page): bool
    {
        $all = self::getAll();
        if (isset($all[$page])) {
            unset($all[$page]);
            $path = self::getStoragePath();
            File::put($path, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return true;
        }

        return false;
    }

    /**
     * Seed or get default editable schema for supported pages.
     */
    public static function getSchema(): array
    {
        return [
            'home' => [
                'title' => 'الصفحة الرئيسية السيادية',
                'sections' => [
                    'hero_badge' => ['label' => 'شارة الترحيب العلوية', 'type' => 'text', 'default' => '🌟 المنظومة السيادية الأولى عالمياً برؤية 2030'],
                    'hero_title' => ['label' => 'العنوان الرئيسي للهيرو', 'type' => 'text', 'default' => 'منظومة نوادر السيادية العالمية'],
                    'hero_subtitle' => ['label' => 'النص التوضيحي للهيرو', 'type' => 'textarea', 'default' => 'بوابتك الرقمية المتكاملة لتوثيق العقود، تأسيس الشركات، الربط الحكومي السعودي الأمريكي، والذكاء الاصطناعي المؤسسي.'],
                    'cta_primary_text' => ['label' => 'نص زر التعاقد الأساسي', 'type' => 'text', 'default' => 'ابدأ التعاقد السيادي ⚡'],
                    'cta_secondary_text' => ['label' => 'نص زر الاستكشاف الثانوي', 'type' => 'text', 'default' => 'استعراض الـ 20 قطاعاً'],
                    'stat_volume' => ['label' => 'إحصائية حجم المعاملات', 'type' => 'text', 'default' => '1.8B+ ر.س'],
                    'stat_speed' => ['label' => 'مؤشر سرعة الإنجاز والاعتماد', 'type' => 'text', 'default' => '99.8% فوري'],
                ],
            ],
            'about' => [
                'title' => 'عن منظومة نوادر ورؤية 2030',
                'sections' => [
                    'about_badge' => ['label' => 'شارة التميز', 'type' => 'text', 'default' => '🏛️ شراكة استراتيجية سعودية أمريكية موثقة'],
                    'about_heading' => ['label' => 'عنوان من نحن', 'type' => 'text', 'default' => 'نوادر — ريادة السيادة المؤسسية والربط العالمي'],
                    'about_lead' => ['label' => 'المقدمة التعريفية', 'type' => 'textarea', 'default' => 'تأسست نوادر لتكون الجسر السيادي الرقمي بين المملكة العربية السعودية والولايات المتحدة الأمريكية، مقدمة حلولاً لا تضاهى في العقود والتراخيص والمشاريع العملاقة.'],
                ],
            ],
            'pricing' => [
                'title' => 'صفحة الأسعار والحزم التعاقدية',
                'sections' => [
                    'pricing_heading' => ['label' => 'عنوان الحزم', 'type' => 'text', 'default' => 'حزم تعاقدية سيادية وشفافة بلا رسوم خفية'],
                    'pricing_sub' => ['label' => 'الوصف التعاقدي', 'type' => 'textarea', 'default' => 'تسعير دقيق ومرن يشمل الضمان المالي المشروط (Escrow) والربط مع منظومة الفوترة الإلكترونية زاتكا.'],
                ],
            ],
            'studio' => [
                'title' => 'أستديو نوادر السينمائي',
                'sections' => [
                    'studio_badge' => ['label' => 'شارة الأستديو', 'type' => 'text', 'default' => '🎬 إنتاج مجسمات بصرية وسينمائية 8K'],
                    'studio_title' => ['label' => 'عنوان الأستديو الرئيسي', 'type' => 'text', 'default' => 'أستديو نوادر السينمائي للمشاريع الكبرى'],
                ],
            ],
            'app_builder' => [
                'title' => 'باني الأنظمة والبرمجيات السيادية',
                'sections' => [
                    'builder_badge' => ['label' => 'شارة المحرك', 'type' => 'text', 'default' => '🚀 معمارية سحابية فائقة الأمان'],
                    'builder_title' => ['label' => 'عنوان بناء البرمجيات', 'type' => 'text', 'default' => 'باني المنظومات والتطبيقات السيادية'],
                ],
            ],
        ];
    }
}
