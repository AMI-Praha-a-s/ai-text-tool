<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default language
    |--------------------------------------------------------------------------
    |
    | Available language files: english, czech, slovak, german, spanish.
    |
    */
    'default_language' => env('AI_TEXT_TOOL_LANGUAGE', 'english'),

    /*
    |--------------------------------------------------------------------------
    | Optional custom language path
    |--------------------------------------------------------------------------
    |
    | If set, language files from this directory override package language files.
    |
    */
    'custom_language_path' => env('AI_TEXT_TOOL_LANGUAGE_PATH'),

    /*
    |--------------------------------------------------------------------------
    | OpenAI runtime options
    |--------------------------------------------------------------------------
    |
    | Set OpenAI credentials and optional model/base URL overrides.
    |
    */
    'openai_api_key' => env('AI_TEXT_TOOL_OPENAI_API_KEY', env('OPENAI_API_KEY')),
    'openai_model' => env('AI_TEXT_TOOL_OPENAI_MODEL', 'gpt-5-mini'),
    'openai_base_url' => env('AI_TEXT_TOOL_OPENAI_BASE_URL', 'https://api.openai.com/v1'),
    'timeout' => (int) env('AI_TEXT_TOOL_TIMEOUT', 60),
];
