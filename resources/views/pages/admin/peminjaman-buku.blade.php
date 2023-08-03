@extends('template.master')
@section('title', 'Approval Peminjaman')

@section('content')

<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List Member Meminjam Buku</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table id="datatable-peminjaman" class="table table-bordered table-hover w-100">
                  <thead>
                  <tr>
                    <th class="text-center">Cover Buku</th>
                    <th class="text-center">Judul</th>
                    <th class="text-center">Peminjam</th>
                    <th class="text-center">Peminjaman</th>
                    <th class="text-center">Pengembalian</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">#</th>
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

      <!-- /.modal Approve buku -->
      <div class="modal fade" id="modal-approve">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Approve Buku</b></h4>
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
                    <p>Apakah Member Sudah Memberikan <b>KTP</b> atau <b>Kartu Tanda Pengenal Lain</b> Sebagai Jaminan? Jika Sudah Silahkan Approve.</p>
                  </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary simpan-approve-pinjam-buku">Approve</button>
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
  $(document).ready(function () {
    const datatablePeminjaman = () => {
      $('#datatable-peminjaman').DataTable({
        "paging": true,
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
          "url": "/admin/ajax/datatable-peminjaman",
          "type": "get",
          "data": {
          }
        },
        "columns": [
          {"data": "gambar", "name": "gambar"},
          {"data": "judul", "name": "judul"},
          {"data": "peminjam", "name": "peminjam"},
          {"data": "tanggal_pinjam", "name": "tanggal_pinjam"},
          {"data": "tanggal_kembali", "name": "tanggal_kembali"},
          {"data": "status", "name": "status"},
          {"data": "aksi", "name": "aksi"},
        ]
      });
    }

    datatablePeminjaman();

    /*          INISIASI          */
    let id = null;
    /*          INISIASI          */

    $(window).on('hide.bs.modal', function() {
      id = null;
    });

    /*          APPROVE BUKU          */
    $(document).on('click', '.btn-open-modal-approve', function(){
      id = $(this).attr('data-id')
      return $('#modal-approve').modal('show');
    });

    $(document).on('click', '.simpan-approve-pinjam-buku', function(){
      $.ajax({
        url: '/admin/ajax/approve/pinjam-buku',
        method: 'post',
        data:{
          id: id
        },
        success:function(res){
          if(res.status == 200){
            $('#modal-approve').modal('toggle');
              id = null
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
          }
        }
      });
    });
    /*          APPROVE BUKU          */
  });
</script>

@endpush