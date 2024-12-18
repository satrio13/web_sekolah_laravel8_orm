<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeritaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BeritaController extends Controller
{
    function index()
    {     
        $data['title'] = 'Berita';
        $data['data'] = BeritaModel::with('user')->latest()->get();
        return view('admin.berita.index', $data);
    }

    function tambah_berita()
    {     
        $data['title'] = 'Tambah Berita';
        return view('admin.berita.form_tambah', $data);
    }

    function simpan_berita(Request $request)
    {   
        $validated = $request->validate([
            'nama' => 'required|max:100',
            'isi' => 'required',
            'is_active' => 'required',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ],
        [
            'nama.required' => 'Kolom nama berita harus diisi.',
            'nama.max:100' => 'Kolom nama berita harus kurang dari atau sama dengan :value karakter.'
        ]);
            
        $nama_gambar = '';
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/berita'), $nama_gambar);
        }

        $data = array_merge($validated, ['gambar' => $nama_gambar, 'dibaca' => 0, 'id_user' => session('id_user'), 'hari' => hari_ini_indo(), 'tgl' => tgl_jam_simpan_sekarang(), 'slug' => Str::slug($request->input('nama'), '-')]);
        BeritaModel::create($data); 
        return redirect()->route('backend/berita')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_berita($id)
    {
        $berita = BeritaModel::findOrFail($id); 
        $data['title'] = 'Edit Berita';
        $data['data'] = $berita;
        return view('admin.berita.form_edit', $data);
    }

    function update_berita(Request $request, $id)
    {   
        $validated = $request->validate([
            'nama' => 'required|max:100',
            'isi' => 'required',
            'is_active' => 'required',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ],
        [
            'nama.required' => 'Kolom nama berita harus diisi.',
            'nama.max:100' => 'Kolom nama berita harus kurang dari atau sama dengan :value karakter.'
        ]);
            
        $berita = BeritaModel::select('id', 'gambar')->findOrFail($id);
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid())
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/berita'), $nama_gambar);
            if(File::exists("img/berita/$berita->gambar"))
            {
                File::delete("img/berita/$berita->gambar");
            }
        }else
        {
            $nama_gambar = $berita->gambar;
        }
        
        $data = array_merge($validated, ['gambar' => $nama_gambar, 'id_user' => session('id_user'), 'slug' => Str::slug($request->input('nama'), '-')]);
        $berita->update($data);
        return redirect()->route('backend/berita')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_berita($id)
    {   
        $data = BeritaModel::select('id', 'gambar')->findOrFail($id); 
        if(File::exists("img/berita/$data->gambar"))
        {
            File::delete("img/berita/$data->gambar");
        }
    
        $data->delete();
        return redirect()->route('backend/berita')->with(['success' => 'Data Berhasil Dihapus!']);
    }  

}