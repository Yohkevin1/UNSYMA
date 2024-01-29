@extends('layout.main')
@section('title')
UNISEC | User
@endsection
@section('pages')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">User</li>
</ol>
<h6 class="font-weight-bolder text-white mb-0">USER</h6>
@endsection
@section('content')
<div class="card shadow-lg">
    <div class="card-body p-3">
        <h4 class="mb-1">
            List User
        </h4>
    </div>
</div>
<div class="card shadow-lg my-4">
    <div class="col-md-12">
        <div class="card" style="color: black">
            <div class="card-body p-3">
                <a href="{{ route('createUser') }}" class="btn btn-primary mb-3 btn-tambah"><i class="fas fa-plus-circle"></i> Tambah User</a>
                <div id="UserTable">
                    <table class="dataTable table table-hover table-responsive w-auto" style="color: black">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($User as $item)
                                <tr>
                                    <td width="5%">{{$no++}}</td>
                                    <td width="15%">{{$item->username}}</td>
                                    <td width="15%">{{$item->role}}</td>
                                    <td width="25%">
                                        <a class="btn btn-secondary text-white" href="{{ route('detailUser', encrypt($item->id_user)) }}">
                                            <i class="fas fa-pen-to-square"></i> Detail
                                        </a>
                                        <a class="btn btn-warning text-white" href="{{ route('updateUser', encrypt($item->id_user)) }}">
                                            <i class="fas fa-pen-to-square"></i> Ubah
                                        </a>
                                        <a class="btn btn-danger text-white" onclick="confirmDelete({{$item->id_user}})">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $item->id_user }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Yakin data dihapus?</h5>
                                                <button class="close" onclick="cancelModal({{$item->id_user}})" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">Klik "hapus" di bawah ini jika Anda yakin ingin menghapus data {{ $item->nama }}.</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" onclick="cancelModal({{$item->id_user}})">Cancel</button>
                                                <a class="btn btn-danger" href="{{ route('deleteUser', encrypt($item->id_user)) }}">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
</div>
<script>
    function confirmDelete(id) {
        $('#deleteModal' + id).modal('show');
    }
    function cancelModal(id) {
        $('#deleteModal' + id).modal('hide');
    }
</script>
@endsection