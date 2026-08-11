<?php

declare(strict_types=1);

require __DIR__ . '/src/FaqFormatter.php';

use WpReload\Examples\FaqFormatter;

$sampleFaq = [
    [
        'question' => 'Как часто нужно делать обновление WordPress?',
        'answer' => 'Ядро, темы и плагины стоит проверять минимум раз в несколько недель, делая резервную копию перед обновлением.',
    ],
    [
        'question' => 'Чем поможет специалист по WordPress?',
        'answer' => 'Специалист берёт на себя техническую доработку и настройку сайта, пока вы занимаетесь контентом и бизнесом.',
    ],
    [
        'question' => 'Что такое доработка сайта на WordPress?',
        'answer' => 'Разовое изменение функционала или дизайна сайта — в отличие от регулярного обслуживания и поддержки.',
    ],
];

$formatter = new FaqFormatter($sampleFaq);

if (PHP_SAPI === 'cli') {
    echo "Вопросов в примере: {$formatter->count()}\n\n";
    echo $formatter->toPlainText() . "\n";
} else {
    header('Content-Type: text/html; charset=utf-8');
    echo "<h1>Пример: FaqFormatter</h1>\n";
    echo $formatter->toHtmlList();
}
