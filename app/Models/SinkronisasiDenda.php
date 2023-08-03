<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SinkronisasiDenda extends Model
{
    use HasFactory;

    protected $table = 'sync_denda';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
