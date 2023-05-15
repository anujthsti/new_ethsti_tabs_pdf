<?php
$title = "Add Job";
$rn_no_id = old('rn_no_id');
$post_id = old('post_id');
$job_type_id = old('job_type_id');
$center_id = old('center_id');
$payment_mode_id = old('payment_mode_id');
$apply_start_date = old('apply_start_date');
$apply_end_date = old('apply_end_date');
$hard_copy_submission_date = old('hard_copy_submission_date');
$no_of_posts = old('no_of_posts');
$age_limit = old('age_limit');
$age_limit_as_on_date = old('age_limit_as_on_date');
$announcement = old('announcement');
$alt_text = old('alt_text');
$email_id = old('email_id');
$is_payment_required = old('is_payment_required');
$is_permanent = old('is_permanent');
$status = old('status');
$jobDomainArrays = old('domain_area_ids');

$form_action = route('save_job');
if(isset($job) && !empty($job)){
    $title = "Edit Job";
    $rn_no_id = $job->rn_no_id;
    $post_id = $job->post_id;
    $job_type_id = $job->job_type_id;
    $center_id = $job->center_id;
    $payment_mode_id = $job->payment_mode_id;
    $apply_start_date = $job->apply_start_date;
    $apply_end_date = $job->apply_end_date;
    $hard_copy_submission_date = $job->hard_copy_submission_date;
    $no_of_posts = $job->no_of_posts;
    $age_limit = $job->age_limit;
    $age_limit_as_on_date = $job->age_limit_as_on_date;
    $announcement = $job->announcement;
    $alt_text = $job->alt_text;
    $email_id = $job->email_id;
    $is_payment_required = $job->is_payment_required;
    $is_permanent = $job->is_permanent;
    $status = $job->status;
    $jobDomainArrays = $domain_area_ids;

    $encId = Helper::encodeId($job->id);
    $form_action = route('save_job',$encId);
}

if($is_payment_required == ""){
    $is_payment_required = 1;// yes
}
if($is_permanent == ""){
    $is_permanent = 1;// yes
}
if($status == ""){
    $status = 2;// unpublish
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
                    <a class="btn btn-primary" href="{{ route('manage_jobs') }}"> Manage Jobs</a>
                </div>
            </div>
        </div>
        </br>
        
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        @if(session('error_msg'))
        <div class="alert alert-danger mb-1 mt-1">
            {{ session('error_msg') }}
        </div>
        @endif
        @if (Session::get('file_error'))
            <div class="alert alert-danger mb-1 mt-1">
                {{ session('file_error') }}
            </div>
        @endif
        @if (Session::get('errorMsg'))
            <div class="alert alert-danger mb-1 mt-1">
                {{ session('errorMsg') }}
            </div>
        @endif
        
        <form action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <!-- RN No. start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">RN No.:</label>
                        <select name="rn_no_id" class="form-control select2">
                            <option></option>
                            @foreach($rn_nos as $rn_no)
                                <?php
                                $selected = "";
                                if($rn_no->id == $rn_no_id){
                                    $selected = "selected=selected";
                                }
                                ?>
                                <option value="{{ $rn_no->id }}" {{ $selected }}>{{ $rn_no->rn_no }}</option>
                            @endforeach
                        </select>
                        @error('rn_no_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- RN No. end -->
                <!-- job title start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Post</label>
                        <select name="post_id" class="form-control select2">
                            @foreach($posts_list as $post)
                                <?php
                                $selectedPost = "";
                                if($post['id'] == $post_id){
                                    $selectedPost = "selected=selected";
                                }
                                ?>
                                <option value="{{ $post['id'] }}" <?php echo $selectedPost; ?>>{{ $post['code_meta_name'] }}</option>
                            @endforeach
                        </select>
                        @error('job_title')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- job title end -->
                <!-- job types start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Job Type</label>
                        <select name="job_type_id" class="form-control">
                            <option value="">Select Job Type</option>
                            @foreach($job_types as $job_type)
                                <?php
                                $selected = "";
                                if($job_type['id'] == $job_type_id){
                                    $selected = "selected=selected";
                                }
                                ?>
                                <option value="{{ $job_type['id'] }}" {{ $selected }}>{{ $job_type['code_meta_name'] }}</option>
                            @endforeach
                        </select>
                        @error('job_type_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- job types end -->
                <!-- centers start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Domain Area</label>
                        <select name="domain_area_ids[]" class="form-control select2" multiple="multiple">
                            <option value="">Select Domain Area</option>
                            @foreach($domain_areas as $domain_area)
                                <?php
                                $selected = "";
                                if(!empty($jobDomainArrays) && in_array($domain_area['id'], $jobDomainArrays)){
                                    $selected = "selected=selected";
                                }
                                ?>
                                <option value="{{ $domain_area['id'] }}" {{ $selected }}>{{ $domain_area['code_meta_name'] }}</option>
                            @endforeach
                        </select>
                        @error('center_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- centers end -->
                <!-- centers start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Center</label>
                        <select name="center_id" class="form-control">
                            <option value="">Select center</option>
                            @foreach($centers as $center)
                                <?php
                                $selected = "";
                                if($center['id'] == $center_id){
                                    $selected = "selected=selected";
                                }
                                ?>
                                <option value="{{ $center['id'] }}" {{ $selected }}>{{ $center['code_meta_name'] }}</option>
                            @endforeach
                        </select>
                        @error('center_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- centers end -->
                <!-- payment modes start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Payment Mode</label>
                        <select name="payment_mode_id" class="form-control">
                            <option value="">Select Payment Mode</option>
                            @foreach($payment_modes as $payment_mode)
                                <?php
                                $selected = "";
                                if($payment_mode['id'] == $payment_mode_id){
                                    $selected = "selected=selected";
                                }
                                ?>
                                <option value="{{ $payment_mode['id'] }}" {{ $selected }}>{{ $payment_mode['code_meta_name'] }}</option>
                            @endforeach
                        </select>
                        @error('payment_mode_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- payment modes end -->
                <!-- job apply start date start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Job Apply Start Date</label>
                        <input type="text" name="apply_start_date" class="form-control date_picker" placeholder="dd/mm/yyyy" value="{{ $apply_start_date }}">
                        @error('apply_start_date')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- job apply start date end -->
                <!-- job apply end date start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Job Apply End Date</label>
                        <input type="text" name="apply_end_date" class="form-control date_picker" placeholder="dd/mm/yyyy" value="{{ $apply_end_date }}">
                        @error('apply_end_date')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- job apply end date end -->
                <!-- hardcopy Submission start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Hardcopy Submission Date</label>
                        <input type="text" name="hard_copy_submission_date" class="form-control date_picker" placeholder="dd/mm/yyyy" value="{{ $hard_copy_submission_date }}">
                        @error('hard_copy_submission_date')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- hardcopy Submission end -->
                <!-- No. of posts start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">No. of posts</label>
                        <input type="text" name="no_of_posts" class="form-control" placeholder="No. of posts" value="{{ $no_of_posts }}">
                        @error('no_of_posts')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- No. of posts end -->
                <!-- Age Limit start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Age Limit (In Years)</label>
                        <input type="text" name="age_limit" class="form-control" placeholder="No. of posts" value="{{ $age_limit }}">
                        @error('age_limit')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Age Limit end -->
                <!-- Age Limit As-on Date start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Age Limit As-on Date</label>
                        <input type="text" name="age_limit_as_on_date" class="form-control date_picker" placeholder="dd/mm/yyyy" value="{{ $age_limit_as_on_date }}">
                        @error('age_limit_as_on_date')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Age Limit As-on Date end -->
                <!-- Announcement start -->
                <div class="col-xs-12 col-sm-12 col-md-8">
                    <div class="form-group">
                        <label class="form-label">Announcement</label>
                        <input type="text" name="announcement" class="form-control" placeholder="Announcement Text Here" value="{{ $announcement }}">
                        @error('announcement')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Announcement end -->
                <!-- Alt Text start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Alt Text</label>
                        <input type="text" name="alt_text" class="form-control" placeholder="Alt Text Here" value="{{ $alt_text }}">
                        @error('alt_text')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Alt Text end -->
                <!-- Email Id start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Email Id</label>
                        <input type="text" name="email_id" class="form-control" placeholder="Email Id" value="{{ $email_id }}">
                        @error('email_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Email Id end -->
                <!-- Is Payment Required start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Is Payment Required</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_payment_required" value="1" <?php if($is_payment_required == 1){ echo "checked"; } ?>>
                            <label class="form-check-label">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_payment_required" value="2" <?php if($is_payment_required == 2){ echo "checked"; } ?>>
                            <label class="form-check-label">
                                No
                            </label>
                        </div>
                        @error('is_payment_required')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Is Payment Required end -->
                <!-- Is Permanent start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Is Permanent</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_permanent" value="1" <?php if($is_permanent == 1){ echo "checked"; } ?>>
                            <label class="form-check-label">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_permanent" value="2" <?php if($is_permanent == 2){ echo "checked"; } ?>>
                            <label class="form-check-label">
                                No
                            </label>
                        </div>
                        @error('is_permanent')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Is Permanent end -->
                <!-- PHD Document start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">PHD Document</label>
                        <input type="file" name="phd_document" class="form-control">
                        @error('phd_document')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- PHD Document end -->
                <!-- Status start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <?php $selectedText = 'selected="selected"'; ?>
                        <select name="status" class="form-control">
                            <option value="">Select Job Status</option>
                            <option value="1" <?php if($status == 1){ echo $selectedText; } ?>>Publish</option>
                            <option value="2" <?php if($status == 2){ echo $selectedText; } ?>>Unpublish</option>
                            <option value="3" <?php if($status == 3){ echo $selectedText; } ?>>Archive</option>
                        </select>
                        @error('status')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Status end -->
                <div class="col-xs-12 col-sm-12 col-md-4 text-left">
                    </br>
                    <button type="submit" class="btn btn-primary text-right">Submit</button>
                </div>    
            </div>
        </form>
    </div>

</x-app-layout>    