<?php

namespace Tactical\OpenAiTools\Providers;

use Illuminate\Support\ServiceProvider;

use function Tactical\OpenAiTools\fmt;

class OpenAiToolsProvider extends ServiceProvider
{
    const string KEY = 'open-ai-tools';

    const string ROOT = __DIR__.'/../..';

    const array MIGRATIONS = [
        '2025_04_01_000000_create_assistants_table',
    ];

    public function register(): void
    {
        $this->mergeConfig();
    }

    public function mergeConfig(): void
    {
        $this->mergeConfigFrom(fmt('%/config/%.php', self::ROOT, self::KEY), self::KEY);
    }

    public function boot(): void
    {
        $this->publishConfig();
        $this->publishMigrations();
    }

    private function publishConfig(): void
    {
        $files = [
            fmt('%/config/%.php', self::ROOT, self::KEY) => config_path(fmt('%.php', self::KEY)),
        ];

        $this->publishes($files, fmt('%-config', self::KEY));
    }

    private function publishMigrations(): void
    {
        $files = [];

        foreach (self::MIGRATIONS as $migration) {
            $files[fmt('%/database/migrations/%.php', self::ROOT, $migration)] = database_path(fmt('migrations/%.php', $migration));
        }

        $this->publishes($files, fmt('%-migrations', self::KEY));
    }
}
