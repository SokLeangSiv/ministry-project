@extends('layouts.new')
@section('content')
    <div class="container bg-white p-4  mt-4" style="border-radius: 10px">
        <div class="py-2 px-3 rounded mb-5 mt-3" style="background:#e9e9e9;">
            <form action="/casesFiltered" method="post" enctype="multipart/form-data">
                @csrf
                <h4 class="my-auto py-2"><strong>ស្វែងរក</strong></h4>
                <div class="d-flex justify-content-between">
                    <div class="w-100">
                        <div class="d-flex py-2 pe-3">
                            <div class="pe-3">
                                <h6 class="my-auto py-2"><strong>ថ្ងៃផ្តើម</strong></h6>
                                <input type="date" class="form-control border-secondary" name="start_date"
                                    id="start_date">
                            </div>

                            <div class="ps-3">
                                <h6 class="my-auto py-2"><strong>ថ្ងៃបញ្ចប់</strong></h6>
                                <input type="date" class="form-control border-secondary" name="end_date" id="end_date">
                            </div>
                        </div>
                    </div>

                    <div class="my-auto w-100">
                        <h6 class="my-auto py-2"><strong>ស្ថានភាព</strong></h6>
                        <div class="d-flex py-1">
                            <input type="radio" value="1" name="status"
                                class="form-check-input my-auto border-secondary">
                            <label class="px-2 my-auto me-2">
                                <h6 class="my-auto">បានបញ្ចូន</h6>
                            </label>

                            <input type="radio" value="2" name="status"
                                class="form-check-input my-auto border-secondary">
                            <label class="px-2 my-auto me-2">
                                <h6 class="my-auto">កំពុងដោះស្រាយ</h6>
                            </label>

                            <input type="radio" value="3" name="status"
                                class="form-check-input my-auto border-secondary">
                            <label class="px-2 my-auto me-2">
                                <h6 class="my-auto">ដោះស្រាយរួចរាល់</h6>
                            </label>

                            <input type="radio" value="4" name="status"
                                class="form-check-input my-auto border-secondary">
                            <label class="px-2 my-auto me-2">
                                <h6 class="my-auto">បោះបង់</h6>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex py-2">
                    <div class="pe-4">
                        <h6 class="my-auto py-2"><strong>លេខបណ្តឹង</strong></h6>
                        <input type="text" class="form-control border-secondary" name="case_number" placeholder="លេខបណ្តឹង">
                    </div>
                    <div class="pe-4">
                        <h6 class="my-auto py-2"><strong>ឈ្មោះម្ចាស់បណ្តឹង</strong></h6>
                        <input type="text" class="form-control border-secondary" name="complainer_name" placeholder="ឈ្មោះម្ចាស់បណ្តឹង">
                    </div>
                    <div class="pe-4">
                        <h6 class="my-auto py-2"><strong>លេខទូរស័ព្ទ</strong></h6>
                        <input type="text" class="form-control border-secondary" name="complainer_tele" placeholder="លេខទូរស័ព្ទ">
                    </div>
                </div>


                <div class="d-flex justify-content-between pb-2">
                    <button class="bg-primary text-white border-0 rounded p-2">ស្វែងរក</button>
                    <div class="d-flex">
                        <a target=''
                            class="bg-danger text-white border-0 rounded p-2 text-decoration-none d-flex mx-2"
                            href="{{ url('/downloadPdf?status=' . request()->input('status') . '&start_date=' . request()->input('start_date') . '&end_date=' . request()->input('end_date')) }}"><img
                                src="/pdf.png" alt="" style="height: 32px;">
                            <p class="my-auto ms-2">ទាញយកជា PDF</p>
                        </a>
                        <a target='_blank'
                            class="bg-success text-white border-0 rounded p-2 text-decoration-none d-flex mx-2"
                            href="{{ url('/caseExport?status=' . request()->input('status') . '&start_date=' . request()->input('start_date') . '&end_date=' . request()->input('end_date')) }}"><img
                                src="/excel.png" alt="" style="height: 32px;">
                            <p class="my-auto ms-2">ទាញយកជា Excel</p>
                        </a>
                    </div>
                </div>



            </form>

        </div>


        <table class="table p-3 text-break">
            <thead>
                <tr>
                    <th>កាលបរិច្ឆេទទទួលបណ្តឹង</th>
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
                                    <a href="/viewcase/{{ $value->case_number }}" class="rounded p-2 border-0 text-white me-3 text-decoration-none" style="background-color:orange">
                                        ចូលមើល
                                    </a>

                                    @if ($value->status == 3)
                                    <a href="#"
                                        class="rounded p-2 border-0 bg-secondary text-white text-decoration-none"
                                        style="cursor: default;" disabled>ចូលកែប្រែ</a>
                                @elseif ($value->status == 4)
                                    <a href="#"
                                        class="rounded p-2 border-0 bg-secondary text-white text-decoration-none"
                                        style="cursor: default;" disabled>ចូលកែប្រែ</a>
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

    <script>
        let startDateInput = document.getElementById('start_date');
        let endDateInput = document.getElementById('end_date');

        // Get today's date
        let today = new Date();

        let minDate = new Date();

        let minDateString = minDate.toISOString().split('T')[0];

        endDateInput.min = minDateString;

        startDateInput.addEventListener('change', function() {
            if (this.value) endDateInput.min = this.value;
        });
    </script>
@endsection
