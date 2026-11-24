<?php

use App\Models\Pendaftaran;
use App\Support\AdmissionPeriod;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new #[Layout('layouts.public')] #[Title('Rekap Pendaftaran — PPSR')] class extends Component
{
    use WithPagination;

    public function with(): array
    {
        $year = AdmissionPeriod::year();
        $query = Pendaftaran::query()->where('tahun_ajaran', $year);
        $counts = (clone $query)->select('jenjang_pendidikan')
            ->selectRaw('COUNT(*) as jumlah')->groupBy('jenjang_pendidikan')->pluck('jumlah', 'jenjang_pendidikan');

        return [
            'year' => $year,
            'total' => $counts->sum(),
            'counts' => $counts,
            'levels' => ['MTs Putra', 'MTs Putri', 'MA Putra', 'MA Putri'],
            'registrations' => $query->select(['id', 'nama', 'jenjang_pendidikan', 'nama_sekolah_sebelumnya', 'asal_sekolah'])->orderByDesc('id')->paginate(25),
        ];
    }
}; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col gap-3 mb-8">
        <a href="{{ route('psb') }}" wire:navigate class="text-sm text-green-700 dark:text-green-400">Kembali ke PSB</a>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Rekap Pendaftaran</h1>
        <p class="text-gray-600 dark:text-gray-400">Tahun ajaran {{ $year }}</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="rounded-xl bg-green-700 text-white p-5">
            <p>Total pendaftar</p>
            <p class="text-3xl font-bold mt-2">{{ number_format($total, 0, ',', '.') }}</p>
        </div>
        @foreach ($levels as $level)
            <div class="rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-5" wire:key="count-{{ $loop->index }}">
                <p class="text-gray-600 dark:text-gray-400">{{ $level }}</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $counts[$level] ?? 0 }}</p>
            </div>
        @endforeach
    </div>
    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 dark:bg-gray-900 text-gray-600 dark:text-gray-300">
                <tr><th scope="col" class="px-6 py-4">No.</th><th scope="col" class="px-6 py-4">Nama</th><th scope="col" class="px-6 py-4">Jenjang Pendidikan</th><th scope="col" class="px-6 py-4">Asal Sekolah</th></tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-gray-100">
                @forelse ($registrations as $registration)
                    <tr wire:key="registration-{{ $registration->id }}">
                        <td class="px-6 py-4">{{ $registrations->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-4 font-medium">{{ $registration->nama }}</td>
                        <td class="px-6 py-4">{{ $registration->jenjang_pendidikan }}</td>
                        <td class="px-6 py-4">{{ $registration->nama_sekolah_sebelumnya ?: ($registration->asal_sekolah ?: '-') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-10 text-center text-gray-500">Belum ada pendaftaran pada tahun ajaran ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $registrations->links() }}</div>
</div>
