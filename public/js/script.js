// serverside yajra data siswa
$(document).ready(function() {
    let sortirjurusan = $("#filter-jurusan").val(),
        sortirkelas = $("#filter-kelas").val(),
        sortirjenisKelamin = $("#filter-jenis_kelamin").val(),
        sortirstatus = $("#filter-status").val();

    const table = $('#dataSiswa').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/siswa",
            data: function(d){
                d.sortirjurusan = sortirjurusan; 
                d.sortirkelas = sortirkelas;
                d.sortirjenisKelamin = sortirjenisKelamin;
                d.sortirstatus = sortirstatus;
                return d;
            }
        },
        columns:[
            {
                data:'nisn',
                name:'nisn',
            },
            {
                data:'image',
                name:'image',
            },
            {
                data:'name',
                name:'name',
            },
            {
                data:'jenis_kelamin',
                name:'jenis_kelamin',
            },
            {
                data:'jurusan',
                name:'jurusan',
            },
            {
                data:'kelas',
                name:'kelas',
            },
            {
                data:'email',
                name:'email',
            },
            {
                data:'password',
                name:'password',
            },
            {
                data:'alamat',
                name:'alamat',
            },
            {
                data:'tahun_lulus',
                name:'tahun_lulus',
            },
            {
                data:'status',
                name:'status',
            },
            {
                data:'aksi',
                name:'aksi',
            },
        ]
    });

    $(".filter").on('change',function(){
        sortirjurusan = $("#filter-jurusan").val();
        sortirkelas = $("#filter-kelas").val();
        sortirjenisKelamin = $("#filter-jenis_kelamin").val();
        sortirstatus = $("#filter-status").val();
        table.ajax.reload(null,false);
    });
});


// serverside yajra data guru
$(document).ready(function() {
    let sortirjenisKelamin = $("#filter-jenis_kelamin").val(),
        sortirMataPelajaran = $("#filter-mata_pelajaran").val();

    const table = $('#dataguru').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/guru",
            data: function(d){
                d.sortirjenisKelamin = sortirjenisKelamin; 
                d.sortirMataPelajaran = sortirMataPelajaran;
                return d;
            }
        },
        columns:[
            {
                data:'nip',
                name:'nip',
            },
            {
                data:'image',
                name:'image',
            },
            {
                data:'name',
                name:'name',
            },
            {
                data:'email',
                name:'email',
            },
            {
                data:'alamat',
                name:'alamat',
            },
            {
                data:'jenis_kelamin',
                name:'jenis_kelamin',
            },
            {
                data:'mata_pelajaran',
                name:'mata_pelajaran',
            },
            {
                data:'aksi',
                name:'aksi',
            },
        ]
    });

    $(".filter").on('change',function(){
        sortirjenisKelamin = $("#filter-jenis_kelamin").val(),
        sortirMataPelajaran = $("#filter-mata_pelajaran").val();
        table.ajax.reload(null,false);
    });
});


// serverside yajra data kelas
$(document).ready(function() {
    const table = $('#dataKelas').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/data-kelas",
        },
        columns:[
            {
                data:'id_jurusan',
                name:'id_jurusan',
            },
            {
                data:'nama_jurusan',
                name:'nama_jurusan',
            },
            {
                data:'aksi',
                name:'aksi',
            },
        ]
    });

    // $(".filter").on('change',function(){
    //     sortirjenisKelamin = $("#filter-jenis_kelamin").val(),
    //     sortirMataPelajaran = $("#filter-mata_pelajaran").val();
    //     table.ajax.reload(null,false);
    // });
});




// sweetalert
// datatables
// new DataTable('#dataSiswa');
// new DataTable('#dataKelas');
new DataTable('#dataNilai');



// chart nilai
// <block:segmentUtils:1>
const skipped = (dataNilai, value) => dataNilai.p0.skip || dataNilai.p1.skip ? value : undefined;
const down = (dataNilai, value) => dataNilai.p0.parsed.y > dataNilai.p1.parsed.y ? value : undefined;

const genericOptions = {
    fill: false,
    interaction: {
        intersect: false
    },
    radius: 0,
};
// </block:genericOptions>

// <block:config:0>
const nilaiData = [83, 85.4, 90, 86, 85];
const dataNilai = document.getElementById('datanilai');
new Chart(dataNilai, {
    type: 'line',
    data: {
        labels: ['Semester 1', 'Semester 2', 'Semester 3', 'Semester 4', 'Semester 5'],
        datasets: [{
            label: 'Grafik Nilai Per Semester',
            data: nilaiData,
            borderColor: 'rgb(75, 192, 192)',
            segment: {
                borderColor: dataNilai => skipped(dataNilai, 'rgb(0,0,0,0.2)') || down(dataNilai, 'rgb(192,75,75)'),
                borderDash: dataNilai => skipped(dataNilai, [6, 6]),
            },
            spanGaps: true
        }]
    },
    options: {
        scale: {
            y: {
                suggestedMax: 100,
            }
        }
    }

});
// </block:config>

module.exports = {
    actions: [],
    config: config,
};

// Tangkap event submit dari formulir
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.confirm-form-submit').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Menghentikan pengiriman formulir secara langsung

            // Menampilkan SweetAlert konfirmasi penghapusan
            var formId = this.getAttribute('id');
            confirmFormSubmission(formId);
        });
    });
});
