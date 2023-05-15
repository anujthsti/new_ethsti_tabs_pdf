

<!--referecen section-->   
@if(!empty($fieldsArray) && in_array('nameofrefree', $fieldsArray))   
    <?php
    $ref_name = old('ref_name');
    $ref_desig = old('ref_desig');
    $ref_org = old('ref_org');
    $ref_email = old('ref_email');
    $ref_phone = old('ref_phone');
    $ref_mob = old('ref_mob');
    if(isset($existingRefreeDetails) && !empty($existingRefreeDetails)){
        $ref_name = array_column($existingRefreeDetails, 'refree_name');
        $ref_desig = array_column($existingRefreeDetails, 'designation');
        $ref_org = array_column($existingRefreeDetails, 'organisation');
        $ref_email = array_column($existingRefreeDetails, 'email_id');
        $ref_phone = array_column($existingRefreeDetails, 'phone_no');
        $ref_mob = array_column($existingRefreeDetails, 'mobile_no');
    }
    ?>
    <div class="row"> 
           <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="text-primary h4">Referee's Details</div>             
                <table class="table table-bordered table-sm table-responsive-lg table-hover" id="referee">     
                    <thead class="bg-light">
                        <tr>
                            <th>Name of the Refree</th>
                            <th>Designation</th>
                            <th>Organisation</th>
                            <th>Email Id</th>
                            <th>Phone No</th>        
                            <th>Mobile No</th>        
                        </tr>
                    </thead>
                    <tbody id="refreeTBody">

                    </tbody>
                </table>    
                <div class="text-right">
                    <button class="btn btn-primary" type="button" id="ref_add_id" >Add</button>&nbsp;
                    <button class="btn btn-primary" type="button" id="ref_rem_id" style="display:none;">Remove</button>&nbsp;
                    <button class="btn btn-primary" type="button" id="ref_clear" >Clear</button>
                </div>          
           </div>  
    </div>    
@endif       
<!--end of reference section-->      

<script>

    $(document).ready(function(){
        
        @if(!empty($ref_name))
            // for experience alredy added educations
            @foreach($ref_name as $key=>$refree_name)
                //.exp_from, .exp_to, .exp_total, .exp_org_name, .exp_prev_desig, .exp_gp, .exp_gross
                refreeArr = [];
                refreeArr['ref_name'] = "";
                refreeArr['ref_desig'] = "";
                refreeArr['ref_org'] = "";
                refreeArr['ref_email'] = "";
                refreeArr['ref_phone'] = "";
                refreeArr['ref_mob'] = "";
                
                refreeArr['ref_name'] = '<?php echo $refree_name; ?>';
                @if(isset($ref_desig[$key]) && !empty($ref_desig[$key]))
                    refreeArr['ref_desig'] = '<?php echo $ref_desig[$key]; ?>'; 
                @endif
                @if(isset($ref_org[$key]) && !empty($ref_org[$key]))
                    refreeArr['ref_org'] = '<?php echo $ref_org[$key]; ?>'; 
                @endif
                @if(isset($ref_email[$key]) && !empty($ref_email[$key]))
                    refreeArr['ref_email'] = '<?php echo $ref_email[$key]; ?>'; 
                @endif
                @if(isset($ref_phone[$key]) && !empty($ref_phone[$key]))
                    refreeArr['ref_phone'] = <?php echo $ref_phone[$key]; ?>; 
                @endif
                @if(isset($ref_mob[$key]) && !empty($ref_mob[$key]))
                    refreeArr['ref_mob'] = <?php echo $ref_mob[$key]; ?>; 
                @endif
                          
                add_refree_row(refreeArr);
            @endforeach
        @else
            // for new row
            refreeArr = [];
            refreeArr['ref_name'] = "";
            refreeArr['ref_desig'] = "";
            refreeArr['ref_org'] = "";
            refreeArr['ref_email'] = "";
            refreeArr['ref_phone'] = "";
            refreeArr['ref_mob'] = "";
            add_refree_row(refreeArr);
        @endif

    });

    $('#ref_add_id').click(function(){		 
        let flag = true;
        $('.ref_name, .ref_desig, .ref_org, .ref_email, .ref_phone, .ref_mob').each(function(){
            if($(this).val()=='')
            {
                alert("Enter the value");
                $(this).focus();
                flag = false;
                return flag;
            }			
        });
        //alert(flag);
        if(flag == true){
            //alert(flag);
            let pubRowsHtml = "";
            let numRows = $('#refreeTBody tr').length;
            let index = numRows + 1;
            if(numRows <= 3){
                add_refree_row();
            }else{ 
                alert("Maximum 3 references are requierd"); 
            }
        }	 				
    });	

    // remove refree row
    $('#ref_rem_id').click(function(){		
        let numRows = $('#refreeTBody tr').length; 
        if(numRows > 1){ 
            $('#refreeTBody tr:last').remove(); 
        }else{
            alert("Last row is required.");
        }
    });
    
    // clear refree details
    $('#ref_clear').click(function(){		 
        $('.ref_name, .ref_desig, .ref_org, .ref_email, .ref_phone, .ref_mob').each(function(){
            $(this).val(''); 
        });		  
    });

    function add_refree_row(refName=""){

        let retHtml = refree_row_html(refName);
        $("#refreeTBody").append(retHtml);
    }

    function refree_row_html(refreeArr){
        
        let html = "";
            html += '<tr>';
                html += '<td><div class="form-group"><input required="" name="ref_name[]" value="'+refreeArr['ref_name']+'" type="text" class="ref_name form-control" /></div></td>';
                html += '<td><div class="form-group"><input required="" name="ref_desig[]" value="'+refreeArr['ref_desig']+'" type="text" class="ref_desig form-control" /></div></td>';
                html += '<td><div class="form-group"><input required="" name="ref_org[]" value="'+refreeArr['ref_org']+'" type="text" class="ref_org form-control" /></div></td>';
                html += '<td><div class="form-group"><input required="" name="ref_email[]" value="'+refreeArr['ref_email']+'" type="email" class="ref_email form-control" /></div></td>';
                html += '<td><div class="form-group"><input required="" maxlength="12" minlength="10"  name="ref_phone[]" value="'+refreeArr['ref_phone']+'" type="number" class="ref_phone form-control" /></div></td>';
                html += '<td><div class="form-group"><input required="" maxlength="12" minlength="10" name="ref_mob[]"  width="200px" value="'+refreeArr['ref_mob']+'" type="number" class="ref_mob form-control" /></div></td>';
            html += '</tr>'; 
        return html;    
    }
</script>