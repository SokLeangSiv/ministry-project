@extends('layouts.new')
@section('head')
<script>
    error = false

    function validateData() {

        const password = document.getElementById('password').value;
        console.log(password);
        const regex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;
        if (!regex.test(password)) {
            document.getElementById('error_password').innerHTML = "សូមបំពេញយ៉ាងតិចមាន៨អក្សរ, អក្សរធំមួយ, និងលេខមួយ";
            error = true;
        } else {
            document.getElementById('error_password').innerHTML = "";
        }

        if (error) {
            error = false
            event.preventDefault();
        }
    }
</script>
@endsection


@section('content')
    <div class="container p-5 my-5 w-50 bg-white d-flex flex-column" style="min-height:300px; border-radius:1rem; box-shadow:rgb(145, 145, 145) 0 0 1.2rem;">
        <form method="POST" action="/updateCredentials" enctype="multipart/form-data" class="d-flex flex-column justify-content-center my-auto">
            @csrf
            @if (session('message'))
                <div class="container alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if ($errors->has('fullname') || $errors->has('password'))
                <h6 class="text-danger text-start py-1">មានកំហុស</h6>
            @endif
            <div class="d-flex py-1 justify-content-start">
                <h6 class="w-75">ឈ្មោះគណនី:</h6>
                <h6 class="w-100">{{Auth::user()->username}}</h6>
            </div>
            <div class="d-flex py-1">
                <label for="fullname" class="my-auto pe-2 w-75 text-start form-check-label">ឈ្មោះ:</label>
                <h6 class="w-100">{{Auth::user()->fullname}}</h6>
            </div>
              {{-- Validate JS Password Start --}}

              <h6 class="my-auto text-danger ps-0 py-2 text-start">
                <strong id="error_password"></strong>
            </h6>

            {{-- Validate JS Password End --}}

            <div class="d-flex py-1">
                <label for="password" class="my-auto pe-2 w-75 text-start form-check-label">ពាក្យសម្ងាត់ថ្មី:</label>
                <input id="password" class="form-control" type="password" name="password"/>
            </div>
            <button type="submit" onclick="validateData()" class="rounded mt-3 mx-auto py-2 px-3 bg-primary border-0 text-white"
                style="font-family: 'Siemreap', sans-serif;">ផ្លាស់ប្ដូរ</button>
        </form>

    </div>
@endsection
