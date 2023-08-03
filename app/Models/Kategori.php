<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori_buku';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public static function GetBukuByIdKategori($request)
    {
        try {
            $kategori = Kategori::findOrFail(base64_decode($request->id));
            $buku = Buku::where('id_kategori', $kategori->id)->get();
            return response()->json([
                'status' => 200,
                'data' => $buku,
                'judul' => $kategori->kategori,
                'message' => 'Oke'
            ]);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json([
                'status' => 400,
                'data' => null,
                'message' => 'Maaf'
            ]);
        }

    }

    public static function AddAndEditKategori($req)
    {
        DB::beginTransaction();
        try {
            if(isset($req->id_kategori)){
                $add = Kategori::find(base64_decode($req->id_kategori));
                $msg = "Edit";
            }else{
                $msg = "Tambah";
                $add = new Kategori();
            }
            $add->kategori = $req->input('kategori');
            $add->save();
            
            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => $msg.' Kategori Berhasil.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'status' => 400,
                'message' => $msg.' Kategori Gagal. Hubungi Admin Perpustakaan.'
            ]);
        }
    }

    public static function DeleteKategori($req)
    {
        DB::beginTransaction();
        try {
            $get_buku = Buku::where('id_kategori', base64_decode($req->id))->count();
            if($get_buku != 0){
                return response()->json([
                    'status' => 400,
                    'message' => 'Hapus Kategori Gagal. Kategori Sedang Digunakan Buku.'
                ]);
            }
    
            $delete = Kategori::find(base64_decode($req->id));
            $delete->delete();
            
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Hapus Kategori Berhasil.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);
            return response()->json([
                'status' => 400,
                'message' => 'Hapus Kategori Gagal. Hubungi Admin Perpustakaan.'
            ]);
        }
    }

    public static function GetKategoriById($id)
    {
        return Kategori::findOrFail($id);
    }
}
