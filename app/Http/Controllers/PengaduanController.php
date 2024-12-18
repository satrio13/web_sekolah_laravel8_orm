<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PengaduanModel;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    function index()
    {     
        $data['titleweb'] = 'Layanan Pengaduan - '.title();
        $data['title'] = 'Layanan Pengaduan';
        return view('pengaduan.index', $data);
    }

    function simpan_pengaduan(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:50',
            'status' => 'required',
            'isi' => 'required'
        ]);

        PengaduanModel::create($validated);
        return redirect()->route('pengaduan')->with(['success' => 'TERIMAKASIH, DATA BERHASIL DIKIRIM']);
    }

}