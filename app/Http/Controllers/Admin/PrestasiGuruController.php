<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrestasiGuruModel;
use App\Models\TahunModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PrestasiGuruController extends Controller
{
    function index()
    {     
        $data['title'] = 'Prestasi Guru';
        $data['data'] = PrestasiGuruModel::with('tahun')->latest()->get();
        return view('admin.prestasi_guru.index', $data);
    }

    function tambah_prestasi_guru()
    {     
        $data['title'] = 'Tambah Prestasi Guru';
        $data['tahun'] = TahunModel::orderBy('tahun', 'desc')->get();
        return view('admin.prestasi_guru.form_tambah', $data);
    }

    function simpan_prestasi_guru(Request $request)
    {   
        $validated = $request->validate([
            'id_tahun' => 'required|numeric',
            'jenis' => 'required|numeric',
            'nama' => 'required|max:100',
            'prestasi' => 'required|max:100',
            'nama_guru' => 'required|max:100',
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
            $gambar->move(public_path('img/prestasi_guru'), $nama_gambar);
        }
        
        $data = array_merge($validated, ['gambar' => $nama_gambar]);
        PrestasiGuruModel::create($data);
        return redirect()->route('backend/prestasi-guru')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_prestasi_guru($id)
    {   
        $prestasi = PrestasiGuruModel::findOrFail($id); 
        $data['title'] = 'Edit Prestasi Guru';
        $data['data'] = $prestasi;
        $data['tahun'] = TahunModel::orderBy('tahun', 'desc')->get();
        return view('admin.prestasi_guru.form_edit', $data);
    }

    function update_prestasi_guru(Request $request, $id)
    {   
        $validated = $request->validate([
            'id_tahun' => 'required|numeric',
            'jenis' => 'required|numeric',
            'nama' => 'required|max:100',
            'prestasi' => 'required|max:100',
            'nama_guru' => 'required|max:100',
            'tingkat' => 'required|numeric',
            'keterangan' => 'max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ],
        [
            'nama.required' => 'Kolom nama lomba harus diisi.',
            'nama.max:100' => 'Kolom nama lomba harus kurang dari atau sama dengan :value karakter.'
        ]);
            
        $prestasi = PrestasiGuruModel::select('id', 'gambar')->findOrFail($id);
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/prestasi_guru'), $nama_gambar);
            if(File::exists("img/prestasi_guru/$prestasi->gambar"))
            {
                File::delete("img/prestasi_guru/$prestasi->gambar");
            }
        }else
        {
            $nama_gambar = $prestasi->gambar;
        }
        
        $data = array_merge($validated, ['gambar' => $nama_gambar]);
        $prestasi->update($data);
        return redirect()->route('backend/prestasi-guru')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_prestasi_guru($id)
    {   
        $data = PrestasiGuruModel::select('id', 'gambar')->findOrFail($id);
        if(File::exists("img/prestasi_guru/$data->gambar"))
        {
            File::delete("img/prestasi_guru/$data->gambar");
        }
        
        $data->delete();
        return redirect()->route('backend/prestasi-guru')->with(['success' => 'Data Berhasil Dihapus!']);
    }

}