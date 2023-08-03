<?php

namespace App\Console\Commands;

use App\Models\Denda;
use App\Models\SinkronisasiDenda;
use App\Models\Sirkulasi;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncDendaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:denda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Untuk Mensingkronisasi Dendam.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tanggal_sekarang = Carbon::now();
        $sinkronisasi_terakhir = SinkronisasiDenda::latest()->first();
        
        $sirkulasi = Sirkulasi::where('status', Sirkulasi::STATUS_BAYAR_DENDAM)->get();
        
    
        $new_format_tanggal_sekarang = date('Y-m-d H:i:s', strtotime($tanggal_sekarang));

        $format_tanggal_sekarang = new DateTime($new_format_tanggal_sekarang);

        if($sirkulasi->count() != 0){
            DB::beginTransaction();
            try {
                if($sinkronisasi_terakhir != null){
                    foreach ($sirkulasi as $key => $value) {
                        $new_format_tanggal_sekarang_2 = date('Y-m-d', strtotime($sinkronisasi_terakhir->singkronisasi_terakhir));

                        $format_tanggal_sekarang_2 = new DateTime($new_format_tanggal_sekarang_2);

                        $new_format_updated_at = date('Y-m-d', strtotime($value->updated_at));
                        $format_updated_at    = new DateTime($new_format_updated_at);

                        if($format_tanggal_sekarang_2 == $format_updated_at){
                            $this->info("Sudah Dilakukan Sinkronisasi Hari Ini!");
                            return Command::SUCCESS;
                        }
                    }
                }

                foreach ($sirkulasi as $key => $value) {
                    $new_format_tanggal_pengembalian = date('Y-m-d H:i:s', strtotime($value->tanggal_pengembalian));
                    $format_tanggal_pengembalian    = new DateTime($new_format_tanggal_pengembalian);
                    if($format_tanggal_sekarang > $format_tanggal_pengembalian){
                        $update_denda = Denda::where('id_sirkulasi', $value->id)->first();
                        $update_denda->denda_sebesar += 1000;
                        $update_denda->save();
                    }
                }

                $singkronisasi = new SinkronisasiDenda();
                $singkronisasi->singkronisasi_terakhir = Carbon::now();
                $singkronisasi->save();
                DB::commit();
                $this->info("Berhasil Sinkronisasi Denda!");
            } catch (\Exception $e) {
                Log::info($e);
                DB::rollBack();
                $this->info("Gagal Sinkronisasi Denda!");
            }
        }else{
            $this->info("Tidak Tersedia Denda!");
        }
        // return Command::SUCCESS;
    }
}
