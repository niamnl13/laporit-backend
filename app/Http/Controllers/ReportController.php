<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Admin & Operator: lihat semua laporan
    public function index()
    {
        $reports = Report::with('user')->latest()->get();
        return response()->json([
            'success' => true,
            'data' => $reports
        ]);
    }

    // User: buat laporan baru
    public function store(Request $request)
    {
        $request->validate([
            'jenis_kerusakan' => 'required|string',
            'deskripsi'       => 'required|string',
            'lokasi'          => 'nullable|string',
            'foto'            => 'nullable|image|max:2048',
            'priority'        => 'nullable|in:rendah,normal,tinggi,gawat',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_laporan', 'public');
        }

        $report = Report::create([
            'user_id' => $request->user()->id,
            'jenis_kerusakan' => $request->jenis_kerusakan,
            'deskripsi'       => $request->deskripsi,
            'lokasi'          => $request->lokasi,
            'foto'            => $fotoPath,
            'status'          => 'pending',
            'priority'        => $request->priority ?? 'normal',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil dikirim!',
            'data'    => $report
        ], 201);
    }

    // User: lihat laporan milik sendiri
    public function myReports(Request $request)
    {
        $reports = Report::where('user_id', $request->user()->id)->latest()->get();
        return response()->json([
            'success' => true,
            'data' => $reports
        ]);
    }

    // Operator & Admin: update status laporan
    public function updateStatus(Request $request, Report $report)
    {
        $request->validate([
            'status'       => 'required|in:pending,proses,selesai,ditolak',
            'tgl_eksekusi' => 'nullable|date',
        ]);

        $report->update([
            'status'       => $request->status,
            'tgl_eksekusi' => $request->tgl_eksekusi,
        ]);

        // Kalau operator ambil tugas, simpan operator_id
        if ($request->status === 'proses') {
            $updateData['operator_id'] = $request->user()->id;
        }

        $report->update($updateData);
        
        return response()->json([
            'success' => true,
            'message' => 'Status laporan diperbarui!',
            'data'    => $report
        ]);
    }

    // Admin: lihat semua user
    public function allUsers()
    {
        $users = User::select('id', 'name', 'email', 'role')->get();
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }
}