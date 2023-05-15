<!-- common sections variables start -->
<?php
    // variables for section header title
    $headerTitle = "Manage Jobs";
    // variables for section buttons bar
    $createBtnTitle = "Create Job";
    $createBtnLink = route('add_job');
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
                    <th>Job Title</th>
                    <th>Job Type</th>
                    <th>Center</th>
                    <th>Apply On</th>
                    <th>Status</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <!-- table header html end -->
            <tbody>
                <!-- table rows for loop start -->
                @foreach ($jobs as $job)
                    <?php
                    $encId = Helper::encodeId($job->id);
                    $jobTitleArr = Helper::getCodeNamesByCode($posts_list,'id',$job->post_id);
                    $center = "";
                    $job_type = "";
                    // get job type start
                    if($job->job_type_id != null){
                        $jobTypeArr = Helper::getCodeNamesByCode($job_types,'id',$job->job_type_id);
                        if(!empty($jobTypeArr)){
                            $job_type = $jobTypeArr[0]['code_meta_name'];
                        }
                    }
                    // get job type end
                    // get center start
                    if($job->center_id != null){
                        $centersArr = Helper::getCodeNamesByCode($centers,'id',$job->center_id);
                        if(!empty($centersArr)){
                            $center = $centersArr[0]['code_meta_name'];
                        }
                    }
                    // get center end
                    // apply on date start
                    $apply_start_date = $job->apply_start_date;
                    $apply_start_date = Helper::convertDateYMDtoDMY($apply_start_date);
                    // apply on date end
                    // status start
                    $status = "";
                    if($job->status == 1){
                        $status = "Publish";
                    }
                    else if($job->status == 2){
                        $status = "Unpublish";
                    }else{
                        $status = "Archive";
                    }
                    // status end
                    ?>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $job->rn_no }}</td>
                        <td>
                            <?php
                            if(!empty($jobTitleArr)){
                                echo $jobTitleArr[0]['code_meta_name'];
                            }
                            ?>
                        </td>
                        <td>{{ $job_type }}</td>
                        <td>{{ $center }}</td>
                        <td>{{ $apply_start_date }}</td>
                        <td>{{ $status }}</td>
                        <td>
                            <!-- action html start -->
                            <a class="btn btn-primary" href="{{ route('edit_job',$encId) }}"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-danger" href="{{ route('delete_job',$encId) }}"><i class="fa fa-trash"></i></a>
                            <!--<a class="btn btn-success" href="#"><i class="fa fa-cog"></i></a>-->
                            <?php
                            $postId = $job->post_id;
                            $postIdEnc = Helper::encodeId($postId);
                            // form validations url
                            $formValidationUrl = route('add_job_validation','postId='.$postIdEnc.'&job_id='.$encId);  
                            if(isset($job->job_validation_id) && !empty($job->job_validation_id)){
                                $formValidationIdEnc = Helper::encodeId($job->job_validation_id);
                                $formValidationUrl = route('edit_job_validation',$formValidationIdEnc.'?job_id='.$encId);  
                            }

                            // form configuration url
                            $formConfigUrl = route('add_form_configuration','postId='.$postIdEnc.'&job_id='.$encId);    
                            if(isset($job->job_configuration_id) && !empty($job->job_configuration_id)){
                                $formConfigIdEnc = Helper::encodeId($job->job_configuration_id);
                                $formConfigUrl = route('edit_form_configuration',$formConfigIdEnc.'?job_id='.$encId);  
                            }
                            ?>
                            <div class="dropdown actions-btn">
                                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-cog"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" target="_blank" href="<?php echo $formValidationUrl; ?>">Form Validations</a>
                                    <a class="dropdown-item" target="_blank" href="<?php echo $formConfigUrl; ?>">Form Configurations</a>
                                </div>
                            </div>
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