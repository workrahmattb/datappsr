<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use DOMDocument;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $document = new DOMDocument('1.0', 'UTF-8');
        $root = $document->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9', 'urlset');
        $document->appendChild($root);
        $paths = [];
        foreach (['home', 'berita.index', 'fasilitas.index', 'guru.index', 'kontak.index'] as $name) {
            $paths[] = ['path' => route($name, [], false), 'modified' => null];
        }
        foreach (Berita::published()->where('published_at', '<=', now())->select(['slug', 'updated_at'])->cursor() as $berita) {
            $paths[] = ['path' => route('berita.show', ['slug' => $berita->slug], false), 'modified' => $berita->updated_at?->toAtomString()];
        }
        foreach ($paths as $path) {
            $entry = $document->createElement('url');
            $location = $document->createElement('loc');
            $location->appendChild($document->createTextNode(rtrim(config('seo.url'), '/').$path['path']));
            $entry->appendChild($location);
            if ($path['modified']) {
                $entry->appendChild($document->createElement('lastmod', $path['modified']));
            }
            $root->appendChild($entry);
        }

        return response($document->saveXML(), 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
