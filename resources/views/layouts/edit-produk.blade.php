@extends('main')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambahkan Produk</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                @if (Session::has('status'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> {{ Session::get('message') }}</h5>
                    </div>
                @endif
                <div class="form-group">
                    <label for="nama_produk">Nama Produk</label>
                    <input type="text" class="form-control" value="{{ $produk->nama_produk }}" id="nama_produk"
                        name="nama_produk" placeholder="Masukan Nama Produk" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" value="{{ $produk->harga }}" id="harga" name="harga"
                        placeholder="Masukan Harga" required>
                </div>
                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" value="{{ $produk->stok }}" id="stok" name="stok"
                        placeholder="Masukan Stok" required>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="gambar" name="gambar">
                        <label class="custom-file-label" for="gambar">Pilih Gambar</label>
                    </div>
                    <img id="preview" src="#" alt="Preview"
                        style="display: none; max-width: 200px; margin-top: 10px;">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="/produk" class="btn btn-danger float-right">Back</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('gambar').onchange = function(evt) {
            var tgt = evt.target || window.event.srcElement,
                files = tgt.files;

            // Jika ada gambar yang dipilih
            if (FileReader && files && files.length) {
                var fr = new FileReader();
                fr.onload = function() {
                    document.getElementById('preview').src = fr.result;
                    document.getElementById('preview').style.display = 'block';
                }
                fr.readAsDataURL(files[0]);

                // Update label input file dengan nama file yang dipilih
                var fileName = files[0].name;
                var label = document.querySelector('.custom-file-label');
                label.textContent = fileName;
            }
        }
    </script>
@endsection
