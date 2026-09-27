<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * The production config cache file, parked for the duration of the test
     * run so phpunit.xml env overrides (APP_ENV=testing, sqlite :memory:, …)
     * are honoured. Restored automatically on shutdown.
     */
    private static ?string $parkedConfigCache = null;

    public function createApplication()
    {
        $this->parkConfigCacheForTests();

        return parent::createApplication();
    }

    /**
     * Temporarily move bootstrap/cache/config.php out of the way during the
     * test run, then restore it when PHPUnit exits (so production keeps its
     * cached config). Without this, a cached production config silently
     * overrides every phpunit.xml <env> value and tests would execute
     * against the live database with APP_ENV=production.
     */
    private function parkConfigCacheForTests(): void
    {
        if (self::$parkedConfigCache !== null || ! is_dir(dirname(__DIR__).'/bootstrap/cache')) {
            return;
        }

        $cacheFile = dirname(__DIR__).'/bootstrap/cache/config.php';

        if (is_file($cacheFile)) {
            $parked = $cacheFile.'.testparked';

            if (@rename($cacheFile, $parked)) {
                self::$parkedConfigCache = $parked;

                register_shutdown_function(static function () use ($parked, $cacheFile): void {
                    if (is_file($parked) && ! is_file($cacheFile)) {
                        @rename($parked, $cacheFile);
                    }
                });
            }
        }
    }
}
