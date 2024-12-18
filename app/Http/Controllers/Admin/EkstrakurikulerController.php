<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EkstrakurikulerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class EkstrakurikulerController extends Controller
{
    function index()
    {     
        $data['title'] = 'Ekstrakurikuler';
        $data['data'] = EkstrakurikulerModel::latest()->get();
        return view('admin.ekstrakurikuler.index', $data);
    }

    function tambah_ekstrakurikuler()
    {     
        $data['title'] = 'Tambah Ekstrakurikuler';
        return view('admin.ekstrakurikuler.form_tambah', $data);
    }

    function simpan_ekstrakurikuler(Request $request)
    {   
        $validated = $request->validate([
            'nama_ekstrakurikuler' => 'required|max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
            
        $nama_gambar = '';
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid())
        {            
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/ekstrakurikuler'), $nama_gambar);
        }
        
        $data = array_merge($validated, ['keterangan' => $request->input('keterangan'), 'gambar' => $nama_gambar, 'slug' => Str::slug($request->input('nama_ekstrakurikuler'), '-')]);
        EkstrakurikulerModel::create($data);
        return redirect()->route('backend/ekstrakurikuler')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_ekstrakurikuler($id)
    {     
        $ekstrakurikuler = EkstrakurikulerModel::findOrFail($id);
        $data['title'] = 'Edit Ekstrakurikuler';
        $data['data'] = $ekstrakurikuler;
        return view('admin.ekstrakurikuler.form_edit', $data);
    }

    function update_ekstrakurikuler(Request $request, $id)
    {   
        $validated = $request->validate([
            'nama_ekstrakurikuler' => 'required|max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
            
        $ekstrakurikuler = EkstrakurikulerModel::select('id', 'gambar')->findOrFail($id);
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid())
        {            
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/ekstrakurikuler'), $nama_gambar);
            if(File::exists("img/ekstrakurikuler/$ekstrakurikuler->gambar"))
            {
                File::delete("img/ekstrakurikuler/$ekstrakurikuler->gambar");
            }
        }else
        {
            $nama_gambar = $ekstrakurikuler->gambar;
        }
        
        $data = array_merge($validated, ['keterangan' => $request->input('keterangan'), 'gambar' => $nama_gambar, 'slug' => Str::slug($request->input('nama_ekstrakurikuler'), '-')]);
        $ekstrakurikuler->update($data);
        return redirect()->route('backend/ekstrakurikuler')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_ekstrakurikuler($id)
    {
        $data = EkstrakurikulerModel::select('id', 'gambar')->findOrFail($id);   
        if(File::exists("img/ekstrakurikuler/$data->gambar"))
        {
            File::delete("img/ekstrakurikuler/$data->gambar");
        }
        
        $data->delete();
        return redirect()->route('backend/ekstrakurikuler')->with(['success' => 'Data Berhasil Dihapus!']);
    }  

}