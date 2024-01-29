@extends('layout.main')
@section('title')
UNISEC | Kehadiran
@endsection
@section('pages')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Kehadiran</a></li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Kehadiran</li>
</ol>
<h6 class="font-weight-bolder text-white mb-0">KEHADIRAN</h6>
@endsection
@section('content')
<div class="card shadow-lg">
    <div class="card-body p-3">
        <h4 class="mb-1">
            List Kehadiran
        </h4>
    </div>
</div>
<div class="card shadow-lg my-4">
    <div class="col-md-12">
        <div class="card" style="color: black">
            <div class="card-body p-3">
                <div id="KehadiranTable">
                    <div class="row mb-3">
                        <div class="col-3">
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
                                    <option value="{{ $kategori->id_games }}" @if ($data['games']!=0)
                                        {{ $kategori->id_games == $data['games'] ? 'selected' : '' }}
                                    @endif> {{ $kategori->nama_games }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <select class="form-control" name="Pertemuan" id="Pertemuan" onchange="Filter(this)">
                                <option selected value="0">Semua</option>
                                @foreach ($data['Pertemuan'] as $kategori)
                                    <option value="{{ $kategori->id_pertemuan }}" @if ($data['pertemuan']!=0)
                                        {{ $kategori->id_pertemuan == $data['pertemuan'] ? 'selected' : '' }}
                                    @endif> {{ $kategori->meet }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-block mb-2">
                        <a href="{{ route('createKehadiran') }}" class="btn btn-primary mb-3 btn-tambah"><i class="fas fa-plus-circle"></i> Tambah Kehadiran</a>
                        <a class="btn btn-success mb-3 btn-tambah" href="{{ route('Export', ['ta' => $data['ta'], 'pertemuan' => $data['pertemuan'], 'games' => $data['games']]) }}">
                            <i class="fa-solid fa-file-excel"></i> Export
                        </a>
                    </div>
                    <table class="dataTable table table-hover table-responsive w-auto" style="color: black">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Meet</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Verifikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($data['Kehadiran'] as $item)
                                <tr>
                                    <td width="5%">{{$no++}}</td>
                                    <td width="15%">{{$item->anggota->nama}}</td>
                                    <td width="15%">{{$item->pertemuan->meet}}</td>
                                    <td width="15%">{{$item->status}}</td>
                                    <td width="15%">{{ date('d F Y, H:i:s', strtotime($item->created_at)) }}</td>
                                    <td width="15%">{{ $item->verifikasi ? date('d F Y, H:i:s', strtotime($item->verifikasi)) : null }}</td>
                                    <td width="25%">
                                        @if (!$item->verifikasi && $item->status == 'Hadir')
                                            <a href="{{ route('verifikasi', ['pertemuan' => encrypt($item->id_pertemuan), 'anggota' => encrypt($item->id_anggota)]) }}" class="btn btn-info text-white">
                                                <i class="fa-solid fa-check-to-slot"></i> Verifikasi
                                            </a>
                                        @endif
                                        <a href="{{ route('updateKehadiran', ['pertemuan' => encrypt($item->id_pertemuan), 'anggota' => encrypt($item->id_anggota)]) }}" class="btn btn-warning text-white">
                                            <i class="fas fa-pen-to-square"></i> Ubah
                                        </a>
                                        <a class="btn btn-danger text-white" onclick="confirmDelete({{$item->id_pertemuan}},{{$item->id_anggota}})">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $item->id_pertemuan }}{{ $item->id_anggota }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Yakin data dihapus?</h5>
                                                <button class="close" onclick="cancelModal({{$item->id_pertemuan}},{{$item->id_anggota}})" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">Klik "hapus" di bawah ini jika Anda yakin ingin menghapus data Presensi {{$item->anggota->nama}} di {{$item->pertemuan->meet}}.</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" onclick="cancelModal({{$item->id_pertemuan}},{{$item->id_anggota}})">Cancel</button>
                                                <a class="btn btn-danger" href="{{ route('deleteKehadiran', ['pertemuan' => encrypt($item->id_pertemuan), 'anggota' => encrypt($item->id_anggota)]) }}">Hapus</a>
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
    function confirmDelete(pertemuan, anggota) {
        $('#deleteModal' + pertemuan + anggota).modal('show');
    }
    function cancelModal(pertemuan, anggota) {
        $('#deleteModal' + pertemuan + anggota).modal('hide');
    }
    function Filter(element)
    {
        var ta = $('#TA').val();
        var games = $('#Games').val();
        var pertemuan = $('#Pertemuan').val();
        $.ajax({
            url: "{{route('Kehadiran')}}",
            method: "GET",
            data: {
                'TA' : ta,
                'Games' : games,
                'Pertemuan' : pertemuan,
            },
            success: function(data) {
                $('#KehadiranTable').html(data);
                $('.dataTable').DataTable();
            },
        })
    }

    //     $('#exportBtn').html('<i class="fas fa-spinner fa-spin"></i> Exporting...');
</script>
@endsection