
<!-- fellowship tab start -->
@if(!empty($fieldsArray) && in_array('fundagency', $fieldsArray))  
    <?php
    $fund_agency = old('fund_agency');
    $rank = old('rank');
    $admission_test = old('admission_test');
    $val_up_to = old('val_up_to');
    $activate_fellow = old('activate_fellow');
    $active_institute_name = old('active_institute_name');
    $active_date = old('active_date');
    if(isset($candidatesPHDResearchDetails) && !empty($candidatesPHDResearchDetails)){
        $fund_agency = $candidatesPHDResearchDetails[0]['funding_agency'];
        $rank = $candidatesPHDResearchDetails[0]['rank'];
        $admission_test = $candidatesPHDResearchDetails[0]['admission_test'];
        $val_up_to = $candidatesPHDResearchDetails[0]['fellowship_valid_up_to'];
        $activate_fellow = $candidatesPHDResearchDetails[0]['is_fellowship_activated'];
        $active_institute_name = $candidatesPHDResearchDetails[0]['active_institute_name'];
        $active_date = $candidatesPHDResearchDetails[0]['activation_date'];
    }
    ?> 
    <div class="row">                                
        <div class="col-12" id="fellowship">
            <h4 class="text-primary">Fellowship Details</h4>
            <table class="table table-bordered table-sm table-responsive-lg table-hover">     
                <thead>
                    <tr>
                        <th>Funding Agency</th>
                        <th>Rank</th>
                        <th>Admission Test</th>
                        <th>Validity Up To</th>               
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input name="fund_agency" value="<?php echo $fund_agency; ?>" type="text" class="form-control" /></td>
                        <td><input name="rank" value="<?php echo $rank; ?>" type="text"  class="form-control" /></td>
                        <td><input name="admission_test" value="<?php echo $admission_test; ?>" type="text" class="form-control" /></td> 
                        <td><input name="val_up_to" value="<?php echo $val_up_to; ?>" type="date" class="form-control" /></td>       
                    </tr>  
                </tbody>   
            </table>  
            <!--group activation-->
            <div class="row col-lg-12 col-md-12" id="fellow_activation">
                <div class="form-group col-lg-12 col-md-12">
                    <label class="form-check-label mr-1">Have you already activated your fellowship?</label>
                    <div class="form-check form-check-inline">
                        <input name="activate_fellow" class="activate_fellow_id" type="radio" value="1" <?php echo ($activate_fellow==1)?'checked':''; ?> />
                        <label class="form-check-label mr-1 ml-1">Yes</label>
                        <input name="activate_fellow" class="activate_fellow_id" checked type="radio" value="0" <?php echo ($activate_fellow==0)?'checked':''; ?> />
                        <label class="form-check-label mr-1 ml-1">No</label>
                    </div>
                </div>             
                <div class="form-group form-row col-12" style="display:none;" id="group_activation">            
                    <table class="table table-bordered table-sm table-responsive-lg table-hover">     
                        <thead>
                            <tr>
                                <th width="16%">Name of the Institute</th>
                                <th width="16%">Date of Activation</th>                              
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input name="active_institute_name" value="<?php echo $active_institute_name; ?>" type="text" class="form-control dd_no" /></td>
                                <td><input name="active_date" value="<?php echo $active_date; ?>" type="date"  class="form-control"/></td>                 
                            </tr>  
                        </tbody>   
                    </table>
                    <div class="col-12 text-dark strong text-justify">
                    NOTE: The candidate, who has already activated his/ her fellowship, may or may not be shortlisted for the interview. In case the candidate gets shortlisted for the interview, the candidate need to provide a No Objection Certificate from his/ her Guide at the time of the interview stating that the Guide and the institute have no objection if the candidate join the THSTI-JNU PhD program and also that they will allow him/ her to transfer the remaining fellowship to THSTI.
                    </div>
                </div>
            </div>                        
        </div>
    </div>  

    <script>
        $(document).ready(function(){
            $(".activate_fellow_id").trigger('click');
        });
        $(".activate_fellow_id").on('click', function(){				
            var fellow_active_ans = $(this).val();									
            if(fellow_active_ans==1){   
                $('#group_activation').show();	
            }else{   
                $('#group_activation').hide(); 
            }
        });
    </script>
@endif                
<!--end of Fellowship section-->
           
<!-- exams qualified -->
@if(!empty($fieldsArray) && in_array('phdexamqualified', $fieldsArray))  
    <?php
    $exam_qualified = 0;
    $old_exam_qualified = old('exam_qualified');
    if(isset($old_exam_qualified) && !empty($old_exam_qualified)){
        $exam_qualified = $old_exam_qualified;
    }
    $exam_qualified_name = old('exam_qualified_name');
    $exam_qualified_score = old('exam_qualified_score');
    $exam_qualified_val_up_to = old('exam_qualified_val_up_to');
    if(isset($candidatesPHDResearchDetails) && !empty($candidatesPHDResearchDetails)){
        $old_exam_qualified = $candidatesPHDResearchDetails[0]['is_exam_qualified'];
        $exam_qualified_name = $candidatesPHDResearchDetails[0]['exam_name'];
        $exam_qualified_score = $candidatesPHDResearchDetails[0]['exam_score'];
        $exam_qualified_val_up_to = $candidatesPHDResearchDetails[0]['exam_qualified_val_up_to'];
    }
    ?>    
    <div class="row">                            
        <div class="col-12" id="exam_qualified">
            <label class="form-check-label mr-1" >Any National Fellowship Exam Qualified?</label> 
            <input name="exam_qualified" class="exam_qualified" checked type="radio" value="0" <?php echo ($exam_qualified==0)?'checked':''; ?> />
            <label class="form-check-label ml-1 mr-1">No</label>
            <input name="exam_qualified" class="exam_qualified" type="radio" value="1" <?php echo ($exam_qualified==1)?'checked':''; ?> />
            <label class="form-check-label ml-1 mr-1">Yes</label>   
        </div>            
        <div id="exam_div" class="col-lg-12 col-md-12">  
            <div class="text-primary h4">Exam Qualified</div> 
            <table class="table table-bordered table-sm table-responsive-lg table-hover">     
                <thead>
                    <tr>
                        <th>Name of the exam</th>
                        <th>Score</th>                  
                        <th>Validity Up To</th>               
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input name="exam_qualified_name" id="exam_qualified_name" value="<?php echo $exam_qualified_name; ?>" type="text" class="form-control" /></td>
                        <td><input name="exam_qualified_score" id="exam_qualified_score" value="<?php echo $exam_qualified_score; ?>" type="number"  class="form-control" /></td>                  
                        <td><input name="exam_qualified_val_up_to" id="exam_qualified_val_up_to" value="<?php echo $exam_qualified_val_up_to; ?>" type="date" class="form-control" /></td>       
                    </tr>  
                </tbody>   
            </table> 
        </div>                         
    </div>

    <script>
        $(document).ready(function(){
            $('.exam_qualified').trigger('click');    
        });
        $('.exam_qualified').click(function(){		
            let selectedVal = $(this).val();
            if(selectedVal == 1){ 
                $('#exam_div').show();
            }
			else{ 
                $('#exam_div').hide();
            }										
		}); 
    </script>
@endif
<!--end of score section-->
           