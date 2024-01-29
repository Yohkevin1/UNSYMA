@extends('layout.main')
@section('title')
UNISEC | Anggota
@endsection
@section('pages')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Anggota</li>
</ol>
<h6 class="font-weight-bolder text-white mb-0">ANGGOTA</h6>
@endsection
@section('content')
<div class="card shadow-lg">
    <div class="card-body p-3">
        <h4 class="mb-1">
            List Anggota
        </h4>
    </div>
</div>
<div class="card shadow-lg my-4">
    <div class="col-md-12">
        <div class="card" style="color: black">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-3 mb-3">
                        <select class="form-control" name="TA" id="TA" onchange="Filter(this)">
                            @foreach ($data['TA'] as $kategori)
                                <option value="{{ $kategori->id_ta }}" {{ $kategori->id_ta == $data['ta'] ? 'selected' : '' }} > {{ $kategori->nama_ta }}</option>
                            @endforeach
                        </select>
                    </div> 
                    <div class="col-3">
                        <select class="form-control" name="Games" id="Games" onchange="Filter(this)">
                            <option selected value="0">Semua</option>
                            @foreach ($data['Games'] as $kategori)
                                <option value="{{ $kategori->id_games }}" @if ($data['games']!=null)
                                    {{ $kategori->id_games == $data['games']->id_games ? 'selected' : '' }}
                                @endif> {{ $kategori->nama_games }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <a href="{{ route('createAnggota') }}" class="btn btn-primary mb-3 btn-tambah"><i class="fas fa-plus-circle"></i> Tambah Anggota</a>
                <a class="btn btn-success mb-3 btn-tambah" onclick="openImportModal()">
                    <i class="fa-solid fa-file-import"></i> Import
                </a>
                <div id="AnggotaTable">
                    <table class="dataTable table table-hover table-responsive w-auto" style="color: black">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NPM</th>
                                <th>Nama</th>
                                <th>Program Studi</th>
                                <th>Games</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($data['Anggota'] as $item)
                                <tr>
                                    <td width="5%">{{$no++}}</td>
                                    <td width="15%">{{$item->npm}}</td>
                                    <td width="15%">{{$item->nama}}</td>
                                    <td width="15%">{{$item->prodi->nama_prodi}}</td>
                                    <td width="15%">{{$item->games->nama_games}}</td>
                                    <td width="25%">
                                        <a class="btn btn-secondary text-white" href="{{ route('detailAnggota', encrypt($item->id_anggota)) }}">
                                            <i class="fas fa-pen-to-square"></i> Detail
                                        </a>
                                        <a class="btn btn-warning text-white" href="{{ route('updateAnggota', encrypt($item->id_anggota)) }}">
                                            <i class="fas fa-pen-to-square"></i> Ubah
                                        </a>
                                        <a class="btn btn-danger text-white" onclick="confirmDelete({{$item->id_anggota}})">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $item->id_anggota }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Yakin data dihapus?</h5>
                                                <button class="close" onclick="cancelModal({{$item->id_anggota}})" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">Klik "hapus" di bawah ini jika Anda yakin ingin menghapus data {{ $item->nama }}.</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" onclick="cancelModal({{$item->id_anggota}})">Cancel</button>
                                                <a class="btn btn-danger" href="{{ route('deleteAnggota', encrypt($item->id_anggota)) }}">Hapus</a>
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

{{-- Modal Import --}}
<div class="modal fade" id="ImportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data Anggota</h5>
                <button class="close" onclick="cancelImport()" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('importAnggota') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <select class="form-control" name="TA" id="TA">
                        @foreach ($data['TA'] as $kategori)
                            <option value="{{ $kategori->id_ta }}" {{ $kategori->id_ta == $data['ta'] ? 'selected' : '' }} > {{ $kategori->nama_ta }}</option>
                        @endforeach
                    </select>
                    <label for="file">Masukkan File</label>
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button type="submit" class="btn btn-success">Import Data</button>
                </form>
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

    function openImportModal() {
        $('#ImportModal').modal('show');
    }

    function cancelImport() {
        $('#ImportModal').modal('hide');
    }

    
    function Filter(element)
    {
        var ta = $('#TA').val();
        var games = $('#Games').val();
        $.ajax({
            url: "{{route('Anggota')}}",
            method: "GET",
            data: {
                'TA' : ta,
                'Games' : games,
            },
            success: function(data) {
                $('#AnggotaTable').html(data);
                $('.dataTable').DataTable();
            },
        })
    }
</script>
@endsection