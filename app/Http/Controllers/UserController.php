<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;


class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';

        $level = LevelModel::all();

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

   // Ambil data user dalam bentuk json untuk datatables
   public function list(Request $request)
   {
       $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
           ->with('level');
   
       // Filter data user berdasarkan level_id
       if ($request->level_id) {
           $users->where('level_id', $request->level_id);
       }
   
       return DataTables::of($users)
           ->addIndexColumn() // Menambahkan kolom index / no urut
           ->addColumn('aksi', function ($user) { // Menambahkan kolom aksi
               // Menambahkan tombol aksi untuk setiap user
               $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
               $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
               $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
   
               return $btn;
           })
           ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi berisi HTML
           ->make(true);
   }
   


    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all();
        $activeMenu = 'user';

        return view('user.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ], [
            'username.required' => 'Username harus diisi.',
            'username.min' => 'Username minimal 3 karakter.',
            'username.unique' => 'Username sudah digunakan.',
            'nama.required' => 'Nama harus diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 5 karakter.',
            'level_id.required' => 'Level harus dipilih.',
            'level_id.integer' => 'Level tidak valid.'
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user';

        return view('user.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit user'
        ];

        $activeMenu = 'user';

        return view('user.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer'
        ], [
            'username.required' => 'Username harus diisi.',
            'username.min' => 'Username minimal 3 karakter.',
            'username.unique' => 'Username sudah digunakan.',
            'nama.required' => 'Nama harus diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'password.min' => 'Password minimal 5 karakter.',
            'level_id.required' => 'Level harus dipilih.',
            'level_id.integer' => 'Level tidak valid.'
        ]);

        try {
            UserModel::find($id)->update([
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
                'level_id' => $request->level_id
            ]);

            return redirect('/user')->with('success', 'Data user berhasil diubah');
        } catch (\Exception $e) {
            return redirect('/user')->with('error', 'Data user gagal diubah: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id);
            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function dashboardLevelList(Request $request)
    {
        if ($request->ajax()) {
            $data = LevelModel::select(['id', 'nama']); // Pilih kolom yang ingin ditampilkan
            return DataTables::of($data)->make(true);
        }
        return abort(404); // Jika bukan permintaan AJAX
    }
    public function create_ajax()
{
    $level = LevelModel::select('level_id', 'level_nama')->get();

    return view('user.create_ajax')
           ->with('level', $level);
}
public function store_ajax(Request $request)
{
    // cek apakah request berupa ajax
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'level_id' => 'required|integer',
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:6',
        ];

        // use Illuminate\Support\Facades\Validator;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, // response status, false: error/gagal, true: berhasil
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(), // pesan error validasi
            ]);
        }

        UserModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil disimpan',
        ]);
    }

    return redirect('/');
}

// Menampilkan halaman form edit user ajax
public function edit_ajax(string $id)
{
    $user = UserModel::find($id);
    $level = LevelModel::select('level_id', 'level_nama')->get();

    return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
}

public function update_ajax(Request $request, $id)
{
    // cek apakah request dari ajax
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'level_id' => 'required|integer',
            'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|max:100',
            'password' => 'nullable|min:6|max:20'
        ];

        // use Illuminate\Support\Facades\Validator;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, // respon json, true: berhasil, false: gagal
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors() // menunjukkan field mana yang error
            ]);
        }

        $check = UserModel::find($id);

        if ($check) {
            if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                $request->request->remove('password');
            }

            $check->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    return redirect('/');
}
public function confirm_ajax(string $id)
{
    $user = UserModel::find($id);

    return view('user.confirm_ajax', ['user' => $user]);
}
public function delete_ajax(Request $request, $id)
{
    // cek apakah request dari ajax
    if ($request->ajax() || $request->wantsJson()) {
        $user = UserModel::find($id);

        if ($user) {
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    return redirect('/');
}
// Di dalam App\Http\Controllers\UserController.php

public function showRegistrationForm()
{
    $breadcrumb = (object) [
        'title' => 'Registrasi User',
        'list' => ['Home', 'Registrasi']
    ];

    $page = (object) [
        'title' => 'Form Registrasi User Baru'
    ];

    $level = LevelModel::all();
    $activeMenu = ''; // Sesuaikan jika ada menu aktif

    return view('auth.register', [ // Sesuaikan path view jika Anda meletakkan file di direktori lain
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'level' => $level,
        'activeMenu' => $activeMenu
    ]);
}

public function storeRegistration(Request $request)
{
    $request->validate([
        'username' => 'required|string|min:3|unique:m_user,username',
        'nama' => 'required|string|max:100',
        'password' => 'required|min:5|confirmed', // Menambahkan konfirmasi password
        'password_confirmation' => 'required|min:5', // Field konfirmasi password
        'level_id' => 'required|integer'
    ], [
        'username.required' => 'Username harus diisi.',
        'username.min' => 'Username minimal 3 karakter.',
        'username.unique' => 'Username sudah digunakan.',
        'nama.required' => 'Nama harus diisi.',
        'nama.max' => 'Nama maksimal 100 karakter.',
        'password.required' => 'Password harus diisi.',
        'password.min' => 'Password minimal 5 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        'password_confirmation.required' => 'Konfirmasi password harus diisi.',
        'password_confirmation.min' => 'Konfirmasi password minimal 5 karakter.',
        'level_id.required' => 'Level harus dipilih.',
        'level_id.integer' => 'Level tidak valid.'
    ]);

    UserModel::create([
        'username' => $request->username,
        'nama' => $request->nama,
        'password' => bcrypt($request->password),
        'level_id' => $request->level_id
    ]);

    return redirect('/login')->with('success', 'Registrasi berhasil. Silakan login.'); // Redirect ke halaman login setelah berhasil registrasi
}
public function import()
    {
        return view('user.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_user' => ['required', 'mimes:xlsx', 'max:1024'] // Ubah nama input file
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_user'); // Ubah nama input file
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'user_id'    => $value['A'], // Sesuaikan kolom
                            'username'   => $value['B'], // Sesuaikan kolom
                            'nama'       => $value['C'], // Sesuaikan kolom
                            'level_id'   => $value['D'], // Sesuaikan kolom
                            'created_at' => now(),
                        ];
                    }
                }

                if (!empty($insert)) {
                    UserModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diimport'
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Tidak ada data yang diimport'
            ]);
        }

        return redirect('/'); // Atau rute lain yang sesuai
    }

    public function export_excel()
    {
        // Ambil data user yang akan diekspor
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')->get();

        // Load library Excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // Ambil sheet yang aktif

        // Set header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'User ID');
        $sheet->setCellValue('C1', 'Username');
        $sheet->setCellValue('D1', 'Nama');
        $sheet->setCellValue('E1', 'Level ID');

        // Bold header kolom
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        // Isi data user
        $no = 1; // Nomor data dimulai dari 1
        $baris = 2; // Baris data dimulai dari baris ke 2
        foreach ($users as $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->user_id);
            $sheet->setCellValue('C' . $baris, $value->username);
            $sheet->setCellValue('D' . $baris, $value->nama);
            $sheet->setCellValue('E' . $baris, $value->level_id);
            $baris++;
            $no++;
        }

        // Set auto size untuk kolom
        foreach (range('A', 'E') as $columnID) { // Sesuaikan kolom
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set title sheet
        $sheet->setTitle('Data User');

        // Buat writer dan nama file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data User ' . date('Y-m-d H:i:s') . ".xlsx";

        // Set header HTTP untuk download file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        // Simpan file Excel ke output PHP dan keluar
        $writer->save('php://output');
        exit;

        // End function export excel
    }

    public function export_pdf()
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')->get();

        $pdf = Pdf::loadView('user.export_pdf', ['users' => $users]);

        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data User ' . date('Y-m-d H:i:s') . '.pdf');
    }
}