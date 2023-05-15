<!-- common sections variables start -->
<?php
    // variables for section header title
    $headerTitle = "Manage Jobs";
    // variables for section buttons bar
    $createBtnTitle = "Create Job";
    $createBtnLink = route('add_job');
?>
<!-- common sections variables end -->
@extends('layouts.application')

@section('content')
<div class="mt-5 mb-2">
    <!-- loop of jobs start -->
    <?php
    $coreJobsHtml = "";
    $projectJobsHtml = "";
    
    foreach($jobs as $job){
        $jobHtml = "";
        $jobHtml .= '<div class="row border-bottom p-1 mb-3 mt-3">    
                        <div class="col-lg-10 col-md-12 col-sm-12">';  
                $pdfFilePath = "";
                if(!empty($job->rn_document)){
                    $pdfFilePath = url("upload/rn_document/".$job->rn_document);
                }
                $jobIdEnc = Helper::encodeId($job->id);
                $applyUrl = route("jobs_instructions",$jobIdEnc);
                
        $jobHtml .= '<a class="text-primary h5" target="_blank" href="'.$pdfFilePath.'">'.$job->code_meta_name.'</a>'; 
        $jobHtml .= '<i class="fa fa-file-pdf-o text-danger"></i>';
        $jobHtml .= '<div class="col-12 row">
                        <div class="text-dark mr-3">RN No: <span class="text-dark">'.$job->rn_no.'</span></div> 
                        <div class="text-dark"><i class="fa fa-calendar"> Last Date</i>: <span class="text-dark">'.$job->apply_end_date.'</span></div>'; 
        if(in_array($job->job_type_id, $jobTypeIDsRolling)){ 
            $jobHtml .= '<div class="small bg-danger text-light text-center rounded shadow p-1">Rolling Recruitment</div>';
        }
        if(!empty($job->alt_text)){ 
            $jobHtml .= '<div class="small bg-warning text-light text-center rounded shadow p-1" style="margin-left: 10px;">'.$job->alt_text.'</div>';
        }
    
         $jobHtml .= '</div>';    
        $jobHtml .= '</div>       
            <div class="col-lg-2 col-md-12 col-sm-12 mt-2 text-right">';
                
        if(in_array($job->job_type_id, $jobTypeIDsToApplyBtn)){
            $jobHtml .= '<a class="btn btn-primary text-light" target="_blank" href="'.$applyUrl.'"><i class="fa fa-check"></i>&nbsp;Apply Online</a>'; 
        } 
        $jobHtml .= '</div> 
            </div>';

        if($job->is_permanent == 1){
            $coreJobsHtml .= $jobHtml;
        }else{
            $projectJobsHtml .= $jobHtml;
        }   

    } 
    ?>
    <!-- loop of jobs end -->
    <!-- tabs list start -->
    <?php
    $coreActiveClass = "active";
    $coreAreaSelected = "true";
    $coreTabClass = "show active";
    $projectActiveClass = "";
    $projectAreaSelected = "false";
    $projectTabClass = "";
    if($jobTypeCoreOrProject == "project"){
        $coreActiveClass = "";
        $coreAreaSelected = "false";
        $coreTabClass = "";
        $projectActiveClass = "active";
        $projectAreaSelected = "true";
        $projectTabClass = "show active";
    }
    ?>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $coreActiveClass }}" id="core-tab" data-toggle="tab" href="#core" trole="tab" aria-controls="core" aria-selected="{{ $coreAreaSelected }}">Permanent Positions</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $projectActiveClass }}" id="project-tab" data-toggle="tab" href="#project" role="tab" aria-controls="project" aria-selected="{{ $projectAreaSelected }}">Project Positions</a>
        </li>
    </ul>
    <!-- tabs list end -->
    <!-- tabs content start -->
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade {{ $coreTabClass }}" id="core" role="tabpanel" aria-labelledby="core-tab">
            <?php echo $coreJobsHtml; ?>
        </div>
        <div class="tab-pane fade {{ $projectTabClass }}" id="project" role="tabpanel" aria-labelledby="project-tab">
            <?php echo $projectJobsHtml; ?>
        </div>
    </div>
    
    <!-- tabs content end -->

</div>
@endsection
 