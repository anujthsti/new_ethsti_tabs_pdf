<?php
$title = "Add Code";
$code_name = old('code_name');
$form_action = route('save_code');
if(isset($code)){
    $title = "Edit Code";
    $code_name = $code->code_name;
    $encId = Helper::encodeId($code->id);
    $form_action = route('save_code',$encId);
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
                    <a class="btn btn-primary" href="{{ route('manage_codes') }}"> Back</a>
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
            <?php /* ?>
            @if(isset($code))
            @method('PUT')
            @endif
            <?php */ ?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <strong>Code Name:</strong>
                        <input type="text" name="code_name" class="form-control" placeholder="Code Name" value="<?php echo $code_name; ?>">
                        @error('code_name')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 text-left">
                    </br>
                    <button type="submit" class="btn btn-primary ml-3 text-right">Submit</button>
                </div>    
            </div>
        </form>
    </div>

</x-app-layout>    