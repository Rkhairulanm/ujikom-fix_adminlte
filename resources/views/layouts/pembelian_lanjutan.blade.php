@extends('main')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Pembelian Produk</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="proses">
            @csrf
            <div class="card-body">
                {{-- @if (Session::has('status'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> {{ Session::get('message') }}</h5>
                    </div>
                @endif --}}
                <table id="produkTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $k)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $k->nama_produk }}</td>
                                <td>{{ $k->harga }}</td>
                                <td style="max-width: 50px">
                                    @csrf
                                    <input type="number" name="jumlah_{{ $k->produk_id }}[]" value="1" max="{{ $k->stok }}"
                                        required placeholder="Masukan Jumlah">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Subtotal -->
                <div class="form-group mt-3">
                    <label for="subtotal">Subtotal</label>
                    <input type="text" class="form-control" id="subtotal" name="subtotal" readonly>
                </div>
                <div class="form-group mt-5">
                    <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan"
                        placeholder="Masukan Nama Pelanggan" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan Alamat">
                </div>
                {{-- <div class="form-group">
                    <input type="number" class="form-control" id="notelpon" name="notelpon" value="1" min="1"
                        placeholder="Masukan No Telpon" required>
                    <small class="text-muted">Minimal pemesanan adalah 1.</small>
                </div> --}}

                <!-- Form pembayaran -->
                <h4 class="mt-5">Detail Pembayaran</h4>
                <div class="form-group">
                    <label for="bayar">Pembayaran</label>
                    <input type="number" class="form-control" id="bayar" name="bayar"
                        placeholder="Masukkan Total Pembayaran">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="/produk" class="btn btn-danger float-right">Back</a>
            </div>
        </form>
    </div>

    <script>
        // Fungsi untuk menghitung subtotal saat jumlah produk diubah
        document.querySelectorAll('input[name^="jumlah_"]').forEach(function(input) {
            input.addEventListener('change', function() {
                updateSubtotal();
            });
        });

        // Fungsi untuk mengupdate subtotal
        function updateSubtotal() {
            var total = 0;
            document.querySelectorAll('input[name^="jumlah_"]').forEach(function(input) {
                var harga = parseFloat(input.parentElement.previousElementSibling.textContent);
                var jumlah = parseInt(input.value);
                total += harga * jumlah;
            });
            document.getElementById('subtotal').value = total;
        }

        // Panggil updateSubtotal saat halaman dimuat pertama kali
        window.addEventListener('DOMContentLoaded', updateSubtotal);
    </script>
@endsection
