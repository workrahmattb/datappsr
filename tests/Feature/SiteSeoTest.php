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
    expect(count($urls))->toBe(7);
});

test('pagination keeps its own canonical and student search is noindex', function () {
    $this->get('/berita?page=2&utm_source=test')->assertSuccessful()
        ->assertSeeHtml('<link rel="canonical" href="'.rtrim(config('seo.url'), '/').'/berita?page=2">');
    $this->get('/psb')->assertSuccessful()->assertSeeHtml('<meta name="robots" content="noindex, follow">');
    expect(file_get_contents(public_path('robots.txt')))->toContain('Sitemap: https://ppsyafaaturrasul.com/sitemap.xml');
});

test('production domain redirects preserve paths and queries without looping', function () {
    config(['seo.redirect_domain' => true, 'seo.url' => 'https://ppsyafaaturrasul.com']);
    $middleware = new \App\Support\CanonicalDomain;
    $next = fn () => response('ok');
    foreach (['http://ppsyafaaturrasul.com', 'https://www.ppsyafaaturrasul.com'] as $origin) {
        $response = $middleware->handle(\Illuminate\Http\Request::create($origin.'/berita?page=2'), $next);
        expect($response->getStatusCode())->toBe(301)
            ->and($response->headers->get('Location'))->toBe('https://ppsyafaaturrasul.com/berita?page=2');
    }
    foreach (['https://ppsyafaaturrasul.com', 'http://localhost'] as $origin) {
        expect($middleware->handle(\Illuminate\Http\Request::create($origin.'/'), $next)->getStatusCode())->toBe(200);
    }
    expect($middleware->handle(\Illuminate\Http\Request::create('http://ppsyafaaturrasul.com/pendaftaran', 'POST'), $next)->getStatusCode())->toBe(308);
    config(['seo.redirect_domain' => false]);
    expect($middleware->handle(\Illuminate\Http\Request::create('http://ppsyafaaturrasul.com/'), $next)->getStatusCode())->toBe(200);
});

test('legacy and development pages no longer serve public test content', function () {
    $this->get('/beranda')->assertStatus(301)->assertRedirect('/');
    $this->get('/lagibelajar')->assertNotFound();
});

test('registration has Indonesian metadata and appears in sitemap', function () {
    $this->get('/pendaftaran')->assertSuccessful()
        ->assertSeeHtml('<html lang="id">')
        ->assertSee('Pendaftaran Santri Baru MTs &amp; MA | Syafaaturrasul Kuansing', false)
        ->assertSeeHtml('<link rel="canonical" href="'.rtrim(config('seo.url'), '/').'/pendaftaran">')
        ->assertSeeHtml('<meta name="description"');
    $this->get('/sitemap.xml')->assertSee('/pendaftaran');
});

test('future news stays unavailable until publication and public pagination has links', function () {
    $future = Berita::factory()->published()->create(['published_at' => now()->addDay()]);
    Berita::factory()->published()->count(10)->create();
    $this->get(route('berita.show', $future->slug))->assertNotFound();
    $this->get('/')->assertDontSee($future->judul);
    $response = $this->get('/berita')->assertSuccessful()->assertDontSee($future->judul);
    preg_match_all('/href="([^"]+)"[^>]*rel="next"/', $response->getContent(), $matches);
    expect($matches[1])->toContain(route('berita.index').'?page=2');
    $this->get('/berita?page=2')->assertSuccessful()->assertSee('Halaman 2 dari 2');
    $this->travel(2)->days();
    $this->get(route('berita.show', $future->slug))->assertSuccessful();
});

test('article structured data reflects the published article', function () {
    $article = Berita::factory()->published()->create();
    $response = $this->get(route('berita.show', $article->slug))->assertSuccessful();
    $document = new DOMDocument;
    @$document->loadHTML('<?xml encoding="UTF-8">'.$response->getContent());
    $xpath = new DOMXPath($document);
    $schema = json_decode($xpath->query('//script[@type="application/ld+json"]')->item(0)->textContent, true, 512, JSON_THROW_ON_ERROR);
    expect($schema['@type'])->toBe('NewsArticle')->and($schema['headline'])->toBe($article->judul);
});
