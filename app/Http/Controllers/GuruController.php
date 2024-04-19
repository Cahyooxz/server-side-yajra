<?php

namespace App\Http\Controllers;

//test
use Spatie\Permission\Models\Role;
//
use Illuminate\Http\Request;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;
use App\Models\MataPelajaran;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;


class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    //  public function guru (Request $request)
    //  {
    //      $query = Guru::query();
 
    //      // Tampilin data
    //      if ($request->has('search')) {
    //          $query->where('name', 'LIKE', '%' . $request->input('search') . '%');
    //      }
    //      // Tampilkan data
    //      if ($request->filled('mata_pelajaran')) {
    //          $query->where('mata_pelajaran', $request->input('mata_pelajaran'));
    //      }
    //      // Tampilkan data
    //      if ($request->filled('jenis_kelamin')) {
    //          $query->where('jenis_kelamin', $request->input('jenis_kelamin'));
    //      }
     
    //      $data = $query->get();
    //      $matapelajarans = MataPelajaran::all();
     
    //      return view('teacher.dataguru', [
    //         'data' => $data,
    //         'title' => 'Data Guru',
    //         'matapelajarans' => $matapelajarans 
    //      ]);
    //  }
     
    // public function index()
    // {
    //     $data = Guru::get();
    //     return view('teacher/dataguru',compact('data'),
    //     [
    //         'title' => 'Data Guru'
    //     ]);
    // }

    /**
     * Show the form for creating a new resource.
     */

    
     public function guru(Request $request){
        if ($request->ajax()) {
            $query = Guru::query();
            // $data = new User;

            // Tangani filter jika diperlukan
            if ($request->filled('sortirjenisKelamin')) {
                $query->where('jenis_kelamin', $request->input('sortirjenisKelamin'));
            }
            if ($request->filled('sortirMataPelajaran')) {
                $query->where('mata_pelajaran', $request->input('sortirMataPelajaran'));
            }
            // Ambil data sesuai query
            $data = $query->get();

            // Return data dengan DataTables
            return DataTables::of($data)
            ->addColumn('nip', function($data){
                return $data->nip;
            })
            ->addColumn('image', function($data){
                return '<img src="'.asset('storage/photo-guru/'.$data->image).'" alt="" style="width: 100px">';
            })
            ->addColumn('name', function($data){
                return $data->name;
            })
            ->addColumn('email', function($data){
                return $data->email;
            })
            ->addColumn('alamat', function($data){
                return $data->alamat;
            })
            ->addColumn('jenis_kelamin', function($data){
                return $data->jenis_kelamin;
            })
            ->addColumn('mata_pelajaran', function($data){
                return $data->mata_pelajaran;
            })
            ->addColumn('aksi', function($data) {
                return
                '<div class="dropdown py-3">
                    <a class="button py-2 px-3 rounded text-decoration-none text-center dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-fill-gear me-2 i-icon"></i>Option
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="' . route('guru.edit',['id' => $data->id]) . '" class="dropdown-item"><i class="bi bi-person-fill-gear me-2 i-icon"></i>Edit</a>
                        </li>
                        <li>
                            <form id="hapus-guru-'.$data->id.'" action="'.route('guru.hapus', $data->id) .'" method="POST">
                                ' . method_field('DELETE') . '
                                ' . csrf_field() . '
                                <button type="button" id="'.$data->id.'" name="'.$data->name.'" class="btnHapusGuru dropdown-item text-danger">
                                    <i class="bi bi-person-fill-dash me-2 i-icon"></i>Hapus
                                </button>
                            </form>
                            <script>
                                document.querySelectorAll(".btnHapusGuru").forEach(function(button) {
                                    button.addEventListener("click", function() {
                                        // ambil data dari id dan name button per field
                                        var data_id = this.getAttribute("id");
                                        var nama_data = this.getAttribute("name");
                                        // tes masuk gak
                                        console.log(nama_data)
                                        Swal.fire({
                                            title: "Apakah Anda yakin menghapus "+nama_data+"?",
                                            text: "Data yang dihapus tidak dapat dikembalikan!",
                                            icon: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#d33",
                                            cancelButtonColor: "#3085d6",
                                            confirmButtonText: "Ya, hapus!",
                                            cancelButtonText: "Batal"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                document.getElementById("hapus-guru-"+data_id).submit();
                                            }
                                        });
                                    });
                                });
                            </script>
                        </li>
                    </ul>
                </div>';
            })
            ->rawColumns(['image','aksi'])
            ->make(true);
        }

         $matapelajarans = MataPelajaran::all();
         return view('teacher.dataguru', [
            'title' => 'Data Guru',
            'matapelajarans' => $matapelajarans 
         ]);
    }

    public function create()
    {
        $matapelajarans = MataPelajaran::all();

        return view('teacher/dataguru_add',[
            'title' => 'Tambah Data Guru' ,
            'matapelajarans' => $matapelajarans 

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validator
        $validator = Validator::make($request->all(),[
            'nip'=>'required',
            'nama'=>'required',
            'photo'=>'nullable|mimes:png,jpg,jpeg|max:2408',
            'email'=>'required|email',
            // 'jkelamin'=>'required|in:Laki-laki, Perempuan',   
            'password'=>'required',   
            'alamat'=>'required',
            // 'matapelajaran'=>'required|in:MTK, BING',   
   

        ]);
        // jika valid gagal
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        // terima dan kirim
        
        $photo    = $request->file('photo');
        if($photo){
            $filename = date('Y-m-d').$photo->getClientOriginalName();
            $path     = 'photo-guru/'.$filename;
    
            Storage::disk('public')->put($path,file_get_contents($photo));
        }

        $data['nip'] = $request->nip;
        $data['name'] = $request->nama;
        $photo    = $request->file('photo');
        if($photo){
            $filename = date('Y-m-d').$photo->getClientOriginalName();
            $path     = 'photo-guru/'.$filename;
    
            Storage::disk('public')->put($path,file_get_contents($photo));
            $data['image']         = $filename;

            
        }        
        $data['jenis_kelamin'] = $request->jkelamin;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['alamat'] = $request->alamat;
        $data['mata_pelajaran'] = $request->matapelajaran;

        // $newGuru = Guru::request($data);
        // $newGuru->assignRole('admin');

        // $guru = Guru::updateOrCreate([
        //     'nip'=>'request->nip',
        // ]);

    
        
        //create
        if($guru = Guru::create($data)){
        // Pastikan peran 'guru' sudah ada di basis data atau buat jika belum ada
        $role = Role::firstOrCreate(['name' => 'guru', 'guard_name' => 'guru']);
        // Memberikan peran 'guru' kepada guru yang telah dibuat dengan menggunakan guard 'guru'
        $guru->assignRole($role);
        
            // $guru->assignRole('admin');
            // $guru->syncRoles(['admin']);
            return redirect()->route('guru')->with('success', 'Data Guru berhasil ditambahkan');
            
            // $newGuru = Guru::request($data);
       
            // DB::table('model_has_roles')->insert([
            //     'model_id' => $newGuru->id,
            //     'role_id' => 4,
            // ]);
            // $guru = Guru::create($data);

        }else{
            return redirect()->route('guru')->with('fail', 'Data Guru gagal ditambahkan');
        }
        //kembali
        // dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {
        // Ambil data guru berdasarkan ID
    $data = Guru::findOrFail($id);

    // Ambil data mata pelajaran dari tabel mata pelajaran
    $matapelajarans = MataPelajaran::all();

    return view('teacher/dataguru_update',[
        'title' => 'Edit Data Guru',
        'data' => $data,
        'matapelajarans' => $matapelajarans // Kirim data mata pelajaran ke view
    ]);
   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        
            //validator
            $validator = Validator::make($request->all(),[
            // 'nip'=>'required',
            'photo'=>'nullable|mimes:png,jpg,jpeg|max:2408',
            // 'nama'=>'required',
            // 'email'=>'required|email',
            // // 'jkelamin'=>'required|in:Laki-laki, Perempuan',   
            // 'password'=>'required',   
            // 'alamat'=>'required',
            // 'matapelajaran'=>'required|in:MTK, BING',   
   

        ]);
        // jika valid gagal
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator); 
        
        // Ambil data siswa berdasarkan ID
        $data = Guru::find($id);
        $namaguru = $data->name;


        $data->nip = $request->nip;
        $data->name = $request->nama;
        $data->jenis_kelamin = $request->jkelamin;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->alamat = $request->alamat;
        $data->mata_pelajaran = $request->matapelajaran;

        // Periksa apakah password baru diisi
        if($request->password){
            $data->password = Hash::make($request->password);
        }

        $photo    = $request->file('photo');
        if($photo){
            $filename = date('Y-m-d').$photo->getClientOriginalName();
            $path     = 'photo-guru/'.$filename;
    
            Storage::disk('public')->put($path,file_get_contents($photo));
            $data['image']         = $filename;

            
        }
    
        // Simpan perubahan data
        if($data->save()){
            return redirect()->route('guru')->with('success-update', 'Data Guru '.$namaguru.' berhasil diedit');
        }else{
            return redirect()->route('guru')->with('fail', 'Data Guru '.$namaguru.' gagal diedit');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Guru::findOrFail($id);
        $namaguru = $data->name;
        if($data->delete()){
            return redirect()->back()->with('success-delete', 'Data Guru '.$namaguru.' berhasil dihapus');
        }else{
            return redirect()->back()->with('fail', 'Data Guru'.$namaguru.'gagal dihapus');
        }
    }
}
