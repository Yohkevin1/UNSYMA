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
        @foreach ($data['PJ'] as $item)
            <tr>
                <td width="5%">{{$no++}}</td>
                <td width="15%">{{$item->npm}}</td>
                <td width="15%">{{$item->nama}}</td>
                <td width="15%">{{$item->prodi->nama_prodi}}</td>
                <td width="15%">{{$item->games->nama_games}}</td>
                <td width="25%">
                    <a class="btn btn-secondary text-white" href="{{ route('detailPJ', encrypt($item->id_pj)) }}">
                        <i class="fas fa-pen-to-square"></i> Detail
                    </a>
                    <a class="btn btn-warning text-white" href="{{ route('updatePJ', encrypt($item->id_pj)) }}">
                        <i class="fas fa-pen-to-square"></i> Ubah
                    </a>
                    <a class="btn btn-danger text-white" onclick="confirmDelete({{$item->id_pj}})">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </a>
                </td>
            </tr>
            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal{{ $item->id_pj }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Yakin data dihapus?</h5>
                            <button class="close" onclick="cancelModal({{$item->id_pj}})" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Klik "hapus" di bawah ini jika Anda yakin ingin menghapus data {{ $item->nama }}.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" onclick="cancelModal({{$item->id_pj}})">Cancel</button>
                            <a class="btn btn-danger" href="{{ route('deletePJ', encrypt($item->id_pj)) }}">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
</table>