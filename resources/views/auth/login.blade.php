<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Moul&family=Siemreap&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="account_login/style.css">
</head>

<body>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="container">
        <div class="form-container sign-in-container">

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <img src="logo.png" alt="" height="120" class="my-4">
                @if ($errors->has('officer_name') || $errors->has('password'))
                    <h5 class="text-danger text-start">មានកំហុស</h5>
                @endif

                <x-text-input id="login" class="block my-2 w-full p-2 rounded" type="text" name="login"
                    :value="old('officer_name')" required autofocus autocomplete="login" placeholder="លេខគណនី" />
                {{-- <x-input-error :messages="$errors->get('officer_name')" class="mt-2" /> --}}

                <x-text-input id="password" class="block my-2 w-full p-2 rounded" type="password" name="password"
                    required autocomplete="current-password" placeholder="ពាក្យសម្ងាត់" />
                {{--
                <x-input-error :messages="$errors->get('password')" class="mt-2" /> --}}
                <button type="submit" class="rounded mt-5">
                    <h6 class="my-auto" style="font-family: 'Siemreap', sans-serif;">ចូល</h6>
                </button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right py-4">

                        <h5 style="line-height: 1.8; font-family: 'Moul', cursive;" class="my-0 py-4">គណៈកម្មការ​ចំពោះ​កិច្ច​ត្រួត​ពិនិត្យ<br>និង​ដោះស្រាយ​បញ្ហា​ដំណើរ​ចេញ​​ចូល<br>​របស់​ពលករ​ខ្មែរ​តាម​ព្រំ​ដែន​នៃ​ព្រះរាជាណាចក្រកម្ពុជា​</h5>
                        <h5 style="line-height: 1.8; font-family: 'Moul', cursive; color:#0659c5;" class="my-0 py-4">មន្រ្តីដោះស្រាយពាក្យបណ្ដឹង</h5>

                </div>
            </div>
        </div>
    </div>

</body>

</html>
<!-- Session Status -->
<style>
    * {
        font-family: 'Siemreap', sans-serif;
    }
</style>
