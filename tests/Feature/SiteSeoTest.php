<?php

use App\Models\Berita;

test('homepage has canonical metadata and valid school structured data', function () {
    config(['seo.url' => 'https://ppsyafaaturrasul.com']);
    $response = $this->get('/?utm_source=test')->assertSuccessful();
    $response->assertSeeHtml('href="https://ppsyafaaturrasul.com"')
        ->assertDontSee('https://www.syafaaturrasul.com', false)
        ->assertDontSee('https://syafaaturrasul.com', false);
    $document = new DOMDocument;
    @$document->loadHTML('<?xml encoding="UTF-8">'.$response->getContent());
    $xpath = new DOMXPath($document);
    expect($xpath->query('//html')->item(0)->getAttribute('lang'))->toBe('id')
        ->and($xpath->query('//link[@rel="canonical"]')->item(0)->getAttribute('href'))->toBe('https://ppsyafaaturrasul.com/')
        ->and($xpath->query('//title')->item(0)->textContent)->toContain('Syafaaturrasul Kuansing');
    $schema = json_decode($xpath->query('//script[@type="application/ld+json"]')->item(0)->textContent, true, 512, JSON_THROW_ON_ERROR);
    expect($schema['@type'])->toBe('EducationalOrganization')
        ->and($schema['address']['addressLocality'])->toBe('Kuantan Singingi');
});

test('sitemap includes published articles and excludes drafts future articles and student services', function () {
    $published = Berita::factory()->published()->create(['published_at' => now()->subDay()]);
    $draft = Berita::factory()->create(['status' => 'draft']);
    $future = Berita::factory()->published()->create(['published_at' => now()->addDay()]);
    $response = $this->get('/sitemap.xml')->assertSuccessful()->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
    $xml = simplexml_load_string($response->getContent());
    $urls = array_map(fn ($entry) => (string) $entry->loc, iterator_to_array($xml->url, false));
    expect($urls)->toContain(rtrim(config('seo.url'), '/').route('berita.show', $published->slug, false))
        ->not->toContain(rtrim(config('seo.url'), '/').route('berita.show', $draft->slug, false))
        ->not->toContain(rtrim(config('seo.url'), '/').route('berita.show', $future->slug, false))
        ->not->toContain(rtrim(config('seo.url'), '/').'/psb');
    expect(count($urls))->toBe(6);
});

test('pagination keeps its own canonical and student search is noindex', function () {
    $this->get('/berita?page=2&utm_source=test')->assertSuccessful()
        ->assertSeeHtml('<link rel="canonical" href="'.rtrim(config('seo.url'), '/').'/berita?page=2">');
    $this->get('/psb')->assertSuccessful()->assertSeeHtml('<meta name="robots" content="noindex, follow">');
    expect(file_get_contents(public_path('robots.txt')))->toContain('Sitemap: https://ppsyafaaturrasul.com/sitemap.xml');
});
