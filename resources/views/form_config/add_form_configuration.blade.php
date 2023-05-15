<?php
$title = "Add Form Configuration";
$post_id = old('post_id');
$form_fields = old('form_fields');
$form_tabs = old('form_tab');

if(isset($_GET['postId']) && !empty($_GET['postId'])){
    $post_id = Helper::decodeId($_GET['postId']);
}

//print_r($form_fields);exit;
$form_action = route('save_form_configuration');
if(isset($formConfiguration) && !empty($formConfiguration)){
    $title = "Edit Job";
    $post_id = $formConfiguration->post_id;
    $form_tabs = array_column($formTabsConfig, 'form_tab_field_id');
    $form_fields = array_column($formFieldsConfiguration, 'form_tab_field_id');
    
    $encId = Helper::encodeId($formConfiguration->id);
    $form_action = route('save_form_configuration',$encId);
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
                    <a class="btn btn-primary" href="{{ route('manage_form_configuration') }}"> Manage Form Configuration</a>
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
                <!-- RN No. start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Posts</label>
                        <select id="post_id" name="post_id" class="form-control select2">
                            <option></option>
                            @foreach($posts as $post)
                                <?php
                                $selected = "";
                                if($post['id'] == $post_id){
                                    $selected = "selected=selected";
                                }
                                ?>
                                <option value="{{ $post['id'] }}" {{ $selected }}>{{ $post['code_meta_name'] }}</option>
                            @endforeach
                        </select>
                        @error('post_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- RN No. end -->       
                <!-- hidden Job Id -->
                <?php if(isset($_GET['job_id']) && !empty($_GET['job_id'])){ ?>
                    <input type="text" name="job_id" value="<?php echo $_GET['job_id']; ?>" style="display:none;">
                <?php } ?>       
            </div>
            
            <div class="row" style="margin-bottom:20px;">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="select_all" id="selectAll">
                        <span class="tab-head ml-3">Select All</span>
                    </div>         
                </div>                
                @foreach($formTabs as $tab)
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <hr class="mt-1 mb-1"/>
                        <?php
                        $tabChecked = "";
                        if(!empty($form_tabs) && in_array($tab->id, $form_tabs)){
                            $tabChecked = "checked";
                        }
                        ?>
                        <div class="form-check">
                            <input class="form-check-input fieldCheckbox parentCheckbox" type="checkbox" value="{{ $tab->id }}" data-id="{{ $tab->id }}" name="form_tab[]" <?php echo $tabChecked; ?>>
                            <span class="tab-head ml-3">{{ $tab->tab_title }}</span>
                        </div>        
                        <hr class="mt-1 mb-1"/>
                    </div>
                    <?php
                    $formFields = Helper::getCodeNamesByCode($formTabFields,'form_tab_id',$tab->id);
                    foreach($formFields as $field){
                        $fieldChecked = "";
                        if(!empty($form_fields) && in_array($field['id'], $form_fields)){
                            $fieldChecked = "checked";
                        }
                    ?>
                        <div class="col-xs-12 col-sm-12 col-md-4 mt-1 mb-1">
                            <div class="form-check">
                                <input class="form-check-input fieldCheckbox parent-{{ $tab->id }}" type="checkbox" value="{{ $field['id'] }}" name="form_fields[]" <?php echo $fieldChecked; ?>>
                                <label class="form-check-label ml-3" for="flexCheckDefault">{{ $field['field_name'] }}</label>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mb-2"></div>
                @endforeach
            </div>
            <div class="row">
                
                <!-- submit button starts --> 
                <div class="col-xs-12 col-sm-12 col-md-4 text-left">
                    </br>
                    <button type="submit" class="btn btn-primary text-right">Submit</button>
                </div>  
                <!-- submit button ends -->
            </div>
            
        </form>
    </div>

    <script>
        
        // If Select ALL checkbox is checked
        $("#selectAll").change(function() {
            if(this.checked) {
                $('.fieldCheckbox').prop('checked','checked');
            }else{
                $('.fieldCheckbox').prop('checked','');
            }
        });

        // If parent checkbox is checked
        $(".parentCheckbox").change(function() {
            let parentId = $(this).attr('data-id'); 
            if(this.checked) {
                $('.parent-'+parentId).prop('checked','checked');
            }else{
                $('.parent-'+parentId).prop('checked','');
            }
        });
    </script>
</x-app-layout>    