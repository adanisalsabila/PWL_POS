@extends('layouts.template')

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Supplier</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                    <li class="breadcrumb-item active">Data Supplier</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Supplier</h3>
                <div class="card-tools">
                    <button id="addSupplierBtn" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Supplier
                    </button>
                    <button id="ajaxAddSupplierBtn" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Supplier (AJAX)
                    </button>
                </div>
                
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <table id="supplierTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data Supplier will be populated via AJAX -->
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Modal Add/Edit Supplier -->
<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="supplierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supplierModalLabel">Tambah Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="supplierForm">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="contact">Kontak</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <input type="hidden" id="supplierId" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" id="saveBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
$(document).ready(function() {
    // Load Supplier Data via AJAX
    function loadSuppliers() {
        $.ajax({
            url: '{{ route("supplier.index") }}',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let rows = '';
                response.forEach(function(supplier) {
                    rows += `
                        <tr data-id="${supplier.id}">
                            <td>${supplier.name}</td>
                            <td>${supplier.contact}</td>
                            <td>${supplier.address}</td>
                            <td>
                                <button class="btn btn-warning editBtn">Edit</button>
                                <button class="btn btn-danger deleteBtn">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                $('#supplierTable tbody').html(rows);
            }
        });
    }

    loadSuppliers();  // Initial load of supplier data

    // Show modal for Add
    $('#addSupplierBtn').click(function() {
        $('#supplierModalLabel').text('Tambah Supplier');
        $('#supplierForm')[0].reset();
        $('#supplierId').val('');
        $('#supplierModal').modal('show');
    });

    // Save or Update Supplier (Modal)
    $('#saveBtn').click(function(e) {
        e.preventDefault();
        const formData = $('#supplierForm').serialize();
        const supplierId = $('#supplierId').val();

        let url = supplierId ? '/supplier/' + supplierId : '/supplier';
        let method = supplierId ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                $('#supplierModal').modal('hide');
                loadSuppliers();
                alert(response.message);
            },
            error: function(xhr) {
                alert('Error occurred. Please try again.');
            }
        });
    });

    // Edit Supplier
    $('#supplierTable').on('click', '.editBtn', function() {
        const supplierRow = $(this).closest('tr');
        const supplierId = supplierRow.data('id');

        $.ajax({
            url: '/supplier/' + supplierId + '/edit',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#supplierModalLabel').text('Edit Supplier');
                $('#name').val(response.name);
                $('#contact').val(response.contact);
                $('#address').val(response.address);
                $('#supplierId').val(response.id);
                $('#supplierModal').modal('show');
            }
        });
    });

    // Delete Supplier
    $('#supplierTable').on('click', '.deleteBtn', function() {
        const supplierRow = $(this).closest('tr');
        const supplierId = supplierRow.data('id');

        if (confirm('Are you sure you want to delete this supplier?')) {
            $.ajax({
                url: '/supplier/' + supplierId,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    loadSuppliers();
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Error occurred. Please try again.');
                }
            });
        }
    });

    // Add Supplier via AJAX (New Button)
    $('#ajaxAddSupplierBtn').click(function() {
        const supplierData = {
            name: 'Supplier ' + Date.now(),  // example name
            contact: '123456789',             // example contact
            address: 'Alamat Baru',          // example address
            _token: '{{ csrf_token() }}'     // CSRF token for security
        };

        $.ajax({
            url: '/supplier',
            method: 'POST',
            data: supplierData,
            success: function(response) {
                loadSuppliers();
                alert('Supplier added successfully via AJAX!');
            },
            error: function(xhr) {
                alert('Error occurred. Please try again.');
            }
        });
    });
});
</script>
@endpush
