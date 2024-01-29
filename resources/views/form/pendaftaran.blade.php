@extends('form.form')
@section('title')
UNISEC | Pendaftaran
@endsection
@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Pendaftaran Anggota UNISEC</h1>
    <form action="{{ route('submitForm') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>" placeholder="Masukkan nama anda" required>
        </div>

        <div class="mb-3">
            <label for="npm" class="form-label">NPM</label>
            <input type="text" class="form-control" id="npm" name="npm" value="<?= old('npm') ?>" placeholder="Masukkan npm annda" required>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Jenis Kelamin</label>
            <select class="form-select" id="gender" name="gender" required>
                <option selected disabled value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="no_hp" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= old('no_hp') ?>" placeholder="Masukkan nomor HP" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Student</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" placeholder="Masukkan email anda" required>
        </div>

        <div class="mb-3">  
            <label for="prodi" class="form-label">Program Studi</label>
            <select class="form-select" id="prodi" name="prodi" required>
                <option selected disabled value="">Pilih Prodi</option>
                @foreach ($data['Prodi'] as $prodi)
                    <option value="{{$prodi->id_prodi}}" {{ old('prodi') == $prodi->id_prodi ? 'selected' : '' }}>{{$prodi->nama_prodi}}</option>
                @endforeach
            </select>
        </div>

        
        <div class="mb-3">
            <label for="games" class="form-label">Games yang akan diikuti</label>
            <select class="form-select" id="games" name="games" required>
                <option selected disabled value="">Pilih Games</option>
                @foreach ($data['Games'] as $games)
                <option value="{{$games->id_games}}" {{ old('games') == $games->id_games ? 'selected' : '' }}>{{$games->nama_games}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="TA" class="form-label">Tahun Akademik</label>
            <select class="form-select" id="TA" name="TA" required>
                <option selected value="{{$data['TA']->id_ta}}">{{$data['TA']->nama_ta}}</option>
            </select>
        </div>
        
        <!-- Checkbox Persetujuan -->
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="persetujuan" name="persetujuan" required>
            <label class="form-check-label" for="persetujuan">Saya menyetujui syarat dan ketentuan</label>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>
@endsection