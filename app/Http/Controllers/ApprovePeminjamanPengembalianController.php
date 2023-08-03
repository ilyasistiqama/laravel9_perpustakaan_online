<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Sirkulasi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ApprovePeminjamanPengembalianController extends Controller
{
    public function datatablePeminjaman(Request $request)
    {
        if($request->ajax())
        {
            $peminjaman = Sirkulasi::latest()->with('Buku', 'User')->whereBetween('status', [Sirkulasi::STATUS_MENUNGGU_PERSETUJUAN, Sirkulasi::STATUS_APPROVAL_ADMIN]);
            $peminjaman = $peminjaman->get();
            return DataTables::of($peminjaman)
                ->addColumn('gambar', function ($row){
                    if($row->Buku->gambar == null){
                        $gambar = '<small class="text-center font-italic">Belum Upload Gambar</small>';
                    }
                    else{
                        $gambar = '<img src="'. asset('/Image/Buku/'.$row->Buku->gambar) .'" alt="Not Found" style="height: 100px; width: 150px;">';
                    }

                    return $gambar;
                })
                ->addColumn('judul', function ($row){
                    return $row->Buku->judul;
                })
                ->addColumn('peminjam', function ($row){
                    return '<b>'.$row->User->nik.'</b> - '.$row->User->nama;
                })
                ->addColumn('tanggal_pinjam', function ($row){
                    return date('H:i:s d-m-Y', strtotime($row->tanggal_peminjaman));
                })
                ->addColumn('tanggal_kembali', function ($row){
                    return date('H:i:s d-m-Y', strtotime($row->tanggal_pengembalian));
                })
                ->addColumn('status', function ($row){
                    if($row->status == Sirkulasi::STATUS_MENUNGGU_PERSETUJUAN){
                        return '<div class"row"><div class="col-md-12 d-flex justify-content-center"><span class="badge badge-secondary">Menunggu Persetujuan</span></div></div';
                    }else{
                        return '<div class"row"><div class="col-md-12 d-flex justify-content-center"><span class="badge badge-success">Approve Admin</span></div></div';
                    }
                })
                ->addColumn('aksi', function ($row){
                    if($row->status == Sirkulasi::STATUS_APPROVAL_ADMIN){
                        return '<small class="font-italic">Tidak ada aksi.</small>';
                    }else{
                        $button = '<div class="row">
                                        <div class="col-12 d-flex justify-content-center">
                                            <button type="button" title="Approve Peminjaman" data-id="'. base64_encode($row->id) .'" class="btn btn-success btn-sm mt-1 mb-1 ml-1 mr-1 btn-open-modal-approve"><i class="fas fa-thumbs-up"></i></button>
                                        </div>
                                    </div>';
                        return $button;
                    }
                })
                ->rawColumns(['gambar','judul', 'peminjam', 'tanggal_pinjam','tanggal_kembali','status','aksi'])
                ->escapeColumns()
                ->toJson();
        }
    }

    public function approvePeminjaman(Request $request)
    {
        $response = Sirkulasi::AdminApprovePeminjaman($request);
        return $response->getData();
    }

    public function datatableDenda(Request $request)
    {
        if($request->ajax())
        {
            $peminjaman = Sirkulasi::latest()->with('Buku', 'User')->whereBetween('status', [Sirkulasi::STATUS_BAYAR_DENDAM, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM]);
            $peminjaman = $peminjaman->get();
            return DataTables::of($peminjaman)
                ->addColumn('gambar', function ($row){
                    if($row->Buku->gambar == null){
                        $gambar = '<small class="text-center font-italic">Belum Upload Gambar</small>';
                    }
                    else{
                        $gambar = '<img src="'. asset('/Image/Buku/'.$row->Buku->gambar) .'" alt="Not Found" style="height: 100px; width: 150px;">';
                    }

                    return $gambar;
                })
                ->addColumn('judul', function ($row){
                    return $row->Buku->judul;
                })
                ->addColumn('peminjam', function ($row){
                    return '<b>'.$row->User->nik.'</b> - '.$row->User->nama;
                })
                ->addColumn('tanggal_pinjam', function ($row){
                    return date('H:i:s d-m-Y', strtotime($row->tanggal_peminjaman));
                })
                ->addColumn('tanggal_kembali', function ($row){
                    return date('H:i:s d-m-Y', strtotime($row->tanggal_pengembalian));
                })
                ->addColumn('status', function ($row){
                    if($row->status == Sirkulasi::STATUS_BAYAR_DENDAM){
                        return '<div class"row"><div class="col-md-12 d-flex justify-content-center"><span class="badge badge-danger">Belum Bayar Denda</span></div></div';
                    }else{
                        return '<div class"row"><div class="col-md-12 d-flex justify-content-center"><span class="badge badge-success">Denda Sudah di Bayarkan</span></div></div';
                    }
                })
                ->addColumn('aksi', function ($row){
                    if($row->status != Sirkulasi::STATUS_BAYAR_DENDAM){
                        return '<small class="font-italic">Tidak ada aksi.</small>';
                    }else{
                        $button = '<div class="row">
                                        <div class="col-12 d-flex justify-content-center">
                                            <button type="button" title="Approve Denda" data-id="'. base64_encode($row->id) .'" class="btn btn-warning btn-sm mt-1 mb-1 ml-1 mr-1 btn-open-modal-approve"><i class="fas fa-comment-dollar"></i></button>
                                        </div>
                                    </div>';
                        return $button;
                    }
                })
                ->rawColumns(['gambar','judul', 'peminjam', 'tanggal_pinjam','tanggal_kembali','status','aksi'])
                ->escapeColumns()
                ->toJson();
        }
    }

    public function approveDenda(Request $request)
    {
        $response = Denda::ApproveDendam($request);

        return $response->getData();
    }
}
