@extends('admin.layouts.app')
@section('content')
    @php
        $is_active = old('is_active') ?? $data->is_active; 
    @endphp
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('backend') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('backend/banner') }}">Banner</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    @if(session('error'))
                        {!! pesan_gagal(session('error')) !!}
                    @endif
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">FORM {{ strtoupper($title) }}</h3>
                        </div>
                        <form method="POST" action="{{ route('backend/update-banner', $data->id) }}" enctype="multipart/form-data" id="form">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="callout callout-danger">
                                    <h5>REKOMENDASI UKURAN GAMBAR UNTUK BANNER ADALAH LANDSCAPE ( 1024px X 600px )</h5>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">GAMBAR <span class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                        @if(empty($data->gambar))
                                            <img class='img-responsive' id='preview_gambar' width='150px'>
                                        @else
                                            <img class='img-responsive' id='preview_gambar' width='150px' src="/img/banner/{{ $data->gambar }}">
                                        @endif
                                        <input type='file' name='gambar' id="file-upload" accept='image/png, image/jpeg' class='form-control' onchange='readURL(this);'>
                                        <small style="color: red"> *) format file JPG/PNG ukuran maksimal 1 MB</small>
                                        <small class="text-danger mt-2">
                                            {{ ($errors->first('gambar')) ? $errors->first('gambar') : '' }} 
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">JUDUL</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="judul" maxlength="100" value="{{ old('judul', $data->judul) }}" class="form-control" placeholder="JUDUL">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">KETERANGAN</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="keterangan" maxlength="200" value="{{ old('keterangan', $data->keterangan) }}" class="form-control" placeholder="KETERANGAN">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">LINK</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="link" maxlength="300" value="{{ old('link', $data->link) }}" class="form-control" placeholder="LINK">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">TULISAN TOMBOL</label>
                                    <div class="col-sm-5">
                                        <input type="text" name="button" maxlength="30" value="{{ old('button', $data->button) }}" class="form-control" placeholder="TULISAN TOMBOL">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">STATUS AKTIF <span class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="is_active" value="1" id="radioPrimary1" {{ ($is_active == '1') ? 'checked' : '' }} required> 
                                            <label for="radioPrimary1">Aktif</label> 
                                            &nbsp;&nbsp;&nbsp; 
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" name="is_active" value="0" id="radioPrimary2" {{ ($is_active == '0') ? 'checked' : '' }} required> 
                                            <label for="radioPrimary2">Non Aktif</label>
                                        </div>
                                        <br><label for="is_active" class="error"></label>
                                        <small class="text-danger mt-2">
                                            {{ ($errors->first('is_active')) ? $errors->first('is_active') : '' }} 
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <span class="text-danger"><b>*</b></span>) Field Wajib Diisi                     
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm" onclick="return VerifyUploadSizeIsOK()"><i class="fa fa-check"></i> SIMPAN</button>
                                <a href="{{ route('backend/banner') }}" class="btn btn-danger btn-sm float-right"><i class="fa fa-arrow-left"></i> BATAL</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            handle_validate();
        });

        function handle_validate()
        {
            $("#form").validate();
        }

        function readURL(input)
        {
            if(input.files && input.files[0])
            {
                var reader = new FileReader();
                reader.onload = function (e)
                {
                    $("#preview_gambar").attr("src", e.target.result);
                    //.width(300); // Menentukan lebar gambar preview (dalam pixel)
                    //.height(200); // // Menentukan tinggi gambar preview (dalam pixel)
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function VerifyUploadSizeIsOK()
        {
            var UploadFieldID = "file-upload";
            var MaxSizeInBytes = 1048576;
            var fld = document.getElementById(UploadFieldID);
            if(fld.files && fld.files.length == 1 && fld.files[0].size > MaxSizeInBytes)
            {
                setTimeout(function () { 
                    swal({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Ukuran gambar/foto terlalu besar!!',
                        showConfirmButton: false,
                        timer: 5000
                    });
                },2000); 
                return false;
            }
            return true;
        } 
    </script>
@endsection