<?php
$title = "Add Form Field";
$field_name = old('field_name');
$form_tab_id = old('form_tab_id');
$form_action = route('save_form_field');
if(isset($formField) && !empty($formField)){
    $title = "Edit Form Field Type";
    $field_name = $formField->field_name;
    $form_tab_id = $formField->form_tab_id;
    $encId = Helper::encodeId($formField->id);
    $form_action = route('save_form_field',$encId);
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
                    <a class="btn btn-primary" href="{{ route('manage_form_fields') }}"> Manage Form Fields</a>
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
                        <strong>Tab Name :</strong>
                        <select name="form_tab_id">
                            <option value="">Select Tab</option>
                            
                            @foreach($formTabs as $tab)
                                <?php
                                $selected = "";
                                if($tab->id == $form_tab_id){
                                    $selected = "selected=selected";
                                }
                                ?>
                                <option value="{{ $tab->id }}" <?php echo $selected; ?>>{{ $tab->tab_title }}</option>
                            @endforeach
                        </select>
                        @error('form_tab_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <strong>Field Name :</strong>
                        <input type="text" name="field_name" class="form-control" placeholder="Field Name" value="<?php echo $field_name; ?>">
                        @error('field_name')
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