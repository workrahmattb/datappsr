<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#b8d8cf] min-h-screen flex justify-center py-10 px-4">

    <div class="w-full max-w-2xl space-y-6">
        <!-- NISN -->
        <div class="bg-white rounded-xl shadow p-6">
            <label class="block text-gray-900 font-semibold">
                NISN (Nomor Induk Siswa Nasional) <span class="text-red-600">*</span>
            </label>
            <p class="italic text-gray-600 text-sm mt-1">
                NISN ada 10 digit, bisa dilihat di
                <a href="#" class="text-blue-600 underline hover:text-blue-800">cek NISN</a>
            </p>
            <input type="text" placeholder="Your answer"
                class="w-full border-b border-gray-300 mt-3 pb-1 focus:border-blue-500 focus:outline-none text-gray-800 placeholder-gray-400" />
        </div>

        <!-- Nama Lengkap -->
        <div class="bg-white rounded-xl shadow p-6">
            <label class="block text-gray-900 font-semibold uppercase">
                Nama Lengkap Peserta Didik <span class="text-red-600">*</span>
            </label>
            <p class="italic text-gray-600 text-sm mt-1">
                Isi nama lengkap sesuai ijazah
            </p>
            <input type="text" placeholder="Your answer"
                class="w-full border-b border-gray-300 mt-3 pb-1 focus:border-blue-500 focus:outline-none text-gray-800 placeholder-gray-400" />
        </div>

        <!-- Jenis Kelamin -->
        <div class="bg-white rounded-xl shadow p-6">
            <label class="block text-gray-900 font-semibold uppercase">
                Jenis Kelamin <span class="text-red-600">*</span>
            </label>
            <p class="italic text-gray-600 text-sm mt-1">
                Pilih salah satu
            </p>
            <select
                class="w-full border-b border-gray-300 mt-3 pb-1 focus:border-blue-500 focus:outline-none text-gray-800 bg-transparent">
                <option value="">Your answer</option>
                <option>Laki-laki</option>
                <option>Perempuan</option>
            </select>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end pt-4">
            <button class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                Kirim
            </button>
        </div>
    </div>

</body>

</html>
