<ul class="flex flex-col gap-3" aria-label="Kontak resmi pesantren">
    @foreach (config('pesantren.contacts') as $contact)
        <li>
            <span class="block font-semibold">{{ $contact['name'] }}</span>
            <a href="tel:{{ $contact['international'] }}" class="underline underline-offset-4 hover:no-underline"
                aria-label="Telepon {{ $contact['name'] }} di {{ $contact['phone'] }}">{{ $contact['phone'] }}</a>
        </li>
    @endforeach
</ul>
