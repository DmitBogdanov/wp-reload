#!/usr/bin/env python3
"""main.py — простой генератор sitemap.xml из списка URL.

Минимальный самостоятельный пример: берёт список страниц,
формирует валидный sitemap.xml по протоколу sitemaps.org.

Запуск:
    python3 main.py
"""

from __future__ import annotations

import datetime
import xml.etree.ElementTree as ET

SITEMAP_NS = "http://www.sitemaps.org/schemas/sitemap/0.9"

Url = tuple[str, str, float]  # (loc, changefreq, priority)

URLS: list[Url] = [
    ("https://wordpress.forcej.ru/information/", "monthly", 0.8),
    ("https://wordpress.forcej.ru/", "weekly", 1.0),
    ("https://wordpress.forcej.ru/o-proekte/", "yearly", 0.5),
]


def build_sitemap(urls: list[Url], lastmod: str | None = None) -> ET.Element:
    """Строит дерево ElementTree для sitemap.xml по списку URL."""
    lastmod = lastmod or datetime.date.today().isoformat()

    urlset = ET.Element("urlset", xmlns=SITEMAP_NS)
    for loc, changefreq, priority in urls:
        url_el = ET.SubElement(urlset, "url")
        ET.SubElement(url_el, "loc").text = loc
        ET.SubElement(url_el, "lastmod").text = lastmod
        ET.SubElement(url_el, "changefreq").text = changefreq
        ET.SubElement(url_el, "priority").text = f"{priority:.1f}"

    return urlset


def write_sitemap(urlset: ET.Element, path: str = "sitemap.xml") -> None:
    """Сохраняет дерево в файл с XML-декларацией."""
    tree = ET.ElementTree(urlset)
    ET.indent(tree, space="  ")
    tree.write(path, encoding="UTF-8", xml_declaration=True)


def main() -> None:
    urlset = build_sitemap(URLS)
    write_sitemap(urlset, "sitemap.xml")
    print(f"Сформирован sitemap.xml: {len(URLS)} URL")


if __name__ == "__main__":
    main()
