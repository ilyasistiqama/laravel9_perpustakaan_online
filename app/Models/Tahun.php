<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Tahun
{
    public static function GetTahun()
    {
        if(Auth::user()->is_admin == TRUE){
            $Januari = Sirkulasi::whereMonth('created_at', '01')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Feburari = Sirkulasi::whereMonth('created_at', '02')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Maret = Sirkulasi::whereMonth('created_at', '03')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $April = Sirkulasi::whereMonth('created_at', '04')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Mei = Sirkulasi::whereMonth('created_at', '05')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Juni = Sirkulasi::whereMonth('created_at', '06')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Juli = Sirkulasi::whereMonth('created_at', '07')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Agustus = Sirkulasi::whereMonth('created_at', '08')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $September = Sirkulasi::whereMonth('created_at', '09')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Oktober = Sirkulasi::whereMonth('created_at', '10')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $November = Sirkulasi::whereMonth('created_at', '11')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Desember = Sirkulasi::whereMonth('created_at', '12')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();

            return [$Januari, $Feburari, $Maret, $April, $Mei, $Juni, $Juli, $Agustus, $September, $Oktober, $November, $Desember];
        }else{
            $Januari = Sirkulasi::where('id_user', Auth::user()->id)->whereMonth('created_at', '01')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Feburari = Sirkulasi::where('id_user', Auth::user()->id)->whereMonth('created_at', '02')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Maret = Sirkulasi::where('id_user', Auth::user()->id)->whereMonth('created_at', '03')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $April = Sirkulasi::where('id_user', Auth::user()->id)->whereMonth('created_at', '04')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Mei = Sirkulasi::where('id_user', Auth::user()->id)->whereMonth('created_at', '05')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Juni = Sirkulasi::where('id_user', Auth::user()->id)->whereMonth('created_at', '06')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Juli = Sirkulasi::where('id_user', Auth::user()->id)->whereMonth('created_at', '07')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Agustus = Sirkulasi::where('id_user', Auth::user()->id)->whereMonth('created_at', '08')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $September = Sirkulasi::where('id_user', Auth::user()->id)->whereMonth('created_at', '09')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Oktober = Sirkulasi::where('id_user', Auth::user()->id)->whereMonth('created_at', '10')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $November = Sirkulasi::where('id_user', Auth::user()->id)->whereMonth('created_at', '11')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();
            $Desember = Sirkulasi::where('id_user', Auth::user()->id)->whereMonth('created_at', '12')->whereYear('created_at', Carbon::now()->year)->whereBetween('status', [Sirkulasi::STATUS_APPROVAL_ADMIN, Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM])->count();

            return [$Januari, $Feburari, $Maret, $April, $Mei, $Juni, $Juli, $Agustus, $September, $Oktober, $November, $Desember];
        }
    }
}
