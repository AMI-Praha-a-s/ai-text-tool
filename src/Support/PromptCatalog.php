<?php

namespace AmiPraha\AiTextTool\Support;

use RuntimeException;

class PromptCatalog
{
    private array $cache = [];

    public function __construct(
        private readonly string $packagePromptPath,
        private readonly ?string $customPromptPath,
        private readonly string $defaultLanguage = 'english',
    ) {}

    /**
     * @return array{language:string, system:string, user:string}
     */
    public function operation(string $operation, ?string $requestedLanguage = null): array
    {
        $candidates = array_values(array_unique(array_filter([
            $this->normalizeLanguage($requestedLanguage),
            $this->normalizeLanguage($this->defaultLanguage),
            'english',
        ])));

        foreach ($candidates as $language) {
            $prompts = $this->promptsForLanguage($language);

            if (! is_array($prompts)) {
                continue;
            }

            if (! isset($prompts[$operation]['system'], $prompts[$operation]['user'])) {
                continue;
            }

            return [
                'language' => $language,
                'system' => (string) $prompts[$operation]['system'],
                'user' => (string) $prompts[$operation]['user'],
            ];
        }

        throw new RuntimeException(sprintf(
            'No language template found for operation "%s". Checked languages: %s',
            $operation,
            implode(', ', $candidates),
        ));
    }

    private function promptsForLanguage(string $language): ?array
    {
        if (array_key_exists($language, $this->cache)) {
            return $this->cache[$language];
        }

        $fileCandidates = array_values(array_filter([
            $this->customPromptPath ? rtrim($this->customPromptPath, '/').'/'.$language.'.php' : null,
            rtrim($this->packagePromptPath, '/').'/'.$language.'.php',
        ]));

        foreach ($fileCandidates as $filePath) {
            if (! is_file($filePath)) {
                continue;
            }

            $content = require $filePath;

            if (! is_array($content)) {
                continue;
            }

            $this->cache[$language] = $content;

            return $content;
        }

        $this->cache[$language] = null;

        return null;
    }

    private function normalizeLanguage(?string $language): ?string
    {
        if (! is_string($language)) {
            return null;
        }

        $normalized = strtolower(trim($language));

        return $normalized === '' ? null : $normalized;
    }
}
