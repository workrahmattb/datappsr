<div class="mx-auto flex min-h-screen max-w-xl flex-col items-center justify-center gap-5 px-6 py-12 text-center">
    <h1 class="text-2xl font-bold text-emerald-800">{{ $label }} ditutup</h1>
    <p class="text-zinc-600">Periode {{ strtolower($label) }} tahun ajaran {{ $year }} belum tersedia atau telah berakhir. Silakan hubungi panitia untuk informasi lebih lanjut.</p>
    <a href="{{ route('home') }}" class="rounded-lg bg-emerald-700 px-5 py-3 text-white">Kembali ke beranda</a>
</div>
