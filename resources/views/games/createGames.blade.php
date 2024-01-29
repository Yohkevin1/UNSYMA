@extends('layout.main')
@section('title')
UNISEC | Create Games
@endsection

@section('pages')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
    <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ route('games') }}">Games</a></li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Create Games</li>
</ol>
<h6 class="font-weight-bolder text-white mb-0">CREATE GAMES PAGE</h6>
@endsection

@section('content')
<div class="card shadow-lg">
    <div class="card-body p-3">
        <h4 class="mb-1">
            Create Games
        </h4>
    </div>
</div>
<div class="card shadow-lg my-4">
    <div class="col-md-12">
        <div class="card" style="color: black">
            <div class="card-body p-3">
                <!-- Form data -->
                <form action="{{ route('createGames') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4 row">
                        <label for="games" class="col-sm-2 col-form-label">Games</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="games" name="games" value="<?= old('games') ?>" placeholder="Masukkan nama games">
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <label for="kapasitas" class="col-sm-2 col-form-label">Kapasitas</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="kapasitas" name="kapasitas" value="<?= old('kapasitas') ?>" placeholder="Masukkan nama games">
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