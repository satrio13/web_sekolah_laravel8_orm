<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KurikulumModel;
use App\Models\RekapUNModel;
use App\Models\RekapUSModel;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    function index()
    {     
        $data['title'] = 'Kurikulum';
        $data['data'] = KurikulumModel::latest()->get();
        return view('admin.kurikulum.index', $data);
    }

    function tambah_kurikulum()
    {     
        $data['title'] = 'Tambah Kurikulum';
        return view('admin.kurikulum.form_tambah', $data);
    }

    function simpan_kurikulum(Request $request)
    {
        $validated = $request->validate([
            'mapel' => 'required|max:50',
            'alokasi' => 'required|numeric',
            'kelompok' => 'required|max:5',
            'no_urut' => 'required|numeric',
            'is_active' => 'required|numeric'
        ]);

        KurikulumModel::create($validated);
        return redirect()->route('backend/kurikulum')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_kurikulum($id)
    {   
        $kurikulum = KurikulumModel::findOrFail($id);
        $data['title'] = 'Edit Kurikulum';
        $data['data'] = $kurikulum;
        return view('admin.kurikulum.form_edit', $data);
    }  

    function update_kurikulum(Request $request, $id)
    {
        $validated = $request->validate([
            'mapel' => 'required|max:50',
            'alokasi' => 'required|numeric',
            'kelompok' => 'required|max:5',
            'no_urut' => 'required|numeric',
            'is_active' => 'required|numeric'
        ]);

        $kurikulum = KurikulumModel::select('id_kurikulum')->findOrFail($id);
        $kurikulum->update($validated);
        return redirect()->route('backend/kurikulum')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_kurikulum($id)
    {   
        $data = KurikulumModel::select('id_kurikulum')->findOrFail($id);

        $cek_un = RekapUNModel::select('id_kurikulum')->where('id_kurikulum', $id)->first();
        $cek_us = RekapUSModel::select('id_kurikulum')->where('id_kurikulum', $id)->first();
        if($cek_un OR $cek_us)
        {
            return redirect()->route('backend/kurikulum')->with(['error' => 'Data gagal dihapus, karena sudah berelasi!']);
        }else
        {
            $data->delete();
            return redirect()->route('backend/kurikulum')->with(['success' => 'Data Berhasil Dihapus!']);
        }
    }  

}