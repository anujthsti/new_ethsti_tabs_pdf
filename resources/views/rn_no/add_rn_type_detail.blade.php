<?php
$title = "Add RN Type Detail";
$rn_type_id = old('rn_type_id');
$prefix = old('prefix');
$suffix = old('suffix');
$sequence_start_from = old('sequence_start_from');
$fileName = "";
$form_action = route('save_rn_type_details');
if(isset($rnTypeDetail) && !empty($rnTypeDetail)){
    $title = "Edit RN Type Detail";
    $rn_type_id = $rnTypeDetail->rn_type_id;
    $prefix = $rnTypeDetail->prefix;
    $suffix = $rnTypeDetail->suffix;
    $sequence_start_from = $rnTypeDetail->sequence_start_from;
    $encId = Helper::encodeId($rnTypeDetail->id);
    $form_action = route('save_rn_type_details',$encId);
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
                    <a class="btn btn-primary" href="{{ route('manage_rn_type_details') }}"> Back</a>
                </div>
            </div>
        </div>
        </br>
         
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        @if ($message = Session::get('file_error'))
            <div class="alert alert-danger mb-1 mt-1"> 
                {{ session('file_error') }}
            </div>
        @endif
        <form action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">RN Type</label>
                        <select name="rn_type_id" class="form-control">
                            <option value="">Select RN Type</option>
                            @foreach($rnTypes as $type)
                                <?php
                                $selected = "";
                                if($type['id'] == $rn_type_id){
                                    $selected = "selected=selected";
                                }
                                ?>
                                <option value="{{ $type['id'] }}" {{ $selected }}>{{ $type['code_meta_name'] }}</option>
                            @endforeach
                        </select>
                        @error('rn_type_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Prefix</label>
                        <input type="text" name="prefix" class="form-control" value="{{ $prefix }}">
                        @error('prefix')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                       
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Sequence Start From</label>
                        <input type="text" name="sequence_start_from" class="form-control" value="{{ $sequence_start_from }}">
                        @error('sequence_start_from')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>            
                <div class="col-xs-12 col-sm-12 col-md-4 text-left">
                    </br>
                    <button type="submit" class="btn btn-primary ml-3 text-right">Submit</button>
                </div>    
            </div>
        </form>
    </div>

</x-app-layout>    