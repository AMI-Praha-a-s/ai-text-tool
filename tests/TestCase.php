<?php

namespace AmiPraha\AiTextTool\Tests;

use AmiPraha\AiTextTool\AiTextToolServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            AiTextToolServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('ai-text-tool.default_language', 'english');
        $app['config']->set('ai-text-tool.custom_language_path', null);
        $app['config']->set('ai-text-tool.openai_api_key', 'test-key');
        $app['config']->set('ai-text-tool.openai_model', 'gpt-4.1-mini');
        $app['config']->set('ai-text-tool.openai_base_url', 'https://api.openai.com/v1');
        $app['config']->set('ai-text-tool.timeout', 60);
    }
}
