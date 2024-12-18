<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlbumModel;
use App\Models\FotoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    function index()
    {     
        $data['title'] = 'Album';
        $data['data'] = AlbumModel::latest()->get();
        return view('admin.album.index', $data);
    }

    function tambah_album()
    {     
        $data['title'] = 'Tambah Album';
        return view('admin.album.form_tambah', $data);
    }

    function simpan_album(Request $request)
    {
        $validated = $request->validate([
            'album' => 'required|max:50',
            'is_active' => 'required'
        ]);

        $data = array_merge($validated, ['slug' => Str::slug($request->input('album'), '-')]);
        AlbumModel::create($data);
        return redirect()->route('backend/album')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_album($id)
    {   
        $album = AlbumModel::findOrFail($id);
        $data['title'] = 'Edit Album';
        $data['data'] = $album;
        return view('admin.album.form_edit', $data);
    }  

    function update_album(Request $request, $id)
    {
        $validated = $request->validate([
            'album' => 'required|max:50',
            'is_active' => 'required'
        ]);

        $album = AlbumModel::select('id_album')->findOrFail($id);
        $data = array_merge($validated, ['slug' => Str::slug($request->input('album'), '-')]);
        $album->update($data);
        return redirect()->route('backend/album')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_album($id)
    {
        $data = AlbumModel::select('id_album')->findOrFail($id);

        $cek_foto = FotoModel::select('id_album')->where('id_album', $id)->first();
        if($cek_foto)
        {
            return redirect()->route('backend/album')->with(['error' => 'Data gagal dihapus, karena sudah berelasi!']);
        }else
        {
            $data->delete();
            return redirect()->route('backend/album')->with(['success' => 'Data Berhasil Dihapus!']);
        }
    }

}