<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;


class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $data = Jurusan::get();

    //     return view('data-kelas.data-kelas',compact('data'),[
    //         'title' => 'Data Jurusan'
    //     ]);
    // }

    public function jurusan(Request $request){
        if ($request->ajax()) {
            $query = Jurusan::query();
            // $data = new User;
            // // Tangani filter jika diperlukan
            // if ($request->filled('sortirjenisKelamin')) {
            //     $query->where('jenis_kelamin', $request->input('sortirjenisKelamin'));
            // }
            // if ($request->filled('sortirMataPelajaran')) {
            //     $query->where('mata_pelajaran', $request->input('sortirMataPelajaran'));
            // }
            // Ambil data sesuai query

            $data = $query->get();

            // Return data dengan DataTables
            return DataTables::of($data)
            ->addColumn('id_jurusan', function($data){
                return $data->id_jurusan;
            })
            ->addColumn('nama_jurusan', function($data){
                return $data->nama_jurusan;
            })
            ->addColumn('aksi', function($data) {
                return
            //     '<div class="modal fade" id="editDataJurusan{{ $d->id_jurusan }}" tabindex="" aria-labelledby="exampleModalLabel" aria-hidden="true">
            //         <div class="modal-dialog modal-xl modal-fullscreen-sm-down">
            //         <div class="modal-content">
            //             <div class="modal-header">
            //             <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Mata Pelajaran</h1>
            //             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            //             </div>
            //             {{-- edit section --}}
            //             {{-- <div class="modal-body">
            //             <form action="'.route('data-kelas.update', $data->id_jurusan).'" method="POST">
            //                 ' . method_field('PUT') . '
            //                 ' . csrf_field() . '
            //                 <div class="container-fluid">
            //                 <div class="row">
            //                     <div class="col-12 mb-3">
            //                     <label for="id_mapel" class="text-secondary mb-3">ID Mata Pelajaran</label>
            //                     <div class="input-group mb-2">
            //                         <input type="text" class="form-control" id="id_jurusan" name="id_jurusan" value="{{ $d->id_jurusan }}">
            //                     </div>
            //                     @error('id_jurusan')
            //                     <small class="text-danger">{{ $message }}</small>
            //                     @enderror
            //                     </div>
            //                     <div class="col-12 mb-3">
            //                     <label for="nama_jurusan" class="text-secondary mb-3">Nama Mata Pelajaran</label>
            //                     <div class="input-group mb-2">
            //                         <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" value="{{ $d->nama_jurusan }}">
            //                     </div>
            //                     @error('nama_jurusan')
            //                     <small class="text-danger">{{ $message }}</small>
            //                     @enderror
            //                     </div>
            //                 </div>
            //                 </div>
            //                 <div class="modal-footer">
            //                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            //                 <button type="submit" class="button py-2 px-3 rounded text-decoration-none text-center" data-bs-dismiss="modal">Edit</button>
            //                 </div>
            //                 </form>
            //             </div>
            //         </div>
            //         </div>
            //     </div>
                <div class="dropdown py-3">
                    <a class="button py-2 px-3 rounded text-decoration-none text-center dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-fill-gear me-2 i-icon"></i>Option
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="" data-bs-toggle="modal" data-bs-target="#editDataJurusan'.$data->id_jurusan.'" class="dropdown-item"><i class="bi bi-person-fill-gear me-2 i-icon"></i>Edit</a>
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
            ->rawColumns(['aksi'])
            ->make(true);
        }
         return view('data-kelas.data-kelas', [
            'title' => 'Data Jurusan',
         ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'id_jurusan'=>'required',
            'nama_jurusan'=>'required',

        ]);
        // jika valid gagal
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        // terima dan kirim
            // terima dan kirim
            $data['id_jurusan'] = $request->id_jurusan;
            $data['nama_jurusan'] = $request->nama_jurusan;

            if(Jurusan::create($data)){
                //kembali
                return redirect()->route('data-kelas')->with('success', 'Data Jurusan berhasil ditambahkan');
            }else{
                return redirect()->route('data-kelas')->with('fail', 'Data Jurusan gagal ditambahkan');
            }
            
            //kembali
            // dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editin
     * g the specified resource.
     */
    public function edit(Request $request, $id)
    {
    // $data = Jurusan::findOrFail($id);

    // return view('data-kelas.data-kelas', [
    //     'title' => 'Edit Data Jurusan',
    //     'data' => $data,
    // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        // dd($mapel);
        $nama_jurusan = $jurusan->nama_jurusan;

        if($jurusan->update([
            'id_jurusan'     => $request->id_jurusan,
            'nama_jurusan'   => $request->nama_jurusan
        ])){
            return redirect()->route('data-kelas')->with(['success-update' => 'Data Mata Pelajaran '.$nama_jurusan.' Berhasil DiUpdate!']);
        } else{
            return redirect()->route('data-kelas')->with(['fail' => 'Data Mata Pelajaran '.$nama_jurusan.' Gagal DiUpdate!']);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Redirect dengan pesan sukses
        $jurusan = Jurusan::findOrFail($id);
        // dd($mapel);
        $nama_jurusan = $jurusan->nama_jurusan;

        if($jurusan->delete()){
            return redirect()->route('data-kelas')->with(['success-delete' => 'Data Jurusan '.$nama_jurusan.' Berhasil Dihapus!']);
        }else {
            return redirect()->route('data-kelas')->with(['fail' => 'Data Jurusan '.$nama_jurusan.' Berhasil Dihapus!']);
        }
    }
}
