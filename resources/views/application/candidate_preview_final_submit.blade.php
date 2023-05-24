<?php
$page_title = "Candidate Details";
?>
@include('application.header')
<!-- common sections variables start -->
<?php
    // variables for section header title
    $headerTitle = "Candidate Details";
    // variables for section buttons bar
    $createBtnTitle = "";
    $createBtnLink = "";
    // for phd
    $is_publication_tab = $jobValidations[0]['is_publication_tab'];
   
?>
<!-- common sections variables end -->
@include('application.application_head')
<div class="container-fluid">
    @include('application.dashboard_nav')
    <div class="container-fluid border-top pt-5">   
    
        <!-- candidate form steps --> 
        @include('application.candidate_form_steps') 

        <style>
            th {
                text-align: center !important;
            }
            .btn-success {
                color: #fff;
                background-color: #28a745;
                border-color: #28a745;
            }

        </style>

        <!-- success message alert html start -->
        @if ($message = Session::get('success'))
            <!-- include success message common view -->
            @include('layouts/success_message')
        @endif
        @if(session('error_msg'))
            <div class="alert alert-danger mb-1 mt-1">
                {{ session('error_msg') }}
            </div>
        @endif
        <?php
        $master_data_ids = array_column($masterDataArr, 'id');
        // filter age categories by code from array
        // id 5 for age_category
        //print_r($masterDataArr);
        $ageCategories = Helper::getCodeNamesByCode($masterDataArr,'code','age_category');
        $ageCategoriesIds = array_column($ageCategories, 'id');
        $ageCategoriesCodes = array_column($ageCategories, 'meta_code');
        ?>
        
        <!-- top bar start -->
        <div class="row p-3">	
            <div class="col-lg-5 col-md-5 text-left">
                
            </div>

            <div class="col-lg-2 col-md-2 text-center">
                
            </div>

            <div class="col-lg-5 col-md-5 text-right">
                <?php
                $folderPath = config('app.candidates_details_pdf_doc_path');
                if(isset($candidateJobApplyDetail[0]['details_pdf_name']) && !empty($candidateJobApplyDetail[0]['details_pdf_name'])){
                    $detailsFileName = $candidateJobApplyDetail[0]['details_pdf_name'];
                    $payReceiptFileName = $candidateJobApplyDetail[0]['pay_receipt_pdf_name'];
                    $profileFilePath = $folderPath . '/' . $detailsFileName;
                    $payReceiptFilePath  = $folderPath . '/' . $payReceiptFileName;
                ?>
                    <a class="btn btn-primary text-light" target="_blank" href="<?php echo url($profileFilePath); ?>"> Profile PDF </a>
                    <a class="btn btn-primary text-light" target="_blank" href="<?php echo url($payReceiptFilePath); ?>"> Pay Receipt PDF </a>
                <?php } ?>    
                <input class="btn btn-primary" type="button" id="print_app" value="Print">
            </div>   
        </div>
        <!-- top bar end -->
        
        <?php
        if(isset($final_submission_after_payment) && $final_submission_after_payment == 1){
            $formAction = route("save_final_submission_after_payment", $job_apply_id_enc);
            if(isset($formTabIdEnc) && !empty($formTabIdEnc)){
                $formAction .= "/".$formTabIdEnc;
            }
        }else{
            $formAction = route("application_final_submission", $job_apply_id_enc);
            if(isset($formTabIdEnc) && !empty($formTabIdEnc)){
                $formAction .= "/".$formTabIdEnc;
            }
        }
        ?>
        <!-- form html start -->
        <?php
        $full_name = "";
        $father_name = "";
        $mother_name = "";
        $dob = "";
        $age = "";
        $genderId = "";
        $gender = "";
        $category = "";
        $is_pwd = 0;
        $is_ex_serviceman = 0;
        $nationality = "";
        $correspondence_address = "";
        $cors_city = "";
        $cors_pincode = "";
        $cors_state_id = "";
        $corsState = "";
        $permanent_address = "";
        $perm_city = "";
        $perm_pincode = "";
        $perm_state_id = "";
        $permState = "";
        $mobile_no = "";
        $email_id = "";
        $grand_total_experience = "";
        $payment_status = "";
        $nationality_type = "";
        if(isset($candidateDetails) && !empty($candidateDetails)){
            $mobile_no = $candidateDetails[0]['mobile_no'];
            $email_id = $candidateDetails[0]['email_id']; 
            $full_name = $candidateDetails[0]['full_name'];
            $father_name = $candidateDetails[0]['father_name'];
            $mother_name = $candidateDetails[0]['mother_name'];
            $dob = $candidateDetails[0]['dob'];
            $genderId = $candidateDetails[0]['gender'];
            $nationality = $candidateDetails[0]['nationality'];
            $nationality_type = $candidateDetails[0]['nationality_type'];
            $correspondence_address = $candidateDetails[0]['correspondence_address'];
            $cors_city = $candidateDetails[0]['cors_city'];
            $cors_pincode = $candidateDetails[0]['cors_pincode'];
            $cors_state_id = $candidateDetails[0]['cors_state_id'];
            
            if(isset($cors_state_id) && !empty($cors_state_id)){
                $stateIdKey = array_search($cors_state_id, $master_data_ids);
                if(isset($masterDataArr[$stateIdKey]['code_meta_name'])){
                    $corsState = $masterDataArr[$stateIdKey]['code_meta_name'];
                }
            }
            $permanent_address = $candidateDetails[0]['permanent_address'];
            $perm_city = $candidateDetails[0]['perm_city'];
            $perm_pincode = $candidateDetails[0]['perm_pincode'];
            $perm_state_id = $candidateDetails[0]['perm_state_id'];
            if(isset($perm_state_id) && !empty($perm_state_id)){
                $permStateIdKey = array_search($perm_state_id, $master_data_ids);
                if(isset($masterDataArr[$permStateIdKey]['code_meta_name'])){
                    $permState = $masterDataArr[$permStateIdKey]['code_meta_name'];
                }
            }
        }
        $categoryCode = "";
        $is_payment_done = 0;
        if(isset($candidateJobApplyDetail) && !empty($candidateJobApplyDetail)){ 
            $is_payment_done = $candidateJobApplyDetail[0]['is_payment_done']; 
            $is_pwd = $candidateJobApplyDetail[0]['is_pwd']; 
            $is_ex_serviceman = $candidateJobApplyDetail[0]['is_ex_serviceman'];
            $is_esm_reservation_avail = $candidateJobApplyDetail[0]['is_esm_reservation_avail'];
            $is_govt_servent = $candidateJobApplyDetail[0]['is_govt_servent'];
            $age = $candidateJobApplyDetail[0]['age_calculated'];
            $category_id = $candidateJobApplyDetail[0]['category_id'];
            if(isset($category_id) && !empty($category_id)){
                $categoryIdKey = array_search($category_id, $master_data_ids);
                if(isset($masterDataArr[$categoryIdKey]['code_meta_name'])){
                    $category = $masterDataArr[$categoryIdKey]['code_meta_name'];
                    $categoryCode = $masterDataArr[$categoryIdKey]['code'];
                }
            }
        }
        if(isset($genderId) && !empty($genderId)){
            $genderIdKey = array_search($genderId, $master_data_ids);
            if(isset($masterDataArr[$genderIdKey]['code_meta_name'])){
                $gender = $masterDataArr[$genderIdKey]['code_meta_name'];
            }
        }
        $grand_total_experience = $candidateJobApplyDetail[0]['total_experience'];
        $payment_status = $candidateJobApplyDetail[0]['payment_status']; 
        // candidate documents path
        $candidateJobApplyID = Helper::decodeId($job_apply_id_enc);
        $candidates_docs_path = config('app.candidates_docs_path');
        $candidates_docs_path .= "/".$candidateJobApplyID;
        
        $dob = $candidateDetails[0]['dob'];
        $age_limit_as_on_date = $candidateJobApplyDetail[0]['age_limit_as_on_date'];
        $is_pwd = $candidateJobApplyDetail[0]['is_pwd'];
        // to bypass validations of age, education etc.
        // age relaxation validation start
        $isCandidateOverAged = 0;
        $isPDFGenerating = 1;
        $candidateApplyDetails = $candidateJobApplyDetail;
        ?>
        <form method="post" name="candidate_print" action="<?php echo $formAction; ?>" class="border border-dark" >
            @csrf
            <input type="text" name="final_submit" value="1" style="display:none;">
            <table border="0" align="center" cellpadding="0" cellspacing="0" id="print_form_id" class="table-sm">
                <!-- header -->
                @include('hr_shortlisting.candidate_submitted_detail_header')
                
                @include('hr_shortlisting.candidate_submitted_personal_details')
                
                <!-- Academic details start -->
                @include('hr_shortlisting.candidate_submitted_academic_details')                        
                <!-- Academic details end -->

                <!-- Experience details start -->
                @include('hr_shortlisting.candidate_submitted_experience_detail')  
                <!-- Experience details end -->

                <!-- publication details start -->
                @include('hr_shortlisting.candidate_submitted_publication_detail')  
                <!-- publication details end -->

                <!-- patent details start -->
                @include('hr_shortlisting.candidate_submitted_patent_detail')
                <!-- patent details end -->

                <!-- relation tab start -->
                @include('hr_shortlisting.candidate_submitted_relation_detail')   
                <!-- relation tab end -->

                <!-- reference tab start -->
                @include('hr_shortlisting.candidate_submitted_reference_detail')   
                <!-- reference tab end -->

                <!-- fellowship details start -->
                @include('hr_shortlisting.candidate_submitted_fellowship_detail') 
                <!-- fellowship details end -->
                       
                <!-- payment transaction details start -->
                @include('hr_shortlisting.candidate_payment_detail')
                <!-- payment transaction details end -->

                <!-- common documents start -->
                @include('hr_shortlisting.candidate_submitted_common_documents')                        
                <!-- common documents start -->
                
                <?php  
                $submitBtnTitle = "Proceed to Pay Now";
                if(isset($final_submission_after_payment) && $final_submission_after_payment == 1){
                    $submitBtnTitle = "Final Submit";
                ?>
                <!-- payment transaction details start -->
                @include('hr_shortlisting.candidate_payment_detail')
                <!-- payment transaction details end -->
                <!-- declaration start -->
                <tr>
                    <td colspan="3" align="left" valign="top"><strong>Declaration:</strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <div align="justify" style="text-transform:upper">
                        <input type="checkbox" id="declaration" name="declaration" value="1" required>
                        I declare that I fulfil the eligibility conditions as per the advertisement and that all the statements made in this application are true, complete and correct to the best of my  knowledge and belief. I understand that in the event of any information being found false or incorrect at any stage or not satisfying the eligibility conditions according to the requirements mentioned in the advertisement, my candidature/ appointment is liable to be cancelled/ terminated.
                        </div>
                    </td>
                </tr>
                <!-- declaration end -->
                <tr>
                    <td colspan="3" align="center" >&nbsp;</td>
                </tr>
                
                <tr>
                    <td colspan="3" align="center" valign="top"><strong>Note: You will not be able to update any detail after final submit.</strong></td>
                </tr>
                <!-- submit button start -->
                <?php } ?>
                
                <tr><td colspan="3" align="center" ><input class="btn btn-success" type="submit" name="submit" value="<?php echo $submitBtnTitle; ?>"></td></tr>
                <tr><td colspan="3">&nbsp;</td></tr>                    
                <!-- submit button end -->

            </table>
            
            &nbsp;<br>
            &nbsp;<br>     
            
        </form>
        <!-- form html end -->


    </div>
</div>
    <script>
        $(document).ready(function(){
	
            $('#print_app').click(function(){
                window.print();		
            });
            $('#back_id').click(function(){
                    
            });
            
            $('#print_app').click(function(){

                var thePopup = window.open( '', "Print Table", "menubar=0,location=0,height=500,width=900" );
                $('#print_tab').clone().appendTo( thePopup.document.body );
                thePopup.print();
            });	
	

            $('#sl_status').change(function(){	
                
                $('#hr_remarks').val('');				
                $('#members').val('');
                $('#apl_cat').val('');
                
                $('.shortlisted').hide();
                $('#rejected').hide();
                $('.provisional').hide();
                        
                if($('#sl_status').val() == '1')
                { $('.shortlisted').show(); }
                else if($('#sl_status').val() == '2')
                { $('#rejected').show(); }
                else if($('#sl_status').val() == '3')
                { $('#rejected').show();   }
                
            });
	
            $('#sl_status').trigger('change');
            
            if($('#sl_status').val() == '1'){ 
                $('.shortlisted').show();	 
            }
            else if($('#sl_status').val() == '2'){ 
                $('#rejected').show();     
            }
            else if($('#sl_status').val() == '3'){ 
                $('#rejected').show();    
            }			
	

            $('#member_st').change(function(){	
                $('#member_remarks_sel').val('');
                $('#member_remarks_rej').val('');						
                        
                if($('#member_st').val() == '1')
                { 
                    $('#member_rejected').hide();
                    $('#member_shortlisted').show();	
                }
                else if($('#member_st').val() == '2')
                { 
                    $('#member_shortlisted').hide();
                    $('#member_rejected').show();	
                }	
            });
  

            if($('#member_st').val() == '1'){  
                $('#member_shortlisted').show();  
            }
            else if($('#member_st').val() == '2'){  
                $('#member_rejected').show();	 
            }
            else if($('#member_st').val() == '3'){  
                $('#member_rejected').show();	 
            }
                    

            //show faculty remarks
            $('#show_faculty').click(function(){
                
                if($('#show_faculty').is(':checked')){ 
                    $('#faculty_remarks').show(); 
                }
                else{ 
                    $('#faculty_remarks').hide(); 
                }
            
            });

        });
 
    </script>