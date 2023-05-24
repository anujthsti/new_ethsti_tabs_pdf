<!-- common sections variables start -->
<?php
    // variables for section header title
    $headerTitle = "Manage Shortlisting";
    // variables for section buttons bar
    $createBtnTitle = "";
    $createBtnLink = "";
?>
<!-- common sections variables end -->
<style>
    @media only screen and (min-width: 1200px) {
        .container, .container-lg, .container-md, .container-sm, .container-xl {
            max-width: 1700px !important;
        }
    }
</style>    
<x-app-layout>
    <!-- section header title html -->
    @include('layouts/header_title')
    <style>
        .btnFilter{
            margin-right: 10px;
        }
    </style>
    <div class="container mt-2">
        <!-- section buttons bar html -->
        @include('layouts/buttons_bar')
        <!-- success message alert html start -->
        @if ($message = Session::get('success'))
            <!-- include success message common view -->
            @include('layouts/success_message') 
        @endif
        <!-- success message alert html end -->
        <div class="candidatesListContainer" id="candidatesListContainer">
            <!-- dropdown filter rows start -->
            <div class="row" style="margin: 20px 0px;">
                
                <div class="col-md-3 col-sm-12">
                    <select name="rn_types" id="rn_types" class="form-control">
                        <option value="">Select RN Type</option>
                        @foreach($rnNoTypesArr as $rn_no_type)
                            <?php
                            $rnTypeId = $rn_no_type['id'];
                            $rnNoTypeIdEnc = Helper::encodeId($rnTypeId);
                            $rnNoTypeSelected = "";
                            if($rnNoTypeEncId == $rnNoTypeIdEnc){
                                $rnNoTypeSelected = "selected";
                            }
                            ?>
                            <option value="{{ $rnNoTypeIdEnc }}" data-id="<?php echo $rnTypeId; ?>" data-code="{{ $rn_no_type['meta_code'] }}" <?php echo $rnNoTypeSelected; ?>>{{ $rn_no_type['code_meta_name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="ths_rn_types" class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <select id="ths_types" name="ths_types" class="form-control">
                            <?php
                            if(!empty($ths_rn_types)){
                            ?>
                                <option value="">Select THS Type</option>
                                @foreach($ths_rn_types as $ths_type)
                                    <?php
                                    $thsRnTypeIdEnc = Helper::encodeId($ths_type['id']);
                                    $thsRnTypeSelected = "";
                                    if($thsRNTypeEncId == $thsRnTypeIdEnc){
                                        $thsRnTypeSelected = "selected";
                                    }
                                    ?>
                                    <option value="{{ $thsRnTypeIdEnc }}" data-code="{{ $ths_type['id'] }}" data-code="{{ $ths_type['meta_code'] }}" <?php echo $thsRnTypeSelected; ?>>{{ $ths_type['code_meta_name'] }}</option>
                                @endforeach
                            <?php
                            }else{
                            ?>
                                <option value="{{ $cdsaTypeIdEnc }}">CDSA Type</option>
                            <?php    
                            }
                            ?>    
                        </select>
                        @error('ths_types')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-12"></div>

                <div class="col-md-3 col-sm-12">
                    <select name="rn_nos" id="rn_nos" class="form-control">
                        <option value="">Select RN No.</option>
                        @foreach($rn_nos as $rn_no)
                            <?php
                            $rnNoIdEnc = Helper::encodeId($rn_no->id);
                            $rnSelected = "";
                            if($rn_no_EncId == $rnNoIdEnc){
                                $rnSelected = "selected";
                            }
                            ?>
                            <option value="{{ $rnNoIdEnc }}" <?php echo $rnSelected; ?>>{{ $rn_no->rn_no }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-3 col-sm-12">
                    <select name="posts" id="posts" class="form-control">
                        <option value="">Select Position</option>
                        @foreach($positionsArr as $position)
                            <?php
                            $positionIdEnc = Helper::encodeId($position->job_id);
                            $positionSelected = "";
                            if($jobEncId == $positionIdEnc){
                                $positionSelected = "selected";
                            }
                            ?>
                            <option value="{{ $positionIdEnc }}" <?php echo $positionSelected; ?>>{{ $position->code_meta_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-sm-12">
                    <a id="listFilter" class="btn btn-success" href="javascript:void(0);">Filter</a>
                </div>

            </div>
            <!-- dropdown filter rows end -->
            <!-- filters start -->          
            <?php 
            if(isset($rnNoTypeEncId) && !empty($rnNoTypeEncId) && isset($thsRNTypeEncId) && !empty($thsRNTypeEncId) && isset($jobEncId) && !empty($jobEncId) && isset($rn_no_EncId) && !empty($rn_no_EncId)){ 
                $listingPageUrl = route('candidate_list')."/".$rnNoTypeEncId."/".$thsRNTypeEncId."/".$rn_no_EncId."/".$jobEncId;
                $exportUrl = route('candidates_export_to_excel')."/".$rn_no_EncId."/".$jobEncId;
            ?>      
            <div class="row" style="margin: 20px 0px;">
                <a class="btn btn-primary btnFilter" href="<?php echo $listingPageUrl; ?>">All Record</a>
                <a class="btn btn-primary btnFilter" href="<?php echo $listingPageUrl."/1"; ?>">Shortlisted</a> 
                <a class="btn btn-primary btnFilter" href="<?php echo $listingPageUrl."/3"; ?>">Provisional Shortlisted</a> 
                <a class="btn btn-primary btnFilter" href="<?php echo $listingPageUrl."/2"; ?>">Rejected</a>
                <a class="btn btn-primary btnFilter" href="<?php echo $listingPageUrl."/4"; ?>">Screened Record</a>
                <a class="btn btn-warning btnFilter" href="<?php echo $exportUrl; ?>">Extract Record</a>
            </div>
            <?php } ?>    
            <!-- filters end -->                
            <!-- table html start -->
            <table class="table table-bordered dataTable">
                <!-- table header html start -->
                <thead>
                    <tr>
                        <th>Sr.No.</th>
                        <th>Full Name</th>
                        <th>Domain Area/Group</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Category</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Total Experience</th>
                        <th>Payment Status</th>
                        <th>Application Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <!-- table header html end -->
                <tbody>
                    <?php
                    $index = 1;
                    // filter domain areas by code from array
                    $domain_areas = Helper::getCodeNamesByCode($masterData,'code','domain_area');
                    $domain_area_ids = array_column($domain_areas, 'id');
                    // filter caste categories by code from array
                    $cast_categories = Helper::getCodeNamesByCode($masterData,'code','cast_categories');
                    $cast_categories_ids = array_column($cast_categories, 'id');
                    // filter genders by code from array
                    $genderArr = Helper::getCodeNamesByCode($masterData,'code','gender');
                    $gender_ids = array_column($genderArr, 'id');
                    ?>
                    @foreach($candidatesList as $list)
                        <?php
                        // payment status
                        $paymentStatus = '<span class="text-primary"><strong>PENDING</strong></span>';
                        if($list->payment_status == 1){
                            $paymentStatus = '<span class="text-success"><strong>SUCCESS</strong></span>';
                        }
                        else if($list->payment_status == 2){
                            $paymentStatus = '<span class="text-danger"><strong>FAILED</strong></span>';
                        }
                        else{}
                        
                        // application status
                        $applicationStatus = '<span class="text-primary"><strong>PENDING</strong></span>';
                        if($list->is_completed == 1){
                            $applicationStatus = '<span class="text-success"><strong>COMPLETED</strong></span>';
                        }

                        // domain
                        $domainName = "";
                        if(isset($list->domain_id) && !empty($list->domain_id)){
                            $key = array_search ($list->domain_id, $domain_area_ids);
                            $domainName = $domain_areas[$key]['code_meta_name'];
                        }
                        // category
                        $categoryName = "";
                        if(isset($list->category_id) && !empty($list->category_id)){
                            $key = array_search ($list->category_id, $cast_categories_ids);
                            $categoryName = $cast_categories[$key]['code_meta_name'];
                        }
                        // gender
                        $gender = "";
                        if(isset($list->gender) && !empty($list->gender)){
                            $key = array_search ($list->gender, $gender_ids);
                            $gender = $genderArr[$key]['code_meta_name'];
                        }
                        $candidate_job_apply_id = $list->candidate_job_apply_id;
                        $candidateJobApplyIdEnc = Helper::encodeId($candidate_job_apply_id);
                        $viewLink = route("candidate_print",$candidateJobApplyIdEnc);
                        ?>
                    <tr>
                        <td><a href="<?php echo $viewLink; ?>" target="_blank"><?php echo $index++; ?></a></td>
                        <td>{{ $list->full_name }}</td>
                        <td>{{ $domainName }}</td>
                        <td>{{ $list->email_id }}</td>
                        <td>{{ $list->mobile_no }}</td>
                        <td>{{ $categoryName }}</td>
                        <td>{{ $gender }}</td>
                        <td>{{ $list->age_calculated }}</td>
                        <td>{{ $list->total_experience }}</td>
                        <td><?php echo $paymentStatus; ?></td>
                        <td><?php echo $applicationStatus; ?></td>
                        <td><a href="<?php echo $viewLink; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- table html end -->
        </div>    
    </div>

    <script>
        
        $("#rn_types").change(function(){
            let rn_type = $(this).val();
            if(rn_type != ""){
                let code = $(this).find(':selected').data('code');
                let rnNoTypeEncId = $(this).val();
                if(code == "thsti"){
                    //$("#ths_rn_types").show();
                    redirectToCandidatesList(rnNoTypeEncId);
                }else{
                    //$("#ths_rn_types").hide();
                    let ths_typesEncId = $("#ths_types :selected").val();
                    redirectToCandidatesList(rnNoTypeEncId,ths_typesEncId);
                }
                $("#rn_no_field").val("");
            }else{
                alert("Please select RN Type.");
            }
        });
        $("#ths_types").change(function(){
            let rnNoTypeEncId = $("#rn_types :selected").val();
            let ths_typesEncId = $("#ths_types :selected").val();
            redirectToCandidatesList(rnNoTypeEncId,ths_typesEncId);
        });
        /*
        $("#rn_types").change(function(){
            let rnNoTypeEncId = $(this).val();
            redirectToCandidatesList(rnNoTypeEncId);
        });
        */
        $("#rn_nos").change(function(){
            let rnNoTypeEncId = $("#rn_types :selected").val();
            let ths_typesEncId = $("#ths_types :selected").val();
            let rn_no_EncId = $(this).val();
            redirectToCandidatesList(rnNoTypeEncId,ths_typesEncId,rn_no_EncId);
        });

        $("#listFilter").click(function(){
            let rnNoTypeEncId = $("#rn_types :selected").val();
            let ths_typesEncId = $("#ths_types :selected").val();
            let rn_no_EncId = $("#rn_nos :selected").val();
            let job_EncId = $("#posts :selected").val();
            redirectToCandidatesList(rnNoTypeEncId,ths_typesEncId,rn_no_EncId, job_EncId);
        });

        function redirectToCandidatesList(rnNoTypeEncId,ths_typesEncId="",rn_no_EncId="", job_EncId=""){
            let redirectRoute = "<?php echo route('candidate_list');?>/"+rnNoTypeEncId;
            if(ths_typesEncId != "" && ths_typesEncId != "undefined"){
                redirectRoute += "/"+ths_typesEncId; 
            }
            if(rn_no_EncId != "" && ths_typesEncId != "undefined"){
                redirectRoute += "/"+rn_no_EncId; 
            }
            if(job_EncId != "" && ths_typesEncId != "undefined"){
                redirectRoute += "/"+job_EncId; 
            }
            window.location.href = redirectRoute;
            //$(".candidatesListContainer").load(redirectRoute);
            //$('#candidatesListContainer').load(redirectRoute+' #candidatesListContainer', function() {
                /// can add another function here
            //});
        }

        
    </script>

</x-app-layout>    