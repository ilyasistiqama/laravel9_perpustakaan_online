@extends('template.master')
@section('title', $judul.' Buku')

@section('content')

<div class="row">
          <!-- /.col -->
          <div class="col-md-12">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ asset('Image/Buku/'. $buku->gambar)}}"
                       alt="Not Found">
                </div>

                <h3 class="profile-username text-center">{{$buku->judul}}</h3>

                <p class="text-muted text-center">{{ $buku->pengarang }}</p>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tentang Buku</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-barcode"></i> ISBN</strong>

                <p class="text-muted">
                  {{$buku->isbn}}
                </p>

                <hr>

                <strong><i class="fas fa-clock"></i> Tahun Terbit</strong>

                <p class="text-muted">
                  {{date('d-m-Y', strtotime($buku->tahun_terbit))}}
                </p>

                <hr>

                <strong><i class="fas fa-file"></i> Jumlah Halaman</strong>

                <p class="text-muted">
                  {{$buku->jumlah_halaman}} Halaman
                </p>

                <hr>
                <strong><i class="fas fa-boxes"></i> Jumlah Stok</strong>

                <p class="text-muted">
                  {{$buku->jumlah_stok}} Buah
                </p>

                <hr>

                <strong><i class="fas fa-layer-group"></i> Jenis Kategori</strong>

                <p class="text-muted">{{$buku->Kategori->kategori}}</p>

                <hr>

                <strong><i class="fas fa-book"></i> Sinopsis</strong>

                <p class="text-muted">{{$buku->sinopsis}}</p>

                <hr>
                <div class="row">
                  <div class="col-md-6 mt-2">
                    <a href="{{route('admin.master-export-pdf-buku', base64_encode($buku->id)) }}" class="btn btn-danger btn-block" target="_blank"><b>Export PDF</b></a>
                  </div>
                  <div class="col-md-6 mt-2">
                    <a href="{{route('admin.master-buku')}}" class="btn btn-default btn-block"><b>Kembali</b></a>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

@endsection

@push('script')


@endpush