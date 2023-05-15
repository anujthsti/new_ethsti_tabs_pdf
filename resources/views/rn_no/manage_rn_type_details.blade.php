<!-- common sections variables start -->
<?php
    // variables for section header title
    $headerTitle = "Manage RN Type Details";
    // variables for section buttons bar
    $createBtnTitle = "Create RN Type Details";
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
                    <th>RN Type</th>
                    <th>Prefix</th>
                    <th>Sequence No.</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <!-- table header html end -->
            <tbody>
                <!-- table rows for loop start -->
                @foreach ($rnTypeDetails as $type)
                    <?php
                    $encId = Helper::encodeId($type->id);
                    ?>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $type->code_meta_name }}</td>
                        <td>{{ $type->prefix }}</td>
                        <td>{{ $type->sequence_start_from }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('edit_rn_type_details',$encId) }}"><i class="fa fa-pencil"></i></a>
                        </td>
                    </tr>
                @endforeach
                <!-- table rows for loop end -->
                
            </tbody>
        </table>
        <!-- table html end -->
        
    </div>

</x-app-layout>    