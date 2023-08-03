<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Sirkulasi extends Model
{
    use HasFactory;

    protected $table = 'sirkulasi';
    protected $primaryKey = 'id';
    protected $guarded = [];

    // STATUS
    CONST STATUS_MENUNGGU_PERSETUJUAN = 1;
    CONST STATUS_APPROVAL_ADMIN = 2;
    CONST STATUS_BAYAR_DENDAM = 3;
    CONST STATUS_SETELAH_BAYAR_DENDAM = 4;
    CONST STATUS_PENGEMBALIAN_APPROVAL_ADMIN = 5;

    public function Buku()
    {
        return $this->hasOne(Buku::class, 'id', 'id_buku');
    }

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    public static function GetSirkulasiById($request)
    {
        return Sirkulasi::findOrFail(base64_decode($request->id));
    }

    public static function MemberMeminjam($request)
    {
        DB::beginTransaction();
        try {
            $id_user_when_login = Auth::user()->id;
            $buku = Buku::GetBukuById($request->id);


            $peminjaman = new Sirkulasi();
            $peminjaman->id_user = $id_user_when_login;
            $peminjaman->id_buku = $buku->id;
            $peminjaman->status = Sirkulasi::STATUS_MENUNGGU_PERSETUJUAN;
            $peminjaman->tanggal_peminjaman = Carbon::now();
            $peminjaman->tanggal_pengembalian = Carbon::now()->addDays(7);
            $peminjaman->save();

            // $buku->jumlah_stok = $buku->jumlah_stok - 1;
            // $buku->save();

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Pinjam Buku Berhasil. Menunggu Approval Dari Petugas/Admin Perpustakaan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'status' => 400,
                'message' => 'Pinjam Buku Gagal. Hubungi Admin Perpustakaan.'
            ]);
        }
    }

    public static function AdminApprovePeminjaman($request)
    {
        DB::beginTransaction();
        try {

            $peminjaman = Sirkulasi::findOrFail(base64_decode($request->id));
            $peminjaman->status = Sirkulasi::STATUS_APPROVAL_ADMIN;
            $peminjaman->tanggal_pengembalian = Carbon::now()->addDays(7);
            $peminjaman->update();

            $buku = Buku::GetBukuById(base64_encode($peminjaman->id_buku));
            $buku->jumlah_stok = $buku->jumlah_stok - 1;
            $buku->update();

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Approve Buku Berhasil.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'status' => 400,
                'message' => 'Approve Buku Gagal. Hubungi Developer Aplikasi.'
            ]);
        }
    }

    public static function MemberMengembalikan($request)
    {
        DB::beginTransaction();
        try {
            $pengembalian = Sirkulasi::findOrFail(base64_decode($request->id));

            $buku = Buku::GetBukuById(base64_encode($pengembalian->id_buku));
            $buku->jumlah_stok = $buku->jumlah_stok + 1;
            $buku->update();

            $pengembalian->status = Sirkulasi::STATUS_PENGEMBALIAN_APPROVAL_ADMIN;
            $pengembalian->update();

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Pengembalian Buku Berhasil. Terima Kasih Sudah Meminjam di Perpustakaan Kami.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);

            return response()->json([
                'status' => 400,
                'message' => 'Pengembalian Buku Gagal. Hubungi Admin Perpustakaan.'
            ]);
        }
    }
}
