<!-- include header -->
@include('application.header')
@include('application.application_registeration_head')
<?php
$save_url = route('save_registration_details');
$rn_no_id = $jobData[0]['rn_no_id'];
$job_title = $jobData[0]['code_meta_name'];
$rn_no = $jobData[0]['rn_no'];
$apply_end_date = $jobData[0]['apply_end_date'];
$job_type_id = $jobData[0]['job_type_id'];

$masterCode = 'job_types';
$codeMetaCodeArr = ['train_program'];
$jobTypeIDs = Helper::getCodeNamesIdsByCodes($masterCode, $codeMetaCodeArr);
$jobTitleLabel = "Post Applied For";
if(in_array($job_type_id, $jobTypeIDs)){
    $jobTitleLabel = "Training Applied For";
}
?>
<!-- main container start -->
<div class="container-fluid border-top pt-5">                                          
    <div class="text-primary text-center mb-5 h4">Registration Details</div>
    <form id="online-form" name="registration-form" method="post" action="{{ $save_url }}" enctype="multipart/form-data" >        
      @csrf
        <!-- hidden fields-->      		       
        <input name="rn_no_id" type="hidden" value="{{ $rnNoId }}" readonly="readonly" id="rn_id" />
        <input name="job_id" type="hidden" value="{{ $jobId }}" readonly="readonly" id="rn_id" />
        <!-- Autofetched Details-->                       
      <div class="row">       
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="form-group">     
            <label for="staticrn_no" class="form-label">RN No.</label>
            <input type="text" readonly class="form-control" id="staticrn_no" value="{{ $rn_no }}" required="" />   
          </div>
        </div> 
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="form-group">    
            <label for="staticrn_job_title" class="form-label">{{ $jobTitleLabel }}</label> 
            <input type="text" readonly class="form-control" id="staticrn_job_title" value="{{ $job_title }}" required=""  />
          </div>
        </div>   
      </div>
        <!-- include candidate personal details form -->
        @include('application.candidate_personal_detail_form')  
        <!-- Permanent state, city, pincode section end -->
        <!-- SECURITY CAPTCHA CODE start -->                                                   
        <hr />                 			             
        <div class="form-group row" align="center">            
            <div class="col-12" align="center">		
                <span width="85" id="captcha" height="40" class="mb-1 captcha"/>{{ $captcha_code }}</span>
                <input name="security_code" type="text" autocomplete="off" maxlength="6" id="security_code" style="text-transform:none; margin-top: 10px;" class="form-control col-lg-2 col-md-2 col-sm-2" />
                <span class="btn" id="refresh_security_code"><i class="fa fa-refresh"></i></span>
                <br />
                @error('security_code')
                  <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror           
            </div>
            <div class="col-12" align="center">
                <input class="btn btn-success col-lg-2 col-md-2 col-sm-5"  id="submit" name="submit" type="submit" value="Verify and Submit"/>
            </div>                
        </div>    
        <!-- SECURITY CAPTCHA CODE end -->       
            
    <!-- end of registration form -->  
    </form>                                                   
 </div> 
</div> 
<!-- main container end -->

<!-- include footer -->
@include('application.footer')
