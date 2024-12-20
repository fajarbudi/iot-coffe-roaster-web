<table class="table border mt-3">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Tugas</th>
            <th scope="col">Nama Pembuat</th>
            <th scope="col">Waktu Proses</th>
            <th scope="col">Status</th>
            <th style="min-width: 100px; width: 150px">
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addTugas"
                    data-bs-whatever="@getbootstrap">Buat Tugas
                </button>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $project)
        <tr>
            <td>{{$key + 1}}</td>
            <td>{{$project->namaProject}}</td>
            <td>{{$project->namaPembuat}}</td>
            <td>{{$project->waktuProses}} Menit</td>
            <td class="{{($project->status == 'inProgress') ? 'text-success' : 'text-danger'}}">
                {{$project->status}}</td>
            <td>
                @if ($project->status == "inProgress")
                <a class="btn btn-sm btn-success me-2" href={{route('tugas', $project->id )}}>
                    <i class="bi bi-play"></i>
                </a>
                @endif
                @if ($project->status != 'inProgress')
                <a class="btn btn-sm btn-primary me-2" href={{route('hasilTugas', $project->id )}}>
                    <i class="bi bi-journals me-1 mb-1"></i>
                </a>
                @endif
                <form action={{route('dellTugas',$project->id)}} class="d-inline" method="POST"
                    id="hapusTugas{{$project->id}}">
                </form>
                <button class="btn btn-sm btn-danger" id="del{{$project->id}}">
                    <i class="bi bi-x-square"></i>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- Pop Up --}}
<div class="modal fade" id="addTugas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center mb-3">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tugas Baru</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="buatTugas" action={{route('addTugas')}} method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nama" name="namaProject" placeholder="Nama Tugas"
                            value="{{old('namaProject')}}">
                        <label for="nama">Nama Tugas</label>
                        @error('namaProject')
                        <p class="ms-2 mt-1 text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="namaPembuat" name="namaPembuat"
                            placeholder="Nama Pembuat" value="{{old('namaPembuat')}}">
                        <label for="namaPembuat">Nama Pembuat</label>
                        @error('namaPembuat')
                        <p class="ms-2 mt-1 text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="numeric" class="form-control" id="waktuProses" name="waktuProses"
                            placeholder="Menit">
                        <label for="waktuProses">Waktu Proses</label>
                        @error('waktuProses')
                        <p class="ms-2 mt-1 text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-square"></i>
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="simpan()">
                    <i class="bi bi-floppy"></i>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>


@push('jQuery')
<script>
    let data = {{ Js::from($data) }};

    $.each( data, function( key, data ) {
    $(`#del${data.id}`).on('click', () =>{
     Swal.fire({
       title: "Apakah Kamu Yakin?",
       text: `Menghapus Tugas : ${data.namaProject}`,
       icon: "warning",
       showCancelButton: true,
       confirmButtonColor: "#3085d6",
       cancelButtonColor: "#d33",
       confirmButtonText: "Ya, Hapus"
    }).then((result) => {
       if (result.isConfirmed) {
        $(`#hapusTugas${data.id}`).submit()
         Swal.fire({
         title: "Terhapus!",
         text: "Tugas Telah Dihapus",
         icon: "success"
        });
      }
    });
       })
    });

    const simpan = () =>{
    Swal.fire({
       title: "Apakah Kamu Yakin?",
       text: "Menyimpan Tugas",
       icon: "warning",
       showCancelButton: true,
       confirmButtonColor: "#3085d6",
       cancelButtonColor: "#d33",
       confirmButtonText: "Ya,  Simpan"
    }).then((result) => {
       if (result.isConfirmed) {
        $("#buatTugas").submit()
         Swal.fire({
         title: "Tersimpan!",
         text: "Tugas Telah Disimpan",
         icon: "success"
        });
      }
    });
    }
</script>
@endpush