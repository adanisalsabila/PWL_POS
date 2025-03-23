@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Stok</h3>
    </div>
    <div class="card-body">
        <a href="{{ route('stok.create') }}" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tambah Stok
        </a>
        <a href="{{ route('stok.create_ajax') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Tambah Stok (AJAX)
        </a>

        <table id="stok-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Barang ID</th>
                    <th>User ID</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rows will be inserted dynamically -->
            </tbody>
        </table>
        
        <!-- Modal for showing details -->
        <div class="modal fade" id="stokDetailsModal" tabindex="-1" role="dialog" aria-labelledby="stokDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stokDetailsModalLabel">Detail Stok</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div><strong>Barang ID:</strong> <span id="detailBarangId"></span></div>
                        <div><strong>User ID:</strong> <span id="detailUserId"></span></div>
                        <div><strong>Tanggal:</strong> <span id="detailTanggal"></span></div>
                        <div><strong>Jumlah:</strong> <span id="detailJumlah"></span></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

@include('stok.confirm_ajax')

@endsection

@push('js')
<script>
    $(document).ready(function() {
    $('#stok-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('stok.list') !!}', // URL to fetch data
        columns: [
            { data: 'stok_id', name: 'stok_id' },
            { data: 'barang_id', name: 'barang_id' },
            { data: 'user_id', name: 'user_id' },
            { data: 'stok_tanggal', name: 'stok_tanggal' },
            { data: 'stok_jumlah', name: 'stok_jumlah' },
            {
                data: 'aksi',
                name: 'aksi',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-info view-details" data-id="${row.stok_id}">Detail</button>
                        <form action="/stok/${row.stok_id}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                        </form>
                    `;
                }
            }
        ]
    });

    // View details button click event
    $(document).on('click', '.view-details', function() {
        var id = $(this).data('id');

        $.ajax({
            url: '/stok/' + id,
            type: 'GET',
            success: function(response) {
                // Populate modal with details
                $('#detailBarangId').text(response.stok.barang_id);
                $('#detailUserId').text(response.stok.user_id);
                $('#detailTanggal').text(response.stok.stok_tanggal);
                $('#detailJumlah').text(response.stok.stok_jumlah);

                // Show modal
                $('#stokDetailsModal').modal('show');
            },
            error: function(error) {
                console.error(error);
                alert('Terjadi kesalahan.');
            }
        });
    });

    // Delete (AJAX) button click event
    $(document).on('click', '.delete-ajax', function() {
        var id = $(this).data('id');
        $('#confirmDeleteModal').modal('show');

        $('#confirmDeleteButton').click(function() {
            $.ajax({
                url: "/stok/" + id,
                type: "DELETE",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $('#stok-table').DataTable().ajax.reload();
                    } else {
                        alert('Gagal menghapus stok.');
                    }
                    $('#confirmDeleteModal').modal('hide');
                },
                error: function(error) {
                    console.error(error);
                    alert('Terjadi kesalahan.');
                    $('#confirmDeleteModal').modal('hide');
                }
            });
        });
    });
});

</script>
@endpush
