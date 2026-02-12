<?php

namespace AmiPraha\AiTextTool\Tests;

use AmiPraha\AiTextTool\AiTextTool;
use AmiPraha\AiTextTool\Support\PromptCatalog;
use AmiPraha\AiTextTool\Tests\Fakes\FakeExecutor;
use InvalidArgumentException;

class AiTextToolTest extends TestCase
{
    public function test_summarization_builds_prompt_with_length_and_text(): void
    {
        $executor = new FakeExecutor('summary');
        $tool = $this->makeTool($executor);

        $result = $tool->summarization('Some long text.', 120);

        $this->assertSame('summary', $result);
        $this->assertCount(1, $executor->calls);
        $this->assertStringContainsString('about 120 characters', $executor->calls[0]['prompt']);
        $this->assertStringContainsString('Some long text.', $executor->calls[0]['prompt']);
    }

    public function test_translation_uses_auto_source_hint_when_not_provided(): void
    {
        $executor = new FakeExecutor('translation');
        $tool = $this->makeTool($executor);

        $tool->translation('Ahoj svete', 'english');

        $this->assertStringContainsString('Source language hint: auto', $executor->calls[0]['prompt']);
    }

    public function test_translation_uses_explicit_source_hint_when_provided(): void
    {
        $executor = new FakeExecutor('translation');
        $tool = $this->makeTool($executor);

        $tool->translation('Ahoj svete', 'slovak', 'czech');

        $this->assertStringContainsString('Source language hint: czech', $executor->calls[0]['prompt']);
    }

    public function test_prompt_language_override_does_not_leak_state(): void
    {
        $executor = new FakeExecutor('ok');
        $tool = $this->makeTool($executor);

        $tool->inPromptLanguage('czech')->repair('to je text');
        $tool->repair('this is text');

        $this->assertStringContainsString('Jsi jazykovy editor', $executor->calls[0]['instructions']);
        $this->assertStringContainsString('You are a language editor', $executor->calls[1]['instructions']);
    }

    public function test_length_must_be_positive(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $tool = $this->makeTool(new FakeExecutor);
        $tool->heading('text', 0);
    }

    private function makeTool(FakeExecutor $executor): AiTextTool
    {
        return new AiTextTool(
            promptCatalog: new PromptCatalog(
                packagePromptPath: __DIR__.'/../resources/prompts',
                customPromptPath: null,
                defaultLanguage: 'english',
            ),
            executor: $executor,
            provider: null,
            model: null,
            timeout: 60,
        );
    }
}
