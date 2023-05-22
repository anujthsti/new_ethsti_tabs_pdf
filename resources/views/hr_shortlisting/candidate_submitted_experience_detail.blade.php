<?php if(isset($candidatesExperienceDetails) && !empty($candidatesExperienceDetails)){ ?>
    <?php
    if(isset($isPDFGenerating) && $isPDFGenerating == 1){
        ?>
        <div style="page-break-before:always">&nbsp;</div> 
        <?php                 
    }
    ?>
    
                <tr style="background-color:#CCC;">
                    <td colspan="3" align="left" valign="top">
                        <strong>EXPERIENCE Details</strong>
                        <!-- experience validation start -->
                        <?php
                        if(isset($isPDFGenerating) && $isPDFGenerating == 1){
                                                
                        }
                        else{
                            $experienceValid = 1;
                            if(isset($jobExperienceValidation) && !empty($jobExperienceValidation)){
                                $requiredExperienceYear = $jobExperienceValidation[0]['years'];
                                $reqExperienceEduId = $jobExperienceValidation[0]['education_id'];
                                $allEduIds = array_column($candidateAcademicsDetails,'education_id');
                                $reqEduIdKey = array_search($reqExperienceEduId, $allEduIds);
                                if(isset($candidateAcademicsDetails[$reqEduIdKey]['year'])){
                                    $eduYear = $candidateAcademicsDetails[$reqEduIdKey]['year'];
                                    $validExp = 0;
                                    if(!empty($eduYear)){
                                        $totalExp = [];
                                        foreach($candidatesExperienceDetails as $experienceDetails_val){
                                            $from_date_exp = $experienceDetails_val['from_date'];
                                            $totalExperience = $experienceDetails_val['total_experience'];
                                            $dateYear = date('Y', strtotime($from_date_exp));
                                            if($dateYear >= $eduYear){
                                                $totalExp[] = $totalExperience;
                                            }
                                        }
                                        
                                        if(!empty($totalExp)){
                                            $totalExpYear = Helper::grand_total_exp_year($totalExp);
                                            if($totalExpYear < $requiredExperienceYear){
                                                $experienceValid = 0;
                                            }
                                        }else{
                                            $experienceValid = 0;
                                        }
                                    }else{
                                        $experienceValid = 0;
                                    }
                                }
                                else{
                                    $experienceValid = 0;
                                }
                                
                            
                            }
                            if($experienceValid == 0){
                                ?>
                                <span class="text-danger">Required post qualification experience missing</span>
                                <?php
                            }
                        }
                        ?>
                        <!-- experience validation end -->
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
                                <?php
                                if(isset($isPDFGenerating) && $isPDFGenerating == 1){
                                                
                                }
                                else{
                                ?>
                                <td rowspan="2" align="center"><strong>Files</strong></td>
                                <?php } ?>
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
                                    <td align="center">
                                    <?php
                                    if(isset($isPDFGenerating) && $isPDFGenerating == 1){
                                    ?>
                                        <a target="_blank" href="<?php echo $experienceDocumentPath; ?>" title="View File">File</a>
                                    <?php          
                                    }
                                    else{
                                    ?>
                                    <a target="_blank" href="<?php echo $experienceDocumentPath; ?>" title="View File" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                    <?php } ?>
                                    </td>
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