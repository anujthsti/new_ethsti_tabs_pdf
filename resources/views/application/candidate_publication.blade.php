    <?php
    $is_publication_tab = $jobValidations[0]['is_publication_tab'];
    ?>
    <!-- Publications section -->
    @if($is_publication_tab == 1)  
    <?php
    $pub_check = old('pub_check');
    $no_of_pub = old('no_of_pub');
    $no_of_first_author_pub = old('no_of_first_author_pub');
    $no_of_cors_author_pub = old('no_of_cors_author_pub');
    $no_of_pub_impact_fact = old('no_of_pub_impact_fact');
    $no_of_citations = old('no_of_citations');
    
    if(isset($candidatesPHDResearchDetails) && !empty($candidatesPHDResearchDetails)){
        $pub_check = 1;
        $no_of_pub = $candidatesPHDResearchDetails[0]['no_of_pub'];
        $no_of_first_author_pub = $candidatesPHDResearchDetails[0]['no_of_first_author_pub'];
        $no_of_cors_author_pub = $candidatesPHDResearchDetails[0]['no_of_cors_author_pub'];
        $no_of_pub_impact_fact = $candidatesPHDResearchDetails[0]['no_of_pub_impact_fact'];
        $no_of_citations = $candidatesPHDResearchDetails[0]['no_of_citations'];
    }
    ?>
    <div class="row">
        
        <div class="form-group form-row col-12">
            <label class="form-check-label mr-1">Do you have publication/s?</label> 
            <div class="form-check form-check-inline">
                <input name="pub_check" class="pub_check" type="radio" checked value="0" <?php echo ($pub_check==0)?'checked':'disabled'; ?> />
                <label class="form-check-label ml-1 mr-1">No</label> 
                <input name="pub_check" class="pub_check" type="radio" value="1" <?php echo ($pub_check==1)?'checked':''; ?> />
                <label class="form-check-label ml-1 mr-1">Yes</label> 
            </div>
        </div>
        
        <div id="pub_hide" class="form-group form-row col-12 mt-1">
            <h4 class="text-primary">Publications Details</h4>
            <table class="table table-bordered table-sm table-hover table-responsive table-hover" id="pub" >     
                <thead>
                    <tr>
                        <th>Total number of publications</th>
                        <th>Total number of first author publications</th>
                        <th>Total number of publications as corresponding author</th>
                        <th>Total number of publications during the last five years in journals with impact factor > 5</th>
                        <th>Total number of citations</th>
                    </tr>
                </thead>
                <tbody id="publicationTBody">
                    <tr>
                        <td><input type="number" name="no_of_pub" value="{{ $no_of_pub }}" class="form-control"></td>
                        <td><input type="number" name="no_of_first_author_pub" value="{{ $no_of_first_author_pub }}" class="form-control"></td>
                        <td><input type="number" name="no_of_cors_author_pub" value="{{ $no_of_cors_author_pub }}" class="form-control"></td>
                        <td><input type="number" name="no_of_pub_impact_fact" value="{{ $no_of_pub_impact_fact }}" class="form-control"></td>
                        <td><input type="number" name="no_of_citations" value="{{ $no_of_citations }}" class="form-control"></td>
                    </tr>
                </tbody>  
            </table>                          
            
        </div>                
    </div>
    @endif
    <!-- End of publicaiton section--> 


<script>
    
    //check publication
    $('.pub_check').click(function(){						
        if($(this).val()==1){ 
            $('#pub_hide').show(); 
        }
        else{ 
            $('#pub_hide').hide(); 
        }										
    });
    

</script>    