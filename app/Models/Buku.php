<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class,'id_kategori', 'id');
    }

    public static function GetBukuById($id)
    {
        return Buku::findOrFail(base64_decode($id));
    }

    public static function AddAndEditBuku($request, $id = null)
    {
        DB::beginTransaction();
        try {
            $get_kategori = Kategori::GetKategoriById($request->jenis_kategori);
            if(isset($id)){
                $store = Buku::find(base64_decode($id));
                $msg = "Edit";
            }else{
                $store = new Buku();
                $msg = "Tambah";
            }
            $store->judul = $request->input('judul');
            $store->isbn = $request->input('isbn');
            $store->pengarang = $request->input('pengarang');
            $store->jumlah_halaman = $request->input('jumlah_halaman');
            $store->jumlah_stok = $request->input('jumlah_stok');
            $store->tahun_terbit = $request->input('tahun_terbit');
            $store->sinopsis = $request->input('sinopsis');
            $store->id_kategori = $get_kategori->id;

            if(isset($request->img)){
                $file= $request->file('img');
                $filename= date('YmdHi_').$file->getClientOriginalName();
                $file-> move(public_path('Image/Buku'), $filename);
                $store->gambar = $filename;
            };

            $store->save();

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => $msg. ' Buku Berhasil.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);
            return response()->json([
                'status' => 400,
                'message' => $msg. ' Buku Gagal. Hubungi Admin Perpustakaan.'
            ]);
        }
    }

    public static function DeleteBukuById($id)
    {
        $sirkulasi = Sirkulasi::where('id_buku', base64_decode($id))->count();
        if($sirkulasi != 0){
            return response()->json([
                'status' => 400,
                'message' => 'Hapus Buku Gagal. Buku Sudah Terdata di Peminjaman/pengembalian.'
            ]);
        }
        DB::beginTransaction();
        try {
            $hapus = Buku::findOrFail(base64_decode($id));
            $hapus->delete();
            
            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Hapus Buku Berhasil.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e);
            
            return response()->json([
                'status' => 400,
                'message' => 'Hapus Buku Gagal. Hubungi Admin Perpustakaan.'
            ]);
        }
    }

    public static function ImportExcel($request)
    {
        $reader = new Xlsx();
        $inputFileType = 'Xlsx';
        $inputFileName = $request->file_excel;
        $reader = IOFactory::createReader($inputFileType);
        $spreadsheet = $reader->load($inputFileName);
        DB::beginTransaction();
            try {
                $worksheet = $spreadsheet->getSheetByName('Form'); //get nama sheet nya
                if($worksheet == null){
                    return response()->json([
                        'status' => 400,
                        'message' => 'Salah Upload File.'
                    ]);
                }
                $highestRowUser = $worksheet->getHighestRow(); //banyak baris data
                for ($index = 3; $index <= $highestRowUser; $index++) {
                    $temp = 0;

                    $judul = $worksheet->getCellByColumnAndRow(1, $index)->getValue();
                    $isbn = $worksheet->getCellByColumnAndRow(2, $index)->getValue();
                    $pengarang = $worksheet->getCellByColumnAndRow(3, $index)->getValue();
                    $jumlah_halaman = $worksheet->getCellByColumnAndRow(4, $index)->getValue();
                    $jumlah_stok = $worksheet->getCellByColumnAndRow(5, $index)->getValue();
                    $tahun_terbit = $worksheet->getCellByColumnAndRow(6, $index)->getValue();
                    $convert_tehun_terbit = Date::excelToDateTimeObject($tahun_terbit);
                    $sinopsis = $worksheet->getCellByColumnAndRow(7, $index)->getValue();
                    $id_kategori = $worksheet->getCellByColumnAndRow(8, $index)->getValue();

                    if($judul == null){
                        $temp += 1; 
                    }

                    if($isbn == null){
                        $temp += 1; 
                    }

                    if($pengarang == null){
                        $temp += 1; 
                    }

                    if($jumlah_halaman == null){
                        $temp += 1; 
                    }

                    if($jumlah_stok == null){
                        $temp += 1; 
                    }
                    
                    if($tahun_terbit == null){
                        $temp += 1; 
                    }

                    if($sinopsis == null){
                        $temp += 1; 
                    }

                    if($id_kategori == null){
                        $temp += 1; 
                    }

                    if($temp != 0){
                        return response()->json([
                            'status' => 400,
                            'message' => 'Data-Data Buku Tidak Boleh Kosong.'
                        ]);
                    }

                    $add = new Buku();
                    $add->judul = $judul;
                    $add->isbn = $isbn;
                    $add->pengarang = $pengarang;
                    $add->jumlah_halaman = $jumlah_halaman;
                    $add->jumlah_stok = $jumlah_stok;
                    $add->tahun_terbit = $convert_tehun_terbit;
                    $add->sinopsis = $sinopsis;
                    $add->id_kategori = $id_kategori;
                    $add->save();
                }
                
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => 'Tambah Buku Berhasil.'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::info($e);
                return response()->json([
                    'status' => 400,
                    'message' => 'Tambah Buku Gagal. Hubungi Admin Perpustakaan.'
                ]);
            }
    }
}
