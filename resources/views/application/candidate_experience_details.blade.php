<!-- experience block -->
@if(!empty($fieldsArray) && in_array('nameoftheorganisation', $fieldsArray)) 
<?php
$exp_check = old('exp_check');
$exp_grand_total = old('exp_grand_total');
$exp_from = old('exp_from');
$exp_to = old('exp_to');
$exp_total = old('exp_total');
$exp_org_name = old('exp_org_name');
$exp_prev_desig = old('exp_prev_desig');
$exp_gp = old('exp_gp');
$exp_gross = old('exp_gross');
$nature_of_duties = old('nature_of_duties');

$experienceDetailsArr = [];
if(!empty($fieldsArray) && in_array('exp_from', $fieldsArray)){
    $exp_check = 1;
    if(isset($candidateJobApplyDetail) && !empty($candidateJobApplyDetail)){
        $exp_check = $candidateJobApplyDetail[0]['is_experience'];
    }
}

if(isset($candidateExperienceDetails) && !empty($candidateExperienceDetails)){
    //$exp_grand_total = array_column($academicDetails, 'education_id');
    $exp_from = array_column($candidateExperienceDetails, 'from_date');
    $exp_to = array_column($candidateExperienceDetails, 'to_date');
    $exp_total = array_column($candidateExperienceDetails, 'total_experience');
    $exp_org_name = array_column($candidateExperienceDetails, 'organization_name');
    $exp_prev_desig = array_column($candidateExperienceDetails, 'designation');
    $exp_gp = array_column($candidateExperienceDetails, 'pay_level');
    $exp_gross = array_column($candidateExperienceDetails, 'gross_pay');
    $exp_grand_total = $total_experience;
    $nature_of_duties = array_column($candidateExperienceDetails, 'nature_of_duties');
}

?>
    <div class="row">          
            
        <div id="exp_check_hide" class="col-lg-12 col-md-12">
            <label class="form-check-label mr-1" >Any work experience?</label> 
            <div class="form-check form-check-inline">
                <input name="exp_check" class="exp_check" <?php echo ($exp_check == 0)?'checked':''; ?> type="radio" value="0" /><label class="form-check-label ml-1 mr-1">No</label>
                <input name="exp_check" class="exp_check" <?php echo ($exp_check == 1)?'checked':''; ?> type="radio" value="1" /><label class="form-check-label ml-1 mr-1">Yes</label>                  
            </div>
        </div>
                        
        <div id="exp_hide" class="col-lg-12 col-md-12">      
            <div class="text-primary h4">Experience Details</div>                    
              <table class="table table-bordered table-sm table-hover table-responsive table-hover" id="exp">
                <thead class="bg-light">
                    <tr>       
                        @if(!empty($fieldsArray) && in_array('exp_from', $fieldsArray))      
                        <th colspan="2">Period of Employment</th>
                        @endif
                        @if(!empty($fieldsArray) && in_array('totalexperience', $fieldsArray)) 
                        <th rowspan="2">Total Experience</th>
                        @endif
                        @if(!empty($fieldsArray) && in_array('designation', $fieldsArray)) 
                        <th rowspan="2">Post Held</th>
                        @endif
                        <th rowspan="2">Nature of duties performed</th>
                        @if(!empty($fieldsArray) && in_array('nameoftheorganisation', $fieldsArray)) 
                        <th rowspan="2">Name of the Organisation</th>
                        @endif
                        @if(!empty($fieldsArray) && in_array('grosspay', $fieldsArray)) 
                        <th colspan="2">Salary Per Month(INR) </th>      
                        @endif        
                    </tr>
                    <tr>
                        @if(!empty($fieldsArray) && in_array('exp_from', $fieldsArray)) 
                        <th>From</th>
                        @endif
                        @if(!empty($fieldsArray) && in_array('exp_from', $fieldsArray)) 
                        <th>To</th>
                        @endif
                        @if(!empty($fieldsArray) && in_array('gradepay', $fieldsArray)) 
                        <th>Pay Level (if any)</th>
                        @endif
                        @if(!empty($fieldsArray) && in_array('grosspay', $fieldsArray)) 
                        <th>Gross Pay</th>        
                        @endif          
                    </tr>
                </thead>
                <tbody id="experienceTBody">
                
                </tbody>                           
              </table>                    
              @if(!empty($fieldsArray) && in_array('totalexperience', $fieldsArray)) 
              <div class="form-group row col-12" align="left">
                <label for="exp_grand_total" class="col-2">Total Experience: </label>
                <input readonly="readonly" type="text" name="exp_grand_total" id="exp_grand_total" class="form-control col-2" placeholder="Click here to get total experience.." value="<?php echo $exp_grand_total; ?>" /> 
                <input class="form-control-plaintext" id="required_exp" type="hidden" style="width:50px" readonly="readonly" />
                <span id='exp_error' class="text-danger" ></span><input type="hidden" id="exp_error_check"  class="form-control" style="width:50px" />
              </div> 	
              @endif			              
              <div class="text-right">
                <button class="btn btn-primary" type="button" id="exp_add_id">Add</button>&nbsp;
                <button class="btn btn-primary" type="button" id="exp_rem_id" >Remove</button>&nbsp;
                <button class="btn btn-primary" type="button" id="exp_clear" >Clear</button>
              </div>                                             
            </div>                                             
    </div>                                                                     
    <!-- End of experience block -->       
@endif        
        
<script>

    //check experience	
    $('.exp_check').click(function(){						
        if($(this).val()==1){ 
            $('#exp_hide').show(); 
        }
        else{ 
            $('#exp_hide').hide(); 
        }										
    }); 
    // on document ready add default rows
    $(document).ready(function(){
        $('.exp_check').trigger('click');
        //add_experience_row();
        @if(!empty($exp_from))
            // for experience alredy added educations
            @foreach($exp_from as $key=>$from_date)
                //.exp_from, .exp_to, .exp_total, .exp_org_name, .exp_prev_desig, .exp_gp, .exp_gross
                experienceArr = [];
                experienceArr['exp_from'] = "";
                experienceArr['exp_to'] = "";
                experienceArr['exp_total'] = "";
                experienceArr['exp_org_name'] = "";
                experienceArr['nature_of_duties'] = "";
                experienceArr['exp_prev_desig'] = "";
                experienceArr['exp_gp'] = "";
                experienceArr['exp_gross'] = "";
                exp_from = '<?php echo $from_date; ?>';
                exp_from = exp_from.replace(" 00:00:00", "");
                experienceArr['exp_from'] = exp_from; 
                exp_to_date = "";
                @if(isset($exp_to[$key]) && !empty($exp_to[$key]))
                    exp_to_date = '<?php echo $exp_to[$key]; ?>';
                    exp_to_date = exp_to_date.replace(" 00:00:00", "");
                    experienceArr['exp_to'] = exp_to_date; 
                @endif
                
                @if(isset($exp_total[$key]) && !empty($exp_total[$key]))
                    experienceArr['exp_total'] = '<?php echo $exp_total[$key]; ?>'; 
                @endif
                @if(isset($exp_org_name[$key]) && !empty($exp_org_name[$key]))
                    experienceArr['exp_org_name'] = '<?php echo $exp_org_name[$key]; ?>'; 
                @endif
                @if(isset($exp_prev_desig[$key]) && !empty($exp_prev_desig[$key]))
                    experienceArr['exp_prev_desig'] = '<?php echo $exp_prev_desig[$key]; ?>'; 
                @endif
                @if(isset($exp_gp[$key]) && !empty($exp_gp[$key]))
                    experienceArr['exp_gp'] = <?php echo $exp_gp[$key]; ?>; 
                @endif
                @if(isset($exp_gross[$key]) && !empty($exp_gross[$key]))
                    experienceArr['exp_gross'] = <?php echo $exp_gross[$key]; ?>; 
                @endif
                @if(isset($nature_of_duties[$key]) && !empty($nature_of_duties[$key]))
                    experienceArr['nature_of_duties'] = '<?php echo $nature_of_duties[$key]; ?>'; 
                @endif
                
                          
                add_experience_row(experienceArr);
            @endforeach
        @else
            // for new row
            add_experience_row();
        @endif
    });
    // on click add row button
    $('#exp_add_id').click(function(){
        let flag = true;
        // check if column is empty or not
        $('.exp_from, .exp_to, .exp_total, .exp_org_name, .exp_prev_desig, .exp_gross, .nature_of_duties').each(function(){
            if($(this).val()=='')
            {
                alert("Enter the value");
                $(this).focus();
                flag = false;
                return flag;
            }
            if ($(this).attr("class").search("exp_gross") != -1 && $(this).val() == 0) {
                alert("Enter the value");
                $(this).focus();
                flag = false;
                return flag;
            }

        });
        if(flag == true){
            add_experience_row();
        }
    });
    // remove row on click Remove button
    $('#exp_rem_id').click(function(){	
        let noOfRows = $('#experienceTBody tr').length;
        let minRows = 1;
        
        if(noOfRows > minRows){ 
            // remove row
            $('#experienceTBody tr:last').remove(); 
            $('#exp_grand_total').trigger('click');
        }else{
            alert("Please provide minimum required experience informations.");
        }
    });
    // clear 
    $('#exp_clear').click(function(){		 
        $('.exp_from, .exp_to, .exp_total, .exp_org_name, .exp_prev_desig, .exp_gross, .nature_of_duties').each(function(){
            $(this).val(''); 
        });
        $('.exp_gp, .exp_gross').each(function(){
            $(this).val('0');
        });
        $('#exp_grand_total').val('');
        $('#exp_grand_total').trigger('click');
    }); 
    // function to add experience row
    function add_experience_row(experienceArr=[]){
        let rowsHtml = "";
        rowsHtml += experience_row(experienceArr);
        $('#experienceTBody').append(rowsHtml);
    }
    // experience row html
    function experience_row(experienceArr=[]){

        let html = "";
            html += '<tr class="exp_rec_row">';      
            //.exp_from, .exp_to, .exp_total, .exp_org_name, .exp_prev_desig, .exp_gp, .exp_gross
            @if(!empty($fieldsArray) && in_array('exp_from', $fieldsArray))        
                let exp_from = "";
                if(typeof experienceArr['exp_from'] != "undefined"){
                    exp_from = experienceArr['exp_from'];
                }         
                let exp_to = "";
                if(typeof experienceArr['exp_to'] != "undefined"){
                    exp_to = experienceArr['exp_to'];
                }
                html += '<td><input name="exp_from[]" value="'+exp_from+'" type="date" style="width:200px;" class="exp_from form-control calculate_experience"/></td>';
                html += '<td><input name="exp_to[]" value="'+exp_to+'" type="date" style="width:200px;" class="exp_to form-control calculate_experience"/></td>';
            @endif  
            @if(!empty($fieldsArray) && in_array('totalexperience', $fieldsArray)) 
                let exp_total = "";
                if(typeof experienceArr['exp_total'] != "undefined"){
                    exp_total = experienceArr['exp_total'];
                }
                html += '<td><input name="exp_total[]" value="'+exp_total+'" readonly="readonly"  type="text" style="width:250px;" class="exp_total form-control" /></td>';
            @endif
            @if(!empty($fieldsArray) && in_array('designation', $fieldsArray)) 
                let exp_prev_desig = "";
                if(typeof experienceArr['exp_prev_desig'] != "undefined"){
                    exp_prev_desig = experienceArr['exp_prev_desig'];
                }
                html += '<td><div class="form-group"><input name="exp_prev_desig[]" value="'+exp_prev_desig+'" type="text" style="width:300px;" class="exp_prev_desig form-control"/></div></td>';
            @endif  
            
            // nature_of_duties start
            let nature_of_duties = "";
            if(typeof experienceArr['nature_of_duties'] != "undefined"){
                nature_of_duties = experienceArr['nature_of_duties'];
            }
            html += '<td><div class="form-group"><input name="nature_of_duties[]" value="'+nature_of_duties+'" type="text" style="width:300px;" class="nature_of_duties form-control"/></div></td>';
            // nature_of_duties end
            
            @if(!empty($fieldsArray) && in_array('nameoftheorganisation', $fieldsArray))    
                let exp_org_name = "";
                if(typeof experienceArr['exp_org_name'] != "undefined"){
                    exp_org_name = experienceArr['exp_org_name'];
                } 
                html += '<td><div class="form-group"><input name="exp_org_name[]" value="'+exp_org_name+'" type="text" style="width:450px;" class="exp_org_name form-control"/></div></td>';       
            @endif        
            @if(!empty($fieldsArray) && in_array('gradepay', $fieldsArray)) 
                let exp_gp = "";
                if(typeof experienceArr['exp_gp'] != "undefined"){
                    exp_gp = experienceArr['exp_gp'];
                }
                html += '<td><div class="form-group"><input name="exp_gp[]" value="'+exp_gp+'" type="text"  style="width:100px;" class="exp_gp form-control"/></div></td>';
            @endif
            @if(!empty($fieldsArray) && in_array('grosspay', $fieldsArray)) 
                let exp_gross = "";
                if(typeof experienceArr['exp_gross'] != "undefined"){
                    exp_gross = experienceArr['exp_gross'];
                }
                html += '<td><div class="form-group"><input name="exp_gross[]" value="'+exp_gross+'" type="text" style="width:100px;" class="exp_gross form-control"/></div></td>';              
            @endif
            html += '</tr>';
        return html;    
    }

    // on select date for experience_to field
    $('#exp').on('focusout','.exp_to',function(){				  	  				 
        let index = $(this).parent().parent().index();			
        let e_from = $('#exp tbody tr:eq('+index+') td').find('.exp_from').val();	 
        let e_to = $('#exp tbody tr:eq('+index+') td').find('.exp_to').val();		
        //console.log('i: '+i);	
        //console.log('e_from: '+e_from);
        //console.log('e_to: '+e_to);	  				  		 				  
          		
        /*
        var last_dt = $('#last_dt').val();
        var exp_to = $(this).val();									
        if(new Date(exp_to) > new Date(last_dt))
        { 
            alert("Please select the last date of advt for the current employment.");
            $(this).val(last_dt);
        }
        */
        if(e_from!='' && e_to!='')	
        {
            if(e_to>e_from)
            {							
                getCalculatedExperience(index, e_from, e_to);		  									
            }
            else
            { 
                alert("Please correct the date order"); 
                $('#exp tbody tr:eq('+index+') td').find('.exp_total').val('');  
                $('.exp_total')   
            }
        }
        else
        { 				  		
            if(e_from=='')
            {	
                $('#exp tbody tr:eq('+index+') td').find('.exp_from').focus();  
            }
            else
            {	
                $('#exp tbody tr:eq('+index+') td').find('.exp_to').focus();  
            }						
        }
    });

    
</script>
