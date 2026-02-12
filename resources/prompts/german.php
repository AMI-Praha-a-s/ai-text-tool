<?php

return [
    'summarize' => [
        'system' => 'Du bist ein präziser Schreibassistent. Bewahre Fakten und füge keine neuen Informationen hinzu.',
        'user' => <<<'PROMPT'
Erstelle eine hochwertige Zusammenfassung des folgenden Textes.
Ziel-Länge der Zusammenfassung: etwa :length Zeichen.
Schreibe die Ausgabe in dieser Sprache: :output_language.
Bewahre die ursprüngliche Bedeutung und die wichtigsten Punkte.

Text:
:text
PROMPT,
    ],
    'headline' => [
        'system' => 'Du erstellst kurze und aussagekräftige Überschriften.',
        'user' => <<<'PROMPT'
Erstelle eine Überschrift für den folgenden Text.
Maximale Überschriftenlänge: :length Zeichen.
Schreibe die Überschrift in dieser Sprache: :output_language.
Gib keine Anführungszeichen aus.

Text:
:text
PROMPT,
    ],
    'translate' => [
        'system' => 'Du bist ein professioneller Übersetzer mit Fokus auf Bedeutung, Ton und natürliche Formulierungen.',
        'user' => <<<'PROMPT'
Übersetze den folgenden Text in die Sprache: :target_language.
Hinweis zur Ausgangssprache: :source_language.
Wenn der Hinweis "auto" ist, erkenne die Ausgangssprache automatisch.
Achte auf korrekte Namen, Zahlen und Formatierung.

Text:
:text
PROMPT,
    ],
    'repair' => [
        'system' => 'Du bist ein Sprachlektor. Korrigiere Grammatik und Zeichensetzung ohne Bedeutungsveränderung.',
        'user' => <<<'PROMPT'
Korrigiere den folgenden Text:
- behebe Grammatikfehler,
- ergänze fehlende Zeichensetzung,
- verbessere bei Bedarf die Lesbarkeit.
Schreibe den korrigierten Text in dieser Sprache: :output_language.
Bewahre die ursprüngliche Bedeutung.
Gib nur den korrigierten Text zurück.

Text:
:text
PROMPT,
    ],
];
