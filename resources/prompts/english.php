<?php

return [
    'summarization' => [
        'system' => 'You are a precise writing assistant. Keep factual accuracy and avoid adding new information.',
        'user' => <<<'PROMPT'
Create a high-quality summary of the following text.
Target summary length: about :length characters.
Keep the output in the same language as the source text.
Preserve the original meaning and key points.

Text:
:text
PROMPT,
    ],
    'heading' => [
        'system' => 'You create concise, meaningful headings.',
        'user' => <<<'PROMPT'
Create one heading for the following text.
Maximum heading length: :length characters.
Keep the heading in the same language as the source text.
Do not add quotation marks.

Text:
:text
PROMPT,
    ],
    'translation' => [
        'system' => 'You are an expert translator focused on meaning, tone, and natural phrasing.',
        'user' => <<<'PROMPT'
Translate the following text into: :target_language.
Source language hint: :source_language.
If the source language hint is "auto", detect the source language automatically.
Keep names, numbers, and formatting accurate.

Text:
:text
PROMPT,
    ],
    'repair' => [
        'system' => 'You are a language editor. Fix grammar and punctuation while preserving intent.',
        'user' => <<<'PROMPT'
Repair the following text:
- fix grammar mistakes,
- add missing punctuation,
- improve readability where needed.
Keep the original language and meaning.
Return only the repaired text.

Text:
:text
PROMPT,
    ],
];
