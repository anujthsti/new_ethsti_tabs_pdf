<!-- common sections variables start -->
<?php
    // variables for section header title
    $headerTitle = "Candidate Details";
    // variables for section buttons bar
    $createBtnTitle = "";
    $createBtnLink = "";
?>
<!-- common sections variables end -->

<x-app-layout>
    <!-- section header title html -->
    @include('layouts/header_title')

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

    <div class="container mt-2">
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
        $candidates_docs_path = config('app.candidates_docs_path');
        $master_data_ids = array_column($masterDataArr, 'id');
        // filter age categories by code from array
        // id 5 for age_category
        //print_r($masterDataArr);
        $ageCategories = Helper::getCodeNamesByCode($masterDataArr,'code','age_category');
        $ageCategoriesIds = array_column($ageCategories, 'id');
        $ageCategoriesCodes = array_column($ageCategories, 'meta_code');
        ?>
        <div class="col-lg-12">
            <?php
            /* 				
                $val_index = array_search($id, $_SESSION['nextids']);	
                $prev_index=$val_index-1;
                $next_index=$val_index+1;
                
                $prev_id=$_SESSION['nextids'][$prev_index];
                $next_id=$_SESSION['nextids'][$next_index];
                
                $size=sizeof($_SESSION['nextids']);
            */    
            ?>   
        </div>
        <!-- top bar start -->
        <div class="row p-3">	
            <div class="col-lg-5 col-md-5 text-left">
                <?php 
                if(isset($previousRec) && !empty($previousRec)){ 
                    $previousId = $previousRec->id;
                    $previousIdEnc = Helper::encodeId($previousId);
                ?>
                <a class="btn btn-success" href="<?php echo route('candidate_print', $previousIdEnc); ?>">Previous </a>
                <?php } ?>
                <?php 
                if(isset($nextRec) && !empty($nextRec)){ 
                    $nextId = $nextRec->id;
                    $nextIdEnc = Helper::encodeId($nextId);
                ?>
                <a class="btn btn-success" href="<?php echo route('candidate_print', $nextIdEnc); ?>">Next </a>
                <?php } ?>
            </div>

            <?php
                $shortlisting_status = $candidateApplyDetails[0]['shortlisting_status']; 
            ?>
            <?php 
            $remarksCodesIds = [];
            $hrRemarksCodes = "";
            if(isset($candidatesJobHRRemarks) && !empty($candidatesJobHRRemarks)){ 
                $codes = array_column($candidatesJobHRRemarks,'code');
                $remarksCodesIds = array_column($candidatesJobHRRemarks,'remarks_code_id');
                $hrRemarksCodes = implode(", ",$codes);   
            } 
            ?>
            <div class="col-lg-2 col-md-2 text-center">
                <?php if(!empty($shortlisting_status)){ ?>
                <a class="text-danger h3" href="#">
                    <?php 
                    if($shortlisting_status==2){ 
                        echo "Rejected <br>";
                        echo $hrRemarksCodes; 
                    }
                    else if($shortlisting_status==1){ 
                        echo 'Shortlisted'; 
                    }
                    else if($shortlisting_status==3){ 
                        echo 'Provisionally Shortlisted'; 
                    } 
                    ?>
                </a>
                <?php } ?>
            </div>

            <div class="col-lg-5 col-md-5 text-right">
                <a class="btn btn-primary" id="back_id" href="<?php echo route('candidate_list')."/".$rnNoEncId."/".$jobEncId; ?>">List<a>
                <input class="btn btn-primary" type="button" id="print_app" value="Print">
                <?php
                $is_after_payment_mail_sent = $candidateApplyDetails[0]['is_after_payment_mail_sent'];
                if($is_after_payment_mail_sent == 1){
                    $folderPath = config('app.candidates_details_pdf_doc_path');
                    $detailsFileName = $candidateApplyDetails[0]['details_pdf_name'];
                    $payReceiptFileName = $candidateApplyDetails[0]['pay_receipt_pdf_name'];
                    $profileFilePath = $folderPath . '/' . $detailsFileName;
                    $payReceiptFilePath  = $folderPath . '/' . $payReceiptFileName;
                    ?>
                    <a class="btn btn-primary text-light" target="_blank" href="<?php echo url($profileFilePath); ?>"> Profile PDF </a>
                    <a class="btn btn-primary text-light" target="_blank" href="<?php echo url($payReceiptFilePath); ?>"> Pay Receipt PDF </a>
                <?php
                }
                ?>
            </div>   
        </div>
        <!-- top bar end -->
        
        <?php
        $formAction = route("save_candidate_shortlisting", $job_apply_id_enc);
        ?>
        <!-- form html start -->
        <form method="post" name="candidate_print" id="candidate_print" action="<?php echo $formAction; ?>" class="border border-dark" >
            @csrf
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
                $nationality_type = "";
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
                /*echo "<pre>";
                print_r($candidateDetails);
                exit;*/
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
                if(isset($candidateApplyDetails) && !empty($candidateApplyDetails)){ 
                    $is_pwd = $candidateApplyDetails[0]['is_pwd']; 
                    $is_ex_serviceman = $candidateApplyDetails[0]['is_ex_serviceman'];
                    $is_esm_reservation_avail = $candidateApplyDetails[0]['is_esm_reservation_avail'];
                    $date_of_release = $candidateJobApplyDetail[0]['date_of_release'];
                    $is_govt_servent = $candidateApplyDetails[0]['is_govt_servent'];
                    $age = $candidateApplyDetails[0]['age_calculated'];
                    $category_id = $candidateApplyDetails[0]['category_id'];
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
                $grand_total_experience = $candidateApplyDetails[0]['total_experience'];
                $payment_status = $candidateApplyDetails[0]['payment_status']; 
                // candidate documents path
                $candidateJobApplyID = Helper::decodeId($job_apply_id_enc);
                $candidates_docs_path = config('app.candidates_docs_path');
                $candidates_docs_path .= "/".$candidateJobApplyID;
                                    
                ?>
                <?php
                $dob = $candidateDetails[0]['dob'];
                $age_limit_as_on_date = $candidateApplyDetails[0]['age_limit_as_on_date'];
                $is_pwd = $candidateApplyDetails[0]['is_pwd'];
                $age_limit = $candidateApplyDetails[0]['age_limit'];
                // age relaxation validation start
                $isCandidateOverAged = 0;
                // for pdf generating
                if(isset($isPDFGenerating) && $isPDFGenerating == 1){

                }
                else{
                    if(isset($age_limit_as_on_date) && !empty($age_limit_as_on_date) && !empty($age_limit)){
                        $ageYear = Helper::age_validate($dob, $age_limit_as_on_date);
                        $ageRelaxation = "";
                        //$ageCategories
                        //$ageCategoriesIds
                        //$jobAgeRelaxation
                        if($is_pwd == 1){
                            $categoryCode = "pwd";
                        }
                        /*
                        else if($categoryCode == "obc"){

                        }
                        else if($categoryCode == "ews"){

                        }
                        else if($categoryCode == "sc"){

                        }
                        else if($categoryCode == "st"){

                        }
                        */
                        if(isset($categoryCode) && !empty($categoryCode)){
                            $ageCategoryIdKey = array_search($categoryCode, $ageCategoriesCodes);
                            if(isset($ageCategories[$ageCategoryIdKey]['id'])){
                                $ageCategoryId = $ageCategories[$ageCategoryIdKey]['id'];
                                $ageCatValidationIds = array_column($jobAgeRelaxation, 'category_id');
                                if(in_array($ageCategoryId, $ageCatValidationIds)){
                                    $validationAgeKey = array_search($ageCategoryId, $ageCatValidationIds);
                                    $relaxationYear = $jobAgeRelaxation[$validationAgeKey]['years'];
                                    if(!empty($relaxationYear) && $relaxationYear > 0){
                                        $newAgeYear = $age_limit+$relaxationYear;
                                        if($ageYear >= $newAgeYear){
                                            $isCandidateOverAged = 1;
                                            ?>
                                            <!--<tr>
                                                <td colspan="3" align="left" valign="top">
                                                    <div class="col-lg-12 col-md-12 text-center">
                                                        <a class="text-danger h3" href="#">Over Aged</a>
                                                    </div>
                                                </td>
                                            </tr>-->
                                            
                                            <?php
                                        }
                                        /*else{
                                            echo "age_limit: ".$age_limit." -- newAgeYear: ".$newAgeYear;
                                        }*/
                                    }
                                }
                            }
                        }

                    }
                }
                // age relaxation validation end
                // min experience validation start
                //jobExperienceValidation
                // min experience validation end
                ?>
            <table border="0" align="center" cellpadding="0" cellspacing="0" id="print_form_id" class="table-sm">
                @include('hr_shortlisting.candidate_submitted_detail_header')
                
                @include('hr_shortlisting.candidate_submitted_personal_details')
                
                <!-- Academic details start -->
                @include('hr_shortlisting.candidate_submitted_academic_details')                        
                <!-- Academic details end -->

                <!-- Experience details start -->
                @include('hr_shortlisting.candidate_submitted_experience_detail')  
                <!-- Experience details end -->

                <!-- fellowship details start -->
                @include('hr_shortlisting.candidate_submitted_fellowship_detail') 
                <!-- fellowship details end -->
                  
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
     
                <!-- payment transaction details start -->
                @include('hr_shortlisting.candidate_payment_detail')
                <!-- payment transaction details end -->

                <!-- common documents start -->
                @include('hr_shortlisting.candidate_submitted_common_documents')                        
                <!-- common documents start -->

                <!-- declaration start -->
                <tr>
                    <td colspan="3" align="left" valign="top"><strong>Declaration:</strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <div align="justify" style="text-transform:upper">
                        I declare that I fulfil the eligibility conditions as per the advertisement and that all the statements made in this application are true, complete and correct to the best of my  knowledge and belief. I understand that in the event of any information being found false or incorrect at any stage or not satisfying the eligibility conditions according to the requirements mentioned in the advertisement, my candidature/ appointment is liable to be cancelled/ terminated.
                        </div>
                    </td>
                </tr>
                <!-- declaration end -->

                <!-- place & signature of candidate start -->
                <tr><td height="1" colspan="3"></td></tr>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="50%" align="left"><p><strong>Place:</strong></p></td>
                                <td width="50%">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="left">
                                    <strong>Date: <?php echo date('d-m-Y'); ?></strong>
                                </td>
                                <td align="right">
                                    <?php
                                    if(isset($candidatesCommonDocuments[0]['candidate_sign']) && !empty($candidatesCommonDocuments[0]['candidate_sign'])){
                                        $candidate_sign = $candidatesCommonDocuments[0]['candidate_sign'];
                                        $candidate_signPath = $candidates_docs_path."/".$candidate_sign;
                                        $candidate_signPath = url($candidate_signPath);
                                    ?>
                                        <img src="<?php echo $candidate_signPath; ?>" width="150" height="50"/><br>
                                    <?php } ?>
                                    <strong>Signature  of the candidate</strong>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- place & signature of candidate end -->

                <!-- admin/HR shortlisting section start -->
                <tr><td colspan="3"><hr /></td></tr>
                <tr style="background-color:#CCC;">
                    <td colspan="3"><span class="h4">Admin/HR Shortlisting</span></td>
                </tr>
                <tr><td colspan="3" align="left" valign="top"></td></tr>
                
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <div class="col-lg-12">
                            <label>Status: </label>
                            <select class="form-control col-lg-4" name="sl_status" id="sl_status">
                                <option value="">SELECT</option>
                                <option value="1" <?php if($shortlisting_status == 1){ echo "selected"; } ?>>SHORTLISTED</option>
                                <option value="3" <?php if($shortlisting_status == 3){ echo "selected"; } ?>>PROVISIONAL SHORTLISTED</option>
                                <option value="2" <?php if($shortlisting_status == 2){ echo "selected"; } ?>>REJECTED</option>
                            </select>
                        </div>
                    </td>
                </tr>            

                <tr style="display:none" id="rejected">
                    <td colspan="3" align="left">
                        <div class="form-group">
                            
                            <label class="col-lg-12">
                                HR Remarks : 
                                <?php if(!empty($hrRemarksCodes)){ ?>
                                    <span class="text-danger"><?php echo $hrRemarksCodes;?></span> 
                                <?php } ?>
                            </label>
                            
                            <select class="form-control col-lg-12" name="hr_remarks[]" id="hr_remarks" multiple  style="height:450px;"> 
                                <!-- general remarks start -->    
                                <option disabled="disabled" style="background-color: #CCC;">GENERAL REMARKS</option>
                                <?php
                                $generalRemarks = Helper::filterHRRemarksByValue($hRRemarks, "GENERAL");
                                foreach($generalRemarks as $generalRem){ 
                                    $selectedGen = "";
                                    if(!empty($remarksCodesIds) && in_array($generalRem['id'],$remarksCodesIds)){ 
                                        $selectedGen="selected"; 
                                    }
                                ?>
                                    <option value="<?php echo $generalRem['id']?>" <?php echo $selectedGen; ?> ><?php echo $generalRem['code']; ?> - <?php echo $generalRem['remarks_desc']; ?></option>        
                                <?php } ?>
                                <!-- general remarks end -->
                                <!-- PROVISIONAL remarks start -->
                                <option disabled="disabled" style="background-color: #CCC;">PROVISIONAL REMARKS</option>
                                <?php
                                $provisionalRemarks = Helper::filterHRRemarksByValue($hRRemarks, "PROVISIONAL");
                                foreach($provisionalRemarks as $provisionalRem){ 
                                    $selectedPro = "";
                                    if(!empty($remarksCodesIds) && in_array($provisionalRem['id'],$remarksCodesIds)){ 
                                        $selectedPro="selected"; 
                                    }
                                ?>
                                    <option value="<?php echo $provisionalRem['id']?>" <?php echo $selectedPro; ?> ><?php echo $provisionalRem['code']; ?> - <?php echo $provisionalRem['remarks_desc']; ?></option>        
                                <?php } ?>
                                <!-- PROVISIONAL remarks end -->
                                <!-- specific remarks start -->
                                <option disabled="disabled" style="background-color: #CCC;">SPECIFIC REMARKS</option>
                                <?php
                                $specificRemarks = Helper::filterHRRemarksByValue($hRRemarks, "SPECIFIC");
                                foreach($specificRemarks as $specificRem){ 
                                    $selectedSpec = "";
                                    if(!empty($remarksCodesIds) && in_array($specificRem['id'],$remarksCodesIds)){ 
                                        $selectedSpec="selected"; 
                                    }
                                ?>
                                    <option value="<?php echo $specificRem['id']?>" <?php echo $selectedSpec; ?> ><?php echo $specificRem['code']; ?> - <?php echo $specificRem['remarks_desc']; ?></option>        
                                <?php } ?>
                                <!-- specific remarks end -->
                            </select>        
                            </label>
                        </div>
                    </td>
                </tr>
                <!-- hr additional remarks start -->            
                <tr>
                    <td colspan="3">
                        <div class="col-lg-12">
                            <label class="">Any additional Remarks/ Note for candidates</label>
                            <textarea class="form-control" name="hr_add_remarks" id="hr_add_remarks"><?php echo $candidateApplyDetails[0]['hr_additional_remarks']; ?></textarea>
                        </div>
                    </td>
                </tr> 
                <!-- hr additional remarks end -->   
                               
                <!-- admin/HR shortlisting section end -->

                <!-- submit button start -->
                <tr>
                    <td colspan="3" align="center" >&nbsp;</td>
                </tr>
                
                <tr><td colspan="3" align="center" ><input class="btn btn-success" type="submit" name="submit" value="Update"></td></tr>
                <tr><td colspan="3">&nbsp;</td></tr>                    
                <!-- submit button end -->

            </table>
            &nbsp;<br>
            &nbsp;<br>     
            
        </form>
        <!-- form html end -->


    </div>

    <script>
        $(document).ready(function(){
	
            /*$('#print_app').click(function(){
                window.print();		
            });*/
            $('#print_app').click(function(){
                
                w=window.open();
                let html = "<html><body>"+$('#candidate_print').html()+"</body></html>";
                w.document.write(html);
                w.print();
                w.close();
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
   
</x-app-layout>    