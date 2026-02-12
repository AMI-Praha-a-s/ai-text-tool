<?php

namespace AmiPraha\AiTextTool\Facades;

use AmiPraha\AiTextTool\Language;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \AmiPraha\AiTextTool\AiTextTool usingLanguage(Language $language)
 * @method static string summarize(string $sourceText, int $length)
 * @method static string headline(string $sourceText, int $length)
 * @method static string translate(string $sourceText, Language $targetLanguage, ?Language $sourceLanguage = null)
 * @method static string repair(string $sourceText)
 *
 * @mixin \AmiPraha\AiTextTool\AiTextTool
 */
class AiTextTool extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AmiPraha\AiTextTool\AiTextTool::class;
    }
}
