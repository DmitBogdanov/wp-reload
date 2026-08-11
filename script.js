// script.js — ES-модуль. Подключается через <script type="module" src="assets/script.js" defer></script>

/**
 * Открывает первый FAQ-пункт по умолчанию, чтобы блок не выглядел пустым при первом рендере.
 */
function openFirstFaqItem() {
  const firstDetails = document.querySelector(".faq details");
  if (firstDetails) {
    firstDetails.open = true;
  }
}

/**
 * Подсвечивает пункт оглавления, соответствующий разделу, видимому в текущей области экрана.
 */
function highlightActiveTocLink() {
  const sections = document.querySelectorAll("section[id]");
  const tocLinks = document.querySelectorAll(".toc a[href^='#']");

  if (!sections.length || !tocLinks.length) {
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        const link = document.querySelector(`.toc a[href="#${entry.target.id}"]`);
        if (!link) {
          return;
        }
        if (entry.isIntersecting) {
          tocLinks.forEach((l) => l.classList.remove("active"));
          link.classList.add("active");
        }
      });
    },
    { rootMargin: "-40% 0px -50% 0px" }
  );

  sections.forEach((section) => observer.observe(section));
}

function init() {
  openFirstFaqItem();
  highlightActiveTocLink();
}

document.addEventListener("DOMContentLoaded", init);

export { openFirstFaqItem, highlightActiveTocLink };
