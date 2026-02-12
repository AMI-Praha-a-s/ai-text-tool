<?php

namespace AmiPraha\AiTextTool\Tests\Fakes;

use AmiPraha\AiTextTool\Contracts\TextExecutor;

class FakeExecutor implements TextExecutor
{
    public array $calls = [];

    public function __construct(
        private readonly string $response = 'fake-response',
    ) {}

    public function generate(
        string $instructions,
        string $prompt,
        ?string $provider = null,
        ?string $model = null,
        ?int $timeout = null,
    ): string {
        $this->calls[] = [
            'instructions' => $instructions,
            'prompt' => $prompt,
            'provider' => $provider,
            'model' => $model,
            'timeout' => $timeout,
        ];

        return $this->response;
    }
}
