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
                                    <td align="center">
                                        <?php
                                        if(isset($isPDFGenerating) && $isPDFGenerating == 1){
                                        ?>
                                            <a target="_new" href="<?php echo $fellowshipCertPath; ?>" title="View File">
                                                file
                                            </a>
                                        <?php    
                                        }
                                        else{
                                        ?>
                                        <a class="btn btn-primary" target="_new" href="<?php echo $fellowshipCertPath; ?>" title="View File">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <?php } ?>
                                    </td>
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
                                            <?php 
                                            if(isset($isPDFGenerating) && $isPDFGenerating == 1){ 
                                            ?>
                                                <a target="_blank" href="<?php echo $examQualifiedCertPath; ?>" title="File Attached">File</a>
                                            <?php
                                            } 
                                            else{
                                            ?>
                                                <a class="btn btn-primary" target="_blank" href="<?php echo $examQualifiedCertPath; ?>" title="File Attached"><i class="fa fa-eye"></i></a>
                                            <?php } ?>
                                        <?php } ?>
                                    </td>
                                </tr>    
                            </table>
                        </td>
                    </tr>
                    <?php } ?>
                    <!-- exam qualified details end -->

                <?php } ?> 