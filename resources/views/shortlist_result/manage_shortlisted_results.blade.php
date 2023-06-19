<!-- common sections variables start -->
<?php
    // variables for section header title
    $headerTitle = "Manage Shortlisted Results";
    // variables for section buttons bar
    $createBtnTitle = "Add Shortlisted Results";
    $createBtnLink = route('add_shortlisted_results');
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
                    <th>Post</th>
                    <th>Shortlist Title</th>
                    <th>Date of Interview</th>
                    <th>Uploaded file</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <!-- table header html end -->
            <tbody>
                <!-- table rows for loop start -->
                <?php /* ?>
                @foreach ($code_names as $code_name)
                    <?php
                    // Use openssl_encrypt() function to encrypt the data
                    $encId = Helper::encodeId($code_name->id);
                    ?>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $code_name->code_name }}</td>
                        <td>{{ $code_name->code_meta_name }}</td>
                        <td>{{ $code_name->code }}</td>
                        <td>
                            <!-- action html start -->
                            <form action="{{ route('destroy_code_name',$encId) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('edit_code_name',$encId) }}"><i class="fa fa-pencil"></i></a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger text-right"><i class="fa fa-trash"></i></button>
                            </form>
                            <!-- action html end -->
                        </td>
                    </tr>
                @endforeach
                <!-- table rows for loop end -->
                <?php */ ?>
            </tbody>
        </table>
        <!-- table html end -->
        <?php /* ?>
        {!! $rn_nos->links() !!}
        <?php */ ?>
    </div>

    <script>
        $(document).ready(function(){
            $("#masterTables").change(function(){
                let id = $(this).val();
                let redirectUrl = '<?php echo route('manage_code_names'); ?>';
                redirectUrl = redirectUrl+'/'+id;
                window.location.href = redirectUrl;
            });
        });
    </script>

</x-app-layout>    