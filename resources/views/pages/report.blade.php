@php
    $d = Auth::user()->department;
    $department = Illuminate\Support\Facades\DB::table('tbl_department')
        ->where('id', $d)
        ->first();
@endphp
@extends('layouts.download')
@section('content')
    <div class="container-fluid rounded bg-light mt-5 hi" style="width: 100vw;">
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
                <form action="/dashboardCase" class="py-2 px-5" id="locationForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <h4 class="py-4 "><strong style="font-family: 'Moul';">របាយការណ៍</strong></h4>
                    <div class="py-2 d-flex">
                        <p class="my-auto me-2"><strong>កាលបរិច្ឆេទ:</strong></p>
                        <p class="px-0 my-auto text-danger"><strong>{{ $current_date }}</strong></p>

                    </div>
                    <div class="py-2 d-flex">
                        <p class="my-auto me-2"><strong>អង្គភាព:</strong></p>
                        <p class="px-0 my-auto text-danger"><strong>{{ $department->department_name }}</strong></p>
                    </div>

                    <div class="row py-2">
                        <div class="col-12">
                            <div class="pb-4 pt-2 d-flex">
                                <table class="table p-3 text-break">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="text-start">ចំណាត់ការ</th>
                                            <th >បានទទួល</th>
                                            <th >កំពុងដោះស្រាយ</th>
                                            <th >ដោះស្រាយរួចរាល់</th>
                                            <th >បោះបង់</th>
                                            <th >ទាំងអស់</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <tr>
                                            <td class="align-middle">
                                                <h6 class="my-0 fw-bold text-primary text-start">{{ $department->department_name }}
                                                </h6>
                                            </td>
                                            <td class="align-middle">
                                                <h6 class="my-0 fw-bold text-center">{{ $received }}
                                                </h6>
                                            </td>
                                            <td class="align-middle">
                                                <h6 class="my-auto py-1 text-center">{{ $in_progress }}</h6>
                                            </td>
                                            <td class="align-middle">
                                                <h6 class="my-auto py-1 text-center">{{ $solved }}</h6>
                                            </td>
                                            <td class="align-middle">
                                                <h6 class="my-auto py-1 text-center">{{ $dismiss }}</h6>
                                            </td>
                                            <td class="align-middle">
                                                <h6 class="my-0 text-center">{{ $all }}</h6>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    @endsection
