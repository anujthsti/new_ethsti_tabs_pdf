<?php
if(isset($candidateJobApplyDetail) && !empty($candidateJobApplyDetail)){

  $candidateJobApplyArr = $candidateJobApplyDetail[0];
  $is_final_submit_after_payment = $candidateJobApplyArr['is_final_submit_after_payment'];
  $candidateJobFormUrl = route('edit_candidate_applied_job_details', $candidateJobApplyEncID);
  // basic information url start
  $basicInformationRouteUrl = "#";
  if($is_final_submit_after_payment == 0){
    $basicInformationRouteUrl = $candidateJobFormUrl;
  }
  //$basicInformationTabIdEnc = Helper::encodeId(1);  
  // basic information url end
  // qualification & experience information url start
  $qualificationTabIdEnc = Helper::encodeId(2);  
  $qualificationExperienceRouteUrl = "#";
  if($is_final_submit_after_payment == 0){
    $qualificationExperienceRouteUrl = $candidateJobFormUrl."/".$qualificationTabIdEnc;
  }
  // qualification & experience information url end
  // phd detail information url start
  $isPHDEduSelected = 0;
  if(isset($academicDetails) && !empty($academicDetails)){
    $educationIds = array_column($academicDetails, 'education_id');
    if(in_array(18, $educationIds)){
        $isPHDEduSelected = 1;
    }
  }
  $phdDetailsRouteUrl = "#";
  $phdTabIdEnc = Helper::encodeId(3);  
  $is_publication_tab = 0;
  if($candidateJobApplyArr['is_qualification_exp_done'] == 1 && $is_final_submit_after_payment == 0 && ($is_publication_tab == 1 || $isPHDEduSelected == 1)){
    $phdDetailsRouteUrl = $candidateJobFormUrl."/".$phdTabIdEnc;
  }
  // phd detail information url end
  // documents upload information url start
  $documentUploadRouteUrl = "#";
  $documentUploadTabIdEnc = Helper::encodeId(4);  
  if(($is_publication_tab == 1 && $candidateJobApplyArr['is_phd_details_done'] == 1 && $is_final_submit_after_payment == 0) || ($is_publication_tab == 0 && $candidateJobApplyArr['is_qualification_exp_done'] == 1 && $is_final_submit_after_payment == 0)){
    $documentUploadRoute = route('upload_candidate_documents', $candidateJobApplyEncID);
    $documentUploadRouteUrl = $documentUploadRoute."/".$documentUploadTabIdEnc;
  }
  // documents upload information url end
  // preview & final submit route start
  $finalSubmitRouteUrl = "#";
  $finalSubmitTabIdEnc = Helper::encodeId(5);  
  if($candidateJobApplyArr['is_document_upload_done'] == 1 && $is_final_submit_after_payment == 0){
    $finalSubmitRoute = route('preview_application_final_submit', $candidateJobApplyEncID);
    $finalSubmitRouteUrl = $finalSubmitRoute."/".$finalSubmitTabIdEnc;
  }
  // preview & final submit route end
  // checkout route start
  $checkoutPaymentRouteUrl = "#";
  $checkoutPaymentTabIdEnc = Helper::encodeId(6);  
  $checkoutTabTitle = "Payment";
  if($candidateJobApplyArr['is_final_submission_done'] == 1 && $is_final_submit_after_payment == 0){
    if(isset($candidateJobApplyArr['is_payment_done']) && $candidateJobApplyArr['is_payment_done'] == 1){
        $checkoutPaymentRoute = route('pay_receipt', $candidateJobApplyEncID);
        $checkoutPaymentRouteUrl = $checkoutPaymentRoute."/".$checkoutPaymentTabIdEnc;
        $checkoutTabTitle = "Payment Receipt";
    }else{
        $checkoutPaymentRoute = route('checkout', $candidateJobApplyEncID);
        $checkoutPaymentRouteUrl = $checkoutPaymentRoute."/".$checkoutPaymentTabIdEnc;
    }
    
  }
  // checkout route end
  // Final submission route start
  $finalSubmissionRouteUrl = "#";
  $finalSubmissionTabIdEnc = Helper::encodeId(7);  
  if($candidateJobApplyArr['is_payment_done'] == 1 && $is_final_submit_after_payment == 0){
        $finalSubmissionRouteUrl = route('final_submission_after_payment', $candidateJobApplyEncID);
        $finalSubmissionRouteUrl = $finalSubmissionRouteUrl."/".$finalSubmissionTabIdEnc;
  }
  // Final submission route end

    // basic info class start
    $basicInfoClass = "notcompleted";
    if($formTabIdEnc == ""){
        $basicInfoClass = "current";
    }
    else if($candidateJobApplyArr['is_basic_info_done'] == 1){
        $basicInfoClass = "completed";
    }
    // basic info class end
    // qualification & experience class start
    $qualificationExpClass = "notcompleted";
    if($formTabIdEnc == $qualificationTabIdEnc){
        $qualificationExpClass = "current";
    }
    else if($candidateJobApplyArr['is_qualification_exp_done'] == 1){
        $qualificationExpClass = "completed";
    }
    // qualification & experience class end
    // qualification & experience class start
    $phdDetailClass = "notcompleted";
    if($formTabIdEnc == $phdTabIdEnc){
        $phdDetailClass = "current";
    }
    else if($candidateJobApplyArr['is_phd_details_done'] == 1){
        $phdDetailClass = "completed";
    }
    // qualification & experience class end
    // document upload class start
    $documentUploadClass = "notcompleted";
    if($formTabIdEnc == $documentUploadTabIdEnc){
        $documentUploadClass = "current";
    }
    else if($candidateJobApplyArr['is_document_upload_done'] == 1){
        $documentUploadClass = "completed";
    }
    // document upload class end
    // preview & final submit class start
    $previewClass = "notcompleted";
    if($formTabIdEnc == $finalSubmitTabIdEnc){
        $previewClass = "current";
    }
    else if($candidateJobApplyArr['is_final_submission_done'] == 1){
        $previewClass = "completed";
    }
    // preview & final submit class end
    // payment class start
    $paymentClass = "notcompleted";
    if($formTabIdEnc == $checkoutPaymentTabIdEnc){
        $paymentClass = "current";
    }
    else if($candidateJobApplyArr['is_payment_done'] == 1){
        $paymentClass = "completed";
    }
    // payment class end
    // final submission class start
    $finalSubmissionClass = "notcompleted";
    if($formTabIdEnc == $finalSubmissionTabIdEnc){
        $finalSubmissionClass = "current";
    }
    else if($is_final_submit_after_payment == 1){
        $finalSubmissionClass = "completed";
    }
    // final submission class end
}
?>
<ul id="wizardStatus"> 
    <li class="<?php echo $basicInfoClass; ?>">
        <a href="<?php echo $basicInformationRouteUrl; ?>">Basic Information</a>
    </li>  
    <li class="<?php echo $qualificationExpClass; ?>">
        <a href="<?php echo $qualificationExperienceRouteUrl; ?>">Qualification & Experience</a>
    </li>  
    @if($is_publication_tab == 1 || $isPHDEduSelected == 1)  
    <li class="<?php echo $phdDetailClass; ?>">
        <a href="<?php echo $phdDetailsRouteUrl; ?>">Research Credentials</a>
    </li>
    @endif
    <li class="<?php echo $documentUploadClass; ?>">
        <a href="<?php echo $documentUploadRouteUrl; ?>">Documents Upload</a>
    </li>  
    
    <li class="<?php echo $previewClass; ?>">
        <a href="<?php echo $finalSubmitRouteUrl; ?>">Preview Application</a>
    </li>
    <li class="<?php echo $paymentClass; ?>">
        <a href="<?php echo $checkoutPaymentRouteUrl; ?>"><?php echo $checkoutTabTitle; ?></a>
    </li>
    <li class="<?php echo $finalSubmissionClass; ?>">
        <a href="<?php echo $finalSubmissionRouteUrl; ?>">Final Submission</a>
    </li>
</ul>
