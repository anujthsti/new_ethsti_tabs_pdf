                <?php
                $tdWidth = 215;
                if(isset($isPDFGenerating) && $isPDFGenerating == 1){
                    $tdWidth = 150;
                }
                ?>
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

                
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="left" valign="top">
                                    <table width="100%" border="0" cellspacing="1" cellpadding="4">
                                        <tr>
                                            <td width="<?php echo $tdWidth; ?>">FULL NAME</td>		
                                            <td colspan="5" ><?php echo $full_name; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td width="<?php echo $tdWidth; ?>">FATHER&rsquo;S NAME</td>		 
                                            <td colspan="5" ><?php echo $father_name; ?></td>
                                            </tr>
                                        <tr>
                                            <td width="<?php echo $tdWidth; ?>">MOTHER&rsquo;S NAME</td>		  
                                            <td colspan="5" ><?php echo $mother_name; ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td width="<?php echo $tdWidth; ?>">DATE OF BIRTH</td>		
                                            <td colspan="5" >
                                                <?php
                                                if(!empty($dob)){
                                                    echo Helper::convertDateYMDtoDMY($dob);
                                                ?>
                                                    &nbsp; (<?php echo $age; ?>)
                                                <?php    
                                                    if($isCandidateOverAged == 1){
                                                        ?>
                                                         <a class="text-danger h6" href="#">Over Aged</a>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>      
                                        <tr>
                                            <td width="<?php echo $tdWidth; ?>">GENDER</td>		
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
                                                        if(isset($isPDFGenerating) && $isPDFGenerating == 1){
                                                        ?>
                                                            <a target="_blank" href="<?php echo $categoryCertPath; ?>" title="View File">File</a>
                                                        <?php
                                                        }
                                                        else{
                                                    ?>
                                                        <a class='btn btn-primary' target="_blank" href="<?php echo $categoryCertPath; ?>" title="View File"><i class="fa fa-eye"></i></a>
                                                    <?php
                                                        }
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
                                                            if(isset($isPDFGenerating) && $isPDFGenerating == 1){
                                                            ?>
                                                                <a target="_blank" href="<?php echo $pwdCertPath; ?>" title="View File">File</a>
                                                                <br />
                                                            <?php
                                                            }
                                                            else{
                                                        ?>
                                                            <a class='btn btn-primary' target="_blank" href="<?php echo $pwdCertPath; ?>" title="View File"><i class="fa fa-eye"></i></a>
                                                            <br />
                                                        <?php
                                                            }
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
                                                            if(isset($isPDFGenerating) && $isPDFGenerating == 1){
                                                            ?>
                                                                <a target="_blank" href="<?php echo $exServicemanCertPath; ?>" title="View File">File</a>
                                                                <br />
                                                            <?php
                                                            }
                                                            else{
                                                        ?>
                                                            <a class='btn btn-primary' target="_blank" href="<?php echo $exServicemanCertPath; ?>" title="View File"><i class="fa fa-eye"></i></a>
                                                            <br />
                                                        <?php
                                                            }
                                                        }
                                                    }
                                                
                                                ?>
                                            </td>
                                        </tr>
                                        <?php if($is_ex_serviceman == 1){ ?>
                                        <tr>
                                            <td align="left">Date of release</td>
                                            <td colspan="3" align="left">
                                                <?php 
                                                if(isset($date_of_release) && !empty($date_of_release)){
                                                    echo Helper::convertDateYMDtoDMY($date_of_release); 
                                                }
                                                ?>
                                            </td>
                                        </tr>
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
                                            <td width="<?php echo $tdWidth; ?>">NATIONALITY</td>		 
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
                                            <td width="<?php echo $tdWidth; ?>">ADDRESS CORRESPONDENCE</td>	
                                            <td colspan="5" ><?php echo $correspondence_address; ?>  &nbsp;  <?php echo $cors_city; ?>,&nbsp;<?php echo $corsState; ?> - <?php echo $cors_pincode; ?> </td>
                                        </tr>
                                        <tr>
                                            <td width="<?php echo $tdWidth; ?>">ADDRESS PERMANENT</td>		
                                            <td colspan="5" ><?php echo $permanent_address; ?>  &nbsp; <?php echo $perm_city; ?>,&nbsp;<?php echo $permState; ?> - <?php echo $perm_pincode; ?></td>
                                        </tr>
                                    
                                        <tr>
                                            <td>MOBILE NO</td>		 
                                            <td><?php echo $mobile_no; ?></td>	
                                            <?php
                                            if(isset($isPDFGenerating) && !empty($isPDFGenerating)){
                                            ?>    
                                                </tr>
                                                <tr>	
                                            <?php
                                            }
                                            ?>
                                            <td align="left" >EMAIL ID</td>		
                                            <td><?php echo $email_id; ?></td>
                                        </tr>
                                        
                                    </table>
                                </td>
                                <!-- candidate photo start -->
                                <td valign="top">
                                    <table width="138" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="160" height="160" align="center" valign="middle" style="border: solid 1px #000;">
                                                <?php
                                                if(isset($candidatesCommonDocuments[0]['candidate_photo']) && !empty($candidatesCommonDocuments[0]['candidate_photo'])){
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
                