<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Candidate Details</title>
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
</head>
<body>
    
    <div class="container mt-2">
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
            
        </div>
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

                
            </table>
            &nbsp;<br>
            &nbsp;<br>     
            
       
    </div>

    </body>
    </html>    