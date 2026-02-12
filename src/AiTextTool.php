<?php

namespace AmiPraha\AiTextTool;

use AmiPraha\AiTextTool\Contracts\TextExecutor;
use AmiPraha\AiTextTool\Support\PromptCatalog;
use InvalidArgumentException;

class AiTextTool
{
    public function __construct(
        private readonly PromptCatalog $promptCatalog,
        private readonly TextExecutor $executor,
        private readonly ?string $model = null,
        private readonly ?int $timeout = null,
        private ?string $language = null,
    ) {}

    public function usingLanguage(string $language): self
    {
        $normalized = strtolower(trim($language));

        if ($normalized === '') {
            throw new InvalidArgumentException('Language must not be empty.');
        }

        $clone = clone $this;
        $clone->language = $normalized;

        return $clone;
    }

    public function summarize(string $sourceText, int $length): string
    {
        $this->assertNonEmptyText($sourceText);
        $this->assertPositiveLength($length, 'Summary length');

        return $this->run(
            operation: 'summarize',
            replacements: [
                ':length' => (string) $length,
                ':text' => trim($sourceText),
            ],
        );
    }

    public function headline(string $sourceText, int $length): string
    {
        $this->assertNonEmptyText($sourceText);
        $this->assertPositiveLength($length, 'Heading length');

        return $this->run(
            operation: 'headline',
            replacements: [
                ':length' => (string) $length,
                ':text' => trim($sourceText),
            ],
        );
    }

    public function translate(string $sourceText, string $targetLanguage, ?string $sourceLanguage = null): string
    {
        $this->assertNonEmptyText($sourceText);

        $targetLanguage = trim($targetLanguage);

        if ($targetLanguage === '') {
            throw new InvalidArgumentException('Target language must not be empty.');
        }

        $sourceLanguage = is_string($sourceLanguage) && trim($sourceLanguage) !== ''
            ? trim($sourceLanguage)
            : 'auto';

        return $this->run(
            operation: 'translate',
            replacements: [
                ':target_language' => $targetLanguage,
                ':source_language' => $sourceLanguage,
                ':text' => trim($sourceText),
            ],
        );
    }

    public function repair(string $sourceText): string
    {
        $this->assertNonEmptyText($sourceText);

        return $this->run(
            operation: 'repair',
            replacements: [
                ':text' => trim($sourceText),
            ],
        );
    }

    private function run(string $operation, array $replacements): string
    {
        $prompt = $this->promptCatalog->operation($operation, $this->language);
        $replacements = $this->withOutputLanguage($operation, $prompt, $replacements);

        return $this->executor->generate(
            instructions: $this->interpolate((string) $prompt['system'], $replacements),
            prompt: $this->interpolate((string) $prompt['user'], $replacements),
            model: $this->model,
            timeout: $this->timeout,
        );
    }

    /**
     * @param array{language:string, system:string, user:string} $prompt
     */
    private function withOutputLanguage(string $operation, array $prompt, array $replacements): array
    {
        if ($operation === 'translate') {
            return $replacements;
        }

        $replacements[':output_language'] = $this->language ?? (string) $prompt['language'];

        return $replacements;
    }

    private function interpolate(string $template, array $replacements): string
    {
        return strtr($template, $replacements);
    }

    private function assertNonEmptyText(string $text): void
    {
        if (trim($text) === '') {
            throw new InvalidArgumentException('Source text must not be empty.');
        }
    }

    private function assertPositiveLength(int $length, string $field): void
    {
        if ($length <= 0) {
            throw new InvalidArgumentException(sprintf('%s must be greater than zero.', $field));
        }
    }
}
