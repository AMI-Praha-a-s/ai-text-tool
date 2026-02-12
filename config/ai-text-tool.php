<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default prompt language
    |--------------------------------------------------------------------------
    |
    | Available prompt files: english, czech, slovak, german, spanish.
    |
    */
    'default_prompt_language' => env('AI_TEXT_TOOL_PROMPT_LANGUAGE', 'english'),

    /*
    |--------------------------------------------------------------------------
    | Optional custom prompt path
    |--------------------------------------------------------------------------
    |
    | If set, language files from this directory override package prompt files.
    |
    */
    'custom_prompt_path' => env('AI_TEXT_TOOL_PROMPT_PATH'),

    /*
    |--------------------------------------------------------------------------
    | Laravel AI SDK provider/model runtime options
    |--------------------------------------------------------------------------
    |
    | Keep null to use default provider/model from config/ai.php.
    |
    */
    'provider' => env('AI_TEXT_TOOL_PROVIDER'),
    'model' => env('AI_TEXT_TOOL_MODEL'),
    'timeout' => (int) env('AI_TEXT_TOOL_TIMEOUT', 60),
];
