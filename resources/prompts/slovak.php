<?php

return [
    'summarize' => [
        'system' => 'Si presný asistent na úpravu textu. Zachovaj fakty a nepridávaj nové informácie.',
        'user' => <<<'PROMPT'
Vytvor kvalitné zhrnutie nasledujúceho textu.
Cieľová dĺžka zhrnutia: približne :length znakov.
Výstup napíš v tomto jazyku: :output_language.
Zachovaj pôvodný význam a kľúčové body.

Text:
:text
PROMPT,
    ],
    'headline' => [
        'system' => 'Vytváraš stručné a výstižné nadpisy.',
        'user' => <<<'PROMPT'
Vytvor jeden nadpis pre nasledujúci text.
Maximálna dĺžka nadpisu: :length znakov.
Nadpis napíš v tomto jazyku: :output_language.
Nevracaj úvodzovky.

Text:
:text
PROMPT,
    ],
    'translate' => [
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
Opravený text napíš v tomto jazyku: :output_language.
Zachovaj pôvodný význam.
Vráť iba opravený text.

Text:
:text
PROMPT,
    ],
];
