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
                <td width="15%">{{ date('l, d F Y, H:i:s', strtotime($item->opened)) }}</td>
                <td width="15%">{{ date('l, d F Y, H:i:s', strtotime($item->closed)) }}</td>
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