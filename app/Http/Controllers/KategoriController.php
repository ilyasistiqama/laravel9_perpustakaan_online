<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function dataTableKategori(Request $request)
    {
        if($request->ajax()){
            $kategori = Kategori::latest();
            if($request->search){
                $search = strtolower($request->search);
                $kategori = $kategori->where('kategori', 'like', "%$search%");
            }
            $kategori = $kategori->get();
            return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('jenis', function($row) {
                return $row->kategori;
            })
            ->addColumn('aksi', function($row) {
                $button = '<div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <button type="button" title="Detail" data-id="'. base64_encode($row->id) .'" class="btn btn-info btn-sm mt-1 mb-1 ml-1 mr-1 btn-open-modal-detail"><i class="fas fa-eye"></i></button>
                                    <button type="button" title="Edit" data-id="'. base64_encode($row->id) .'" data-kategori="'. base64_encode($row->kategori) .'" class="btn btn-warning btn-sm mt-1 mb-1 ml-1 mr-1 btn-open-modal-edit"><i class="fas fa-pen"></i></button>
                                    <button type="button" title="Hapus" data-id="'. base64_encode($row->id) .'" class="btn btn-danger btn-sm mt-1 mb-1 ml-1 mr-1 btn-delete-kategori"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>';
                return $button;
            })
            ->rawColumns(['jenis','aksi'])
            ->escapeColumns()
            ->toJson();
        }
    }

    public function doAdd(Request $request)
    {
        if($request->ajax())
        {
            if($request->input('kategori') == null){
                return response()->json([
                    'status' => 400,
                    'message' => 'Jenis Kategori Tidak Boleh Kosong'
                ]);
            }

            $response = Kategori::AddAndEditKategori($request);

            return $response->getData();
        }
    }

    public function doEdit(Request $request)
    {
        if($request->ajax())
        {
            if($request->input('kategori') == null){
                return response()->json([
                    'status' => 400,
                    'message' => 'Jenis Kategori Tidak Boleh Kosong'
                ]);
            }

            $response = Kategori::AddAndEditKategori($request);

            return $response->getData();
        }
    }

    public function doDelete(Request $request)
    {
        if($request->ajax())
        {
            $response = Kategori::DeleteKategori($request);

            return $response->getData();
        }
    }

    public function getBukuFromJenisKategori(Request $request)
    {
        if($request->ajax()){
            $response = Kategori::GetBukuByIdKategori($request);

            return $response->getData();
        }
    }
}
