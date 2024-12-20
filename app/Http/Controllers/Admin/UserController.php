<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\PengumumanModel;
use App\Models\BeritaModel;
use App\Models\DownloadModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function index()
    {     
        $data['title'] = 'Users';
        $data['data'] = UserModel::latest()->get();
        return view('admin.user.index', $data);
    }

    function tambah_user()
    {     
        $data['title'] = 'Tambah User';
        return view('admin.user.form_tambah', $data);
    }

    function simpan_user(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'username' => 'required|alpha_num|unique:tb_user,username|min:5|max:30',
            'password1' => 'required|alpha_num|min:5|max:30',
            'password2' => 'required|same:password1',
            'email' => 'required|email|unique:tb_user,email|max:100',
            'is_active' => 'required'
        ]);

        $data = [
            'nama' => $request->input('nama'),
            'username' => trim($request->input('username')),
            'password' => password_hash(trim($request->input('password1')), PASSWORD_DEFAULT),
            'email' => trim($request->input('email')),
            'level' => 'admin',
            'is_active' => $request->input('is_active')
        ];

        UserModel::create($data);
        return redirect()->route('backend/users')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_user($id)
    {   
        $user = UserModel::findOrFail($id);
        $data['title'] = 'Edit User';
        $data['data'] = $user;
        return view('admin.user.form_edit', $data);
    }  

    function update_user(Request $request, $id)
    {
        if(!empty($request->input('password')))
        {
            $request->validate([
                'nama' => 'required|max:50',
                'username' => 'required|alpha_num|min:5|max:30|cek_username:'.$id,
                'password' => 'alpha_num|min:5|max:30',
                'email' => 'required|email|max:100|cek_email:'.$id,
                'is_active' => 'required'
            ]);
        }else
        {
            $request->validate([
                'nama' => 'required|max:50',
                'username' => 'required|alpha_num|min:5|max:30|cek_username:'.$id,
                'email' => 'required|email|max:100|cek_email:'.$id,
                'is_active' => 'required'
            ]);
        }
        
        $user = UserModel::select('id_user', 'level')->findOrFail($id);
        $data = [
            'nama' => $request->input('nama'),
            'username' => trim($request->input('username')),
            'email' => trim($request->input('email')),
            'level' => $user->level,
            'is_active' => $request->input('is_active')
        ];

        if(!empty($request->input('password')))
        {
            $data['password'] = password_hash(trim($request->input('password')), PASSWORD_DEFAULT);
        }
            
        $user->update($data);
        return redirect()->route('backend/users')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_user($id)
    {   
        $data = UserModel::select('id_user')->findOrFail($id);

        $cek_pengumuman = PengumumanModel::select('id_user')->where('id_user', $id)->first();
        $cek_berita = BeritaModel::select('id_user')->where('id_user', $id)->first();
        $cek_download = DownloadModel::select('id_user')->where('id_user', $id)->first();
        if($cek_pengumuman OR $cek_berita OR $cek_download)
        {
            return redirect()->route('backend/users')->with(['error' => 'Data gagal dihapus, karena sudah berelasi!']);
        }else
        {
            $data->delete();
            return redirect()->route('backend/users')->with(['success' => 'Data Berhasil Dihapus!']);  
        }     
    }  

    function edit_profil()
    {   
        $data['title'] = 'Edit Profil';
        $id = session('id_user');
        $data['data'] = UserModel::findOrFail($id);
        return view('admin.user.form_profil', $data);
    }  

    function update_profil(Request $request)
    {
        $id = session('id_user');
        $validated = $request->validate([
            'nama' => 'required|max:50',
            'username' => 'required|alpha_num|min:5|max:30|cek_username:'.$id,
            'email' => 'required|email|max:100|cek_email:'.$id,
        ]);
        
        $user = UserModel::select('id_user')->findOrFail($id);
        $user->update($validated);
        return redirect()->back()->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function ganti_password()
    {   
        $data['title'] = 'Ganti Password';
        $id = session('id_user');
        $get = UserModel::findOrFail($id);
        $data['username'] = $get->username;
        return view('admin.user.ganti_password', $data);
    }  

    function update_password(Request $request)
    {
        $id = session('id_user');
        $user = UserModel::findOrFail($id);

        $request->validate([
            'password1' => 'required|alpha_num|min:5|max:30',
            'password2' => 'required|same:password1',
            'password3' => 'required',
        ]);
        
        if(!password_verify($request->input('password3'), $user->password))
        {
            return redirect()->back()->withInput()->with('error', 'Password lama yang anda inputkan salah!');
        }elseif(password_verify($request->input('password1'), $user->password))
        {
            return redirect()->back()->withInput()->with('error', 'Password baru yang anda inputkan sama dengan password lama!');
        }else
        {   
            $data = ['password' => password_hash(trim($request->input('password1')), PASSWORD_DEFAULT)];
            $user->update($data);
            echo '<script type="text/javascript">alert("Password berhasil dirubah");window.location.replace("'.route('auth/logout').'")</script>';
        }
    }

}
