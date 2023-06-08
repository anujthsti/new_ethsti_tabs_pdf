<?php
$is_patent_tab = $jobValidations[0]['is_patent_tab'];
?>
<!--Patent Information-->
@if($is_patent_tab == 1)  
    <?php
    $patent_check = old('patent_check');
    $patent_information = old('patent_information');
    $no_patents_filed_national = old('no_patents_filed_national');
    $no_patents_granted_national = old('no_patents_granted_national');
    $no_patents_filed_international = old('no_patents_filed_international');
    $no_patents_granted_international = old('no_patents_granted_international');
    if(isset($candidatesPHDResearchDetails) && !empty($candidatesPHDResearchDetails)){
        $patent_check = $candidatesPHDResearchDetails[0]['is_have_patents'];
        $patent_information = $candidatesPHDResearchDetails[0]['patent_information'];
        $no_patents_filed_national = $candidatesPHDResearchDetails[0]['no_patents_filed_national'];
        $no_patents_granted_national = $candidatesPHDResearchDetails[0]['no_patents_granted_national'];
        $no_patents_filed_international = $candidatesPHDResearchDetails[0]['no_patents_filed_international'];
        $no_patents_granted_international = $candidatesPHDResearchDetails[0]['no_patents_granted_international'];
    }
    ?>
    <div class="row mt-3" id="patent">       
        <div class="form-group col-12">
            <label class="form-check-label mr-1">Do you have patent/s?</label>
            <div class="form-check form-check-inline">
                <input name="patent_check" class="patent_check" checked type="radio" value="0" <?php echo ($patent_check==0)?'checked':''; ?> />
                <label class="form-check-label ml-1 mr-1">No</label> 
                <input name="patent_check" class="patent_check" type="radio" value="1" <?php echo ($patent_check==1)?'checked':''; ?>  />
                <label class="form-check-label ml-1 mr-1">Yes</label>
            </div>
        </div> 
    </div>   
    <div class="row mt-3 patent_hide">        
        <div class="form-group col-md-3">
            <label>Number of patents filed (National)</label>
            <input type="number" name="no_patents_filed_national" class="form-control" value="{{ $no_patents_filed_national }}">
        </div>
        <div class="form-group col-md-3">
            <label>Number of patents granted (National)</label>
            <input type="number" name="no_patents_granted_national" class="form-control" value="{{ $no_patents_granted_national }}">
        </div>
        <div class="form-group col-md-3">
            <label>Number of patents filed (International)</label>
            <input type="number" name="no_patents_filed_international" class="form-control" value="{{ $no_patents_filed_international }}">
        </div>
        <div class="form-group col-md-3">
            <label>Number of patents granted (International)</label>
            <input type="number" name="no_patents_granted_international" class="form-control" value="{{ $no_patents_granted_international }}">
        </div>
    </div>    
    <div class="row mt-3" id="patent">     
        <div class="form-group col-12 patent_hide">
            <textarea name="patent_information" id="patent_information" autocomplete="off" maxlength="250" class="form-control col-12" placeholder="Add Patent information, if any"><?php echo $patent_information; ?></textarea>
        </div>                            
    </div>
@endif
<!--End of Patent seection-->

<script>

    @if($patent_check == 1)
        $('.patent_hide').show(); 
    @else
        $('.patent_hide').hide(); 
    @endif
//check patent
  $('.patent_check').click(function(){						
        if($(this).val()==1){ 
            $('.patent_hide').show(); 
        }
        else{ 
            $('.patent_hide').hide(); 
        }										
  });
</script>

                  