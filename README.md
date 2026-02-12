# AmiPraha AiTextTool

`AmiPraha\AiTextTool` is a Laravel package for AI-powered text operations backed by the Laravel AI SDK.

## Features

- Text summarization with requested output length.
- Heading generation with requested max length.
- Translation with target language and optional source language hint.
- Text repair (grammar, punctuation, readability improvements).
- Native prompt packs for multiple languages to improve output quality with non-English source text.

## Supported Prompt Languages

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

Optional: publish prompt files so you can customize them:

```bash
php artisan vendor:publish --tag=ai-text-tool-prompts
```

## Configuration

File: `config/ai-text-tool.php`

- `default_prompt_language`: default prompt language used by package.
- `custom_prompt_path`: optional directory with language prompt files that override package prompts.
- `provider`, `model`, `timeout`: forwarded to Laravel AI SDK request options.

Example:

```php
return [
    'default_prompt_language' => 'english',
    'custom_prompt_path' => resource_path('ai-text-tool/prompts'),
    'provider' => null,
    'model' => null,
    'timeout' => 60,
];
```

## Usage

```php
use AmiPraha\AiTextTool\Facades\AiTextTool;

$summary = AiTextTool::summarization($sourceText, 450);
$heading = AiTextTool::heading($sourceText, 50);
$translation = AiTextTool::translation($sourceText, 'slovak', 'czech');
$repaired = AiTextTool::repair($sourceText);
```

### Fluent per-call prompt language override

```php
$summary = AiTextTool::inPromptLanguage('czech')->summarization($sourceText, 450);
$heading = AiTextTool::inPromptLanguage('german')->heading($sourceText, 50);
```

The override is immutable and per-call, so it does not change global config defaults.

## Requirements

- PHP 8.2+
- Laravel 12+
- `laravel/ai` package configured with at least one provider API key.
