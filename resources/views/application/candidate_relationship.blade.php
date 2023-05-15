@if(!empty($fieldsArray) && in_array('nameofthepersons', $fieldsArray)) 
    <?php
    $rel_check = old('rel_check');
    $rel_person_name = old('rel_person_name');
    $rel_person_designation = old('rel_person_designation');
    $rel_person_relationship = old('rel_person_relationship');
    if(isset($candidateJobApplyDetail) && !empty($candidateJobApplyDetail)){
        $rel_person_name = $candidateJobApplyDetail[0]['relative_name'];
        $rel_person_designation = $candidateJobApplyDetail[0]['relative_designation'];
        $rel_person_relationship = $candidateJobApplyDetail[0]['relative_relationship'];
        if(!empty($rel_person_name)){
            $rel_check = 1;
        }
    }
    ?>
    <div class="row" id="relatives">
        <div class="form-group col-lg-12 col-md-12">
            <label class="form-check-label mr-1">Do you have any near relative/friend working in THSTI. If so, please state?</label>
            <div class="form-check form-check-inline">
                <input name="rel_check" class="rel_check" checked type="radio" value="0" <?php echo ($rel_check==0)?'checked':'disabled'; ?> />
                <label class="form-check-label mr-1 ml-1">No</label>
                <input name="rel_check" class="rel_check" type="radio" value="1" <?php echo ($rel_check==1)?'checked':''; ?>/>
                <label class="form-check-label mr-1 ml-1" >Yes</label>
            </div>
        </div>
        <div id="rel_hide" style="display:none;" class="col-12">
            <table class="table table-bordered table-sm table-hover table-responsive-lg">
                <thead class="bg-light">
                    <tr>
                        <th>Name of the person(s)</th>
                        @if(!empty($fieldsArray) && in_array('designation', $fieldsArray)) 
                        <th>Designation</th>
                        @endif
                        @if(!empty($fieldsArray) && in_array('relationshipwiththecandidate', $fieldsArray)) 
                        <th>Relationship with the candidate</th>   
                        @endif                 
                    </tr>
                </thead>          
                <tbody>
                    <tr>                
                        <td>
                            <div class="form-group">
                                <input class="form-control" value="<?php echo $rel_person_name; ?>" name="rel_person_name" type="text" autocomplete="off" />
                            </div>
                        </td>       
                        @if(!empty($fieldsArray) && in_array('designation', $fieldsArray))  
                        <td>
                            <div class="form-group">
                                <input class="form-control" value="<?php echo $rel_person_designation; ?>" name="rel_person_designation" type="text" autocomplete="off" />
                            </div>
                        </td>         
                        @endif
                        @if(!empty($fieldsArray) && in_array('relationshipwiththecandidate', $fieldsArray)) 
                        <td>
                            <div class="form-group">
                                <input class="form-control" value="<?php echo $rel_person_relationship; ?>" width="200px" name="rel_person_relationship" type="text" autocomplete="off" />
                            </div>
                        </td>
                        @endif
                    </tr>
                </tbody>
            </table>        
        </div>        
    </div>
@endif
<!--end of relationship section-->

<script>

    $(document).ready(function(){
        @if(isset($rel_check) && $rel_check == 1)
            $('#rel_hide').show(); 
        @endif
    });
    //check relative
    $('.rel_check').click(function(){						
        if($(this).val()==1){ 
            $('#rel_hide').show(); 
        }
        else{ 
            $('#rel_hide').hide(); 
        }										
    });
</script>