<!-- common sections variables start -->
<?php
    // variables for section header title
    $headerTitle = "Manage Results";
    // variables for section buttons bar
    $createBtnTitle = "Add Results";
    $createBtnLink = route('add_results');
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
                    <th>Title</th>
                    <th>Showing Till Date</th>
                    <th>Uploaded file</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <!-- table header html end -->
            <tbody>
                <!-- table rows for loop start -->
                
                @foreach ($results as $result)
                    <?php
                    // Use openssl_encrypt() function to encrypt the data
                    $encId = Helper::encodeId($result['id']);
                    $upload_file = $result['upload_file'];
                    $post_id = $result['post_id'];
                    $postName = "";
                    $postsIds = [];
                    if(isset($postsArr) && !empty($postsArr)){
                        $postsIds = array_column($postsArr,'id');
                        $postKey = array_search($post_id, $postsIds);
                        $postName = $postsArr[$postKey]['code_meta_name'];
                    }
                    ?>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $result['rn_no'] }}</td>
                        <td>{{ $postName }}</td>
                        <td>{{ $result['result_title'] }}</td>
                        <td>{{ $result['showing_till_date'] }}</td>
                        <td>
                            <?php
                            $destinationParentFolderPath = config('app.result_doc_path');
                            $file_url = $destinationParentFolderPath."/".$upload_file;
                            if(!empty($upload_file)){
                                $file_url = url($file_url);
                            ?>
                            <a class="btn btn-primary" target="_blank" href="{{ $file_url }}">
                                <i class="fa fa-file-pdf"></i>
                            </a>
                            <?php } ?>
                        </td>
                        <td>
                            <!-- action html start -->
                            <form action="{{ route('delete_results',$encId) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('edit_results',$encId) }}"><i class="fa fa-pencil"></i></a>
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