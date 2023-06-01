<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Helper;
use App\Models\Jobs;
use App\Models\Rn_no;
use App\Models\JobValidation;
use App\Models\JobAgeRelaxation;
use App\Models\JobEducationValidation;
use App\Models\JobExperienceValidation;
use App\Models\JobCategoryWiseFee;
use App\Models\FormTabs;
use App\Models\FormTabFields;
use App\Models\FormFieldType;
use App\Models\FormConfiguration;
use App\Models\FormFieldsConfiguration;
use App\Models\JobDomainArea;
use App\Models\ExamCenters;
use App\Models\ExamCenterMapping;


class JobsController extends Controller
{
    // 
    public function __construct(){
        // get all code_names join with code_master
        $this->codeNamesArr = Helper::getCodeNames();
        // filter job types by code from array
        $this->job_types = Helper::getCodeNamesByCode($this->codeNamesArr,'code','job_types');
        // filter job types by code from array
        $this->centers = Helper::getCodeNamesByCode($this->codeNamesArr,'code','centers');
        // filter payment modes by code from array
        $this->payment_modes = Helper::getCodeNamesByCode($this->codeNamesArr,'code','payment_modes');
        // filter age categories by code from array
        $this->age_category = Helper::getCodeNamesByCode($this->codeNamesArr,'code','age_category');
        // filter educations by code from array
        $this->educations = Helper::getCodeNamesByCode($this->codeNamesArr,'code','education');
        // filter fee categories by code from array
        $this->fee_categories = Helper::getCodeNamesByCode($this->codeNamesArr,'code','fee_categories');
        // filter domain areas by code from array
        $this->domain_areas = Helper::getCodeNamesByCode($this->codeNamesArr,'code','domain_area');
        // filter posts by code from array
        $this->posts = Helper::getCodeNamesByCode($this->codeNamesArr,'code','post_master');
    }

    
    //////////////////////////////// manage jobs functions starts 
    public function index(){
        
        // get all code_names join with code_master
        $codeNamesArr = $this->codeNamesArr;
        // filter job types by code from array
        $job_types = $this->job_types;
        // filter job types by code from array
        $centers = $this->centers;
        // filter all posts
        $posts_list = $this->posts; 
        // get jobs
        $jobs = Jobs::join('rn_nos', 'rn_nos.id', '=', 'jobs.rn_no_id')
                ->orderBy('id','desc')
                ->where('jobs.status','!=',3)
                ->get(['jobs.*','rn_nos.rn_no']);
               
        //print_r($jobs);exit;
        return view('jobs.manage_jobs',compact('jobs','job_types','centers','posts_list'));

    }

    public function add_job($encodedId=""){

        // get all code_names join with code_master
        $codeNamesArr = $this->codeNamesArr;
        // filter job types by code from array
        $job_types = $this->job_types;
        // filter centers by code from array
        $centers = $this->centers;
        // filter payment modes by code from array
        $payment_modes = $this->payment_modes;
        // filter domain area by code from array
        $domain_areas = $this->domain_areas;
        // filter all posts
        $posts_list = $this->posts; 
        // get all RN No.'s
        $rn_nos = Rn_no::orderBy('id','desc')->get();
        $job = [];
        $domain_area_ids = [];
        if(!empty($encodedId)){
            $id = Helper::decodeId($encodedId);
            $job = Jobs::find($id);
            $domain_area_ids = JobDomainArea::where('job_id', $id)->where('status', 1)->get('domain_area_id')->toArray();
            $domain_area_ids = array_column($domain_area_ids, 'domain_area_id');
        }
        return view('jobs.add_job',compact('rn_nos','job_types','centers','payment_modes','domain_areas','job','domain_area_ids','posts_list'));
    }
    /*
    public function edit_job($encodedId){
        $id = Helper::decodeId($encodedId);
        $code = CodeMaster::find($id);
        return view('jobs.add_job',compact('code'));
    }
    */
    public function save_job(Request $request, $encodedId="")
    {
        try{
            
            $required = config("validations.required");
            $email_optional = config("validations.email_optional");
            $postData = $request->post();
            
            $request->validate([
                'rn_no_id' => $required,
                'post_id' => $required,
                'job_type_id' => $required,
                'center_id' => $required,
                'apply_start_date' => $required,
                'apply_end_date' => $required,
                'no_of_posts' => $required,
                'email_id' => $email_optional,
                'is_payment_required' => $required,
                'is_permanent' => $required,
                'status' => $required
            ]);
            
            // transactions start
            DB::beginTransaction();
            
            $postData = $request->post();
            $postNewArray = $postData;
            if(isset($postData['domain_area_ids']) && !empty($postData['domain_area_ids'])){
                $domain_area_ids = $postData['domain_area_ids'];
            }
            //print_r($domain_area_ids);exit;
            $rn_no_id = $postData['rn_no_id'];
            //print_r($postNewArray);exit;
            if(!empty($postData['apply_start_date'])){
                $apply_start_dateDMY = $postData['apply_start_date'];
                $apply_start_dateYMD = Helper::convertDateDMYtoYMD($apply_start_dateDMY);
                $postNewArray['apply_start_date'] = $apply_start_dateYMD;
            }
            if(!empty($postData['apply_end_date'])){
                $apply_end_dateDMY = $postData['apply_end_date'];
                $apply_end_dateYMD = Helper::convertDateDMYtoYMD($apply_end_dateDMY);
                $postNewArray['apply_end_date'] = $apply_end_dateYMD;
            }
            if(!empty($postData['hard_copy_submission_date'])){
                $hard_copy_submission_dateDMY = $postData['hard_copy_submission_date'];
                $hard_copy_submission_dateYMD = Helper::convertDateDMYtoYMD($hard_copy_submission_dateDMY);
                $postNewArray['hard_copy_submission_date'] = $hard_copy_submission_dateYMD;
            }
            if(!empty($postData['age_limit_as_on_date'])){
                $age_limit_as_on_dateDMY = $postData['age_limit_as_on_date'];
                $age_limit_as_on_dateYMD = Helper::convertDateDMYtoYMD($age_limit_as_on_dateDMY);
                $postNewArray['age_limit_as_on_date'] = $age_limit_as_on_dateYMD;
            }
            // file upload section start
            if(!empty($request->file('phd_document'))){
                try{
                    $fileData = $request->file('phd_document');
                    $destinationPath = "upload/phd_job_document";
                    $maxFileSizeKB = 5*1024*1024;// in KB
                    $fileExtentionArr = ['pdf','png','jpg','jpeg'];// should be array
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                    if($fileUploadRetArr['status'] == 1){
                        $phdFileName = $fileData->getClientOriginalName();
                        $postNewArray['phd_document'] = $phdFileName;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        //print_r($fileUploadRetArr);exit;
                        return redirect()->back()->with('file_error',$errorMsg);
                    }
                }catch(\Exception $e){
                    $errorMsg = $e->getMessage();
                    // log error in file
                    Helper::logErrorInFile($e);
                    return redirect()->back()->withInput()->with('file_error',$errorMsg);
                }
            }
            
            // get job configuration Id start
            $job_configuration_id = "";
            $postId = $postData['post_id'];
            $formConfigRec = FormConfiguration::where('post_id', $postId)
                                                ->where('status', 1)
                                                ->get(['form_configuration.*'])
                                                ->toArray();
            if(!empty($formConfigRec)){
                $job_configuration_id = $formConfigRec[0]['id'];
            }
            if(!empty($job_configuration_id)){
                $postNewArray['job_configuration_id'] = $job_configuration_id;
            }
            // get job configuration Id end
            // get job validation Id start
            $job_validation_id = "";
            $formValidationRec = JobValidation::where('post_id', $postId)
                                            ->where('status', 1)
                                            ->get(['job_validation.*'])
                                            ->toArray();
            if(!empty($formValidationRec)){
                $job_validation_id = $formValidationRec[0]['id'];
            }
            if(!empty($job_validation_id)){
                $postNewArray['job_validation_id'] = $job_validation_id;
            }
            // get job validation Id end

            $newDomainItems = [];
            if(!empty($encodedId)){
                
                $id = Helper::decodeId($encodedId);
                $jobData = Jobs::find($id);
                $jobData->fill($postNewArray);
                $jobData->save();
                
                $successMsg = "Job has been updated successfully";
                // domain area updations start
                $jobId = $id;
                if(isset($postData['domain_area_ids']) && !empty($postData['domain_area_ids'])){
                    $jobDomainIds = [];
                    $jobDomainArr = JobDomainArea::where('job_id', $jobId)
                                                ->where('status', 1)
                                                ->get('domain_area_id')
                                                ->toArray();
                    if(!empty($jobDomainArr)){
                        $jobDomainIds = array_column($jobDomainArr, 'domain_area_id');
                    }
                    if(!empty($jobDomainIds)){
                        // new domain ids

                        $newDomainItems = array_diff($domain_area_ids, $jobDomainIds);   
                        
                        // old unselected domain ids    
                        $oldDomainItems = array_diff($jobDomainIds, $domain_area_ids);  
                        
                        ///////////////////////////  old items status deleted start  /////////////////////////
                        if(!empty($oldDomainItems)){
                            JobDomainArea::where('job_id', $jobId)->whereIn('domain_area_id', $oldDomainItems)->update(['status' => 3]);
                        }
                        
                    }else{
                        $newDomainItems = $domain_area_ids;
                    }      
                } 
                
                // domain area updations end
            }else{
                //print_r($postNewArray);exit;
                // get job configuration Id start
                /*
                $job_configuration_id = "";
                $postId = $postData['post_id'];
                $formConfigRec = FormConfiguration::where('post_id', $postId)
                                                    ->where('status', 1)
                                                    ->get(['form_configuration.*'])
                                                    ->toArray();
                if(!empty($formConfigRec)){
                    $job_configuration_id = $formConfigRec[0]['id'];
                }
                if(!empty($job_configuration_id)){
                    $postNewArray['job_configuration_id'] = $job_configuration_id;
                }
                // get job configuration Id end
                // get job validation Id start
                $job_validation_id = "";
                $formValidationRec = JobValidation::where('post_id', $postId)
                                                ->where('status', 1)
                                                ->get(['job_validation.*'])
                                                ->toArray();
                if(!empty($formValidationRec)){
                    $job_validation_id = $formValidationRec[0]['id'];
                }
                if(!empty($job_validation_id)){
                    $postNewArray['job_validation_id'] = $job_validation_id;
                }
                */
                // get job validation Id end

                $insertedData = Jobs::create($postNewArray);
                if(isset($insertedData->id)){
                    $job_id = $insertedData->id;
                }
                $successMsg = "Job has been created successfully";
            }
            ///////////////////////////  new items added start  /////////////////////////
                // for domain ids
                $domainAreaBatch = [];
                foreach($newDomainItems as $domain_id){
                    $domainAreaArr = [];
                    $domainAreaArr['rn_no_id'] = $rn_no_id;
                    $domainAreaArr['job_id'] = $jobId;
                    $domainAreaArr['domain_area_id'] = $domain_id;
                    array_push($domainAreaBatch, $domainAreaArr);
                }
                
                if(!empty($domainAreaBatch)){
                    JobDomainArea::insert($domainAreaBatch);
                }
                ///////////////////////////  new items added end  /////////////////////////                     

            // transactions commit
            DB::commit();
            return redirect()->route('manage_jobs')->with('success',$successMsg);
        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            DB::rollback();
            // log error in file
            Helper::logErrorInFile($e);
            return redirect()->back()->withInput()->with('error_msg',$errorMsg);
        }
    }

    public function delete_job($encodedId){

            $postNewArray['status'] = 3;
            $id = Helper::decodeId($encodedId);
            $jobData = Jobs::find($id);
            $jobData->fill($postNewArray);
            $jobData->save();
            $successMsg = "Job has been deleted successfully";
            return redirect()->route('manage_jobs')->with('success',$successMsg);
    }

    ///////////////////////////////// manage jobs functions ends

    ///////////////////////////////// manage jobs validations functions starts
    public function manage_jobs_validation(){

        $jobsValidations = JobValidation::join('code_names', 'code_names.id', '=', 'job_validation.post_id')
                            ->orderBy('id','desc')
                            ->where('job_validation.status',1)
                            ->get(['job_validation.*','code_names.code_meta_name','code_names.code']);

        $validations = $jobsValidations;
        return view('jobs_validation.manage_jobs_validation',compact('validations'));

    }

    public function add_job_validation($encodedId=""){

        // get all RN No's from DB
        $posts = $this->posts;
        $ageCategoriesc = $this->age_category;
        $educations = $this->educations;
        $fee_categories = $this->fee_categories;
        $jobValidation = array();
        $ageRelaxationArr = array();
        $educationIds = array();
        $experienceArr = array();
        $categoryFeesArr = array();
        if(!empty($encodedId)){
            $job_validation_id = Helper::decodeId($encodedId);
            // get job validation
            $jobValidation = JobValidation::find($job_validation_id);
            // get age category relaxation data
            $ageRelaxationArr = JobAgeRelaxation::where('job_validation_id',$job_validation_id)->get(['id','category_id','years'])->toArray();
            if(!empty($ageRelaxationArr)){
                $ageCatIds = array_column($ageRelaxationArr, 'category_id');
                $ageCatYears = array_column($ageRelaxationArr, 'years');
                $ageRelaxationArr = array_combine($ageCatIds, $ageCatYears);
            }
            // min education
            $minEducation = JobEducationValidation::where('job_validation_id',$job_validation_id)->get(['id','education_id'])->toArray();
            if(!empty($minEducation)){
                $educationIds = array_column($minEducation, 'education_id');
            }
            // experience
            $experienceValidationsArr = JobExperienceValidation::where('job_validation_id',$job_validation_id)->get(['id','education_id','years'])->toArray();
            if(!empty($experienceValidationsArr)){
                $expEduIds = array_column($experienceValidationsArr, 'education_id');
                $expEduYears = array_column($experienceValidationsArr, 'years');
                $experienceArr = array_combine($expEduIds, $expEduYears);
            }
            // category wise fee
            $catWiseFeeArr = JobCategoryWiseFee::where('job_validation_id',$job_validation_id)->get(['id','fee_category_id','fee'])->toArray();
            if(!empty($catWiseFeeArr)){
                $feeCatIds = array_column($catWiseFeeArr, 'fee_category_id');
                $fees = array_column($catWiseFeeArr, 'fee');
                $categoryFeesArr = array_combine($feeCatIds, $fees);
            }
        }
        
        return view('jobs_validation.add_job_validation',compact('jobValidation','posts','ageCategoriesc','educations','fee_categories','ageRelaxationArr','educationIds','experienceArr','categoryFeesArr'));
    }
    
    public function ajaxGetJobsDropdownhtml(Request $request){

        $status = "success";
        $postData = $request->post();
        $selectedJobId = $postData['selectedJobId'];
        $html = "";
        if(isset($postData['rnnoId']) && !empty($postData['rnnoId'])){
            $rnNoId = $postData['rnnoId'];
            $jobs = Jobs::where('rn_no_id',$rnNoId)
                    ->select('id','job_title')
                    ->get();  
            if(!empty($jobs)){   
                $html = '<option value="">Select Job</option>';          
                foreach($jobs as $job){
                    $selected = "";
                    if($selectedJobId != "" && $selectedJobId == $job->id){
                        $selected = "selected=selected";
                    }
                    $html .= '<option value="'.$job->id.'" '.$selected.'>'.$job->job_title.'</option>';
                }  
            }       
        }else{
            $status = "error";
        }
        $retData['status'] = $status;
        $retData['html'] = $html;
        return response()->json($retData);
    }

    public function save_job_validation(Request $request, $encodedId="")
    {
        $required = config("validations.required");
        $request->validate([
            'post_id' => $required
        ]);
        $postData = $request->post();
        
        try{
            // job validation table transaction start
            $post_id = $postData['post_id'];
            
            // age relaxation array
            $ageCatWise = $postData['age_cat'];
            // education required
            $educations = array();
            if(isset($postData['educations']) && !empty($postData['educations'])){
                $educations = $postData['educations'];
            }
            // minimum experience
            $minExperience = $postData['minimum_experience'];
            // category wise fee
            $feeCatArr = $postData['fee_category'];
            
            // make validation table array
            $validationNewArray['post_id'] = $post_id;
            
            // mandatory fields
            $is_exp_tab = 0;
            if(isset($postData['exp_tab']) && !empty($postData['exp_tab'])){
                $is_exp_tab = $postData['exp_tab'];
            }
            $validationNewArray['is_exp_tab'] = $is_exp_tab;

            $is_publication_tab = 0;
            if(isset($postData['pub_tab']) && !empty($postData['pub_tab'])){
                $is_publication_tab = $postData['pub_tab'];
            }
            $validationNewArray['is_publication_tab'] = $is_publication_tab;

            $is_patent_tab = 0;
            if(isset($postData['patent_tab']) && !empty($postData['patent_tab'])){
                $is_patent_tab = $postData['patent_tab'];
            }
            $validationNewArray['is_patent_tab'] = $is_patent_tab;

            $is_research_tab = 0;
            if(isset($postData['research_tab']) && !empty($postData['research_tab'])){
                $is_research_tab = $postData['research_tab'];
            }
            $validationNewArray['is_research_tab'] = $is_research_tab;

            $is_proposal_tab = 0;
            if(isset($postData['proposal_tab']) && !empty($postData['proposal_tab'])){
                $is_proposal_tab = $postData['proposal_tab'];
            }
            $validationNewArray['is_proposal_tab'] = $is_proposal_tab;
            
            // transactions start
            DB::beginTransaction();

            if(!empty($encodedId)){
                $job_validation_id = Helper::decodeId($encodedId);
                // start delete transactions table data
                $statusDelete = 3;
                JobValidation::where('id', $job_validation_id)->update(array('status' => $statusDelete)); 
                JobAgeRelaxation::where('job_validation_id', $job_validation_id)->update(array('status' => $statusDelete)); 
                JobEducationValidation::where('job_validation_id', $job_validation_id)->update(array('status' => $statusDelete)); 
                JobExperienceValidation::where('job_validation_id', $job_validation_id)->update(array('status' => $statusDelete)); 
                JobCategoryWiseFee::where('job_validation_id', $job_validation_id)->update(array('status' => $statusDelete)); 
                // end delete transactions table data
                $successMsg = "Job has been updated successfully";
            }else{
                $successMsg = "Job has been created successfully";
                //echo $successMsg;
            }
            //echo "<pre>";
            //print_r($validationNewArray);exit;
            $data = JobValidation::create($validationNewArray); 
            //print_r($data);exit;
            
            if(isset($data->id)){
                $insertedValidationId = $data->id;
            }
            if(isset($insertedValidationId) && !empty($insertedValidationId)){
                // age relaxations insert loop start
                $insertAgeCatArr = array();
                foreach($ageCatWise as $key=>$ageCatYear){
                    if($ageCatYear != ""){
                        $category_id = $key;
                        $ageCatArr = array();
                        $ageCatArr['post_id'] = $post_id;
                        $ageCatArr['job_validation_id'] = $insertedValidationId;
                        $ageCatArr['category_id'] = $category_id;
                        $ageCatArr['years'] = $ageCatYear;
                        // insert
                        //JobAgeRelaxation::create($ageCatArr); 
                        array_push($insertAgeCatArr, $ageCatArr);
                    }
                }
                // insert in batch
                if(!empty($insertAgeCatArr)){
                    JobAgeRelaxation::insert($insertAgeCatArr);
                }
                // age relaxations insert loop end
                // education validation insert loop start
                $insertJobEduArr = array();
                foreach($educations as $education_id){
                        $jobEduArr = array();
                        $jobEduArr['post_id'] = $post_id;
                        $jobEduArr['job_validation_id'] = $insertedValidationId;
                        $jobEduArr['education_id'] = $education_id;
                        // insert
                        //JobEducationValidation::create($jobEduArr); 
                        array_push($insertJobEduArr, $jobEduArr);
                }
                // insert in batch
                if(!empty($insertJobEduArr)){
                    JobEducationValidation::insert($insertJobEduArr);
                }
                // education validation insert loop end
                // min experience insert loop start
                //print_r($minExperience);exit;
                $insertMinExperience = array();
                foreach($minExperience as $key=>$experience){
                    if(!empty($experience)){
                        $minExpArr = array();
                        $education_id = $key;
                        $minExpArr['post_id'] = $post_id;
                        $minExpArr['job_validation_id'] = $insertedValidationId;
                        $minExpArr['education_id'] = $education_id;
                        $minExpArr['years'] = $experience;
                        array_push($insertMinExperience, $minExpArr);
                    }
                    // insert
                    
                }
                // insert in batch
                if(!empty($insertMinExperience)){
                    JobExperienceValidation::insert($insertMinExperience);
                }
                // min experience insert loop end
                
                // category wise fee insert loop start
                $insertCatWiseFee = array();
                foreach($feeCatArr as $key=>$fee){
                    if(!empty($fee)){
                        $catFeeArr = array();
                        $fee_category_id = $key;
                        $catFeeArr['post_id'] = $post_id;
                        $catFeeArr['job_validation_id'] = $insertedValidationId;
                        $catFeeArr['fee_category_id'] = $fee_category_id;
                        $catFeeArr['fee'] = $fee;
                        array_push($insertCatWiseFee, $catFeeArr);
                    }
                }
                // insert in batch
                if(!empty($insertCatWiseFee)){
                    JobCategoryWiseFee::insert($insertCatWiseFee);
                }
                // category wise fee insert loop end
                
                // update validation id in jobs table
                $jobsData = [];
                if(isset($postData['job_id']) && !empty($postData['job_id'])){
                    $job_id = Helper::decodeId($postData['job_id']);
                    $jobsData['job_validation_id'] = $insertedValidationId;
                    Jobs::where('id',$job_id)->update($jobsData);
                }
            }
            
            // transactions commit
            DB::commit();
            return redirect()->route('manage_jobs_validation')->with('success',$successMsg);
            // job validation table transaction ends
        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            DB::rollback();
            // log error in file
            Helper::logErrorInFile($e);
            return redirect()->back()->withInput()->with('error_msg',$errorMsg);
        }
       
    }

    public function delete_job_validation($encodedId){

            $postNewArray['status'] = 3;
            $id = Helper::decodeId($encodedId);
            $jobData = Jobs::find($id);
            $jobData->fill($postNewArray);
            $jobData->save();
            $successMsg = "Job has been deleted successfully";
            return redirect()->route('manage_jobs_validation')->with('success',$successMsg);
    }
    ///////////////////////////////// manage jobs validations functions ends

    ///////////////////////////////// manage form tabs functions starts
    public function manage_form_tabs(){

            // get form tabs
            $formTabs = FormTabs::orderBy('sort_order','asc')->where('status',1)->get();
            return view('form_config.manage_form_tabs',compact('formTabs'));
    }

    public function add_form_tab($encodedId=""){

        $form_tab = [];
        if(!empty($encodedId)){
            $id = Helper::decodeId($encodedId);
            $form_tab = FormTabs::find($id);
        }
        return view('form_config.add_form_tab',compact('form_tab'));

    }

    public function save_form_tab(Request $request, $encodedId="")
    {

        $nameValidation = config("validations.name");
        $request->validate([
            'tab_title' => $nameValidation
        ]);
        if(!empty($encodedId)){
            $id = Helper::decodeId($encodedId);
            $formTabMaster = FormTabs::find($id);
            $formTabMaster->fill($request->all());
            $formTabMaster->save();
            $successMsg = "Form tab has been updated successfully";
        }else{
            $insertData = $request->post();
            $newSortOrder = 1;
            $maxSortOrderArr = FormTabs::orderBy('sort_order','desc')->limit(1)->get()->toArray();
            if(!empty($maxSortOrderArr)){
                $newSortOrder = $maxSortOrderArr[0]['sort_order'] + 1;
            }
            $insertData['sort_order'] = $newSortOrder;
            FormTabs::create($insertData);
            $successMsg = "Form tab has been created successfully";
        }
        
        return redirect()->route('manage_form_tabs')->with('success',$successMsg);

    }

    public function update_form_tabs_sorting(Request $request)
    {
        try{
            $index = 1;
            foreach ($request->order as $order) {
                    $sortOrder = $index;
                    $id = $order['id'];
                    FormTabs::where('id', $id)->update(array('sort_order' => $sortOrder)); 
                    $index++;
            }
            $status = "success";
            $msg = "Form Tabs sorting order updated successfully.";
        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            // log error in file
            Helper::logErrorInFile($e);
            $status = "error";
            $msg = $errorMsg;    
        }    
            
        $retData['status'] = $status;
        $retData['msg'] = $msg;
        return response()->json($retData);
    }

    public function delete_form_tab($encodedId){

            $postNewArray['status'] = 3;
            $id = Helper::decodeId($encodedId);
            $formTabData = FormTabs::find($id);
            $formTabData->fill($postNewArray);
            $formTabData->save();
            $successMsg = "Form tab has been deleted successfully";
            return redirect()->route('manage_form_tabs')->with('success',$successMsg);
    }
    ///////////////////////////////// manage form tabs functions ends

    ///////////////////////////////// manage form fields functions starts
    public function manage_form_fields(){

            // get form tabs
            /*
            $formFields = FormTabFields::join('form_tabs','form_tabs.id', '=', 'form_tab_fields.form_tab_id')
                            ->where('form_tab_fields.status',1)
                            ->groupBy('form_tab_fields.*','form_tab_id')
                            ->get(['form_tab_fields.*', 'form_tabs.tab_title']);
            */

            $formFields = FormTabFields::join('form_tabs', 'form_tabs.id', '=', 'form_tab_fields.form_tab_id')
                            ->where('form_tab_fields.status', 1)
                            ->orderBy('form_tab_fields.form_tab_id','asc')
                            ->orderBy('form_tab_fields.id','asc')
                            ->get(['form_tab_fields.id','form_tab_fields.field_name','form_tab_fields.field_slug','form_tabs.tab_title','form_tab_fields.form_tab_id']);     
            //echo "<pre>";                 
            //print_r($formFields);exit;                          
            return view('form_config.manage_form_fields',compact('formFields'));
    }

    public function add_form_field($encodedId=""){

        $formField = [];
        if(!empty($encodedId)){
            $id = Helper::decodeId($encodedId);
            $formField = FormTabFields::find($id);
        }
        // get form tabs
        $formTabs = FormTabs::orderBy('sort_order','asc')->where('status',1)->get();
        return view('form_config.add_form_field',compact('formField','formTabs'));

    }

    public function save_form_field(Request $request, $encodedId="")
    {

        $nameValidation = config("validations.name");
        $request->validate([
            'field_name' => $nameValidation,
            'form_tab_id' => 'required'
        ]);
        if(!empty($encodedId)){
            $id = Helper::decodeId($encodedId);
            $formTabFields = FormTabFields::find($id);
            $formTabFields->fill($request->all());
            $formTabFields->save();
            $successMsg = "Form field has been updated successfully";
        }else{
            $insertData = $request->post();
            $tabId = $insertData['form_tab_id'];
            $newSortOrder = 1;
            $maxSortOrderArr = FormTabFields::orderBy('sort_order','desc')->where('form_tab_id',$tabId)->limit(1)->get()->toArray();
            if(!empty($maxSortOrderArr)){
                $newSortOrder = $maxSortOrderArr[0]['sort_order'] + 1;
            }
            $insertData['sort_order'] = $newSortOrder;

            $field_slug = trim(strtolower($insertData['field_name']));
            $field_slug = str_replace(" / ", "_", $field_slug);
            $field_slug = str_replace(" ", "_", $field_slug);
            $field_slug = str_replace("'", "", $field_slug);
            $field_slug = preg_replace('/[^A-Za-z0-9\-]/', '', $field_slug);
            $insertData['field_slug'] = $field_slug;

            FormTabFields::create($insertData);
            $successMsg = "Form field has been created successfully";
        }
        
        return redirect()->route('manage_form_fields')->with('success',$successMsg);

    }

    public function delete_form_field($encodedId){

            $postNewArray['status'] = 3;
            $id = Helper::decodeId($encodedId);
            $formTabFields = FormTabFields::find($id);
            $formTabFields->fill($postNewArray);
            $formTabFields->save();
            $successMsg = "Form field has been deleted successfully";
            return redirect()->route('manage_form_fields')->with('success',$successMsg);
    }
    ///////////////////////////////// manage form fields functions ends

    ///////////////////////////////// manage form configuration functions starts
    public function manage_form_configuration(){

            $formConfigurations = FormConfiguration::join('code_names','code_names.id','=','form_configuration.post_id')
                                        ->orderBy('form_configuration.id','desc')
                                        ->get(['form_configuration.id','code_names.code_meta_name']);    
                                    
            return view('form_config.manage_form_configuration',compact('formConfigurations'));
    }

    public function add_form_configuration($encodedId=""){

        $formConfiguration = [];
        $formTabsConfig = [];
        $formFieldsConfiguration = [];
        if(!empty($encodedId)){
            $id = Helper::decodeId($encodedId);
            $formConfiguration = FormConfiguration::find($id);
            if(!empty($formConfiguration)){
                $formConfigId = $formConfiguration->id;
                // for tabs
                $formTabsConfig = FormFieldsConfiguration::where('form_config_id', $formConfigId)
                                                            ->where('is_tab_field', 1)
                                                            ->where('status', 1)
                                                            ->get()
                                                            ->toArray();
                // for fields
                $formFieldsConfiguration = FormFieldsConfiguration::where('form_config_id', $formConfigId)
                                                            ->where('is_tab_field', 2)
                                                            ->where('status', 1)
                                                            ->get()
                                                            ->toArray();                                            
            }
        }
        // get RN No's
        $posts = $this->posts; 
        // get tabs with fields
        
        $formTabs = FormTabs::orderBy('sort_order', 'asc')->get();
        $formTabFields = FormTabFields::orderBy('sort_order','asc')->get()->toArray();
        
                  
        return view('form_config.add_form_configuration',compact('formConfiguration','posts','formTabs','formTabFields','formTabsConfig','formFieldsConfiguration'));

    }   

    public function save_form_configuration(Request $request, $encodedId="")
    {

        $required = config("validations.required");
        $request->validate([
            'post_id' => $required
        ]);
        try{
            // transactions start
            DB::beginTransaction();
            $insertData = $request->post();
            $post_id = $insertData['post_id'];
            $form_tabs = $insertData['form_tab'];
            $form_fields = $insertData['form_fields'];
            if(!empty($encodedId)){
                // update data
                $id = Helper::decodeId($encodedId);
                // for tabs
                $formTabsConfig = FormFieldsConfiguration::where('form_config_id', $id)
                                                            ->where('is_tab_field', 1)
                                                            ->where('status', 1)
                                                            ->get(['form_tab_field_id'])
                                                            ->toArray();
                $formTabsConfig = array_column($formTabsConfig, 'form_tab_field_id');                                            
                // for fields
                $formFieldsConfiguration = FormFieldsConfiguration::where('form_config_id', $id)
                                                            ->where('is_tab_field', 2)
                                                            ->where('status', 1)
                                                            ->get(['form_tab_field_id'])
                                                            ->toArray();   
                $formFieldsConfiguration = array_column($formFieldsConfiguration, 'form_tab_field_id');                                            
                // new selected tabs 
                
                $newTabItems = array_diff($form_tabs, $formTabsConfig);   
                //echo count($newTabItems);exit;
                // old unselected tabs    
                $oldTabItems = array_diff($formTabsConfig, $form_tabs);  
                // new selected form items    
                $newFormFieldItems = array_diff($form_fields, $formFieldsConfiguration);         
                // old unselected form items    
                $oldFormFieldItems = array_diff($formFieldsConfiguration, $form_fields);  
                ///////////////////////////  new items added start  /////////////////////////
                
                $batchInsertArr = [];
                $form_config_id = $id;
                // for tab field ids
                foreach($newTabItems as $tab_id){
                    $tabFieldArr = [];
                    $tabFieldArr['form_config_id'] = $form_config_id;
                    $tabFieldArr['form_tab_field_id'] = $tab_id;
                    $tabFieldArr['is_tab_field'] = 1; // 1 for tab
                    array_push($batchInsertArr, $tabFieldArr);
                }
                // for fields ids
                foreach($newFormFieldItems as $field_id){
                    $tabFieldArr = [];
                    $tabFieldArr['form_config_id'] = $form_config_id;
                    $tabFieldArr['form_tab_field_id'] = $field_id;
                    $tabFieldArr['is_tab_field'] = 2; // 2 for fields
                    array_push($batchInsertArr, $tabFieldArr);
                }
                if(!empty($batchInsertArr)){
                    FormFieldsConfiguration::insert($batchInsertArr);
                }
                ///////////////////////////  new items added end  /////////////////////////
                ///////////////////////////  old items status deleted start  /////////////////////////
                FormFieldsConfiguration::where('is_tab_field', 1)->whereIn('form_tab_field_id', $oldTabItems)->update(['status' => 3]);
                FormFieldsConfiguration::where('is_tab_field', 2)->whereIn('form_tab_field_id', $oldFormFieldItems)->update(['status' => 3]);
                ///////////////////////////  old items status deleted end  /////////////////////////
                $successMsg = "Form field has been updated successfully";
            }else{
                // create new entry
                
                $batchInsertArr = [];
                // one entry in form_configuration table
                $formConfigArr = [];
                $formConfigArr['post_id'] = $post_id;
                $data = FormConfiguration::create($formConfigArr);
                if(isset($data->id)){
                    $form_config_id = $data->id;
                    // for tab field ids
                    foreach($form_tabs as $tab_id){
                        $tabFieldArr = [];
                        $tabFieldArr['form_config_id'] = $form_config_id;
                        $tabFieldArr['form_tab_field_id'] = $tab_id;
                        $tabFieldArr['is_tab_field'] = 1; // 1 for tab
                        array_push($batchInsertArr, $tabFieldArr);
                    }
                    // for fields ids
                    foreach($form_fields as $field_id){
                        $tabFieldArr = [];
                        $tabFieldArr['form_config_id'] = $form_config_id;
                        $tabFieldArr['form_tab_field_id'] = $field_id;
                        $tabFieldArr['is_tab_field'] = 2; // 2 for fields
                        array_push($batchInsertArr, $tabFieldArr);
                    }

                    FormFieldsConfiguration::insert($batchInsertArr);
                    $successMsg = "Form field has been created successfully";
                }

            }
            // update form configuration id in jobs table
            $jobsData = [];
            if(isset($postData['job_id']) && !empty($postData['job_id'])){
                $job_id = Helper::decodeId($postData['job_id']);
                $jobsData['job_configuration_id'] = $form_config_id;
                Jobs::where('id',$job_id)->update($jobsData);
            }
            // transactions start
            DB::commit();
        }catch(\Exception $e){
            //print_r($e);exit;
            $errorMsg = $e->getMessage();
            // log error in file
            Helper::logErrorInFile($e);
            return redirect()->back()->withInput()->with('error_msg',$errorMsg);
        }
        
        return redirect()->route('manage_form_configuration')->with('success',$successMsg);

    }

    public function delete_form_configuration($encodedId){

            $postNewArray['status'] = 3;
            $id = Helper::decodeId($encodedId);
            $formTabFields = FormConfiguration::find($id);
            $formTabFields->fill($postNewArray);
            $formTabFields->save();
            $successMsg = "Form field has been deleted successfully";
            return redirect()->route('manage_form_configuration')->with('success',$successMsg);
    }
    ///////////////////////////////// manage form configuration functions ends

    ///////////////////////////////// exam center mapping functions starts

    public function manage_exam_centers_mapping(){

        $examCentersMapp = ExamCenterMapping::join('rn_nos','rn_nos.id','=','exam_center_mapping.rn_no_id')
                                            ->groupBy(['exam_center_mapping.job_id','rn_nos.rn_no','rn_nos.id'])
                                            ->get(['exam_center_mapping.job_id','rn_nos.rn_no','rn_nos.id','exam_center_mapping.id as exam_center_map_id'])
                                            ->toArray();
        /*echo "<pre>";
        print_r($examCentersMapp);
        exit;*/                                    
        return view('jobs.manage_exam_centers_mapping',compact('examCentersMapp'));
    }

    public function add_exam_center_mapping($rn_no_id="", $jobId=""){

        $posts_list = [];
        $examCenters = [];
        $selectedCentersIds = [];
        if(!empty($rn_no_id)){
            $posts_list = Jobs::join('code_names', 'code_names.id', '=', 'jobs.post_id')
                                ->orderBy('jobs.id','asc')
                                ->where('rn_no_id', $rn_no_id)
                                ->where('jobs.status','!=',3)
                                ->get(['jobs.id','code_names.code_meta_name'])
                                ->toArray();

            $examCenters = ExamCenters::orderBy('centre_name','asc')->get(['exam_centers.*'])->toArray();

            if(!empty($jobId)){
                $examCentersMapp = ExamCenterMapping::where('job_id',$jobId)
                                            ->where('status',1)
                                            ->get(['exam_center_id'])
                                            ->toArray();
                if(!empty($examCentersMapp)){                            
                    $selectedCentersIds = array_column($examCentersMapp, 'exam_center_id');
                }
            }
        }
        $rn_nos = Rn_no::orderBy('id','desc')->get();
        return view('jobs.exam_center_mapping',compact('rn_nos','posts_list','examCenters','rn_no_id','selectedCentersIds','jobId'));
    }

    
    public function save_exam_center_mapping(Request $request, $jobId=""){

            try{
                        
                $insertData = $request->post();
                
                $validator = $request->validate([
                                'rn_no_id' => 'required',
                                'job_id' => 'required',
                                'exam_centers' => 'required'
                            ]);

                DB::beginTransaction();
                $batchInsertArr = [];
                $exam_centers = $insertData['exam_centers'];
                $newIds = [];
                $commonIds = [];      
                if(!empty($jobId)){
                    $examCenterIdsArr = ExamCenterMapping::where('job_id', $jobId)->where('status', 1)->get(['exam_center_id'])->toArray();                                       
                    if(!empty($examCenterIdsArr)){
                        $examCenterIds = array_column($examCenterIdsArr, 'exam_center_id');                                            
                        // new IDs to insert
                        $newIds = array_diff($exam_centers, $examCenterIds);   
                        //echo count($newTabItems);exit;
                        // old IDs to delete    
                        $oldIds = array_diff($examCenterIds, $exam_centers);  
                        // Ids to Update
                        $commonIds = array_intersect($exam_centers, $examCenterIds);  

                        // delete old Ids start
                        if(!empty($oldIds)){
                            ExamCenterMapping::where('job_id', $jobId)
                                                    ->where('status', 1)
                                                    ->whereIn('exam_center_id', $oldIds)
                                                    ->update(['status' => 3]);
                        }
                        // delete old Ids end

                    }else{
                        $newIds = $exam_centers;
                    } 
                }
                if(!empty($exam_centers)){
                    foreach($exam_centers as $center_id){
                        $mappginArr = [];
                        $mappginArr['rn_no_id'] = $insertData['rn_no_id'];
                        $mappginArr['job_id'] = $insertData['job_id'];
                        $mappginArr['exam_center_id'] = $center_id;
                        // push in batch insert array
                        if(!empty($newIds) && in_array($center_id, $newIds)){
                            array_push($batchInsertArr, $mappginArr);
                        }
                        // push in batch update array
                        if(!empty($commonIds) && in_array($center_id, $commonIds)){
                            ExamCenterMapping::where('job_id', $jobId)
                                            ->where('status', 1)
                                            ->where('exam_center_id', $center_id)
                                            ->update($mappginArr);
                        }
                    }
                    if(!empty($batchInsertArr)){
                        ExamCenterMapping::insert($batchInsertArr);
                    }
                    DB::commit();
                    $finalSubmitRouteUrl = route('manage_exam_centers_mapping');
                    return redirect($finalSubmitRouteUrl)->with('success','Records added.');
                }else{
                    return redirect()->back()->withInput()->with('error_msg','Please select exam centers.');
                }
            
            }catch(\Exception $e){
                $errorMsg = $e->getMessage();
                //$errorMsg = "Something went wrong. Please contact administrator.";
                DB::rollback();
                // log error in file
                Helper::logErrorInFile($e);
                return redirect()->back()->withInput()->with('error_msg',$errorMsg);
            }
        
    }

    public function delete_exam_center_mapping($rn_no_id="", $jobId=""){

        // delete old Ids start
        if(!empty($rn_no_id) && !empty($jobId)){
            ExamCenterMapping::where('job_id', $jobId)
                                    ->where('status', 1)
                                    ->update(['status' => 3]);
        }
        $finalSubmitRouteUrl = route('manage_exam_centers_mapping');
        return redirect($finalSubmitRouteUrl)->with('success','Records deleted.');
    }
    ///////////////////////////////// exam center mapping functions ends

    ///////////////////////////////// exam shift function start
    public function exam_interview_shift($exam_center_map_id="", $job_id=""){

        echo $exam_center_map_id;exit;
        $examCenters = ExamCenterMapping::join('exam_centers','exam_centers.id','=','exam_center_mapping.exam_center_id')
                                            ->where(['exam_center_mapping.id',$exam_center_map_id])
                                            ->get(['exam_center_mapping.id','exam_centers.centre_name','exam_centers.centre_address'])
                                            ->toArray();
        return view('jobs.exam_interview_shift', compact('exam_center_map_id','job_id','examCenters'));
    }
    ///////////////////////////////// exam shift function end
    
    ///////////////////////////////// manage form field types functions starts
    /*
    public function manage_form_field_types(){

            // get form tabs
            $formFieldType = FormFieldType::orderBy('id','desc')->where('status',1)->get();
            return view('form_config.manage_form_field_types',compact('formFieldType'));
    }

    public function add_form_field_type($encodedId=""){

        $formFieldType = [];
        if(!empty($encodedId)){
            $id = Helper::decodeId($encodedId);
            $formFieldType = FormFieldType::find($id);
        }
        return view('form_config.add_form_field_type',compact('formFieldType'));

    }

    public function save_form_field_type(Request $request, $encodedId="")
    {

        $nameValidation = config("validations.name");
        $request->validate([
            'field_type' => $nameValidation
        ]);
        if(!empty($encodedId)){
            $id = Helper::decodeId($encodedId);
            $formFieldType = FormFieldType::find($id);
            $formFieldType->fill($request->all());
            $formFieldType->save();
            $successMsg = "Form field type has been updated successfully";
        }else{
            $insertData = $request->post();
            FormFieldType::create($insertData);
            $successMsg = "Form field type has been created successfully";
        }
        
        return redirect()->route('manage_form_field_types')->with('success',$successMsg);

    }

    public function delete_form_field_type($encodedId){

            $postNewArray['status'] = 3;
            $id = Helper::decodeId($encodedId);
            $formFieldTypeData = FormFieldType::find($id);
            $formFieldTypeData->fill($postNewArray);
            $formFieldTypeData->save();
            $successMsg = "Form field type has been deleted successfully";
            return redirect()->route('manage_form_field_types')->with('success',$successMsg);
    }
    */
    ///////////////////////////////// manage form field types functions ends

}
