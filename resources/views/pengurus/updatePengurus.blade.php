@extends('layout.main')
@section('title')
UNISEC | Update Pengurus
@endsection

@section('pages')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
    <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ route('Pengurus') }}">Pengurus</a></li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Update Pengurus</li>
</ol>
<h6 class="font-weight-bolder text-white mb-0">UPDATE PENGURUS PAGE</h6>
@endsection

@section('content')
<div class="card shadow-lg">
    <div class="card-body p-3">
        <h4 class="mb-1">
            Update Data {{$data['Pengurus']->nama}}
        </h4>
    </div>
</div>
<div class="card shadow-lg my-4">
    <div class="col-md-12">
        <div class="card" style="color: black">
            <div class="card-body p-3">
                <!-- Form data -->
                <form action="{{ route('updatePengurus', encrypt($data['Pengurus']->id_pengurus)) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="text" class="form-control" id="id" name="id" value="<?= old('id', $data['Pengurus']->id_pengurus) ?>" placeholder="Masukkan nama Pengurus" hidden>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Pengurus</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama', $data['Pengurus']->nama) ?>" placeholder="Masukkan nama Pengurus">
                        </div>
                        <label for="npm" class="col-sm-2 col-form-label">NPM</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="npm" name="npm" value="<?= old('npm', $data['Pengurus']->npm) ?>" placeholder="Masukkan NPM Pengurus">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="gender" id="genderSelect">
                                <option selected disabled value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('gender', $data['Pengurus']->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('gender', $data['Pengurus']->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <label for="prodi" class="col-sm-2 col-form-label">Program Studi</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="prodi" id="prodiSelect">
                                <option selected disabled value="">Pilih Prodi</option>
                                @foreach ($data['Prodi'] as $prodi)
                                    <option value="{{$prodi->id_prodi}}" {{ $data['Pengurus']->id_prodi == $prodi->id_prodi ? 'selected' : '' }}>{{$prodi->nama_prodi}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="TA" class="col-sm-2 col-form-label">Tahun Akademik</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="TA" id="TASelect">
                                <option selected disabled value="">Pilih Tahun Akademik</option>
                                @foreach ($data['TA'] as $ta)
                                    <option value="{{$ta->id_ta}}" {{ $data['Pengurus']->id_ta == $ta->id_ta ? 'selected' : '' }}>{{$ta->nama_ta}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= old('jabatan', $data['Pengurus']->jabatan) ?>" placeholder="Masukkan Jabatan Pengurus">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="no_hp" class="col-sm-2 col-form-label">No HP</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= old('no_hp', $data['Pengurus']->no_hp) ?>" placeholder="Masukkan nomor HP">
                        </div>
                        <label for="email" class="col-sm-2 col-form-label">Email Student</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $data['Pengurus']->email) ?>" placeholder="Masukkan email Pengurus">
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