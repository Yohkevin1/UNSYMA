@extends('form.form')
@section('title')
UNISEC | Presensi
@endsection
@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Presensi Anggota UNISEC</h1>
    <form action="{{ route('submitPresensi') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 row">
            <label for="npm" class="col-sm-2 col-form-label">NPM</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="npm" name="npm" value="<?= old('npm') ?>" placeholder="Masukkan NPM">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="pertemuan" class="col-sm-2 col-form-label">Pertemuan</label>
            <div class="col-sm-9">
                <select class="form-control" name="pertemuan" id="pertemuanSelect">
                    <option selected disabled value="">Pilih Pertemuan</option>
                    @foreach ($Pertemuan as $pertemuan)
                        <option value="{{$pertemuan->id_pertemuan}}" {{ old('pertemuan') == $pertemuan->id_pertemuan ? 'selected' : '' }}>{{$pertemuan->meet}}</option>
                    @endforeach
                </select>
            </div>
            
        </div>
        <div class="mb-3 row">
            <label for="foto" class="col-sm-2 col-form-label">Bukti Kehadiran</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" id="foto" name="foto" value="<?= old('foto') ?>" onchange="previewImage()">
                <div class="col-sm-6 mt-2">
                    <img src="{{ asset('img/default.jpg') }}" alt="" class="img-thumbnail img-preview">
                </div>
            </div>
        </div>

        <div class="d-grid gap-2 d-md-block">
            <div class="justify-content-end d-flex" style="grid-gap: 1rem">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection