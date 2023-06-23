<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', "eTHSTI") }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <!-- bootstrap css -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
        <!-- Fontawesome cdn -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        
        <!--@vite(['resources/css/app.css', 'resources/js/app.js'])-->
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <!-- DataTable Script -->
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
        <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

        <!-- bootstrap scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        
        <!-- for date-picker -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

        <!--These jQuery libraries for select2 need to be included-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" />

        <style>
            .max-w-7xl {
                max-width: 100rem !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
        <script>
        $(document).ready(function() {
          
           

            $(function() {
                $(".date_picker").datepicker({
                    dateFormat: 'dd/mm/yy',//check change
                    changeMonth: true,
                    changeYear: true
                });

                $('.dataTable').DataTable();

                $('.select2').select2({
                    placeholder: 'Select an option'
                });
            });

            
        })
        </script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function getJobsDropdown(rnnoId, selectedJobId=""){
                $.ajax({
                    type:'POST',
                    url:"{{ route('ajaxGetJobsDropdownhtml') }}",
                    data:{rnnoId:rnnoId, selectedJobId:selectedJobId},
                    success:function(data){
                        //alert(data.success);
                        let retHtml = data['html'];
                        $('#job_id').html(retHtml);
                    }
                });
            }

            $(document.body).on("change","#rn_no",function(){
                let rn_no_id = this.value;
                getJobsDropdown(rn_no_id);
            });


            
        </script>
    </body>
</html>
