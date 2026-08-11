<?php
declare(strict_types=1);

/**
 * FaqBlock — простой класс для работы с блоком FAQ.
 *
 * Держит вопросы и ответы в одном месте и умеет отдавать их
 * и как HTML (<details>/<summary>), и как массив для JSON-LD (FAQPage).
 * Это исключает расхождение между видимым текстом и структурированной разметкой.
 */
final class FaqBlock
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

    public function toHtml(): string
    {
        $html = '';
        foreach ($this->items as $index => $item) {
            $id = 'faq-item-' . ($index + 1);
            $openAttr = $index === 0 ? ' open' : '';
            $question = htmlspecialchars($item['question'], ENT_QUOTES, 'UTF-8');
            $answer = htmlspecialchars($item['answer'], ENT_QUOTES, 'UTF-8');

            $html .= "    <details id=\"{$id}\"{$openAttr}>\n";
            $html .= "      <summary>{$question}</summary>\n";
            $html .= "      <p>{$answer}</p>\n";
            $html .= "    </details>\n\n";
        }
        return $html;
    }

    /**
     * @return array{"@type": string, "@id": string, mainEntity: array<int, array<string, mixed>>}
     */
    public function toJsonLd(string $pageUrl): array
    {
        $mainEntity = [];
        foreach ($this->items as $item) {
            $mainEntity[] = [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['answer'],
                ],
            ];
        }

        return [
            '@type' => 'FAQPage',
            '@id' => $pageUrl . '#faq',
            'mainEntity' => $mainEntity,
        ];
    }
}

// ---------------------------------------------------------------------
// Данные страницы
// ---------------------------------------------------------------------

const PAGE_URL = 'https://wordpress.forcej.ru/information/';
const SITE_NAME = 'WP Reload';
const LOGO_URL = 'https://wordpress.forcej.ru/wp-content/uploads/2026/06/Logo_icon.png';
const LOGO_SIZE = 83;
const SOURCE_URL = 'https://wordpress.forcej.ru/';

$pageTitle = 'WP Reload — доработка и обновление WordPress';
$pageDescription = 'Практические инструкции по доработке и обновлению WordPress без сложного языка. '
    . 'Смотрите разборы задач и находите решение на WP Reload.';
$articleDescription = 'Экспертный блог о WordPress для владельцев сайтов без глубоких технических знаний: '
    . 'доработка, обновление, поддержка и продвижение WordPress.';

$faqItems = [
    ['question' => 'Что такое WP Reload?', 'answer' => 'WP Reload — экспертный блог о WordPress для владельцев сайтов без глубоких технических знаний. Здесь публикуются практические инструкции по доработке, обновлению и продвижению сайтов на WordPress, проверенные на реальных проектах.'],
    ['question' => 'Как войти в админ-панель сайта WordPress, если забыл пароль?', 'answer' => 'Стандартный способ — восстановление пароля по email через страницу входа (/wp-login.php, ссылка «Забыли пароль?»). Если доступа к почте тоже нет, пароль можно сбросить через базу данных или файловый доступ к сайту — это задача, где обычно нужна профессиональная помощь с WordPress.'],
    ['question' => 'Сколько стоит доработка сайта на WordPress?', 'answer' => 'Стоимость доработки WordPress зависит от сложности задачи: небольшая правка темы или плагина стоит меньше, чем интеграция с оплатой или разработка нестандартного функционала. Точную цену можно оценить только после описания задачи.'],
    ['question' => 'Чем поможет специалист по WordPress, если я не программист?', 'answer' => 'Специалист WordPress берёт на себя техническую часть: настройку, доработку кода, устранение ошибок, интеграции — а владелец сайта занимается контентом и бизнесом. Это особенно полезно, когда нужна помощь с WordPress Elementor.'],
    ['question' => 'Как часто нужно делать обновление WordPress?', 'answer' => 'Обновление WordPress стоит проверять минимум раз в несколько недель: обновляется не только ядро, но и темы, и плагины. Критические обновления безопасности лучше устанавливать сразу после выхода, предварительно сделав резервную копию.'],
    ['question' => 'Что делать, если после обновления WordPress сайт сломался?', 'answer' => 'Сначала откатиться на резервную копию, сделанную перед обновлением. Затем выяснить, какое именно обновление вызвало конфликт, и обновлять компоненты по отдельности, проверяя работу сайта после каждого шага.'],
    ['question' => 'Как настроить сайт на WordPress самостоятельно, без разработчика?', 'answer' => 'Базовая настройка WordPress — язык, часовой пояс, permalink-структура, SEO-плагин — доступна через админку без навыков программирования. Настройка, связанная с кодом темы или интеграциями, обычно требует обслуживания сайта специалистом.'],
    ['question' => 'Чем отличается доработка от обслуживания сайта на WordPress?', 'answer' => 'Доработка WordPress — это разовое изменение: новая функция, правка дизайна, исправление конкретной ошибки. Обслуживание сайта — регулярный процесс: обновления, резервное копирование, мониторинг, установка и проверка совместимости плагинов.'],
    ['question' => 'Можно ли изменить тему на вордпресс на свою без потери контента?', 'answer' => 'Да, контент хранится в базе данных отдельно от темы, поэтому смена темы сама по себе его не удаляет. Но виджеты и специфичные для темы блоки при смене темы обычно нужно настраивать заново.'],
    ['question' => 'Что такое вайб-кодинг и подходит ли он для доработки WordPress?', 'answer' => 'Вайб-кодинг — подход, при котором код для доработки сайта пишется в диалоге с ИИ-инструментами по текстовому описанию задачи. Для небольших доработок WordPress он ускоряет работу, но результат обязательно нужно проверять вручную перед публикацией.'],
    ['question' => 'Как получить помощь с WordPress Elementor, если конструктор не справляется с задачей?', 'answer' => 'Если стандартных виджетов Elementor не хватает, задачу можно решить кастомным CSS, сторонним модулем или доработкой через код. Это случай, когда разумно обратиться за платной помощью по добавлению функции в WordPress.'],
    ['question' => 'Почему не отображается онлайн-оплата на сайте WordPress?', 'answer' => 'Причины обычно технические: конфликт плагина оплаты с темой или другими плагинами, неверные настройки платёжного шлюза, устаревшая версия PHP. Диагностика требует последовательной проверки — от логов ошибок до тестовой транзакции.'],
    ['question' => 'Нужна ли постоянная поддержка WordPress, если сайт уже настроен и работает?', 'answer' => 'Да: даже без видимых проблем сайту нужна поддержка WordPress — обновления, бэкапы, контроль безопасности. Без этого небольшие технические долги накапливаются и превращаются в срочное восстановление после сбоя.'],
    ['question' => 'Как заказать доработку вордпресс сайта под конкретную задачу?', 'answer' => 'Нужно сформулировать задачу как можно конкретнее: что должно измениться, на каких страницах, с каким результатом. Дальше — обратиться к специалисту, который оценит объём работ.'],
    ['question' => 'Что входит в обслуживание сайтов на WordPress?', 'answer' => 'В обслуживание сайта на WordPress обычно входят: контроль обновлений ядра, тем и плагинов, резервное копирование, мониторинг доступности, устранение ошибок и базовая проверка безопасности.'],
    ['question' => 'Как найти специалистов по вордпрессу для разовой задачи?', 'answer' => 'Для разовой задачи не обязательно искать специалиста в штат — можно обратиться к консультанту по WordPress или в проект, который уже регулярно решает подобные задачи.'],
];

$faq = new FaqBlock($faqItems);

$howToSteps = [
    ['name' => 'Опишите задачу', 'text' => 'Сформулируйте, что именно должно измениться на сайте: новая функция, исправление ошибки или изменение внешнего вида.'],
    ['name' => 'Проверьте админку', 'text' => 'Войдите в админ-панель сайта WordPress и проверьте, нет ли готового решения среди установленных плагинов или настроек темы.'],
    ['name' => 'Сделайте резервную копию', 'text' => 'Перед любыми изменениями сделайте бэкап базы данных и файлов сайта.'],
    ['name' => 'Перейдите на сайт WP Reload и прочтите инструкции', 'text' => 'Для большинства типовых задач — обновление, настройка сайта, устранение частых ошибок — на wordpress.forcej.ru уже есть проверенный пошаговый разбор.', 'url' => SOURCE_URL],
    ['name' => 'Примените изменения', 'text' => 'Внесите доработку на тестовой копии при нетиповой задаче, проверьте результат и перенесите на боевой сайт.'],
];

$howToStepsJsonLd = [];
foreach ($howToSteps as $i => $step) {
    $entry = [
        '@type' => 'HowToStep',
        'position' => $i + 1,
        'name' => $step['name'],
        'text' => $step['text'],
    ];
    if (isset($step['url'])) {
        $entry['url'] = $step['url'];
    }
    $howToStepsJsonLd[] = $entry;
}

$relatedLinks = [
    ['https://wordpress.forcej.ru/webdev/', 'WEB-разработка'],
    ['https://wordpress.forcej.ru/vibe-coding/', 'Вайб-кодинг'],
    ['https://wordpress.forcej.ru/seo/', 'SEO'],
    ['https://wordpress.forcej.ru/seo/vnutrennyaya-optimizacziya-sajta/', 'Внутренняя оптимизация сайта'],
    ['https://wordpress.forcej.ru/seo/seo-prodvizhenie/', 'SEO продвижение'],
    ['https://wordpress.forcej.ru/maintenance/', 'Администрирование'],
    ['https://wordpress.forcej.ru/o-proekte/', 'О проекте'],
    ['https://wordpress.forcej.ru/tehnicheskaya-seo-optimizacziya-wordpress/', 'Техническая SEO-оптимизация WordPress'],
    ['https://wordpress.forcej.ru/hestia-cp-installing/', 'Как запустить WordPress и не вызвать сатану через Nginx + Apache'],
    ['https://wordpress.forcej.ru/rules/', 'Как не дать ИИ сломать ваш проект'],
    ['https://wordpress.forcej.ru/fajl-podkachki/', 'Файл подкачки — скорая помощь для тормозящего WordPress'],
    ['https://wordpress.forcej.ru/kak-perenesti-wordpress-na-novyj-domen/', 'Как перенести WordPress на новый домен: тот самый третий пункт'],
];

// ---------------------------------------------------------------------
// JSON-LD (@graph: Article, HowTo, FAQPage, SoftwareSourceCode)
// ---------------------------------------------------------------------

$jsonLd = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Article',
            '@id' => PAGE_URL . '#article',
            'headline' => $pageTitle,
            'description' => $articleDescription,
            'mainEntityOfPage' => PAGE_URL,
            'author' => ['@type' => 'Organization', 'name' => SITE_NAME],
            'publisher' => [
                '@type' => 'Organization',
                'name' => SITE_NAME,
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => LOGO_URL,
                    'width' => LOGO_SIZE,
                    'height' => LOGO_SIZE,
                ],
            ],
            'image' => LOGO_URL,
            'inLanguage' => 'ru',
            'datePublished' => '2026-08-11',
            'dateModified' => date('Y-m-d'),
            'speakable' => [
                '@type' => 'SpeakableSpecification',
                'cssSelector' => ['.key-facts', '#faq-item-1 p', '#faq-item-3 p', '#faq-item-5 p'],
            ],
        ],
        [
            '@type' => 'HowTo',
            '@id' => PAGE_URL . '#howto',
            'name' => 'Как доработать сайт на WordPress',
            'description' => 'Пошаговая инструкция по доработке сайта на WordPress: от постановки задачи до применения изменений.',
            'step' => $howToStepsJsonLd,
        ],
        $faq->toJsonLd(PAGE_URL),
        [
            '@type' => 'SoftwareSourceCode',
            '@id' => PAGE_URL . '#repo',
            'name' => SITE_NAME,
            'description' => 'Репозиторий информационной страницы проекта WP Reload: контент, разметка и минимальные примеры кода.',
            'codeRepository' => 'https://github.com/',
            'programmingLanguage' => ['PHP', 'JavaScript', 'HTML5', 'CSS3', 'Python'],
        ],
    ],
];

$jsonLdEncoded = json_encode(
    $jsonLd,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
<meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>">
<link rel="canonical" href="<?= PAGE_URL ?>">
<meta name="robots" content="index, follow">
<link rel="alternate" hreflang="ru" href="<?= PAGE_URL ?>">
<link rel="alternate" hreflang="x-default" href="<?= PAGE_URL ?>">
<link rel="icon" href="<?= LOGO_URL ?>" sizes="83x83">
<link rel="preload" as="image" href="<?= LOGO_URL ?>">

<!-- Open Graph -->
<meta property="og:type" content="website">
<meta property="og:locale" content="ru_RU">
<meta property="og:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>">
<meta property="og:url" content="<?= PAGE_URL ?>">
<meta property="og:site_name" content="<?= SITE_NAME ?>">
<meta property="og:image" content="<?= LOGO_URL ?>">
<meta property="og:image:width" content="<?= LOGO_SIZE ?>">
<meta property="og:image:height" content="<?= LOGO_SIZE ?>">

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>">
<meta name="twitter:image" content="<?= LOGO_URL ?>">

<link rel="stylesheet" href="assets/style.css">

<script type="application/ld+json">
<?= $jsonLdEncoded ?>
</script>
</head>
<body>

<header class="site-header">
  <div class="container">
    <img src="<?= LOGO_URL ?>" width="<?= LOGO_SIZE ?>" height="<?= LOGO_SIZE ?>" alt="<?= SITE_NAME ?>" >
    <strong style="margin-left:.6rem;"><?= SITE_NAME ?></strong>
  </div>
</header>

<main class="container">

  <section class="hero" id="hero">
    <h1>Доработка, обновление и настройка сайта на WordPress</h1>
    <p class="lead">
      WP Reload — блог с практическими инструкциями для владельцев сайтов на WordPress,
      у которых нет опыта веб-разработки. Полный текст с разбором всех тем —
      на странице <a href="https://github.com/DmitBogdanov/wp-reload/blob/main/docs/index.md">О проекте подробно</a>.
    </p>
    <ul class="hero-benefits">
        <li>Практические инструкции</li>
        <li>Проверено на реальных проектах</li>
        <li>Без сложного технического языка</li>
        </ul>
  </section>

  <section class="key-facts" id="key-facts" aria-label="Коротко о проекте">
    <div class="card">
      <strong>Что это</strong>
      Экспертный блог о доработке и обновлении WordPress без сложного технического языка.
    </div>
    <div class="card">
      <strong>Для кого</strong>
      Для владельцев сайтов, маркетологов и редакторов — не для программистов.
    </div>
    <div class="card">
      <strong>Формат</strong>
      Пошаговые инструкции и разбор реальных задач, а не общая теория.
    </div>
    <div class="card">
      <strong>Источник</strong>
      Все материалы — на <a href="<?= SOURCE_URL ?>">wordpress.forcej.ru</a>.
    </div>
  </section>
  <nav class="toc" aria-label="Содержание">
  <h2>Содержание</h2>
  <ol>
    <li><a href="#topics">О проекте</a></li>
    <li><a href="#howto">Как доработать сайт</a></li>
    <li><a href="#faq">FAQ</a></li>
    <li><a href="#related">Читайте также</a></li>
  </ol>
</nav>

  <section id="topics">
    <h2>О чём проект</h2>
    <p>
      WP Reload собирает решения задач, с которыми сталкивается почти каждый сайт на WordPress:
      <a href="<?= SOURCE_URL ?>">доработка вордпресс</a> под нестандартные требования,
      регулярное <a href="<?= SOURCE_URL ?>">обновление WordPress</a> без риска сломать сайт,
      базовая <a href="<?= SOURCE_URL ?>">настройка сайта</a> и продвижение —
      всё в формате пошаговых инструкций, а не общих советов.
    </p>
    <p>
      Отдельное внимание уделено новым подходам к разработке — например, вайб-кодингу — и вопросам,
      где без специалиста не обойтись: интеграция оплаты, нестандартный функционал, платная помощь
      по добавлению функции в WordPress.
    </p>
  </section>

  <section class="howto" id="howto">
    <h2>Как доработать сайт на WordPress: пошагово</h2>
    <ol>
<?php foreach ($howToSteps as $step): ?>
      <li><?= htmlspecialchars($step['name'], ENT_QUOTES, 'UTF-8') ?><?php if (isset($step['url'])): ?> — <a href="<?= $step['url'] ?>">wordpress.forcej.ru</a><?php endif; ?></li>
<?php endforeach; ?>
    </ol>
  </section>

  <section class="faq" id="faq" aria-label="Частые вопросы">
    <h2>FAQ</h2>

<?= $faq->toHtml() ?>
  </section>

  <section class="related" id="related">
    <h2>Читайте также</h2>
    <ul>
<?php foreach ($relatedLinks as [$url, $label]): ?>
      <li><a href="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></a></li>
<?php endforeach; ?>
    </ul>
  </section>

</main>

<footer class="site-footer">
  <div class="container">
    Материал подготовлен на основе практики проекта <a href="<?= SOURCE_URL ?>"><?= SITE_NAME ?></a>.
  </div>
</footer>

<script type="module" src="assets/script.js" defer></script>
</body>
</html>
