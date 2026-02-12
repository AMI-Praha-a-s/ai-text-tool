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
        $app['config']->set('ai-text-tool.default_prompt_language', 'english');
        $app['config']->set('ai-text-tool.custom_prompt_path', null);
        $app['config']->set('ai-text-tool.provider', null);
        $app['config']->set('ai-text-tool.model', null);
        $app['config']->set('ai-text-tool.timeout', 60);
    }
}
