@extends('main')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg mb-5">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card mb-4 px-3">
                        <div class="card-header pb-0">
                            <h4 class="text-center">Detail Pembelian</h4>
                            <hr class="bg-dark px-auto">
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <!-- Informasi Pembelian -->
                            @if (Session::has('status'))
                                <div class="alert alert-success text-white opacity-5" role="alert">
                                    {{ Session::get('message') }}
                                </div>
                            @endif
                            <div class="info">
                                <div class="info-item">
                                    <span class="info-label">Nama : </span>
                                    <span class="info-value"><u>{{ $pelanggan->nama_pelanggan }}</u></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Total : </span>
                                    @php
                                        $totalPembelian = $pelanggan->pembelian->sum('total');
                                        $sisaPembayaran = $totalPembelian - $pembayaran['pembayaran'];
                                        $totalTampil = max(0, $sisaPembayaran);
                                    @endphp
                                    <span class="info-value"><u>{{ $totalTampil }}</u></span>
                                </div>

                                <div class="info-item">
                                    <span class="info-label">Status : </span>
                                    @php
                                        $kasbon = false;
                                        $totalPembelian = $pelanggan->pembelian->sum('total');
                                        $totalPembayaran = $pelanggan->pembelian->sum('pembayaran');
                                        if ($totalPembayaran < $totalPembelian && $totalPembayaran != 0) {
                                            echo '<span class="badge badge-sm bg-gradient-warning">Belum Lunas</span>';
                                        } else {
                                            foreach ($pelanggan->pembelian as $pembelian) {
                                                if ($pembelian->pembayaran === null) {
                                                    $kasbon = true;
                                                    break;
                                                }
                                            }
                                            if ($kasbon) {
                                                echo '<span class="badge badge-sm bg-gradient-danger">Kasbon</span>';
                                            } else {
                                                echo '<span class="badge badge-sm bg-gradient-success">Lunas</span>';
                                            }
                                        }
                                    @endphp
                                </div>
                            </div>

                            <!-- Tabel Detail Pembelian -->
                            <div class="table-responsive pt-2">
                                <table class="table table-striped table-bordered table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">Foto</th>
                                            <th scope="col">Produk</th>
                                            <th scope="col">Jumlah Pembelian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pelanggan->pembelian as $pembelian)
                                            @foreach ($pembelian->produk as $produk)
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset('/storage/image/' . $produk->image) }}"
                                                            class="card-img"
                                                            style="object-fit: cover;max-width: 100px; max-height: 100px;"
                                                            alt="...">
                                                    </td>
                                                    <td>{{ $produk->nama_produk }}</td>
                                                    <td>{{ $pembelian->jumlah }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach

                                    </tbody>
                                </table>

                                <!-- Form Pembayaran -->
                                @if ($pelanggan->pembayaran == null)
                                    <form action="/pembayaran/{{ $pelanggan->pelanggan_id }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="pelanggan_id" value="{{ $pelanggan->pelanggan_id }}">
                                        <div class="form-group mb-3">
                                            <label for="pembayaran" class="form-label">Pembayaran:</label>
                                            <input type="number" class="form-control" id="pembayaran" name="pembayaran"
                                                required>
                                        </div>
                                        <center>
                                            <button type="submit" class="btn btn-primary">Submit Pembayaran</button>
                                        </center>
                                    </form>
                                @endif


                            </div>
                        </div>
                    </div>
                    <center>
                        <div class="card-footer mb-1">
                            <a href="/pelanggan" class="btn btn-secondary">Back</a>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </main>
@endsection
