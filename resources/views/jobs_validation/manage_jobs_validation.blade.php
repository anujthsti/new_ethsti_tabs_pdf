<!-- common sections variables start -->
<?php
    // variables for section header title
    $headerTitle = "Manage Jobs Validations";
    // variables for section buttons bar
    $createBtnTitle = "Create Job Validation";
    $createBtnLink = route('add_job_validation');
?>
<!-- common sections variables end -->

<x-app-layout>
    <!-- section header title html -->
    @include('layouts/header_title')
    
    <div class="container mt-2">
        <!-- section buttons bar html -->
        @include('layouts/buttons_bar')
        <!-- success message alert html start -->
        @if ($message = Session::get('success'))
            <!-- include success message common view -->
            @include('layouts/success_message')
        @endif
        <!-- success message alert html end -->
        <!-- table html start -->
        
        <table class="table table-bordered dataTable">
            <!-- table header html start -->
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>Post Name</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <!-- table header html end -->
            <tbody>
                <!-- table rows for loop start -->
                @foreach ($validations as $validation)
                    <?php
                    // Use openssl_encrypt() function to encrypt the data
                    $encId = Helper::encodeId($validation->id);
                    ?>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $validation->code_meta_name }}</td>
                        <td>
                            <!-- action html start -->
                            <a class="btn btn-primary" href="{{ route('edit_job_validation',$encId) }}"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-danger" href="{{ route('delete_job_validation',$encId) }}"><i class="fa fa-trash"></i></a>
                            <!--<button type="submit" class="btn btn-danger text-right"><i class="fa fa-trash"></i></button>-->
                            <!-- action html end -->
                        </td>
                    </tr>
                @endforeach
                <!-- table rows for loop end -->
                
            </tbody>
        </table>
        <!-- table html end -->
        <?php /* ?>
        {!! $rn_nos->links() !!}
        <?php */ ?>
    </div>

    

</x-app-layout>    