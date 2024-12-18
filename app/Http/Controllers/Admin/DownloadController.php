<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DownloadModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DownloadController extends Controller
{
    function index()
    {     
        $data['title'] = 'Download';
        $data['data'] = DownloadModel::with('user')->latest()->get();
        return view('admin.download.index', $data);
    }

    function tambah_download()
    {     
        $data['title'] = 'Tambah Download';
        return view('admin.download.form_tambah', $data);
    }

    function simpan_download(Request $request)
    {   
        $validated = $request->validate([
            'nama_file' => 'required|max:100',
            'is_active' => 'required',
            'file' => 'required|max:7168'
        ]);
            
        $nama_file = '';
        if($request->hasFile('file') AND $request->file('file')->isValid())
        {
            $file = $request->file('file');
            $nama_file = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('file'), $nama_file);
        }

        $data = array_merge($validated, ['file' => $nama_file, 'hits' => 0, 'id_user' => session('id_user')]);
        DownloadModel::create($data);
        return redirect()->route('backend/download')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_download($id)
    {     
        $download = DownloadModel::findOrFail($id); 
        $data['title'] = 'Edit Download';
        $data['data'] = $download;
        return view('admin.download.form_edit', $data);
    }

    function update_download(Request $request, $id)
    {   
        $validated = $request->validate([
            'nama_file' => 'required|max:100',
            'is_active' => 'required',
            'file' => 'max:7168'
        ]);
            
        $download = DownloadModel::select('id', 'file')->findOrFail($id);             
        if($request->hasFile('file') AND $request->file('file')->isValid())
        {   
            $file = $request->file('file');
            $nama_file = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('file'), $nama_file);
            if(File::exists("file/$download->file"))
            {
                File::delete("file/$download->file");
            }
        }else
        {
            $nama_file = $download->file;
        }
            
        $data = array_merge($validated, ['file' => $nama_file, 'id_user' => session('id_user')]);
        $download->update($data);
        return redirect()->route('backend/download')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_download($id)
    {
        $data = DownloadModel::select('id', 'file')->findOrFail($id);   
        if(File::exists("file/$data->file"))
        {
            File::delete("file/$data->file");
        }
        
        $data->delete();
        return redirect()->route('backend/download')->with(['success' => 'Data Berhasil Dihapus!']);
    }  

}