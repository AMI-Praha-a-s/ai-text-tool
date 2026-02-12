<?php

namespace AmiPraha\AiTextTool\Contracts;

interface TextExecutor
{
    public function generate(
        string $instructions,
        string $prompt,
        ?string $model = null,
        ?int $timeout = null,
    ): string;
}
