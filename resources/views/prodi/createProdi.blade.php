@extends('layout.main')
@section('title')
UNISEC | Create Prodi
@endsection

@section('pages')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
    <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ route('prodi') }}">Prodi</a></li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Create Prodi</li>
</ol>
<h6 class="font-weight-bolder text-white mb-0">CREATE PRODI PAGE</h6>
@endsection

@section('content')
<div class="card shadow-lg">
    <div class="card-body p-3">
        <h4 class="mb-1">
            Create Prodi
        </h4>
    </div>
</div>
<div class="card shadow-lg my-4">
    <div class="col-md-12">
        <div class="card" style="color: black">
            <div class="card-body p-3">
                <!-- Form data -->
                <form action="{{ route('createProdi') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4 row">
                        <label for="Prodi" class="col-sm-2 col-form-label">Program Studi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="Prodi" name="Prodi" value="<?= old('Prodi') ?>" placeholder="Masukkan nama prodi">
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-block">
                        <div class="justify-content-end d-flex" style="grid-gap: 1rem">
                            <a class="btn btn-danger ms-2" href="javascript:history.back()">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
                <!-- end form -->
            </div>
        </div>
    </div> 
</div>
@endsection