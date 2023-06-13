
@include('application.header')
<?php
if(empty($candidateInfo)){
    echo "Candidate details not found. Kindly contact technical support team.";
    exit;
}
$infoArr = $candidateInfo[0];
?>

<div class="container border" style="page-break-before: always; margin: 10px auto;">	
  <div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <img class="img" src="{{ asset('thsti-logo-vertical.jpg') }}" width="90" height="80" />
        </div>	
        <div class="col-lg-12 text-center">
            <h4><strong>TRANSLATIONAL HEALTH SCIENCE AND TECHNOLOGY INSTITUTE</strong></h4>
            <small class="text-muted">NCR-Biotech Science Cluster, 3rd Milestone Faridabad-Gurgaon Expressway, P.O. Box No.04 Faridabad-121001, Haryana, India</small>
        </div>  	 
    </div>
  </div>
  
  <div class="text-center text-danger h3">Admit Card</div>
  
  <div class="col-lg-12 table-responsive">  
    <table class="table table-bordered table-sm">
        <?php
        
        ?>
        <tr>
            <td>Roll No</td>
            <td><strong>0000<?php echo $infoArr['id']; ?></strong></td>
            <?php
            $candidate_photoPath = "";
            $candidate_signPath = "";
            if(isset($infoArr['candidate_photo']) && !empty($infoArr['candidate_photo'])){
                $candidates_docs_path = config('app.candidates_docs_path');
                $candidates_docs_path .= "/".$job_apply_id;
                // candidate image
                $candidate_photo = $infoArr['candidate_photo'];
                $candidate_photoPath = $candidates_docs_path."/".$candidate_photo;
                $candidate_photoPath = url($candidate_photoPath);
                // candidate sign
                $candidate_sign = $infoArr['candidate_sign'];
                $candidate_signPath = $candidates_docs_path."/".$candidate_sign;
                $candidate_signPath = url($candidate_signPath);
            }
            ?>
            <td align="center" rowspan="8">
                <img class="img" width="150" height="150" src="<?php echo $candidate_photoPath; ?>"  />
                <br />
                <img class="img" width="100" height="50" src="<?php echo $candidate_signPath; ?>"  />
            </td>
        </tr>
        <tr>
            <td>Post/s Applied for </td>
            <td>    
                <?php 
                $post_name = Helper::getCodeNameValueById($infoArr['post_id']); 
                if(isset($infoArr['post_domain_id']) && !empty($infoArr['post_domain_id'])){
                    $domain_name = Helper::getCodeNameValueById($infoArr['post_domain_id']); 
                    $post_name .= " ( ".$domain_name." )";
                }
                echo $post_name;
                ?>	                   
            </td>
        </tr>
        <tr>
            <td width="32%">Candidate's Name</td>
            <td width="60%"><?php echo $infoArr['full_name']; ?></td>
        </tr>	
        <tr>
            <td>Father's Name</td>
            <td><?php echo $infoArr['father_name']; ?></td>
        </tr>
        <tr>
            <td>Gender</td>
            <td><?php echo Helper::getCodeNameValueById($infoArr['gender']); ?></td>
        </tr>  
        <tr>
            <td>Date of Birth</td>
            <td><?php echo Helper::convertDateYMDtoDMY($infoArr['dob']); ?></td>
            </tr> 
        <tr>
            <td>Category</td>
            <td><?php echo Helper::getCodeNameValueById($infoArr['category_id']); ?></td>
        </tr>
        <tr>
            <td>PWD</td>
            <td>
                <?php
                if($infoArr['is_pwd'] == 1){
                    echo "YES";
                }else{
                    echo "NO";
                }
                ?>
            </td>
        </tr>     
    </table>
    <?php
    if(isset($candidateShiftInfo) && !empty($candidateShiftInfo)){
        $shiftDetails = $candidateShiftInfo[0];
    
        $examTitle = "Exam Center";
        if($typeId == 1){
            $examTitle = "Written test Centre";
        }
    ?>            
        <table class="table table-bordered">   
            <tr class="bg-light">
                <td class="text-center h5"><strong><?php echo $examTitle; ?></strong></td>
                <td colspan="2" class="text-center h5"><strong>Date &amp; Time</strong></td>
                </tr>
            <tr>
                <td rowspan="3">
                    <?php echo $shiftDetails['centre_name']; ?>
                    <br>
                    <?php echo $shiftDetails['centre_address']; ?>
                </td>
                <td>Date & time of reporting at the Centre</td>
                <td>
                    <?php echo Helper::convertDateYMDtoDMY($shiftDetails['reporting_date']); ?>
                    <br>
                    <?php echo $shiftDetails['reporting_time']; ?>
                </td>
            </tr>
            <tr>
                <td>Time of gate closing at the Centre</td>
                <td> 30 Minutes before the written test starts </td>
                <!--<td><?php echo $shiftDetails['start_time']; ?></td>-->
                </tr>
            <tr>
                <td> Time of written test</td>
                <td><?php echo $shiftDetails['shift_time']; ?></td>
            </tr>    
        </table>
    <?php } ?>    
        
    <table class="table table-bordered table-lg">
            <tr class="bg-light">     
            <td colspan="2" class="text-center h5"><strong>To be signed before the invigilator</strong></td>     
        </tr> 
        <tr>     
            <td align="center">Candidate's Signature</td>
            <td align="center">Invigilator's Signature</td>     
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>     
        </tr>
    </table> 

    <div class="col-lg-12 border bg-light" style="page-break-before: always">
        <div class="h5 text-center">General Instructions for the Candidates</div>		       
            <ol class="text-justify small">
                <li>Any request for change of written test Centre will not be entertained in any circumstances.</li>
                <li>Candidate may please note that this admit card does not constitute an offer for appointment.</li>
                <li>Candidate should bear their own travelling and other expenses to attend the examination and the candidate have to make their own arrangements for boarding/lodging. </li>
                <li>The entry of the candidate inside the Centre will be allowed only as per the timing mentioned in the Admit Card.</li>
                <li>Candidate should report at the Centre before the reporting time and note that no candidate will be allowed to enter  after the gate closing time under any circumstances or due to any reason.</li>
                <li>Frisking by Security personnel will be done at the entrance of the Centre.</li>
                <li>Wearing facemask, carrying hand-sanitizer and following physical distancing should be followed strictly during the entire process of the written test.  However, facemask will have to be removed for identification at the Centre. Candidate will not be permitted to enter in the Centre without mask. Candidates are advised to install Aarogya Setu App. </li>
                <li>Candidates will be allowed to carry only the following items to the Centre:-
                    <ul>
                        <li>Admit Card</li>
                        <li>Proof of Identity (Passport, Aadhaar Card, Driving License, PAN Card, Voter ID card)</li>
                        <li>Mask on face</li>
                        <li>Personal transparent water bottle</li>
                        <li>Small hand sanitizer (50 ml)</li>
                                <li>Ball pens having transparent outer cover</li>
                    </ul>
                </li> 
                <li>Candidate must carry an original photo identity card as proof of identity having the date of birth as printed in the Admit Card.</li>
                <li>In case of mismatch in the date of birth mentioned in the admit card and original photo ID, the candidate will not be allowed to appear in the written test.</li>                 
                <li>Prohibited items such as watches, books, pens, paper chits, magazines, electric gadgets (Mobile phone, Bluetooth devices, head phones, pen/buttonhole cameras, scanner, calculator, storage devices etc) are strictly prohibited during written test. If any such item is found in the possession of a candidate, the same will be confiscated and kept at the gate entry, THSTI in any circumstances will not be respobsible for safe custody of the same.</li>
                <li>Candidates are strictly advised to desist from bringing bags. In case they bring bags, they would have to make their own arrangements for safe custody. However, the Institute will make arrangement for keeping one small bag at the entrance of the centre but shall not be responsible for the same.</li>                                             
                <li>Candidate should bring their own ball point pen (black or blue). Empty space in the question paper may be used for rough work.</li>
                <li>The candidate should ensure that they do not indulge in any unfair means and should also not talk to each other after commencement of the written test and during its entire duration.</li>                  
                <li>If any candidate is found obstructing the conduct of the written test or creating disturbances at the Centre, his/her candidature shall be summarily cancelled. Such candidate shall also be liable to be debarred from future selection of THSTI and appropriate proceedings could be initiated against him/her. It may be noted that no re-test would be conducted if it is found that the test was disrupted on the account of instigation by the candidates.</li>
                <li>In case of any doubt or any clarification, the candidates are advised to contact the invigilators available in the exam hall.</li>
                <li>Anyone found to be disclosing, publishing, reproducing, transmitting, storage or facilitating transmission and storage of test content in any form or any information therein in whole or part thereof or by any means i.e. verbal or written. electronically or mechanically or taking away the papers supplied in the Centre or found to be in unauthorized possession of test content will be considered as serious misconduct and will be debarred/disqualified from Centre. Appropriate action will be initiated and such cases will be reported to police, if necessary.</li>
                <li>Candidates are advised to move in and move-out of the Centre in orderly manner.</li>                           
                <li>Non observation of the instructions mentioned herein or instructions issued hereafter or use of any unfair means or in possession of any incriminating material or items during the written test will render the candidature liable to be rejected and the candidate will be liable for prosecution.</li>
                <li>No candidate wiil be allowed to leave the Centre before the completion of the written test time for any reason without permission from the written test functionaries.  Once a candidate leaves the hall without the permission of the written test functionaries, he/she shall not be permitted to re-enter the hall and his/her candidature shall be cancelled.</li>                 
                <li>Candidates have to report at 9.00 AM at THSTI. The written test result will be declared on 6th November 2022. The candidates who qualify written test will be required to appear in skill test and interview on 7th November 2022.</li>
                <li>The candidates are required to bring with them the following documents in original and one set of photocopy. In the absence of these documents the candidates shall not be allowed to undergo the written test.</li>                 
                    <ul>
                        <li>Date of birth certificate/proof (matriculation certificate or birth certificate).</li>
                        <li>Certificates pertaining to your educational qualifications and experience as claimed by you in your application.</li>
                        <li>No Objection Certificate’ from the present employer, if you are already employed in any government organization /PSU/ Autonomous Institute. Please note that without an ‘NOC’ from the present employer, your candidature will not be considered for the selection process.</li>
                        <li>‘Discharge Book’ in case you are an “Ex-Servicemen”.  Please note that if you fail to provide a ‘Discharge Book’ or NOC issued by the Air Force/Army/Navy, you will not be permitted to appear in the selection process.</li>
                        <li>Caste certificate issued by the competent authority in the format prescribed by the Govt of India, if applicable.
                    </ul>
                </li> 
                <li>Candidate shall sanitize their hands before & after receiving the question paper, OMR Sheet and Answer sheet handing over the same to invigilators.</li>
                <li>The candidate should regularly visit the THSTI website for latest updates related to this recruitment process.</li>      
            </ol>  
            
        </div>  
    </div>
    
  </div> 
</div> 

<span class="break"></span>

</body>
</html>