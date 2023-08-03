@extends('template.master')
@section('title', 'Master Kategori Buku')

@section('content')

<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List Kategori Buku</h3>
                <!-- card tools -->
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#modal-tambah">
                    <i class="fas fa-plus mr-2"></i> Tambah Kategori
                    </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-10">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Search:">
                  </div>
                  <div class="col-2">
                    <button type="button" class="btn btn-primary btn-search col-12 btn-search"><i class="fas fa-search"></i>  Search</button>
                  </div>
                </div>
                <table id="datatable" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th class="text-center" style="width: 15px;">No.</th>
                    <th class="text-center">Jenis Kategori</th>
                    <th class="text-center" style="width:10%;">#</th>
                  </tr>
                  </thead>
                  <tbody></tbody>
                </table>
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        
        
        <!-- /.modal tambah kategori -->
        <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Kategori</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="tambah-kategori">
              <div class="modal-body">
                <div class="form-group">
                  <label for="add-kategori">Jenis Kategori</label>
                  <input type="text" class="form-control" id="add-kategori" name="kategori" placeholder="Masukkan Jenis Kategori">
                  <small id="err-add-kategori" class="form-text text-muted d-none text-red">Jenis Kategori Tidak Boleh Kosong</small>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary simpan-tambah-kategori">Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
        
      <!-- /.modal edit kategori -->
      <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Kategori</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="update-kategori">
              <div class="modal-body">
                <div class="form-group">
                  <label for="edit-kategori">Jenis Kategori</label>
                  <input type="hidden" name="id_kategori" id="id-kategori">
                  <input type="text" class="form-control" id="edit-kategori" name="kategori" placeholder="Masukkan Jenis Kategori">
                  <small id="err-edit-kategori" class="form-text text-muted d-none text-red">Jenis Kategori Tidak Boleh Kosong</small>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary simpan-edit-kategori">Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      
      <!-- /.modal detail kategori -->
      <div class="modal fade" id="modal-detail">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detail Kategori - <b id="nama_kategori"></b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              <div class="modal-body">
                <div class="form-group">
                  <div id="list-buku"></div>
                </div>
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

@endsection

@push('script')

<script>
  $(document).ready(function(){
    /*          FUNGSI          */
    const datatable = () => {
      $('#datatable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
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
          "url": "/admin/ajax/datatable-kategori",
          "type": "get",
          "data": {
            search: $('#search').val()
          }
        },
        "columns": [
          {"data": "DT_RowIndex", "name": "DT_RowIndex"},
          {"data": "jenis", "name": "jenis"},
          {"data": "aksi", "name": "aksi"},
        ]
      });
    }

    const checkValidInvalidForm = (idFormInput, idErr) => {
      let kategori = idFormInput;
        
        if(kategori.val().length == 0){
          idErr.removeClass('d-none').addClass('d-block');
          return kategori.addClass('is-invalid'); 
        }else{
          if (kategori.hasClass('is-invalid')){
            kategori.removeClass('is-invalid'); idErr.addClass('d-none').removeClass('d-block');
          }
          return false
        }
    }

    const ifValueNullBeforeSubmit = (idFormInput, idErr) => {
      idFormInput.addClass('is-invalid'); 
      idErr.removeClass('d-none').addClass('d-block');
    }
    /*          FUNGSI          */

    datatable()
    /*          INISIASI          */
    let id = null;
    let name_kategori = null;
    /*          INISIASI          */

    $(window).on('hide.bs.modal', function() {
        id = null
        name_kategori = null
    });

    $(document).on('click', '.btn-search', function(){
      $('#datatable').DataTable().destroy();
      datatable();
    });

    /*          TAMBAH KATEGORI          */
    $(document).on('keyup', '#add-kategori', function(){
      return checkValidInvalidForm($('#add-kategori'), $('#err-add-kategori'));
    });

    $(document).on('click', '.simpan-tambah-kategori', async function() {
        let kategori = $('#add-kategori').val();
        let data = $('#tambah-kategori').serialize();
        if(kategori == null || kategori == ''){
          ifValueNullBeforeSubmit($('#add-kategori'), $('#err-add-kategori'));
          return false;
        }else{
          checkValidInvalidForm($('#add-kategori'), $('#err-add-kategori'));

          $.ajax({
            url: "/admin/ajax/tambah-kategori",
            method: "post",
            data: data,
            success:function(res){
              if(res.status == 200){
                $('#modal-tambah').modal('toggle');
                $('#add-kategori').val("");

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
              return;
            }
          })
        }
    });
    /*          TAMBAH KATEGORI          */
    
    /*          DETAIL KATEGORI          */
    $(document).on('click', '.btn-open-modal-detail', function(){
      id = $(this).attr('data-id')
      $('#list-buku').empty();
      $.ajax({
        url: '/admin/ajax/get-buku-from-jenis-kategori',
        method: 'post',
        data: {
          id: id
        },
        success:function(res){
            $('#nama_kategori').html(res.judul);
            if(res.data.length == 0){
              let list = '<h6 class="text-center mt-5 mb-5"><b>Belum Ada Buku yang Terkait di Jenis Kategori.</b><h6>';
              $('#list-buku').append(list);
            }else{
              let list = `<label>Berikut Judul-Judul Buku yang Menggunakan Jenis Kategori Ini:</label>
                          <ul>`;
                  res.data.map((val, idx) => {
                    list += `<li>${val.judul}</li>`;
                  });
                  list += '</ul>';
  
              $('#list-buku').append(list);
            }
            return $('#modal-detail').modal('show');
        }
      })
    });
    /*          DETAIL KATEGORI          */

    /*          UBAH KATEGORI          */
    $(document).on('click', '.btn-open-modal-edit', function(){
      id = $(this).attr('data-id')
      name_kategori = window.atob($(this).attr('data-kategori'))
      $('#edit-kategori').val(name_kategori);
      $('#id-kategori').val(id);
      checkValidInvalidForm($('#edit-kategori'), $('#err-edit-kategori'));
      return $('#modal-edit').modal('show');
    });

    $(document).on('keyup', '#edit-kategori', function(){
      return checkValidInvalidForm($('#edit-kategori'), $('#err-edit-kategori'));
    });

    $(document).on('click', '.simpan-edit-kategori', async function() {
        let kategori = $('#edit-kategori').val();
        let data = $('#update-kategori').serialize();
        if(kategori == null || kategori == ''){
          ifValueNullBeforeSubmit($('#edit-kategori'), $('#err-edit-kategori'));
          return false;
        }else{
          checkValidInvalidForm($('#edit-kategori'), $('#err-edit-kategori'));

          $.ajax({
            url: "/admin/ajax/edit-kategori",
            method: "post",
            data: data,
            success:function(res){
              if(res.status == 200){
                $('#modal-edit').modal('toggle');
                $('#edit-kategori').val("");
                $('#id-kategori').val("");

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
              return;
            }
          })
        }
    });
    /*          UBAH KATEGORI          */

    /*          HAPUS KATEGORI          */
    $(document).on('click', '.btn-delete-kategori', function(){
      id = $(this).attr('data-id')
      return Swal.fire({
        title: 'Yakin Menghapus Kategori?',
        input: 'text',
        icon: 'warning',
        inputAttributes: {
          autocapitalize: 'off'
        },
        inputPlaceholder: 'Ketik "Hapus"',
        showCancelButton: true,
        cancelButtonText: 'Tutup',
        confirmButtonText: 'Hapus',
        showLoaderOnConfirm: true,
        preConfirm: (data) => {
          if(data == 'Hapus'){
            return true;
          }else{
            Swal.showValidationMessage(`Harap isi sesuai perintah !`)
          }
        },
        // allowOutsideClick: () => !Swal.isLoading()
      }).then((res) => {
        if(res.isConfirmed){
          console.log(id);
          $.ajax({
            url: '/admin/ajax/hapus-kategori',
            method:'post',
            data:{
              id: id
            },
            success:function(res){
              if(res.status == 200){
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
          })
        }
      })
    })
    /*          HAPUS KATEGORI          */

  });

</script>

@endpush