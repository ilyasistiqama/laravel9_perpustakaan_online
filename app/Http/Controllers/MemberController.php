<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    public function datatableMember(Request $request)
    {
        if($request->ajax())
        {
            $member = User::latest();
            if($request->search){
                $search = strtolower($request->search);
                $member = $member->where(function($row) use ($search){
                    $row->orWhere('nama', 'like', "%$search%")
                    ->orWhere('nik', 'like', "%$search%");
                });
            }
            
            $member = $member->whereNot('is_admin', 1)->get();
            return DataTables::of($member)
                ->addIndexColumn()
                ->addColumn('nama', function ($row){
                    return $row->nama;
                })
                ->addColumn('nik', function ($row){
                    return $row->nik;
                })
                ->rawColumns(['nama', 'nik'])
                ->escapeColumns()
                ->toJson();
        }
    }
}
