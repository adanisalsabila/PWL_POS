<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;

class LevelController extends Controller
{
    public function index()
    {
        $activeMenu = 'level'; // Tambahkan ini
        return view('level.index', compact('activeMenu')); // Tambahkan compact
    }

    public function list(Request $request) // Ubah nama fungsi
    {
        if ($request->ajax()) {
            $data = LevelModel::select(['level_id', '*']);
            return DataTables::of($data)->make(true);
        }
        return abort(404);
    }
}