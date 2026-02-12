<?php

namespace AmiPraha\AiTextTool\Tests;

use AmiPraha\AiTextTool\Language;
use AmiPraha\AiTextTool\Support\PromptCatalog;

class PromptCatalogTest extends TestCase
{
    public function test_it_resolves_requested_language_templates(): void
    {
        $catalog = new PromptCatalog(
            packagePromptPath: __DIR__.'/../resources/prompts',
            customPromptPath: null,
            defaultLanguage: Language::English,
        );

        $prompt = $catalog->operation('repair', Language::Czech);

        $this->assertSame('czech', $prompt['language']);
        $this->assertStringContainsString('Zkontroluj a oprav text', $prompt['user']);
    }

    public function test_it_falls_back_to_default_language_when_requested_is_null(): void
    {
        $catalog = new PromptCatalog(
            packagePromptPath: __DIR__.'/../resources/prompts',
            customPromptPath: null,
            defaultLanguage: Language::Spanish,
        );

        $prompt = $catalog->operation('headline', null);

        $this->assertSame('spanish', $prompt['language']);
        $this->assertStringContainsString('Crea un titular', $prompt['user']);
    }

    public function test_it_uses_default_language_when_no_language_requested(): void
    {
        $catalog = new PromptCatalog(
            packagePromptPath: __DIR__.'/../resources/prompts',
            customPromptPath: null,
            defaultLanguage: Language::German,
        );

        $prompt = $catalog->operation('summarize');

        $this->assertSame('german', $prompt['language']);
    }
}
