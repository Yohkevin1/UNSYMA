@extends('layout.main')
@section('title')
UNISEC | Pertemuan
@endsection
@section('pages')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pertemuan</a></li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Pertemuan</li>
</ol>
<h6 class="font-weight-bolder text-white mb-0">PERTEMUAN</h6>
@endsection
@section('content')
<div class="card shadow-lg">
    <div class="card-body p-3">
        <h4 class="mb-1">
            List Pertemuan
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
                <a href="{{ route('createPertemuan') }}" class="btn btn-primary mb-3 btn-tambah"><i class="fas fa-plus-circle"></i> Tambah Pertemuan</a>
                <div id="PertemuanTable">
                    <table class="dataTable table table-hover table-responsive w-auto" style="color: black">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Games</th>
                                <th>Opened</th>
                                <th>Closed</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($data['Pertemuan'] as $item)
                                <tr>
                                    <td width="5%">{{$no++}}</td>
                                    <td width="15%">{{$item->meet}}</td>
                                    <td width="15%">{{$item->games->nama_games}}</td>
                                    <td width="15%">{{ date('d F Y, H:i:s', strtotime($item->opened)) }}</td>
                                    <td width="15%">{{ date('d F Y, H:i:s', strtotime($item->closed)) }}</td>
                                    <td width="25%">
                                        <a class="btn btn-warning text-white" href="{{ route('updatePertemuan', encrypt($item->id_pertemuan)) }}">
                                            <i class="fas fa-pen-to-square"></i> Ubah
                                        </a>
                                        <a class="btn btn-danger text-white" onclick="confirmDelete({{$item->id_pertemuan}})">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $item->id_pertemuan }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Yakin data dihapus?</h5>
                                                <button class="close" onclick="cancelModal({{$item->id_pertemuan}})" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">Klik "hapus" di bawah ini jika Anda yakin ingin menghapus data {{ $item->meet }}.</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" onclick="cancelModal({{$item->id_pertemuan}})">Cancel</button>
                                                <a class="btn btn-danger" href="{{ route('deletePertemuan', encrypt($item->id_pertemuan)) }}">Hapus</a>
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
    function Filter(element)
    {
        var ta = $('#TA').val();
        var games = $('#Games').val();
        $.ajax({
            url: "{{route('Pertemuan')}}",
            method: "GET",
            data: {
                'TA' : ta,
                'Games' : games,
            },
            success: function(data) {
                $('#PertemuanTable').html(data);
                $('.dataTable').DataTable();
            },
        })
    }
</script>
@endsection