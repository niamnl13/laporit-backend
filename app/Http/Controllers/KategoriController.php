<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Kategori::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|unique:kategoris,nama']);

        $kategori = Kategori::create(['nama' => $request->nama]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $kategori,
        ], 201);
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate(['nama' => 'required|string|unique:kategoris,nama,' . $kategori->id]);

        $kategori->update(['nama' => $request->nama]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui',
            'data' => $kategori,
        ]);
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus',
        ]);
    }
}