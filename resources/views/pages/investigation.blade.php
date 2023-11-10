@extends('layouts.new')

@php
    $d = Auth::user()->department;
    $department = Illuminate\Support\Facades\DB::table('tbl_department')
        ->where('id', $d)
        ->first();
@endphp
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/richtexteditor/rte_theme_default.css" />
    <script type="text/javascript" src="/richtexteditor/rte.js"></script>
    <script type="text/javascript" src='/richtexteditor/plugins/all_plugins.js'></script>
    <script>
        let error = false;

        function validateSubmit(event) {
            if (error) {
                error = false;
                event.preventDefault();
            } else {
                document.getElementById('waiting').style.display ="grid";
            }
        }
    </script>

    <style>
        .loading {
            z-index: 1500;
            display: none;
            place-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.4);
            transition: ease-in-out .3s;
        }

        .pop-up {
            margin: auto;
            width: 30vw;
            height: 20vh;
            background: rgba(153, 240, 255);
            border-radius: 3rem;
            padding: 1rem;
            display: grid;
            place-items: center;
        }

        .pop-up h1 {
            text-align: center;
            font-family: 'Moul', cursive;
        }
    </style>
@endsection
@section('content')
    <div class="loading" id="waiting">
        <div class="pop-up">
            <h1>កំពុងបញ្ចូលទិន្នន័យ...</h1>
        </div>
    </div>
    <div class="container ">
        <form action="/updateCase/{{ $case->case_number }}" class="py-2 px-5" id="locationForm" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="pt-3">
                @if (session('success'))
                    <div class="alert alert-success mt-2">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mt-2">
                        {{ session('error') }}
                    </div>
                @endif
            </div>


            <div class="container rounded p-4 bg-light mt-5" style="background:#e9e9e9;">
                <h1 class="py-4 text-center"><strong style="font-family: 'Preahvihear', sans-serif;">ពាក្យបណ្តឹង</strong>
                </h1>

                <hr>

                <div class="row py-2">
                    <div class="col my-auto">
                        <div>
                            <div class="py-2 d-flex">
                                <h5 class="my-auto me-2"><strong>កាលបរិច្ឆេទទទួលបណ្តឹង:</strong></h5>
                                <h5 class="px-0 my-auto text-danger"><strong>{{ $case->received_date }}</strong></h5>
                            </div>
                            <div class="py-2 d-flex">
                                <h5 class="my-auto me-2"><strong>កាលបរិច្ឆេទកំណត់ត្រាបណ្តឹង:</strong></h5>
                                <h5 class="px-0 my-auto text-danger"><strong>{{ $case->sent_date }}</strong></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col my-auto">
                        <div>
                            <div class="py-2 d-flex">
                                <h5 class="my-auto me-2"><strong>លេខបណ្តឹង:</strong></h5>
                                <h5 class="px-0 my-auto text-primary"><strong
                                        style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">{{ $case->case_number }}</strong>
                                </h5>
                            </div>
                            <div class="py-2 d-flex">
                                <h5 class="my-auto me-2"><strong>ប្រភេទបណ្តឹង:</strong></h5>
                                <h5 class="px-0 my-auto text-danger">
                                    <strong>{{ $case->is_new == 1 ? 'ថ្មី' : 'ចាស់' }}</strong>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div>
                            <div class="py-2 d-flex">
                                <h5 class="my-auto me-2"><strong>ស្ថានភាព:</strong></h5>

                                @switch($case->status)
                                    @case(1)
                                        <div class="d-flex">
                                            <img src="/recieved.png" alt="" height="35" class="my-auto mx-1">
                                            <h5 class="px-0 my-auto text-primary"><strong>បានទទួល</strong></h5>
                                        </div>
                                    @break

                                    @case(2)
                                        <div class="d-flex">
                                            <img src="/loading.png" alt="" height="34" class="my-auto mx-1">
                                            <h5 class="px-0 my-auto text-warning"><strong>កំពុងដោះស្រាយ</strong></h5>
                                        </div>
                                    @break

                                    @case(3)
                                        <div class="d-flex">
                                            <img src="/completed.png" alt="" height="35" class="my-auto mx-1">
                                            <h5 class="px-0 my-auto text-success"><strong>ដោះស្រាយរួចរាល់</strong></h5>
                                        </div>
                                    @break

                                    @default
                                        <div class="d-flex">
                                            <img src="/dismiss.png" alt="" height="33" class="my-auto mx-1">
                                            <h5 class="px-0 my-auto text-danger"><strong>បោះបង់</strong></h5>
                                        </div>
                                @endswitch
                            </div>
                        </div>
                        <div class="py-2 d-flex">
                            <h5 class="my-auto me-2"><strong>មន្រ្តីទទួលបណ្តឹង:</strong></h5>
                            <h5 class="px-0 my-auto text-danger">
                                <strong>{{ $case->officer_fullname }}</strong>
                            </h5>
                        </div>
                    </div>
                </div>

                <hr>

                <h4 class="py-2"><strong style="font-family: 'Preahvihear', sans-serif;">ព័ត៏មានម្ចាស់បណ្តឹង</strong>
                </h4>

                <div class="row pt-2 pb-4">
                    <div class="col-4">
                        <div class="py-2 d-flex">
                            <h5 class="my-auto me-2"><strong>ឈ្មោះ:</strong></h5>
                            <h5 class="px-0 my-auto text-danger"><strong>{{ $case->complainer_name }}</strong></h5>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="py-2 d-flex">
                            <h5 class="my-auto me-2"><strong>ភេទ:</strong></h5>
                            <h5 class="px-0 my-auto text-danger">
                                <strong>{{ $case->complainer_gender == 1 ? 'ប្រុស' : 'ស្រី' }}</strong>
                            </h5>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="py-2 d-flex">
                            <h5 class="my-auto me-2"><strong>អាយុ:</strong></h5>
                            <h5 class="px-0 my-auto text-danger"><strong>{{ $case->complainer_age }}</strong></h5>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="py-2 d-flex">
                            <h5 class="my-auto me-2"><strong>លេខទូរស័ព្ទ:</strong></h5>
                            <h5 class="px-0 my-auto text-danger"><strong>{{ $case->complainer_tele }}</strong></h5>
                        </div>
                    </div>
                </div>

                <div class="row py-2">
                    <div class="col-4">
                        <div class="d-flex my-0 py-0">
                            <h5 class="my-auto me-2"><strong>ទីលំនៅ:</strong></h5>
                            <h5 class="px-0 my-auto text-danger">
                                <strong>{{ $case->complainer_address ?? 'គ្មាន​ទិន្នន័យ' }}</strong>
                            </h5>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="d-flex my-0 py-0">
                            <h5 class="my-auto me-2"><strong>ខេត្ត/ក្រុង:</strong></h5>
                            <h5 class="px-0 my-auto text-danger"><strong>{{ $province->name }}</strong></h5>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="d-flex my-0 py-0">
                            <h5 class="my-auto me-2"><strong>ខណ្ឌ/ស្រុក:</strong></h5>
                            <h5 class="px-0 my-auto text-danger">
                                <strong>{{ $district->name ?? ' គ្មាន​ទិន្នន័យ' }}</strong>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="row py-2">
                    <div class="col-4">
                        <div class="d-flex my-0 py-0">
                            <h5 class="my-auto me-2"><strong>ឃុំ/សង្គាត់:</strong></h5>
                            <h5 class="px-0 my-auto text-danger">
                                <strong>{{ $commune->name ?? ' គ្មាន​ទិន្នន័យ' }}</strong>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex my-0 py-0">
                            <h5 class="my-auto me-2"><strong>ភូមិ:</strong></h5>
                            <h5 class="px-0 my-auto text-danger">
                                <strong>{{ $village->name ?? ' គ្មាន​ទិន្នន័យ' }}</strong>
                            </h5>
                        </div>
                    </div>
                </div>

                <hr>
                <h4 class="py-2"><strong style="font-family: 'Preahvihear', sans-serif;">ចំណាត់ការ</strong></h4>
                <div class="row py-2">

                    <div class="my-auto d-flex col-4">


                        <h5 class="px-0 my-auto text-danger">
                            <strong> <span class="text-dark">អង្គភាព :
                                </span>{{ $department->department_name }}</strong>
                        </h5>
                    </div>
                    <div class="my-auto d-flex col-4">
                        <h5 class="my-auto me-2"><strong>មន្ត្រីទទួលដោះស្រាយ:</strong></h5>
                        <h5 class="px-0 my-auto text-danger">
                            <strong>
                                @if ($case->department_fullname != null)
                                    {{ $case->department_fullname }}
                                @else
                                    <h5><strong>គ្មាន</strong></h5>
                                @endif
                            </strong>
                        </h5>
                    </div>
                </div>
                {{-- @if ($case->solved_by_user == Auth::id()) --}}
                <hr>
                <div class="row py-2">
                    <h4 class="my-auto me-2"><strong
                            style="font-family: 'Preahvihear', sans-serif;">ខ្លឹមសារបណ្តឹង</strong></h4>
                    <p class="my-auto py-2">{!! $case->case_story !!}</p>
                </div>

                <hr>


                <div class="py-2">
                    <h6 class="my-auto me-2"><strong>សារសម្លេងសន្ទនា: </strong></h6>
                    @if ($case->voice_recorded != null)
                        @foreach ($audio_files as $voice)
                            <div class="d-flex my-2">
                                <audio controls>
                                    <source
                                        src="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $voice }}"
                                        type="audio/ogg">
                                    <source
                                        src="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $voice }}"
                                        type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                                <a href="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $voice }}"
                                    class="my-auto text-decoration-none btn btn-warning"><strong>ទាញយក</strong></a>
                            </div>
                        @endforeach
                    @else
                        <h6 class="px-0 my-auto text-danger"><strong>មិនមានសារសម្លេងទេ</strong></h6>
                    @endif
                </div>
                <div class="row py-2">
                    <h5 class="my-auto me-2"><strong>ឯកសារ: </strong></h5>
                    @if ($files != null)
                        @foreach ($files as $key => $file)
                            <div class="py-2 d-flex">
                                <h6 class="my-auto me-2 text-danger "><strong>ឯកសារទី {{ $key + 1 }}:
                                    </strong>
                                </h6>
                                <div class="d-flex m-0 p-0">
                                    <a href="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $file }}"
                                        class="my-auto text-decoration-none text-light me-3 btn btn-primary"><strong>ពិនិត្យ</strong></a>
                                </div>
                                <a href="/getfiles/{{ $case->case_number }}/{{ $file }}"
                                    class="my-auto text-decoration-none me-3 btn btn-warning"><strong>ទាញយក</strong></a>
                            </div>
                        @endforeach
                    @else
                        <h6 class="my-auto"><strong>គ្មានឯកសារទេ</strong></h6>
                    @endif
                </div>
                {{-- @else --}}
                <hr>


                <div class="row py-2">
                    <h4 class="my-auto me-2"><strong
                            style="font-family: 'Preahvihear', sans-serif;">ខ្លឹមសារបណ្តឹង</strong></h4>
                    <p class="my-auto py-2">{!! $case->case_story !!}</p>
                </div>

                {{-- @endif --}}

                {{-- input part --}}

                @if ($case->status == 3 || $case->status == 4)
                    <div class="row pt-3 pb-4 container">
                        <hr>
                        <h4 class="px-0 py-1 mb-3 text-center"><strong
                                style="font-family: 'Preahvihear', sans-serif;">របាយការណ៏សេុីបអង្កេតបណ្ដោះអាសន្ន</strong>
                        </h4>
                        <div class="py-0 rounded" style="white-space:pre-wrap; background:#e9e9e9;">
                            {!! $case->case_summary !!}
                        </div>
                    </div>

                    <div class="row pt-3 pb-4 container">
                        <hr>
                        <h4 class="px-0 py-1 mb-3 text-center"><strong
                                style="font-family: 'Preahvihear', sans-serif;">សេចក្ដីសម្រច</strong></h4>
                        <div class="py-0 rounded" style="white-space:pre-wrap; background:#e9e9e9;">
                            {!! $case->solved_summary !!}
                        </div>
                    </div>
                    <div class="row pt-3 pb-4 container">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="formFileMultiple" class="form-label h5 mb-3"><strong
                                        style="font-family: 'Preahvihear', sans-serif;">ភស្តុតាង</strong></label>
                                <input class="form-control" type="file" name="evidence[]" multiple id="photo"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-4"></div>

                        <div class="col-3 ">

                            <div class="mb-3">
                                <label for="formFileMultiple" class="form-label h5 mb-3"><strong
                                        style="font-family: 'Preahvihear', sans-serif;">ដំណើរការនិតិវិធី</strong>
                                </label>
                                <select class="form-select" aria-label="Default select example" name="status" disabled>
                                    <option selected>ជ្រើសរើស</option>
                                    <option value="1"{{ $case->status == 1 ? 'selected' : '' }}>
                                        បានទទួល</option>
                                    <option value="2"{{ $case->status == 2 ? 'selected' : '' }}>
                                        កំពុងដោះស្រាយ</option>
                                    <option value="3"{{ $case->status == 3 ? 'selected' : '' }}>
                                        បានដោះស្រាយរួច</option>
                                    <option value="4"{{ $case->status == 4 ? 'selected' : '' }}>
                                        បោះបង់</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-3 pb-4 container" id="imageContainer">

                    </div>
                    <div class="row d-flex justify-content-center rounded px-5 mb-4">
                        <button type="submit" id="submit" onclick="validateSubmit(event)" class="bg-primary py-3 text-white">បញ្ចូលទិន្នន័យ</button>
                    </div>
                @elseif (
                    ($case->solved_by_user == Auth::id() && $case->status == 1) ||
                        ($case->solved_by_user == Auth::id() && $case->status == 2))
                    <div class="row pt-3 pb-4 container">
                        <hr>
                        <h4 class="px-0 py-1 mb-3 text-center"><strong
                                style="font-family: 'Preahvihear', sans-serif;">របាយការណ៏សេុីបអង្កេតបណ្ដោះអាសន្ន</strong>
                        </h4>
                        <textarea name="case_summary" class="form-control border-secondary" rows="10" id="editor">{!! $case->case_summary !!}</textarea>
                    </div>
                    <div class="row pt-3 pb-4 container">
                        <hr>
                        <h4 class="px-0 py-1 mb-3 text-center"><strong
                                style="font-family: 'Preahvihear', sans-serif;">សេចក្ដីសម្រច</strong></h4>
                        <textarea name="solved_summary" class="form-control border-secondary" rows="10" id="editor1">{!! $case->solved_summary !!}</textarea>
                    </div>
                    <div class="row pt-3 pb-4 container">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="formFileMultiple" class="form-label h5 mb-3"><strong
                                        style="font-family: 'Preahvihear', sans-serif;">ភស្តុតាង</strong></label>
                                <input class="form-control" type="file" name="evidence[]" multiple id="photo">
                            </div>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-3 ">

                            <div class="mb-3">
                                <label for="formFileMultiple" class="form-label h5 mb-3"><strong
                                        style="font-family: 'Preahvihear', sans-serif;">ដំណើរការនិតិវិធី</strong></label>
                                <select class="form-select" aria-label="Default select example" name="status">


                                    <option selected>ជ្រើសរើស</option>
                                    <option value="1"{{ $case->status == 1 ? 'selected' : '' }}>
                                        បានទទួល</option>
                                    <option value="2"{{ $case->status == 2 ? 'selected' : '' }}>
                                        កំពុងដោះស្រាយ</option>
                                    <option value="3"{{ $case->status == 3 ? 'selected' : '' }}>
                                        បានដោះស្រាយរួច</option>
                                    <option value="4"{{ $case->status == 4 ? 'selected' : '' }}>
                                        បោះបង់</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-3 pb-4 container">

                        <div class="row py-2">
                            <h6 class="my-auto me-2"><strong>ឯកសារ: </strong></h6>
                            @if (!empty($reference_files) && !empty(array_filter($reference_files)))
                                @foreach ($reference_files as $key => $reference_file)
                                    <div class="py-2 d-flex">
                                        <h6 class="my-auto me-2 text-danger "><strong>ឯកសារទី {{ $key + 1 }}:
                                            </strong>
                                        </h6>
                                        <div class="d-flex m-0 p-0">
                                            <a href="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $reference_file }}"
                                                class="my-auto text-decoration-none  me-3 btn btn-primary text-light">ពិនិត្យ</a>
                                        </div>
                                        <a href="/getfiles/{{ $case->case_number }}/{{ $reference_file }}"
                                            class="my-auto text-decoration-none btn btn-warning"><strong>ទាញយក</strong></a>
                                    </div>
                                @endforeach
                            @else
                                <h6 class="my-auto"><strong>គ្មានឯកសារទេ</strong></h6>
                            @endif
                        </div>


                        <div class="row pt-3 pb-4 container" id="imageContainer">

                        </div>
                        <div class="row d-flex justify-content-center rounded px-5 mb-4">
                            <button type="submit" id="submit" onclick="validateSubmit(event)" class="bg-primary py-3 text-white">បញ្ចូលទិន្នន័យ</button>
                        </div>
                    @elseif ($case->solved_by_user == null)
                        <div class="row pt-3 pb-4 container">
                            <hr>
                            <h4 class="px-0 py-1 mb-3 text-center"><strong
                                    style="font-family: 'Preahvihear', sans-serif;">របាយការណ៏សេុីបអង្កេតបណ្ដោះអាសន្ន</strong>
                            </h4>
                            <textarea name="case_summary" class="px-4 py-2" rows="10" id="editor">{{ $case->case_summary }}</textarea>
                        </div>

                        <div class="row pt-3 pb-4 container">
                            <hr>
                            <h4 class="px-0 py-1 mb-3 text-center"><strong
                                    style="font-family: 'Preahvihear', sans-serif;">សេចក្ដីសម្រច</strong></h4>
                            <textarea name="solved_summary" class="px-4 py-2" rows="10" id="editor"></textarea>
                        </div>



                        <div class="row pt-3 pb-4 container">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="formFileMultiple" class="form-label h5 mb-3"> <strong
                                            style="font-family: 'Preahvihear', sans-serif;">ភស្តុតាង</strong></label>
                                    <input class="form-control" type="file" name="evidence[]" multiple
                                        id="photo">
                                </div>
                            </div>

                            <div class="col-4"></div>

                            <div class="col-3 ">

                                <div class="mb-3">
                                    <label for="formFileMultiple" class="form-label h5 mb-3"><strong
                                            style="font-family: 'Preahvihear', sans-serif;">ដំណើរការនិតិវិធី</strong></label>
                                    <select class="form-select" aria-label="Default select example" name="status">
                                        <option selected>ជ្រើសរើស</option>
                                        <option value="1"{{ $case->status == 1 ? 'selected' : '' }}>
                                            បានទទួល</option>
                                        <option value="2"{{ $case->status == 2 ? 'selected' : '' }}>
                                            កំពុងដោះស្រាយ</option>
                                        <option value="3"{{ $case->status == 3 ? 'selected' : '' }}>
                                            បានដោះស្រាយរួច</option>
                                        <option value="4"{{ $case->status == 4 ? 'selected' : '' }}>
                                            បោះបង់</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3 pb-4 container" id="imageContainer">

                        </div>

                        <div class="row d-flex justify-content-center rounded px-5 mb-4">
                            <button type="submit" id="submit" onclick="validateSubmit(event)" class="bg-primary py-3 text-white">បញ្ចូលទិន្នន័យ</button>
                        </div>
                    @elseif($case->solved_by_user != Auth::id())
                        <div class="row pt-3 pb-4 container">
                            <hr>
                            <h4 class="px-0 py-1 mb-3 text-center"><strong
                                    style="font-family: 'Preahvihear', sans-serif;">របាយការណ៏សេុីបអង្កេតបណ្ដោះអាសន្ន</strong>
                            </h4>
                            <div class="py-0 rounded" style="white-space:pre-wrap; background:#e9e9e9;">
                                {!! $case->solved_summary !!}
                            </div>
                        </div>
                        <div class="row pt-3 pb-4 container">
                            <hr>
                            <h4 class="px-0 py-1 mb-3 text-center"><strong
                                    style="font-family: 'Preahvihear', sans-serif;">សេចក្ដីសម្រច</strong></h4>
                            <div class="py-0 rounded" style="white-space:pre-wrap; background:#e9e9e9;">
                                {!! $case->solved_summary !!}
                            </div>
                        </div>
                        <div class="row pt-3 pb-4 container">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="formFileMultiple" class="form-label h5 mb-3"><strong
                                            style="font-family: 'Preahvihear', sans-serif;">ភស្តុតាង</strong></label>
                                    <input class="form-control" type="file" name="evidence[]" multiple id="photo"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-4"></div>
                            <div class="col-3 ">
                                <div class="mb-3">
                                    <label for="formFileMultiple" class="form-label h5 mb-3"><strong
                                            style="font-family: 'Preahvihear', sans-serif;">ដំណើរការនិតិវិធី</strong></label>
                                    <select class="form-select" aria-label="Default select example"​ name="status"
                                        disabled>
                                        <option selected>ជ្រើសរើស</option>
                                        <option value="1"{{ $case->status == 1 ? 'selected' : '' }}>
                                            បានទទួល</option>
                                        <option value="2"{{ $case->status == 2 ? 'selected' : '' }}>
                                            កំពុងដោះស្រាយ</option>
                                        <option value="3"{{ $case->status == 3 ? 'selected' : '' }}>
                                            បានដោះស្រាយរួច</option>
                                        <option value="4"{{ $case->status == 4 ? 'selected' : '' }}>
                                            បោះបង់</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row py-2">
                            <h5 class="my-auto me-2"><strong>ឯកសារ: </strong></h5>
                            @if ($files)
                                @foreach ($files as $key => $file)
                                    <div class="py-2 d-flex">
                                        <h6 class="my-auto me-2 text-danger "><strong>ឯកសារទី
                                                {{ $key + 1 }}:</strong></h6>
                                        <div class="d-flex m-0 p-0">
                                            <a href="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $file }}"
                                                class="my-auto text-decoration-none text-light me-3 btn btn-primary"><strong>ពិនិត្យ</strong></a>
                                        </div>
                                        <a href="/getfiles/{{ $case->case_number }}/{{ $file }}"
                                            class="my-auto text-decoration-none btn btn-warning btn btn-warning"><strong>ទាញយក</strong></a>
                                    </div>
                                @endforeach
                            @else
                                <h6 class="my-auto"><strong>គ្មានឯកសារទេ</strong></h6>
                            @endif
                        </div>

                        <div class="row pt-3 pb-4 container" id="imageContainer"></div>
                        <div class="row d-flex justify-content-center rounded px-5 mb-4">
                            <button type="submit" id="submit" onclick="validateSubmit(event)" class="bg-primary py-3 text-white">បញ្ចូលទិន្នន័យ</button>
                        </div>
                @endif
                {{-- end input part --}}
            </div>
        </form>
        {{-- to show the image --}}
        <script>
            $(document).ready(function() {
                $('#photo').change(function(e) {
                    var files = e.target.files;
                    var output = $('#imageContainer'); // This is where you want to append the images

                    output.empty(); // Clear out the old images

                    $.each(files, function(i, file) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var container = $('<div>').attr('style',
                                'display: inline-block; width: 50%; position: relative;margin-top:10px'
                            );
                            if (file.type === "application/pdf") {
                                var pdf = $('<embed>').attr('src', e.target.result).attr('style',
                                    'width: 100%; height: 400px;');
                                container.append(pdf);
                            } else {
                                var img = $('<img>').attr('src', e.target.result).attr('style',
                                    'width: 100%; height: auto;');
                                container.append(img);
                            }

                            output.append(container);
                        };

                        reader.readAsDataURL(file);
                    });
                });
            });
        </script>
        {{-- to show the image --}}
        <script>
            $(document).ready(function() {
                // Show the alert for 5 seconds (5000 milliseconds), then hide it
                $('.alert-success').show().delay(5000).fadeOut();
                $('.alert-danger').show().delay(5000).fadeOut();
            });
        </script>
        <script>
            var editor1 = new RichTextEditor("#editor");
            var editor2 = new RichTextEditor("#editor1");
        </script>
    @endsection
