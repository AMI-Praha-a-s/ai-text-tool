<?php

namespace AmiPraha\AiTextTool\Facades;

use Illuminate\Support\Facades\Facade;

class AiTextTool extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AmiPraha\AiTextTool\AiTextTool::class;
    }
}
