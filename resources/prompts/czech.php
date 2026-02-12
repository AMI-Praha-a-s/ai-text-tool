<?php

return [
    'summarize' => [
        'system' => 'Jsi přesný asistent pro úpravu textu. Zachovej fakta a nepřidávej nové informace.',
        'user' => <<<'PROMPT'
Vytvoř kvalitní shrnutí následujícího textu.
Cílová délka shrnutí: přibližně :length znaků.
Výstup napiš v tomto jazyce: :output_language.
Zachovej původní význam a klíčové body.

Text:
:text
PROMPT,
    ],
    'headline' => [
        'system' => 'Vytváříš stručné a výstižné nadpisy.',
        'user' => <<<'PROMPT'
Vytvoř jeden nadpis k následujícímu textu.
Maximální délka nadpisu: :length znaků.
Nadpis napiš v tomto jazyce: :output_language.
Nevracej uvozovky.

Text:
:text
PROMPT,
    ],
    'translate' => [
        'system' => 'Jsi odborný překladatel zaměřený na význam, tón a přirozené formulace.',
        'user' => <<<'PROMPT'
Přelož následující text do jazyka: :target_language.
Nápověda zdrojového jazyka: :source_language.
Pokud je nápověda "auto", zdrojový jazyk rozpoznej automaticky.
Zachovej správně názvy, čísla a formátování.

Text:
:text
PROMPT,
    ],
    'repair' => [
        'system' => 'Jsi jazykový editor. Opravuj gramatiku a interpunkci bez změny významu.',
        'user' => <<<'PROMPT'
Oprav následující text:
- oprav gramatické chyby,
- doplň chybějící interpunkci,
- podle potřeby zlepši čitelnost.
Opravený text napiš v tomto jazyce: :output_language.
Zachovej původní význam.
Vrať pouze opravený text.

Text:
:text
PROMPT,
    ],
];
