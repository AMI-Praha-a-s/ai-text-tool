<?php

namespace AmiPraha\AiTextTool\Tests;

use AmiPraha\AiTextTool\Support\PromptCatalog;

class PromptCatalogTest extends TestCase
{
    public function test_it_resolves_requested_language_templates(): void
    {
        $catalog = new PromptCatalog(
            packagePromptPath: __DIR__.'/../resources/prompts',
            customPromptPath: null,
            defaultLanguage: 'english',
        );

        $prompt = $catalog->operation('repair', 'czech');

        $this->assertSame('czech', $prompt['language']);
        $this->assertStringContainsString('Oprav nasledujici text', $prompt['user']);
    }

    public function test_it_falls_back_to_default_language_when_requested_is_missing(): void
    {
        $catalog = new PromptCatalog(
            packagePromptPath: __DIR__.'/../resources/prompts',
            customPromptPath: null,
            defaultLanguage: 'spanish',
        );

        $prompt = $catalog->operation('heading', 'french');

        $this->assertSame('spanish', $prompt['language']);
        $this->assertStringContainsString('Crea un titulo', $prompt['user']);
    }

    public function test_it_falls_back_to_english_when_default_is_missing(): void
    {
        $catalog = new PromptCatalog(
            packagePromptPath: __DIR__.'/../resources/prompts',
            customPromptPath: null,
            defaultLanguage: 'french',
        );

        $prompt = $catalog->operation('summarization', 'italian');

        $this->assertSame('english', $prompt['language']);
        $this->assertStringContainsString('Create a high-quality summary', $prompt['user']);
    }
}
