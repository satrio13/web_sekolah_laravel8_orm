<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoModel;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    function index()
    {     
        $data['title'] = 'Video';
        $data['data'] = VideoModel::latest()->get();
        return view('admin.video.index', $data);
    }

    function tambah_video()
    {     
        $data['title'] = 'Tambah Video';
        return view('admin.video.form_tambah', $data);
    }

    function simpan_video(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:100',
            'keterangan' => 'max:200',
            'link' => 'required|max:100'
        ],
        [
            'link.required' => 'Kolom kode video youtube harus diisi.',
            'link.max:100' => 'Kolom kode video youtube harus kurang dari atau sama dengan :value karakter.'
        ]);

        VideoModel::create($validated);
        return redirect()->route('backend/video')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_video($id)
    {   
        $video = VideoModel::findOrFail($id);
        $data['title'] = 'Edit Video';
        $data['data'] = $video;
        return view('admin.video.form_edit', $data);
    }  

    function update_video(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|max:100',
            'keterangan' => 'max:200',
            'link' => 'required|max:100'
        ],
        [
            'link.required' => 'Kolom kode video youtube harus diisi.',
            'link.max:100' => 'Kolom kode video youtube harus kurang dari atau sama dengan :value karakter.'
        ]);

        $video = VideoModel::select('id_video')->findOrFail($id);
        $video->update($validated);
        return redirect()->route('backend/video')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_video($id)
    {   
        $data = VideoModel::select('id_video')->findOrFail($id);
        $data->delete();
        return redirect()->route('backend/video')->with(['success' => 'Data Berhasil Dihapus!']);   
    }  

}