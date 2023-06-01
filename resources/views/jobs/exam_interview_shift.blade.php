<?php
$title = "Exam or Interview shifts";
$center_map_id = old('exam_center');
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
                        @error('rn_no_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Exam centers dropdown end -->
                
                <div class="col-xs-12 col-sm-12 col-md-4 text-left">
                    </br>
                    <button type="submit" class="btn btn-primary text-right">Submit</button>
                </div>    
            </div>
        </form>
    

    </div>

</x-app-layout>    