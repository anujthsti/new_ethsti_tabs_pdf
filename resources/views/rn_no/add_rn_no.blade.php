<?php
$title = "Add RN No.";
$rn_no = old('rn_no');
$rn_type = old('rn_type');
$ths_types = old('ths_rn_types');
$fileName = "";
$form_action = route('save_rnno');
if(isset($rnno) && !empty($rnno)){
    $title = "Edit RN No.";
    $rn_no = $rnno->rn_no;
    $fileName = $rnno->rn_document;
    $encId = Helper::encodeId($rnno->id);
    $form_action = route('save_rnno',$encId);
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
                    <a class="btn btn-primary" href="{{ route('manage_rnno') }}"> Back</a>
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
                        <select id="rn_type" name="rn_type" class="form-control">
                            <option value="">Select Type</option>
                            @foreach($rn_no_types as $type)
                                <?php
                                $selected = "";
                                if($rn_type == $type['id']){
                                    $selected = "selected";     
                                }
                                ?>
                                <option value="{{ $type['id'] }}" data-code="{{ $type['meta_code'] }}" <?php echo $selected; ?>>{{ $type['code_meta_name'] }}</option>
                            @endforeach
                        </select>
                        @error('rn_type')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div id="ths_rn_types" class="col-xs-12 col-sm-12 col-md-4" style="display:none;">
                    <div class="form-group">
                        <label class="form-label">THS RN Type</label>
                        <select id="ths_types" name="ths_types" class="form-control">
                            <option value="">Select THS Type</option>
                            @foreach($ths_rn_types as $ths_type)
                                <?php
                                $selected = "";
                                if($ths_types == $ths_type['id']){
                                    $selected = "selected";     
                                }
                                ?>
                                <option value="{{ $ths_type['id'] }}"  data-code="{{ $ths_type['meta_code'] }}" <?php echo $selected; ?>>{{ $ths_type['code_meta_name'] }}</option>
                            @endforeach
                        </select>
                        @error('ths_types')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label class="form-label">PDF File</label>
                        <input type="file" name="rn_file" class="form-control">
                        <span>{{ $fileName }}</span>
                        @error('rn_file')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4" id="rn_no" style="display:none;">
                    <div class="form-group">
                        <label class="form-label">RN No.:</label>
                        <input type="text" name="rn_no" id="rn_no_field" class="form-control" placeholder="RN No." value="<?php echo $rn_no; ?>" readonly>
                        <input type="text" name="sequenceCode" id="sequenceCode" value="" placeholder="Sequence Code" class="displayNone">
                        <input type="text" name="cycle" id="cycle" value="" placeholder="Cycle" class="displayNone">
                        @error('rn_no')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-4 text-left">
                    </br>
                    <a href="javascript:void(0)" onClick="generateNewRnNo();" class="btn btn-success text-right">Generate New RN No</a>
                    <button type="submit" class="btn btn-primary text-right">Save</button>
                </div>    
            </div>
        </form>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#rn_type").change(function(){
            let rn_type = $(this).val();
            if(rn_type != ""){
                let code = $(this).find(':selected').data('code');
                if(code == "thsti"){
                    $("#ths_rn_types").show();
                }else{
                    $("#ths_rn_types").hide();
                }
                $("#rn_no_field").val("");
            }else{
                alert("Please select RN Type.");
            }
        });

        $("#ths_types").change(function(){
            $("#rn_no_field").val("");
        });

        function generateNewRnNo(){
            let selectedRNType = $("#rn_type").find(':selected').val();
            if(selectedRNType != ""){
                    let rn_type_code = $("#rn_type").find(':selected').data('code');
                    let ths_rn_type_code = "";
                    let selectedTHSRNType = "";
                    // if code is thsti else cdsa
                    if(rn_type_code == "thsti"){
                        let selectedTHSRNTypeCode = $("#ths_types").find(':selected').data('code');
                        selectedTHSRNType = $("#ths_types").find(':selected').val();
                        if(selectedTHSRNType != ""){
                            ths_rn_type_code = selectedTHSRNTypeCode;
                        }else{
                            alert("Please select THS RN Type.");
                            exit;
                        }
                    }
                    
                    $.ajax({
                        type:'POST',
                        url:"{{ route('generate_new_rnno') }}",
                        data:{rn_type_id:selectedRNType, rn_type_code:rn_type_code, ths_rn_type_id:selectedTHSRNType, ths_rn_type_code:ths_rn_type_code},
                        success:function(data){
                            let newRNNo = data['newRNNo'];
                            let sequenceCode = data['sequenceCode'];
                            console.log("sequenceCode: "+sequenceCode);
                            let cycle = data['cycle'];
                            $("#rn_no_field").val(newRNNo);
                            $("#sequenceCode").val(sequenceCode);
                            $("#cycle").val(cycle);
                            $("#rn_no").show();
                        }
                    });
                    
                
            }else{
                alert("Please select RN Type.");
            }
            
        }
    </script>

</x-app-layout>    