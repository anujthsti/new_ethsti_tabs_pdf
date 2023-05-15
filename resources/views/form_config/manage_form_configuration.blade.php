<!-- common sections variables start -->
<?php
    // variables for section header title
    $headerTitle = "Manage Form Configuration";
    // variables for section buttons bar
    $createBtnTitle = "Create Form Configuration";
    $createBtnLink = route('add_form_configuration');
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
                @foreach ($formConfigurations as $configuration)
                    <?php
                    // encode id
                    $encId = Helper::encodeId($configuration->id);
                    ?>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $configuration->code_meta_name }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('edit_form_configuration',$encId) }}"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-danger" href="{{ route('delete_form_configuration',$encId) }}"><i class="fa fa-trash"></i></a>
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