@extends('template.master')
@section('title', 'Member')

@section('content')

<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List Member</h3>
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
                    <th class="text-center">Nama</th>
                    <th class="text-center">NIK</th>
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
          "url": "/admin/ajax/datatable-member",
          "type": "get",
          "data": {
            search: $('#search').val()
          }
        },
        "columns": [
          {"data": "DT_RowIndex", "name": "DT_RowIndex"},
          {"data": "nama", "name": "nama"},
          {"data": "nik", "name": "nik"},
        ]
      });
    }

    /*          FUNGSI          */

    datatable()


    $(document).on('click', '.btn-search', function(){
      $('#datatable').DataTable().destroy();
      datatable();
    });

  });

</script>

@endpush