<?php
$title = "Exam or Interview shifts";
$center_map_id = $exam_center_map_id;
$is_exam_or_interview = $shift_for_id;

/*
if(isset($existedShiftInfo) && !empty($existedShiftInfo)){
    $center_map_id = $existedShiftInfo[0]['exam_center_map_id'];
    $is_exam_or_interview = $existedShiftInfo[0]['is_exam_or_interview'];
    $exam_int_date = array_column($existedShiftInfo, 'reporting_date');
    $reporting_time = array_column($existedShiftInfo, 'reporting_time');
}
*/
$form_action = route("save_candidate_center_mapping", $jobId);

if(!empty($exam_center_map_id)){
    $form_action .= "/".$exam_center_map_id;
}
if(!empty($shift_for_id)){
    $form_action .= "/".$shift_for_id;
}
if(!empty($shift_id)){
    $form_action .= "/".$shift_id;
}

$checkedJobApplyids = [];
if(isset($existedJobApplyIds) && !empty($existedJobApplyIds)){
    $checkedJobApplyids = array_column($existedJobApplyIds, 'id');
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

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Shifts</label>
                        <select name="exam_center_shifts" class="form-control select2 exam_center_shifts">
                            <option></option>
                            @foreach($existedShiftInfo as $shift)
                                <?php
                                $selected = "";
                                if($shift['id'] == $shift_id){
                                    $selected = "selected=selected";
                                }
                                ?>
                                <option value="{{ $shift['id'] }}" {{ $selected }}>{{ $shift['shift'] }} -- {{ $shift['reporting_date'] }} -- {{ $shift['reporting_time'] }}</option>
                            @endforeach
                        </select>
                        @error('exam_center_shifts')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>    
            
            
            <!-- shifts block start -->         
                    <div class="text-primary h4">Candidates List</div>
                    <table class="table table-bordered table-hover table-sm table-responsive-lg" id="shifts_table" >
                        <thead class="bg-light">
                            <tr>
                                <th><input type="checkbox" id="selectAll" name="selectAll" value="1" /> Select All</th>
                                <th>Sr. No.</th>
                                <th>Candidate Name</th>
                                <th>Email</th>
                            </tr> 
                        </thead>     
                        <tbody id="shiftsDetailsBody">
                            @foreach($candidatesList as $index=>$list)
                                <?php
                                $checked = "";
                                $jobApplyId = $list['id'];
                                if(!empty($checkedJobApplyids) && in_array($jobApplyId, $checkedJobApplyids)){
                                    $checked = "checked";
                                }
                                ?>
                                <?php $srNo = $index + 1; ?>
                                <tr>
                                    <td><input type="checkbox" class="candidates_checkboxes" name="candidates[]" value="{{ $jobApplyId }}" <?php echo $checked; ?> /></td>
                                    <td>{{ $srNo }}</td>
                                    <td>{{ $list['full_name'] }}</td>
                                    <td>{{ $list['email_id'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>            
                    </table>                                    
                      	       	                        
            <!-- shifts block end -->
            <div class="col-xs-12 col-sm-12 col-md-4 text-center">
                </br>
                <button type="submit" class="btn btn-primary text-right">Submit</button>
            </div>    
        
        </form>
    

    </div>

    <script>

        $("#selectAll").click(function(){
            if(this.checked){
                $('.candidates_checkboxes').each(function(){
                    $(".candidates_checkboxes").prop('checked', true);
                })
            }else{
                $('.candidates_checkboxes').each(function(){
                    $(".candidates_checkboxes").prop('checked', false);
                })
            }
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
                let redirectUrl = "<?php echo route('candidate_center_mapping')."/".$jobId; ?>";
                redirectUrl += "/"+exam_center_map_id+"/"+is_exam_or_interview;
                window.location.href = redirectUrl;
            }
        });

        
        $(".exam_center_shifts").change(function(){
            let exam_center_map_id = $(".exam_center_map").find(":selected").val();
            let is_exam_or_interview = $(".is_exam_or_interview").find(":selected").val();
            let shift_id = $(this).val();
            let canProceed = 1;
            if(exam_center_map_id == "" || exam_center_map_id == "undefined"){
                canProceed = 0;
                alert("Kindly select exam center.");
            }
            if(is_exam_or_interview == "" || is_exam_or_interview == "undefined"){
                canProceed = 0;
                alert("Kindly select Shift For.");
            }
            if(shift_id == "" || shift_id == "undefined"){
                canProceed = 0;
                alert("Kindly select Shift For.");
            }
            if(canProceed == 1){
                let redirectUrl = "<?php echo route('candidate_center_mapping')."/".$jobId; ?>";
                redirectUrl += "/"+exam_center_map_id+"/"+is_exam_or_interview+"/"+shift_id;
                window.location.href = redirectUrl;
            }
        });
    </script>                            

</x-app-layout>    