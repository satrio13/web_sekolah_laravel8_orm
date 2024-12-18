<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SejarahModel;
use Illuminate\Http\Request;

class SejarahController extends Controller
{
    function index()
    {     
        $data['title'] = 'Sejarah';
        $data['data'] = SejarahModel::where('id', 1)->first();
        return view('admin.sejarah.index', $data);
    }

    function edit_sejarah()
    {     
        $data['title'] = 'Edit Sejarah';
        $data['data'] = SejarahModel::where('id', 1)->first();
        return view('admin.sejarah.form_sejarah', $data);
    }

    function update_sejarah(Request $request)
    {   
        $sejarah = SejarahModel::where('id', 1)->first();
        $sejarah->update(['isi' => $request->input('isi')]);
        return redirect()->route('backend/sejarah')->with(['success' => 'Data Berhasil Diupdate!']);
    }

}