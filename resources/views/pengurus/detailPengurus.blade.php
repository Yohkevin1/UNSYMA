@extends('layout.main')
@section('title')
UNISEC | Detail Pengurus
@endsection

@section('pages')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
    <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ route('Pengurus') }}">Pengurus</a></li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Detail Pengurus</li>
</ol>
<h6 class="font-weight-bolder text-white mb-0">DETAIL PENGURUS PAGE</h6>
@endsection

@section('content')
<div class="card shadow-lg">
    <div class="card-body p-3">
        <h4 class="mb-1">
            Data Pengurus {{$Pengurus->nama}}
        </h4>
    </div>
</div>
<div class="card shadow-lg my-4">
    <div class="col-md-12">
        <div class="card" style="color: black">
            <div class="card-body p-3">
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Nama Pengurus</label>
                    <div class="col-sm-3">
                        <input class="form-control" value="{{$Pengurus->nama}}" disabled>
                    </div>
                    <label for="npm" class="col-sm-2 col-form-label">NPM</label>
                    <div class="col-sm-4">
                        <input class="form-control" value="{{$Pengurus->npm}}" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-3">
                        <input class="form-control" value="{{$Pengurus->gender}}" disabled>
                    </div>
                    <label for="prodi" class="col-sm-2 col-form-label">Program Studi</label>
                    <div class="col-sm-4">
                        <input class="form-control" value="{{$Pengurus->prodi->nama_prodi}}" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="TA" class="col-sm-2 col-form-label">Tahun Akademik</label>
                    <div class="col-sm-3">
                        <input class="form-control" value="{{$Pengurus->TA->nama_ta }}" disabled>
                    </div>
                    <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                    <div class="col-sm-4">
                        <input class="form-control" value="{{$Pengurus->jabatan}}" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="hp" class="col-sm-2 col-form-label">No HP</label>
                    <div class="col-sm-3">
                        <input class="form-control" value="{{$Pengurus->no_hp}}" disabled>
                    </div>
                    <label for="email" class="col-sm-2 col-form-label">email</label>
                    <div class="col-sm-4">
                        <input class="form-control" value="{{$Pengurus->email}}" disabled>
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-block">
                    <div class="justify-content-end d-flex" style="grid-gap: 1rem">
                        <a class="btn btn-dark ms-2" href="javascript:history.back()">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection