<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Denda;
use App\Models\Kategori;
use App\Models\Sirkulasi;
use App\Models\Tahun;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $buku_chart = Buku::join('kategori_buku', 'kategori_buku.id', '=', 'buku.id_kategori')
        ->select('buku.id_kategori', DB::raw('count(*) as jumlah'))
        ->groupBy('id_kategori')
        ->orderBy('jumlah', 'desc')
        ->get();

        $chart = [];
        foreach ($buku_chart as $key => $row) {
            if($key < 5){
                $kategori = Kategori::find($row->id_kategori);
                if($kategori->id == $row->id_kategori){
                    $obj = [
                        'nama_kategori' => $kategori->kategori,
                        'jumlah' => $row->jumlah,
                    ];
                    array_push($chart, $obj);
                }
            }else{
                break;
            }
        }

        $member = User::where('is_admin', 0)->count();
        $buku = Buku::count();
        $aktifitas_peminjaman = Tahun::GetTahun();

        if(Auth::user()->is_admin == 1){
            $denda = Denda::where('already_paid', 0)->sum('denda_sebesar');
            $buku_dipinjamkan = Sirkulasi::whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
        }else{
            $sirkulasi = Sirkulasi::where('id_user', Auth::user()->id)->where('status', Sirkulasi::STATUS_BAYAR_DENDAM)->get();
            $denda = Denda::whereIn('id_sirkulasi', $sirkulasi->pluck('id'))->sum('denda_sebesar');
            $buku_dipinjamkan = Sirkulasi::where('id_user', Auth::user()->id)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
        }


        return view('pages.dashboard', [
            'menu' => 'dashboard',
            'chart' => $chart,
            'count_chart' => count($chart),
            'member' => $member,
            'buku' => $buku,
            'denda' => $denda,
            'buku_dipinjamkan' => $buku_dipinjamkan,
            'aktifitas_peminjaman' => $aktifitas_peminjaman,

        ]);
    }
}
