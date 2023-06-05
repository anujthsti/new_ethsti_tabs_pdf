<?php
    $is_publication_tab = $jobValidations[0]['is_publication_tab'];
    ?>
    <!-- Publications section -->
    @if($is_publication_tab == 1)  
    <?php
    $pub_check = old('pub_check');
    $pub_no = old('pub_no');
    $pub_author = old('pub_author');
    $pub_article = old('pub_article');
    $pub_journal = old('pub_journal');
    $pub_vol = old('pub_vol');
    $pub_doi = old('pub_doi');
    $pub_mid = old('pub_mid');
    if(isset($candidatesPublicationsDetails) && !empty($candidatesPublicationsDetails)){
        $pub_check = 1;
        $pub_no = array_column($candidatesPublicationsDetails, 'publication_number');
        $pub_author = array_column($candidatesPublicationsDetails, 'authors');
        $pub_article = array_column($candidatesPublicationsDetails, 'article_title');
        $pub_journal = array_column($candidatesPublicationsDetails, 'journal_name');
        $pub_vol = array_column($candidatesPublicationsDetails, 'year_volume');
        $pub_doi = array_column($candidatesPublicationsDetails, 'doi');
        $pub_mid = array_column($candidatesPublicationsDetails, 'pubmed_pmid');
    }
    ?>
    <div class="row col-12">
        
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
                        @if(!empty($fieldsArray) && in_array('selectnumberinpublication', $fieldsArray)) 
                        <th>Select Number in Publication</th>
                        @endif
                        @if(!empty($fieldsArray) && in_array('listofauthors', $fieldsArray))
                        <th>List of authors</th>
                        @endif
                        @if(!empty($fieldsArray) && in_array('titleofthearticle', $fieldsArray))
                        <th>Title of the article</th>
                        @endif
                        @if(!empty($fieldsArray) && in_array('journalname', $fieldsArray))
                        <th>Journal name</th>
                        @endif
                        @if(!empty($fieldsArray) && in_array('yearvolumeissue', $fieldsArray))
                        <th>Year;Volume(Issue)</th>   
                        @endif
                        @if(!empty($fieldsArray) && in_array('doi', $fieldsArray))     
                        <th>Doi</th>        
                        @endif
                        @if(!empty($fieldsArray) && in_array('pubmedpmid', $fieldsArray))
                        <th>PubMed PMID</th> 
                        @endif       
                    </tr>
                </thead>
                <tbody id="publicationTBody">

                </tbody>  
            </table>                          
            <div class="col-12 action_buttons_row" align="right">
                <button type="button" class="btn btn-primary" id="pub_add_id" >Add</button>&nbsp;
                <button type="button" class="btn btn-primary" id="pub_rem_id" >Remove</button>&nbsp;
                <button class="btn btn-primary" type="button" id="pub_clear" >Clear</button>
            </div> 
        </div>                
    </div>
    @endif
    <!-- End of publicaiton section--> 


<script>
    // on document ready
    $(document).ready(function(){

        $('.pub_check').trigger('click');
        $('.patent_check').trigger('click');
        $('.rs_check').trigger('click');
        //$('.rel_check').trigger('click');
        /*
        let rowLength = $("#publicationTBody").length;
        if( rowLength != 0) {
            alert(rowLength);
            let pubRowsHtml = "";
            let index = 1;
            console.log("index: "+index);
            pubRowsHtml = publication_row_html(index);
            $('#publicationTBody').append(pubRowsHtml);
        }
        */
        let pubRowsHtml = "";
        @if(!empty($pub_no))
            let publicationArr = [];
            // for experience alredy added educations
            /*
            @foreach($pub_no as $key=>$number)
                pubRowsHtml = "";
                publicationArr = [];
                publicationArr['pub_author'] = "";
                publicationArr['pub_article'] = "";
                publicationArr['pub_journal'] = "";
                publicationArr['pub_vol'] = "";
                publicationArr['pub_doi'] = "";
                publicationArr['pub_mid'] = "";
                publicationArr['pub_no'] = '<?php echo $number; ?>';
                 
                @if(isset($pub_author[$key]) && !empty($pub_author[$key]))
                    publicationArr['pub_author'] = '<?php echo $pub_author[$key]; ?>'; 
                    alert(publicationArr['pub_author']);
                @endif
                @if(isset($pub_article[$key]) && !empty($pub_article[$key]))
                    publicationArr['pub_article'] = '<?php echo $pub_article[$key]; ?>'; 
                @endif
                @if(isset($pub_journal[$key]) && !empty($pub_journal[$key]))
                    publicationArr['pub_journal'] = '<?php echo $pub_journal[$key]; ?>'; 
                @endif
                @if(isset($pub_vol[$key]) && !empty($pub_vol[$key]))
                    publicationArr['pub_vol'] = '<?php echo $pub_vol[$key]; ?>'; 
                @endif
                @if(isset($pub_doi[$key]) && !empty($pub_doi[$key]))
                    publicationArr['pub_doi'] = '<?php echo $pub_doi[$key]; ?>'; 
                @endif
                @if(isset($pub_mid[$key]) && !empty($pub_mid[$key]))
                    publicationArr['pub_mid'] = '<?php echo $pub_mid[$key]; ?>'; 
                @endif
                alert(publicationArr['pub_author']);  
                alert(JSON.stringify(publicationArr));      
                pubRowsHtml = publication_row_html(publicationArr);
                console.log(JSON.stringify(publicationArr));
                $('#publicationTBody').append(pubRowsHtml);
            @endforeach
            */
            let pub_author = "";
            let pub_article = "";
            let pub_journal = "";
            let pub_vol = "";
            let pub_doi = "";
            let pub_mid = "";
            let pub_no = "";
            @foreach($pub_no as $key=>$number)
                pubRowsHtml = "";
                pub_author = "";
                pub_article = "";
                pub_journal = "";
                pub_vol = "";
                pub_doi = "";
                pub_mid = "";
                pub_no = '<?php echo $number; ?>';
                 
                @if(isset($pub_author[$key]) && !empty($pub_author[$key]))
                    pub_author = '<?php echo $pub_author[$key]; ?>'; 
                @endif
                @if(isset($pub_article[$key]) && !empty($pub_article[$key]))
                    pub_article = '<?php echo $pub_article[$key]; ?>'; 
                @endif
                @if(isset($pub_journal[$key]) && !empty($pub_journal[$key]))
                    pub_journal = '<?php echo $pub_journal[$key]; ?>'; 
                @endif
                @if(isset($pub_vol[$key]) && !empty($pub_vol[$key]))
                    pub_vol = '<?php echo $pub_vol[$key]; ?>'; 
                @endif
                @if(isset($pub_doi[$key]) && !empty($pub_doi[$key]))
                    pub_doi = '<?php echo $pub_doi[$key]; ?>'; 
                @endif
                @if(isset($pub_mid[$key]) && !empty($pub_mid[$key]))
                    pub_mid = '<?php echo $pub_mid[$key]; ?>'; 
                @endif
                
                pubRowsHtml = publication_row_html(pub_no, pub_author, pub_article, pub_journal, pub_vol, pub_doi, pub_mid);
                $('#publicationTBody').append(pubRowsHtml);
            @endforeach
        @else
            // for new row
            pubRowsHtml = publication_row_html();
            $('#publicationTBody').append(pubRowsHtml);
        @endif
    });
    // add publication row
    $('#pub_add_id').click(function(){		 
        flag=true;
        $('.no_pub, .pub_no, .pub_auth, .pub_article, .pub_journal, .pub_vol, .pub_mid').each(function(){
            if($(this).val()==''){
                alert("Enter the value");
                $(this).focus();
                flag=false;
                return flag;
            }			
        });
        
        if(flag){
            let pubRowsHtml = "";
            let numRows = $('#publicationTBody tr').length;
            let index = numRows + 1;
            pubRowsHtml = publication_row_html();
            $('#publicationTBody').append(pubRowsHtml);
        }		 				
    });	  
    // remove publication last row
    $('#pub_rem_id').click(function(){		
        let noOfRows = $('#publicationTBody tr').length;
        let minRows = 1; 
        if(noOfRows > minRows){ 
            // remove row
            $('#publicationTBody tr:last').remove(); 
        }else{
            alert("You can't remove the first row.");
        }
    });
    // clear publications
    $('#pub_clear').click(function(){		 
        $('.no_pub, .pub_no, .pub_auth, .pub_article, .pub_journal, .pub_vol, .pub_mid').each(function(){
            $(this).val(''); 
        });		  
    }); 

    //check publication
    $('.pub_check').click(function(){						
        if($(this).val()==1){ 
            $('#pub_hide').show(); 
        }
        else{ 
            $('#pub_hide').hide(); 
        }										
    });
    
    //check patent
    $('.patent_check').click(function(){						
        if($(this).val()==1)
        { $('#patent_hide').show(); }
        else
        { $('#patent_hide').hide(); }										
    });
    
    //check research statement
    $('.rs_check').click(function(){						
        if($(this).val()==1)
        { $('#rs_hide').show(); }
        else
        { $('#rs_hide').hide(); }										
    });
    
    //check relative
    $('.rel_check').click(function(){						
        if($(this).val()==1)
        { $('#rel_hide').show(); }
        else
        { $('#rel_hide').hide(); }										
    });
        

    function publication_row_html(pub_no="", pub_author="", pub_article="", pub_journal="", pub_vol="", pub_doi="", pub_mid=""){

        let publication_article = pub_article;
        let publication_author = pub_author;
        let publication_journal = pub_journal;
        let pubmedpmid = pub_mid;
        
        let html = "";
            // publication number dropdown column start
            html += '<tr class="pub_rec">';
            @if(!empty($fieldsArray) && in_array('selectnumberinpublication', $fieldsArray)) 
                let pubNoDropdownHtml = getPublicationNoDropdownHtml(pub_no);
                //console.log('pubNoDropdownHtml: '+pubNoDropdownHtml);
                html += '<td>'+pubNoDropdownHtml+'</td>';
            @endif
            // publication number dropdown column end
            // publication author column start
            @if(!empty($fieldsArray) && in_array('listofauthors', $fieldsArray))
                html += '<td>';
                    html += '<textarea name="pub_author[]"  type="text" rows="1"  class="pub_auth form-control">';
                    html += publication_author;
                    html += '</textarea>';
                html += '</td>';
            @endif
            // publication author column end
            // title of the article column start
            @if(!empty($fieldsArray) && in_array('titleofthearticle', $fieldsArray))
                html += '<td>';
                html += '<textarea name="pub_article[]" type="text" rows="1" class="pub_article form-control">'+publication_article+'</textarea></td>';
                html += '</td>';
            @endif
            // title of the article column end
            // journal name column start
            @if(!empty($fieldsArray) && in_array('journalname', $fieldsArray))
                html += '<td>';
                html += '<textarea name="pub_journal[]" type="text"  rows="1" class="pub_journal form-control">'+publication_journal+'</textarea>';
                html += '</td>';    
            @endif
            // journal name column end
            // journal name column start
            @if(!empty($fieldsArray) && in_array('yearvolumeissue', $fieldsArray))
                html += '<td>';
                    html += '<div class="form-group">';
                        html += '<input name="pub_vol[]" value="'+pub_vol+'" type="text" style="width:450px;" class="pub_vol form-control" />';
                    html += '</div>';    
                html += '</td>';    
            @endif
            // journal name column end
            // doi column start        
            @if(!empty($fieldsArray) && in_array('doi', $fieldsArray))     
                html += '<td>';
                    html += '<input name="pub_doi[]" value="'+pub_doi+'" type="text" class="pub_doi form-control" />';
                html += '</td>';       
            @endif
            // doi column end
            // pubmedpmid column start        
            @if(!empty($fieldsArray) && in_array('pubmedpmid', $fieldsArray))     
                html += '<td>';
                    html += '<input name="pub_mid[]" value="'+pubmedpmid+'" type="text" class="pub_mid form-control" />';
                html += '</td>';       
            @endif
            // pubmedpmid column end
            html += '</tr>';
        return html;    
    }            
    
    function getPublicationNoDropdownHtml(pub_no){

        /*let pubNum = 1;
        if(pubNumArr.length > 0){
            pubNum = pubNumArr[rowIndex];
        }*/
        let html = "";
            html += '<Select name="pub_no[]" class="pub_no form-control">';
                html += '<option selected="selected" value="">SELECT</option>';
                html += '<option value="NA">NA</option>';
                let selected = "";
                let num = 1; 
                while( num <= 20 ){ 
                    if(pub_no == num){
                        selected = "selected";
                    } 
                    html += '<option value="'+num+'" '+selected+'>'+num+'</option>';    
                    selected = "";
                    num++;
                }
            html += '</Select>';
        return html;    
    }

</script>    