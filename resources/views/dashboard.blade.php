@extends('layouts.new')

@php
    $d = Auth::user()->department;
    $department = Illuminate\Support\Facades\DB::table('tbl_department')
        ->where('id', $d)
        ->first();
@endphp
@section('content')
    <div class="row my-4">
        <div class="col-xl-2 col-sm-6">
            <!-- Card -->
            <div class="card">
                <div class="card-body">

                    <h6 class="my-auto text-primary"><strong>ចំនួនបណ្តឹងសរុបប្រចាំនាយកដ្ឋាន</strong></h6>
                    <div class="d-flex my-2 py-1 px-0 justify-content-between">
                        <h6><strong class="text-primary">(ទាំងអស់):</strong></h6>
                        <h6><strong class="text-danger">{{ $post }}</strong></h6>
                    </div>
                    <canvas id="bar1"></canvas>

                </div>
            </div>
        </div>

        <div class="col-xl-2 col-sm-6">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('dashboardCase', ['status' => 'all']) }}" class="text-decoration-none">
                        <h6 class="my-auto text-primary">
                            <strong>ចំនួនបណ្តឹងសរុប</strong>
                        </h6>
                        <div class="d-flex my-2 py-1 px-0 justify-content-between">
                            <h6><strong class="text-danger">({{ $department->department_name }}):</strong></h6>
                            <h6><strong class="text-danger">{{ $all }}</strong></h6>
                        </div>

                        <canvas id="line1"></canvas>
                    </a>
                </div>
            </div>
        </div>


        <div class="col-xl-2 col-sm-6">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('dashboardCase', ['status' => '1']) }}" class="text-decoration-none">
                        <h6 class="my-auto text-primary"><strong>ចំនួនបណ្តឹងកំពុងទទួលបាន</strong></h6>
                        <div class="d-flex my-2 py-1 px-0 justify-content-end">

                            <h6><strong class="text-danger">{{ $received }}</strong></h6>
                        </div>

                        <canvas id="bar2"></canvas>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-6">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('dashboardCase', ['status' => '2']) }}" class="text-decoration-none">
                        <h6 class="my-auto text-primary"><strong>ចំនួនបណ្តឹងកំពុងដោះស្រាយ</strong></h6>
                        <div class="d-flex my-2 py-1 px-0 justify-content-end">
                            <h6><strong class="text-danger">{{ $in_progress }}</strong></h6>
                        </div>
                        <canvas id="line2"></canvas>
                    </a>

                </div>
            </div>
        </div>

        <div class="col-xl-2 col-sm-6">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('dashboardCase', ['status' => '3']) }}" class="text-decoration-none">
                        <h6 class="my-auto text-primary"><strong>ចំនួនបណ្តឹងបានដោះស្រាយរួចរាល់</strong></h6>
                        <div class="d-flex my-2 py-1 px-0 justify-content-end">

                            <h6><strong class="text-danger">{{ $solved }}</strong></h6>
                        </div>


                        <canvas id="line3"></canvas>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-6">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('dashboardCase', ['status' => '4']) }}" class="text-decoration-none">
                        <h6 class="my-auto text-primary"><strong>ចំនួនបណ្តឹងមិនបានបន្តនីតិវិធី</strong></h6>
                        <div class="d-flex my-2 py-1 px-0 justify-content-end">

                            <h6><strong class="text-danger">{{ $dismiss }}</strong></h6>
                        </div>

                        <canvas id="bar3"></canvas>
                    </a>
                </div>
            </div>
        </div>

    </div>
    <div class="bg-white p-3 rounded my-3">
        <h4 class="my-auto text-black py-3"><strong>បណ្តឹងថ្ងៃនេះ</strong></h4>
        <table class="table table-hover table-nowrap mb-0 align-middle table-check">
            <thead class="table-light">
                <tr>
                    <th>កាលបរិច្ឆេទទទួលបណ្តឹង</th>
                    <th>លេខបណ្ដឺង</th>
                    <th>ម្ចាស់បណ្តឹង</th>
                    <th>ប្រភេទ</th>

                    <th>មន្រ្តីទទួលបណ្តឹង</th>
                    <th>មន្ត្រីទទួលដោះស្រាយ</th>
                    <th>ស្ថានភាព</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($getRecordToday as $value)
                    <tr>
                        <td class="align-middle">{{ $value->sent_date }}</td>
                        <td class="align-middle fw-bold text-primary">{{ $value->case_number }}</td>
                        <td class="align-middle">
                            <h6 class="my-auto py-1">{{ $value->complainer_name }}</h6>
                            <h6 class="my-auto py-1">{{ $value->complainer_tele }}</h6>
                        </td>

                        <td class="align-middle">
                            @if ($value->is_new == 1)
                                <div class="box new">ថ្មី</div>
                            @else
                                <div class="box old">ចាស់</div>
                            @endif
                        </td>

                        <td class="align-middle">
                            <h6>
                                {{ $value->officer_fullname }}
                            </h6>
                        </td>

                        <td class="align-middle">
                            <h6>{{ $value->department_fullname }}</h6>
                        </td>

                        <td class="align-middle">
                            <div class="d-flex justify-content-between">
                                @switch($value->status)
                                    @case(1)
                                        <div class="d-flex">
                                            <img src="/recieved.png" alt="" height="35" class="my-auto mx-1">
                                            <h6 class="my-auto">បានទទួល</h6>
                                        </div>
                                    @break

                                    @case(2)
                                        <div class="d-flex">
                                            <img src="/loading.png" alt="" height="34" class="my-auto mx-1">
                                            <h6 class="my-auto">កំពុងដោះស្រាយ</h6>
                                        </div>
                                    @break

                                    @case(3)
                                        <div class="d-flex">
                                            <img src="/completed.png" alt="" height="35" class="my-auto mx-1">
                                            <h6 class="my-auto">ដោះស្រាយរួចរាល់</h6>
                                        </div>
                                    @break

                                    @default
                                        <div class="d-flex">
                                            <img src="/dismiss.png" alt="" height="33" class="my-auto mx-1">
                                            <h6 class="my-auto">បោះបង់</h6>
                                        </div>
                                @endswitch


                                <div>
                                    <a href="/viewcase/{{ $value->case_number }}"
                                        class="rounded p-2 border-0 text-white me-3 text-decoration-none"
                                        style="background-color:orange">
                                        ចូលមើល
                                    </a>

                                    @if ($value->status == 3)
                                        <a href="#"
                                            class="rounded p-2 border-0 bg-secondary text-white text-decoration-none"
                                            style="cursor: default;" disabled>ចូលកែប្រែ</a>
                                    @elseif ($value->status == 4)
                                        <button
                                            class="rounded p-2 border-0 bg-secondary text-white text-decoration-none cursor-default"
                                            style="cursor: default;">ចូលកែប្រែ</button>
                                    @else
                                        <a href="/case/{{ $value->case_number }}"
                                            class="rounded p-2 border-0 bg-primary text-white text-decoration-none">ចូលកែប្រែ</a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>


    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>
    <script src="assets/js/pages/dashboard-sales.init.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        for (let i = 0; i < 3; i++) {
            const line = document.getElementById('line' + String(i + 1))
            new Chart(line, {
                type: 'line',
                data: {
                    labels: ['', '', '', '', '', '', '', ''],
                    datasets: [{
                        data: [24 * Math.floor((Math.random() * 10) + 1), 12 * Math.floor((Math.random() *
                                10) + 1), 20 * Math.floor((Math.random() * 10) + 1), 13 * Math.floor((
                                Math.random() * 10) + 1), 17 * Math.floor((Math.random() * 10) + 1),
                            30 * Math.floor((Math.random() * 10) + 1), 8 * Math.floor((Math.random() *
                                10) + 1), 16 * Math.floor((Math.random() * 10) + 1)
                        ],

                    }]
                },
                options: {

                    scales: {
                        y: {
                            ticks: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // hide the legend
                        },
                        tooltip: {
                            enabled: false
                        },
                    }
                },
            });
        }

        for (let i = 0; i < 3; i++) {

            const bar = document.getElementById('bar' + String(i + 1))
            new Chart(bar, {
                type: 'bar',
                data: {
                    labels: ['', '', '', '', '', '', '', ''],
                    datasets: [{
                        data: [24 * Math.floor((Math.random() * 10) + 1), 12 * Math.floor((Math.random() *
                                10) + 1), 20 * Math.floor((Math.random() * 10) + 1), 13 * Math.floor((
                                Math.random() * 10) + 1), 17 * Math.floor((Math.random() * 10) + 1),
                            30 * Math.floor((Math.random() * 10) + 1), 8 * Math.floor((Math.random() *
                                10) + 1), 16 * Math.floor((Math.random() * 10) + 1)
                        ],

                    }]
                },
                options: {
                    scales: {
                        y: {
                            ticks: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // hide the legend
                        },
                        tooltip: {
                            enabled: false
                        },
                    }
                }
            });
        }
    </script>
@endsection
