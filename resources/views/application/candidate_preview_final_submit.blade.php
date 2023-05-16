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
                <input class="btn btn-primary" type="button" id="print_app" value="Print">
            </div>   
        </div>
        <!-- top bar end -->
        
        <?php
        $formAction = route("application_final_submission", $job_apply_id_enc);
        if(isset($formTabIdEnc) && !empty($formTabIdEnc)){
            $formAction .= "/".$formTabIdEnc;
        }
        ?>
        <!-- form html start -->
        <form method="post" name="candidate_print" action="<?php echo $formAction; ?>" class="border border-dark" >
            @csrf
            <table border="0" align="center" cellpadding="0" cellspacing="0" id="print_form_id" class="table-sm">
                <!--
                <tr>
                    <td colspan="3" align="center" valign="top">
                        <img class="img img-thumbnail" src="{{ asset('thsti-logo-vertical.jpg') }}" width="100" height="100" />
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center" valign="top">
                        <span style="font-size:24px;">
                            <strong>TRANSLATIONAL HEALTH SCIENCE  AND TECHNOLOGY INSTITUTE</strong>
                        </span>
                        <br />
                        <span class="span" style="font-size:13x;">(An Autonomous Institute of the  Department of Biotechnology, Govt. of India)</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center" valign="top"><h3 class="h3">Online Registration Form</h3></td>
                </tr>
                -->
                <tr>
                    <td width="29%" align="left" valign="top">
                        <strong>POST APPLIED FOR IN DOMAIN:</strong>
                    </td>
                    <td width="32%" align="left" valign="top">

                        <?php
                        // post title
                        if(isset($jobDetails[0]['post_id']) && !empty($jobDetails[0]['post_id'])){
                            $post_id = $jobDetails[0]['post_id'];
                            $postIdKey = array_search($post_id, $master_data_ids);
                            if(isset($masterDataArr[$postIdKey]['code_meta_name'])){
                                $postTitle = $masterDataArr[$postIdKey]['code_meta_name'];
                                echo $postTitle;
                            }        
                        }
                        // domain name
                        if(isset($candidateApplyDetails[0]['domain_id']) && !empty($candidateApplyDetails[0]['domain_id'])){
                            $domainIdKey = array_search($candidateApplyDetails[0]['domain_id'], $master_data_ids);
                            if(isset($masterDataArr[$domainIdKey]['code_meta_name'])){
                                $domainName = $masterDataArr[$domainIdKey]['code_meta_name'];
                                echo "(".$domainName.")";
                            }
                        }
                        ?>
                        
                    </td>
                    <td width="39%" align="right" valign="top"><strong>RN No. </strong><?php echo $jobDetails[0]['rn_no']; ?></td>
                </tr>
                <?php 
                // method of appointment start
                if(isset($candidateApplyDetails[0]['appointment_method_id']) && !empty($candidateApplyDetails[0]['appointment_method_id'])){ 
                    $appointment_method_id = $candidateApplyDetails[0]['appointment_method_id'];
                    $appointmentMethodIdKey = array_search($appointment_method_id, $master_data_ids);
                    if(isset($masterDataArr[$appointmentMethodIdKey]['code_meta_name'])){
                        $appointmentMethod = $masterDataArr[$appointmentMethodIdKey]['code_meta_name'];
                        ?>
                        <tr>
                            <td align="left" valign="top"><strong>METHOD OF APPOINTMENT:</strong>
                            <td colspan="2" align="left" valign="top"><?php echo $appointmentMethod; ?></td>
                        </tr>
                        <?php 
                    }
                } 
                // method of appointment end
                ?>

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
                
                $dob = $candidateDetails[0]['dob'];
                $age_limit_as_on_date = $candidateApplyDetails[0]['age_limit_as_on_date'];
                $is_pwd = $candidateApplyDetails[0]['is_pwd'];
                
                ?>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="left" valign="top">
                                    <table width="100%" border="0" cellspacing="1" cellpadding="4">
                                        <tr>
                                            <td width="215">FULL NAME</td>		
                                            <td colspan="5" ><?php echo $full_name; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td width="215">FATHER&rsquo;S NAME</td>		 
                                            <td colspan="5" ><?php echo $father_name; ?></td>
                                            </tr>
                                        <tr>
                                            <td width="215">MOTHER&rsquo;S NAME</td>		  
                                            <td colspan="5" ><?php echo $mother_name; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td width="215">DATE OF BIRTH</td>		
                                            <td colspan="5" >
                                                <?php
                                                if(!empty($dob)){
                                                    echo Helper::convertDateYMDtoDMY($dob);
                                                ?>
                                                    &nbsp; (<?php echo $age; ?>)
                                                <?php } ?>    
                                            </td>
                                        </tr>      
                                        <tr>
                                            <td width="215">GENDER</td>		
                                            <td colspan="5">
                                                <?php echo $gender; ?>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td align="left">Category </td>
                                            <td colspan="3" align="left">
                                                <?php echo $category; ?>&nbsp; 
                                                <?php 
                                                if($category != "GEN"){
                                                    $categoryCertPath = "";
                                                    if(isset($candidatesCommonDocuments[0]['category_certificate']) && !empty($candidatesCommonDocuments[0]['category_certificate'])){
                                                        $categoryCert = $candidatesCommonDocuments[0]['category_certificate'];
                                                        $categoryCertPath = $candidates_docs_path."/".$categoryCert;
                                                        $categoryCertPath = url($categoryCertPath);
                                                    }
                                                    if(!empty($categoryCertPath)){
                                                       ?>
                                                       <a class='btn btn-primary' target="_blank" href="<?php echo $categoryCertPath; ?>" title="View File"><i class="fa fa-eye"></i></a>
                                                       <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left">Person with disability?</td>
                                            <td colspan="3" align="left">
                                                <input <?php if($is_pwd==0){echo "checked='checked'";}else{echo "disabled='disabled'";} ?> type="radio" readonly="readonly"/>No&nbsp;
                                                <input <?php if($is_pwd==1){echo "checked='checked'";}else{echo "disabled='disabled'";} ?> type="radio" readonly="readonly" />Yes&nbsp; 
                                                <?php 
                                                if($is_pwd == 1){
                                                    $pwdCertPath = "";
                                                    if(isset($candidatesCommonDocuments[0]['pwd_certificate']) && !empty($candidatesCommonDocuments[0]['pwd_certificate'])){
                                                        $pwdCert = $candidatesCommonDocuments[0]['pwd_certificate'];
                                                        $pwdCertPath = $candidates_docs_path."/".$pwdCert;
                                                        $pwdCertPath = url($pwdCertPath);
                                                    }
                                                    if(!empty($pwdCertPath)){
                                                    ?>
                                                        <a class='btn btn-primary' target="_blank" href="<?php echo $pwdCertPath; ?>" title="View File"><i class="fa fa-eye"></i></a>
                                                        <br />
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left">Ex-Servicemen?</td>
                                            <td colspan="3" align="left">
                                                <input <?php if($is_ex_serviceman==0){echo "checked='checked'";} else{echo "disabled='disabled'";} ?> type="radio"  readonly="readonly" />No&nbsp;
                                                <input <?php if($is_ex_serviceman==1){echo "checked='checked'";} else{echo "disabled='disabled'";} ?> type="radio"  readonly="readonly" />Yes
                                                <?php 
                                                if($is_ex_serviceman == 1){
                                                    $exServicemanCertPath = "";
                                                    if(isset($candidatesCommonDocuments[0]['esm_certificate']) && !empty($candidatesCommonDocuments[0]['esm_certificate'])){
                                                        $exServicemanCert = $candidatesCommonDocuments[0]['esm_certificate'];
                                                        $exServicemanCertPath = $candidates_docs_path."/".$exServicemanCert;
                                                        $exServicemanCertPath = url($exServicemanCertPath);
                                                    }
                                                    if(!empty($exServicemanCertPath)){
                                                    ?>
                                                        <a class='btn btn-primary' target="_blank" href="<?php echo $exServicemanCertPath; ?>" title="View File"><i class="fa fa-eye"></i></a>
                                                        <br />
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php if($is_ex_serviceman == 1){ ?>
                                        <tr>
                                            <td align="left">Have you avail the reservation available to ESM in civil side?</td>
                                            <td colspan="3" align="left">
                                                <input <?php if($is_esm_reservation_avail==0){echo "checked='checked'";} else{echo "disabled='disabled'";} ?> type="radio"  readonly="readonly" />No&nbsp;
                                                <input <?php if($is_esm_reservation_avail==1){echo "checked='checked'";} else{echo "disabled='disabled'";} ?> type="radio"  readonly="readonly" />Yes
                                            </td>
                                        </tr>
                                        <?php } ?>   
                                        <tr>
                                            <td align="left">Are you a govt. servent?</td>
                                            <td colspan="3" align="left">
                                                <input <?php if($is_govt_servent==0){echo "checked='checked'";} else{echo "disabled='disabled'";} ?> type="radio"  readonly="readonly" />No&nbsp;
                                                <input <?php if($is_govt_servent==1){echo "checked='checked'";} else{echo "disabled='disabled'";} ?> type="radio"  readonly="readonly" />Yes
                                            </td>
                                        </tr>  
                                        <?php
                                        if($is_govt_servent == 1){
                                            $type_of_employment = $candidateApplyDetails[0]['type_of_employment'];  
                                            $type_of_employer = $candidateApplyDetails[0]['type_of_employer'];  
                                            ?>
                                            <tr>
                                                <td align="left">Type of employment</td>
                                                <td colspan="3" align="left">
                                                    <?php
                                                    if($type_of_employment == 1){
                                                        echo "Permanent";
                                                    }
                                                    else if($type_of_employment == 2){
                                                        echo "Temporary";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td align="left">Type of employer</td>
                                                <td colspan="3" align="left">
                                                    <?php
                                                    if(isset($type_of_employer) && !empty($type_of_employer)){
                                                        $type_of_employerIdKey = array_search($type_of_employer, $master_data_ids);
                                                        if(isset($masterDataArr[$type_of_employerIdKey]['code_meta_name'])){
                                                            $type_of_employer_name = $masterDataArr[$type_of_employerIdKey]['code_meta_name'];
                                                            echo $type_of_employer_name;
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        
                                        <tr>
                                            <td width="215">NATIONALITY</td>		 
                                            <td colspan="5" >
                                                <?php 
                                                if($nationality_type == 1){
                                                    echo "India";
                                                }else{
                                                    echo $nationality;
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="215">ADDRESS CORRESPONDENCE</td>	
                                            <td colspan="5" ><?php echo $correspondence_address; ?>  &nbsp;  <?php echo $cors_city; ?>,&nbsp;<?php echo $corsState; ?> - <?php echo $cors_pincode; ?> </td>
                                        </tr>
                                        <tr>
                                            <td width="215">ADDRESS PERMANENT</td>		
                                            <td colspan="5" ><?php echo $permanent_address; ?>  &nbsp; <?php echo $perm_city; ?>,&nbsp;<?php echo $permState; ?> - <?php echo $perm_pincode; ?></td>
                                        </tr>
                                    
                                        <tr>
                                            <td width="215">MOBILE NO</td>		 
                                            <td width="154" ><?php echo $mobile_no; ?></td>		
                                            <td width="119" align="left" >EMAIL ID</td>		
                                            <td width="246" ><?php echo $email_id; ?></td>
                                        </tr>
                                    </table>
                                </td>
                                <!-- candidate photo start -->
                                <td valign="top">
                                    <table width="138" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="160" height="160" align="center" valign="middle" style="border: solid 1px #000;">
                                                <?php
                                                if(!empty($candidatesCommonDocuments[0]['candidate_photo'])){
                                                    $candidate_photo = $candidatesCommonDocuments[0]['candidate_photo'];
                                                    $candidate_photoPath = $candidates_docs_path."/".$candidate_photo;
                                                    $candidate_photoPath = url($candidate_photoPath);
                                                ?>
                                                    <img src="<?php echo $candidate_photoPath; ?>" width="130" height="158"/>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>                
                                <!-- candidate photo end -->
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <!-- Academic details start -->
                <tr style="background-color:#CCC;">
                    <td colspan="3" align="left" valign="top">
                        <strong>ACADEMIC/ PROFESSIONAL QUALIFICATION</strong>
                    </td>
                </tr>      
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <table class="table table-bordered table-hover" width="100%" border="1" cellpadding="0" cellspacing="0">
                            <tr>
                                <th align="center">Name of Examination</th>
                                <th colspan="2" align="center">Month & Year of Passing</th>
                                <th align="center">Duration of course (Year)</th>
                                <th align="center">Subjects</th>
                                <th align="center">Board/ University</th>
                                <th align="center">%(Round Off)</th>
                                <th align="center">CGPA</th>
                                <th align="center">Division</th>
                                <th align="center">Files</th>
                            </tr>
                            <?php    
                            if(isset($candidateAcademicsDetails) && !empty($candidateAcademicsDetails)){
                                
                                foreach($candidateAcademicsDetails as $academicDetails){   
                                    
                                    $educationName = "";
                                    // education name
                                    $education_id = $academicDetails['education_id'];
                                    $educationIdKey = array_search($education_id, $master_data_ids);
                                    if(isset($masterDataArr[$educationIdKey]['code_meta_name'])){
                                        $educationName = $masterDataArr[$educationIdKey]['code_meta_name'];
                                    }
                                    
                                    // month passed
                                    $monthName = "";
                                    if(isset($academicDetails['month']) && !empty($academicDetails['month'])){
                                        $month = $academicDetails['month'];
                                        $monthName = Helper::getMonthName($month);
                                    }
                                    // year
                                    $year = $academicDetails['year'];
                                    // duration_of_course
                                    $duration_of_course = $academicDetails['duration_of_course'];
                                    // degree_or_subject
                                    $degree_or_subject = $academicDetails['degree_or_subject'];
                                    // board_or_university
                                    $board_or_university = $academicDetails['board_or_university'];
                                    // percentage
                                    $percentage = $academicDetails['percentage'];
                                    // cgpa
                                    $cgpa = $academicDetails['cgpa'];
                                    // division
                                    $division = $academicDetails['division'];
                                    // documents
                                    $eduDocumentPath = "";
                                    
                                    if(isset($candidatesAcademicsDocuments) && !empty($candidatesAcademicsDocuments)){

                                        $documentName = "";
                                        $documentsIds = array_column($candidatesAcademicsDocuments,'education_id');
                                        
                                        $educationDocIdKey = array_search($education_id, $documentsIds);
                                        if(isset($candidatesAcademicsDocuments[$educationDocIdKey]['file_name'])){
                                            $documentName = $candidatesAcademicsDocuments[$educationDocIdKey]['file_name'];
                                            $eduDocumentPath = $candidates_docs_path."/".$documentName;
                                            $eduDocumentPath = url($eduDocumentPath);
                                        }

                                    }

                                    
                                ?>
                                <tr>
                                    <td align="center"><?php echo $educationName; ?></td>
                                    <td align="center"><?php echo $monthName; ?></td>
                                    <td align="center"><?php echo $year; ?></td>
                                    <td align="center"><?php echo $duration_of_course; ?></td>
                                    <td align="center"><?php echo $degree_or_subject; ?></td>
                                    <td align="center"><?php echo $board_or_university; ?></td>
                                    <td align="center"><?php echo $percentage; ?></td>
                                    <td align="center"><?php echo $cgpa; ?></td>
                                    <td align="center"><?php echo $division; ?></td>
                                    <td align="center">
                                        <?php if(!empty($eduDocumentPath)){ ?>
                                        <a class="btn btn-primary" target="_blank" title="View File" href="<?php echo $eduDocumentPath; ?>"><i class="fa fa-eye"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>      
                            <?php }
                            }
                            ?>
                        </table>
                    </td>
                </tr>                          
                <!-- Academic details end -->

                <!-- Experience details start -->
                <?php if(isset($candidatesExperienceDetails) && !empty($candidatesExperienceDetails)){ ?>
                <tr style="background-color:#CCC;">
                    <td colspan="3" align="left" valign="top">
                        <strong>EXPERIENCE Details</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <table class="table table-bordered table-hover"  width="100%" border="1" cellspacing="0" cellpadding="0">
                            <tr>
                                <td colspan="2" align="center" valign="top"><strong>Period of Employment</strong></td>
                                <td rowspan="2" align="center" valign="top"><strong>Total experience</strong></td>
                                <td rowspan="2" align="center" valign="top"><strong>Designation</strong></td>
                                <td rowspan="2" align="center" valign="top"><strong>Name of the Organisation</strong></td>
                                <td rowspan="2" align="center" valign="top"><strong>Nature of duties</strong></td>
                                <td colspan="2" align="center"><strong>Salary per Month(INR)</strong></td>
                                <td rowspan="2" align="center"><strong>Files</strong></td>
                            </tr>      
                            <tr>
                                <td align="center"><strong>From </strong></td>
                                <td align="center"><strong>To</strong></td>
                                <td  align="center" valign="top"><strong>Pay Level </strong><br />(if any)</td>
                                <td align="center" valign="top"><strong>Gross Pay </strong></td>
                            </tr>
                            
                            <?php    
                            foreach($candidatesExperienceDetails as $experienceDetails){   
                                $experience_id = $experienceDetails['id'];
                                $from_date = $experienceDetails['from_date'];
                                $from_date = Helper::convertDateYMDtoDMY($from_date);
                                $to_date = $experienceDetails['to_date'];
                                $to_date = Helper::convertDateYMDtoDMY($to_date);
                                $total_experience = $experienceDetails['total_experience'];
                                $designation = $experienceDetails['designation'];
                                $organization_name = $experienceDetails['organization_name'];
                                $nature_of_duties = $experienceDetails['nature_of_duties'];
                                $pay_level = $experienceDetails['pay_level'];
                                $gross_pay = $experienceDetails['gross_pay'];
                                // documents
                                $experienceDocumentPath = "";
                                    
                                if(isset($candidatesExperienceDocuments) && !empty($candidatesExperienceDocuments)){

                                    $expDocumentName = "";
                                    $expDocumentsIds = array_column($candidatesExperienceDocuments,'candidate_experience_detail_id');
                                    //print_r($expDocumentsIds);
                                    //exit;
                                    $expDocIdKey = array_search($experience_id, $expDocumentsIds);
                                    if(isset($candidatesExperienceDocuments[$expDocIdKey]['file_name'])){
                                        $expDocumentName = $candidatesExperienceDocuments[$expDocIdKey]['file_name'];
                                        $experienceDocumentPath = $candidates_docs_path."/".$expDocumentName;
                                        $experienceDocumentPath = url($experienceDocumentPath);
                                    }

                                }
                                
                            ?>       
                                <tr>
                                    <td align="center"><?php echo $from_date; ?></td>
                                    <td align="center"><?php echo $to_date; ?></td>              
                                    <td align="center"><?php echo $total_experience; ?></td>
                                    <td align="center"><?php echo $designation; ?></td>
                                    <td align="center"><?php echo $organization_name; ?></td>
                                    <td align="center"><?php echo $nature_of_duties; ?></td>
                                    <td align="center"><?php echo $pay_level; ?></td>
                                    <td align="center"><?php echo $gross_pay; ?></td>
                                    <td align="center"><a target="_blank" href="<?php echo $experienceDocumentPath; ?>" title="View File" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                                </tr>
                            <?php  } ?>
                            <tr>
                                <td colspan='2' align="center">Grand Total</td>      
                                <td align="center"><?php echo $grand_total_experience; ?></td>
                                <td colspan='5'></td>
                            </tr>
                        </table>      
                    </td>
                </tr>
                <?php } ?>
                <!-- Experience details end -->

                <!-- publication details start -->
                
                <?php if(isset($candidatesPublicationsDetails) && !empty($candidatesPublicationsDetails)){?>
                <tr style="background-color:#CCC;">
                    <td colspan="3" align="left" valign="top"><strong>Publication/s Details</strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <table class="table table-bordered table-hover"  width="100%" border="1" cellpadding="0" cellspacing="0">
                            <tr>
                                <th>Select Number in Publication</th>
                                <th>List of authors</th>
                                <th>Title of the article</th>
                                <th>Journal name</th>
                                <th>Year/Volume(Issue)</th>        
                                <th>Doi</th>        
                                <th>PubMed PMID</th>        
                            </tr>
                            <?php    
                            foreach($candidatesPublicationsDetails as $publicationDetails){   
                            ?>     
                            <tr>
                                <td align="center"><?php echo $publicationDetails['publication_number']; ?></td>
                                <td align="center"><?php echo $publicationDetails['authors']; ?></td>
                                <td align="center"><?php echo $publicationDetails['article_title']; ?></td>
                                <td align="center"><?php echo $publicationDetails['journal_name']; ?></td>
                                <td align="center"><?php echo $publicationDetails['year_volume']; ?></td>
                                <td align="center"><?php echo $publicationDetails['doi']; ?></td>
                                <td align="center"><?php echo $publicationDetails['pubmed_pmid']; ?></td>
                            </tr>  
                            <?php } ?>
                        
                        </table>
                        
                    </td>
                </tr>
                <?php } ?>
                <!-- publication details end -->

                <!-- patent details start -->
                <?php if(isset($candidatesPHDResearchDetails) && !empty($candidatesPHDResearchDetails)){?>
                <tr>
                    <td colspan="3" align="left" valign="top">&nbsp;</td>
                </tr> 
                    <?php if(isset($candidatesPHDResearchDetails[0]['patent_information']) && !empty($candidatesPHDResearchDetails[0]['patent_information'])){?>
                    <!-- patent informations start -->
                    <tr>
                        <td colspan="3" align="left">
                            <div style="background-color:#CCC;">
                                <strong>Patent/s</strong>
                            </div>
                            <?php echo $candidatesPHDResearchDetails[0]['patent_information']?>
                        </td>
                    </tr>
                    <!-- patent informations end -->
                    <?php } ?>
                    <?php if(isset($candidatesPHDResearchDetails[0]['research_statement']) && !empty($candidatesPHDResearchDetails[0]['research_statement'])){?>
                        <!-- Research Statement start -->
                        <tr><td colspan="3" align="left" valign="top">&nbsp;</td></tr> 
                        <tr>
                            <td colspan="3" align="left">
                                <div style="background-color:#CCC;">
                                    <strong>Research statement</strong>
                                </div>
                                <?php echo $candidatesPHDResearchDetails[0]['research_statement']; ?>
                            </td>
                        </tr>
                        <!-- Research Statement end -->
                    <?php } ?>

                <?php } ?>
                <!-- patent details end -->

                <!-- relation tab start -->
                <?php if(!empty($candidateApplyDetails)){?>
                <tr style="background-color:#CCC;">
                    <td colspan="3" align="left" valign="top"><strong>Do you have any near relative/friend working in THSTI. If so, please state ?</strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <table class="table table-bordered table-hover"  width="100%" border="1" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="30%" align="center"><strong>Name of the person(s)</strong></td>
                                <td width="30%" align="center"><strong>Designation</strong></td>
                                <td width="40%" align="center"><strong>Relationship with the candidate</strong></td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <?php
                                    if(isset($candidateApplyDetails[0]['relative_name']) && !empty($candidateApplyDetails[0]['relative_name'])){
                                        echo $candidateApplyDetails[0]['relative_name'];
                                    }
                                    ?>
                                </td>
                                <td align="center">
                                    <?php
                                    if(isset($candidateApplyDetails[0]['relative_designation']) && !empty($candidateApplyDetails[0]['relative_designation'])){
                                        echo $candidateApplyDetails[0]['relative_designation'];
                                    }
                                    ?>
                                </td>
                                <td align="center">
                                    <?php
                                    if(isset($candidateApplyDetails[0]['relative_relationship']) && !empty($candidateApplyDetails[0]['relative_relationship'])){
                                        echo $candidateApplyDetails[0]['relative_relationship'];
                                    }
                                    ?>
                                </td>
                            </tr>    
                        </table>
                    </td>
                </tr>
                <?php } ?>        
                <!-- relation tab end -->

                <!-- reference tab start -->
                <?php if(isset($candidatesRefreeDetails) && !empty($candidatesRefreeDetails)){?>
                <tr style="background-color:#CCC;">
                    <td colspan="3" align="left" valign="top"><strong>Name of the Referee/s</strong><strong></strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <table class="table table-bordered table-hover" width="100%" border="1" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="24%" align="center" valign="top"><strong>Name of Refree</strong></td>
                                <td width="16%" align="center" valign="top"><strong>Designation</strong></td>
                                <td width="16%" align="center" valign="top"><strong>Organisation</strong></td>
                                <td width="18%" align="center" valign="top"><strong>Email Id</strong></td>
                                <td width="14%"  align="center" valign="top"><strong>Phone No</strong></td>
                                <td width="12%" align="center" valign="top"><strong>Mobile No</strong></td>
                            </tr>
                            <?php    
                            foreach($candidatesRefreeDetails as $refreeDetails){   
                            ?>       
                            <tr>
                                <td align="center"><?php echo $refreeDetails['refree_name']; ?></td>
                                <td align="center"><?php echo $refreeDetails['designation']; ?></td>
                                <td align="center"><?php echo $refreeDetails['organisation']; ?></td>
                                <td align="center"><?php echo $refreeDetails['email_id']; ?></td>
                                <td align="center"><?php echo $refreeDetails['phone_no']; ?></td>
                                <td align="center"><?php echo $refreeDetails['mobile_no']; ?></td>
                            </tr>
                            <?php } ?>
                        </table>      
                    </td>
                </tr>
                <?php } ?>
                <!-- reference tab end -->

                <!-- fellowship details start -->
                <?php if(isset($candidatesPHDResearchDetails[0]['funding_agency']) && !empty($candidatesPHDResearchDetails[0]['funding_agency'])){?>
                    <tr style="background-color:#CCC;">
                        <td colspan="3" align="left" valign="top"><strong>Fellowship Details</strong><strong></strong></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" valign="top">
                            <table width="100%" border="1" cellpadding="0" cellspacing="0" class="table table-bordered table-hover" >
                                <tr>
                                    <th align="center">Funding Agency</th>
                                    <th align="center">Rank</th>
                                    <th align="center">Admission Test</th>
                                    <th align="center">Validity Up To</th>
                                    <th align="center">Document</th>               
                                </tr>
                                <?php
                                $fellowshipCertPath = "";
                                if(isset($candidatesCommonDocuments[0]['fellowship_certificate']) && !empty($candidatesCommonDocuments[0]['fellowship_certificate'])){
                                    $fellowship_certificate = $candidatesCommonDocuments[0]['fellowship_certificate'];
                                    $fellowshipCertPath = $candidates_docs_path."/".$fellowship_certificate;
                                    $fellowshipCertPath = url($fellowshipCertPath);
                                }
                                $fellowship_valid_up_to = "";
                                if(isset($candidatesPHDResearchDetails[0]['fellowship_valid_up_to']) && !empty($candidatesPHDResearchDetails[0]['fellowship_valid_up_to'])){
                                    $fellowship_valid_up_to = $candidatesPHDResearchDetails[0]['fellowship_valid_up_to'];
                                    $fellowship_valid_up_to = Helper::convertDateYMDtoDMY($fellowship_valid_up_to);
                                }
                                ?>
                                <tr>
                                    <td align="center"><?php echo $candidatesPHDResearchDetails[0]['funding_agency']; ?></td>
                                    <td align="center"><?php echo $candidatesPHDResearchDetails[0]['rank']; ?></td>
                                    <td align="center"><?php echo $candidatesPHDResearchDetails[0]['admission_test']; ?></td>
                                    <td align="center"><?php echo $fellowship_valid_up_to; ?></td>
                                    <td align="center"><a class="btn btn-primary" target="_new" href="<?php echo $fellowshipCertPath; ?>" title="View File"><i class="fa fa-eye"></i></a></td>
                                </tr>    
                            </table>
                        </td>
                    </tr>  
                    <!-- fellowship activation details start -->            
                    <?php if(isset($candidatesPHDResearchDetails[0]['is_fellowship_activated']) && $candidatesPHDResearchDetails[0]['is_fellowship_activated'] == 1){ ?>
                        <tr style="background-color:#CCC;">
                            <td colspan="3" align="left" valign="top"><strong>Details of activated Fellowship</strong><strong></strong></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="left" valign="top">
                                <table width="100%" border="1" cellpadding="0" cellspacing="0" class="table table-bordered table-hover" >
                                    <tr>
                                        <th align="center">Name of the Institute</th>
                                        <th align="center">Date of Activation</th>                 
                                    </tr>
                                    <?php
                                    $activation_date = "";
                                    if(isset($candidatesPHDResearchDetails[0]['activation_date']) && !empty($candidatesPHDResearchDetails[0]['activation_date'])){
                                        $activation_date = $candidatesPHDResearchDetails[0]['activation_date'];
                                        $activation_date = Helper::convertDateYMDtoDMY($activation_date);
                                    }
                                    ?>
                                    <tr>
                                        <td align="center"><?php echo $candidatesPHDResearchDetails[0]['active_institute_name']; ?></td>
                                        <td align="center"><?php echo $activation_date; ?></td>
                                    </tr>    
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="justify" colspan="3">
                                NOTE: The candidate, who has already activated his/ her fellowship, may or may not be shortlisted for the interview. In case the candidate gets shortlisted for the interview, the candidate need to provide a No Objection Certificate from his/ her Guide at the time of the interview stating that the Guide and the institute have no objection if the candidate join the THSTI-JNU PhD program and also that they will allow him/ her to transfer the remaining fellowship to THSTI.
                            </td>
                        </tr>
                    <?php } ?>
                    <!-- fellowship activation details end -->

                    <!-- exam qualified details start -->
                    <?php if(isset($candidatesPHDResearchDetails[0]['is_exam_qualified']) && $candidatesPHDResearchDetails[0]['is_exam_qualified'] == 1){ ?>
                    <tr style="background-color:#CCC;">
                        <td colspan="3" align="left" valign="top"><strong>Exam Qualified</strong><strong></strong></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" valign="top">
                            <table width="100%" border="1" cellpadding="0" cellspacing="0" class="table table-bordered table-hover" >
                                <tr>
                                    <th align="center">Name of the exam</th>
                                    <th align="center">Score</th>      
                                    <th align="center">Validity Up To</th>   
                                    <th align="center">Document</th>            
                                </tr>
                                <?php
                                    $exam_qualified_val_up_to = "";
                                    if(isset($candidatesPHDResearchDetails[0]['exam_qualified_val_up_to']) && !empty($candidatesPHDResearchDetails[0]['exam_qualified_val_up_to'])){
                                        $exam_qualified_val_up_to = $candidatesPHDResearchDetails[0]['exam_qualified_val_up_to'];
                                        $exam_qualified_val_up_to = Helper::convertDateYMDtoDMY($exam_qualified_val_up_to);
                                    }
                                    $examQualifiedCertPath = "";
                                    if(isset($candidatesCommonDocuments[0]['exam_qualified_certificate']) && !empty($candidatesCommonDocuments[0]['exam_qualified_certificate'])){
                                        $exam_qualified_certificate = $candidatesCommonDocuments[0]['exam_qualified_certificate'];
                                        $examQualifiedCertPath = $candidates_docs_path."/".$exam_qualified_certificate;
                                        $examQualifiedCertPath = url($examQualifiedCertPath);
                                    }
                                    ?>
                                <tr>
                                    <td align="center"><?php echo $candidatesPHDResearchDetails[0]['exam_name']; ?></td>
                                    <td align="center"><?php echo $candidatesPHDResearchDetails[0]['exam_score']; ?></td>      
                                    <td align="center"><?php echo $exam_qualified_val_up_to; ?></td>
                                    <td align="center">
                                        <?php if(!empty($examQualifiedCertPath)){ ?>
                                            <a class="btn btn-primary" target="_blank" href="<?php echo $examQualifiedCertPath; ?>" title="File Attached"><i class="fa fa-eye"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>    
                            </table>
                        </td>
                    </tr>
                    <?php } ?>
                    <!-- exam qualified details end -->

                <?php } ?>  
                <!-- fellowship details end -->
                       
                
                <!-- common documents start -->
                <?php
                if(isset($candidatesCommonDocuments) && !empty($candidatesCommonDocuments)){
                ?>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <?php
                         if(empty($candidatesCommonDocuments[0]['id_card']) && empty($candidatesCommonDocuments[0]['project_proposal']) && empty($candidatesCommonDocuments[0]['candidate_cv']) && empty($candidatesCommonDocuments[0]['publication'])){
                        ?>
                         <h5 class="text-danger">NO DOCUMENT ATTACHED</h5>
                         <?php 
                        }else{ ?>
                        <div style="background-color:#CCC;"><strong>Attachments:</strong></div>
                        <?php } ?>
                        <!-- cv doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['candidate_cv'])){
                            $candidate_cv = $candidatesCommonDocuments[0]['candidate_cv'];
                            $cvPath = $candidates_docs_path."/".$candidate_cv;
                            $cvPath = url($cvPath);
                        ?>
                        <div class="row">
                            <div class="col-md-6 text-right">CV:</div> 
                            <div class="col-md-6 text-left">
                                <a target="_new" href="<?php echo $cvPath; ?>"><?php echo $candidate_cv; ?></a>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- cv doc end -->
                        <!-- age proof doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['age_proof'])){
                            $age_proof = $candidatesCommonDocuments[0]['age_proof'];
                            $age_proofPath = $candidates_docs_path."/".$age_proof;
                            $age_proofPath = url($age_proofPath);
                        ?>
                            <div class="row">
                                <div class="col-md-6 text-right">AGE PROOF:</div> 
                                <div class="col-md-6 text-left">
                                    <a target="_new" href="<?php echo $age_proofPath; ?>"><?php echo $age_proof; ?></a>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- age proof doc end -->
                        <!-- NOC doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['noc_certificate'])){
                            $noc_certificate = $candidatesCommonDocuments[0]['noc_certificate'];
                            $noc_certificatePath = $candidates_docs_path."/".$noc_certificate;
                            $noc_certificatePath = url($noc_certificatePath);
                        ?>
                            <div class="row">
                                <div class="col-md-6 text-right">NOC FOR PRESENT EMPLOYER:</div> 
                                <div class="col-md-6 text-left">
                                    <a target="_new" href="<?php echo $noc_certificatePath; ?>"><?php echo $noc_certificate; ?></a>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- NOC doc end -->
                        <!-- LIST OF PUBLICATIONS doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['listpublication'])){
                            $listpublication = $candidatesCommonDocuments[0]['listpublication'];
                            $listpublicationPath = $candidates_docs_path."/".$listpublication;
                            $listpublicationPath = url($listpublicationPath);
                        ?>
                            <div class="row">
                                <div class="col-md-6 text-right">LIST OF PUBLICATIONS:</div> 
                                <div class="col-md-6 text-left">
                                    <a target="_new" href="<?php echo $listpublicationPath; ?>"><?php echo $listpublication; ?></a>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- LIST OF PUBLICATIONS doc end -->
                        <!-- BEST FIVE/TEN PUBLICATIONS doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['publication'])){
                            $publication = $candidatesCommonDocuments[0]['publication'];
                            $publicationPath = $candidates_docs_path."/".$publication;
                            $publicationPath = url($publicationPath);
                        ?>
                            <div class="row">
                                <div class="col-md-6 text-right">BEST FIVE/TEN PUBLICATIONS:</div> 
                                <div class="col-md-6 text-left">
                                    <a target="_new" href="<?php echo $publicationPath; ?>"><?php echo $publication; ?></a>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- BEST FIVE/TEN PUBLICATIONS doc end -->
                        <!-- PROJECT PROPOSAL doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['project_proposal'])){
                            $project_proposal = $candidatesCommonDocuments[0]['project_proposal'];
                            $project_proposalPath = $candidates_docs_path."/".$project_proposal;
                            $project_proposalPath = url($project_proposalPath);
                        ?>
                            <div class="row">
                                <div class="col-md-6 text-right">PROJECT PROPOSAL:</div> 
                                <div class="col-md-6 text-left">
                                    <a target="_new" href="<?php echo $project_proposalPath; ?>"><?php echo $project_proposal; ?></a>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- PROJECT PROPOSAL doc end -->
                        <!-- STATEMENT OF PURPOSE doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['stmt_proposal'])){
                            $stmt_proposal = $candidatesCommonDocuments[0]['stmt_proposal'];
                            $stmt_proposalPath = $candidates_docs_path."/".$stmt_proposal;
                            $stmt_proposalPath = url($stmt_proposalPath);
                        ?>
                            <div class="row">
                                <div class="col-md-6 text-right">STATEMENT OF PURPOSE:</div> 
                                <div class="col-md-6 text-left">
                                    <a target="_new" href="<?php echo $stmt_proposalPath; ?>"><?php echo $stmt_proposal; ?></a>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- STATEMENT OF PURPOSE doc end -->
                        <!-- ID Card doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['id_card'])){
                            $id_card = $candidatesCommonDocuments[0]['id_card'];
                            $id_cardPath = $candidates_docs_path."/".$id_card;
                            $id_cardPath = url($id_cardPath);
                        ?>
                            <div class="row">
                                <div class="col-md-6 text-right">ID Card:</div> 
                                <div class="col-md-6 text-left">
                                    <a target="_new" href="<?php echo $id_cardPath; ?>"><?php echo $id_card; ?></a>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- ID Card doc end -->
                    </td>
                </tr>    
                <?php } ?>                        
                <!-- common documents start -->

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

                <!-- submit button start -->
                <tr>
                    <td colspan="3" align="center" >&nbsp;</td>
                </tr>
                
                <tr><td colspan="3" align="center" ><input class="btn btn-success" type="submit" name="submit" value="Final Submit"></td></tr>
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