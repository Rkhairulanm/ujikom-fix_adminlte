@extends('main')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                {{-- <h3 class="card-title">DataTable with minimal features & hover style</h3> --}}
                <a href="/produk-tambah" class="btn btn-success">Tambah Produk</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if (Session::has('status'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> {{ Session::get('message') }}</h5>

                    </div>
                @endif
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="max-width: 50px"><img src="{{ asset('images/' . $k->gambar) }}" alt="Product Image"
                                        style="max-width: 80px;" class="rounded "></td>
                                <td>{{ $k->nama_produk }}</td>
                                <td>{{ $k->harga }}</td>
                                <td>{{ $k->stok }}</td>
                                <td><a href="/produk-hapus/{{ $k->produk_id }}" class="btn btn-danger"
                                        onclick="return confirm('Are You sure you want to Delete this product?')">Delete</a>
                                    <a href="/produk-edit/{{ $k->produk_id }}" class="btn btn-warning">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    @endsection
