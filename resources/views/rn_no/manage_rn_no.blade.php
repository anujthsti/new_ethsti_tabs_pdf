<!-- common sections variables start -->
<?php
    // variables for section header title
    $headerTitle = "Manage RN No.";
    // variables for section buttons bar
    $createBtnTitle = "Create RN No.";
    $createBtnLink = route('add_rnno');
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
                    <th>RN No.</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <!-- table header html end -->
            <tbody>
                <!-- table rows for loop start -->
                @foreach ($rn_nos as $rn_no)
                    <?php
                    // Use openssl_encrypt() function to encrypt the data
                    $encId = Helper::encodeId($rn_no->id);
                    ?>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $rn_no->rn_no }}</td>
                        <td>
                            <!--<a class="btn btn-primary" href="{{ route('edit_rnno',$encId) }}"><i class="fa fa-pencil"></i></a>-->
                            <a class="btn btn-danger" href="{{ route('delete_rnno',$encId) }}"><i class="fa fa-trash"></i></a>
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