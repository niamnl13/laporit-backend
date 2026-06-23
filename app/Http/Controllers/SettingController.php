<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'nama_sistem'       => Setting::get('nama_sistem', 'Lapor IT'),
                'is_2fa_enabled'    => Setting::get('is_2fa_enabled', '1') === '1',
                'is_email_notif'    => Setting::get('is_email_notif', '1') === '1',
                'is_push_notif'     => Setting::get('is_push_notif', '0') === '1',
            ],
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_sistem'    => 'sometimes|string',
            'is_2fa_enabled' => 'sometimes|boolean',
            'is_email_notif' => 'sometimes|boolean',
            'is_push_notif'  => 'sometimes|boolean',
        ]);

        if ($request->has('nama_sistem')) {
            Setting::set('nama_sistem', $request->nama_sistem);
        }
        if ($request->has('is_2fa_enabled')) {
            Setting::set('is_2fa_enabled', $request->is_2fa_enabled ? '1' : '0');
        }
        if ($request->has('is_email_notif')) {
            Setting::set('is_email_notif', $request->is_email_notif ? '1' : '0');
        }
        if ($request->has('is_push_notif')) {
            Setting::set('is_push_notif', $request->is_push_notif ? '1' : '0');
        }

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan berhasil disimpan',
        ]);
    }
}