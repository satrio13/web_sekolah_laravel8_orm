<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekapUNModel;
use App\Models\TahunModel;
use App\Models\KurikulumModel;
use Illuminate\Http\Request;

class RekapUNController extends Controller
{
    function index()
    {     
        $data['title'] = 'Rekap UN';
        $data['data'] = RekapUNModel::with(['kurikulum', 'tahun'])->latest()->get();
        return view('admin.rekap_un.index', $data);
    }

    function tambah_rekap_un()
    {     
        $data['title'] = 'Tambah Rekap UN';
        $data['tahun'] = TahunModel::orderBy('tahun', 'desc')->get();
        $data['mapel'] = KurikulumModel::orderBy('mapel', 'asc')->get();
        return view('admin.rekap_un.form_tambah', $data);
    }
    
    function simpan_rekap_un(Request $request)
    {   
        $validated = $request->validate([
            'id_tahun' => 'required|numeric',
            'id_kurikulum' => 'required|numeric',
            'tertinggi' => 'required|numeric',
            'terendah' => 'required|numeric',
            'rata' => 'required|numeric'
        ]);
        
        RekapUNModel::create($validated);
        return redirect()->route('backend/rekap-un')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_rekap_un($id)
    {
        $rekap = RekapUNModel::findOrFail($id);
        $data['title'] = 'Edit Rekap UN';
        $data['data'] = $rekap;
        $data['tahun'] = TahunModel::orderBy('tahun', 'desc')->get();
        $data['mapel'] = KurikulumModel::orderBy('mapel', 'asc')->get();
        return view('admin.rekap_un.form_edit', $data);   
    }

    function update_rekap_un(Request $request, $id)
    {   
        $validated = $request->validate([
            'id_tahun' => 'required|numeric',
            'id_kurikulum' => 'required|numeric',
            'tertinggi' => 'required|numeric',
            'terendah' => 'required|numeric',
            'rata' => 'required|numeric'
        ]);
        
        $rekap = RekapUNModel::select('id_un')->findOrFail($id);
        $rekap->update($validated);
        return redirect()->route('backend/rekap-un')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_rekap_un($id)
    {
        $data = RekapUNModel::select('id_un')->findOrFail($id);
        $data->delete();
        return redirect()->route('backend/rekap-un')->with(['success' => 'Data Berhasil Dihapus!']);   
    }

}