<?php

namespace AmiPraha\AiTextTool\Tests;

use AmiPraha\AiTextTool\AiTextTool as AiTextToolService;
use AmiPraha\AiTextTool\Contracts\TextExecutor;
use AmiPraha\AiTextTool\Facades\AiTextTool as AiTextToolFacade;
use AmiPraha\AiTextTool\Tests\Fakes\FakeExecutor;

class FacadeTest extends TestCase
{
    public function test_facade_supports_fluent_language_override(): void
    {
        $fakeExecutor = new FakeExecutor('facade-output');

        $this->app->bind(TextExecutor::class, fn () => $fakeExecutor);
        $this->app['config']->set('ai-text-tool.openai_model', 'gpt-4.1-mini');
        $this->app['config']->set('ai-text-tool.timeout', 45);

        $this->app->forgetInstance(AiTextToolService::class);
        AiTextToolFacade::clearResolvedInstance(AiTextToolService::class);

        $result = AiTextToolFacade::usingLanguage('german')->summarize('Beispieltext', 90);

        $this->assertSame('facade-output', $result);
        $this->assertSame('gpt-4.1-mini', $fakeExecutor->calls[0]['model']);
        $this->assertSame(45, $fakeExecutor->calls[0]['timeout']);
        $this->assertStringContainsString('Du bist ein präziser Schreibassistent', $fakeExecutor->calls[0]['instructions']);
        $this->assertStringContainsString('Schreibe die Ausgabe in dieser Sprache: german.', $fakeExecutor->calls[0]['prompt']);
    }
}
