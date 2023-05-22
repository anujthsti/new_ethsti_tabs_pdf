<tr style="background-color:#CCC;">
                    <td colspan="3" align="left" valign="top">
                        <strong>ACADEMIC/ PROFESSIONAL QUALIFICATION</strong>
                        <?php
                        if(isset($isPDFGenerating) && $isPDFGenerating == 1){
                                                
                        }
                        else{
                            $educationValid = 1;
                            if(isset($jobEducationValidation) && !empty($jobEducationValidation)){
                                $requiredEducationIds = array_column($jobEducationValidation, 'education_id');
                                if(isset($candidateAcademicsDetails) && !empty($candidateAcademicsDetails)){
                                    $candidateEducationIds = array_column($candidateAcademicsDetails, 'education_id');  
                                    $idsDiff = array_diff($requiredEducationIds, $candidateEducationIds);  
                                    if(!empty($idsDiff)){
                                        $educationValid = 0;
                                    }  
                                }else{
                                    $educationValid = 0;
                                }
                            }
                            if($educationValid == 0){
                                ?>
                                <span class="text-danger">Required education missing</span>
                                <?php
                            }
                        }
                        ?>
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
                                            <?php
                                            if(isset($isPDFGenerating) && $isPDFGenerating == 1){
                                            ?>
                                                <a target="_blank" title="View File" href="<?php echo $eduDocumentPath; ?>">File</a>
                                            <?php         
                                            }
                                            else{
                                            ?>
                                            <a class="btn btn-primary" target="_blank" title="View File" href="<?php echo $eduDocumentPath; ?>"><i class="fa fa-eye"></i></a>
                                            <?php 
                                            }
                                        } ?>
                                    </td>
                                    
                                </tr>      
                            <?php }
                            }
                            ?>
                        </table>
                    </td>
                </tr> 