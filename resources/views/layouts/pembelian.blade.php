@extends('main')
@section('content')
    <form action="/pembelian-lanjutan">
        @method('GET')
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title text-xl my-2">Pembelian</h1>
                    </div>
                    <div class="card-body">
                        @if (Session::has('status'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> {{ Session::get('message') }}</h5>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                @foreach ($errors->all() as $item)
                                    <h5> {{ $item }}</h5>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari produk...">
                        </div>
                        <table id="produkTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produk as $k)
                                    @if ($k->stok != 0)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ asset('images/' . $k->gambar) }}" alt="Product Image"
                                                    style="max-width: 80px;"></td>
                                            <td>{{ $k->nama_produk }}</td>
                                            <td>{{ $k->harga }}</td>
                                            <td>
                                                <input type="checkbox" class="produk-checkbox"
                                                    id="produk_{{ $k->produk_id }}" name="produk_id[]"
                                                    value="{{ $k->produk_id }}">
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" style="max-height: 400px; overflow-y: auto;">
                    <div class="card-header">
                        <h1 class="card-title text-xl my-2">Produk yang Dipilih</h1>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody id="selectedProducts">

                            </tbody>
                        </table>
                        <div class=""><button type="submit" class="btn btn-success btn-block">Checkout</button></div>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <script>
        // Fungsi untuk menampilkan produk yang dipilih
        function showSelectedProducts() {
            // Bersihkan daftar produk yang dipilih sebelum menambahkan yang baru
            document.getElementById('selectedProducts').innerHTML = '';

            // Dapatkan semua checkbox yang dicentang
            var checkboxes = document.querySelectorAll('.produk-checkbox:checked');

            // Variabel untuk menyimpan total harga produk yang dipilih
            var totalHarga = 0;

            // Buat elemen untuk setiap produk yang dicentang dan tambahkan ke daftar produk yang dipilih
            checkboxes.forEach(function(checkbox) {
                var productId = checkbox.value;
                var productName = checkbox.parentElement.parentElement.cells[2].textContent;
                var productPrice = parseFloat(checkbox.parentElement.parentElement.cells[3]
                    .textContent); // Harga sebagai angka desimal
                var productImage = checkbox.parentElement.parentElement.cells[1].querySelector('img').src;

                var productRow = document.createElement('tr');

                // Tambahkan atribut data-harga pada baris produk untuk menyimpan harga produk
                productRow.setAttribute('data-harga', productPrice);

                productRow.innerHTML = `
                    <td><img src="${productImage}" alt="${productName}" style="max-width: 80px;"></td>
                    <td>${productName}</td>
                    <td>Rp ${productPrice.toFixed(2)}</td>  `; // Tampilkan subtotal
                document.getElementById('selectedProducts').appendChild(productRow);

                // Tambahkan harga produk ke totalHarga
                totalHarga += productPrice;
            });

            // Tampilkan total harga produk yang dipilih di bagian bawah tabel
            document.getElementById('totalHarga').innerText = 'Total Harga: Rp ' + totalHarga.toFixed(2);
        }

        // Panggil fungsi showSelectedProducts setiap kali ada perubahan pada checkbox
        var checkboxes = document.querySelectorAll('.produk-checkbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', showSelectedProducts);
        });

        // Panggil showSelectedProducts sekali saat halaman dimuat untuk menampilkan produk yang dipilih awal
        window.addEventListener('DOMContentLoaded', showSelectedProducts);

        // Fungsi untuk melakukan pencarian
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("produkTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2]; // Kolom dengan nama produk
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        });
    </script>
@endsection
