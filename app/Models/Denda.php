<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Denda extends Model
{
    use HasFactory;

    protected $table = 'denda';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public static function AddDendaByIdSirkulasi($id)
    {
        DB::beginTransaction();
        try {
            $check_sirkulasi = Denda::where('id_sirkulasi', $id)->first();
            if($check_sirkulasi == null){
                
                $denda = new Denda();
                $denda->id_sirkulasi = $id;
                $denda->denda_sebesar = 1000;
                $denda->already_paid = FALSE;
                $denda->save();
    
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'type' => 1,
                    'message' => 'Bayar Dahulu Denda Pengembalian Keterlambatan Sebesar: <b>Rp.'. $denda->denda_sebesar.'</b>'
                ]);
            }else{
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'type' => 1,
                    'message' => 'Bayar Dahulu Denda Pengembalian Keterlambatan Sebesar: <b>Rp.'. $check_sirkulasi->denda_sebesar.'</b>'
                ]);
            }
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollBack();

            return response()->json([
                'status' => 400,
                'type' => 1,
                'message' => 'Pemberian Denda Gagal. Hubungi Admin Perpustakaan'
            ]);
        }
    }

    public static function ApproveDendam($request)
    {
        $id = base64_decode($request->id);
        DB::beginTransaction();
        try {
            $sirkulasi = Sirkulasi::findOrFail($id);
            $sirkulasi->status = Sirkulasi::STATUS_SETELAH_BAYAR_DENDAM;
            $sirkulasi->update();

            $denda = Denda::where('id_sirkulasi', $sirkulasi->id)->first();
            $denda->already_paid = TRUE;
            $denda->update();

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil Approve Denda.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'status' => 400,
                'message' => 'Gagal Approve Denda. Hubungi Developer Aplikasi.'
            ]);
        }
    }
}
