<?php

namespace AmiPraha\AiTextTool\Tests;

use AmiPraha\AiTextTool\AiTextTool;
use AmiPraha\AiTextTool\Language;
use AmiPraha\AiTextTool\Support\PromptCatalog;
use AmiPraha\AiTextTool\Tests\Fakes\FakeExecutor;
use InvalidArgumentException;

class AiTextToolTest extends TestCase
{
    public function test_summarize_builds_prompt_with_length_text_and_default_output_language(): void
    {
        $executor = new FakeExecutor('summary');
        $tool = $this->makeTool($executor);

        $result = $tool->summarize('Some long text.', 120);

        $this->assertSame('summary', $result);
        $this->assertCount(1, $executor->calls);
        $this->assertStringContainsString('approximately 120 characters', $executor->calls[0]['prompt']);
        $this->assertStringContainsString('Some long text.', $executor->calls[0]['prompt']);
        $this->assertStringContainsString('OUTPUT LANGUAGE: english', $executor->calls[0]['prompt']);
    }

    public function test_translate_uses_auto_source_hint_when_not_provided(): void
    {
        $executor = new FakeExecutor('translation');
        $tool = $this->makeTool($executor);

        $tool->translate('Ahoj svete');

        $this->assertStringContainsString('SOURCE LANGUAGE HINT: auto', $executor->calls[0]['prompt']);
    }

    public function test_translate_uses_explicit_source_hint_via_from_language(): void
    {
        $executor = new FakeExecutor('translation');
        $tool = $this->makeTool($executor);

        $tool->fromLanguage(Language::Czech)->translate('Ahoj svete');

        $this->assertStringContainsString('SOURCE LANGUAGE HINT: czech', $executor->calls[0]['prompt']);
    }

    public function test_translate_uses_output_language_from_using_language(): void
    {
        $executor = new FakeExecutor('translation');
        $tool = $this->makeTool($executor);

        $tool->usingLanguage(Language::Slovak)->translate('Hello world');

        $this->assertStringContainsString('slovak', $executor->calls[0]['prompt']);
        $this->assertStringContainsString('Hello world', $executor->calls[0]['prompt']);
    }

    public function test_language_override_does_not_leak_state(): void
    {
        $executor = new FakeExecutor('ok');
        $tool = $this->makeTool($executor);

        $tool->usingLanguage(Language::Czech)->repair('to je text');
        $tool->repair('this is text');

        $this->assertStringContainsString('Jsi profesionální engine pro korekturu a opravu gramatiky', $executor->calls[0]['instructions']);
        $this->assertStringContainsString('JAZYK VÝSTUPU: czech', $executor->calls[0]['prompt']);
        $this->assertStringContainsString('You are a professional proofreading and grammar correction engine', $executor->calls[1]['instructions']);
        $this->assertStringContainsString('OUTPUT LANGUAGE: english', $executor->calls[1]['prompt']);
    }

    public function test_from_language_does_not_leak_state(): void
    {
        $executor = new FakeExecutor('ok');
        $tool = $this->makeTool($executor);

        $tool->fromLanguage(Language::Czech)->translate('Ahoj svete');
        $tool->translate('Hello world');

        $this->assertStringContainsString('SOURCE LANGUAGE HINT: czech', $executor->calls[0]['prompt']);
        $this->assertStringContainsString('SOURCE LANGUAGE HINT: auto', $executor->calls[1]['prompt']);
    }

    public function test_language_override_applies_to_output_language(): void
    {
        $executor = new FakeExecutor('ok');
        $tool = $this->makeTool($executor);

        $tool->usingLanguage(Language::Spanish)->repair('this is text');

        $this->assertStringContainsString('Eres un motor profesional de corrección y revisión gramatical', $executor->calls[0]['instructions']);
        $this->assertStringContainsString('IDIOMA DE SALIDA: spanish', $executor->calls[0]['prompt']);
    }

    public function test_from_language_applies_to_non_translate_operations(): void
    {
        $executor = new FakeExecutor('ok');
        $tool = $this->makeTool($executor);

        $tool->fromLanguage(Language::Czech)->summarize('Nějaký dlouhý text.', 120);

        $this->assertStringContainsString('SOURCE LANGUAGE HINT: czech', $executor->calls[0]['prompt']);
    }

    public function test_length_must_be_positive(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $tool = $this->makeTool(new FakeExecutor);
        $tool->headline('text', 0);
    }

    private function makeTool(FakeExecutor $executor): AiTextTool
    {
        return new AiTextTool(
            promptCatalog: new PromptCatalog(
                packagePromptPath: __DIR__.'/../resources/prompts',
                customPromptPath: null,
                defaultLanguage: Language::English,
            ),
            executor: $executor,
            model: null,
            timeout: 60,
        );
    }
}
