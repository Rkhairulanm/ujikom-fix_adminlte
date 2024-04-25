<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cash-E | {{ $title }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://kit.fontawesome.com/04deebaf3b.js" crossorigin="anonymous"></script>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .dashed-line {
        border-top: 1px dashed #9fa6b2;
        width: 100%;
        margin: 20px 0;
    }
</style>
<div class="container pt-5">
    <div class="row">
        <div class="col">
            <center>
                <h3 class="mt-3 text-center d-print-none text-xl">Struk Pembelian</h3>
                <a href="/pembelian" class="btn btn-danger d-print-none  my-3">Back</a>
            </center>
        </div>
    </div>
    <div class="row mt-3 justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <center>
                        <h5 class="text-bold"><b>Cash-E App</b></h5>
                        {{-- if has img --}}
                        {{-- <img src="{{ asset('/storage/image/' . $produk->image) }}" alt="" class="rounded-circle"
                            style="max-width: 100; max-height:100px"> --}}
                    </center>
                    <div class="dashed-line"></div>
                    <h6 class="text-secondary">Waktu <span class="float-right">{{ $currentTime }}</span></h6>
                    <h6 class="text-secondary">No.Struk <span class="float-right">{{ $noStruk }}</span></h6>
                    <h6 class="text-secondary">Nama Petugas <span class="float-right">{{ $petugasName }}</span></h6>
                    <h6 class="text-secondary">Nama Pelanggan <span class="float-right">{{ $data_pelanggan }}</span></h6>
                    <div class="dashed-line"></div>
                    <div>
                        <h6 class="text-secondary">Produk</h6>
                        @foreach ($pembelianDetail as $detail)
                            <h6 class="text-secondary mt-0 text-sm">{{ $detail['produk'] }} x
                                {{ $detail['jumlah'] }} <span class="float-right">Rp.{{ $detail['subtotal'] }}</span>
                            </h6>
                        @endforeach


                    </div>

                    <div class="dashed-line"></div>
                    <h3 class="text-dark font-weight-bold">Total <span class="float-right">Rp.{{ $totalHargaKeseluruhan }}</span></h3>
                    <h3 class="text-dark font-weight-bold">Kembalian <span class="float-right">Rp.{{ $kembalian }}</span></h3>
                    <div class="dashed-line"></div>
                    <h6 class="text-secondary">Bayar
                        @if ($bayar !== null)
                            <span class="float-end">Rp.{{ $bayar }}</span>
                        @else
                            <span class="float-end">Kasbon</span>
                        @endif
                    </h6>
                    @if ($bayar !== null)
                        <h6 class="text-secondary">Kembalian <span
                                class="float-end">Rp.{{ $bayar - $totalHargaKeseluruhan }}</span></h6>
                    @endif
                    <h6 class="text-secondary mx-auto d-flex justify-content-center mt-4">
                        <span class="float-end">
                            @if ($bayar !== null)
                                @if ($bayar - $totalHargaKeseluruhan >= 0)
                                    <span class="badge bg-gradient-success">Lunas</span>
                                @elseif ($bayar - $totalHargaKeseluruhan != 0)
                                    <span class="badge bg-gradient-warning">Belum Lunas</span>
                                @endif
                            @else
                                <span class="badge bg-gradient-danger">Belum Bayar</span>
                            @endif

                        </span>
                    </h6>
                </div>

            </div>
            <div class=" text-center mt-5">
                <!-- Tombol cetak dan unduh (tambahkan kelas 'no-print') -->
                <button class="btn btn-primary d-print-none" onclick="cetakAndRedirect()">Cetak</button>
                <a href="/downloadStruk" class="btn btn-success d-print-none" onclick="unduhPembelian()">Unduh</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function cetakAndRedirect() {
        window.print();
        setTimeout(function() {
            window.location.href = "/pembelian";
        }, 1000); // Delay 1 detik sebelum mengarahkan kembali
    }

    function unduhPembelian() {
        // Logika unduh pembelian (ganti dengan kode yang sesuai)
        console.log('Pembelian diunduh');
    }
</script>
