@extends('template.master')
@section('title', 'Master Buku')

@section('content')

<!-- /.row -->
<div class="row">
  
    <div class="col-md-12">
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">Import Excel</h3>
        </div>
        <div class="card-body">
          <div class="row">
          <div class="col-lg-2 mt-3">
              <a href="{{route('admin.master-template-import-buku')}}" class="btn btn-warning" style="width: 100%" title="Download Template"><i class="fas fa-download"></i></a>
            </div>
            
            <div class="col-lg-8 mt-3">
              <form action="{{route('admin.master-import-buku')}}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="excel" name="file_excel">
                        <label class="custom-file-label" for="excel" id="nama_excel">Upload Excel</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div>
            </div>
            <div class="col-lg-2 mt-3">
              <button type="submit" class="btn btn-success" style="width: 100%" title="Upload Excel"><i class="fas fa-upload"></i></button>
            </form>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
  <!-- /.row -->

<div class="row">
          <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">List Buku</h3>
                <!-- card tools -->
                <div class="card-tools">
                  <div class="d-flex justify-content-between">
                    <a href="{{route('admin.master-export-buku')}}" class="btn btn-success btn-sm mr-1"><i class="fas fa-file-export"></i>  Export Excel</a>
                    <a href="{{route('admin.master-create-buku')}}" class="btn btn-primary btn-sm mr-1">
                      <i class="fas fa-plus mr-2"></i> Tambah Buku
                    </a>
                  </div>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form action="{{route('admin.master-buku')}}" method="get">
                  <div class="row">
                    <div class="col-lg-2">
                      <label for="lengthChange">Show Entries</label>
                      <!-- select -->
                      <div class="form-group">
                        <select id="lengthChange" name="lengthChange" class="form-control">
                          <option value="10">10</option>
                          <option value="25">25</option>
                          <option value="50">50</option>
                          <option value="100">100</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-10">
                      <label for="search">Search</label>
                      <input type="text" class="form-control" id="search" name="search" value="{{ old('search', $search) }}" placeholder="Search:">
                    </div>
                  </div>
                  <div class="row mb-3 mt-3">
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary btn-search ml-1 float-right"><i class="fas fa-filter"></i>  Filter</button>
                    </div>
                  </div>
                </form>
                <hr>
                <!-- Tabel Manual Responsive -->
                <div style="overflow-x:auto;"> 
                  <table id="datatable" class="table table-bordered table-hover mr-1">
                    <thead>
                    <tr>
                      <th class="text-center">Cover Buku</th>
                      <th>Judul</th>
                      <th>ISBN</th>
                      <th>Jumlah Stok</th>
                      <th class="text-center" style="width:10%;">#</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($buku as $row)
                      <tr>
                        @if($row->gambar == null)
                          <td class="text-center font-italic"><small>Belum Upload Gambar</small></td>
                        @else
                          <td class="text-center"><img src="{{ asset('/Image/Buku/'.$row->gambar) }}" alt="Not Found" style="height: 100px; width: 150px;"></td>
                        @endif
                        <td>{{$row->judul}}</td>
                        <td>{{$row->isbn}}</td>
                        <td>{{$row->jumlah_stok}} buah</td>
                        <td>
                              <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <a href="{{ route('admin.master-detail-buku', base64_encode($row->id)) }}" title="Detail" class="btn btn-info btn-sm mt-1 mb-1 ml-1 mr-1 btn-detail-buku disabled" disabled><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.master-edit-buku', base64_encode($row->id)) }}" title="Edit" class="btn btn-warning btn-sm mt-1 mb-1 ml-1 mr-1 btn-edit-buku disabled" disabled><i class="fas fa-pen"></i></a>
                                    <button type="button" title="Hapus" data-id="{{ base64_encode($row->id) }}" class="btn btn-danger btn-sm mt-1 mb-1 ml-1 mr-1 btn-delete-buku disabled"><i class="fas fa-trash" disabled></i></button>
                                </div>
                              </div>
                        </td>
                      </tr>
                    @empty
                    <tr>
                      <td colspan="5" class="text-center">No data available in table</td>
                    </tr>
                    @endforelse
                    </tbody>
                  </table>
                </div>
                <div class="row mt-3">
                  <div class="col-12">
                    {!! $buku->withQueryString()->links('pagination::bootstrap-5') !!}
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

        <!-- /.modal hapus -->
      <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="post" action="{{ route('admin.master-delete-buku') }}">
              <input type="hidden" name="id" id="id-buku">
              @csrf
              <div class="modal-body">
                <div class="d-flex justify-content-center mt-3">
                  <img src="{{ asset('/Image/warning.png') }}" alt="" class="d-block" style="height: 200px; width: 210px;">
                </div>
                <div class="d-flex justify-content-center">
                  <h5>Yakin Menghapus Buku?</h5>
                </div>
                <div class="d-flex justify-content-center mt-5">
                  <button type="button" class="btn btn-default mr-1" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-danger ml-1">Hapus</button>
                </div>
              </div>
            </form>
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
    $('.btn-detail-buku').prop('disabled', false).removeClass('disabled');
    $('.btn-edit-buku').prop('disabled', false).removeClass('disabled');
    $('.btn-delete-buku').prop('disabled', false).removeClass('disabled');

    $('#lengthChange').val({{$lengthChange}});

    $(document).on('click', '.btn-delete-buku', function(){
      let id = $(this).attr('data-id');
      $('#id-buku').val(id);
      $('#modal-delete').modal('show');
    });

    $(document).on('change', '#excel', function(e){
        let excel = $('#excel').val()
        $('#nama_excel').html(excel)
    });
  });
</script>

@endpush