<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

/**
 * Whitelist based HTML sanitizer for rich text content.
 *
 * Only a small, explicit set of tags/attributes is kept; everything else is
 * either unwrapped (content preserved) or removed entirely for inherently
 * dangerous elements (script, iframe, ...). URL attributes are limited to
 * http/https/mailto/tel plus relative links.
 *
 * Implemented without an external dependency so no new package is required.
 */
class HtmlSanitizer
{
    /**
     * Tags that may be kept, together with their inner content.
     *
     * @var list<string>
     */
    private const ALLOWED_TAGS = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'strike', 'sub', 'sup',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'ul', 'ol', 'li',
        'blockquote', 'pre', 'code',
        'a', 'img', 'hr',
        'span', 'div',
    ];

    /**
     * Attributes allowed per tag. Everything else (including inline style and
     * all on* event handlers) is removed.
     *
     * @var array<string, list<string>>
     */
    private const ALLOWED_ATTRIBUTES = [
        'a' => ['href', 'title', 'target', 'rel'],
        'img' => ['src', 'alt', 'title', 'width', 'height'],
    ];

    /**
     * Tags that must be dropped completely, including their content.
     *
     * @var list<string>
     */
    private const DANGEROUS_TAGS = [
        'script', 'style', 'iframe', 'frame', 'frameset', 'object', 'embed',
        'applet', 'form', 'input', 'button', 'select', 'option', 'textarea',
        'svg', 'math', 'link', 'meta', 'base', 'noscript', 'template', 'title',
    ];

    /**
     * Allowed URL schemes for href/src attributes.
     *
     * @var list<string>
     */
    private const ALLOWED_SCHEMES = ['http', 'https', 'mailto', 'tel'];

    /**
     * Sanitize an HTML fragment, returning only whitelisted markup.
     */
    public static function clean(?string $html): string
    {
        $html = (string) $html;

        if (trim($html) === '') {
            return '';
        }

        $previousErrors = libxml_use_internal_errors(true);

        $document = new DOMDocument('1.0', 'UTF-8');
        $document->loadHTML(
            '<?xml encoding="UTF-8"><div id="sanitizer-root">'.$html.'</div>',
            LIBXML_HTML_NODEFDTD
        );

        libxml_clear_errors();
        libxml_use_internal_errors($previousErrors);

        $root = self::findRoot($document);

        if (! $root) {
            return '';
        }

        self::sanitizeChildren($root);

        $result = '';

        foreach ($root->childNodes as $child) {
            $result .= (string) $document->saveHTML($child);
        }

        return trim($result);
    }

    /**
     * Locate the wrapper element used to hold the fragment.
     */
    private static function findRoot(DOMDocument $document): ?DOMElement
    {
        foreach ($document->getElementsByTagName('div') as $div) {
            if ($div->getAttribute('id') === 'sanitizer-root') {
                return $div;
            }
        }

        return null;
    }

    /**
     * Walk the children of the given node and sanitize them in place.
     */
    private static function sanitizeChildren(DOMNode $node): void
    {
        $children = [];

        foreach ($node->childNodes as $child) {
            $children[] = $child;
        }

        foreach ($children as $child) {
            if (! $child instanceof DOMElement) {
                continue;
            }

            $tag = strtolower($child->nodeName);

            if (in_array($tag, self::DANGEROUS_TAGS, true)) {
                $node->removeChild($child);

                continue;
            }

            if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                self::sanitizeChildren($child);
                self::unwrap($child);

                continue;
            }

            self::cleanAttributes($child, $tag);
            self::sanitizeChildren($child);
        }
    }

    /**
     * Replace an element with its own children (used for unknown tags).
     */
    private static function unwrap(DOMElement $element): void
    {
        $parent = $element->parentNode;

        if (! $parent) {
            return;
        }

        while ($element->firstChild) {
            $parent->insertBefore($element->firstChild, $element);
        }

        $parent->removeChild($element);
    }

    /**
     * Remove every attribute that is not explicitly allowed.
     */
    private static function cleanAttributes(DOMElement $element, string $tag): void
    {
        $allowed = self::ALLOWED_ATTRIBUTES[$tag] ?? [];

        $names = [];

        foreach ($element->attributes as $attribute) {
            $names[] = $attribute->nodeName;
        }

        foreach ($names as $name) {
            $lower = strtolower($name);

            if (str_starts_with($lower, 'on') || ! in_array($lower, $allowed, true)) {
                $element->removeAttribute($name);

                continue;
            }

            if (in_array($lower, ['href', 'src'], true)
                && ! self::isSafeUrl((string) $element->getAttribute($name))) {
                $element->removeAttribute($name);
            }
        }

        if ($tag === 'a' && $element->hasAttribute('href')) {
            $element->setAttribute('rel', 'noopener noreferrer');
        }
    }

    /**
     * Extract a safe URL from an admin-supplied embed snippet (mis. kode embed
     * Google Maps). Hanya URL-nya yang dipakai — HTML mentah tidak pernah
     * dirender di halaman publik.
     */
    public static function embedUrl(?string $html): ?string
    {
        $snippet = trim((string) $html);

        if ($snippet === '') {
            return null;
        }

        if (preg_match('/src\s*=\s*["\']([^"\']+)["\']/i', $snippet, $matches) === 1) {
            $snippet = html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        $snippet = trim($snippet);

        return self::isSafeUrl($snippet) ? $snippet : null;
    }

    /**
     * Determine whether a URL is safe to keep in href/src (also used by
     * models that store a link, e.g. Carousel).
     */
    public static function isSafeUrl(string $url): bool
    {
        $url = trim($url);

        if ($url === '') {
            return false;
        }

        // Normalize away entities and control/whitespace characters that are
        // commonly used to smuggle schemes (e.g. "java&#09;script:").
        $normalized = strtolower((string) preg_replace(
            '/[\x00-\x20]+/',
            '',
            html_entity_decode($url, ENT_QUOTES | ENT_HTML5, 'UTF-8')
        ));

        foreach (['javascript:', 'vbscript:', 'data:', 'file:'] as $blocked) {
            if (str_starts_with($normalized, $blocked)) {
                return false;
            }
        }

        if (str_starts_with($normalized, '/')
            || str_starts_with($normalized, '#')
            || str_starts_with($normalized, '?')) {
            return true;
        }

        $scheme = parse_url($normalized, PHP_URL_SCHEME);

        if (! is_string($scheme) || $scheme === '') {
            return true;
        }

        return in_array($scheme, self::ALLOWED_SCHEMES, true);
    }
}
