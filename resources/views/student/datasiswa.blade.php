@extends('layouts.app')
@section('content')
<div class="container-fluid">
  @include('partials.notification')
  <div class="row">
    <div class="col-12 mt-4">
        <div class="d-flex">
          <h4>Data Siswa</h4>
          <a href="{{ route('tambah_siswa') }}" class="py-1 px-3 text-center align-items-center d-flex rounded text-decoration-none button ms-auto"><i class="fa-solid fa-user-plus me-2"></i>Tambah siswa</a>
        </div>
        <div class="container-fluid px-4" data-aos="fade-up">
          <div class="row">
            <div class="col p-0">
              {{-- sortir data siswa
              <form action="{{ route('siswa') }}" method="GET">
                <div class="row mt-3">
                  <div class="col-3">
                    <div class="input-group mb-3 mt-3">
                      <select name="jurusan" id="jurusan" class="rounded form-select">
                        <option value="" multiple aria-label="Multiple select example">Semua Jurusan</option>
                        @foreach ($jurusans as $jurusan)
                        <option value="{{ $jurusan->id_jurusan }}" {{ request('jurusan') == $jurusan->id_jurusan ? 'selected' : '' }}>{{ $jurusan->nama_jurusan }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="input-group mb-3 mt-3">
                      <select name="kelas" id="kelas" class="rounded form-select">
                        <option value="" multiple aria-label="Multiple select example">Semua Kelas</option>
                        <option value="X" {{ request()->input('kelas') == 'X' ? 'selected' : '' }}>X/SEPULUH</option>
                        <option value="XI" {{ request()->input('kelas') == 'XI' ? 'selected' : '' }}>XI/SEBELAS</option>
                        <option value="XII" {{ request()->input('kelas') == 'XII' ? 'selected' : '' }}>XII/DUA BELAS</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="input-group mb-3 mt-3">
                      <select name="jenis_kelamin" id="jenis_kelamin" class="rounded form-select">
                        <option value="" multiple aria-label="Multiple select example">Semua Jenis Kelamin</option>
                        <option value="Laki-laki" {{ request()->input('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="Perempuan" {{ request()->input('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="input-group mb-3 mt-3">
                      <select name="status" id="status" class="rounded form-select">
                        <option value="" multiple aria-label="Multiple select example">Semua Status</option>
                        <option value="Belum Lulus" {{ request()->input('status') == 'Belum Lulus' ? 'selected' : '' }}>Siswa Aktif</option>
                        <option value="Lulus" {{ request()->input('status') == 'Lulus' ? 'selected' : '' }}>Alumni</option>
                      </select>
                    </div>
                  </div>
                  {{-- input manual --}}
                  {{-- <div class="col d-none">
                    <div class="input-group mb-3 mt-3">
                      <input type="text" name="search" class="form-control" aria-label="Text input with dropdown button" placeholder="Cari siswa berdasarkan NIP atau Nama" value="">
                    </div>
                  </div> --}}
                  {{-- <div class="col-12 mb-2 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-sort me-2"></i>Sortir Data Siswa</button>
                  </div>
                </div> --}}
              {{-- </form> --}}
              <div class="row mt-3">
                <div class="col-3">
                  <div class="input-group mb-3 mt-3">
                    <select id="filter-jurusan" class="filter rounded form-select">
                      <option value="" multiple aria-label="Multiple select example">Semua Jurusan</option>
                      @foreach ($jurusans as $jurusan)
                      <option value="{{ $jurusan->id_jurusan }}">{{ $jurusan->nama_jurusan }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="input-group mb-3 mt-3">
                    <select id="filter-kelas" class="filter rounded form-select">
                      <option value="" multiple aria-label="Multiple select example">Semua Kelas</option>
                      <option value="X">X/SEPULUH</option>
                      <option value="XI">XI/SEBELAS</option>
                      <option value="XII">XII/DUA BELAS</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="input-group mb-3 mt-3">
                    <select id="filter-jenis_kelamin" class="filter rounded form-select">
                      <option value="" multiple aria-label="Multiple select example">Semua Jenis Kelamin</option>
                      <option value="Laki-laki">Laki-Laki</option>
                      <option value="Perempuan">Perempuan</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="input-group mb-3 mt-3">
                    <select id="filter-status" class="filter rounded form-select">
                      <option value="" multiple aria-label="Multiple select example">Semua Status</option>
                      <option value="Belum Lulus">Siswa Aktif</option>
                      <option value="Lulus">Alumni</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="card mt-3" style="min-height: 43rem">
                <div class="card-body table-responsive">
                  <div class="">
                    <table class="table table-bordered w-100 mt-3" id="dataSiswa">
                      <thead>
                        <tr>
                          <th>NISN</th>
                          <th>Foto</th>
                          <th>Nama</th>
                          <th>Jenis Kelamin</th>
                          <th>Jurusan</th>
                          <th>Kelas</th>
                          <th>Email</th>
                          <th>Password</th>
                          <th>Alamat</th>
                          <th>Tahun Lulus</th>
                          <th>Status</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                        {{-- @foreach($data as $d)
                        <tr>
                          <td>{{ $d->nisn }}</td> 
                          <td>
                            <img src="{{asset('storage/photo-user/'.$d->image)}}" alt="" style="width: 100px">
                          </td> 
                          <td>{{ $d->name }}</td> 
                          <td>{{ $d->jenis_kelamin }}</td> 
                          <td>{{ $d->jurusan }}</td> 
                          <td>{{ $d->kelas }}</td> 
                          <td>{{ $d->email }}</td> 
                          <td>{{ $d->password }}</td> 
                          <td>{{ $d->alamat }}</td> 
                          <td>{{ $d->tahun_lulus }}</td> 
                          <td>{{ $d->status }}</td> 
                          <td class="d-flex justify-content-center align-items-center">
                            <div class="dropdown py-3">
                              <a class="button py-2 px-3 rounded text-decoration-none text-center dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-fill-gear me-2 i-icon"></i>Option
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="{{ route('user.edit',['id' => $d->id]) }}" class="dropdown-item" href="#"><i class="bi bi-person-fill-gear me-2 i-icon"></i>Edit</a></li>
                                <li>
                                  <form id="hapus-siswa-{{ $d->id }}" action="{{ route('siswa.hapus', $d->id) }}" method="POST">
                                    <button type="button" id="btnHapusSiswa{{ $d->id }}" class="dropdown-item text-danger">
                                      <i class="bi bi-person-fill-dash me-2 i-icon"></i>Hapus
                                    </button>
                                    @csrf
                                    @method('DELETE')
                                  </form>
                                  <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        document.getElementById('btnHapusSiswa{{ $d->id }}').addEventListener('click', function() {
                                            Swal.fire({
                                                title: 'Apakah Anda yakin menghapus {{ $d->name}} ?',
                                                text: "Data yang dihapus tidak dapat dikembalikan!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#3085d6',
                                                confirmButtonText: 'Ya, hapus!',
                                                cancelButtonText: 'Batal'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    document.getElementById('hapus-siswa-{{ $d->id }}').submit();
                                                }
                                            });
                                        });
                                    });
                                  </script>
                                </li>
                              </ul>
                            </div>
                          </td>
                        </tr>
                        @endforeach  --}}
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
