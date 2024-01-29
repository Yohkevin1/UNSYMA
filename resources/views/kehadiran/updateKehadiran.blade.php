@extends('layout.main')
@section('title')
UNISEC | Update Kehadiran
@endsection

@section('pages')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
    <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ route('Kehadiran') }}">Kehadiran</a></li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Update Kehadiran</li>
</ol>
<h6 class="font-weight-bolder text-white mb-0">UPDATE KEHADIRAN PAGE</h6>
@endsection

@section('content')
<div class="card shadow-lg">
    <div class="card-body p-3">
        <h4 class="mb-1">
            Update Data Kehadiran {{$data['Kehadiran']->anggota->nama}}
        </h4>
    </div>
</div>
<div class="card shadow-lg my-4">
    <div class="col-md-12">
        <div class="card" style="color: black">
            <div class="card-body p-3">
                <!-- Form data -->
                <form action="{{ route('updateKehadiran', ['pertemuan' => encrypt($data['Kehadiran']->id_pertemuan), 'anggota' => encrypt($data['Kehadiran']->id_anggota)]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_lama" value="{{$data['Kehadiran']->id_anggota}}">
                    <input type="hidden" name="pertemuan_lama" value="{{$data['Kehadiran']->id_pertemuan}}">
                    <div class="mb-3 row">
                        <label for="npm" class="col-sm-2 col-form-label">NPM</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="npm" name="npm" value="<?= old('npm', $data['Kehadiran']->anggota->npm) ?>" placeholder="Masukkan NPM">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="pertemuan" class="col-sm-2 col-form-label">Pertemuan</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="pertemuan" id="pertemuanSelect">
                                <option selected disabled value="">Pilih Pertemuan</option>
                                @foreach ($data['Pertemuan'] as $pertemuan)
                                    <option value="{{$pertemuan->id_pertemuan}}" {{ $data['Kehadiran']->id_pertemuan == $pertemuan->id_pertemuan ? 'selected' : '' }}>{{$pertemuan->meet}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="status" id="statusSelect">
                                <option selected disabled value="">Pilih Status</option>
                                <option value="Hadir" {{ $data['Kehadiran']->status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="Izin" {{ $data['Kehadiran']->status == 'Izin' ? 'selected' : '' }}>Izin</option>
                                <option value="Alpha" {{ $data['Kehadiran']->status == 'Alpha' ? 'selected' : '' }}>Alpha</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="foto" class="col-sm-2 col-form-label">Bukti Kehadiran</label>
                        <div class="col-sm-4">
                            <input type="hidden" name="fotoLama" value="{{$data['Kehadiran']->foto}}">
                            <input type="file" class="form-control" id="foto" name="foto" value="<?= old('foto') ?>" onchange="previewImage()">
                            <div class="col-sm-6 mt-2">
                                <img src="{{ asset('img/buktiPresensi/'. $data['Kehadiran']->foto) }}" alt="" class="img-thumbnail img-preview">
                            </div>
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