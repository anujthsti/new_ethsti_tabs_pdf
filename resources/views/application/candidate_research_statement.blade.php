<?php
$is_research_tab = $jobValidations[0]['is_research_tab'];
?>
<!-- Research Statement-->  
@if($is_research_tab == 1)  
    <?php
    $rs_check = old('rs_check');
    $research_statement = old('research_statement');
    if(isset($candidatesPHDResearchDetails) && !empty($candidatesPHDResearchDetails)){
        $rs_check = 1;
        $research_statement = $candidatesPHDResearchDetails[0]['research_statement'];
    }
    ?>
    <div class="row" id="research" > 
        <div class="form-group col-12">
            <label class="form-check-label mr-1" >Do you want to submit research statement/proposal ? </label>
            <div class="form-check form-check-inline">
                <input name="rs_check" class="rs_check" checked type="radio" value="0" <?php echo ($rs_check==0)?'checked':''; ?> />
                <label class="form-check-label mr-1 ml-1">No</label>
                <input name="rs_check" class="rs_check" type="radio" value="1" <?php echo ($rs_check==1)?'checked':''; ?> />
                <label class="form-check-label ml-1 mr-1">Yes</label> 
            </div>
        </div>
        <div class="form-group col-12" id="rs_hide"> 
            <textarea name="research_statement" id="research_statement" class="form-control col-12"><?php echo $research_statement; ?></textarea>
            <div class="text-info col-lg-12"></div>                                  
        </div>
    </div>
@endif
<!--End of Patent section-->

<script>
  //check research statement
  $('.rs_check').click(function(){						
        if($(this).val()==1){ 
            $('#rs_hide').show(); 
        }
        else{ 
            $('#rs_hide').hide(); 
        }										
  });
</script>
          