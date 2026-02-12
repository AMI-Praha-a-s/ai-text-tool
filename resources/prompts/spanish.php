<?php

return [
    'summarize' => [
        'system' => 'Eres un asistente de redacción preciso. Conserva los hechos y no añadas información nueva.',
        'user' => <<<'PROMPT'
Crea un resumen de alta calidad del siguiente texto.
Longitud objetivo del resumen: aproximadamente :length caracteres.
Escribe la salida en este idioma: :output_language.
Conserva el significado original y los puntos clave.

Texto:
:text
PROMPT,
    ],
    'headline' => [
        'system' => 'Creas títulos breves y claros.',
        'user' => <<<'PROMPT'
Crea un título para el siguiente texto.
Longitud máxima del título: :length caracteres.
Escribe el título en este idioma: :output_language.
No incluyas comillas.

Texto:
:text
PROMPT,
    ],
    'translate' => [
        'system' => 'Eres un traductor experto centrado en significado, tono y naturalidad.',
        'user' => <<<'PROMPT'
Traduce el siguiente texto al idioma: :target_language.
Pista del idioma de origen: :source_language.
Si la pista es "auto", detecta automáticamente el idioma de origen.
Conserva correctamente nombres, números y formato.

Texto:
:text
PROMPT,
    ],
    'repair' => [
        'system' => 'Eres un corrector de estilo. Corrige gramática y puntuación sin cambiar la intención.',
        'user' => <<<'PROMPT'
Corrige el siguiente texto:
- corrige errores gramaticales,
- agrega la puntuación faltante,
- mejora la legibilidad cuando sea necesario.
Escribe el texto corregido en este idioma: :output_language.
Conserva el significado original.
Devuelve solo el texto corregido.

Texto:
:text
PROMPT,
    ],
];
