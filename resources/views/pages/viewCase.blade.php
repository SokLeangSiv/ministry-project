@extends('layouts.new')

@php
    $d = Auth::user()->department;
    $department = Illuminate\Support\Facades\DB::table('tbl_department')
        ->where('id', $d)
        ->first();
@endphp
@section('head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#editor',
            plugins: [
                'a11ychecker', 'advlist', 'advcode', 'advtable', 'autolink', 'checklist', 'export',
                'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
                'powerpaste', 'fullscreen', 'formatpainter', 'insertdatetime', 'media', 'table', 'help',
                'wordcount'
            ],
            toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help'
        });
    </script>
@endsection


@section('content')

    <div class="container">
        <form action="/updateCase/{{ $case->case_number }}"  class="py-2 px-5"  id="locationForm" method="POST"
            enctype="multipart/form-data">
            @csrf
            {{-- @method('GET') --}}
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
            <div class="container rounded p-4 bg-light mt-5 w-75" style="">
                <h2 class="py-4 text-center"><strong style="font-family: 'Preahvihear', sans-serif;">ពាក្យបណ្តឹង</strong>
                </h2>

                <hr>

                <div class="row py-2">
                    <div class="col-5 my-auto">
                        <div>
                            <div class="py-2 d-flex">
                                <h6 class="my-auto me-2"><strong>កាលបរិច្ឆេទទទួលបណ្តឹង:</strong></h6>
                                <h6 class="px-0 my-auto text-danger"><strong>{{ $case->received_date }}</strong></h6>
                            </div>
                            <div class="py-2 d-flex">
                                <h6 class="my-auto me-2"><strong>កាលបរិច្ឆេទកំណត់ត្រាបណ្តឹង:</strong></h6>
                                <h6 class="px-0 my-auto text-danger"><strong>{{ $case->sent_date }}</strong></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col my-auto">
                        <div>
                            <div class="py-2 d-flex">
                                <h6 class="my-auto me-2"><strong>លេខបណ្តឹង:</strong></h6>
                                <h6 class="px-0 my-auto text-primary"><strong
                                        style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">{{ $case->case_number }}</strong>
                                </h6>
                            </div>
                            <div class="py-2 d-flex">
                                <h6 class="my-auto me-2"><strong>ប្រភេទបណ្តឹង:</strong></h6>
                                <h6 class="px-0 my-auto text-danger">
                                    <strong>{{ $case->is_new == 1 ? 'ថ្មី' : 'ចាស់' }}</strong>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div>
                            <div class="py-2 d-flex">
                                <h6 class="my-auto me-2"><strong>ស្ថានភាព:</strong></h6>

                                @switch($case->status)
                                    @case(1)
                                        <div class="d-flex">
                                            <img src="/recieved.png" alt="" height="35" class="my-auto mx-1">
                                            <h6 class="px-0 my-auto text-primary"><strong>បានទទួល</strong></h6>
                                        </div>
                                    @break

                                    @case(2)
                                        <div class="d-flex">
                                            <img src="/loading.png" alt="" height="34" class="my-auto mx-1">
                                            <h6 class="px-0 my-auto text-warning"><strong>កំពុងដោះស្រាយ</strong></h6>
                                        </div>
                                    @break

                                    @case(3)
                                        <div class="d-flex">
                                            <img src="/completed.png" alt="" height="35" class="my-auto mx-1">
                                            <h6 class="px-0 my-auto text-success"><strong>ដោះស្រាយរួចរាល់</strong></h6>
                                        </div>
                                    @break

                                    @default
                                        <div class="d-flex">
                                            <img src="/dismiss.png" alt="" height="33" class="my-auto mx-1">
                                            <h6 class="px-0 my-auto text-danger"><strong>បោះបង់</strong></h6>
                                        </div>
                                @endswitch
                            </div>
                        </div>
                        <div class="py-2 d-flex">
                            <h6 class="my-auto me-2"><strong>មន្រ្តីទទួលបណ្តឹង:</strong></h6>
                            <h6 class="px-0 my-auto text-danger">
                                <strong>{{ $case->officer_fullname }}</strong>
                            </h6>

                        </div>
                    </div>
                </div>

                <hr>

                <h5 class="py-2"><strong style="font-family: 'Preahvihear', sans-serif;">ព័ត៏មានម្ចាស់បណ្តឹង</strong></h5>

                <div class="row pt-2 pb-4">
                    <div class="col-4">
                        <div class="py-2 d-flex">
                            <h6 class="my-auto me-2"><strong>ឈ្មោះ:</strong></h6>
                            <h6 class="px-0 my-auto text-danger"><strong>{{ $case->complainer_name }}</strong></h6>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="py-2 d-flex">
                            <h6 class="my-auto me-2"><strong>ភេទ:</strong></h6>
                            <h6 class="px-0 my-auto text-danger">
                                <strong>{{ $case->complainer_gender == 1 ? 'ប្រុស' : 'ស្រី' }}</strong>
                            </h6>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="py-2 d-flex">
                            <h6 class="my-auto me-2"><strong>អាយុ:</strong></h6>
                            <h6 class="px-0 my-auto text-danger"><strong>{{ $case->complainer_age }}</strong></h6>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="py-2 d-flex">
                            <h6 class="my-auto me-2"><strong>លេខទូរស័ព្ទ:</strong></h6>
                            <h6 class="px-0 my-auto text-danger"><strong>{{ $case->complainer_tele }}</strong></h6>
                        </div>
                    </div>
                </div>

                <div class="row py-2">
                    <div class="col-4">
                        <div class="d-flex my-0 py-0">
                            <h6 class="my-auto me-2"><strong>ទីលំនៅ:</strong></h6>
                            <h6 class="px-0 my-auto text-danger">
                                <strong>{{ $case->complainer_address ?? 'គ្មាន​ទិន្នន័យ' }}</strong>
                            </h6>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="d-flex my-0 py-0">
                            <h6 class="my-auto me-2"><strong>ខេត្ត/ក្រុង:</strong></h6>
                            <h6 class="px-0 my-auto text-danger"><strong>{{ $province->name }}</strong></h6>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="d-flex my-0 py-0">
                            <h6 class="my-auto me-2"><strong>ខណ្ឌ/ស្រុក:</strong></h6>
                            <h6 class="px-0 my-auto text-danger">
                                <strong>{{ $district->name ?? ' គ្មាន​ទិន្នន័យ' }}</strong>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="row py-2">
                    <div class="col-4">
                        <div class="d-flex my-0 py-0">
                            <h6 class="my-auto me-2"><strong>ឃុំ/សង្គាត់:</strong></h6>
                            <h6 class="px-0 my-auto text-danger"><strong>{{ $commune->name ?? ' គ្មាន​ទិន្នន័យ' }}</strong>
                            </h6>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex my-0 py-0">
                            <h6 class="my-auto me-2"><strong>ភូមិ:</strong></h6>
                            <h6 class="px-0 my-auto text-danger"><strong>{{ $village->name ?? ' គ្មាន​ទិន្នន័យ' }}</strong>
                            </h6>
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="py-2"><strong style="font-family: 'Preahvihear', sans-serif;">ចំណាត់ការ</strong></h5>
                <div class="row py-2">

                    <div class="my-auto d-flex col-4">


                        <h6 class="px-0 my-auto text-danger">
                            <strong> <span class="text-dark">អង្គភាព : </span><br>
                                {{ $department->department_name }}</strong>
                        </h6>
                    </div>
                    <div class="my-auto d-flex col-4">
                        <h6 class="my-auto me-2"><strong>មន្ត្រីទទួលដោះស្រាយ:</strong></h6>
                        <br>
                        <h6 class="px-0 my-auto text-danger">
                            <strong>
                                @if ($case->department_fullname != null)
                                    {{ $case->department_fullname }}
                                @else
                                    <h6><strong>គ្មាន</strong></h6>
                                @endif
                            </strong>
                        </h6>
                    </div>
                </div>

                @if ($case->solved_by_user == Auth::id())
                    <hr>
                    <h5 class="my-auto me-2"><strong
                            style="font-family: 'Preahvihear', sans-serif;">ខ្លឹមសារបណ្តឹង</strong></h5>
                    <div class="row py-2">

                        <p class="my-auto py-2">{!! $case->case_story !!}</p>
                    </div>

                    <hr>

                    <div class="py-2 d-flex">
                        <h6 class="my-auto me-2"><strong>សារសម្លេងសន្ទនា: </strong></h6>
                        @if ($case->voice_recorded != null)
                        @foreach ($audio_files as $voice)
                            <audio controls>
                                <source
                                    src="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $case->voice_recorded }}"
                                    type="audio/ogg">
                                <source
                                    src="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $case->voice_recorded }}"
                                    type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            <a href="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $voice }}"
                                class="my-auto text-decoration-none btn btn-warning"><strong>ទាញយក</strong></a>
                            @endforeach
                        @else
                            <h6 class="px-0 my-auto text-danger"><strong>មិនមានសារសម្លេងទេ</strong></h6>
                        @endif
                    </div>
                    <div class="row py-2">
                        <h6 class="my-auto me-2"><strong>ឯកសារ: </strong></h6>
                        @if ($files != null)
                            @foreach ($files as $key => $file)
                                <div class="py-2 d-flex">
                                    <h6 class="my-auto me-2 text-danger "><strong>ឯកសារទី {{ $key + 1 }}: </strong>
                                    </h6>
                                    <div class="d-flex m-0 p-0">
                                        <a href="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $file }}"
                                            class="my-auto text-decoration-none text-light me-3 btn btn-primary"><strong>ពិនិត្យ</strong></a>
                                    </div>
                                    <a href="/getfiles/{{ $case->case_number }}/{{ $audio_files }}"
                                        class="my-auto text-decoration-none me-3 btn btn-warning"><strong>ទាញយក</strong>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <h6 class="my-auto"><strong>គ្មានឯកសារទេ</strong></h6>
                        @endif
                    </div>
                @else
                    <hr>
                    <div class="row py-2">
                        <h5 class="my-auto me-2"><strong
                                style="font-family: 'Preahvihear', sans-serif;">ខ្លឹមសារបណ្តឹង</strong>
                        </h5>
                        <p class="my-auto py-2">{!! $case->case_story !!}</p>
                    </div>

                    {{-- <div class="py-2 d-flex">
                        <h6 class="my-auto me-2"><strong>សារសម្លេងសន្ទនា: </strong></h6>
                        @if ($case->voice_recorded != null)
                        @foreach ($audio_files as $voice)
                            <audio controls>
                                <source
                                    src="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $case->voice_recorded }}"
                                    type="audio/ogg">
                                <source
                                    src="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $case->voice_recorded }}"
                                    type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            <a href="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $voice }}"
                                class="my-auto text-decoration-none btn btn-warning"><strong>ទាញយក</strong></a>
                            @endforeach
                        @else
                            <h6 class="px-0 my-auto text-danger"><strong>មិនមានសារសម្លេងទេ</strong></h6>
                        @endif
                    </div> --}}
                    
                    <div class="row py-2">
                        <h6 class="my-auto me-2"><strong>ឯកសារ: </strong></h6>
                        @if ($files != null)
                            @foreach ($files as $key => $file)
                                <div class="py-2 d-flex">
                                    <h6 class="my-auto me-2 text-danger "><strong>ឯកសារទី {{ $key + 1 }}: </strong>
                                    </h6>
                                    <div class="d-flex m-0 p-0">
                                        <a href="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $file }}"
                                            class="my-auto text-decoration-none text-light me-3 btn btn-primary"><strong>ពិនិត្យ</strong></a>
                                    </div>
                                    <a href="/getfiles/{{ $case->case_number }}/{{ $voice }}"
                                        class="my-auto text-decoration-none me-3 btn btn-warning"><strong>ទាញយក</strong></a>
                                </div>
                            @endforeach
                        @else
                            <h6 class="my-auto"><strong>គ្មានឯកសារទេ</strong></h6>
                        @endif
                    </div>

                @endif
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
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="formFileMultiple" class="form-label h6 mb-3 fw-bold">ភស្តុតាង</label>
                            <div class="row py-2">
                                <h6 class="my-auto me-2"><strong>ឯកសារ: </strong></h6>
                                @if (!empty($reference_files) && !empty(array_filter($reference_files)))
                                    @foreach ($reference_files as $key => $reference_file)
                                        <div class="py-2 d-flex">
                                            <h6 class="my-auto me-2 text-danger "><strong>ឯកសារទី
                                                    {{ $key + 1 }}:</strong></h6>
                                            <div class="d-flex m-0 p-0">
                                                <a href="https://mediacomplaint.sgp1.cdn.digitaloceanspaces.com/files_complaint/{{ $case->case_number }}/{{ $reference_file }}"
                                                    class="my-auto text-decoration-none text-light me-3 btn btn-primary "><strong>ពិនិត្យ</strong></a>
                                            </div>
                                            <a href="/getfiles/{{ $case->case_number }}/{{ $reference_file }}"
                                                class="my-auto text-decoration-none me-3 btn btn-warning"><strong>ទាញយក</strong></a>
                                            <a href="/deleteFile/{{ $case->case_number }}/{{ $reference_file }}"
                                                class="my-auto text-decoration-none me-3 btn btn-danger"><strong>លុបចោល</strong></a>

                                        </div>
                                    @endforeach
                                @else
                                    <h6 class="my-auto"><strong>គ្មានឯកសារទេ</strong></h6>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection
