@extends('layout.main')
@section('title')
UNISEC | Create Pertemuan
@endsection

@section('pages')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
    <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ route('Pertemuan') }}">Pertemuan</a></li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Create Pertemuan</li>
</ol>
<h6 class="font-weight-bolder text-white mb-0">CREATE PERTEMUAN PAGE</h6>
@endsection

@section('content')
<div class="card shadow-lg">
    <div class="card-body p-3">
        <h4 class="mb-1">
            Create Pertemuan
        </h4>
    </div>
</div>
<div class="card shadow-lg my-4">
    <div class="col-md-12">
        <div class="card" style="color: black">
            <div class="card-body p-3">
                <!-- Form data -->
                <form action="{{ route('createPertemuan') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <label for="meet" class="col-sm-2 col-form-label">Meet</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="meet" name="meet" value="<?= old('meet') ?>" placeholder="Masukkan nama pertemuan">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="TA" class="col-sm-2 col-form-label">Tahun Akademik</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="TA" id="TASelect">
                                <option selected disabled value="">Pilih Tahun Akademik</option>
                                @foreach ($data['TA'] as $ta)
                                    <option value="{{$ta->id_ta}}" {{ old('TA') == $ta->id_ta ? 'selected' : '' }}>{{$ta->nama_ta}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="games" class="col-sm-2 col-form-label">Games</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="games" id="gamesSelect">
                                <option selected disabled value="">Pilih Games</option>
                                @foreach ($data['Games'] as $games)
                                    <option value="{{$games->id_games}}" {{ old('games') == $games->id_games ? 'selected' : '' }}>{{$games->nama_games}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="opened" class="col-sm-2 col-form-label">Opened</label>
                        <div class="col-sm-3">
                            <input type="datetime-local" class="form-control" id="opened" name="opened" value="<?= old('opened') ?>" placeholder="Masukkan tangal opened">
                        </div>
                        <label for="closed" class="col-sm-2 col-form-label">Closed</label>
                        <div class="col-sm-4">
                            <input type="datetime-local" class="form-control" id="closed" name="closed" value="<?= old('closed') ?>" placeholder="Masukkan tanggal closed">
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