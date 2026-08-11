<?php

declare(strict_types=1);

namespace WpReload\Examples;

/**
 * FaqFormatter — простой класс-форматтер FAQ-данных.
 *
 * Принимает массив вопросов/ответов и умеет отдавать их
 * в виде обычного текста или простого HTML-списка.
 * Минимальный самостоятельный пример для демонстрации PHP в проекте.
 */
final class FaqFormatter
{
    /** @var array<int, array{question:string, answer:string}> */
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function toPlainText(): string
    {
        $lines = [];
        foreach ($this->items as $i => $item) {
            $lines[] = sprintf('%d. %s', $i + 1, $item['question']);
            $lines[] = '   ' . $item['answer'];
        }
        return implode("\n", $lines);
    }

    public function toHtmlList(): string
    {
        $html = "<dl>\n";
        foreach ($this->items as $item) {
            $question = htmlspecialchars($item['question'], ENT_QUOTES, 'UTF-8');
            $answer = htmlspecialchars($item['answer'], ENT_QUOTES, 'UTF-8');
            $html .= "  <dt>{$question}</dt>\n  <dd>{$answer}</dd>\n";
        }
        $html .= "</dl>\n";
        return $html;
    }
}
