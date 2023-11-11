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

    <script src="/script/view.js"></script>
    <script>
        let error = false;

        function validateSubmit(event) {
            if (error) {
                error = false;
                event.preventDefault();
            } else {
                document.getElementById('waiting').style.display = "grid";
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
            color:white;
        }

        .pop-up {
            margin: auto;
            width: 30vw;
            height: 20vh;

            border-radius: 3rem;
            padding: 1rem;
            display: grid;
            place-items: center;
        }

        .pop-up h1 {
            text-align: center;
            font-family: 'Moul', cursive;
            animation: wave 2s infinite;
        }

        @keyframes wave {

            0%,
            100% {
                transform: scale(1, 1);
            }

            25% {
                transform: scale(0.9, 1.1);
            }

            75% {
                transform: scale(1.1, 0.9);
            }
        }
    </style>
@endsection
@section('content')
    <div class="loading" id="waiting">
        <div class="pop-up" style="background-color: darkgreen">
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



                <div class="row py-2">
                    <h5 class="my-auto me-2"><strong>ឯកសារ: </strong></h5>
                    @if (count($officer_files) > 0)
                        @foreach ($officer_files as $key => $file)
                            <div class="file-container">
                                <div class="loading" id="file{{ $key }}">
                                    <div class="pop-up" >
                                        @if (in_array($file->type, ['pdf']))
                                            <embed
                                                src="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $file->filename . '.' . $file->type }}"
                                                type="application/pdf" height="600" width="1200">
                                        @elseif(in_array($file->type, ['png', 'jpeg', 'jpg', 'gif']))
                                            <img src="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $file->filename . '.' . $file->type }}"
                                                height="600" alt="Example Image" />
                                        @elseif(in_array($file->type, ['mp3', 'ogg', 'wav', 'aac']))
                                            <audio controls>
                                                <source
                                                    src="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $file->filename . '.' . $file->type }}"
                                                    type="audio/{{ $file->type }}">
                                                ឯកសារប្រភេទនេះមិនអាចមើលបានទេ
                                            </audio>
                                        @else
                                            <h6 class="px-3 py-2 text-white font-weight-bold"
                                                style="background: rgba(128, 128, 128, 0.774)">
                                                ឯកសារប្រភេទនេះមិនអាចមើលបានទេ</h6>
                                        @endif
                                    </div>
                                </div>

                                <div class="py-2 d-flex">
                                    @if ($file->type == 'pdf')
                                        <img src="/smallpdf.png" alt="smallpdf.png" height="40" class="me-2">
                                    @elseif (in_array($file->type, ['png', 'jpeg', 'jpg', 'gif']))
                                        <img src="/smallImg.png" alt="smallImg.png" height="40" class="me-2">
                                    @elseif (in_array($file->type, ['mp3', 'ogg', 'wav', 'aac']))
                                        <img src="/smallAudio.png" alt="smallAudio.png" height="40" class="me-2">
                                    @else
                                        <img src="/anyType.png" alt="anyType.png" height="40" class="me-2">
                                    @endif

                                    <h6 class="my-auto me-2 text-danger d-flex">
                                        <strong>{{ $file->filename . '.' . $file->type }}</strong>
                                    </h6>

                                    <h6 class="my-auto me-2 text-primary">({{ $file->size }}kb)</h6>

                                    <img src="/viewFile.png" alt="viewFile.png" height="40" class="me-3"
                                        onclick="displayFiles({{ $key }})" style="cursor: pointer;">

                                    <a href="/getfiles/{{ $case->case_number }}/{{ $file->filename . '.' . $file->type }}"
                                        class="my-auto text-decoration-none">
                                        <img src="/download.png" alt="/download.png" height="40">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h6 class="my-auto text-danger"><strong>គ្មានឯកសារទេ</strong></h6>
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
                                <input class="form-control" type="file" name="evidence[]" multiple id="files"
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

                    <div class="py-2 container" id="imageContainer"></div>
                    <div class="py-2 container" id="pdfContainer"></div>
                    <div class="py-2 container" id="audioContainer"></div>

            </div>
            <div class="row d-flex justify-content-center rounded px-5 mb-4">
                <button type="submit" id="submit" onclick="validateSubmit(event)"
                    class="bg-primary py-3 text-white">បញ្ចូលទិន្នន័យ</button>
            </div>
        @elseif ($case->status == 1 || $case->status == 2)
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
                        <input class="form-control" type="file" name="evidence[]" multiple id="files" accept="audio/*, image/*, application/pdf">
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
                    <h5 class="my-auto me-2"><strong>ឯកសារ: </strong></h5>
                    @if (count($department_file) > 0)
                        @foreach ($department_file as $key => $file)
                            <div class="file-container">
                                <div class="loading" id="file{{ $key }}">
                                    <div class="pop-up" >
                                        @if (in_array($file->type, ['pdf']))
                                            <embed
                                                src="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $file->filename . '.' . $file->type }}"
                                                type="application/pdf" height="600" width="1200">
                                        @elseif(in_array($file->type, ['png', 'jpeg', 'jpg', 'gif']))
                                            <img src="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $file->filename . '.' . $file->type }}"
                                                height="600" alt="Example Image" />
                                        @elseif(in_array($file->type, ['mp3', 'ogg', 'wav', 'aac']))
                                            <audio controls>
                                                <source
                                                    src="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $file->filename . '.' . $file->type }}"
                                                    type="audio/{{ $file->type }}">
                                                ឯកសារប្រភេទនេះមិនអាចមើលបានទេ
                                            </audio>
                                        @else
                                            <h6 class="px-3 py-2 text-white font-weight-bold"
                                                style="background: rgba(128, 128, 128, 0.774)">
                                                ឯកសារប្រភេទនេះមិនអាចមើលបានទេ</h6>
                                        @endif
                                    </div>
                                </div>

                                <div class="py-2 d-flex">
                                    @if ($file->type == 'pdf')
                                        <img src="/smallpdf.png" alt="smallpdf.png" height="40" class="me-2">
                                    @elseif (in_array($file->type, ['png', 'jpeg', 'jpg', 'gif']))
                                        <img src="/smallImg.png" alt="smallImg.png" height="40" class="me-2">
                                    @elseif (in_array($file->type, ['mp3', 'ogg', 'wav', 'aac']))
                                        <img src="/smallAudio.png" alt="smallAudio.png" height="40" class="me-2">
                                    @else
                                        <img src="/anyType.png" alt="anyType.png" height="40" class="me-2">
                                    @endif

                                    <h6 class="my-auto me-2 text-danger d-flex">
                                        <strong>{{ $file->filename . '.' . $file->type }}</strong>
                                    </h6>

                                    <h6 class="my-auto me-2 text-primary">({{ $file->size }}kb)</h6>

                                    <img src="/viewFile.png" alt="viewFile.png" height="40" class="me-3"
                                        onclick="displayEvidence({{ $key }})" style="cursor: pointer;">

                                    <a href="/getfiles/{{ $case->case_number }}/{{ $file->filename . '.' . $file->type }}"
                                        class="my-auto text-decoration-none">
                                        <img src="/download.png" alt="/download.png" height="40">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h6 class="my-auto text-danger"><strong>គ្មានឯកសារទេ</strong></h6>
                    @endif
                </div>


                <div class="py-2 container" id="imageContainer"></div>
                <div class="py-2 container" id="pdfContainer"></div>
                <div class="py-2 container" id="audioContainer"></div>

            </div>

            <div class="row d-flex justify-content-center rounded px-5 mb-4">
                <button type="submit" id="submit" onclick="validateSubmit(event)"
                    class="bg-primary py-3 text-white">បញ្ចូលទិន្នន័យ</button>
            </div>

            @endif
            {{-- end input part --}}
    </div>
    </form>
    {{-- to show the image --}}
    <script>
        document.getElementById('files').addEventListener('change', handleFileSelect);

        function handleFileSelect(event) {
            const files = event.target.files;

            for (const file of files) {
                const fileType = file.type;

                if (fileType.startsWith('image/')) {
                    const imgContainer = displayImage(file);
                    addRemoveButton(imgContainer);
                } else if (fileType.startsWith('audio/')) {
                    const audioContainer = displayAudio(file);
                    addRemoveButton(audioContainer);
                } else if (fileType.startsWith('application/pdf')) {
                    const pdfContainer = displayPdf(file);
                    addRemoveButton(pdfContainer);
                }
                // Add more conditions for other file types if needed
            }
        }

        function displayImage(file) {
            const imageContainer = document.getElementById('imageContainer');
            const imgContainer = createFileContainer();

            const imgElement = document.createElement('img');
            imgElement.src = URL.createObjectURL(file);
            imgElement.className = 'img-thumbnail m-2';
            imgElement.style.width = '250px'; // Set the desired width
            imgContainer.appendChild(imgElement);

            imageContainer.appendChild(imgContainer);

            return imgContainer;
        }

        function displayAudio(file) {
            const audioContainer = document.getElementById('audioContainer');
            const audioContainerElement = createFileContainer();

            const audioElement = document.createElement('audio');
            audioElement.src = URL.createObjectURL(file);
            audioElement.controls = true;
            audioContainerElement.appendChild(audioElement);

            audioContainer.appendChild(audioContainerElement);

            return audioContainerElement;
        }

        function displayPdf(file) {
            const pdfContainer = document.getElementById('pdfContainer');
            const pdfContainerElement = createFileContainer();

            const pdfEmbed = document.createElement('embed');
            pdfEmbed.src = URL.createObjectURL(file);
            pdfEmbed.type = 'application/pdf';
            pdfEmbed.width = '500';
            pdfEmbed.height = '300';
            pdfContainerElement.appendChild(pdfEmbed);

            pdfContainer.appendChild(pdfContainerElement);

            return pdfContainerElement;
        }

        function createFileContainer() {
            const fileContainer = document.createElement('div');
            fileContainer.style.position = 'relative';
            fileContainer.style.display = 'inline-block';
            fileContainer.style.marginRight = '10px'; // Adjust spacing between files

            return fileContainer;
        }

        function addRemoveButton(container) {
            const removeButton = document.createElement('button');
            removeButton.innerHTML = '&times;'; // Use '×' for the multiplication symbol (X)
            removeButton.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
            removeButton.style.marginTop = '-10px'; // Adjust the vertical position
            removeButton.style.marginRight = '-10px'; // Adjust the horizontal position
            removeButton.addEventListener('click', () => {
                container.remove();
            });

            container.appendChild(removeButton);
        }
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
