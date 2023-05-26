<?php
$title = "Exam centers mapping";
$form_action = route('save_exam_center_mapping');      
if(!empty($jobId)){
    $form_action .= "/".$jobId;
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
                    <a class="btn btn-primary" href="{{ route('manage_exam_centers_mapping') }}"> Manage Exam Centers</a>
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
        
        <?php
        $job_id = old('job_id');
        $exam_centers = old('exam_centers');
        if(!empty($selectedCentersIds)){
            $exam_centers = $selectedCentersIds;
        }
        ?>
        <form action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <!-- RN No. start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">RN No.:</label>
                        <select name="rn_no_id" id="rn_no_id" class="form-control select2">
                            <option></option>
                            @foreach($rn_nos as $rn_no)
                                <?php
                                $selected = "";
                                if($rn_no->id == $rn_no_id){
                                    $selected = "selected=selected";
                                }
                                ?>
                                <option value="{{ $rn_no->id }}" {{ $selected }}>{{ $rn_no->rn_no }}</option>
                            @endforeach
                        </select>
                        @error('rn_no_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- RN No. end -->
                <!-- job title start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Post</label>
                        <select name="job_id" class="form-control select2">
                            @foreach($posts_list as $post)
                                <?php
                                $selectedPost = "";
                                if($post['id'] == $job_id){
                                    $selectedPost = "selected=selected";
                                }
                                ?>
                                <option value="{{ $post['id'] }}" <?php echo $selectedPost; ?>>{{ $post['code_meta_name'] }}</option>
                            @endforeach
                        </select>
                        @error('job_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- job title end -->
            </div>
            
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Exam Centers</label>
                        <select name="exam_centers[]" class="form-control select2" multiple>
                            @foreach($examCenters as $center)
                                <?php
                                $selectedPost = "";
                                if(!empty($exam_centers) && in_array($center['id'], $exam_centers)){
                                    $selectedPost = "selected=selected";
                                }
                                ?>
                                <option value="{{ $center['id'] }}" <?php echo $selectedPost; ?>>{{ $center['centre_name'] }}</option>
                            @endforeach
                        </select>
                        @error('exam_centers')
                        <div class="alert alert-danger mt-1 mb-1">{{ $exam_centers }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4 text-left">
                    </br>
                    <button type="submit" class="btn btn-primary text-right">Submit</button>
                </div>    
            </div>
        </form>
    </div>

    <script>
        $("#rn_no_id").change(function(){
            let rn_no_id = $(this).val();
            let redirectUrl = '<?php echo route('add_exam_center_mapping') ?>/'+rn_no_id;
            window.location.href = redirectUrl;
        });
    </script>
</x-app-layout>    