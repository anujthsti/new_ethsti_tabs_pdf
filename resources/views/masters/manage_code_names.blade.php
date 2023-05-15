<!-- common sections variables start -->
<?php
    // variables for section header title
    $headerTitle = "Manage Code Names";
    // variables for section buttons bar
    $createBtnTitle = "Create Code Names";
    $createBtnLink = route('add_code_name');
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
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-12 col-sm-12">
                <label>Masters Filter: </label>
                <select name="masters" class="select2" id="masterTables">
                    
                    <!--<option value="Select Master">Select Master</option>-->
                    @foreach($codesMasters as $master)
                        <?php
                            $codeEncId = Helper::encodeId($master->id);
                            $selected = "";
                            if(!empty($masterEncId) && $masterEncId == $codeEncId){
                                $selected = "selected";
                            }
                        ?>
                        <option value="{{ $codeEncId }}" <?php echo $selected; ?>>{{ $master->code_name }}</option>
                    @endforeach
                </select>
                <a class="btn btn-warning" href="<?php echo route('manage_code_names'); ?>">Clear Filter</a>
            </div>
        </div>
        <table class="table table-bordered dataTable">  
            <!-- table header html start -->
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>Code Name</th>
                    <th>Meta Name</th>
                    <th>Code</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <!-- table header html end -->
            <tbody>
                <!-- table rows for loop start -->
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