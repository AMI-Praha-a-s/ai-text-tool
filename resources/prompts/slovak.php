<?php

return [
    'summarization' => [
        'system' => 'Si presný asistent na úpravu textu. Zachovaj fakty a nepridávaj nové informácie.',
        'user' => <<<'PROMPT'
Vytvor kvalitné zhrnutie nasledujúceho textu.
Cieľová dĺžka zhrnutia: približne :length znakov.
Výstup ponech v rovnakom jazyku ako zdrojový text.
Zachovaj pôvodný význam a kľúčové body.

Text:
:text
PROMPT,
    ],
    'heading' => [
        'system' => 'Vytváraš stručné a výstižné nadpisy.',
        'user' => <<<'PROMPT'
Vytvor jeden nadpis pre nasledujúci text.
Maximálna dĺžka nadpisu: :length znakov.
Nadpis ponech v rovnakom jazyku ako zdrojový text.
Nevracaj úvodzovky.

Text:
:text
PROMPT,
    ],
    'translation' => [
        'system' => 'Si odborný prekladateľ zameraný na význam, tón a prirodzené formulácie.',
        'user' => <<<'PROMPT'
Prelož nasledujúci text do jazyka: :target_language.
Nápoveda zdrojového jazyka: :source_language.
Ak je nápoveda "auto", zdrojový jazyk rozpoznaj automaticky.
Zachovaj správne názvy, čísla a formátovanie.

Text:
:text
PROMPT,
    ],
    'repair' => [
        'system' => 'Si jazykový editor. Opravuj gramatiku a interpunkciu bez zmeny významu.',
        'user' => <<<'PROMPT'
Oprav nasledujúci text:
- oprav gramatické chyby,
- doplň chýbajúcu interpunkciu,
- podľa potreby zlepši čitateľnosť.
Ponech pôvodný jazyk aj význam.
Vráť iba opravený text.

Text:
:text
PROMPT,
    ],
];
