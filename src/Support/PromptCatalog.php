<?php

namespace AmiPraha\AiTextTool\Support;

use AmiPraha\AiTextTool\Language;
use RuntimeException;

class PromptCatalog
{
    private array $cache = [];

    public function __construct(
        private readonly string $packagePromptPath,
        private readonly ?string $customPromptPath,
        private readonly Language $defaultLanguage = Language::English,
    ) {}

    /**
     * @return array{language:string, system:string, user:string}
     */
    public function operation(string $operation, ?Language $requestedLanguage = null): array
    {
        $candidates = array_values(array_unique(array_filter([
            $requestedLanguage,
            $this->defaultLanguage,
            Language::English,
        ]), SORT_REGULAR));

        foreach ($candidates as $language) {
            $prompts = $this->promptsForLanguage($language);

            if (! is_array($prompts)) {
                continue;
            }

            if (! isset($prompts[$operation]['system'], $prompts[$operation]['user'])) {
                continue;
            }

            return [
                'language' => $language->value,
                'system' => (string) $prompts[$operation]['system'],
                'user' => (string) $prompts[$operation]['user'],
            ];
        }

        throw new RuntimeException(sprintf(
            'No language template found for operation "%s". Checked languages: %s',
            $operation,
            implode(', ', array_map(fn (Language $l) => $l->value, $candidates)),
        ));
    }

    private function promptsForLanguage(Language $language): ?array
    {
        if (array_key_exists($language->value, $this->cache)) {
            return $this->cache[$language->value];
        }

        $fileCandidates = array_values(array_filter([
            $this->customPromptPath ? rtrim($this->customPromptPath, '/').'/'.$language->value.'.php' : null,
            rtrim($this->packagePromptPath, '/').'/'.$language->value.'.php',
        ]));

        foreach ($fileCandidates as $filePath) {
            if (! is_file($filePath)) {
                continue;
            }

            $content = require $filePath;

            if (! is_array($content)) {
                continue;
            }

            $this->cache[$language->value] = $content;

            return $content;
        }

        $this->cache[$language->value] = null;

        return null;
    }
}
