<?php
$title = "Add Result";
$form_action = route('save_results');
$rn_no_id = old('rn_no_id');
$job_id = old('job_id');
$result_title = old('result_title');
$showing_till_date = old('showing_till_date');
$alternate_text = old('alternate_text');
$upload_file = old('upload_file');
$announcement = old('announcement');
$email = config('app.to_emails_on_results');
if(isset($shortlistedResults) && !empty($shortlistedResults)){
    $title = "Edit Shortlisted Result";
    $resultArr = $shortlistedResults[0];
    $encId = Helper::encodeId($resultArr['id']);
    $form_action = route('save_shortlisted_results',$encId);

    $rn_no_id = $resultArr['rn_no_id'];
    $job_id = $resultArr['job_id'];
    $result_title = $resultArr['result_title'];
    $showing_till_date = $resultArr['showing_till_date'];
    $alternate_text = $resultArr['alternate_text'];
    $upload_file = $resultArr['upload_file'];
    $announcement = $resultArr['announcement'];
    $email = $resultArr['email'];
}

?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($title) }}
        </h2>
    </x-slot>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="text-left">
                    <a class="btn btn-primary" href="{{ route('manage_results') }}"> Back</a>
                </div>
            </div>
        </div>
        </br>
         
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        @if ($message = Session::get('file_error'))
            <div class="alert alert-danger mb-1 mt-1">
                {{ session('file_error') }}
            </div>
        @endif
        <form action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">RN No.</label>
                        <select id="rn_no" name="rn_no_id" class="form-control select2">
                            <option value="">Select Type</option>
                            @foreach($rnNos as $rn_no)
                                <?php
                                $selected = "";
                                if($rn_no_id == $rn_no['id']){
                                    $selected = "selected";     
                                }
                                ?>
                                <option value="{{ $rn_no['id'] }}" data-code="{{ $rn_no['rn_no'] }}" <?php echo $selected; ?>>{{ $rn_no['rn_no'] }}</option>
                            @endforeach
                        </select>
                        @error('rn_no_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Position</label>
                        <select id="job_id" name="job_id" class="form-control">
                            
                        </select>
                        @error('job_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Title</label>
                        <input type="text" name="result_title" class="form-control" value="<?php echo $result_title; ?>">
                        @error('result_title')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Showing Till Date</label>
                        <input type="date" name="showing_till_date" class="form-control" value="<?php echo $showing_till_date; ?>">
                        @error('showing_till_date')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Alternate Text</label>
                        <input type="text" name="alternate_text" class="form-control" value="<?php echo $alternate_text; ?>">
                        @error('alternate_text')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Upload File</label>
                        <input type="file" name="upload_file" class="form-control" value="<?php echo $upload_file; ?>">
                        @error('upload_file')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Announcement</label>
                        <input type="text" name="announcement" class="form-control" value="<?php echo $announcement; ?>">
                        @error('announcement')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Emails send to</label>
                        <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                        @error('email')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
            </div>
            <div class="row">
                
                <div class="col-xs-12 col-sm-12 col-md-4 text-left">
                    </br>
                    <button type="submit" class="btn btn-primary text-right">Save</button>
                </div>    
            </div>
        </form>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        @if(!empty($rn_no_id) && !empty($job_id))
            let rnNoId = '<?php echo $rn_no_id; ?>';
            let jobId = '<?php echo $job_id; ?>';
            postsByRNNo(rnNoId, jobId);
        @endif


        $("#rn_no").change(function(){
            let rn_no_id = $(this).val();
            if(rn_no_id != ""){
                postsByRNNo(rn_no_id);
            }else{
                alert("Please select RN No.");
            }
        });

        function postsByRNNo(rn_no_id, job_id=""){
            $.ajax({
                        type:'POST',
                        url:"{{ route('get_posts_by_rnno') }}",
                        data:{rn_no_id:rn_no_id, job_id:job_id},
                        success:function(data){
                            let rnnoHtml = data;
                            $("#job_id").html(rnnoHtml);
                        }
            });
        }


    </script>

</x-app-layout>    