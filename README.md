# AmiPraha AiTextTool

`AmiPraha\AiTextTool` is a Laravel package for OpenAI-powered text operations with multilingual language packs.

## Features

- Text summarization with requested output length.
- Headline generation with requested max length.
- Translation with target language and optional source language hint.
- Text repair (grammar, punctuation, readability improvements).
- Native language packs for multiple languages to improve output quality with non-English source text.

## Breaking Change

- Multi-provider support has been removed.
- The package is now OpenAI-only.
- `provider` config key no longer exists.

## Supported Languages

- `english`
- `czech`
- `slovak`
- `german`
- `spanish`

## Installation

```bash
composer require amipraha/ai-text-tool
```

Publish package config:

```bash
php artisan vendor:publish --tag=ai-text-tool-config
```

Optional: publish language files so you can customize them:

```bash
php artisan vendor:publish --tag=ai-text-tool-languages
```

## Configuration

File: `config/ai-text-tool.php`

- `default_language`: default language used by package.
- `custom_language_path`: optional directory with language files that override package language files.
- `openai_api_key`: OpenAI API key used for chat completion requests.
- `openai_model`: OpenAI model used by package operations.
- `openai_base_url`: optional OpenAI-compatible base URL (useful for gateways/proxies).
- `timeout`: HTTP timeout in seconds.

Example:

```php
return [
    'default_language' => 'english',
    'custom_language_path' => resource_path('ai-text-tool/languages'),
    'openai_api_key' => env('OPENAI_API_KEY'),
    'openai_model' => 'gpt-4.1-mini',
    'openai_base_url' => 'https://api.openai.com/v1',
    'timeout' => 60,
];
```

Environment variables:

```env
OPENAI_API_KEY=your-api-key
AI_TEXT_TOOL_LANGUAGE=english
AI_TEXT_TOOL_LANGUAGE_PATH=/full/path/to/language/files
AI_TEXT_TOOL_OPENAI_MODEL=gpt-4.1-mini
AI_TEXT_TOOL_OPENAI_BASE_URL=https://api.openai.com/v1
AI_TEXT_TOOL_TIMEOUT=60
```

## Usage

```php
use AmiPraha\AiTextTool\Facades\AiTextTool;

$summary = AiTextTool::summarize($sourceText, 450);
$headline = AiTextTool::headline($sourceText, 50);
$translation = AiTextTool::translate($sourceText, 'slovak', 'czech');
$repaired = AiTextTool::repair($sourceText);
```

### Fluent per-call language override

```php
$summary = AiTextTool::usingLanguage('czech')->summarize($sourceText, 450);
$headline = AiTextTool::usingLanguage('german')->headline($sourceText, 50);
```

The override is immutable and per-call, so it does not change global config defaults.

## Requirements

- PHP 8.2+
- Laravel 12+
- OpenAI API key.
