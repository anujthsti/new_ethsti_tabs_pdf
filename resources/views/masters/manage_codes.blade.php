<!-- common sections variables start -->
<?php
    // variables for section header title
    $headerTitle = "Manage Codes";
    // variables for section buttons bar
    $createBtnTitle = "Create Codes";
    $createBtnLink = route('add_code');
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
                    <th>Code Name</th>
                    <th>Code</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <!-- table header html end -->
            <tbody>
                <!-- table rows for loop start --> 
                @foreach ($codes as $code)
                    <?php
                    // Use openssl_encrypt() function to encrypt the data
                    $encId = Helper::encodeId($code->id);
                    ?>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $code->code_name }}</td>
                        <td>{{ $code->code }}</td>
                        <td>
                            <!-- action html start -->
                            <form action="{{ route('delete_code',$encId) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('edit_code',$encId) }}"><i class="fa fa-pencil"></i></a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger text-right"><i class="fa fa-trash"></i></button>
                            </form>
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