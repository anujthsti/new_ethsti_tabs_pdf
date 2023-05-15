<?php
$educationMaster = Helper::getCodeNamesByCode($codeNamesArr,'code','education');
$exam_pass = old('exam_pass');
$mn_pass = old('mn_pass');
$yr_pass = old('yr_pass');
$subjects = old('subjects');
$board = old('board');
$percent = old('percent');
$cgpa = old('cgpa');
$division = old('division');
$duration_of_course = old('duration_of_course');
$phd_result = old('phd_result');
if(isset($academicDetails) && !empty($academicDetails)){
    $minJobEduRequired = array_column($academicDetails, 'education_id');
    $exam_pass = $minJobEduRequired;
    $mn_pass = array_column($academicDetails, 'month');
    $yr_pass = array_column($academicDetails, 'year');
    $subjects = array_column($academicDetails, 'degree_or_subject');
    $board = array_column($academicDetails, 'board_or_university');
    $percent = array_column($academicDetails, 'percentage');
    $cgpa = array_column($academicDetails, 'cgpa');
    $division = array_column($academicDetails, 'division');
    $duration_of_course = array_column($academicDetails, 'duration_of_course');
    $phd_result = array_column($academicDetails, 'phd_result');
}

?>
<!-- Academic block -->         
<div class="row">                      
    <div id="acad_id" class="col-lg-12 col-md-12">
        <div class="text-primary h4">Academic Details</div>
        <table class="table table-bordered table-hover table-sm table-responsive-lg" id="academics_detail_id" >
          <thead class="bg-light">
            <tr>
                @if(!empty($fieldsArray) && in_array('nameoftheexaminationpassed', $fieldsArray)) 
                <th>Name of the Examination Passed</th>
                @endif
                @if(!empty($fieldsArray) && in_array('yearofpassing', $fieldsArray)) 
                <th colspan="2">Month & Year of Passing </th>
                @endif
                <th>Total duration of course (in years)</th>
                @if(!empty($fieldsArray) && in_array('nameofthedegreesubjects', $fieldsArray)) 
                <th>Name of the degree/Subjects </th>
                @endif
                @if(!empty($fieldsArray) && in_array('boarduniversity', $fieldsArray)) 
                <th>Board / University</th>
                @endif
                @if(!empty($fieldsArray) && in_array('roundoff', $fieldsArray)) 
                <th>%<br/>(Round Off)</th>
                @endif
                @if(!empty($fieldsArray) && in_array('cgpa', $fieldsArray)) 
                <th>CGPA</th>
                @endif
                @if(!empty($fieldsArray) && in_array('division', $fieldsArray)) 
                <th>Division</th>       
                @endif     
            </tr> 
          </thead>     
          <tbody id="academicDetailsBody">
             
          </tbody>            
        </table>                                    
    </div>
    <div class="col-12 text-right">
        <button class="btn btn-primary" type="button" id="edu_add_id">Add</button>&nbsp;
        <button class="btn btn-primary" type="button" id="edu_rem_id">Remove</button>&nbsp;
        <button class="btn btn-primary" type="button" id="edu_clear" >Clear</button>
    </div>	
</div>	            	       	                        
<!-- End of academic block-->

<script>
    
    // when page loaded completely                            
    $(document).ready(function(){
        @if(!empty($minJobEduRequired))
            // for min. educations required or alredy added educations
            @foreach($minJobEduRequired as $key=>$minEducationID)
                minEducationID = <?php echo $minEducationID; ?>; 
                academicArr = [];
                academicArr['mn_pass'] = "";
                academicArr['yr_pass'] = "";
                academicArr['subjects'] = "";
                academicArr['board'] = "";
                academicArr['percent'] = "";
                academicArr['cgpa'] = "";
                academicArr['division'] = "";
                academicArr['duration_of_course'] = "";
                academicArr['phd_result'] = "";
                
                @if(isset($mn_pass[$key]) && !empty($mn_pass[$key]))
                    academicArr['mn_pass'] = <?php echo $mn_pass[$key]; ?>; 
                @endif
                @if(isset($yr_pass[$key]) && !empty($yr_pass[$key]))
                    academicArr['yr_pass'] = <?php echo $yr_pass[$key]; ?>; 
                @endif
                @if(isset($subjects[$key]) && !empty($subjects[$key]))
                    academicArr['subjects'] = '<?php echo $subjects[$key]; ?>'; 
                @endif
                @if(isset($board[$key]) && !empty($board[$key]))
                    academicArr['board'] = '<?php echo $board[$key]; ?>'; 
                @endif
                @if(isset($percent[$key]) && !empty($percent[$key]))
                    academicArr['percent'] = <?php echo $percent[$key]; ?>; 
                @endif
                @if(isset($cgpa[$key]) && !empty($cgpa[$key]))
                    academicArr['cgpa'] = <?php echo $cgpa[$key]; ?>; 
                @endif
                @if(isset($division[$key]) && !empty($division[$key]))
                    academicArr['division'] = '<?php echo $division[$key]; ?>'; 
                @endif
                @if(isset($duration_of_course[$key]) && !empty($duration_of_course[$key]))
                    academicArr['duration_of_course'] = <?php echo $duration_of_course[$key]; ?>; 
                @endif
                @if(isset($phd_result[$key]) && !empty($phd_result[$key]))
                    academicArr['phd_result'] = <?php echo $phd_result[$key]; ?>; 
                @endif
                
                academicDetailNewRow(minEducationID, academicArr);
            @endforeach
        @else
            // for new row
            academicDetailNewRow();
        @endif
    });

    // on click add new row button
    $("#edu_add_id").click(function(){
        let flag = true;
        $('.exam_pass:visible, .yr_pass:visible, .subject:visible, .board:visible, .percent:visible, .cgpa:visible, .division:visible, .duration_of_course:visible').each(function(){
            if($(this).val()=='')
            {
                alert("Enter the value");
                $(this).focus();
                flag = false;
                return flag;
            }			
        });
        if(flag == true){
            academicDetailNewRow();
        }
    });

    // remove row on click Remove button
    $('#edu_rem_id').click(function(){	
        let noOfRows = $('#academicDetailsBody tr').length;
        let minRows = 1;
        //console.log('noOfRows: '+noOfRows);
        let minReqEduRows = <?php echo count($minJobEduRequired); ?>;
        if(minReqEduRows > 1){
            minRows = minReqEduRows;
        }
        if(noOfRows > minRows){ 
            // remove row
            $('#academicDetailsBody tr:last').remove(); 
        }else{
            alert("Please provide minimum required educations informations.");
        }
    });
    
    // clear all fields on click Clear button
    $('#edu_clear').click(function(){		 
        $('.yr_pass, .subject, .board, .percent, .cgpa').each(function(){
            $(this).val(''); 
        });
    });

    function academicDetailNewRow(minEducationID="", academicArr=[]){

        let isExamNameField = 0;
        let isYearofpassing = 0;
        let isnameofthedegreesubjects = 0;
        let isboarduniversity = 0;
        let isroundoff = 0;
        let iscgpa = 0;
        let isdivision = 0;
        @if(!empty($fieldsArray) && in_array('nameoftheexaminationpassed', $fieldsArray)) 
            isExamNameField = 1;
        @endif
        @if(!empty($fieldsArray) && in_array('yearofpassing', $fieldsArray)) 
            isYearofpassing = 1;
        @endif
        @if(!empty($fieldsArray) && in_array('nameofthedegreesubjects', $fieldsArray)) 
            isnameofthedegreesubjects = 1;
        @endif
        @if(!empty($fieldsArray) && in_array('boarduniversity', $fieldsArray)) 
            isboarduniversity = 1;
        @endif
        @if(!empty($fieldsArray) && in_array('roundoff', $fieldsArray)) 
            isroundoff = 1;
        @endif
        @if(!empty($fieldsArray) && in_array('cgpa', $fieldsArray)) 
            iscgpa = 1;
        @endif
        @if(!empty($fieldsArray) && in_array('division', $fieldsArray)) 
            isdivision = 1;    
        @endif   
        // array of fields shown or not
        let formFieldsArr = {
                                isExamNameField: isExamNameField,
                                isYearofpassing: isYearofpassing,
                                isnameofthedegreesubjects: isnameofthedegreesubjects,
                                isboarduniversity: isboarduniversity,
                                isroundoff: isroundoff,
                                iscgpa: iscgpa,
                                isdivision: isdivision
                            }

        let rowsHtml = "";
        rowsHtml += academicDetailRowHtml(formFieldsArr, minEducationID, academicArr);
        $('#academicDetailsBody').append(rowsHtml);

    }

    // get html of academic details row
    function academicDetailRowHtml(formFieldsArr, minEducationID="", academicArr=[]){
        let rowHtml = "";
        // new row start
        rowHtml += "<tr>";
            // name of exam column start
            if(formFieldsArr['isExamNameField'] == 1){
                let retEduDropdownHtml = getEducationDropdown(minEducationID);
                rowHtml += '<td>'+retEduDropdownHtml+'</td>';
            }
            // name of exam column end
            // year of passing column start
            if(formFieldsArr['isYearofpassing'] == 1){
                let selectedMonth = "";
                let selectedYear = "";
                if(typeof academicArr['mn_pass'] != "undefined"){
                    selectedMonth = academicArr['mn_pass'];
                } 
                if(typeof academicArr['yr_pass'] != "undefined"){
                    selectedYear = academicArr['yr_pass'];
                }
                let retMonthsDropdownHtml = monthsDropdownHtml(selectedMonth);
                let retPassingYearHtml = passingYearHtml(selectedYear);
                rowHtml += '<td>'+retMonthsDropdownHtml+'</td>';
                rowHtml += '<td>'+retPassingYearHtml+'</td>';
            }
            // year of passing column end
            // total duration of course in Years starts
            let totalDuration = "";
            if(typeof academicArr['duration_of_course'] != "undefined"){
                totalDuration = academicArr['duration_of_course'];
            } 
            let durationOfCourseRetHtml = durationOfCourseHtml(totalDuration);
            rowHtml += '<td>'+durationOfCourseRetHtml+'</td>';
            // total duration of course in Years ends
            // name of degree/subject column start
            if(formFieldsArr['isnameofthedegreesubjects'] == 1){
                let selectedSubject = "";
                if(typeof academicArr['subjects'] != "undefined"){
                    selectedSubject = academicArr['subjects'];
                }
                let retDegreeSubHtml = degreeOrSubjectHtml(selectedSubject);
                rowHtml += '<td>'+retDegreeSubHtml+'</td>';
            }
            // name of degree/subject column end
            // name of board/university column start
            if(formFieldsArr['isboarduniversity'] == 1){
                let selectedBoard = "";
                if(typeof academicArr['board'] != "undefined"){
                    selectedBoard = academicArr['board'];
                }
                let retBoardUniHtml = boardOrUniversityHtml(selectedBoard);
                rowHtml += '<td>'+retBoardUniHtml+'</td>';
            }
            // name of board/university column end
            let displayNonPhdEduCol = "";
            let displayPhdEduCol = "display:none;";
            let phd_resultRequired = "";
            // code_names id 18 for PHD education -- fixed ID
            if(minEducationID != "" && minEducationID == 18){
                displayNonPhdEduCol = "display:none;";
                displayPhdEduCol = "";
                phd_resultRequired = "required";
            }
            let styleNonPhd = 'style="'+displayNonPhdEduCol+'"';
            let stylePhd = 'style="'+displayPhdEduCol+'"';
            
            // %/roundoff column start
            if(formFieldsArr['isroundoff'] == 1){
                let selectedPercent = "";
                if(typeof academicArr['percent'] != "undefined"){
                    selectedPercent = academicArr['percent'];
                }
                let retPercentRoundOffHtml = percentRoundoffHtml(selectedPercent,displayNonPhdEduCol);
                rowHtml += '<td class="non_phd_edu_col" '+styleNonPhd+'>'+retPercentRoundOffHtml+'</td>';
            }
            // %/roundoff column end
            // cgpa column start
            if(formFieldsArr['iscgpa'] == 1){
                let selectedCGPA = "";
                if(typeof academicArr['cgpa'] != "undefined"){
                    selectedCGPA = academicArr['cgpa'];
                }
                let retCgpaHtml = cgpaHtml(selectedCGPA,displayNonPhdEduCol);
                rowHtml += '<td class="non_phd_edu_col" '+styleNonPhd+'>'+retCgpaHtml+'</td>';
            }
            // cgpa column end
            // division column start
            if(formFieldsArr['isdivision'] == 1){
                let selectedDivision = "";
                if(typeof academicArr['division'] != "undefined"){
                    selectedDivision = academicArr['division'];
                }
                let retDivisionHtml = divisionHtml(selectedDivision,displayNonPhdEduCol);
                rowHtml += '<td class="non_phd_edu_col" '+styleNonPhd+'>'+retDivisionHtml+'</td>';
            }
            
            // division column end
            // phd confirmation start 
            let selectOption1 = "";
            let selectOption2 = "";
            if(academicArr['phd_result'] == 1){
                selectOption1 = 'selected="selected"';
                selectOption2 = '';
            }
            else if(academicArr['phd_result'] == 2){
                selectOption1 = '';
                selectOption2 = 'selected="selected"';
            }
                /*let phdConfirmationByHtml = '<td class="phd_edu_col" colspan="3" '+stylePhd+'>';
                        phdConfirmationByHtml += '<div class="form-group">';
                            phdConfirmationByHtml += '<label class="form-label"><b>PHD Result:</b> </label><br>';
                            phdConfirmationByHtml += '<label class="radio-inline"><input type="radio" name="phd_result[]" '+selectOption1+' value="1">Degree Awarded</label>';
                            phdConfirmationByHtml += '<label class="radio-inline"><input type="radio" name="phd_result[]" '+selectOption2+' value="2" >Thesis Submitted</label>';
                        phdConfirmationByHtml += '</div>';
                    phdConfirmationByHtml += '</td>';
                rowHtml += phdConfirmationByHtml;*/
                //
                let phdConfirmationByHtml = '<td class="phd_edu_col" colspan="3" '+stylePhd+'>';
                        phdConfirmationByHtml += '<select name="phd_result[]" class="form-control phd_result" '+phd_resultRequired+'>';
                            phdConfirmationByHtml += '<option value="">Select PHD Result</option>';
                            phdConfirmationByHtml += '<option '+selectOption1+' value="1">Degree Awarded</option>';
                            phdConfirmationByHtml += '<option '+selectOption2+' value="2">Thesis Submitted</option>';
                        phdConfirmationByHtml += '</select>';
                    phdConfirmationByHtml += '</td>';
                rowHtml += phdConfirmationByHtml;
            // phd confirmation end
            
        rowHtml += "</tr>";
        // new row end
        return rowHtml;
    }

    // education dropdown html function
    function getEducationDropdown(selectedEducationId=""){

        let readonly = 'readonly="readonly"';
        let educationDropdownHtml = '<div class="form-group">';
                educationDropdownHtml += '<select name="exam_pass[]" class="exam_pass form-control" type="text" style="width:200px;" required="" '+readonly+'>';
                let selectedEdu = "";
                // foreach start
                @foreach($educationMaster as $education)
                    if(selectedEducationId == <?php echo $education['id']; ?>){
                        selectedEdu = "selected";
                    }
                    educationDropdownHtml += '<option value="<?php echo $education['id']; ?>" '+selectedEdu+'><?php echo $education['code_meta_name']; ?></option>';
                    selectedEdu = "";
                @endforeach
                // foreach end
                educationDropdownHtml += '</select>';
            educationDropdownHtml += '</div>';    
        return educationDropdownHtml;
    }

    // months dropdown html function
    function monthsDropdownHtml(selectedMonth=""){

        let html = '<div class="form-group">';           
                html += '<select class="form-control" name="mn_pass[]" style="width:100px;" required="">';
                    html += '<option value="">Month</option>';
                    let n = 1;
                    while(n <= 12){
                        let monthName = getMonthName(n);
                        let selected = "";
                        if(selectedMonth == n){
                            selected = "selected";
                        }
                        html += '<option value="'+n+'" '+selected+'>'+monthName+'</option>';
                        n++;
                    }
                html += '</select>';
            html += '</div>';
        return html;    
    }

    // get month name by number function
    function getMonthName(monthNumber) {
        var months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        return months[monthNumber - 1];
    }

    // year input field html
    function passingYearHtml(examYear=""){

        let html = '<div class="form-group">';
            html += '<input required="" value="'+examYear+'" name="yr_pass[]" type="number" maxlength="4" autocomplete="off" maxlength="4" minlength="4" class="yr_pass form-control" placeholder="year">';
            html += '</div>';
        return html;    
    }

    // duration of course input field html
    function durationOfCourseHtml(durationOfCourse=""){

        let html = '<div class="form-group">';
            html += '<input required="" value="'+durationOfCourse+'" name="duration_of_course[]" type="number" maxlength="2" autocomplete="off" class="duration_of_course form-control" placeholder="">';
            html += '</div>';
        return html;    
    }

    // degree or subject input field html
    function degreeOrSubjectHtml(degreeSubName=""){

        let html = '<div class="form-group">';
            html += '<input required="" value="'+degreeSubName+'" name="subjects[]" type="text" autocomplete="off" class="subject form-control">';
            html += '</div>';
        return html;    
    }

    // board/university input field html
    function boardOrUniversityHtml(boardOrUniversityName=""){

        let html = '<div class="form-group">';
            html += '<input required="" value="'+boardOrUniversityName+'" name="board[]" type="text" autocomplete="off" class="board form-control">';
            html += '</div>';
        return html;    
    }

    // % or round off input field html
    function percentRoundoffHtml(percentRoundoffVal="",displayNonPhdEduCol=""){

        let required = "";
        if(displayNonPhdEduCol == ""){
            required = 'required=""';
        }
        let html = '<div class="form-group">';
            html += '<input '+required+' value="'+percentRoundoffVal+'" name="percent[]" type="number" autocomplete="off"  maxlength="2" class="percent form-control">';
            html += '</div>';
        return html;    
    }

    // cgpa input field html 
    function cgpaHtml(cgpaVal="",displayNonPhdEduCol=""){

        let required = "";
        if(displayNonPhdEduCol == ""){
            required = 'required=""';
        }
        let html = '<div class="form-group">';
            html += '<input '+required+' value="'+cgpaVal+'" name="cgpa[]" type="text" autocomplete="off" class="cgpa form-control" maxlength="3">';
            html += '</div>';
        return html;    
    }

    // division field dropdown html function
    function divisionHtml(divisionVal="",displayNonPhdEduCol=""){

        let required = "";
        if(displayNonPhdEduCol == ""){
            required = 'required=""';
        }
        let html = '<div class="form-group">';
            html += '<select name="division[]" class="division form-control" style="width:200px;" '+required+' >'; 
                // array of divisions with keys and values
                let arrValues = {I:"1ST", II:"2ND", III:"3RD", PASS:"PASS"};    
                let selected = "";
                $.each(arrValues, function(key, value) {
                    if(key == divisionVal){
                        selected = "selected";
                    }
                    html += '<option value="'+key+'" '+selected+'>'+value+'</option>';
                    selected = "";
                });          
            html += '</select>';
        return html;    
    }

    $('#academics_detail_id').on('change','.exam_pass',function(){ 
        let edu_id = $(this).val();
        var currentRow=$(this).closest("tr"); 
        //alert(rowindex);
        // if phd education -- id = 18 -- for PHD
        if(edu_id == 18){
            currentRow.find(".phd_edu_col").show();
            currentRow.find(".non_phd_edu_col").hide();
            currentRow.find(".percent").removeAttr('required');
            currentRow.find(".cgpa").removeAttr('required');
            currentRow.find(".division").removeAttr('required');
        }else{
            currentRow.find(".phd_edu_col").hide();
            currentRow.find(".non_phd_edu_col").show();
            currentRow.find(".phd_result").removeAttr('required');
            
        } 
    });
    
</script>
                            