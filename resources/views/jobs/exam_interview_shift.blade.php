<?php
$title = "Exam or Interview shifts";
$center_map_id = $exam_center_map_id;
$is_exam_or_interview = $shift_for_id;
$shift = [];
$exam_int_date = [];
$reporting_time = [];

if(isset($existedShiftInfo) && !empty($existedShiftInfo)){
    $center_map_id = $existedShiftInfo[0]['exam_center_map_id'];
    $is_exam_or_interview = $existedShiftInfo[0]['is_exam_or_interview'];
    $shift = array_column($existedShiftInfo, 'shift');
    $exam_int_date = array_column($existedShiftInfo, 'reporting_date');
    $reporting_time = array_column($existedShiftInfo, 'reporting_time');
    $start_time = array_column($existedShiftInfo, 'start_time');
    $shift_time = array_column($existedShiftInfo, 'shift_time');
}

$form_action = route("save_exam_interview_shift")."/".$jobId;
if(!empty($center_map_id)){
    $form_action .= "/".$center_map_id;
}
if(!empty($is_exam_or_interview)){
    $form_action .= "/".$is_exam_or_interview;
}
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($title) }}
        </h2>
    </x-slot>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="text-left">
                    <a class="btn btn-primary" href="{{ route('manage_exam_centers_mapping') }}"> Back</a>
                </div>
            </div>
        </div>
        </br>
        
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        @if(session('error_msg'))
        <div class="alert alert-danger mb-1 mt-1">
            {{ session('error_msg') }}
        </div>
        @endif
        
        <form action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <!-- Exam centers dropdown start -->
                <?php
                $job_id = $examCenters[0]['job_id'];
                ?>
                <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Exam Centers</label>
                        <select name="exam_center_map" class="form-control select2 exam_center_map">
                            <option></option>
                            @foreach($examCenters as $center)
                                <?php
                                $selected = "";
                                if($center['id'] == $center_map_id){
                                    $selected = "selected=selected";
                                }
                                ?>
                                <option value="{{ $center['id'] }}" {{ $selected }}>{{ $center['centre_name'] }}</option>
                            @endforeach
                        </select>
                        @error('exam_center')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Exam centers dropdown end -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Shift For</label>
                        <select name="is_exam_or_interview" class="form-control is_exam_or_interview">
                            <option value="">Select</option>
                            <option value="1" <?php if($is_exam_or_interview == 1){ echo 'selected="selected"'; } ?>>Exam</option>
                            <option value="2" <?php if($is_exam_or_interview == 2){ echo 'selected="selected"'; } ?>>Interview</option>
                        </select>
                        @error('is_exam_or_interview')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>    
            
            <!-- shifts block start -->         
            <div class="row">                      
                <div id="acad_id" class="col-lg-12 col-md-12">
                    <div class="text-primary h4">Exam Center Shifts</div>
                    <table class="table table-bordered table-hover table-sm table-responsive-lg" id="shifts_table" >
                        <thead class="bg-light">
                            <tr>
                                <th>Shift</th>
                                <th>Exam Date</th>
                                <th>Reporting Time</th>
                                <th>Start Time</th>
                                <th>Shift Time</th>
                            </tr> 
                        </thead>     
                        <tbody id="shiftsDetailsBody">
                            
                        </tbody>            
                    </table>                                    
                </div>
                <div class="col-12 text-right">
                    <button class="btn btn-primary" type="button" id="shift_add_id">Add</button>&nbsp;
                    <button class="btn btn-primary" type="button" id="shift_rem_id">Remove</button>&nbsp;
                    <button class="btn btn-primary" type="button" id="shift_clear" >Clear</button>
                </div>	
            </div>	            	       	                        
            <!-- shifts block end -->
            <div class="col-xs-12 col-sm-12 col-md-4 text-left">
                </br>
                <button type="submit" class="btn btn-primary text-right">Submit</button>
            </div>    
        
        </form>
    

    </div>

    <script>

        $(document).ready(function(){
            @if(isset($exam_int_date) && !empty($exam_int_date))
                let shift = "";
                let exam_date = "";
                let reporting_time = "";
                let exam_center_shift_id = "";
                let start_time = "";
                let shift_time = "";
                @foreach($exam_int_date as $index=>$date_shift)
                    shift = "";
                    exam_date = "";
                    reporting_time = "";
                    exam_center_shift_id = "";
                    start_time = "";
                    shift_time = "";

                    shift = "<?php echo $shift[$index]; ?>";
                    exam_date = "<?php echo $date_shift; ?>";
                    reporting_time = "<?php echo $reporting_time[$index]; ?>";
                    exam_center_shift_id = "<?php echo $existedShiftInfo[$index]['id']; ?>";
                    start_time = "<?php echo $start_time[$index]; ?>";
                    shift_time = "<?php echo $shift_time[$index]; ?>";
                    shift_row(shift, exam_date, reporting_time, exam_center_shift_id, start_time, shift_time);
                @endforeach
            @else
                shift_row();
            @endif
        });                        

        function shift_row(shift="", exam_date="", reporting_time="", exam_center_shift_id="", start_time="", shift_time=""){
            let rowsHtml = "";
                rowsHtml += "<tr>";
                    rowsHtml += '<td><input required="" type="text" class="shift" name="shift[]" value="'+shift+'"></td>';
                    rowsHtml += '<td>';
                    rowsHtml += '<input type="hidden" class="exam_center_shift_id" name="exam_center_shift_id[]" value="'+exam_center_shift_id+'">';
                    rowsHtml += '<input required="" class="form-control exam_int_date" name="exam_int_date[]" type="date" value="'+exam_date+'" placeholder="DD-MM-YYYY">';
                    rowsHtml += '</td>';
                    rowsHtml += '<td><input required="" type="text" class="reporting_time" name="reporting_time[]" value="'+reporting_time+'"></td>';
                    rowsHtml += '<td><input required="" type="text" class="start_time" name="start_time[]" value="'+start_time+'"></td>';
                    rowsHtml += '<td><input required="" type="text" class="shift_time" name="shift_time[]" value="'+shift_time+'"></td>';
                rowsHtml += "</tr>";

            $('#shiftsDetailsBody').append(rowsHtml);
        }

        // on click add new row button
        $("#shift_add_id").click(function(){
            let flag = true;
            $('.exam_int_date:visible, .reporting_time:visible').each(function(){
                if($(this).val()=='')
                {
                    alert("Enter the value");
                    $(this).focus();
                    flag = false;
                    return flag;
                }			
            });
            if(flag == true){
                shift_row();
            }
        });

        // remove row on click Remove button
        $('#shift_rem_id').click(function(){	
            let noOfRows = $('#shiftsDetailsBody tr').length;
            let minRows = 1;
            
            if(noOfRows > 1){ 
                // remove row
                $('#shiftsDetailsBody tr:last').remove(); 
            }else{
                alert("Please provide minimum required informations.");
            }
        });
        
        // clear all fields on click Clear button
        $('#shift_clear').click(function(){		 
            $('.exam_int_date:visible, .reporting_time:visible').each(function(){
                $(this).val(''); 
            });
        });

        $(".is_exam_or_interview").change(function(){
            let exam_center_map_id = $(".exam_center_map").find(":selected").val();
            let is_exam_or_interview = $(this).val();
            let canProceed = 1;
            if(exam_center_map_id == "" || exam_center_map_id == "undefined"){
                canProceed = 0;
                alert("Kindly select exam center.");
            }
            if(is_exam_or_interview == "" || is_exam_or_interview == "undefined"){
                canProceed = 0;
                alert("Kindly select Shift For.");
            }
            if(canProceed == 1){
                let redirectUrl = "<?php echo route('exam_interview_shift')."/".$jobId; ?>";
                redirectUrl += "/"+exam_center_map_id+"/"+is_exam_or_interview;
                window.location.href = redirectUrl;
            }
        });

    </script>                            

</x-app-layout>    