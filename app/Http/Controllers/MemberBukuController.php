<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Denda;
use App\Models\Kategori;
use App\Models\Sirkulasi;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MemberBukuController extends Controller
{
    public function datatableMemberBuku(Request $request)
    {
        if($request->ajax())
        {
            $buku = Buku::latest()->where('jumlah_stok', '!=', 0);
            if($request->search){
                $search = strtolower($request->search);
                $buku = $buku->where(function($row) use ($search){
                    $row->orWhere('judul', 'like', "%$search%")
                    ->orWhere('isbn', 'like', "%$search%")
                    ->orWhere('sinopsis', 'like', "%$search%")
                    ->orWhere('pengarang', 'like', "%$search%");
                });
            }
            
            $buku = $buku->get();
            return DataTables::of($buku)
                ->addColumn('gambar', function ($row){
                    if($row->gambar == null){
                        $gambar = '<small class="text-center font-italic">Belum Upload Gambar</small>';
                    }
                    else{
                        $gambar = '<img src="'. asset('/Image/Buku/'.$row->gambar) .'" alt="Not Found" style="height: 100px; width: 150px;">';
                    }

                    return $gambar;
                })
                ->addColumn('judul', function ($row){
                    return $row->judul;
                })
                ->addColumn('isbn', function ($row){
                    return $row->isbn;
                })
                ->addColumn('pengarang', function ($row){
                    return $row->pengarang;
                })
                ->addColumn('sinopsis', function ($row){
                    return $row->sinopsis;
                })
                ->addColumn('aksi', function ($row){
                    $button = '<div class="row">
                                    <div class="col-12 d-flex justify-content-center">
                                        <button type="button" title="Detail" data-id="'. base64_encode($row->id) .'" class="btn btn-info btn-sm mt-1 mb-1 ml-1 mr-1 btn-open-modal-detail"><i class="fas fa-eye"></i></button>
                                        
                                        <button type="button" title="Pinjam Buku" data-id="'. base64_encode($row->id) .'" class="btn btn-primary btn-sm mt-1 mb-1 ml-1 mr-1 btn-open-modal-pinjam"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>';
                    return $button;
                })
                ->rawColumns(['gambar','judul', 'isbn','pengarang', 'sinopsis', 'aksi'])
                ->escapeColumns()
                ->toJson();
        }
    }

    public function getDetailBuku(Request $request)
    {
        if($request->ajax()){
            $id = $request->id;
            $get_buku = Buku::GetBukuById($id);
            
            $get_kategori = Kategori::GetKategoriById($get_buku->id_kategori);

            return response()->json([
                'status' => 200,
                'message' => 'Oke',
                'data' => $get_buku,
                'data_kategori' => $get_kategori,
            ]);
        }
    }

    public function doPinjam(Request $request)
    {
        if($request->ajax()){
            $response = Sirkulasi::MemberMeminjam($request);

            return $response->getData();
        }
    }

    public function datatableMemberPeminjaman(Request $request)
    {
        if($request->ajax())
        {
            $id_user_login = Auth::user()->id;
            $buku = Sirkulasi::latest()->where('id_user', $id_user_login)->with('Buku')->whereBetween('status', [Sirkulasi::STATUS_MENUNGGU_PERSETUJUAN,Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM]);
            $buku = $buku->get();
            return DataTables::of($buku)
                ->addColumn('gambar', function ($row){
                    if($row->Buku->gambar == null){
                        $gambar = '<small class="text-center font-italic">Belum Upload Gambar</small>';
                    }
                    else{
                        $gambar = '<img src="'. asset('/Image/Buku/'.$row->Buku->gambar) .'" alt="Not Found" style="height: 100px; width: 150px;text-align:center;">';
                    }

                    return $gambar;
                })
                ->addColumn('judul', function ($row){
                    return $row->Buku->judul;
                })
                ->addColumn('tanggal_pinjam', function ($row){
                    return date('H:i:s d-m-Y', strtotime($row->tanggal_peminjaman));
                })
                ->addColumn('tanggal_kembali', function ($row){
                    return date('H:i:s d-m-Y', strtotime($row->tanggal_pengembalian));
                })
                ->addColumn('status', function ($row){
                    if($row->status == Sirkulasi::STATUS_MENUNGGU_PERSETUJUAN){
                        return '<div class"row"><div class="col-md-12 d-flex justify-content-center"><span class="badge badge-secondary">Menunggu Persetujuan</span></div></div>';
                    }elseif($row->status == Sirkulasi::STATUS_APPROVAL_ADMIN || $row->status == Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM){
                        return '<div class"row"><div class="col-md-12 d-flex justify-content-center"><span class="badge badge-success">Approve Admin</span></div></div>';
                    }else{
                        return '<div class"row"><div class="col-md-12 d-flex justify-content-center"><span class="badge badge-danger">Bayar Denda Dahulu</span></div></div>';
                    }
                })
                ->addColumn('aksi', function ($row){
                    if($row->status == Sirkulasi::STATUS_MENUNGGU_PERSETUJUAN){
                        return '<small class="font-italic">Tidak ada aksi.</small>';
                    }else{
                        $button = '<div class="row">
                                        <div class="col-12 d-flex justify-content-center">
                                            <button type="button" title="Kembalikan Buku" data-id="'. base64_encode($row->id) .'" class="btn btn-primary btn-sm mt-1 mb-1 ml-1 mr-1 btn-open-modal-kembalikan"><i class="fas fa-undo"></i></button>
                                        </div>
                                    </div>';
                        return $button;
                    }
                })
                ->rawColumns(['gambar','judul', 'nama_peminjam', 'tanggal_pinjam','tanggal_kembali','status','aksi'])
                ->escapeColumns()
                ->toJson();
        }
    }

    public function checkPengembalianTelat(Request $request)
    {
        if($request->ajax()){
            $peminjaman = Sirkulasi::GetSirkulasiById($request);
            
            if($peminjaman->status == Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM){
                $dendam_sudah_dibayar = Denda::where('id_sirkulasi',$peminjaman->id)->where('already_paid', TRUE)->first();
                if($dendam_sudah_dibayar != null){
                    return response()->json([
                        'status' => 200,
                        'type' => 2,
                        'message' => 'Denda Lunas. Silahkan Kembalikan Buku dan Ambil <b> KTP/Kartu Tanda Pengenal Lain </b> yang Dititipkan Kepada Petugas.'
                    ]);
                }else{
                    return response()->json([
                        'status' => 400,
                        'type' => 1,
                        'message' => 'Pembayaran Belum Masuk. Silahkan Hubungi <b> Admin/Petugas Perpustakaan</b>.'
                    ]);
                }
            }else{
                $tanggal_sekarang = Carbon::now();
    
                $new_format_tanggal_sekarang = date('Y-m-d H:i:s', strtotime($tanggal_sekarang));
                $new_format_tanggal_pengembalian = date('Y-m-d H:i:s', strtotime($peminjaman->tanggal_pengembalian));
    
                $format_tanggal_sekarang        = new DateTime($new_format_tanggal_sekarang);
                $format_tanggal_pengembalian    = new DateTime($new_format_tanggal_pengembalian);
    
                if($format_tanggal_sekarang > $format_tanggal_pengembalian){
                    $response = Denda::AddDendaByIdSirkulasi($peminjaman->id);
    
                    $peminjaman->status = Sirkulasi::STATUS_BAYAR_DENDAM;
                    $peminjaman->update();
    
                    return $response->getData();
                }else{
                    return response()->json([
                        'status' => 200,
                        'type' => 2,
                        'message' => 'Tidak Ada Denda di Dapatkan. Silahkan Kembalikan Buku dan Ambil <b> KTP/Kartu Tanda Pengenal Lain </b> yang Dititipkan Kepada Petugas.'
                    ]);
                }
            }
            
        }
    }

    public function doKembalikan(Request $request)
    {
        if($request->ajax())
        {
            $response = Sirkulasi::MemberMengembalikan($request);
            
            return $response->getData();
        }
    }

    public function datatableMemberPengembalian(Request $request)
    {
        if($request->ajax())
        {
            $id_user_login = Auth::user()->id;
            $buku = Sirkulasi::latest()->where('id_user', $id_user_login)->with('Buku')->where('status', Sirkulasi::STATUS_PENGEMBALIAN_APPROVAL_ADMIN);
            $buku = $buku->get();
            return DataTables::of($buku)
                ->addColumn('gambar', function ($row){
                    if($row->Buku->gambar == null){
                        $gambar = '<small class="text-center font-italic">Belum Upload Gambar</small>';
                    }
                    else{
                        $gambar = '<img src="'. asset('/Image/Buku/'.$row->Buku->gambar) .'" alt="Not Found" style="height: 100px; width: 150px;text-align:center;">';
                    }

                    return $gambar;
                })
                ->addColumn('judul', function ($row){
                    return $row->Buku->judul;
                })
                ->addColumn('tanggal_pinjam', function ($row){
                    return date('H:i:s d-m-Y', strtotime($row->tanggal_peminjaman));
                })
                ->addColumn('tanggal_kembali', function ($row){
                    return date('H:i:s d-m-Y', strtotime($row->tanggal_pengembalian));
                })
                ->addColumn('status', function ($row){
                    return '<div class"row"><div class="col-md-12 d-flex justify-content-center"><span class="badge badge-success">Pengembalian Buku Berhasil</span></div></div>';
                })
                ->rawColumns(['gambar','judul', 'nama_peminjam', 'tanggal_pinjam','tanggal_kembali','status'])
                ->escapeColumns()
                ->toJson();
        }
    }
}
