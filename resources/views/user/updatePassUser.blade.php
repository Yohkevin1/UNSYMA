@extends('layout.main')
@section('title')
UNISEC | Update User
@endsection

@section('pages')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
    <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ route('User') }}">User</a></li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Update User</li>
</ol>
<h6 class="font-weight-bolder text-white mb-0">UPDATE USER PAGE</h6>
@endsection

@section('content')
<div class="card shadow-lg">
    <div class="card-body p-3">
        <h4 class="mb-1">
            Update Password {{$User->username}}
        </h4>
    </div>
</div>
<div class="card shadow-lg my-4">
    <div class="col-md-12">
        <div class="card" style="color: black">
            <div class="card-body p-3">
                <!-- Form data -->
                <form action="{{ route('updatePass', encrypt($User->id_user)) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-3">
                            <input type="password" class="form-control" id="password" name="password" value="<?= old('password') ?>" placeholder="Masukkan password">
                        </div>
                        <label for="passConfirm" class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="passConfirm" name="passConfirm" value="<?= old('passConfirm') ?>" placeholder="Masukkan password">
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