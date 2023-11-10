<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>បញ្ចីបណ្ដឹង</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Pichforest" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('logo.png') }}">
    {{-- css when screen --}}
    {{-- <link rel="stylesheet" media="screen" href="/css/screen.css"> --}}

    <!-- plugin css -->
    <link href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    @yield('head')

    <!-- Khmer Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Moul&family=Siemreap&display=swap" rel="stylesheet">
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{-- java pdf --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf.js/2.5.1/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function($) {
            $('#generate-pdf').click(function() {
                var element = document.getElementById('pdf');
                var opt = {
                    margin: 0.5,
                    filename: 'បញ្ជីបណ្តឹង.pdf',
                    image: {
                        type: 'pdf',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 1
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'a4',
                        orientation: 'portrait'
                    }
                };
                html2pdf().from(element).set(opt).save();
            });
        });
    </script>
    <style type="text/css" media="screen"></style>
    <style type="text/css" media="print">
       body {
            margin: -40px;
            padding: -40px
        }
        th{
            font-size: 11px;
        }
        td h6{
            font-size: 10px;
        }
    </style>
</head>

<body data-layout="horizontal">
    <div id="pdf">
        @yield('content')
    </div>
</body>

</html>
<style>
    * {

        font-family: 'Siemreap', sans-serif;
    }
</style>
