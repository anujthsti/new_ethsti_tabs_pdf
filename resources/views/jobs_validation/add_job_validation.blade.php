<?php
$title = "Add Job Validation";
$post_id = old('post_id');
$age_cat_limits = old('age_cat');
$education_ids = old('educations');
$minExperienceArr = old('minimum_experience');
$catFeeArr = old('fee_category');
// mandatory fields
$exp_tab = old('exp_tab');
$pub_tab = old('pub_tab');
$patent_tab = old('patent_tab');
$research_tab = old('research_tab');
$proposal_tab = old('proposal_tab');
// form action
$form_action = route('save_job_validation');
if(isset($_GET['postId']) && !empty($_GET['postId'])){
    $post_id = Helper::decodeId($_GET['postId']);
}
if(isset($jobValidation) && !empty($jobValidation)){
    $title = "Edit Job Validation";
    $post_id = $jobValidation->post_id;
    // arrays
    $age_cat_limits = $ageRelaxationArr;
    $education_ids = $educationIds;
    $minExperienceArr = $experienceArr;
    $catFeeArr = $categoryFeesArr;
    // mandatory fields
    $exp_tab = $jobValidation->is_exp_tab;
    $pub_tab = $jobValidation->is_publication_tab;
    $patent_tab = $jobValidation->is_patent_tab;
    $research_tab = $jobValidation->is_research_tab;
    $proposal_tab = $jobValidation->is_proposal_tab;
    // encode id
    $encId = Helper::encodeId($jobValidation->id);
    // form action
    $form_action = route('save_job_validation',$encId);
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
                    <a class="btn btn-primary" href="{{ route('manage_jobs_validation') }}"> Manage Jobs Validations</a>
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
                <?php if(isset($_GET['job_id']) && !empty($_GET['job_id'])){ ?>
                    <input type="text" name="job_id" value="<?php echo $_GET['job_id']; ?>" style="display:none;">
                <?php } ?>

            </div>
            <hr class="mt-1 mb-3"/>
            <div class="row">
                <!-- age limit categories starts -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <table>
                            <tr>
                                <th>Age Relaxation</th>
                                <th>(In Years)</th>
                            </tr>
                            @foreach($ageCategoriesc as $age_cat)
                            <?php
                            $age_cat_id = $age_cat['id'];
                            $age_limit = "";
                            if(isset($age_cat_limits[$age_cat_id])){
                                $age_limit = $age_cat_limits[$age_cat_id];
                            }
                            ?>
                            <tr>
                                <td>{{ $age_cat['code_meta_name'] }}</td>
                                <td><input class="form-control" name="age_cat[{{ $age_cat_id }}]" value="{{ $age_limit }}"></td>
                            </tr>
                            @endforeach
                        </table>    
                        @error('age_cat')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>   
                <!-- age limit categories ends -->
                <!-- minimum educations starts -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Minimum Educations</label>
                        <select name="educations[]" class="form-control select2" multiple="multiple">
                            <option></option>
                            @foreach($educations as $education)
                                <?php
                                $selected = "";
                                if(!empty($education_ids)){
                                    if(in_array($education['id'],$education_ids)){
                                        $selected = "selected=selected";
                                    }
                                }
                                ?>
                                <option value="{{ $education['id'] }}" {{ $selected }}>{{ $education['code_meta_name'] }}</option>
                            @endforeach
                        </select>
                        @error('educations')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>  
                <!-- minimum educations ends -->   
                <!-- mimimum experience starts -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <table>
                            <tr>
                                <th>Minimum Experience</th>
                                <th>(In Years)</th>
                            </tr>
                            @foreach($educations as $edu_exp)
                            <?php
                            $experience_id = $edu_exp['id'];
                            $experience = "";
                            if(isset($minExperienceArr[$experience_id])){
                                $experience = $minExperienceArr[$experience_id];
                            }
                            ?>
                            <tr>
                                <td>{{ $edu_exp['code_meta_name'] }}</td>
                                <td><input class="form-control" name="minimum_experience[{{ $experience_id }}]" value="{{ $experience }}"></td>
                            </tr>
                            @endforeach
                        </table>   
                        @error('minimum_experience')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror 
                    </div>
                </div>   
                <!-- age limit categories ends -->    
            </div>    
            <div class="row">
                <!-- mimimum experience starts -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <table>
                            <tr>
                                <th>Application Fee</th>
                                <th>(In Rs)</th>
                            </tr>
                            @foreach($fee_categories as $fee_category)
                            <?php
                            $fee_category_id = $fee_category['id'];
                            $fee = "";
                            if(isset($catFeeArr[$fee_category_id])){
                                $fee = $catFeeArr[$fee_category_id];
                            }
                            ?>
                            <tr>
                                <td>{{ $fee_category['code_meta_name'] }}</td>
                                <td><input class="form-control" name="fee_category[{{ $fee_category_id }}]" value="{{ $fee }}"></td>
                            </tr>
                            @endforeach
                        </table>   
                        @error('fee_category')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror 
                    </div>
                </div>   
                <!-- age limit categories ends -->   
                <!-- mandatory section start -->
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label>Mandatory Sections</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="exp_tab" value="1" <?php if($exp_tab == 1){ echo 'checked="checked"'; } ?>>
                            <label class="form-check-label" for="check1">Experience Section</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="pub_tab" value="1" <?php if($pub_tab == 1){ echo 'checked="checked"'; } ?>>
                            <label class="form-check-label">Publication Section</label>
                        </div>    
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="patent_tab" value="1" <?php if($patent_tab == 1){ echo 'checked="checked"'; } ?>>
                            <label class="form-check-label">Patent</label>
                        </div>    
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="research_tab" value="1" <?php if($research_tab == 1){ echo 'checked="checked"'; } ?>>
                            <label class="form-check-label">Research Statement</label>
                        </div> 
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="proposal_tab" value="1" <?php if($proposal_tab == 1){ echo 'checked="checked"'; } ?>>
                            <label class="form-check-label">Project Proposal</label>
                        </div>      
                    </div>
                </div>
                <!-- mandatory section end -->
                <!-- submit button starts --> 
                <div class="col-xs-12 col-sm-12 col-md-4 text-left">
                    </br>
                    <button type="submit" class="btn btn-primary text-right">Submit</button>
                </div>  
                <!-- submit button ends -->
            </div>
            <!--
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 text-right">
                    </br>
                    <button type="submit" class="btn btn-primary text-right">Submit</button>
                </div>  
            </div>
            -->
        </form>
    </div>

</x-app-layout>    