<?php

namespace AmiPraha\AiTextTool\Support;

use AmiPraha\AiTextTool\Contracts\TextExecutor;

use function Laravel\Ai\agent;

class LaravelAiExecutor implements TextExecutor
{
    public function generate(
        string $instructions,
        string $prompt,
        ?string $provider = null,
        ?string $model = null,
        ?int $timeout = null,
    ): string {
        $options = array_filter([
            'provider' => $provider,
            'model' => $model,
            'timeout' => is_int($timeout) && $timeout > 0 ? $timeout : null,
        ], fn (mixed $value) => $value !== null);

        $response = agent(instructions: $instructions)->prompt($prompt, ...$options);

        return trim((string) $response);
    }
}
