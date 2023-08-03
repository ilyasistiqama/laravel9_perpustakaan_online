<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function AdminCheckWhenLogin($validated)
    {
        $check = User::where('nik', $validated['nik'])
                    ->where('is_admin', true)
                    ->first();
        return (!$check == null ? true : false); 
    }

    public static function MakeAccount($validated)
    {
        DB::beginTransaction();
        try {
            $new = new User();
            $new->nama = $validated['full_name'];
            $new->nik = $validated['nik'];
            $new->password = Hash::make($validated['password']);
            $new->is_admin = false;
            $new->save();

            $new->assignRole('member');

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Berhasil Membuat Akun'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e);
            return response()->json([
                'status' => 400,
                'message' => 'Gagal Membuat Akun. Hubungi Admin Perpustakaan'
            ]);
        }
    }

}
