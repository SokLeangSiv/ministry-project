@php
    $d = Auth::user()->department;
    $department = Illuminate\Support\Facades\DB::table('tbl_department')
        ->where('id', $d)
        ->first();
@endphp
@extends('layouts.download')
@section('content')
    <div class="container-fluid rounded bg-light mt-5">
        <div class="row">
            {{-- logo --}}
            <div class="col-12">
                <div class="d-flex justify-content-center mt-3">
                    <img src="{{ asset('logo.png') }}" alt="" width="100px" height="100px">
                </div>
                <p style="line-height: 1.8; font-family: 'Moul', cursive;font-size:14px; text-align:center;"
                    class=" fw-bold mt-2">
                    គណៈកម្មការ​ចំពោះ​កិច្ច​ត្រួត​ពិនិត្យ និង​ដោះស្រាយបញ្ហា​ដំណើរ​ចេញ​​ចូល <br>
                    ​របស់​ពលករ​ខ្មែរ​តាម​ព្រំ​ដែន​នៃ​ព្រះរាជាណាចក្រកម្ពុជា​
                </p>
                <form action="/caseFiltered" class="py-2 px-5" id="locationForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <h4 class="py-4"><strong style="font-family: 'Moul';">របាយការណ៍</strong></h4>
                    <div class="py-2 d-flex">
                        <p class="my-auto me-2"><strong>កាលបរិច្ឆេទ:</strong></p>
                        <p class="px-0 my-auto text-danger"><strong>{{ $current_date }}</strong></p>

                    </div>
                    <div class="py-2 d-flex">
                        <p class="my-auto me-2"><strong>អង្គភាព:</strong></p>
                        <p class="px-0 my-auto text-danger"><strong>{{ $department->department_name }}</strong></p>

                    </div>
                    <div class="py-2 d-flex">
                        <p class="my-auto me-2"><strong>ស្ថានភាព:</strong></p>

                        @switch($status)
                            @case(1)
                                <div class="d-flex">
                                    <img src="/recieved.png" alt="" height="35" class="my-auto mx-1">
                                    <h6 class="my-auto"><strong class="text-primary">បានទទួល</strong></h6>
                                </div>
                            @break

                            @case(2)
                                <div class="d-flex">
                                    <img src="/loading.png" alt="" height="34" class="my-auto mx-1">
                                    <h6 class="my-auto"><strong class="text-warning">កំពុងដោះស្រាយ</strong></h6>
                                </div>
                            @break

                            @case(3)
                                <div class="d-flex">
                                    <img src="/completed.png" alt="" height="35" class="my-auto mx-1">
                                    <h6 class="my-auto"><strong class="text-success">ដោះស្រាយរួចរាល់</strong></h6>
                                </div>
                            @break

                            @case(4)
                                <div class="d-flex">
                                    <img src="/dismiss.png" alt="" height="33" class="my-auto mx-1">
                                    <h6 class="my-auto"><strong class="text-danger">បោះបង់</strong></h6>
                                </div>
                            @break

                            @default
                                <div class="d-flex">
                                    <h6 class="my-auto"><strong class="text-secondary">ទាំងអស់</strong></h6>
                                </div>
                        @endswitch

                    </div>
                    <hr>
                    <div class="row py-2">
                        <div class="col-12">
                            <div class="pb-4 pt-2 d-flex">
                                <table class="table p-3">
                                    <thead>
                                        <tr>
                                            <th>កាលបរិច្ឆេទ</th>
                                            <th>លេខបណ្តឹង</th>
                                            <th>ម្ចាស់បណ្តឹង</th>
                                            <th>ប្រភេទ</th>
                                            <th>មន្រ្តីទទួលបណ្តឹង</th>
                                            <th>មន្ត្រីទទួលដោះស្រាយ</th>
                                            <th>ស្ថានភាព</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getRecord as $value)
                                            <tr>
                                                <td class="align-middle">
                                                    <h6 class="my-0">{{ $value->sent_date }}</h6>
                                                </td>
                                                <td class="align-middle">
                                                    <h6 class="my-0 fw-bold text-primary">{{ $value->case_number }}</h6>

                                                </td>

                                                <td class="align-middle">
                                                    <h6 class="my-auto py-1">{{ $value->complainer_name }}</h6>
                                                    <h6 class="my-auto py-1">{{ $value->complainer_tele }}</h6>
                                                </td>
                                                <td class="align-middle">
                                                    @if ($value->is_new == 1)
                                                        <h6 class="my-0">ថ្មី</h6>
                                                    @else
                                                        <h6 class="my-0">ចាស់</h6>
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

                                                                    <h6 class="my-auto">បានទទួល</h6>
                                                                </div>
                                                            @break

                                                            @case(2)
                                                                <div class="d-flex">

                                                                    <h6 class="my-auto">កំពុងដោះស្រាយ</h6>
                                                                </div>
                                                            @break

                                                            @case(3)
                                                                <div class="d-flex">

                                                                    <h6 class="my-auto">ដោះស្រាយរួចរាល់</h6>
                                                                </div>
                                                            @break

                                                            @default
                                                                <div class="d-flex">

                                                                    <h6 class="my-auto">បោះបង់</h6>
                                                                </div>
                                                        @endswitch

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
