<?php

namespace AmiPraha\AiTextTool;

use AmiPraha\AiTextTool\Contracts\TextExecutor;
use AmiPraha\AiTextTool\Support\LaravelAiExecutor;
use AmiPraha\AiTextTool\Support\PromptCatalog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AiTextToolServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ai-text-tool.php', 'ai-text-tool');

        $this->app->singleton(PromptCatalog::class, fn () => new PromptCatalog(
            packagePromptPath: __DIR__.'/../resources/prompts',
            customPromptPath: $this->nullableString(config('ai-text-tool.custom_prompt_path')),
            defaultLanguage: (string) config('ai-text-tool.default_prompt_language', 'english'),
        ));

        $this->app->bind(TextExecutor::class, LaravelAiExecutor::class);

        $this->app->singleton(AiTextTool::class, fn (Application $app) => new AiTextTool(
            promptCatalog: $app->make(PromptCatalog::class),
            executor: $app->make(TextExecutor::class),
            provider: $this->nullableString(config('ai-text-tool.provider')),
            model: $this->nullableString(config('ai-text-tool.model')),
            timeout: is_numeric(config('ai-text-tool.timeout')) ? (int) config('ai-text-tool.timeout') : null,
        ));
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/ai-text-tool.php' => config_path('ai-text-tool.php'),
        ], 'ai-text-tool-config');

        $this->publishes([
            __DIR__.'/../resources/prompts' => resource_path('ai-text-tool/prompts'),
        ], 'ai-text-tool-prompts');
    }

    private function nullableString(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $trimmed = trim($value);

        return $trimmed === '' ? null : $trimmed;
    }
}
