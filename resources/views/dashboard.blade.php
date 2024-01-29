@extends('layout.main')
@section('title')
UNISEC | Dashboard
@endsection
@section('pages')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard</li>
</ol>
<h6 class="font-weight-bolder text-white mb-0">DASHBOARD</h6>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold mb-2">Anggota Aktif</p>
                            <h5 class="font-weight-bolder" id="anggota">
                                Loading ....
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                            <i class="fa-solid fa-person-rifle text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold mb-2">Kehadiran</p>
                            <h5 class="font-weight-bolder" id="PersenKehadiran">
                                Loading ...
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                            <i class="fas fa-check-circle text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold mb-2">Tidah Hadir</p>
                            <h5 class="font-weight-bolder" id="PersenAlpha">
                                Loading ...
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                            <i class="fas fa-times-circle text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold mb-2">Pertemuan</p>
                            <h5 class="font-weight-bolder" id="presentasePertemuan">
                                Loading ...
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                            <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">Total Anggota PerTahun</h6>
            </div>
            <div class="card-body p-3">
                <div class="chart">
                    <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.get('{{ route('totalAnggota')}}', function(data) {
            $('#anggota').text(data + ' orang');
        });

        $.get('{{ route('presentKehadiran')}}', function(data) {
            $('#PersenKehadiran').text(data.presentaseKehadiran + ' %');
            $('#PersenAlpha').text(data.presentaseAlpha + ' %');
        });

        $.get('{{ route('presentasePertemuan')}}', function(data) {
            $('#presentasePertemuan').text(data + ' Pertemuan');
        });

        $.get('{{ route('AnggotaPerTahun')}}', function(data) {
            const dataTA = new Array(data.ta.length).fill(0);
            const dataAnggota = new Array(data.ta.length).fill(0);

            data.ta.forEach((tahun, index) => {
                dataTA[index] = tahun.nama_ta; // Menggunakan properti nama_ta
                dataAnggota[index] = data.anggota[index];
            });

            LineChart(dataTA, dataAnggota)
        });
    });

    function LineChart(dataTA, dataAnggota)
    {
        var ctx1 = document.getElementById("chart-line").getContext("2d");
        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);
        gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: dataTA,
                datasets: [{
                    label: "Tahun Akademik",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#5e72e4",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: dataAnggota,
                    maxBarThickness: 6
        
                }],
            },
            options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                grid: {
                    drawBorder: false,
                    display: true,
                    drawOnChartArea: true,
                    drawTicks: false,
                    borderDash: [5, 5]
                },
                ticks: {
                    display: true,
                    padding: 10,
                    color: '#fbfbfb',
                    font: {
                    size: 11,
                    family: "Open Sans",
                    style: 'normal',
                    lineHeight: 2
                    },
                }
                },
                x: {
                grid: {
                    drawBorder: false,
                    display: false,
                    drawOnChartArea: false,
                    drawTicks: false,
                    borderDash: [5, 5]
                },
                ticks: {
                    display: true,
                    color: '#ccc',
                    padding: 20,
                    font: {
                    size: 11,
                    family: "Open Sans",
                    style: 'normal',
                    lineHeight: 2
                    },
                }
                },
            },
            },
        });
    }
</script>
@endsection