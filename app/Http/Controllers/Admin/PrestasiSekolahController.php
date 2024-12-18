<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrestasiSekolahModel;
use App\Models\TahunModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PrestasiSekolahController extends Controller
{
    function index()
    {     
        $data['title'] = 'Prestasi Sekolah';
        $data['data'] = PrestasiSekolahModel::with('tahun')->latest()->get();
        return view('admin.prestasi_sekolah.index', $data);
    }

    function tambah_prestasi_sekolah()
    {     
        $data['title'] = 'Tambah Prestasi Sekolah';
        $data['tahun'] = TahunModel::orderBy('tahun', 'desc')->get();
        return view('admin.prestasi_sekolah.form_tambah', $data);
    }

    function simpan_prestasi_sekolah(Request $request)
    {   
        $validated = $request->validate([
            'id_tahun' => 'required|numeric',
            'jenis' => 'required|numeric',
            'nama' => 'required|max:100',
            'prestasi' => 'required|max:100',
            'tingkat' => 'required|numeric',
            'keterangan' => 'max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ],
        [
            'nama.required' => 'Kolom nama lomba harus diisi.',
            'nama.max:100' => 'Kolom nama lomba harus kurang dari atau sama dengan :value karakter.'
        ]);
            
        $nama_gambar = '';
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/prestasi_sekolah'), $nama_gambar);
        }

        $data = array_merge($validated, ['gambar' => $nama_gambar]);
        PrestasiSekolahModel::create($data);
        return redirect()->route('backend/prestasi-sekolah')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_prestasi_sekolah($id)
    {   
        $prestasi = PrestasiSekolahModel::findOrFail($id); 
        $data['title'] = 'Edit Prestasi Sekolah';
        $data['data'] = $prestasi;
        $data['tahun'] = TahunModel::orderBy('tahun', 'desc')->get();
        return view('admin.prestasi_sekolah.form_edit', $data);
    }

    function update_prestasi_sekolah(Request $request, $id)
    {   
        $validated = $request->validate([
            'id_tahun' => 'required|numeric',
            'jenis' => 'required|numeric',
            'nama' => 'required|max:100',
            'prestasi' => 'required|max:100',
            'tingkat' => 'required|numeric',
            'keterangan' => 'max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ],
        [
            'nama.required' => 'Kolom nama lomba harus diisi.',
            'nama.max:100' => 'Kolom nama lomba harus kurang dari atau sama dengan :value karakter.'
        ]);
            
        $prestasi = PrestasiSekolahModel::select('id', 'gambar')->findOrFail($id);
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/prestasi_sekolah'), $nama_gambar);
            if(File::exists("img/prestasi_sekolah/$prestasi->gambar"))
            {
                File::delete("img/prestasi_sekolah/$prestasi->gambar");
            }
        }else
        {
            $nama_gambar = $prestasi->gambar;
        }
        
        $data = array_merge($validated, ['gambar' => $nama_gambar]);
        $prestasi->update($data);
        return redirect()->route('backend/prestasi-sekolah')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_prestasi_sekolah($id)
    {   
        $data = PrestasiSekolahModel::select('id', 'gambar')->findOrFail($id);
        if(File::exists("img/prestasi_sekolah/$data->gambar"))
        {
            File::delete("img/prestasi_sekolah/$data->gambar");
        }
        
        $data->delete();
        return redirect()->route('backend/prestasi-sekolah')->with(['success' => 'Data Berhasil Dihapus!']);
    }

}