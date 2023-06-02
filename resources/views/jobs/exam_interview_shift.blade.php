<?php
$title = "Exam or Interview shifts";
$center_map_id = old('exam_center');
$is_exam_or_interview = old('is_exam_or_interview');
$exam_int_date = [];
$reporting_time = [];
$form_action = route("save_exam_interview_shift")."/".$jobId;
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
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Exam Centers</label>
                        <select name="exam_center" class="form-control select2">
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
                        <select name="is_exam_or_interview" class="form-control">
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
                                <th>Exam Date</th>
                                <th>Reporting Time</th>
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
            shift_row();
            
        });                        

        function shift_row(exam_date="", reporting_time=""){
            let rowsHtml = "";
                rowsHtml += "<tr>";
                    rowsHtml += '<td><input required="" class="form-control exam_int_date" name="exam_int_date[]" type="date" value="'+exam_date+'" placeholder="DD-MM-YYYY"></td>';
                    rowsHtml += '<td><input type="text" class="reporting_time" name="reporting_time[]" value="'+reporting_time+'"></td>';
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
            //console.log('noOfRows: '+noOfRows);
            let minReqEduRows = <?php echo count($exam_int_date); ?>;
            if(minReqEduRows > 1){
                minRows = minReqEduRows;
            }
            if(noOfRows > minRows){ 
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

    </script>                            

</x-app-layout>    