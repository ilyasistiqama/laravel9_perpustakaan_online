@extends('template.master')
@section('title', 'Buku')

@section('content')

<div class="row">
          <div class="col-12">
            <div class="card">
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-list-buku-tab" data-toggle="pill" href="#tab-list-buku" role="tab" aria-controls="tab-list-buku" aria-selected="true">List Buku</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-content-below-peminjaman-tab" data-toggle="pill" href="#list-peminjaman" role="tab" aria-controls="list-peminjaman" aria-selected="false">Peminjaman</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-content-below-pengembalian-tab" data-toggle="pill" href="#list-pengembalian" role="tab" aria-controls="list-pengembalian" aria-selected="false">Pengembalian</a>
                  </li>
              </ul>
              <div class="card-body">
                  <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade show active" id="tab-list-buku" role="tabpanel" aria-labelledby="custom-content-below-list-buku-tab">
                      <div class="row mb-3">
                        <div class="col-md-10">
                          <input type="text" class="form-control mt-2" id="search" name="search" placeholder="Search:">
                        </div>
                        <div class="col-md-2">
                          <button type="button" class="btn btn-primary btn-search col-12 btn-search mt-2"><i class="fas fa-search"></i>  Search</button>
                        </div>
                      </div>
                      <table id="datatable" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th class="text-center">Cover Buku</th>
                          <th class="text-center">Judul</th>
                          <th class="text-center">ISBN</th>
                          <th class="text-center">Pengarang</th>
                          <th class="text-center">Sinopsis</th>
                          <th class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="list-peminjaman" role="tabpanel" aria-labelledby="custom-content-below-peminjaman-tab">
                      <table id="datatable-peminjaman" class="table table-bordered table-hover w-100">
                        <thead>
                        <tr>
                          <th class="text-center">Cover Buku</th>
                          <th class="text-center">Judul</th>
                          <th class="text-center">Peminjaman</th>
                          <th class="text-center">Pengembalian</th>
                          <th class="text-center">Status</th>
                          <th class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="list-pengembalian" role="tabpanel" aria-labelledby="custom-content-below-pengembalian-tab">
                      <table id="datatable-pengembalian" class="table table-bordered table-hover w-100">
                        <thead>
                        <tr>
                          <th class="text-center">Cover Buku</th>
                          <th class="text-center">Judul</th>
                          <th class="text-center">Peminjaman</th>
                          <th class="text-center">Pengembalian</th>
                          <th class="text-center">Status</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                      </table>
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

      <!-- /.modal detail buku -->
      <div class="modal fade" id="modal-detail">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detail Buku</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              <div class="modal-body">
              <div class="row">
                  <!-- /.col -->
                  <div class="col-md-12">

                  <!-- Profile Image -->
                  <div class="card card-primary card-outline">
                      <div class="card-body box-profile">
                        <div class="text-center">
                          <img class="profile-user-img img-fluid img-circle detail-gambar"
                              src=""
                              alt="Not Found">
                        </div>

                        <h3 class="profile-username text-center detail-judul">Judul</h3>

                        <p class="text-muted text-center detail-pengarang">Pengarang</p>

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

                        <p class="text-muted detail-isbn">
                          ISBN
                        </p>

                        <hr>

                        <strong><i class="fas fa-clock"></i> Tahun Terbit</strong>

                        <p class="text-muted detail-tahun-terbit">
                          Tahun Terbit
                        </p>

                        <hr>

                        <strong><i class="fas fa-file"></i> Jumlah Halaman</strong>

                        <p class="text-muted detail-jumlah-halaman">
                          0 Halaman
                        </p>

                        <hr>
                        <strong><i class="fas fa-boxes"></i> Jumlah Stok</strong>

                        <p class="text-muted detail-jumlah-stok">
                          0 Buah
                        </p>

                        <hr>

                        <strong><i class="fas fa-layer-group"></i> Jenis Kategori</strong>

                        <p class="text-muted detail-jenis-kategori">Kategori</p>

                        <hr>

                        <strong><i class="fas fa-book"></i> Sinopsis</strong>

                        <p class="text-muted detail-sinopsis">Sinopsis</p>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      
      <!-- /.modal pinjam buku -->
      <div class="modal fade" id="modal-pinjam">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pinjam Buku</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('/Image/warning.png') }}" alt="" class="d-block" style="height: 100px; width: 110px;">
                  </div>
                  <div class="d-flex justify-content-center">
                    <h5 class="text-red"><b>Perhatian</b></h5>
                  </div>
                  <div class="d-flex justify-content-justify">
                    <p>Saat Peminjaman Buku, Wajib Memberikan <b>KTP</b> atau <b>Kartu Tanda Pengenal Lain</b> Sebagai Jaminan untuk Dilakukan Verifikasi Peminjaman oleh Petugas Perpustakaan. Bersediakah Anda ?</p>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary simpan-pinjam-buku">Pinjam</button>
              </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      
      <!-- /.modal kembali buku -->
      <div class="modal fade" id="modal-kembali">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pengembalian Buku</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <img src="" alt="" class="d-block image-modal-pengembalian" style="height: 100px; width: 110px;">
                  </div>
                  <div class="d-flex justify-content-center">
                    <h5 class="text-red title-modal-pengembalian"></h5>
                  </div>
                  <div class="d-flex justify-content-justify">
                    <p class="message-check-denda"></p>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary d-none simpan-kembalikan-buku">Kembalikan</button>
              </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
@endsection

@push('script')

<script>
  $(document).ready(function(){
    /*          FUNGSI          */
    const datatable = () => {
      $('#datatable').DataTable({
        "paging": true,
        // "scrollX": true,
        "lengthChange": true,
        "searching": false,
        "ordering": true,
        "aaSorting": [],
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "serverSide": true,
        "processing": true,
        "language": 
        {          
          "processing": ` <div class='spinner-border text-dark mt-3' role='status'>
                              <span class='sr-only'>Loading...</span>
                        </div>
                        <p>Mohon Tunggu..</p>`,
        },
        "ajax": {
          "url": "/member/ajax/datatable-member-buku",
          "type": "get",
          "data": {
            search: $('#search').val()
          }
        },
        "columns": [
          {"data": "gambar", "name": "gambar"},
          {"data": "judul", "name": "judul"},
          {"data": "isbn", "name": "isbn"},
          {"data": "pengarang", "name": "pengarang"},
          {"data": "sinopsis", "name": "sinopsis"},
          {"data": "aksi", "name": "aksi"},
        ]
      });
    }
    
    const datatablePeminjaman = () => {
      $('#datatable-peminjaman').DataTable({
        "paging": true,
        // "scrollX": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "serverSide": true,
        "processing": true,
        "language": 
        {          
          "processing": ` <div class='spinner-border text-dark mt-3' role='status'>
                              <span class='sr-only'>Loading...</span>
                        </div>
                        <p>Mohon Tunggu..</p>`,
        },
        "ajax": {
          "url": "/member/ajax/datatable-member-peminjaman",
          "type": "get",
          "data": {
          }
        },
        "columns": [
          {"data": "gambar", "name": "gambar"},
          {"data": "judul", "name": "judul"},
          {"data": "tanggal_pinjam", "name": "tanggal_pinjam"},
          {"data": "tanggal_kembali", "name": "tanggal_kembali"},
          {"data": "status", "name": "status"},
          {"data": "aksi", "name": "aksi"},
        ]
      });
    }
    
    const datatablePengembalian = () => {
      $('#datatable-pengembalian').DataTable({
        "paging": true,
        // "scrollX": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "serverSide": true,
        "processing": true,
        "language": 
        {          
          "processing": ` <div class='spinner-border text-dark mt-3' role='status'>
                              <span class='sr-only'>Loading...</span>
                        </div>
                        <p>Mohon Tunggu..</p>`,
        },
        "ajax": {
          "url": "/member/ajax/datatable-member-pengembalian",
          "type": "get",
          "data": {
          }
        },
        "columns": [
          {"data": "gambar", "name": "gambar"},
          {"data": "judul", "name": "judul"},
          {"data": "tanggal_pinjam", "name": "tanggal_pinjam"},
          {"data": "tanggal_kembali", "name": "tanggal_kembali"},
          {"data": "status", "name": "status"},
        ]
      });
    }

    /*          FUNGSI          */

    
    $(document).on('click', '#custom-content-below-list-buku-tab', function(){
      $('#datatable').DataTable().destroy();
      datatable()
    });

    $(document).on('click', '#custom-content-below-peminjaman-tab', function(){
      $('#datatable-peminjaman').DataTable().destroy();
      datatablePeminjaman()
    });

    $(document).on('click', '#custom-content-below-pengembalian-tab', function(){
      $('#datatable-pengembalian').DataTable().destroy();
      datatablePengembalian()
    });

    $('#custom-content-below-list-buku-tab').click();

    /*          INISIASI          */
    let id = null;
    let gambar = null;
    let judul = null;
    let pengarang = null;
    let isbn = null;
    let tahun_terbit = null;
    let jumlah_halaman = null;
    let jumlah_stok = null;
    let sinopsis = null;
    let id_for_pinjam = null;
    let id_for_kembalikan = null;

    /*          INISIASI          */

    $(document).on('click', '.btn-search', function(){
      $('#datatable').DataTable().destroy();
      datatable();
    });


    $(window).on('hide.bs.modal', function() {
        id_for_pinjam = null;
        id_for_kembalikan = null;
        if($('.simpan-kembalikan-buku').hasClass('d-block')){
          $('.simpan-kembalikan-buku').removeClass('d-block').addClass('d-none');
        }
    });


    /*          DETAIL BUKU          */
    $(document).on('click', '.btn-open-modal-detail', function(){
      id = $(this).attr('data-id')
      $.ajax({
        url: '/member/ajax/get-detail-buku-from-member',
        method: 'get',
        data: {
          id: id
        },
        success:function(res){
            if(res.data.length != 0){
              let formatDate = moment(res.data.tahun_terbit).format('DD-MM-YYYY');

              $('.detail-gambar').attr('src', '/Image/Buku/'+ res.data.gambar);
              $('.detail-judul').html(res.data.judul);
              $('.detail-pengarang').html(res.data.pengarang);
              $('.detail-isbn').html(res.data.isbn);
              $('.detail-tahun-terbit').html(formatDate);
              $('.detail-jumlah-halaman').html(res.data.jumlah_halaman + ' Halaman');
              $('.detail-jumlah-stok').html(res.data.jumlah_stok + ' Buah');
              $('.detail-jenis-kategori').html(res.data_kategori.kategori);
              $('.detail-sinopsis').html(res.data.sinopsis);
              return $('#modal-detail').modal('show');
            }
        }
      })
    });
    /*          DETAIL BUKU          */

    /*          PINJAM BUKU          */
    $(document).on('click', '.btn-open-modal-pinjam', function(){
      id_for_pinjam = $(this).attr('data-id')
      return $('#modal-pinjam').modal('show');
    });

    $(document).on('click', '.simpan-pinjam-buku', function(){
      $.ajax({
        url: '/member/ajax/pinjam-buku',
        method: 'post',
        data:{
          id: id_for_pinjam
        },
        success:function(res){
          if(res.status == 200){
            $('#modal-pinjam').modal('toggle');
            id_for_pinjam = null
              Toast.fire({
                icon: 'success',
                title: res.message
              })
              $('#datatable').DataTable().ajax.reload();
          }else{
              Toast.fire({
                icon: 'error',
                title: res.message
              })
          }
        }
      });
    });
    /*          PINJAM BUKU          */
    
    /*          KEMBALIKAN BUKU          */
    $(document).on('click', '.btn-open-modal-kembalikan', function(){
      id_for_kembalikan = $(this).attr('data-id')
      $.ajax({
        url:'/member/ajax/check-pengembalian-telat',
        method: 'get',
        data:{
          id: id_for_kembalikan
        }, 
        success:function(res){
          if(res.status == 200){
            if(res.type == 1){
              $('.image-modal-pengembalian').attr('src', "/Image/warning.png");
              $('.title-modal-pengembalian').html('Perhatian');
              $('.message-check-denda').html(res.message);
            }else{
              $('.image-modal-pengembalian').attr('src', "/Image/success.png");
              $('.title-modal-pengembalian').html('Sukses');
              $('.message-check-denda').html(res.message);
              $('.simpan-kembalikan-buku').removeClass('d-none').addClass('d-block');
            }
            return $('#modal-kembali').modal('show');
          }else{
              $('.image-modal-pengembalian').attr('src', "/Image/warning.png");
              $('.title-modal-pengembalian').html('Perhatian');
              $('.message-check-denda').html(res.message);
              return $('#modal-kembali').modal('show');
          }
        }
      })
    });

    $(document).on('click', '.simpan-kembalikan-buku', function(){
      $.ajax({
        url: '/member/ajax/kembalikan-buku',
        method: 'post',
        data:{
          id: id_for_kembalikan
        },
        success:function(res){
          if(res.status == 200){
            $('#modal-kembali').modal('toggle');
            id_for_kembalikan = null
              Toast.fire({
                icon: 'success',
                title: res.message
              })
              $('#datatable-peminjaman').DataTable().ajax.reload();
            }else{
              Toast.fire({
                icon: 'error',
                title: res.message
              })
              $('#datatable-peminjaman').DataTable().ajax.reload();
          }
        }
      });
    });
    /*          KEMBALIKAN BUKU          */

  });

</script>

@endpush