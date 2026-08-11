// script.js — ES-модуль. Подключается через <script type="module" src="../js/script.js">.
// Минимальный самостоятельный пример: подсвечивает в TOC пункт,
// соответствующий разделу, видимому в текущей области экрана.

/**
 * @param {NodeListOf<Element>} sections
 * @param {NodeListOf<Element>} tocLinks
 * @param {Element|null} label
 */
export function highlightActiveSection(sections, tocLinks, label) {
  if (!sections.length || !tocLinks.length) {
    return null;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          return;
        }
        const link = document.querySelector(`nav a[href="#${entry.target.id}"]`);
        tocLinks.forEach((l) => l.classList.remove("active"));
        if (link) {
          link.classList.add("active");
        }
        if (label) {
          label.textContent = `Активный раздел: ${entry.target.id}`;
        }
      });
    },
    { rootMargin: "-40% 0px -50% 0px" }
  );

  sections.forEach((section) => observer.observe(section));
  return observer;
}

function init() {
  const sections = document.querySelectorAll("article[id]");
  const tocLinks = document.querySelectorAll("nav a[href^='#']");
  const label = document.querySelector("#active-section-label");
  highlightActiveSection(sections, tocLinks, label);
}

document.addEventListener("DOMContentLoaded", init);
