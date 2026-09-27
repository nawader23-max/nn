<?php

namespace App\Services\Integrations;

use App\Models\IntegrationSetting;

class SovereignIntegrationsManager
{
    /**
     * Get list of all available integrations grouped by sector
     */
    public static function getAllIntegrations(): array
    {
        return [
            'ai' => [
                'title' => 'وكلاء ونماذج الذكاء الاصطناعي (AI Engines)',
                'icon' => '🤖',
                'providers' => [
                    'allam' => [
                        'name' => 'علّام — SDAIA ALLaM',
                        'desc' => 'النموذج اللغوي السيادي السعودي المعتمد من هيئة سدايا',
                        'keys' => ['api_key' => 'API Key', 'endpoint' => 'API Endpoint URL'],
                        'status' => self::hasKey('allam', 'api_key') ? 'connected' : 'ready',
                        'badge' => '🇸🇦 سيادي حكومي',
                    ],
                    'openai' => [
                        'name' => 'OpenAI — GPT-4o / o1',
                        'desc' => 'تحليل الوثائق القانونية والاستشارات الفورية المتقدمة',
                        'keys' => ['api_key' => 'Secret Key (sk-...)', 'org_id' => 'Organization ID'],
                        'status' => self::hasKey('openai', 'api_key') ? 'connected' : 'ready',
                        'badge' => '🌐 عالمي',
                    ],
                    'anthropic' => [
                        'name' => 'Anthropic — Claude 3.5 Sonnet',
                        'desc' => 'صياغة ومراجعة العقود الثنائية المعقدة والتدقيق النظامي',
                        'keys' => ['api_key' => 'API Key (sk-ant-...)'],
                        'status' => self::hasKey('anthropic', 'api_key') ? 'connected' : 'ready',
                        'badge' => '⚖️ عقود وقوانين',
                    ],
                    'gemini' => [
                        'name' => 'Google Gemini — 2.5 Flash / Pro',
                        'desc' => 'المعالجة متعددة الوسائط والتعرف على المستندات والخرائط',
                        'keys' => ['api_key' => 'Google AI Key'],
                        'status' => self::hasKey('gemini', 'api_key') ? 'connected' : 'ready',
                        'badge' => '🔍 فحص وسائط',
                    ],
                    'deepseek' => [
                        'name' => 'DeepSeek — V3 / R1 Reasoner',
                        'desc' => 'المعالجة الرياضية والخوارزمية للنماذج المالية وحسابات الضرائب',
                        'keys' => ['api_key' => 'API Key (sk-...)'],
                        'status' => self::hasKey('deepseek', 'api_key') ? 'connected' : 'ready',
                        'badge' => '📊 نمذجة مالية',
                    ],
                    'ollama' => [
                        'name' => 'Local Sovereign LLM (Ollama / vLLM)',
                        'desc' => 'تشغيل محلي معزول 100% داخل خوادم المنصة للبيانات فائقة السرية',
                        'keys' => ['endpoint' => 'Server URL (e.g. http://localhost:11434)', 'model' => 'Model Name'],
                        'status' => self::hasKey('ollama', 'endpoint') ? 'connected' : 'ready',
                        'badge' => '🔒 معزول سيادياً',
                    ],
                ],
            ],
            'payment' => [
                'title' => 'بوابات الدفع والخزينة الرقمية (Payment Rails)',
                'icon' => '💳',
                'providers' => [
                    'moyasar' => [
                        'name' => 'ميسر — Moyasar (Mada & Saudi Rails)',
                        'desc' => 'المدفوعات السعودية عبر مدى والبطاقات البنكية وسداد',
                        'keys' => ['publishable_key' => 'Publishable Key', 'secret_key' => 'Secret Key'],
                        'status' => self::hasKey('moyasar', 'secret_key') ? 'connected' : 'ready',
                        'badge' => '🇸🇦 مدى وسداد',
                    ],
                    'stripe' => [
                        'name' => 'Stripe Global (USA & Europe)',
                        'desc' => 'استقبال المدفوعات والاشتراكات الدولية بالدولار واليورو',
                        'keys' => ['publishable_key' => 'Publishable Key (pk_...)', 'secret_key' => 'Secret Key (sk_...)', 'webhook_secret' => 'Webhook Signing Secret'],
                        'status' => self::hasKey('stripe', 'secret_key') ? 'connected' : 'ready',
                        'badge' => '🇺🇸 دولي USD',
                    ],
                    'apple_pay' => [
                        'name' => 'Apple Pay Direct Rail',
                        'desc' => 'معالجة الدفع السريع عبر أجهزة Apple بمصادقة FaceID',
                        'keys' => ['merchant_id' => 'Merchant Identifier', 'cert_path' => 'Merchant Certificate (.pem)'],
                        'status' => self::hasKey('apple_pay', 'merchant_id') ? 'connected' : 'ready',
                        'badge' => '🍎 سريع ومباشر',
                    ],
                    'tamara' => [
                        'name' => 'تمارا — Tamara (BNPL)',
                        'desc' => 'تقسيط رسوم الخدمات والدفع الآجل المتوافق مع الشريعة',
                        'keys' => ['api_token' => 'API Token', 'notification_token' => 'Notification Token'],
                        'status' => self::hasKey('tamara', 'api_token') ? 'connected' : 'ready',
                        'badge' => '💜 دفع آجل',
                    ],
                    'tabby' => [
                        'name' => 'تابي — Tabby (BNPL)',
                        'desc' => 'تقسيط الدفعات على 4 أقساط ميسرة بدون فوائد',
                        'keys' => ['public_key' => 'Public Key', 'secret_key' => 'Secret Key'],
                        'status' => self::hasKey('tabby', 'secret_key') ? 'connected' : 'ready',
                        'badge' => '💚 تقسيط ميسر',
                    ],
                ],
            ],
            'gov' => [
                'title' => 'التكاملات الحكومية والوزارية (Gov Tech)',
                'icon' => '🏛️',
                'providers' => [
                    'nafath' => [
                        'name' => 'نفاذ الوطني — KSA Nafath SSO',
                        'desc' => 'المصادقة الرقمية والتحقق من الهوية الوطنية والنفاذ الموحد',
                        'keys' => ['app_id' => 'Application ID', 'app_key' => 'Application Key'],
                        'status' => self::hasKey('nafath', 'app_key') ? 'connected' : 'ready',
                        'badge' => '🇸🇦 SSO معتمد',
                    ],
                    'wathq' => [
                        'name' => 'واثق — وزارة التجارة (MOC Wathq)',
                        'desc' => 'التحقق اللحظي من السجلات التجارية والوكالات والشركاء',
                        'keys' => ['api_key' => 'Wathq API Key'],
                        'status' => self::hasKey('wathq', 'api_key') ? 'connected' : 'ready',
                        'badge' => '📜 سجلات فورية',
                    ],
                    'zatca' => [
                        'name' => 'فاتورة — ZATCA Phase 2 E-Invoicing',
                        'desc' => 'الربط والتكامل مع هيئة الزكاة والضريبة وإصدار الفواتير المشفرة',
                        'keys' => ['csid' => 'Cryptographic Stamp ID', 'secret' => 'Compliance Secret', 'binary_token' => 'Binary Token'],
                        'status' => self::hasKey('zatca', 'csid') ? 'connected' : 'ready',
                        'badge' => '🧾 زاتكا المرحلة 2',
                    ],
                    'delaware' => [
                        'name' => 'Delaware Division of Corporations (USA)',
                        'desc' => 'الربط مع سجل شركات ولاية ديلاوير وتأسيس الكيانات الأمريكية',
                        'keys' => ['agent_code' => 'Registered Agent Code', 'api_key' => 'DE SOS Access Key'],
                        'status' => self::hasKey('delaware', 'api_key') ? 'connected' : 'ready',
                        'badge' => '🇺🇸 ديلاوير',
                    ],
                ],
            ],
            'comms' => [
                'title' => 'الاتصالات والإشعارات المباشرة (Omni-Channel Comms)',
                'icon' => '📱',
                'providers' => [
                    'whatsapp' => [
                        'name' => 'WhatsApp Business Cloud API (Meta)',
                        'desc' => 'إرسال تحديثات الرخص، الشهادات الصادرة، وتنبيهات السداد لحظياً',
                        'keys' => ['phone_number_id' => 'Phone Number ID', 'access_token' => 'System User Token', 'webhook_verify_token' => 'Verify Token'],
                        'status' => self::hasKey('whatsapp', 'access_token') ? 'connected' : 'ready',
                        'badge' => '💬 واتساب رسمي',
                    ],
                    'sms' => [
                        'name' => 'بوابة الرسائل النصية القصيرة (National SMS Gateway)',
                        'desc' => 'إرسال رموز المصادقة والتحقق الثنائي OTP فائق السرعة',
                        'keys' => ['api_key' => 'SMS API Key', 'sender_name' => 'Sender ID (نوادر / NAWADER)'],
                        'status' => self::hasKey('sms', 'api_key') ? 'connected' : 'ready',
                        'badge' => '📲 SMS OTP',
                    ],
                    'smtp' => [
                        'name' => 'البريد المؤسسي المشفر (TLS/SSL SMTP)',
                        'desc' => 'إرسال العقود الموقعة، الفواتير الضريبية، ومذكرات الاستثمار',
                        'keys' => ['host' => 'SMTP Host', 'port' => 'Port', 'username' => 'Username', 'password' => 'Password'],
                        'status' => self::hasKey('smtp', 'host') ? 'connected' : 'ready',
                        'badge' => '📧 بريد مشفر',
                    ],
                ],
            ],
            'analytics' => [
                'title' => 'التحليلات والامتثال وتجربة المستخدم (Analytics & Consent)',
                'icon' => '📊',
                'providers' => [
                    'ga4' => [
                        'name' => 'Google Analytics 4 (GA4)',
                        'desc' => 'تحليل رحلة العميل وسلوك التصفح ومعدلات التحويل',
                        'keys' => ['measurement_id' => 'Measurement ID (G-XXXXXXXXXX)'],
                        'status' => self::hasKey('ga4', 'measurement_id') ? 'connected' : 'ready',
                        'badge' => '📈 تحليلات GA4',
                    ],
                    'contentsquare' => [
                        'name' => 'ContentSquare Digital Experience',
                        'desc' => 'تحليل خرائط الحرارة والخرائط السلوكية لتجربة المستخدم',
                        'keys' => ['project_id' => 'Project ID'],
                        'status' => self::hasKey('contentsquare', 'project_id') ? 'connected' : 'ready',
                        'badge' => '👁️ سلوك المستخدم',
                    ],
                    'cookieyes' => [
                        'name' => 'CookieYes / PDPL Sovereign Consent',
                        'desc' => 'إدارة ملفات تعريف الارتباط والامتثال لنظام حماية البيانات السعودي وGDPR',
                        'keys' => ['website_key' => 'Website Key'],
                        'status' => self::hasKey('cookieyes', 'website_key') ? 'connected' : 'ready',
                        'badge' => '🍪 موافقة الكوكيز',
                    ],
                    'recaptcha' => [
                        'name' => 'Google reCAPTCHA v3',
                        'desc' => 'حماية النماذج وبوابات الدخول من الهجمات التلقائية بدون إزعاج المستخدم',
                        'keys' => ['site_key' => 'Site Key', 'secret_key' => 'Secret Key'],
                        'status' => self::hasKey('recaptcha', 'site_key') ? 'connected' : 'ready',
                        'badge' => '🛡️ حماية روبوتات',
                    ],
                ],
            ],
            'storage' => [
                'title' => 'التخزين السحابي والأرشفة السيادية (Storage & Archival)',
                'icon' => '☁️',
                'providers' => [
                    's3' => [
                        'name' => 'AWS S3 / Sovereign Middle East Region',
                        'desc' => 'تخزين المستندات والعقود الموقعة بتشفير AES-256 وحفظ محلي بالمملكة',
                        'keys' => ['key' => 'Access Key', 'secret' => 'Secret Access Key', 'region' => 'Region (me-central-1)', 'bucket' => 'Bucket Name'],
                        'status' => self::hasKey('s3', 'key') ? 'connected' : 'ready',
                        'badge' => '🗄️ تخزين سحابي',
                    ],
                ],
            ],
        ];
    }

    /**
     * Check if a specific integration key exists
     */
    public static function hasKey(string $provider, string $key): bool
    {
        return ! empty(IntegrationSetting::getVal($provider, $key));
    }

    /**
     * Get integration key
     */
    public static function getKey(string $provider, string $key, ?string $default = null): ?string
    {
        return IntegrationSetting::getVal($provider, $key, $default);
    }

    /**
     * Set integration key
     */
    public static function setKey(string $provider, string $key, ?string $value, string $group = 'general', ?string $label = null): void
    {
        IntegrationSetting::setVal($provider, $key, $value, $group, $label);
    }
}
