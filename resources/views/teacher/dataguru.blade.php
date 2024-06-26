@extends('layouts.app')
@section('content')
<div class="container-fluid">
  @include('partials.notification')
  <div class="row">
    <div class="col-12 mt-4">
      <div class="d-flex">
        <h4>Data Guru</h4>
        <a href="/guru/tambah" class="py-1 px-3 text-center align-items-center d-flex rounded text-decoration-none button ms-auto"><i class="fa-solid fa-user-plus me-2"></i>Tambah Guru</a>
      </div>
      <div class="container-fluid px-4" data-aos="fade-up">
        <div class="row">
          <div class="col p-0">
            <div class="row mt-3">
              <div class="col-6">
                <div class="input-group mb-3 mt-3">
                  <select id="filter-jenis_kelamin" class="filter rounded form-select">
                    <option value="" multiple aria-label="Multiple select example">Semua Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="input-group mb-3 mt-3">
                  <select id="filter-mata_pelajaran" class="filter rounded form-select">
                    <option value="" multiple aria-label="Multiple select example">Semua Mata Pelajaran</option>
                    @foreach($matapelajarans as $matapelajaran)
                        <option value="{{ $matapelajaran->id_mata_pelajaran }}">{{ $matapelajaran->nama_mata_pelajaran }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              {{-- input manual --}}
              {{-- <div class="col d-none">
                <div class="input-group mb-3 mt-3">
                  <input type="text" name="search" class="form-control" aria-label="Text input with dropdown button" placeholder="Cari siswa berdasarkan NIP atau Nama" value="">
                </div>
              </div> --}}
            </div>
            <div class="card mt-3" style="height: 43rem">
              <div class="card-body table-responsive">
                {{-- empty --}}
                {{-- <div class="d-flex flex-column text-center d-flex justify-content-center align-items-center text-secondary h-100">
                  <h3 class="fw-medium">Data Guru Tidak Ada</h3>
                  <h5 class="">Segera Isi Tambah Guru</h5>
                </div> --}}
                {{-- @endempty --}}
                {{-- ada --}}
                <div class="">
                  <table id="dataguru" class="table table-bordered w-100 mt-3">
                    <thead>
                      <tr>
                        <th>NIP</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        {{-- <th>Password</th> --}}
                        <th>Jenis Kelamin</th>
                        <th>Mata Pelajaran</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    {{-- <tbody> --}}
                      {{-- @foreach($data as $d)
                        <tr>
                          <td>{{ $d->nip }}</td> 
                          <td><img src="{{asset('storage/photo-guru/'.$d->image)}}" alt="" style="width:100px"></td> 
                          <td>{{ $d->name }}</td> 
                          <td>{{ $d->alamat }}</td> 
                          <td>{{ $d->email }}</td> 
                          {{-- <td>{{ $d->password }}</td>  --}}
                          {{-- <td>{{ $d->jenis_kelamin }}</td>
                          <td>{{ $d->mata_pelajaran }}</td>
                          <td class="d-flex justify-content-center align-items-center">
                            <div class="dropdown py-3">
                              <a class="button py-2 px-3 rounded text-decoration-none text-center dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-fill-gear me-2 i-icon"></i>Option
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="{{ route('guru.edit',['id' => $d->id]) }}" class="dropdown-item" href="#"><i class="bi bi-person-fill-gear me-2 i-icon"></i>Edit</a></li>
                                <li>
                                  <form id="hapus-guru-{{ $d->id }}" action="{{ route('guru.hapus', $d->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" id="btnHapusGuru{{ $d->id }}" class="dropdown-item text-danger">
                                      <i class="bi bi-person-fill-dash me-2 i-icon"></i>Hapus
                                    </button>
                                  </form>
                                </li>       
                                  <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        document.getElementById('btnHapusGuru{{ $d->id }}').addEventListener('click', function() {
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
                                                    document.getElementById('hapus-guru-{{ $d->id }}').submit();
                                                }
                                            });
                                        });
                                    });
                                  </script>
                                </li>                    
                              </ul>
                            </div>
                          </td>
                        </tr> --}}
                      {{-- @endforeach --}}
                    {{-- </tbody> --}}
                  </table>
                </div>
                {{-- gak ada --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection