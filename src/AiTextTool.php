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
        private ?Language $language = null,
        private ?Language $sourceLanguage = null,
    ) {}

    public function usingLanguage(Language $language): self
    {
        $clone = clone $this;
        $clone->language = $language;

        return $clone;
    }

    public function fromLanguage(Language $language): self
    {
        $clone = clone $this;
        $clone->sourceLanguage = $language;

        return $clone;
    }

    /**
     * Summarize the source text into a shorter text.
     *
     * @param string $sourceText
     * @param int $length
     * @return string
     */
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

    /**
     * Generate a headline for the source text.
     *
     * @param string $sourceText
     * @param int $length
     * @return string
     */
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

    /**
     * Translate the source text into the configured output language. 
     * It is recommended to use the `usingLanguage()` 
     * and `fromLanguage()` methods to set the output 
     * and source languages respectively.
     *
     * @param string $sourceText
     * @return string
     */
    public function translate(string $sourceText): string
    {
        $this->assertNonEmptyText($sourceText);

        return $this->run(
            operation: 'translate',
            replacements: [
                ':text' => trim($sourceText),
            ],
        );
    }

    /**
     * Repair the source text to correct grammatical and spelling errors.
     *
     * @param string $sourceText
     * @return string
     */
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

        $replacements[':output_language'] = $this->language?->value ?? (string) $prompt['language'];
        $replacements[':source_language'] = $this->sourceLanguage?->value ?? 'auto';

        return $this->executor->generate(
            instructions: $this->interpolate((string) $prompt['system'], $replacements),
            prompt: $this->interpolate((string) $prompt['user'], $replacements),
            model: $this->model,
            timeout: $this->timeout,
        );
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
