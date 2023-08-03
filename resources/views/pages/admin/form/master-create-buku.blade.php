@extends('template.master')
@section('title', $judul.' Buku')

@section('content')

<div class="row">
    <!-- left column -->
    <div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
        <h3 class="card-title">Form {{$judul}} Buku</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{route('admin.master-store-buku')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- select -->
            <div class="form-group">
            <label for="jenis_kategori">Jenis Kategori Buku</label>
            <select class="form-control" id="jenis_kategori" name="jenis_kategori">
                <option selected value="" disabled>Pilih Jenis kategori</option>
                @foreach($kategori as $val)
                    <option value="{{$val->id}}">{{$val->kategori}}</option>
                @endforeach
            </select>
            </div>
            <div class="form-group">
            <label for="judul">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{old('judul')}}" placeholder="Masukkan Judul">
            </div>
            <div class="form-group">
            <label for="isbn">ISBN</label>
                <input type="text" onkeypress="return /[0-9-]/i.test(event.key)" class="form-control" id="isbn" name="isbn" value="{{old('isbn')}}" placeholder="Masukkan ISBN">
            </div>
            <div class="form-group">
            <label for="pengarang">Pengarang</label>
                <input type="text" class="form-control" id="pengarang" name="pengarang" value="{{old('pengarang')}}" placeholder="Masukkan Pengarang">
            </div>
            <div class="form-group">
            <label for="jumlah_halaman">Jumlah Halaman</label>
                <input type="number" min="0" onkeypress="return /[0-9]/i.test(event.key)" class="form-control" id="jumlah_halaman" name="jumlah_halaman" value="{{old('jumlah_halaman')}}" placeholder="Masukkan Jumlah Halaman">
            </div>
            <div class="form-group">
            <label for="jumlah_stok">Jumlah Stok</label>
                <input type="number" min="0" onkeypress="return /[0-9]/i.test(event.key)" class="form-control" id="jumlah_stok" name="jumlah_stok" value="{{old('jumlah_stok')}}" placeholder="Masukkan Jumlah Stok">
            </div>
            <div class="form-group">
            <label for="tahun_terbit">Tahun Terbit</label>
                <input type="date" min="0" onkeypress="return /[0-9]/i.test(event.key)" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{old('tahun_terbit')}}" placeholder="Masukkan Tahun Terbit">
            </div>
            <div class="form-group">
            <label for="sinopsis">Sinopsis</label>
            <textarea class="form-control" id="sinopsis" name="sinopsis" rows="3" placeholder="Masukkan Sinopsis">{{ old('sinopsis') }}</textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">Gambar Buku</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="img" id="gambar" accept="image/jpeg, image/png, image/jpg">
                    <label class="custom-file-label" for="gambar" id="nama_gambar">Pilih Gambar</label>
                    </div>
                    <div class="input-group-append">
                    <span class="input-group-text">Upload</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <a href="{{route('admin.master-buku')}}" class="btn btn-default">Kembali</a>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
        </form>
    </div>
    <!-- /.card -->
    </div>
    <!--/.col (left) -->
</div>
<!-- /.row -->

@endsection

@push('script')

<script>
    $(document).ready(function(){
        $(document).on('change', '#gambar', function(e){
            let gambar = $('#gambar').val()
            $('#nama_gambar').html(gambar)
        });
    });
</script>

@endpush