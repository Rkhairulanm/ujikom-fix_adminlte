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
                            <th>Total Pemesanan</th>
                            <th>Total Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="max-width: 50px"><img src="{{ asset('images/' . $k->gambar) }}"
                                        alt="Product Image" style="max-width: 80px;" class="rounded "></td>
                                <td>{{ $k->nama_produk }}</td>
                                <td>{{ $k->detailPenjualans->sum('jumlah') }}</td>
                                <td>{{ $k->detailPenjualans->sum('subtotal') }}</td>
                                <td>
                                    <a href="/detail-pembelian/{{ $k->produk_id }}" class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                        @endforeach

                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    @endsection
