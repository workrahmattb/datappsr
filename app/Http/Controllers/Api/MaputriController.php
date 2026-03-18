<?php

namespace App\Http\Controllers\Api;

use App\Models\Maputri;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaputriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $search = $request->get('search');
        $tahunAjaran = $request->get('tahun_ajaran');
        $kelasId = $request->get('kelas_id');

        $query = Maputri::query();

        // Include kelas relationship if requested
        if ($request->get('with_kelas')) {
            $query->with('kelas');
        }

        // Search functionality
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Filter by tahun ajaran
        if ($tahunAjaran) {
            $query->where('tahun_ajaran', $tahunAjaran);
        }

        // Filter by kelas
        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $data = $query->latest()->paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Data MA Putri berhasil diambil',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nisn' => 'nullable|string|min:10|max:10',
            'nis' => 'nullable|string|max:50',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'tahun_ajaran' => 'nullable|string|max:20',
            'kelas_id' => 'nullable|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $maputri = Maputri::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data MA Putri berhasil ditambahkan',
                'data' => $maputri
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $query = Maputri::query();

        // Include kelas relationship if requested
        if ($request->get('with_kelas')) {
            $query->with('kelas');
        }

        $maputri = $query->find($id);

        if (!$maputri) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data MA Putri berhasil diambil',
            'data' => $maputri
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $maputri = Maputri::find($id);

        if (!$maputri) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|required|string|max:255',
            'tempat_lahir' => 'sometimes|required|string|max:255',
            'tanggal_lahir' => 'sometimes|required|date',
            'nisn' => 'nullable|string|min:10|max:10',
            'nis' => 'nullable|string|max:50',
            'nama_ayah' => 'sometimes|required|string|max:255',
            'nama_ibu' => 'sometimes|required|string|max:255',
            'tahun_ajaran' => 'nullable|string|max:20',
            'kelas_id' => 'nullable|exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $maputri->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data MA Putri berhasil diupdate',
                'data' => $maputri->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $maputri = Maputri::find($id);

        if (!$maputri) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        try {
            $maputri->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data MA Putri berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
