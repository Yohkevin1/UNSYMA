@extends('layout.main')
@section('title')
UNISEC | Update TA
@endsection

@section('pages')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
    <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ route('TA') }}">Tahun Akademik</a></li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Update Tahun Akademik</li>
</ol>
<h6 class="font-weight-bolder text-white mb-0">TAHUN AKADEMIK UPDATE PAGE</h6>
@endsection

@section('content')
<div class="card shadow-lg">
    <div class="card-body p-3">
        <h4 class="mb-1">
            Update TA {{$TA->nama_ta}}
        </h4>
    </div>
</div>
<div class="card shadow-lg my-4">
    <div class="col-md-12">
        <div class="card" style="color: black">
            <div class="card-body p-3">
                <!-- Form data -->
                <form action="{{ route('updateTA', encrypt($TA->id_ta)) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4 row">
                        <label for="TA" class="col-sm-2 col-form-label">TA</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="TA" name="TA" value="<?= old('games', $TA->nama_ta) ?>" placeholder="Masukkan nama TA">
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