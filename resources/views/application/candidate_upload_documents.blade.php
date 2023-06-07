<!-- include header -->
@include('application.header')
<?php
$page_title = "Dashboard";
$form_action = route('update_candidate_upload_documents',$candidateJobApplyEncID);

$jobData = [];
$fieldsArray = [];
$job_title = "";
$rn_no = "";
$job_type_id = "";
if(isset($retData['jobData']) && !empty($retData['jobData'])){
    $jobData = $retData['jobData'];
    $fieldsArray = $retData['fieldsArray'];
    if(isset($jobData) && !empty($jobData)){
        $job_title = $jobData[0]['code_meta_name'];
        $rn_no = $jobData[0]['rn_no'];
        $job_type_id = $jobData[0]['job_type_id'];
    }
}

$isTrainProgram = 0;
$masterCode = 'job_types';
$codeMetaCodeArr = ['train_program'];
$jobTypeIDs = Helper::getCodeNamesIdsByCodes($masterCode, $codeMetaCodeArr);
$jobTitleLabel = "Post Applied For";
if(!empty($jobTypeIDs) && in_array($job_type_id, $jobTypeIDs)){
    $jobTitleLabel = "Training Applied For";
    $isTrainProgram = 1;
}

$castCategoryId = "";
$is_pwd = "";
$is_ex_serviceman = "";
$type_of_employment = "";
$is_govt_servent = "";
if(isset($candidateJobApplyDetail) && !empty($candidateJobApplyDetail)){
    $rn_no_id = $candidateJobApplyDetail[0]['rn_no_id'];
    $jobId = $candidateJobApplyDetail[0]['job_id'];
    $castCategoryId = $candidateJobApplyDetail[0]['category_id'];
    $is_pwd = $candidateJobApplyDetail[0]['is_pwd'];
    $is_ex_serviceman = $candidateJobApplyDetail[0]['is_ex_serviceman'];
    $type_of_employment = $candidateJobApplyDetail[0]['type_of_employment'];
    $is_govt_servent = $candidateJobApplyDetail[0]['is_govt_servent']; 
}

$castCategoryGenIdArr = Helper::getCodeNamesIdsByCodes("cast_categories", ["gen"]);

// get education master data
$educationMasterArr = Helper::getCodeNamesByMasterCode("education");
//print_r($castCategoryGenIdArr);
//echo "castCategoryId: ".$castCategoryId;
// candidate documents path

$candidateJobApplyID = Helper::decodeId($candidateJobApplyEncID);
$candidateDocsParentFolderPath = config('app.candidates_docs_path');
$candidateDocsParentFolderPath .= "/".$candidateJobApplyID;
//$candidateDocsParentFolderPath = "upload/candidates_documents";
$is_publication_tab = "";
if(isset($jobValidations[0]['is_publication_tab'])){
    $is_publication_tab = $jobValidations[0]['is_publication_tab'];
}

?>
@include('application.application_head')

<div class="container-fluid">	
    <!-- old existed file -> new_online_upload.php -->
    <!-- old existing submit form file -> online-update-upload.php -->
    <!-- include dashboard navigation -->
    @include('application.dashboard_nav')
    <div class="container-fluid border-top pt-5">    
        <!-- candidate form steps --> 
        @include('application.candidate_form_steps')                        
      <!-- form start -->  
        <form id="online-form" name="online-form" method="post" action="{{ $form_action }}" enctype="multipart/form-data">
            @csrf
            <!-- hidden fields start -->      		       
            <input name="rn_no_id" type="hidden" value="{{ $rn_no_id }}" readonly="readonly" id="rn_id" />
            <input name="job_id" type="hidden" value="{{ $jobId }}" readonly="readonly" id="rn_id" />
            <!-- hidden fields end -->
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
            @if(session('error_msg'))
                <div class="alert alert-danger mb-1 mt-1">
                    {{ session('error_msg') }}
                </div>
            @endif
            @if(session('file_error'))
                <div class="alert alert-danger mb-1 mt-1">
                    {{ session('file_error') }}
                </div>
            @endif
            @if(session('errorMsgArr'))
                @foreach(session()->get('errorMsgArr') as $in)
                    <div class="alert alert-danger mb-1 mt-1">
                            {{$in}}
                    </div>
                @endforeach
            @endif     
            <hr />          
            <!-- Files update fileds-->
            <!--------- Categories certificates starts ----------->
            <?php 
            if($isTrainProgram == 0 && !in_array($castCategoryId, $castCategoryGenIdArr) || $is_pwd == 1){
            ?>
                <div class="text-primary h4">Upload Certificates (.pdf file only and Size less than <span class="text-danger">200KB</span>)
                <?php if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['category_certificate']))){  ?> 
                    <i class="fa fa-edit text-danger" id="categories_edit">Edit</i>
                    <i class="fa fa-undo text-danger" id="categories_undo" style="display:none;">Cancel</i>
                <?php } ?> 
                </div>     
            <?php } ?>  				 
                <div class="col-12 mb-5">                                                                   
                    <?php if($isTrainProgram == 0 && !in_array($castCategoryId, $castCategoryGenIdArr)){ ?>
                        <!----- Category certificate upload start ----->
                        <div class="form-group row">
                            <label class="col-lg-2 col-md-2 col-sm-2">Category Certificate</label>
                            <input type="file" class="categories" name="category_certificate" value="" style="display:none;" />	                                			
                            <?php 
                            if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['category_certificate']))){ 
                                $categoryDocName = $candidatesCommonDocuments[0]['category_certificate'];
                                $categoryDocUrl = url($candidateDocsParentFolderPath."/".$categoryDocName);
                            ?> 
                                <a id="category_certificate_view" target="_new" href="<?php echo $categoryDocUrl; ?>">View File</a> 
                            <?php 
                            }else{ 
                            ?>
                                <input type="file" id="category_certificate_id" name="category_certificate" value=""  />
                            <?php } ?>                                
                        </div>   
                        <!----- Category certificate upload end ----->                        
                    <?php } ?>
                    
                    <?php if($is_ex_serviceman == 1){ ?>
                        <!----- Ex-serviceman NOC certificate upload start ----->
                        <div class="form-group row">
                            <label class="col-lg-2 col-md-2 col-sm-2">Discharge Certificate/NOC (Ex-servicemen)</label>
                            <input type="file" class="categories" name="esm_certificate" value="" style="display:none;" />	                                			
                            <?php 
                            if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['esm_certificate']))){ 
                                $esmDocName = $candidatesCommonDocuments[0]['esm_certificate'];
                                $esmDocUrl = url($candidateDocsParentFolderPath."/".$esmDocName);
                            ?>    
                                <a id="esm_certificate_view" target="_new" href="<?php echo $esmDocUrl; ?>">View File</a> 
                            <?php 
                            }else{ 
                            ?>
                                <input type="file" id="esm_certificate_id" name="esm_certificate" value=""  />
                            <?php } ?>                                
                        </div>  
                        <!----- Ex-serviceman NOC certificate upload end ----->                         
                    <?php } ?>
                    
                    
                    
                    <?php if($is_pwd == 1){ ?>
                        <!----- PWD certificate upload start ----->
                        <div class="form-group row">
                            <label class="col-lg-2 col-md-2 col-sm-2">Disability Certificate </label>                
                            <input type="file" class="categories" name="pwd_certificate" value="" style="display:none;"  />
                            <?php 
                            if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['pwd_certificate']))){ 
                                $pwdDocName = $candidatesCommonDocuments[0]['pwd_certificate'];
                                $pwdDocUrl = url($candidateDocsParentFolderPath."/".$pwdDocName);
                            ?>    
                                <a target="_new" href="<?php echo $pwdDocUrl; ?>">View File</a> 
                            <?php 
                            } else{ 
                            ?>
                                <input type="file" id="pwd_certificate_id" name="pwd_certificate" value="" />
                            <?php } ?>
                        </div>  
                        <!----- PWD certificate upload end ----->                         
                    <?php } ?>
                </div>
            
            <!--------- Categories certificates end ----------->  

            <!--------- Update Acacdemic Cerficates and degrees start ------>
            <?php 
            if($isTrainProgram == 0 && !empty($candidateAcademicsDetails)){
                $existingAcademicDocsIds = [];
                if(!empty($candidatesAcademicsDocuments)){
                    $existingAcademicDocsIds = array_column($candidatesAcademicsDocuments,'education_id');
                }
                ?>
                <div class="text-primary h4">
                    Upload Academics Certificates/ Degrees (.pdf file only and Size less than <span class="text-danger">200KB</span>)
                    <?php if(!empty($existingAcademicDocsIds)){ ?> 
                        <i class="fa fa-edit text-danger" id="academic_edit">Edit</i>
                        <i class="fa fa-undo text-danger" id="academic_undo" style="display:none;">Cancel</i>
                    <?php } ?> 
                </div> 
                <div class="col-12 mb-5" id="#edu">                                                            
                    <?php 
                    
                    foreach($candidateAcademicsDetails as $academic){ 
                        $education_id = $academic['education_id'];
                        $educationData = [];
                        $educationData = Helper::getCodeNamesByCode($educationMasterArr, "id", $education_id);
                    ?>
                        <div class="form-group row">
                            <label class="col-lg-6 col-md-6 col-sm-6"><?php echo $educationData[0]['code_meta_name']; ?></label>
                            <input name="academic_upload[<?php echo $education_id; ?>]" class="academics" type="file"  style="display:none;" disabled="disabled" />
                            <?php 
                            if(!empty($existingAcademicDocsIds) && in_array($education_id, $existingAcademicDocsIds)){ 
                                $idKey = array_search($education_id, $existingAcademicDocsIds);
                                
                                $academicDocName = $candidatesAcademicsDocuments[$idKey]['file_name'];
                                //echo $candidateDocsParentFolderPath;exit;
                                $candidateFilePath = url($candidateDocsParentFolderPath."/".$academicDocName);
                            ?> 
                                <a target="_new" href="<?php  echo $candidateFilePath; ?>">View File</a>
                            <?php 
                            } else{ 
                            ?>
                                <input name="academic_upload[<?php echo $education_id; ?>]" class="academics" type="file"/>
                            <?php } ?>
                        </div>                           
                    <?php 
                        } 
                    ?>
                </div>
			<?php } ?>
            <!--------- Update Acacdemic Cerficates and degrees end ------>        

            <!--------- Update Experience documents start ------>                 
            <?php 
            if($isTrainProgram == 0 && !empty($candidateExperienceDetails)){ 
                $existingExperienceDocsIds = [];
                if(!empty($candidatesExperienceDocuments)){
                    $existingExperienceDocsIds = array_column($candidatesExperienceDocuments,'candidate_experience_detail_id');
                }
            ?> 
                <div class="text-primary h4">Upload Experience Certificates (.pdf file only and Size less than <span class="text-danger">200KB</span>)
                    <?php if(!empty($existingExperienceDocsIds)){?> 
                        <i class="fa fa-edit text-danger" id="exp_edit">Edit</i>
                        <i class="fa fa-undo text-danger" id="exp_undo" style="display:none;">Cancel</i>
                    <?php } ?> 
                </div>
                <div class="col-12 mb-5">                         
                    <?php 
                        
                        foreach($candidateExperienceDetails as $experience){ 
                            $candidate_experience_detail_id = $experience['id'];
                    ?>
                            <div class="form-group row">
                                <label class="col-lg-6 col-md-6 col-sm-6"><?php echo $experience['organization_name']; ?> (<?php echo date('d-m-Y',strtotime($experience['from_date'])); ?> TO <?php echo date('d-m-Y',strtotime($experience['to_date'])); ?>) </label>
                                <input name="exp_upload[<?php echo $candidate_experience_detail_id; ?>]" class="exp" type="file" style="display:none;" disabled="disabled" />
                                <?php  
                                if(!empty($existingExperienceDocsIds) && in_array($candidate_experience_detail_id, $existingExperienceDocsIds)){ 
                                    $idKey = array_search($candidate_experience_detail_id, $existingExperienceDocsIds);
                                    
                                    $experienceDocName = $candidatesExperienceDocuments[$idKey]['file_name'];
                                    $candidateExpFilePath = url($candidateDocsParentFolderPath."/".$experienceDocName);
                                ?>    
                                    <a target="_new" href="<?php  echo $candidateExpFilePath; ?>">View File</a> 
                                <?php 
                                } else{ 
                                ?>
                                    <input name="exp_upload[<?php echo $candidate_experience_detail_id; ?>]" class="exp_upload" type="file" />
                                <?php } ?>
                            </div>                           
                    <?php } ?>
                </div>
            <?php 
            } 
            ?>
            <!--------- Update Experience documents end ------>   


            <!--------- Passport photo upload start ------->
		    <?php 
            if($isTrainProgram == 0){
            ?>
                <div class="text-primary h4">
                    Upload Images (.jpg/.jpeg file only)
                    <?php if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['candidate_photo']))){ ?> 
                        <i class="fa fa-edit text-danger" id="images_edit">Edit</i>
                        <i class="fa fa-undo text-danger" id="images_undo" style="display:none;">Cancel</i>
                    <?php } ?> 
                </div>  
                <div class="col-lg-12 col-md-12 col-sm-12 mb-5">                       
                    <div class="form-group" id="img_attachements_id">              
                        <div class="form-group row">
                            <label for="passport_photo" class="col-lg-6 col-md-6 col-sm-6">Upload passport size Photograph (200 x 250) of maximum  <span class="text-danger h5">100 KB</span></label>   
                            <input name="passport_photo" type="file" id="passport_photo" class="col-lg-4 images" style="display:none;" />                               
                            <?php 
                            if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['candidate_photo']))){ 
                                $photoDocName = $candidatesCommonDocuments[0]['candidate_photo'];
                                $photoDocUrl = url($candidateDocsParentFolderPath."/".$photoDocName);
                            ?>    
                                <img src="<?php echo $photoDocUrl; ?>" width="50" height="50" class="border" />
                            <?php 
                            }else{ 
                            ?>
                            <input name="passport_photo" type="file" id="passport_photo" class="col-lg-4" />
                            <?php } ?>
                        </div>
                        <div class="form-group row">
                            <label for="passport_sig" class="col-lg-6 col-md-6 col-sm-6">Upload Signature (150 x 100) of  maximum <span class="text-danger h5">100 KB</span></label>
                            <input name="passport_sig" type="file" id="passport_sig" class="col-lg-4 images" style="display:none;" />
                            <?php 
                            if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['candidate_sign']))){ 
                                $signDocName = $candidatesCommonDocuments[0]['candidate_sign'];
                                $signDocUrl = url($candidateDocsParentFolderPath."/".$signDocName);
                            ?>    
                                <img src="<?php echo $signDocUrl; ?>" width="50" height="20" class="border" />
                            <?php 
                            } else {
                            ?>
                                <input name="passport_sig" type="file" id="passport_sig" class="col-lg-4"  />
                            <?php } ?>
                        </div>                          
                    </div>          
                </div>
		    <?php } ?>
            <!--------- Passport photo upload end ------->   
            
            <?php if(isset($candidatePHDResearchDetails) && !empty($candidatePHDResearchDetails)){ ?> 
                <!--------- Fellowship document upload start ------->  
                <?php if(isset($candidatePHDResearchDetails[0]['funding_agency']) && !empty($candidatePHDResearchDetails[0]['funding_agency'])){ ?> 
                    <div class="text-primary h4">
                        Fellowship/Certificate Attachments (.pdf file only and Size less than <span class="text-danger">200KB</span>) 
                        <?php if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['fellowship_certificate']))){ ?>
                        <i class="fa fa-edit text-danger" id="fellowship_edit">Edit</i>
                        <i class="fa fa-undo text-danger" id="fellowship_undo" style="display:none;">Cancel</i>
                        <?php } ?>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-5">
                        <div class="form-group row">
                            <label for="fellowship_upload" class="col-lg-6 col-md-6 col-sm-6">Upload fellowship award letter</label>
                            <?php 
                            if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['fellowship_certificate']))){ 
                                $fellowshipDocName = $candidatesCommonDocuments[0]['fellowship_certificate'];
                                $fellowshipDocUrl = url($candidateDocsParentFolderPath."/".$fellowshipDocName);
                            ?>  
                                <input name="fellowship_upload" type="file" id="fellowship_upload" style="display:none;" disabled="disabled" />
                                <a target="_new" href="<?php echo $fellowshipDocUrl; ?>">View File</a>
                            <?php 
                            } 
                            else{ 
                            ?>
                            <input name="fellowship_upload" type="file" id="fellowship_upload" required  />    
                            <?php } ?>                          
                        </div>
                    </div>
                <?php } ?>        
                <!--------- Fellowship document upload end ------->
                
                <!--------- Exam Qualified document upload start ------->
                <?php if(isset($candidatePHDResearchDetails[0]['exam_name']) && !empty($candidatePHDResearchDetails[0]['exam_name'])){ ?>    
                    <div class="text-primary h4">
                        Exam Qualified (.pdf file only and Size less than <span class="text-danger">200KB</span>) 
                        <?php if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['exam_qualified_certificate']))){ ?>    
                        <i class="fa fa-edit text-danger" id="exam_qualified_edit">Edit</i>
                        <i class="fa fa-undo text-danger" id="exam_qualified_undo" style="display:none;">Cancel</i>
                        <?php } ?>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-5">
                        <div class="form-group row">
                            <label for="exam_qualified_upload" class="col-lg-6 col-md-6 col-sm-6">GATE/NET/GPAT score card</label>
                            <?php 
                            if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['exam_qualified_certificate']))){ 
                                $examQualifiedDocName = $candidatesCommonDocuments[0]['exam_qualified_certificate'];
                                $examQualifiedDocUrl = url($candidateDocsParentFolderPath."/".$examQualifiedDocName);
                            ?>   
                                <input name="exam_qualified_upload" type="file" id="exam_qualified_upload" style="display:none;" disabled="disabled" />
                                <a target="_new" href="<?php echo $examQualifiedDocUrl; ?>">View File</a>
                            <?php 
                            }else{ 
                            ?>
                                <input name="exam_qualified_upload" type="file" id="exam_qualified_upload" required />
                            <?php } ?>                          
                            
                        </div>
                    </div>
                <?php } ?>
                <!--------- Exam Qualified document upload end ------->
            <?php } ?>

                
                <div class="text-primary h4">Attachments (.pdf file only and Size less than <span class="text-danger">500KB</span>)    
                                
                    <?php if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['id_card']))){?>
                        <i class="fa fa-edit text-danger" id="attachments_edit">Edit</i>
                        <i class="fa fa-undo text-danger" id="attachments_undo" style="display:none;">Cancel</i>
                    <?php } ?> 
                    
                </div>         		                            
                

                @if(!empty($fieldsArray) && (in_array('idcard', $fieldsArray) || in_array('uploadcv', $fieldsArray) || in_array('listofpublicationsandpatents', $fieldsArray) || in_array('publicationsbestthree', $fieldsArray) || in_array('projectproposal', $fieldsArray) || in_array('forwardingletternoc', $fieldsArray) || $type_of_employment == 1))
                <div class="col-lg-12 col-md-12 col-sm-12" id="attachments">                                                                                                   
                          
                    <!-- ID Card start-->
                    <?php if(in_array('idcard', $fieldsArray)){ ?>
                        <div class="form-group row">
                            <label for="id_card" class="col-lg-6 col-md-6 col-sm-6">ID Card</label>                
                            <?php 
                            if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['id_card']))){ 
                                $idCardDocName = $candidatesCommonDocuments[0]['id_card'];
                                $idCardDocUrl = url($candidateDocsParentFolderPath."/".$idCardDocName);
                            ?>    
                                <input class="attachments_view"  name="id_card" type="file" id="id_card" value="" style="display:none;" disabled="disabled" />   
                                <a target="_new" href="<?php echo $idCardDocUrl; ?>">View File</a>
                            <?php 
                            }else{ 
                            ?>
                                <input class="attachments_view"  name="id_card" type="file" id="id_card" value="" />                
                            <?php } ?>                                
                        </div>  
                    <?php } ?> 
                    <!-- ID Card end-->

                    <!-- Age proof start -->
                    <?php if(in_array('ageproof', $fieldsArray)){ ?>
                        <div class="form-group row">
                            <label for="age_proof" class="col-lg-6 col-md-6 col-sm-6">Age Proof</label>
                            <?php 
                            if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['age_proof']))){ 
                                $age_proofDocName = $candidatesCommonDocuments[0]['age_proof'];
                                $age_proofDocUrl = url($candidateDocsParentFolderPath."/".$age_proofDocName);
                            ?>   
                                <input class="attachments_view"  name="age_proof" type="file" id="age_proof" value="" style="display:none;" disabled="disabled" /> 
                                <a target="_new" href="<?php echo $age_proofDocUrl; ?>">View File</a>
                            <?php 
                            }else{ 
                            ?>
                                <input class="attachments_view"  name="age_proof" type="file" id="age_proof" value="" />
                            <?php } ?>                
                        </div>
                    <?php } ?> 
                    <!-- Age proof end -->
                    
                    <!-- Employer NOC start -->
                    <?php if(in_array('forwardingletternoc', $fieldsArray) && $is_govt_servent == 1 && $type_of_employment == 1){ ?>
                        <div class="form-group row">
                            <label for="employer_noc" class="col-lg-6 col-md-6 col-sm-6">Forwarding letter/NOC from current employer/Current experience certificate</label>                
                            <?php 
                            if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['noc_certificate']))){ 
                                $nocDocName = $candidatesCommonDocuments[0]['noc_certificate'];
                                $nocDocUrl = url($candidateDocsParentFolderPath."/".$nocDocName);
                            ?>    
                                <input class="attachments_view"  name="employer_noc" type="file" id="employer_noc" value="" style="display:none;" disabled="disabled" />   
                                <a target="_new" href="<?php echo $nocDocUrl; ?>">View File</a>
                            <?php 
                            }else{ 
                            ?>
                                <input class="attachments_view"  name="employer_noc" type="file" id="employer_noc" value="" />                
                            <?php } ?>                                
                        </div>
                    <?php } ?>    
                    <!-- Employer NOC end -->    
                    
                    <!-- Statement of Proposal start-->
                    <?php if(in_array('statementofproposal', $fieldsArray)){ ?>
                        <div class="form-group row">
                            <label for="stmt_proposal" class="col-lg-6 col-md-6 col-sm-6">Statement of Purpose</label>                
                            <?php 
                            if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['stmt_proposal']))){ 
                                $stmtName = $candidatesCommonDocuments[0]['stmt_proposal'];
                                $stmtUrl = url($candidateDocsParentFolderPath."/".$stmtName);
                            ?>
                                <input class="attachments_view"  name="stmt_proposal" type="file" id="stmt_proposal" value="" style="display:none;" disabled="disabled" />   
                                <a target="_new" href="<?php echo $stmtName;?>">View File</a>
                            <?php 
                            }else{ 
                            ?>
                                <input class="attachments_view"  name="stmt_proposal" type="file" id="stmt_proposal" value="" />                
                            <?php } ?>                                
                        </div>     
                    <?php } ?>                   
                    <!-- Statement of Proposal end-->

                    <!-- cv block start-->
                    <?php if(in_array('uploadcv', $fieldsArray)){ ?>
                        <div class="form-group row">
                            <label for="attach_cv" class="col-lg-6 col-md-6 col-sm-6">Upload CV</label>
                            <?php 
                            if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['candidate_cv']))){ 
                                $cvName = $candidatesCommonDocuments[0]['candidate_cv'];
                                $cvUrl = url($candidateDocsParentFolderPath."/".$cvName);
                            ?>    
                                <input class="attachments_view" name="cv" type="file" id="attach_cv" value="" style="display:none;" disabled="disabled" />
                                <a target="_new" href="<?php echo $cvUrl; ?>">View File</a>
                            <?php 
                            }else{ 
                            ?>
                                <input name="cv" type="file" id="attach_cv"  />
                            <?php } ?>                
                        </div>
                    <?php } ?>      
                    <!-- cv block end-->

                    <!-- List of Publications start -->
                    <?php if(in_array('listofpublicationsandpatents', $fieldsArray)){ ?>
                        <div class="form-group row">                                              
                            <label for="attach_pub_list" class="col-lg-6 col-md-6 col-sm-6">List of Publications and Patents</label>                
                            <label>
                            
                            <?php 
                            if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['listpublication']))){ 
                                $listpublicationName = $candidatesCommonDocuments[0]['listpublication'];
                                $listpublicationUrl = url($candidateDocsParentFolderPath."/".$listpublicationName);
                            ?>    
                                <input class="attachments_view" name="listpublication" value="" type="file" style="display:none;" disabled="disabled" />                                                      
                                <a target="_new" href="<?php echo $listpublicationUrl;?>">View File</a>
                            <?php }else{ ?>
                                <input name="listpublication" type="file" id="attach_pub_list" value="" />
                                <!--    
                                <label <?php //echo ($rec_job_valid['list_pub_open']==1)?'style="display:none"':''; ?> id="list_pub_close"><i class="fa fa-close">&nbsp;Close</i></label>
                                <label id="list_pub_open" style="display:none;"><i class="fa fa-upload">&nbsp;Upload</i></label>
                                -->
                            <?php } ?>                                                                 
                            
                            </label>                                                       
                        </div>
                    <?php } ?> 
                    <!-- List of Publications end -->

                    <!-- Publications block start -->
                    <?php if(in_array('publicationsbestthree', $fieldsArray)){ ?>
                        <div class="form-group row">
                            <label for="attach_pub1" class="col-lg-6 col-md-6 col-sm-6">Publications (Best Five/Ten)</label>
                            
                            <?php //if($c_dtl['publication']!='' && file_exists("../ethsti/writereaddata/".$c_dtl['publication'])){ ?>
                            <?php 
                            if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['publication']))){ 
                                $publicationName = $candidatesCommonDocuments[0]['publication'];
                                $publicationUrl = url($candidateDocsParentFolderPath."/".$publicationName);
                            ?>    
                                <input class="attachments_view" name="publication" type="file" id="attach_pub1" style="display:none;" disabled="disabled" />
                                <a target="_new" href="<?php echo $publicationUrl; ?>">View File</a>
                            <?php 
                            }else{ 
                            ?>
                                <input  name="publication" type="file" id="attach_pub1" />
                            <?php } ?>
                        </div>
                    <?php } ?> 
                    <!-- Publications block end -->

                    <!-- Project block start -->
                    <?php if(in_array('projectproposal', $fieldsArray)){ ?>            
                        <div class="form-group row">
                            <label for="attach_pro" class="col-lg-6 col-md-6 col-sm-6">Project Proposal</label>                
                            <label>
                                <?php 
                                if(!empty($candidatesCommonDocuments) && (!empty($candidatesCommonDocuments[0]['project_proposal']))){ 
                                    $proposalName = $candidatesCommonDocuments[0]['project_proposal'];
                                    $proposalUrl = url($candidateDocsParentFolderPath."/".$proposalName);
                                ?>    
                                    <input class="attachments_view"  name="project" type="file" style="display:none;" disabled="disabled" />
                                    <a target="_new" href="<?php echo $proposalUrl; ?>">View File</a>
                                <?php }else{ ?>
                                    <input name="project" type="file" id="attach_pro" /> 				                
                                    <!--
                                    <label <?php //echo ($rec_job_valid['proposal_tab']==1)?'style="display:none"':''; ?> id="pro_close"><i class="fa fa-close">&nbsp;Close</i></label>
                                    <label id="pro_open" style="display:none;"><i class="fa fa-upload">&nbsp;Upload</i></label>
                                    -->
                                <?php } ?>
                            
                            </label>
                        </div>
                    <?php } ?> 

                </div>
                @endif
    
                <!-- endof attachemnet-->   
                <hr /> 
                        			             
                <div class="form-group row" align="center" id="security">             
                    <div class="col-12" align="center">		
                        <span width="85" id="captcha" height="40" class="mb-1 captcha">{{ $captcha_code }}</span>
                        <input name="security_code" type="text" autocomplete="off" maxlength="6" id="security_code" style="text-transform:none; margin-top: 10px;" class="form-control col-lg-2 col-md-2 col-sm-2" />
                        <span class="btn" id="refresh_security_code"><i class="fa fa-refresh"></i></span>
                        <br />
                        @error('security_code')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror           
                    </div>
                    <div class="form-group col-12" align="center">	            
                        <input class="btn btn-success col-1" id="update" name="update" type="submit" value="Update" onclick="disableSubmitButton();"/>
                    </div>                
                </div>  

        </form>
      <!-- form end -->
    </div>  
      

</div>

<script type="text/javascript">
    $(document).ready(function(){	
    
        //alert("right click functionality is disabled for this page.");
        $("body").on("contextmenu",function(e){	  
            //return false;
        });
    
        
        $('#online-form').change(function(){
            $('#security').show();	  
        });
    
    
        //optional pdf files
        $("#pro_close").click(function(){	
            $('#attach_pro').hide();
            $('#pro_close').hide();
            $('#pro_open').show();	
        });
    
        $("#pro_open").click(function(){	
            $('#attach_pro').show();
            $('#pro_close').show();
            $('#pro_open').hide();	
        });
    
    
        //categoryt certificate code
        $("#categories_edit").click(function(){	
            $('.categories').each(function(){
                $(this).show();
                $("#categories_edit").hide();
                $("#categories_undo").show();
            });
        });
        $("#categories_undo").click(function(){	
            $('.categories').each(function(){
                $(this).val('');
                $(this).hide();
                $("#categories_edit").show();
                $("#categories_undo").hide();
            });
        });
        
        //images sectin edit
        $("#images_edit").click(function(){	
            $('.images').each(function(){
                $(this).show();
                $("#images_edit").hide();
                $("#images_undo").show();
            });
        });
        
        $("#images_undo").click(function(){	
            $('.images').each(function(){
                $(this).val('');
                $(this).hide();
                $("#images_edit").show();
                $("#images_undo").hide();
            });
        });
        
        
        //images sectin edit
        $("#academic_edit").click(function(){	
            $('.academics').each(function(){
                $(this).show();
                $(this).removeAttr("disabled");
                $("#academic_edit").hide();
                $("#academic_undo").show();
            });
        });
        $("#academic_undo").click(function(){	
            $('.academics').each(function(){
                $(this).val('');
                $(this).hide();
                //$(this).addAttr("disabled");
                $("#academic_undo").hide();
                $("#academic_edit").show();				
            });
        });
        
        //images sectin edit
        $("#exp_edit").click(function(){	
            $('.exp').each(function(){
                $(this).show();
                $(this).removeAttr("disabled");		
            });
            $("#exp_undo").show();
            $("#exp_edit").hide();
        });
        
        $("#exp_undo").click(function(){	
            $('.exp').each(function(){
                $(this).val('');
                $(this).hide();
                //$(this).removeAttr("disabled");
                $("#exp_undo").hide();
                $("#exp_edit").show();
            });	
        });    
        
        //Attachments edit
        $("#attachments_edit").click(function(){	
            $('.attachments_view').each(function(){
                $(this).show();	
                $(this).removeAttr("disabled");			
            });
            $("#attachments_undo").show();
            $("#attachments_edit").hide();
        });
        
        $("#attachments_undo").click(function(){	
            $('.attachments_view').each(function(){
                $(this).val('');
                $(this).hide();		
                $("#attachments_undo").hide();
                $("#attachments_edit").show();
            });	
        });
                
        //publication file optional feature
        $("#list_pub_close").click(function(){	 
            $('#attach_pub_list').hide();
            $('#list_pub_close').hide();
            $('#list_pub_open').show();	
        });
        
        $("#list_pub_open").click(function(){	
            $('#attach_pub_list').show();
            $('#list_pub_close').show();
            $('#list_pub_open').hide();	
        });
        
        //fellowship sectinon edit
        $("#fellowship_edit").click(function(){	
                $("#fellowship_upload").show();
                $("#fellowship_upload").removeAttr("disabled");
                $("#fellowship_edit").hide();
                $("#fellowship_undo").show();
           
        });
        $("#fellowship_undo").click(function(){	
                $("#fellowship_upload").val('');
                $("#fellowship_upload").hide();
                //$(this).addAttr("disabled");
                $("#fellowship_undo").hide();
                $("#fellowship_edit").show();				
            
        });

        //exam qualified sectinon edit
        $("#exam_qualified_edit").click(function(){	
                $("#exam_qualified_upload").show();
                $("#exam_qualified_upload").removeAttr("disabled");
                $("#exam_qualified_edit").hide();
                $("#exam_qualified_undo").show();
           
        });
        $("#exam_qualified_undo").click(function(){	
                $("#exam_qualified_upload").val('');
                $("#exam_qualified_upload").hide();
                //$(this).addAttr("disabled");
                $("#exam_qualified_undo").hide();
                $("#exam_qualified_edit").show();				
            
        });
        
        
        /*
        $('#security_code').keydown(function(){  
            $('#captcha_error').html(''); 
        });
        */

        //form submit
        $('#online-form').submit(function(){			
            
            var isvalid='';
            var datavalid='';			 	  	 	 			   	  	 	 	 	 	 	 	 
            var flag=false;
            var ctr=0;
            $('input[type="file"]:visible,input[type="text"]:visible').each(function(){		 		 					 
                if($(this).val()=='')
                {	
                    isvalid=false;		 	 	 	  		
                    $(this).css({"border":"2px solid red"});		 
                    $(this).focus();		
                    return false;			 
                }
                else		 
                {			 				  			
                    $(this).css({"border":""}); 
                    isvalid=true; 	
                    ctr++;		   
                }	 					 	  
            });		
            if(isvalid==true)
            {			
                var code_check=$('#captcha_error_check').val();		 		   
                if(code_check==0)
                {
                    datavalid=false;		 	 	 	  		
                    $('#security_code').css({"border":"2px solid red"});		 
                    $('#security_code').focus();		
                    return false;
                }		 
                else
                {  datavalid=true;  }
            }	
                
            if(datavalid==true && isvalid==true)
            { 						  		 
                alert("Your form has been verified!!!!");	  
                flag=true;
            }

            if(flag)
            {
                var ans=confirm("Do you want to submit?");	
                if(ans)
                {  return true;  }
                else
                {  return false; }
            }    
        });
        
        
        
        //form validation			  
        $('#online-form').validate({						  
            rules: {
                rn_no: {required: true},
                domain_area: {required: true},
                job_title: {required: true},			
                cv: {required: true, accept:"pdf"},
                listpublication:{required: true,accept:"pdf"}, 
                publication:{accept:"pdf"}, 
                publication1:{accept:"pdf"}, 
                publication2:{accept:"pdf"}, 
                project:{required: true,accept:"pdf"}, 	
                passport_photo: {required: true, accept:"jpg|JPG|jpeg|JPEG"},
                passport_sig: {required: true, accept:"jpg|JPG|jpeg|JPEG"},					
                fellowship_upload: {accept:"pdf", required:true},
                exam_qualified_upload: {accept:"pdf", required:true },
                age_proof: {accept:"pdf",required:true},
                employer_noc: {accept:"pdf",required:true},
                security_code: {required: true, minlength:6, maxlength:6},			
                category_certificate: {required: true, accept:"pdf"},
                pwd_certificate: {required: true, accept:"pdf"},	
                'academic_upload[]': {required: true, accept:"pdf"},
                'exp_upload[]': {required: true, accept:"pdf"},																	
            },	
        });		
            
        //attachments and file upload 
        
        //UPDATE IMAGES ONLY  
        $('#img_attachements_id').on('change','#passport_photo',function(){	
            var img_size=$(this)[0].files[0].size/1024;		
            var ext=$(this)[0].files[0].type;
            if(ext=='image/jpeg' || ext=='image/jpg' || ext=='image/JPEG' || ext=='image/JPG')
            {	if(img_size>50){ alert("Maximum file size is 50KB"); $(this).val(''); $(this).focus();  } }
            else
            { alert("Please upload Image format (.jpeg, .jpg) only"); $(this).val(''); $(this).focus();  }
        });
        
        $('#img_attachements_id').on('change','#passport_sig',function(){	
            var img_size=$(this)[0].files[0].size/1024;		
            var ext=$(this)[0].files[0].type;
            if(ext=='image/jpeg' || ext=='image/jpg' || ext=='image/JPEG' || ext=='image/JPG')
            {	if(img_size>10){ alert("Maximum file size is 10KB"); $(this).val(''); $(this).focus();  } }
            else
            { alert("Please upload Image format (.jpeg, .jpg) only"); $(this).val(''); $(this).focus();  }
        }); 
        
        //UPLOAD PDF FILE ONLY    
        $('#attachments').on('change','#attach_cv, #attach_pub_list, #attach_pub1, #attach_pub2, #attach_pub3, #attach_pro, #attach_age_proof, #attach_employer_noc',function(){		 
            var fsize=$(this)[0].files[0].size/1024;		 
            var ext=$(this)[0].files[0].type;
            if(ext=='application/pdf')
            {  if(fsize > 500){ alert("Maximum file size is 500KB");  $(this).val(''); $(this).focus(); }	}
            else
            { alert("Please upload PDF only"); $(this).val(''); $(this).focus();  }
        });

        
        $('#category_certificate_id').on('change',function(){	
            var file_size=$(this)[0].files[0].size/1024;	
            var ext=$(this)[0].files[0].type;
            if(ext=='application/pdf')
            { if(file_size>200){ alert("Maximum file size is 200KB"); $(this).val(''); $(this).focus();  } }
            else
            { alert("Please upload PDF only"); $(this).val(''); $(this).focus();  }
            
        });
        
        $('.academics').change(function(){			 
            var file_size=$(this)[0].files[0].size/1024;
            var ext=$(this)[0].files[0].type;
            if(ext=='application/pdf')	
            { if(file_size>200){ alert("Maximum file size is 200KB");  $(this).val(''); $(this).focus(); }  }
            else
            { alert("Please upload PDF only"); $(this).val(''); $(this).focus();  }
        });
        
        $('.exp_upload').change(function(){	
            var file_size=$(this)[0].files[0].size/1024;	
            var ext=$(this)[0].files[0].type;
            if(ext=='application/pdf')
            { if(file_size>200){ alert("Maximum file size is 200KB");  $(this).val(''); $(this).focus();  } }
            else
            { alert("Please upload PDF only"); $(this).val(''); $(this).focus();  } 	  
        });
        
        $('#pwd_certificate_id').on('change',function(){	
            var file_size=$(this)[0].files[0].size/1024;	
            var ext=$(this)[0].files[0].type;
            if(ext=='application/pdf')
            {	if(file_size>200){ alert("Maximum file size is 200KB");  $(this).val(''); $(this).focus(); } }
            else
            { alert("Please upload PDF only"); $(this).val(''); $(this).focus();   }
        });
        
        $('#exam_qualified_upload').on('change',function(){	
            var file_size=$(this)[0].files[0].size/1024;	
            var ext=$(this)[0].files[0].type;
            if(ext=='application/pdf')
            {	if(file_size>200){ alert("Maximum file size is 200KB");  $(this).val(''); $(this).focus(); } }
            else
            { alert("Please upload PDF only"); $(this).val(''); $(this).focus();   }
        });
        
        $('#fellowship_upload').on('change',function(){	
            var file_size=$(this)[0].files[0].size/1024;	
            var ext=$(this)[0].files[0].type;
            if(ext=='application/pdf')
            {	if(file_size>200){ alert("Maximum file size is 200KB");  $(this).val(''); $(this).focus(); } }
            else
            { alert("Please upload PDF only"); $(this).val(''); $(this).focus();   }
        });      
        
        $('#domicile_certificate_id').on('change',function(){	
            var file_size=$(this)[0].files[0].size/1024;	
            var ext=$(this)[0].files[0].type;
            if(ext=='application/pdf')
            {	if(file_size>200){ alert("Maximum file size is 200KB");  $(this).val(''); $(this).focus();  } }
            else
            { alert("Please upload PDF only"); $(this).val(''); $(this).focus();  }
        });
        <!-- end of files validations -->
            
    });//end of ready function
	

</script>
<!-- include footer -->
@include('application.footer')