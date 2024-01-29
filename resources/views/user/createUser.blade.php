@extends('layout.main')
@section('title')
UNISEC | Create User
@endsection

@section('pages')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
    <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="{{ route('User') }}">User</a></li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Create User</li>
</ol>
<h6 class="font-weight-bolder text-white mb-0">CREATE USER PAGE</h6>
@endsection

@section('content')
<div class="card shadow-lg">
    <div class="card-body p-3">
        <h4 class="mb-1">
            Create User
        </h4>
    </div>
</div>
<div class="card shadow-lg my-4">
    <div class="col-md-12">
        <div class="card" style="color: black">
            <div class="card-body p-3">
                <!-- Form data -->
                <form action="{{ route('createUser') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>" placeholder="Masukkan username">
                        </div>
                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="role" id="roleSelect">
                                <option selected disabled value="">Pilih Role</option>
                                <option value="pengurus" {{ old('role') == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                                <option value="PJ" {{ old('role') == 'PJ' ? 'selected' : '' }}>Penanggung Jawab</option>
                            </select>
                        </div>
                    </div>
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