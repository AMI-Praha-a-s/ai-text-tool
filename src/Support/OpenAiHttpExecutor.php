<?php

namespace AmiPraha\AiTextTool\Support;

use AmiPraha\AiTextTool\Contracts\TextExecutor;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class OpenAiHttpExecutor implements TextExecutor
{
    public function __construct(
        private readonly ?string $apiKey = null,
        private readonly string $baseUrl = 'https://api.openai.com/v1',
        private readonly string $defaultModel = 'gpt-4.1-mini',
    ) {}

    public function generate(
        string $instructions,
        string $prompt,
        ?string $model = null,
        ?int $timeout = null,
    ): string {
        $apiKey = $this->normalizeString($this->apiKey);
        if ($apiKey === null) {
            throw new RuntimeException('OpenAI API key is missing. Set AI_TEXT_TOOL_OPENAI_API_KEY.');
        }

        $resolvedModel = $this->normalizeString($model) ?? $this->normalizeString($this->defaultModel);
        if ($resolvedModel === null) {
            throw new RuntimeException('OpenAI model is missing. Set AI_TEXT_TOOL_OPENAI_MODEL.');
        }

        $resolvedTimeout = is_int($timeout) && $timeout > 0 ? $timeout : 60;

        try {
            $response = Http::baseUrl($this->normalizeBaseUrl($this->baseUrl))
                ->withToken($apiKey)
                ->acceptJson()
                ->asJson()
                ->timeout($resolvedTimeout)
                ->post('/chat/completions', [
                    'model' => $resolvedModel,
                    'messages' => [
                        ['role' => 'system', 'content' => $instructions],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);
        } catch (ConnectionException $exception) {
            throw new RuntimeException(
                sprintf('OpenAI request failed: %s', $exception->getMessage()),
                0,
                $exception,
            );
        }

        if ($response->failed()) {
            throw new RuntimeException(sprintf(
                'OpenAI request failed with status %d: %s',
                $response->status(),
                $response->body(),
            ));
        }

        $content = $this->extractMessageContent($response->json('choices.0.message.content'));
        if ($content === null) {
            throw new RuntimeException('OpenAI response did not include assistant message content.');
        }

        return $content;
    }

    private function extractMessageContent(mixed $content): ?string
    {
        if (is_string($content)) {
            $trimmed = trim($content);

            return $trimmed === '' ? null : $trimmed;
        }

        if (! is_array($content)) {
            return null;
        }

        $textParts = array_values(array_filter(array_map(
            fn (mixed $part): string => is_array($part) && is_string($part['text'] ?? null) ? $part['text'] : '',
            $content,
        )));

        if ($textParts === []) {
            return null;
        }

        $joined = trim(implode('', $textParts));

        return $joined === '' ? null : $joined;
    }

    private function normalizeBaseUrl(string $baseUrl): string
    {
        $trimmed = trim($baseUrl);

        return rtrim($trimmed === '' ? 'https://api.openai.com/v1' : $trimmed, '/');
    }

    private function normalizeString(?string $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $trimmed = trim($value);

        return $trimmed === '' ? null : $trimmed;
    }
}
