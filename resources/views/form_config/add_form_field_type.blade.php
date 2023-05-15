<?php
$title = "Add Form Field Type";
$field_type = old('field_type');
$is_multiple_option = old('is_multiple_option');
$form_action = route('save_form_field_type');
if(isset($formFieldType) && !empty($formFieldType)){
    $title = "Edit Form Field Type";
    $field_type = $formFieldType->field_type;
    $is_multiple_option = $formFieldType->is_multiple_option;
    $encId = Helper::encodeId($formFieldType->id);
    $form_action = route('save_form_field_type',$encId);
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
                    <a class="btn btn-primary" href="{{ route('manage_form_field_types') }}"> Manage Field Types</a>
                </div>
            </div>
        </div>
        </br>
        
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <strong>Field Type :</strong>
                        <input type="text" name="field_type" class="form-control" placeholder="Field Type" value="<?php echo $field_type; ?>">
                        @error('field_type')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                        <label></label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="is_multiple_option" value="1" <?php if($is_multiple_option == 1){ echo 'checked="checked"'; } ?>>
                            <label class="form-check-label ml-2" for="check1"> Is multiple options</label>
                        </div>
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