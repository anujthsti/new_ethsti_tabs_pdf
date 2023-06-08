<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use PDF;

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
use App\Models\RegisterCandidate;
use App\Models\CandidatesJobsApply;
use App\Models\CandidatesAcademicsDetails;
use App\Models\CandidatesExperienceDetails;
use App\Models\CandidatesPublicationsDetails;
use App\Models\CandidatesRefreeDetails;
use App\Models\CandidatesPHDResearchDetails;
use App\Models\CandidatesExperienceDocuments;
use App\Models\CandidatesCommonDocuments;
use App\Models\CandidatesAcademicsDocuments;
use App\Models\FeeTransactions;
use App\Models\FeeStatusTransactions;
use App\Models\FeeCroneJob;
use App\Models\FeeCroneJobTrans;
use App\Models\RegistrationOTP;

class ApplicationController extends Controller
{

    public function __construct(Request $request){
        /*
        $candidateLoginId = $request->session()->get('candidate_id');
        if(!isset($candidateLoginId) || empty($candidateLoginId)){
            return redirect()->route('candidate_dashboard_login');
        }
        */
    }

    public function jobs(Request $request, $jobTypeCoreOrProject=""){

        // get jobs
        $masterCode = 'job_types';
        $codeNamesArr = ['online','train_program'];
        $jobTypeIDsToApplyBtn = Helper::getCodeNamesIdsByCodes($masterCode, $codeNamesArr);
        // get rolling job type
        $rollingNamesArr = ['rolling'];
        $jobTypeIDsRolling = Helper::getCodeNamesIdsByCodes($masterCode, $rollingNamesArr);
        //print_r($jobTypeIDsToApplyBtn);exit;
        $currentDate = date('Y-m-d');
        $jobs = Jobs::join('rn_nos', 'rn_nos.id', '=', 'jobs.rn_no_id')
                ->join('code_names', 'code_names.id', '=', 'jobs.post_id')
                ->orderBy('id','desc')
                ->where('jobs.status',1)
                ->where('jobs.apply_end_date','>=',$currentDate)
                ->get(['jobs.*','rn_nos.rn_no','rn_nos.rn_document','code_names.code_meta_name']);
          
        return view('application.jobs',compact('jobs','jobTypeIDsToApplyBtn','jobTypeCoreOrProject','jobTypeIDsRolling'));
    }

    // function to show instruction page
    public function instructions(Request $request, $jobEncID=""){

        if(!empty($jobEncID)){
            $jobId = Helper::decodeId($jobEncID);
            $jobData = Jobs::find($jobId);
            $rnNoId = $jobData->rn_no_id;
            // set session of jobId and rnNoId
            $request->session()->put('applicationJobId', $jobId);
            $request->session()->put('applicationRNNOId', $rnNoId);
            
            return view('application.instructions');
        }else{
            // if user will access page directly then redirect to jobs list page
            return redirect()->route('jobs');
        }

    }

    // function for login page
    public function login(Request $request){

        return view('application/login');
    }

    public function check_login(Request $request){
 
        $request->validate([
            'email' => 'required',
            'mobile' => 'required'
        ]);
        $postData = $request->post();
        $email = $postData['email'];
        $mobile = $postData['mobile'];
        $loginUserData = RegisterCandidate::where('email_id', $email)
                            ->where('mobile_no', $mobile)
                            ->where('status', 1)
                            ->get(['id'])
                            ->toArray();
                            
        if(!empty($loginUserData)){
            $candidate_id = $loginUserData[0]['id'];
            $request->session()->put('candidate_id', $candidate_id);
            $jobId = $request->session()->get('applicationJobId');
            $rnNoId = $request->session()->get('applicationRNNOId');
            if(!empty($jobId) && !empty($rnNoId)){
                $existingRec = CandidatesJobsApply::where('rn_no_id', $rnNoId)
                                                    ->where('job_id', $jobId)  
                                                    ->where('candidate_id', $candidate_id)
                                                    ->where('status', 1)
                                                    ->get(['candidates_jobs_apply.id'])
                                                    ->toArray();
                if(empty($existingRec)){                                    
                    $insertArr['rn_no_id'] = $rnNoId;
                    $insertArr['job_id'] = $jobId;
                    $insertArr['candidate_id'] = $candidate_id;
                    CandidatesJobsApply::create($insertArr);
                }
            }
            return redirect()->route('dashboard');
        }else{
            $msg = "Invalid email or password.";
            return redirect()->route('candidate_dashboard_login')->with('errorMsg',$msg);
        }
    }

    // logout function
    public function logout(Request $request){
        $request->session()->flush('candidate_id');
        return redirect()->route('candidate_dashboard_login');
    }

    // common function to get data for candidate register/edit details forms
    public function get_candidate_selected_job_details($jobId){

            $fieldsArray = [];
            $domainAreas = [];
            $codeNamesArr = [];
            $jobData = Jobs::join('rn_nos', 'rn_nos.id', '=', 'jobs.rn_no_id')
                            ->join('code_names', 'code_names.id', '=', 'jobs.post_id')
                            ->where('jobs.id',$jobId)
                            ->get(['jobs.*','rn_nos.id as rn_no_id','rn_nos.rn_no','code_names.code_meta_name'])
                            ->toArray();
            //echo "jobId: ".$jobId;exit;               
            if(!empty($jobData)){                
                // formFields
                $post_id = $jobData[0]['post_id'];
                $job_configuration_id = $jobData[0]['job_configuration_id'];
                //echo "post_id: ".$post_id;exit;
                $is_tab_field = 2; // for fields
                $fieldsArray = [];
                if(!empty($job_configuration_id)){
                    $formFields = FormFieldsConfiguration::join('form_configuration','form_configuration.id','=','form_fields_configuration.form_config_id')  
                                                            ->join("form_tab_fields",function($join){
                                                                $join->on('form_tab_fields.id','=','form_fields_configuration.form_tab_field_id')
                                                                    ->where('form_tab_fields.status',1);
                                                            })        
                                                            ->where('is_tab_field',$is_tab_field)
                                                            ->where('form_configuration.id',$job_configuration_id)
                                                            ->where('form_fields_configuration.status',1)
                                                            ->get(['form_fields_configuration.form_tab_field_id','form_tab_fields.field_slug'])
                                                            ->toArray();  
                }
                else{
                    $formFields = FormFieldsConfiguration::join('form_configuration','form_configuration.id','=','form_fields_configuration.form_config_id')  
                                                            ->join("form_tab_fields",function($join){
                                                                $join->on('form_tab_fields.id','=','form_fields_configuration.form_tab_field_id')
                                                                    ->where('form_tab_fields.status',1);
                                                            })        
                                                            ->where('is_tab_field',$is_tab_field)
                                                            ->where('form_configuration.post_id',$post_id)
                                                            ->where('form_fields_configuration.status',1)
                                                            ->get(['form_fields_configuration.form_tab_field_id','form_tab_fields.field_slug'])
                                                            ->toArray();   
                } 
                //print_r($formFields);exit;                                        
                if(!empty($formFields)){                                        
                    $fieldsArray = array_column($formFields,'field_slug');   
                }                                           
                
                // domain area array
                $domainAreas = JobDomainArea::join('code_names','code_names.id','=','job_domain_area.domain_area_id')
                                            ->where('job_id', $jobId)
                                            ->where('job_domain_area.status', 1)
                                            ->get(['code_names.id','code_names.code_meta_name']);

                // get all code_names join with code_master
                $codeNamesArr = Helper::getCodeNames();
                // call view
            }
            $retArray = [];
            $retArray = compact('jobData','fieldsArray','domainAreas','codeNamesArr');
            //print_r($retArray);exit;
            return $retArray;
            
    }

    // function for online registration page
    public function online_registration(Request $request){

        $captcha_code = Helper::get_captcha_code();
        // set session of captcha for registration form
        $request->session()->put('registration_captcha', $captcha_code);
        // set session of job id and RN No. id
        $jobId = $request->session()->get('applicationJobId');
        $rnNoId = $request->session()->get('applicationRNNOId');
        if(!empty($jobId) && !empty($rnNoId)){
            $retData = $this->get_candidate_selected_job_details($jobId);
            $jobData = $retData['jobData'];
            $fieldsArray = $retData['fieldsArray'];
            $domainAreas = $retData['domainAreas'];
            $codeNamesArr = $retData['codeNamesArr'];
            if(!empty($jobData)){                
                // call view
                return view('application.register', compact('jobData','fieldsArray','domainAreas','codeNamesArr','captcha_code','jobId','rnNoId'));
            }else{
                echo "Something went wrong.";
                exit;
            }
        }else{
            // if user will access page directly then redirect to jobs list page
            return redirect()->route('jobs_list');
        } 
    }
    

    // get age in years, months, days from 2 dates difference
    public function calculate_age(){

        $dob = $_POST['dob'];
        $as_on_date = $_POST['as_on_date'];
        $calculatedAge = $this->calculate_age_by_parm($dob, $as_on_date);
        //$interval = date_diff(date_create($dob), date_create($as_on_date));
        //$calculatedAge = $interval->format("%Y Year, %M Months, %d Days");
        return $calculatedAge;
    }

    public function calculate_age_by_parm($dob, $as_on_date){

        $interval = date_diff(date_create($dob), date_create($as_on_date));
        $calculatedAge = $interval->format("%Y Year, %M Months, %d Days");
        return $calculatedAge;
    }

    // common function to get experience in years, months, days from 2 dates difference
    public function calculate_experience(){

        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $to_date = date("Y-m-d", strtotime($to_date." + 1 days"));
        $interval = date_diff(date_create($from_date), date_create($to_date));
        $calculatedExp = $interval->format("%Y Year, %M Months, %d Days");
        return $calculatedExp;
    }

    // get grand total experience
    public function calculate_grand_total_exp(){

        //grand total experience calculation
        $totalExp = $_POST['totalExp'];
        $years = 0;
        $months = 0;
        $days = 0;
        foreach($totalExp as $exp_val){
            $exp = explode("-",$exp_val);	
            $yr = explode(" ",$exp[0]);
            $mn = explode(" ",$exp[1]);	
            $dy = explode(" ",$exp[2]);
               
            $years = $years+$yr[0];
            $months = $months+$mn[0];
            $days = $days+$dy[0];		
                
            while($days>=31)
            {
                $months++;
                $days = $days-31;		
            }	
            while($months>=12)
            {
                $years++;
                $months = $months-12;										
            }				
        }
        $retData = $years." YEARS,".$months." MONTHS,".$days." DAYS";
        return $retData;
    }

    // get refresh captcha value
    public function refresh_captcha(Request $request){

        $captcha_code = Helper::get_captcha_code();
        // set session of captcha for registration form
        $request->session()->put('registration_captcha', $captcha_code);
        return $captcha_code;
    }

    // save registration details for user
    public function save_registration_details(Request $request){

        $postData = $request->post();
        //print_r($postData);exit;
        $security_code = "";//$request->session()->get('registration_captcha');
        $email_id = $postData['email_id'];
        $email_otp = $postData['email_otp'];
        $emailValidate = '|check_unique_registration:'.$email_id;
        $validator = $this->validate_candidate_details($request, $security_code, $emailValidate, $email_otp, $email_id);
        
        try{
            if($validator->fails()) {
                //withInput keep the users info
                return redirect()->back()->withInput()->withErrors($validator->messages());
            } else {
                //echo 11;exit;
                // transactions start
                DB::beginTransaction();
                $postNewArray = [];
                $postNewArray = $this->register_candidate_personal_details_arr($postData);
                if(!empty($postNewArray)){
                    $insertedRec = RegisterCandidate::create($postNewArray);
                    if(isset($insertedRec->id)){
                        $candidate_id = $insertedRec->id;
                        // set session of registered user
                        $request->session()->put('candidate_id', $candidate_id);
                        $jobApplyArr = [];
                        $jobApplyArr = $this->candidate_job_apply_info_arr($postData, $candidate_id);
                        // update is_basic_info_done to 1 - completed
                        $jobApplyArr['is_basic_info_done'] = 1;
                        CandidatesJobsApply::create($jobApplyArr);
                    }
                }
                // transactions commit
                DB::commit();
                return redirect()->route('dashboard')->with('success','Registration Successfull.');
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

    // candidate dashboard
    public function dashboard(Request $request){
        
        // set session of job id and RN No. id
        $candidate_id = $request->session()->get('candidate_id');
        if(isset($candidate_id) && !empty($candidate_id)){
            $candidate_details = RegisterCandidate::find($candidate_id);
            $candidateJobApplyDetailArr = CandidatesJobsApply::join('rn_nos','rn_nos.id','=','candidates_jobs_apply.rn_no_id')
                                                        ->join('jobs','jobs.id','=','candidates_jobs_apply.job_id')
                                                        ->orderBy('candidates_jobs_apply.id','desc')
                                                        ->where('candidates_jobs_apply.candidate_id', $candidate_id)
                                                        ->where('candidates_jobs_apply.status', 1)
                                                        ->get(['candidates_jobs_apply.id','candidates_jobs_apply.is_completed','candidates_jobs_apply.rn_no_id','candidates_jobs_apply.job_id','candidates_jobs_apply.domain_id','candidates_jobs_apply.application_status','candidates_jobs_apply.is_basic_info_done','candidates_jobs_apply.is_qualification_exp_done','candidates_jobs_apply.is_phd_details_done','candidates_jobs_apply.is_document_upload_done','candidates_jobs_apply.is_final_submission_done','candidates_jobs_apply.is_payment_done','candidates_jobs_apply.payment_status','candidates_jobs_apply.is_final_submit_after_payment','rn_nos.rn_no','jobs.post_id','jobs.job_type_id','jobs.is_payment_required','jobs.job_validation_id'])
                                                        ->toArray();
            $mastersDataArr = Helper::getCodeNames();    
            $postsMasterArr = Helper::getCodeNamesByCode($mastersDataArr,'code','post_master');
            $domainAreaArr = Helper::getCodeNamesByCode($mastersDataArr,'code','domain_area');
            
            return view('application.dashboard',compact('candidate_details','candidateJobApplyDetailArr','mastersDataArr','postsMasterArr','domainAreaArr'));
        }else{
            // if user will access page directly then redirect to jobs list page
            return redirect()->route('candidate_dashboard_login');
        }
        
    }

    // candidate edit applied job details
    public function edit_candidate_applied_job_details(Request $request, $candidateJobApplyEncID, $formTabIdEnc=""){
        
        $captcha_code = Helper::get_captcha_code();
        
        // set session of captcha for registration form
        $request->session()->put('registration_captcha', $captcha_code);
        $formTabId = "";
        if(isset($formTabIdEnc) && !empty($formTabIdEnc)){
            $formTabId = Helper::decodeId($formTabIdEnc);
        }
        $candidateJobApplyID = Helper::decodeId($candidateJobApplyEncID);
        $candidateJobApplyDetail = CandidatesJobsApply::join('register_candidates','register_candidates.id','=','candidates_jobs_apply.candidate_id')
                                                        ->join('jobs','jobs.id','=','candidates_jobs_apply.job_id')
                                                        ->where('candidates_jobs_apply.id',$candidateJobApplyID)
                                                        ->where('jobs.status','!=',3)
                                                        ->get(['register_candidates.*','candidates_jobs_apply.*','jobs.post_id'])
                                                        ->toArray();
        //echo $candidateJobApplyID;exit;                                                

        if(!empty($candidateJobApplyDetail)){
            $jobId = $candidateJobApplyDetail[0]['job_id'];
            $postId = $candidateJobApplyDetail[0]['post_id'];
            $candidate_id = $candidateJobApplyDetail[0]['candidate_id'];
            $is_experience = $candidateJobApplyDetail[0]['is_experience'];
            $is_publication = $candidateJobApplyDetail[0]['is_publication'];

            $retData = $this->get_candidate_selected_job_details($jobId);
            // get job validation minimum education
            $jobData = $retData['jobData'];
            /*echo "<pre>";
            print_r($jobData);
            exit;*/
            if(!empty($jobData)){
                //echo 11;exit;
                $job_validation_id = $jobData[0]['job_validation_id'];
                //echo $job_validation_id;exit;
                $jobValidations = JobValidation::leftJoin('job_min_education_trans','job_min_education_trans.job_validation_id','=','job_validation.id')
                                                ->where('job_validation.id', $job_validation_id)
                                                ->where('job_min_education_trans.status', 1)
                                                ->get(['job_validation.is_age_validate','job_validation.is_exp_tab','job_validation.is_publication_tab','job_validation.is_patent_tab','job_validation.is_research_tab','job_validation.is_proposal_tab','job_min_education_trans.education_id','job_min_education_trans.job_validation_id'])
                                                ->toArray();   
            }else{
                $jobValidations = JobValidation::leftJoin('job_min_education_trans','job_min_education_trans.job_validation_id','=','job_validation.id')
                                                ->where('job_validation.post_id', $postId)
                                                ->where('job_validation.status', 1)
                                                ->where('job_min_education_trans.status', 1)
                                                ->get(['job_validation.is_age_validate','job_validation.is_exp_tab','job_validation.is_publication_tab','job_validation.is_patent_tab','job_validation.is_research_tab','job_validation.is_proposal_tab','job_min_education_trans.education_id','job_min_education_trans.job_validation_id'])
                                                ->toArray();   
            }
            //print_r($jobValidations);exit;
            
            $minJobEduRequired = [];
            if(!empty($jobValidations)){
                $minJobEduRequired = array_column($jobValidations, 'education_id');
            }
            // get candidate existing education details
            $academicDetails = CandidatesAcademicsDetails::orderBy('id','asc')
                                                         ->where('candidate_id', $candidate_id)
                                                         ->where('job_id', $jobId)
                                                         ->where('status', 1)
                                                         ->get(['candidates_academics_details.*'])
                                                         ->toArray();

            // get experience details
            $candidateExperienceDetails = [];
            $total_experience = "";
            if($is_experience == 1){
                $candidateExperienceDetails = CandidatesExperienceDetails::orderBy('id','asc')
                                                                        ->where('candidate_id', $candidate_id)
                                                                        ->where('job_id', $jobId)
                                                                        ->where('status', 1)
                                                                        ->get(['candidates_experience_details.*'])
                                                                        ->toArray();
                $total_experience = $candidateJobApplyDetail[0]['total_experience'];
            } 

            
            // get experience details
            $candidatesPublicationsDetails = [];
            if($is_publication == 1){
                $candidatesPublicationsDetails = CandidatesPublicationsDetails::orderBy('id','asc')
                                                                        ->where('candidate_id', $candidate_id)
                                                                        ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                                        ->where('status', 1)
                                                                        ->get(['candidates_publications_details.*'])
                                                                        ->toArray();
            }

            // get refree details
            $existingRefreeDetails = CandidatesRefreeDetails::orderBy('id','asc')
                                                        ->where('candidate_id', $candidate_id)
                                                        ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                        ->where('status', 1)
                                                        ->get(['candidates_refree_details.*'])
                                                        ->toArray();

            // get candidate PHD Research details
            $candidatesPHDResearchDetails = CandidatesPHDResearchDetails::orderBy('id','asc')
                                                                        ->where('candidate_id', $candidate_id)
                                                                        ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                                        ->where('status', 1)
                                                                        ->get(['candidates_phd_research_details.*'])
                                                                        ->toArray();

            /*                                            
            echo "<pre>";
            print_r($candidateExperienceDetails);
            exit;
            */
            
            $jobData = $retData['jobData'];
            $fieldsArray = $retData['fieldsArray'];
            $domainAreas = $retData['domainAreas'];
            $codeNamesArr = $retData['codeNamesArr'];
            
            //echo "<pre>";
            //print_r($jobValidations);exit;
            //echo 11;
            //echo "<pre>";
            //print_r($jobValidations);
            //exit;
            return view('application.edit_candidate_applied_job_details', compact('jobData','fieldsArray','domainAreas','codeNamesArr','jobId','candidateJobApplyDetail','minJobEduRequired','jobValidations','captcha_code','candidateJobApplyEncID','academicDetails','candidateExperienceDetails','total_experience','candidatesPublicationsDetails','existingRefreeDetails','candidatesPHDResearchDetails','formTabId','formTabIdEnc'));
        }else{
            echo "Something went wrong.";
            exit;
        }
    }

    // update candidate applied job details
    public function update_candidate_applied_job_details(Request $request, $encId, $formTabIdEnc=""){

        $postData = $request->post();
        $candidateJobApplyID = Helper::decodeId($encId);
        $formTabId = "";
        if(isset($formTabIdEnc) && !empty($formTabIdEnc)){
            $formTabId = Helper::decodeId($formTabIdEnc);
        }
        //print_r($postData);exit;
        $security_code = $request->session()->get('registration_captcha');
        //$email_id = $postData['email_id'];
        $is_phd_job = 0;
        if(isset($postData['is_phd_job']) && !empty($postData['is_phd_job'])){
            $is_phd_job = 1;
        }
        if($formTabId == ""){
            $validator = $this->validate_candidate_details($request, $security_code);
        }else{
            $validator = $this->validate_security_code($request, $security_code);
        }
        try{
            
            if($validator->fails()) {
                //withInput keep the users info
                return redirect()->back()->withInput()->withErrors($validator->messages());
            } else {
                
                // transactions start
                DB::beginTransaction();
                $postNewArray = [];
                // get candidate_id from job details
                $candidateJobApplyDetail = CandidatesJobsApply::where('id',$candidateJobApplyID)
                                                        ->limit(1)
                                                        ->get(['candidate_id'])
                                                        ->toArray();
                $candidate_id = "";
                if(!empty($candidateJobApplyDetail)){
                    $candidate_id = $candidateJobApplyDetail[0]['candidate_id'];
                }

                if($formTabId == ""){
                    //********************************** */ candidate basic details start ***************************/
                    // get register candidate details array
                    $postNewArray = $this->register_candidate_personal_details_arr($postData);
                    if(!empty($postNewArray) && $candidate_id != ""){
                        // update registered candidate details
                        RegisterCandidate::where('id', $candidate_id)->update($postNewArray);
                        // set session of registered user
                        $request->session()->put('candidate_id', $candidate_id);
                        $jobApplyArr = [];
                        $jobId = $postData['job_id'];
                        // return array of job apply info
                        $jobApplyArr = $this->candidate_job_apply_info_arr($postData, $candidate_id);
                        if(!empty($jobApplyArr)){
                            // update is_basic_info_done to 1 - completed
                            $jobApplyArr['is_basic_info_done'] = 1;
                            // update candidate job apply details
                            CandidatesJobsApply::where('id', $candidateJobApplyID)
                                                ->where('status', 1)
                                                ->update($jobApplyArr);
                        }
                    }
                    // candidate basic details end
                }
                else if($formTabId == 2){
                    //******************************* */ academic, experience, refree, relationship details **********************/
                    /*echo "<pre>";
                    print_r($postData);
                    exit;*/
                    // update candidate academic details start
                    $retData = $this->update_candidate_academic_details($postData, $candidate_id, $candidateJobApplyID);
                    
                    if($retData['status'] == 'error'){
                        $errorMsg = $retData['msg'];
                        DB::rollback();
                        return redirect()->back()->withInput()->with('error_msg',$errorMsg);
                    }
                    // update candidate academic details end
                    
                    // update candidate experience details start
                    if(isset($postData['exp_check']) && $postData['exp_check'] == 1){
                        $retData = $this->update_candidate_experience_details($postData, $candidate_id, $candidateJobApplyID);
                        if($retData['status'] == 'error'){
                            $errorMsg = $retData['msg'];
                            DB::rollback();
                            return redirect()->back()->withInput()->with('error_msg',$errorMsg);
                        }
                    }else{
                        // mark all items as deleted
                        CandidatesExperienceDetails::where('candidate_id', $candidate_id)
                                                    ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                    ->where('status', 1)
                                                    ->update(['status' => 3]);
                    }
                    // update candidate experience details end

                    // update candidate refree details start
                    if(isset($postData['ref_name']) && !empty($postData['ref_name'])){
                        $retData = $this->update_candidate_refree_details($postData, $candidate_id, $candidateJobApplyID);
                        if($retData['status'] == 'error'){
                            $errorMsg = $retData['msg'];
                            DB::rollback();
                            return redirect()->back()->withInput()->with('error_msg',$errorMsg);
                        }
                    }else{
                        // mark all refree as deleted
                        CandidatesRefreeDetails::where('candidate_id', $candidate_id)
                                                    ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                    ->where('status', 1)
                                                    ->update(['status' => 3]);
                    }
                    // update candidate refree details end
                    // update is_qualification_exp_done to 1 - completed
                    $jobApplyArr['is_qualification_exp_done'] = 1;
                    if(isset($postData['exp_check']) && !empty($postData['exp_check'])){
                        $jobApplyArr['is_experience'] = $postData['exp_check'];
                        if(isset($postData['exp_grand_total']) && !empty($postData['exp_grand_total'])){
                            $jobApplyArr['total_experience'] = $postData['exp_grand_total'];
                        }
                    }
                    // update candidate job apply details
                    CandidatesJobsApply::where('id', $candidateJobApplyID)
                                        ->update($jobApplyArr);
                }
                else if($formTabId == 3){
                    //*********************************************  PHD Details ***************************/
                    //update candidate publications details start
                    /*
                    if(isset($postData['pub_check']) && $postData['pub_check'] == 1){
                        $retData = $this->update_candidate_publications_details($postData, $candidate_id, $candidateJobApplyID);
                        if($retData['status'] == 'error'){
                            $errorMsg = $retData['msg'];
                            DB::rollback();
                            return redirect()->back()->withInput()->with('error_msg',$errorMsg);
                        }
                    }else{
                        // mark all publications items as deleted
                        CandidatesPublicationsDetails::where('candidate_id', $candidate_id)
                                                    ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                    ->where('status', 1)
                                                    ->update(['status' => 3]);
                    }
                    */
                    // update candidate publications details end
                    
                    
                    // update is_phd_details_done to 1 - completed
                    $jobApplyArr['is_phd_details_done'] = 1;
                    if(isset($postData['pub_check'])){
                        $jobApplyArr['is_publication'] = $postData['pub_check'];
                    }
                    //print_r($jobApplyArr);exit;
                    // update candidate job apply details
                    CandidatesJobsApply::where('id', $candidateJobApplyID)
                                        ->update($jobApplyArr);
                    // update candidate PHD Research details end
                }
                // update candidate PHD Research details start
                $retData = $this->update_candidate_phd_research_details($postData, $candidate_id, $candidateJobApplyID);
                if($retData['status'] == 'error'){
                    $errorMsg = $retData['msg'];
                    DB::rollback();
                    return redirect()->back()->withInput()->with('error_msg',$errorMsg);
                }

                // transactions start
                DB::commit();
                $nextTabId = "";
                $redirectUrl = route('edit_candidate_applied_job_details',$encId);
                if($formTabId == ""){
                    $nextTabId = 2;
                }
                else if($formTabId == 2 && $is_phd_job == 1){
                    $nextTabId = 3;
                }
                else if($formTabId == 3 || ($formTabId == 2 && $is_phd_job == 0)){
                    $nextTabId = 4;
                    $redirectUrl = route('upload_candidate_documents', $encId);
                }

                if(!empty($nextTabId)){
                    $formTabIdEnc = Helper::encodeId($nextTabId);   
                    $redirectUrl .= "/".$formTabIdEnc;
                }
                return redirect($redirectUrl)->with('success','Details updated successfully.');
            }
        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            DB::rollback();
            // log error in file
            Helper::logErrorInFile($e);
            return redirect()->back()->withInput()->with('error_msg',$errorMsg);
        }

    }

    // common function to validate candidate details
    public function validate_candidate_details($request, $security_code="", $emailValidate="", $email_otp="", $email_id=""){

            $validationArray = [
                'rn_no_id' => 'required',
                'job_id' => 'required',
                'email_id' => 'required|email'.$emailValidate,
                'mobile_no' => 'required',
                'full_name' => 'required',
                'father_name' => 'required',
                'mother_name' => 'required',
                'dob' => 'required',
                'gender' => 'required',
                'pwd_check' => 'required',
                'cast_category' => 'required',
                'nationality_type' => 'required',
                'correspondes_address' => 'required',
                'present_state' => 'required',
                'present_city' => 'required',
                'present_pincode' => 'required'
            ];

            $validationMsgArr = [
                'check_unique_registration' => 'Email & Phone no. already exists.'
            ];
            if(!empty($security_code)){
                $securityCodeArr = [
                    'security_code' => 'required|check_captcha:'.$security_code
                ];  
                $validationArray = array_merge($validationArray,$securityCodeArr);

                $newMsgArr = [
                    'check_captcha' => 'Invalid captcha code.'
                ];   
                $validationMsgArr = array_merge($validationMsgArr,$newMsgArr);
            }
            // email_otp
            if(!empty($email_otp)){
                $newOTPArr = [
                    'email_otp'=>'check_email_otp:'.$email_otp
                ];   
                $validationArray = array_merge($validationArray,$newOTPArr);

                $otpMsgArr = [
                    'check_email_otp' => 'Invalid OTP code.'
                ];   
                $validationMsgArr = array_merge($validationMsgArr,$otpMsgArr);
            }
            //echo "<pre>";
            //print_r($validationArray);exit;
            $validator = Validator::make($request->all(), $validationArray, $validationMsgArr);

            return $validator;
    }

    public function validate_security_code($request, $security_code=""){

        $validationArray = [
            'rn_no_id' => 'required',
            'job_id' => 'required'
        ];

        
        if(!empty($security_code)){
            $securityCodeArr = [
                'security_code' => 'required|check_captcha:'.$security_code
            ];  
            $validationArray = array_merge($validationArray,$securityCodeArr);

            $newMsgArr = [
                'check_captcha' => 'Invalid captcha code.'
            ];   
            $validationMsgArr = $newMsgArr;
        }
        
        //echo "<pre>";
        //print_r($validationArray);exit;
        $validator = Validator::make($request->all(), $validationArray, $validationMsgArr);

        return $validator;
}

    // array of candidate personal details
    public function register_candidate_personal_details_arr($postData){

            $postNewArray = [];
            $postNewArray['email_id'] = $postData['email_id'];
            $postNewArray['mobile_no'] = $postData['mobile_no'];
            if(isset($postData['salutation']) && !empty($postData['salutation'])){
                $postNewArray['salutation'] = $postData['salutation'];
            }
            $postNewArray['full_name'] = $postData['full_name'];
            if(isset($postData['father_name']) && !empty($postData['father_name'])){
                $postNewArray['father_name'] = $postData['father_name'];
            }
            if(isset($postData['mother_name']) && !empty($postData['father_name'])){
                $postNewArray['mother_name'] = $postData['mother_name'];
            }
            if(isset($postData['dob']) && !empty($postData['dob'])){
                $dob = $postData['dob'];
                $newDOB = Helper::convertDateDMYtoYMD($dob);
                $postNewArray['dob'] = $newDOB;
            }
            if(isset($postData['gender']) && !empty($postData['gender'])){
                $postNewArray['gender'] = $postData['gender'];
            }
            if(isset($postData['gender']) && !empty($postData['gender'])){
                $postNewArray['gender'] = $postData['gender'];
            }
            
            if(isset($postData['nationality_type']) && !empty($postData['nationality_type'])){
                $nationality_type = $postData['nationality_type'];
                $postNewArray['nationality_type'] = $nationality_type;
                $postNewArray['nationality'] = null;
                if($nationality_type == 2){
                    if(isset($postData['nationality']) && !empty($postData['nationality'])){
                        $postNewArray['nationality'] = $postData['nationality'];
                    }
                }
            }
            
            if(isset($postData['correspondes_address']) && !empty($postData['correspondes_address'])){
                $postNewArray['correspondence_address'] = $postData['correspondes_address'];
            }
            if(isset($postData['present_state']) && !empty($postData['present_state'])){
                $postNewArray['cors_state_id'] = $postData['present_state'];
            }
            if(isset($postData['present_city']) && !empty($postData['present_city'])){
                $postNewArray['cors_city'] = $postData['present_city'];
            }
            if(isset($postData['present_pincode']) && !empty($postData['present_pincode'])){
                $postNewArray['cors_pincode'] = $postData['present_pincode'];
            }
            if(isset($postData['permanent_address']) && !empty($postData['permanent_address'])){
                $postNewArray['permanent_address'] = $postData['permanent_address'];
            }
            if(isset($postData['permanent_state']) && !empty($postData['permanent_state'])){
                $postNewArray['perm_state_id'] = $postData['permanent_state'];
            }
            if(isset($postData['permanent_city']) && !empty($postData['permanent_city'])){
                $postNewArray['perm_city'] = $postData['permanent_city'];
            }
            if(isset($postData['permanent_pincode']) && !empty($postData['permanent_pincode'])){
                $postNewArray['perm_pincode'] = $postData['permanent_pincode'];
            }

            return $postNewArray;

    }
    public function candidate_job_apply_info_arr($postData, $candidate_id){

            $jobApplyArr = [];
            $jobApplyArr['candidate_id'] = $candidate_id;
            $jobApplyArr['rn_no_id'] = $postData['rn_no_id'];
            $jobApplyArr['job_id'] = $postData['job_id'];
            if(isset($postData['domain_area']) && !empty($postData['domain_area'])){
                $jobApplyArr['domain_id'] = $postData['domain_area'];
            }
            if(isset($postData['method_of_appointment']) && !empty($postData['method_of_appointment'])){
                $jobApplyArr['appointment_method_id'] = $postData['method_of_appointment'];
            }
            if(isset($postData['esm_check'])){
                $esm_check = $postData['esm_check'];
                $jobApplyArr['is_ex_serviceman'] = $esm_check;
                $jobApplyArr['is_esm_reservation_avail'] = 0;
                $jobApplyArr['date_of_release'] = 0;
                if($esm_check == 1){
                    $jobApplyArr['is_esm_reservation_avail'] = $postData['is_esm_reservation_avail'];
                    $jobApplyArr['date_of_release'] = $postData['date_of_release'];
                }
            }
            if(isset($postData['pwd_check'])){
                $jobApplyArr['is_pwd'] = $postData['pwd_check'];
            }
            if(isset($postData['is_govt_servent'])){
                $is_govt_servent = $postData['is_govt_servent'];
                $jobApplyArr['is_govt_servent'] = $postData['is_govt_servent'];
                if(isset($postData['type_of_employment'])){
                    $type_of_employment = null;
                    $type_of_employer = null;
                    if($is_govt_servent == 1){
                        $type_of_employment = $postData['type_of_employment'];
                        if($type_of_employment == 1){
                            $type_of_employer = $postData['type_of_employer'];
                        }
                    }
                    $jobApplyArr['type_of_employment'] = $type_of_employment;
                    $jobApplyArr['type_of_employer'] = $type_of_employer;
                }
            }
            
            if(isset($postData['cast_category']) && !empty($postData['cast_category'])){
                $jobApplyArr['category_id'] = $postData['cast_category'];
            }
            if(isset($postData['trainee_category']) && !empty($postData['trainee_category'])){
                $jobApplyArr['trainee_category_id'] = $postData['trainee_category'];
            }
            if(isset($postData['institute_name']) && !empty($postData['institute_name'])){
                $jobApplyArr['institute_name'] = $postData['institute_name'];
            }
            /*
            if(isset($postData['exp_check']) && !empty($postData['exp_check'])){
                $jobApplyArr['is_experience'] = $postData['exp_check'];
                if(isset($postData['exp_grand_total']) && !empty($postData['exp_grand_total'])){
                    $jobApplyArr['total_experience'] = $postData['exp_grand_total'];
                }
            }
            */
            
            if(isset($postData['rel_person_name']) && !empty($postData['rel_person_name'])){
                $jobApplyArr['relative_name'] = $postData['rel_person_name'];
            }
            if(isset($postData['rel_person_designation']) && !empty($postData['rel_person_designation'])){
                $jobApplyArr['relative_designation'] = $postData['rel_person_designation'];
            }
            if(isset($postData['rel_person_relationship']) && !empty($postData['rel_person_relationship'])){
                $jobApplyArr['relative_relationship'] = $postData['rel_person_relationship'];
            }
            if(isset($postData['marital_status']) && !empty($postData['marital_status'])){
                $jobApplyArr['marital_status'] = $postData['marital_status'];
            }

            // for age calculation
            
            if(isset($postData['dob']) && !empty($postData['dob']) && isset($postData['as_on_date']) && !empty($postData['as_on_date'])){
                $dob = $postData['dob'];
                $as_on_date = $postData['as_on_date'];
                $jobApplyArr['age_calculated'] = $this->calculate_age_by_parm($dob, $as_on_date);
            }

            return $jobApplyArr;
    }

    // add or update candidate academic details
    public function update_candidate_academic_details($postData, $candidate_id, $candidateJobApplyID){

        try{
            $jobApplyArr = [];
            $rn_no_id = $postData['rn_no_id'];
            $job_id = $postData['job_id'];
            DB::beginTransaction();
            if(isset($postData['exam_pass']) && !empty($postData['exam_pass'])){
                $exam_pass = $postData['exam_pass'];
                $mn_pass = $postData['mn_pass'];
                $yr_pass = $postData['yr_pass'];
                $duration_of_course = $postData['duration_of_course'];
                
                $subjects = $postData['subjects'];
                $board = $postData['board'];
                $percent = $postData['percent'];
                $cgpa = $postData['cgpa'];
                $division = $postData['division'];
                $phd_result = [];
                $thesis_title = [];
                if(isset($postData['phd_result']) && !empty($postData['phd_result'])){
                    $phd_result = $postData['phd_result'];
                    $thesis_title = $postData['thesis_title'];
                }
                // get existing academic details
                $academicDetails = CandidatesAcademicsDetails::where('candidate_id', $candidate_id)
                                                             ->where('job_id', $job_id)
                                                             ->where('status', 1)
                                                             ->get(['education_id'])
                                                             ->toArray();
                $newIds = [];
                $commonIds = [];                                             
                if(!empty($academicDetails)){
                    $academicIds = array_column($academicDetails, 'education_id');                                            
                    // new IDs to insert
                    $newIds = array_diff($exam_pass, $academicIds);   
                    //echo count($newTabItems);exit;
                    // old IDs to delete    
                    $oldIds = array_diff($academicIds, $exam_pass);  
                    // Ids to Update
                    $commonIds = array_intersect($exam_pass, $academicIds);  

                    // delete old Ids start
                    if(!empty($oldIds)){
                        CandidatesAcademicsDetails::where('candidate_id', $candidate_id)
                                                  ->where('job_id', $job_id)
                                                  ->where('status', 1)
                                                  ->whereIn('education_id', $oldIds)
                                                  ->update(['status' => 3]);
                    }
                    // delete old Ids end

                }else{
                    $newIds = $exam_pass;
                }                                             
                // create batch of new IDs to insert
                // for fields ids
                $batchInsertArr = [];
                $batchUpdateArr = [];
                foreach($exam_pass as $key=>$education_id){
                    $academicArr = [];
                    $academicArr['candidate_id'] = $candidate_id;
                    $academicArr['job_id'] = $job_id;
                    $academicArr['education_id'] = $education_id;
                    $academicArr['candidate_job_apply_id'] = $candidateJobApplyID;
                    // for month value
                    if(isset($mn_pass[$key]) && !empty($mn_pass[$key])){
                        $academicArr['month'] = $mn_pass[$key];
                    }
                    // for year value
                    if(isset($yr_pass[$key]) && !empty($yr_pass[$key])){
                        $academicArr['year'] = $yr_pass[$key];
                    }
                    // for duration_of_course
                    // for year value
                    if(isset($duration_of_course[$key]) && !empty($duration_of_course[$key])){
                        $academicArr['duration_of_course'] = $duration_of_course[$key];
                    }
                    // for degree_or_subject value
                    if(isset($subjects[$key]) && !empty($subjects[$key])){
                        $academicArr['degree_or_subject'] = $subjects[$key];
                    }
                    // for board_or_university value
                    if(isset($board[$key]) && !empty($board[$key])){
                        $academicArr['board_or_university'] = $board[$key];
                    }
                    // for percentage value
                    $academicArr['percentage'] = null;
                    if(isset($percent[$key]) && !empty($percent[$key])){
                        $academicArr['percentage'] = $percent[$key];
                    }
                    // for cgpa value
                    $academicArr['cgpa'] = null;
                    if(isset($cgpa[$key]) && !empty($cgpa[$key])){
                        $academicArr['cgpa'] = $cgpa[$key];
                    }
                    // for division value
                    $academicArr['division'] = null;
                    if(isset($division[$key]) && !empty($division[$key])){
                        $academicArr['division'] = $division[$key];
                    }
                    // for phd_result value
                    $academicArr['phd_result'] = null;
                    if(isset($phd_result[$key]) && !empty($phd_result[$key])){
                        $academicArr['phd_result'] = $phd_result[$key];
                    }
                    $academicArr['thesis_title'] = null;
                    if(isset($thesis_title[$key]) && !empty($thesis_title[$key])){
                        $academicArr['thesis_title'] = $thesis_title[$key];
                    }
                    

                    // push in batch insert array
                    if(!empty($newIds) && in_array($education_id, $newIds)){
                        array_push($batchInsertArr, $academicArr);
                    }
                    // push in batch update array
                    if(!empty($commonIds) && in_array($education_id, $commonIds)){
                        CandidatesAcademicsDetails::where('candidate_id', $candidate_id)
                                                  ->where('job_id', $job_id)
                                                  ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                  ->where('status', 1)
                                                  ->where('education_id', $education_id)
                                                  ->update($academicArr);
                    }
                }
                // batch insert
                if(!empty($batchInsertArr)){
                    CandidatesAcademicsDetails::insert($batchInsertArr);
                }
                

            }
            DB::commit();

            $retData['status'] = 'success';
            $retData['msg'] = 'Data inserted successfully';
            return $retData;
        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            DB::rollback();
            // log error in file
            Helper::logErrorInFile($e);
            $retData['status'] = 'error';
            $retData['msg'] = $errorMsg;
            return $retData;
        }

    }

    // add or update candidate experience details
    public function update_candidate_experience_details($postData, $candidate_id, $candidateJobApplyID){

        try{
            $jobApplyArr = [];
            $rn_no_id = $postData['rn_no_id'];
            $job_id = $postData['job_id'];
            /*echo "<pre>";
            print_r($postData);
            exit;*/
            DB::beginTransaction();
            if(isset($postData['exp_from']) && !empty($postData['exp_from'])){
                $exp_from = $postData['exp_from'];
                $exp_to = $postData['exp_to'];
                $exp_total = $postData['exp_total'];
                $exp_prev_desig = $postData['exp_prev_desig'];
                $exp_org_name = $postData['exp_org_name'];
                $exp_pay_level = $postData['exp_gp'];
                $exp_gross = $postData['exp_gross'];
                $nature_of_duties = $postData['nature_of_duties'];
                // get existing experience details
                $experienceDetails = CandidatesExperienceDetails::where('candidate_id', $candidate_id)
                                                             ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                             ->where('status', 1)
                                                             ->get(['organization_name'])
                                                             ->toArray();
                                                             
                $newExp = [];
                $commonExp = [];                                             
                if(!empty($experienceDetails)){
                    $existingOrganizationNames = array_column($experienceDetails, 'organization_name');  
                    // new organization experience to insert
                    $newExp = array_diff($exp_org_name, $existingOrganizationNames);   
                    //echo count($newTabItems);exit;
                    // old organization experience to delete    
                    $oldExp = array_diff($existingOrganizationNames, $exp_org_name);  
                    // organization experience to Update
                    $commonExp = array_intersect($exp_org_name, $existingOrganizationNames);  

                    // delete old experience start
                    if(!empty($oldIds)){
                        CandidatesExperienceDetails::where('candidate_id', $candidate_id)
                                                  ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                  ->where('status', 1)
                                                  ->whereIn('organization_name', $oldExp)
                                                  ->update(['status' => 3]);
                    }
                    // delete old experience end

                }else{
                    $newExp = $exp_org_name;
                }      
                                                    
                // create batch of new organization experience to insert
                // for fields organization experience
                $batchInsertArr = [];
                $batchUpdateArr = [];
                foreach($exp_org_name as $key=>$organization){
                    $experienceArr = [];
                    $experienceArr['candidate_id'] = $candidate_id;
                    $experienceArr['job_id'] = $job_id;
                    $experienceArr['organization_name'] = $organization;
                    $experienceArr['candidate_job_apply_id'] = $candidateJobApplyID;
                    
                    // for from_date value
                    if(isset($exp_from[$key]) && !empty($exp_from[$key])){
                        $experienceArr['from_date'] = $exp_from[$key];
                    }
                    
                    // for to_date value
                    if(isset($exp_to[$key]) && !empty($exp_to[$key])){
                        $experienceArr['to_date'] = $exp_to[$key];
                    }
                    
                    // for total_experience value
                    if(isset($exp_total[$key]) && !empty($exp_total[$key])){
                        $experienceArr['total_experience'] = $exp_total[$key];
                    }
                    
                    // for cgpa value
                    if(isset($exp_prev_desig[$key]) && !empty($exp_prev_desig[$key])){
                        $experienceArr['designation'] = $exp_prev_desig[$key];
                    }
                    
                    // for pay_level value
                    if(isset($exp_pay_level[$key]) && !empty($exp_pay_level[$key])){
                        $experienceArr['pay_level'] = $exp_pay_level[$key];
                    }
                    
                    // for gross pay value
                    if(isset($exp_gross[$key]) && !empty($exp_gross[$key])){
                        $experienceArr['gross_pay'] = $exp_gross[$key];
                    }

                    // nature_of_duties
                    if(isset($nature_of_duties[$key]) && !empty($nature_of_duties[$key])){
                        $experienceArr['nature_of_duties'] = $nature_of_duties[$key];
                    }
                    
                    // push in batch insert array
                    if(!empty($newExp) && in_array($organization, $newExp)){
                        array_push($batchInsertArr, $experienceArr);
                    }
                    
                    // push in batch update array
                    if(!empty($commonExp) && in_array($organization, $commonExp)){
                        
                        CandidatesExperienceDetails::where('candidate_id', $candidate_id)
                                                  ->where('job_id', $job_id)
                                                  ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                  ->where('status', 1)
                                                  ->where('organization_name', $organization)
                                                  ->update($experienceArr);
                    }
                }
                // batch insert
                
                if(!empty($batchInsertArr)){
                    CandidatesExperienceDetails::insert($batchInsertArr);
                }
                
            }
            DB::commit();

            $retData['status'] = 'success';
            $retData['msg'] = 'Data inserted successfully';
            return $retData;

        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            DB::rollback();
            // log error in file
            Helper::logErrorInFile($e);
            $retData['status'] = 'error';
            $retData['msg'] = $errorMsg;
            return $retData;
        }

    }

    // add or update candidate publications details
    public function update_candidate_publications_details($postData, $candidate_id, $candidateJobApplyID){
        
        try{
            $jobApplyArr = [];
            $rn_no_id = $postData['rn_no_id'];
            $job_id = $postData['job_id'];
            DB::beginTransaction();
            
            if(isset($postData['pub_no']) && !empty($postData['pub_no'])){
                $pub_nos = $postData['pub_no'];
                $pub_authors = $postData['pub_author'];
                $pub_articles = $postData['pub_article'];
                $pub_journals = $postData['pub_journal'];
                $pub_vols = $postData['pub_vol'];
                $pub_dois = $postData['pub_doi'];
                $pub_mids = $postData['pub_mid'];
                // get existing publications details
                $publicationsDetails = CandidatesPublicationsDetails::where('candidate_id', $candidate_id)
                                                             ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                             ->where('status', 1)
                                                             ->get(['article_title'])
                                                             ->toArray();
                                                             
                $newPublications = [];
                $commonPublications = [];                                             
                if(!empty($publicationsDetails)){
                    $existingPublications = array_column($publicationsDetails, 'article_title');  
                    // new organization publications to insert
                    $newPublications = array_diff($pub_articles, $existingPublications);   
                    // old organization publications to delete    
                    $oldPublications = array_diff($existingPublications, $pub_articles);  
                    // organization publications to Update
                    $commonPublications = array_intersect($pub_articles, $existingPublications);  

                    // delete old publications start
                    if(!empty($oldPublications)){
                        CandidatesPublicationsDetails::where('candidate_id', $candidate_id)
                                                  ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                  ->where('status', 1)
                                                  ->whereIn('article_title', $oldPublications)
                                                  ->update(['status' => 3]);
                    }
                    // delete old experience end

                }else{
                    $newPublications = $pub_articles;
                }      
                                                    
                // create batch of new organization experience to insert
                // for fields organization experience
                $batchInsertArr = [];
                $batchUpdateArr = [];
                foreach($pub_articles as $key=>$article){
                    $publicationArr = [];
                    $publicationArr['candidate_id'] = $candidate_id;
                    $publicationArr['job_id'] = $job_id;
                    $publicationArr['article_title'] = $article;
                    $publicationArr['candidate_job_apply_id'] = $candidateJobApplyID;
                    
                    // for publication_number value
                    if(isset($pub_nos[$key]) && !empty($pub_nos[$key])){
                        $publicationArr['publication_number'] = $pub_nos[$key];
                    }
                    
                    // for pub_authors value
                    if(isset($pub_authors[$key]) && !empty($pub_authors[$key])){
                        $publicationArr['authors'] = $pub_authors[$key];
                    }
                    
                    // for journal_name value
                    if(isset($pub_journals[$key]) && !empty($pub_journals[$key])){
                        $publicationArr['journal_name'] = $pub_journals[$key];
                    }
                    
                    // for year_volume value
                    if(isset($pub_vols[$key]) && !empty($pub_vols[$key])){
                        $publicationArr['year_volume'] = $pub_vols[$key];
                    }
                    
                    // for doi value
                    if(isset($pub_dois[$key]) && !empty($pub_dois[$key])){
                        $publicationArr['doi'] = $pub_dois[$key];
                    }
                    
                    // for pubmed_pmid value
                    if(isset($pub_mids[$key]) && !empty($pub_mids[$key])){
                        $publicationArr['pubmed_pmid'] = $pub_mids[$key];
                    }
                    
                    // push in batch insert array
                    if(!empty($newPublications) && in_array($article, $newPublications)){
                        array_push($batchInsertArr, $publicationArr);
                    }
                    
                    // push in batch update array
                    if(!empty($commonPublications) && in_array($article, $commonPublications)){
                        
                        CandidatesPublicationsDetails::where('candidate_id', $candidate_id)
                                                  ->where('job_id', $job_id)
                                                  ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                  ->where('status', 1)
                                                  ->where('article_title', $article)
                                                  ->update($publicationArr);
                    }
                }
                // batch insert
                if(!empty($batchInsertArr)){
                    CandidatesPublicationsDetails::insert($batchInsertArr);
                }
                
            }
            DB::commit();

            $retData['status'] = 'success';
            $retData['msg'] = 'Data inserted successfully';
            return $retData;

        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            DB::rollback();
            // log error in file
            Helper::logErrorInFile($e);
            $retData['status'] = 'error';
            $retData['msg'] = $errorMsg;
            return $retData;
        }

    }

    // add or update candidate refree details
    public function update_candidate_refree_details($postData, $candidate_id, $candidateJobApplyID){

        try{
            $jobApplyArr = [];
            $rn_no_id = $postData['rn_no_id'];
            $job_id = $postData['job_id'];
            DB::beginTransaction();
            
            if(isset($postData['ref_name']) && !empty($postData['ref_name'])){
                $ref_name = $postData['ref_name'];
                $ref_desig = $postData['ref_desig'];
                $ref_org = $postData['ref_org'];
                $ref_email = $postData['ref_email'];
                $ref_phone = $postData['ref_phone'];
                $ref_mob = $postData['ref_mob'];
                
                // get existing refree details
                $refreeDetails = CandidatesRefreeDetails::where('candidate_id', $candidate_id)
                                                             ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                             ->where('status', 1)
                                                             ->get(['refree_name'])
                                                             ->toArray();
                                                             
                $newRefree = [];
                $commonRefree = [];                                             
                if(!empty($refreeDetails)){
                    
                    $existingRefree = array_column($refreeDetails, 'refree_name');  
                    // new refree to insert
                    $newRefree = array_diff($ref_name, $existingRefree);   
                    // old refree to delete    
                    $oldRefree = array_diff($existingRefree, $ref_name);  
                    // refree to Update
                    $commonRefree = array_intersect($ref_name, $existingRefree);  

                    // delete old refree start
                    if(!empty($oldRefree)){
                        CandidatesRefreeDetails::where('candidate_id', $candidate_id)
                                                  ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                  ->where('status', 1)
                                                  ->whereIn('refree_name', $oldRefree)
                                                  ->update(['status' => 3]);
                    }
                    // delete old refree end

                }else{
                    $newRefree = $ref_name;
                }      
                                                    
                // create batch of new organization experience to insert
                // for fields organization experience
                $batchInsertArr = [];
                $batchUpdateArr = [];
                foreach($ref_name as $key=>$refree_name){
                    $refreeArr = [];
                    $refreeArr['candidate_id'] = $candidate_id;
                    $refreeArr['job_id'] = $job_id;
                    $refreeArr['refree_name'] = $refree_name;
                    $refreeArr['candidate_job_apply_id'] = $candidateJobApplyID;
                    
                    // for designation value
                    if(isset($ref_desig[$key]) && !empty($ref_desig[$key])){
                        $refreeArr['designation'] = $ref_desig[$key];
                    }
                    
                    // for organisation value
                    if(isset($ref_org[$key]) && !empty($ref_org[$key])){
                        $refreeArr['organisation'] = $ref_org[$key];
                    }
                    
                    // for ref_email value
                    if(isset($ref_email[$key]) && !empty($ref_email[$key])){
                        $refreeArr['email_id'] = $ref_email[$key];
                    }
                    
                    // for phone_no value
                    if(isset($ref_phone[$key]) && !empty($ref_phone[$key])){
                        $refreeArr['phone_no'] = $ref_phone[$key];
                    }
                    
                    // for mobile_no value
                    if(isset($ref_mob[$key]) && !empty($ref_mob[$key])){
                        $refreeArr['mobile_no'] = $ref_mob[$key];
                    }
                    
                    // push in batch insert array
                    if(!empty($newRefree) && in_array($refree_name, $newRefree)){
                        array_push($batchInsertArr, $refreeArr);
                    }
                    // push in batch update array
                    if(!empty($commonRefree) && in_array($refree_name, $commonRefree)){
                        
                        CandidatesRefreeDetails::where('candidate_id', $candidate_id)
                                                  ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                  ->where('status', 1)
                                                  ->where('refree_name', $refree_name)
                                                  ->update($refreeArr);
                    }
                }
                // batch insert
                if(!empty($batchInsertArr)){
                    CandidatesRefreeDetails::insert($batchInsertArr);
                }
                
            }
            DB::commit();

            $retData['status'] = 'success';
            $retData['msg'] = 'Data inserted successfully';
            return $retData;

        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            DB::rollback();
            // log error in file
            Helper::logErrorInFile($e);
            $retData['status'] = 'error';
            $retData['msg'] = $errorMsg;
            return $retData;
        }

    }

    // update candidate PHD Research details
    public function update_candidate_phd_research_details($postData, $candidate_id, $candidateJobApplyID){

        $insertFlag = 1;// 1 for Insert 2 for update
        $dataArr = [];
        try{
            DB::beginTransaction();
            // get candidate PHD Research details
            $candidatesPHDResearchDetails = CandidatesPHDResearchDetails::where('candidate_id', $candidate_id)
                                                                        ->where('candidate_job_apply_id', $candidateJobApplyID)
                                                                        ->where('status', 1)
                                                                        ->get(['candidates_phd_research_details.*'])
                                                                        ->toArray();
            /*echo "<pre>";
            print_r($candidatesPHDResearchDetails);       
            exit;*/                                      
            if(isset($postData['patent_check']) && $postData['patent_check'] == 1){
                $dataArr['is_have_patents'] = 1;
                $dataArr['patent_information'] = $postData['patent_information'];
                $dataArr['no_patents_filed_national'] = $postData['no_patents_filed_national'];
                $dataArr['no_patents_granted_national'] = $postData['no_patents_granted_national'];
                $dataArr['no_patents_filed_international'] = $postData['no_patents_filed_international'];
                $dataArr['no_patents_granted_international'] = $postData['no_patents_granted_international'];
                
            }else{
                $dataArr['is_have_patents'] = 0;
            }
             
            if(isset($postData['rs_check']) && $postData['rs_check'] == 1){
                $dataArr['is_submitted_research_statement'] = 1;
                $dataArr['research_statement'] = $postData['research_statement'];
            }else{
                $dataArr['is_submitted_research_statement'] = 0;
            }
            
             
            if(isset($postData['fund_agency']) && !empty($postData['fund_agency'])){
                
                $dataArr['funding_agency'] = $postData['fund_agency'];
                $dataArr['rank'] = $postData['rank'];
                $dataArr['admission_test'] = $postData['admission_test'];
                $dataArr['fellowship_valid_up_to'] = $postData['val_up_to'];
                
            }
            
            if(isset($postData['activate_fellow']) && $postData['activate_fellow'] == 1){
                
                $dataArr['is_fellowship_activated'] = 1;
                $dataArr['active_institute_name'] = $postData['active_institute_name'];
                $dataArr['activation_date'] = $postData['active_date'];
                
            }
            
            if(isset($postData['exam_qualified']) && $postData['exam_qualified'] == 1){
                
                $dataArr['is_exam_qualified'] = 1;
                $dataArr['exam_name'] = $postData['exam_qualified_name'];
                $dataArr['exam_score'] = $postData['exam_qualified_score'];
                $dataArr['exam_qualified_val_up_to'] = $postData['exam_qualified_val_up_to'];
                
            }
            // publications details
            if(isset($postData['no_of_pub']) && !empty($postData['no_of_pub'])){
                
                $dataArr['no_of_pub'] = $postData['no_of_pub'];
                $dataArr['no_of_first_author_pub'] = $postData['no_of_first_author_pub'];
                $dataArr['no_of_cors_author_pub'] = $postData['no_of_cors_author_pub'];
                $dataArr['no_of_pub_impact_fact'] = $postData['no_of_pub_impact_fact'];
                $dataArr['no_of_citations'] = $postData['no_of_citations'];
                
            }
            /*
                echo "<pre>";
                print_r($dataArr);
                exit;
                */
            if(!empty($dataArr)){    
                if(!empty($candidatesPHDResearchDetails)){
                    /*
                    CandidatesPHDResearchDetails::where('candidate_id', $candidate_id)
                                            ->where('candidate_job_apply_id', $candidateJobApplyID)
                                            ->where('status', 1)
                                            ->update(['status' => 3]);
                    */                        
                    CandidatesPHDResearchDetails::where('candidate_id', $candidate_id)
                                            ->where('candidate_job_apply_id', $candidateJobApplyID)
                                            ->where('status', 1)
                                            ->update($dataArr);                        
                }
                else{
                    $dataArr['candidate_id'] = $candidate_id;
                    $dataArr['job_id'] = $postData['job_id'];
                    $dataArr['candidate_job_apply_id'] = $candidateJobApplyID;
                    
                    CandidatesPHDResearchDetails::create($dataArr);
                }
            }

            DB::commit();

            $retData['status'] = 'success';
            $retData['msg'] = 'Data inserted successfully';
            return $retData;
        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            DB::rollback();
            // log error in file
            Helper::logErrorInFile($e);
            $retData['status'] = 'error';
            $retData['msg'] = $errorMsg;
            return $retData;
        }
    }

    // upload candidate documents 
    public function upload_candidate_documents(Request $request, $candidateJobApplyEncID, $formTabIdEnc=""){

        $captcha_code = Helper::get_captcha_code();
        // set session of captcha for registration form
        $request->session()->put('registration_captcha', $captcha_code);
        $formTabId = "";
        if(isset($formTabIdEnc) && !empty($formTabIdEnc)){
            $formTabId = Helper::decodeId($formTabIdEnc);
        }
        $candidateJobApplyID = Helper::decodeId($candidateJobApplyEncID);
        $candidateJobApplyDetail = CandidatesJobsApply::join('register_candidates','register_candidates.id','=','candidates_jobs_apply.candidate_id')
                                                        ->join('jobs','jobs.id','=','candidates_jobs_apply.job_id')
                                                        ->where('candidates_jobs_apply.id',$candidateJobApplyID)
                                                        ->where('jobs.status','!=',3)
                                                        ->get(['register_candidates.*','candidates_jobs_apply.*','jobs.post_id'])
                                                        ->toArray();
        $retData = [];
        $jobValidations = [];
        if(!empty($candidateJobApplyDetail)){          
            $jobId = $candidateJobApplyDetail[0]['job_id'];  
            $postId = $candidateJobApplyDetail[0]['post_id'];                                     
            $retData = $this->get_candidate_selected_job_details($jobId);
            // get job validation minimum education
            $jobData = $retData['jobData'];
            if(!empty($jobData)){
                $job_validation_id = $jobData[0]['job_validation_id'];
                //echo $job_validation_id;exit;
                $jobValidations = JobValidation::leftJoin('job_min_education_trans','job_min_education_trans.job_validation_id','=','job_validation.id')
                                                ->where('job_validation.id', $job_validation_id)
                                                ->where('job_min_education_trans.status', 1)
                                                ->get(['job_validation.is_age_validate','job_validation.is_exp_tab','job_validation.is_publication_tab','job_validation.is_patent_tab','job_validation.is_research_tab','job_validation.is_proposal_tab','job_min_education_trans.education_id','job_min_education_trans.job_validation_id'])
                                                ->toArray();   
            }else{
                $jobValidations = JobValidation::leftJoin('job_min_education_trans','job_min_education_trans.job_validation_id','=','job_validation.id')
                                                ->where('job_validation.post_id', $postId)
                                                ->where('job_validation.status', 1)
                                                ->where('job_min_education_trans.status', 1)
                                                ->get(['job_validation.is_age_validate','job_validation.is_exp_tab','job_validation.is_publication_tab','job_validation.is_patent_tab','job_validation.is_research_tab','job_validation.is_proposal_tab','job_min_education_trans.education_id','job_min_education_trans.job_validation_id'])
                                                ->toArray();   
            }
        }
        
        $candidateAcademicsDetails = CandidatesAcademicsDetails::where('candidate_job_apply_id', $candidateJobApplyID)
                                                  ->where('status', 1)
                                                  ->get(['candidates_academics_details.*'])
                                                  ->toArray();
        $academicDetails = $candidateAcademicsDetails;                                          

        $candidateExperienceDetails = CandidatesExperienceDetails::where('candidate_job_apply_id', $candidateJobApplyID)
                                                  ->where('status', 1)
                                                  ->get(['candidates_experience_details.*'])
                                                  ->toArray();

        $candidatePHDResearchDetails = CandidatesPHDResearchDetails::where('candidate_job_apply_id', $candidateJobApplyID)
                                                  ->where('status', 1)
                                                  ->get(['candidates_phd_research_details.*'])
                                                  ->toArray();     
                                                  
        // candidate documents records
        $candidatesAcademicsDocuments = CandidatesAcademicsDocuments::where('candidate_job_apply_id', $candidateJobApplyID)
                                                  ->where('status', 1)
                                                  ->get(['candidates_academics_documents.*'])
                                                  ->toArray();

        $candidatesCommonDocuments = CandidatesCommonDocuments::where('candidate_job_apply_id', $candidateJobApplyID)
                                                  ->where('status', 1)
                                                  ->get(['candidates_common_documents.*'])
                                                  ->toArray();

        $candidatesExperienceDocuments = CandidatesExperienceDocuments::where('candidate_job_apply_id', $candidateJobApplyID)
                                                  ->where('status', 1)
                                                  ->get(['candidates_experience_documents.*'])
                                                  ->toArray();
                                          
        /*
        echo "<pre>";
        print_r($candidateJobApplyDetail);
        exit;*/
        return view('application.candidate_upload_documents',compact('candidateJobApplyDetail','retData','candidateJobApplyEncID','candidateAcademicsDetails','academicDetails','candidateExperienceDetails','candidatePHDResearchDetails','captcha_code','candidatesAcademicsDocuments','candidatesCommonDocuments','candidatesExperienceDocuments','formTabId','formTabIdEnc','jobValidations'));

    }

    // update candidate uploaded documents
    public function update_candidate_upload_documents(Request $request, $candidateJobApplyEncID, $formTabIdEnc=""){

        $postData = $request->post();
        /*
        echo "<pre>";
        print_r($_FILES);
        exit;
        */
        try{
            $candidateJobApplyID = Helper::decodeId($candidateJobApplyEncID);
            $candidate_id = "";
            $job_id = "";
            $candidatesJobsApplyRec = CandidatesJobsApply::where('id',$candidateJobApplyID)
                               ->get(['candidates_jobs_apply.*'])
                               ->toArray(); 
            if(!empty($candidatesJobsApplyRec)){
                $candidate_id = $candidatesJobsApplyRec[0]['candidate_id'];
                $job_id = $candidatesJobsApplyRec[0]['job_id'];
            
                // transactions start
                DB::beginTransaction();

                $postCommonDocsArr = [];
                //$destinationParentFolderPath = "public/upload/candidates_documents";
                $destinationParentFolderPath = config('app.candidates_docs_path');
                $destinationParentFolderPath .= "/".$candidateJobApplyID;
                $maxFileSize200KB = 500*1024;// 200 KB
                $maxFileSize50KB = 100*1024;// 50 KB
                $maxFileSize10KB = 100*1024;// 10 KB
                $maxFileSize500KB = 500*1024;// 10 KB
                $fileExtentionArr = ['pdf'];// should be array
                $fileExtentionImageArr = ['jpg','JPG','jpeg','JPEG'];// should be array
                //$candidateFolderName = "";
                $errorMsgArr = [];
                $isFileUploadError = 0;
                $isDocsUploaded = 0;     
                // category certificate upload start
                if(!empty($request->file('category_certificate'))){
                    $fileData = $request->file('category_certificate');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize200KB;
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                    if($fileUploadRetArr['status'] == 1){
                        $fileName = $fileData->getClientOriginalName();
                        $postCommonDocsArr['category_certificate'] = $fileName;
                        $isDocsUploaded = 1;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        array_push($errorMsgArr,$errorMsg);
                        $isFileUploadError = 1;
                        //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                    }
                    
                }
                // category certificate upload end
                // ESM certificate upload start
                if(!empty($request->file('esm_certificate'))){
                    $fileData = $request->file('esm_certificate');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize200KB;
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                    if($fileUploadRetArr['status'] == 1){
                        $fileName = $fileData->getClientOriginalName();
                        $postCommonDocsArr['esm_certificate'] = $fileName;
                        $isDocsUploaded = 1;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        array_push($errorMsgArr,$errorMsg);
                        $isFileUploadError = 1;
                        //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                    }
                    
                }
                // ESM certificate upload end
                // PWD certificate upload start
                if(!empty($request->file('pwd_certificate'))){
                    $fileData = $request->file('pwd_certificate');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize200KB;
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                    if($fileUploadRetArr['status'] == 1){
                        $fileName = $fileData->getClientOriginalName();
                        $postCommonDocsArr['pwd_certificate'] = $fileName;
                        $isDocsUploaded = 1;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        array_push($errorMsgArr,$errorMsg);
                        $isFileUploadError = 1;
                        //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                    }
                    
                }
                // PWD certificate upload end
                // candidate photo upload start
                if(!empty($request->file('passport_photo'))){
                    $fileData = $request->file('passport_photo');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize50KB;
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionImageArr);
                    if($fileUploadRetArr['status'] == 1){
                        $fileName = $fileData->getClientOriginalName();
                        $postCommonDocsArr['candidate_photo'] = $fileName;
                        $isDocsUploaded = 1;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        array_push($errorMsgArr,$errorMsg);
                        $isFileUploadError = 1;
                        //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                    }
                    
                }
                // candidate photo upload end
                
                // candidate signature upload start
                if(!empty($request->file('passport_sig'))){
                    $fileData = $request->file('passport_sig');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize10KB;
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionImageArr);
                    if($fileUploadRetArr['status'] == 1){
                        $fileName = $fileData->getClientOriginalName();
                        $postCommonDocsArr['candidate_sign'] = $fileName;
                        $isDocsUploaded = 1;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        array_push($errorMsgArr,$errorMsg);
                        $isFileUploadError = 1;
                        //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                    }
                    
                }
                // candidate signature upload end
                
                // fellowship certificate upload start
                if(!empty($request->file('fellowship_upload'))){
                    $fileData = $request->file('fellowship_upload');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize200KB;
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                    if($fileUploadRetArr['status'] == 1){
                        $fileName = $fileData->getClientOriginalName();
                        $postCommonDocsArr['fellowship_certificate'] = $fileName;
                        $isDocsUploaded = 1;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        array_push($errorMsgArr,$errorMsg);
                        $isFileUploadError = 1;
                        //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                    }
                    
                }
                // fellowship certificate upload end
                // exam qualified certificate upload start
                if(!empty($request->file('exam_qualified_upload'))){
                    $fileData = $request->file('exam_qualified_upload');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize200KB;
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                    if($fileUploadRetArr['status'] == 1){
                        $fileName = $fileData->getClientOriginalName();
                        $postCommonDocsArr['exam_qualified_certificate'] = $fileName;
                        $isDocsUploaded = 1;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        array_push($errorMsgArr,$errorMsg);
                        $isFileUploadError = 1;
                        //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                    }
                    
                }
                // exam qualified certificate upload end
                // Id Card upload start
                if(!empty($request->file('id_card'))){
                    $fileData = $request->file('id_card');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize500KB;
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                    if($fileUploadRetArr['status'] == 1){
                        $fileName = $fileData->getClientOriginalName();
                        $postCommonDocsArr['id_card'] = $fileName;
                        $isDocsUploaded = 1;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        array_push($errorMsgArr,$errorMsg);
                        $isFileUploadError = 1;
                        //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                    }
                    
                }
                // Id Card certificate upload end
                // Age Proof certificate upload start
                if(!empty($request->file('age_proof'))){
                    $fileData = $request->file('age_proof');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize500KB;
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                    if($fileUploadRetArr['status'] == 1){
                        $fileName = $fileData->getClientOriginalName();
                        $postCommonDocsArr['age_proof'] = $fileName;
                        $isDocsUploaded = 1;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        array_push($errorMsgArr,$errorMsg);
                        $isFileUploadError = 1;
                        //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                    }
                    
                }
                // Age Proof certificate upload end
                // NOC certificate upload start
                if(!empty($request->file('employer_noc'))){
                    $fileData = $request->file('employer_noc');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize500KB;
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                    if($fileUploadRetArr['status'] == 1){
                        $fileName = $fileData->getClientOriginalName();
                        $postCommonDocsArr['noc_certificate'] = $fileName;
                        $isDocsUploaded = 1;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        array_push($errorMsgArr,$errorMsg);
                        $isFileUploadError = 1;
                        //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                    }
                    
                }
                // NOC certificate upload end
                // stmt proposal upload start
                if(!empty($request->file('stmt_proposal'))){
                    $fileData = $request->file('stmt_proposal');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize500KB;
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                    if($fileUploadRetArr['status'] == 1){
                        $fileName = $fileData->getClientOriginalName();
                        $postCommonDocsArr['stmt_proposal'] = $fileName;
                        $isDocsUploaded = 1;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        array_push($errorMsgArr,$errorMsg);
                        $isFileUploadError = 1;
                        //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                    }
                    
                }
                // stmt proposal upload end
                // cv upload start
                if(!empty($request->file('cv'))){
                    $fileData = $request->file('cv');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize500KB;
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                    if($fileUploadRetArr['status'] == 1){
                        $fileName = $fileData->getClientOriginalName();
                        $postCommonDocsArr['candidate_cv'] = $fileName;
                        $isDocsUploaded = 1;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        array_push($errorMsgArr,$errorMsg);
                        $isFileUploadError = 1;
                        //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                    }
                    
                }
                // cv upload end
                // listpublication upload start
                if(!empty($request->file('listpublication'))){
                    $fileData = $request->file('listpublication');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize500KB;
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                    if($fileUploadRetArr['status'] == 1){
                        $fileName = $fileData->getClientOriginalName();
                        $postCommonDocsArr['listpublication'] = $fileName;
                        $isDocsUploaded = 1;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        array_push($errorMsgArr,$errorMsg);
                        $isFileUploadError = 1;
                        //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                    }
                    
                }
                // listpublication upload end
                // publication upload start
                if(!empty($request->file('publication'))){
                    $fileData = $request->file('publication');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize500KB;
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                    if($fileUploadRetArr['status'] == 1){
                        $fileName = $fileData->getClientOriginalName();
                        $postCommonDocsArr['publication'] = $fileName;
                        $isDocsUploaded = 1;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        array_push($errorMsgArr,$errorMsg);
                        $isFileUploadError = 1;
                        //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                    }
                    
                }
                // publication upload end
                // project upload start
                if(!empty($request->file('project'))){
                    $fileData = $request->file('project');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize500KB;
                    $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                    if($fileUploadRetArr['status'] == 1){
                        $fileName = $fileData->getClientOriginalName();
                        $postCommonDocsArr['project_proposal'] = $fileName;
                        $isDocsUploaded = 1;
                    }else{
                        $errorMsg = $fileUploadRetArr['msg'];
                        array_push($errorMsgArr,$errorMsg);
                        $isFileUploadError = 1;
                        //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                    }
                    
                }
                // project upload end
                if(!empty($postCommonDocsArr)){
                    $postCommonDocsArr['candidate_id'] = $candidate_id;
                    $postCommonDocsArr['job_id'] = $job_id;
                    $postCommonDocsArr['candidate_job_apply_id'] = $candidateJobApplyID;
                    $existingCommonDocs = CandidatesCommonDocuments::where('candidate_job_apply_id', $candidateJobApplyID)
                                             ->where('status', 1)     
                                             ->get(['id'])  
                                             ->toArray();
                    if(empty($existingCommonDocs)){                         
                        CandidatesCommonDocuments::create($postCommonDocsArr);
                    }else{
                        CandidatesCommonDocuments::where('id', $existingCommonDocs[0]['id'])->update($postCommonDocsArr);
                    }
                }


                // Academics certificate upload start
                if(!empty($request->file('academic_upload'))){
                    $fileDataAcademicArr = $request->file('academic_upload');
                    
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize200KB;
                    foreach($fileDataAcademicArr as $key=>$academicData){
                        $education_id = $key;
                        $fileUploadRetArr = Helper::upload($academicData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                        //print_r($fileUploadRetArr);
                        if($fileUploadRetArr['status'] == 1){
                            $postAcademicDocsArr = [];
                            $fileName = $academicData->getClientOriginalName();
                            $education_id = $key;
                            $postAcademicDocsArr['file_name'] = $fileName;
                            $postAcademicDocsArr['candidate_id'] = $candidate_id;
                            $postAcademicDocsArr['job_id'] = $job_id;
                            $postAcademicDocsArr['candidate_job_apply_id'] = $candidateJobApplyID;
                            $postAcademicDocsArr['education_id'] = $education_id;
                            $existingAcademicsDocs = CandidatesAcademicsDocuments::where('candidate_job_apply_id', $candidateJobApplyID)
                                                                                 ->where('education_id', $education_id)
                                                                                 ->where('status', 1)     
                                                                                 ->get(['id'])  
                                                                                 ->toArray();
                            if(empty($existingAcademicsDocs)){                         
                                CandidatesAcademicsDocuments::create($postAcademicDocsArr);
                            }else{
                                CandidatesAcademicsDocuments::where('id', $existingAcademicsDocs[0]['id'])->update($postAcademicDocsArr);
                            }
                            $isDocsUploaded = 1;
                        }else{
                            $errorMsg = $fileUploadRetArr['msg'];
                            array_push($errorMsgArr,$errorMsg);
                            $isFileUploadError = 1;
                            //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                        }
                    }
                }
                // Academics certificate upload end

                // Experience certificate upload start
                if(!empty($request->file('exp_upload'))){
                    $fileDataArr = $request->file('exp_upload');
                    $destinationPath = $destinationParentFolderPath;
                    $maxFileSizeKB = $maxFileSize200KB;
                    foreach($fileDataArr as $key=>$fileData){
                        $education_id = $key;
                        $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                        if($fileUploadRetArr['status'] == 1){
                            $fileName = $fileData->getClientOriginalName();
                            $postExperienceDocsArr = [];
                            $candidate_experience_detail_id = $key;
                            $postExperienceDocsArr['file_name'] = $fileName;
                            $postExperienceDocsArr['candidate_id'] = $candidate_id;
                            $postExperienceDocsArr['job_id'] = $job_id;
                            $postExperienceDocsArr['candidate_job_apply_id'] = $candidateJobApplyID;
                            $postExperienceDocsArr['candidate_experience_detail_id'] = $candidate_experience_detail_id;
                            $existingExperienceDocs = CandidatesExperienceDocuments::where('candidate_job_apply_id', $candidateJobApplyID)
                                                    ->where('candidate_experience_detail_id', $candidate_experience_detail_id) 
                                                    ->where('status', 1)     
                                                    ->get(['id'])  
                                                    ->toArray();
                            if(empty($existingExperienceDocs)){                         
                                CandidatesExperienceDocuments::create($postExperienceDocsArr);
                            }else{
                                CandidatesExperienceDocuments::where('id', $existingExperienceDocs[0]['id'])->update($postExperienceDocsArr);
                            }
                            $isDocsUploaded = 1;
                        }else{
                            $errorMsg = $fileUploadRetArr['msg'];
                            array_push($errorMsgArr,$errorMsg);
                            $isFileUploadError = 1;
                            //return redirect()->back()->withInput()->with('file_error',$errorMsg);
                        }
                    }
                }
                // Experience certificate upload end
            }

            // update candidate is_document_upload_done
            if($isFileUploadError == 0 && $isDocsUploaded = 1){
                $jobApplyArr['is_document_upload_done'] = 1;
                CandidatesJobsApply::where('id', $candidateJobApplyID)->update($jobApplyArr);
            }
            // transactions commit
            DB::commit();
            //echo 11;exit;
            if($isFileUploadError == 0 && $isDocsUploaded = 1){
                $finalSubmitTabIdEnc = Helper::encodeId(5);  
                $finalSubmitRoute = route('preview_application_final_submit', $candidateJobApplyEncID);
                $finalSubmitRouteUrl = $finalSubmitRoute."/".$finalSubmitTabIdEnc;
                return redirect($finalSubmitRouteUrl)->with('success','Documents uploaded.');
            }else{
                $finalSubmitTabIdEnc = Helper::encodeId(4);  
                $finalSubmitRoute = route('upload_candidate_documents', $candidateJobApplyEncID);
                $finalSubmitRouteUrl = $finalSubmitRoute."/".$finalSubmitTabIdEnc;
                return redirect($finalSubmitRouteUrl)->with('errorMsgArr',$errorMsgArr);
            }
            
        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            // log error in file
            Helper::logErrorInFile($e);
            DB::rollback();
            return redirect()->back()->withInput()->with('error_msg',$errorMsg);
        }

    }

    public function checkout($encJobApplyId, $formTabIdEnc=""){

        $candidateJobApplyEncID = $encJobApplyId;
        $candidateJobApplyID = Helper::decodeId($encJobApplyId);
        $candidateJobApplyDetail = CandidatesJobsApply::where('id',$candidateJobApplyID)
                                                        ->where('status', 1)
                                                        ->get(['candidates_jobs_apply.*'])
                                                        ->toArray();
        $candidateData = [];    
        $amountToPay = "";   
        $jobValidations = [];    
        $academicDetails = [];                                     
        if(!empty($candidateJobApplyDetail)){
            $category_id = $candidateJobApplyDetail[0]['category_id'];
            $job_id = $candidateJobApplyDetail[0]['job_id'];
            $candidate_id = $candidateJobApplyDetail[0]['candidate_id'];
            $candidateData = RegisterCandidate::where('id', $candidate_id)
                            ->where('status', 1)
                            ->get(['register_candidates.*'])
                            ->toArray();
            
            // call helper function to get candidate fee                
            $amountToPay = Helper::get_fee_for_candidate($candidateData, $candidateJobApplyDetail, $job_id);

            $candidateJobApplyValidationDetail = CandidatesJobsApply::join('jobs','jobs.id','=','candidates_jobs_apply.job_id')
                                                        ->where('candidates_jobs_apply.id',$candidateJobApplyID)
                                                        ->where('jobs.status','!=',3)
                                                        ->get(['candidates_jobs_apply.*','jobs.post_id'])
                                                        ->toArray();
            // job validation
            if(!empty($candidateJobApplyValidationDetail)){
                $postId = $candidateJobApplyValidationDetail[0]['post_id'];
                $jobValidations = JobValidation::where('job_validation.post_id', $postId)
                                                    ->where('job_validation.status', 1)
                                                    ->get(['job_validation.is_publication_tab','job_validation.is_patent_tab','job_validation.is_research_tab','job_validation.is_proposal_tab'])
                                                    ->toArray(); 
            }

            // get candidate existing education details
            $academicDetails = CandidatesAcademicsDetails::orderBy('id','asc')
                                                         ->where('candidate_id', $candidate_id)
                                                         ->where('job_id', $job_id)
                                                         ->where('status', 1)
                                                         ->get(['candidates_academics_details.*'])
                                                         ->toArray();
            
        }      
        

        return view('application.checkout', compact('candidateJobApplyDetail','academicDetails','candidateData','candidateJobApplyID','amountToPay','encJobApplyId','formTabIdEnc','jobValidations','candidateJobApplyEncID'));

    }

    // add fee transaction
    public function add_fee_transaction(Request $request, $encJobApplyId){

        try{
            $jobApplyId = Helper::decodeId($encJobApplyId);
            $postData = $request->post();
            $insertArr = [];
            $insertArr['job_apply_id'] = $jobApplyId;
            $insertArr['merchant_id'] = config('app.bildesk.merchant_id');
            $customer_id = $postData['customer_id'];
            $insertArr['customer_id'] = $customer_id;
            $insertArr['email'] = $postData['email'];
            $insertArr['mobile'] = $postData['mobile'];
            $insertArr['name'] = $postData['name'];
            $insertArr['txn_amount'] = $postData['txn_amt'];
            $insertArr['msg'] = $postData['msg'];
            $insertArr['checksum'] = $postData['checksum'];

            $feeTransRec = FeeTransactions::where('customer_id', $customer_id)->get(['fee_transactions.id'])->toArray();
            if(empty($feeTransRec)){
                // insert record
                FeeTransactions::create($insertArr);
                
            }
        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            DB::rollback();
            // log error in file
            Helper::logErrorInFile($e);
            return $errorMsg;
        }    
    }
    
    public function payment_response(){

        try{
            //CHECK FOR THE RESPONSE
            //$_REQUEST['msg'] = "THSTI|THSTI_3_JobFee_3_20230425092948|YCPH1857333605|311527275081|00000001.00|CPH|NA|10|INR|DIRECT|NA|NA|0.00|25-04-2023 15:00:05|0300|NA|kambojanuj@thsti.res.in|9999999999|Anuj|3|NA|NA|NA|NA|Success|43689AF4C8EB12BF644A1D098F8FF8A1A6E833FC0E12193C64742A9774E27D71";
            //http://localhost/new_ethsti_tabs_pdf/application/payment_response?msg=THSTI|THSTI_3_JobFee_3_20230425092948|YCPH1857333605|311527275081|00000001.00|CPH|NA|10|INR|DIRECT|NA|NA|0.00|25-04-2023%2015:00:05|0300|NA|kambojanuj@thsti.res.in|9999999999|Anuj|3|NA|NA|NA|NA|Success|43689AF4C8EB12BF644A1D098F8FF8A1A6E833FC0E12193C64742A9774E27D71
            if(isset($_REQUEST['msg']))
            {	
                $originalMsg = $_REQUEST['msg'];
                $bd_res=explode("|",$originalMsg);			
                /*echo "<pre>";
                print_r($bd_res);
                exit;*/
                $arr_count = sizeof($bd_res);
                if($arr_count<26)
                { 
                    //header('Location: https://thsti.in/bdpay/error.php?ercd=101'); 
                    return redirect()->route('dashboard')->with('error','Your recent transaction was not done. Please check status.');
                }
                else
                { 
                    $checksum_res=$bd_res[$arr_count-1]; 
                }
            
                //validating checksum values in the response string.		
                array_pop($bd_res);	
                $msg_res=implode("|",$bd_res);
                
                $checksum_cal = Helper::msg_encrypt($msg_res);//hash_hmac('sha256',$msg_res,'K6UQ3zS8RdctMiiPNjbn6wjDQ9cHUHQm', false);
                $checksum_cal = strtoupper($checksum_cal);
                
                if($checksum_cal == $checksum_res)
                {
                    
                    //fetch values from response and assigned to the array
                    $res=array();
                    $merchant_id = $bd_res[0];
                    $customer_id = $bd_res[1];
                    //echo $customer_id;exit;
                    $res['txn_reference_no'] = $bd_res[2];		
                    $res['bank_ref_no'] = $bd_res[3];
                    $res['bank_id'] = $bd_res[5];
                    $res['currency_type'] = $bd_res[8];
                    $txn_date = $bd_res[13];
                    $dateArr=explode(" ",$txn_date);
                    $ymdDate = Helper::rev_date($dateArr[0]);
                    $res['txn_date'] = $ymdDate." ".$dateArr[1];
                    $res['pay_status'] = $bd_res[14];
                    $res['error_status'] = $bd_res[23];
                    $res['error_description'] = $bd_res[24];
                    $res['checksum_res'] = $checksum_res;
                    $res['msg_res'] = $originalMsg;												
                                                
                    //sending and updating of record of tables after successful transaction		
                    $configMerchantId = config('app.bildesk.merchant_id');	
                    if($merchant_id == $configMerchantId)
                    {														
                        //here we need to update the respective table of candidate, tender, aef and etc depend on customer id
                        $req_type = explode("_",$customer_id);
                        $fee_type = $req_type[1];
                        $pay_st = $res['pay_status'];
                                                                                  
                        //fetch information to send sms
                        
                        $can_rec = FeeTransactions::leftJoin('candidates_jobs_apply','candidates_jobs_apply.id','=','fee_transactions.job_apply_id')
                                                    ->leftJoin('rn_nos','rn_nos.id','=','candidates_jobs_apply.rn_no_id')
                                                    ->where('fee_transactions.customer_id', $customer_id)
                                                    ->get(['fee_transactions.name','fee_transactions.mobile','fee_transactions.txn_reference_no','rn_nos.rn_no','candidates_jobs_apply.id as job_apply_id'])
                                                    ->toArray();
                                                    
                        $txn_id = $can_rec[0]['txn_reference_no'];
                                                           
                            //$can_rec=@mysqli_fetch_array(mysqli_query($conn,"SELECT r.`name`, j.`rn_no`, j.`position`, j.`app_id`, j.`mobile`, r.`pay_st`,r.`txn_no` FROM `bd_job_pay` j, `bd_pay_response` r WHERE j.`id`=r.`form_id` AND `customer_id` = '".$customer_id."'"),MYSQL_ASSOC);													
                            //print_r($can_rec);
                            $payment_status = 0;
                            $pay_status_code = $pay_st;
                            $is_payment_done = 0;
                            if($pay_st == '0300')
                            { 
                                $payment_status = 1;
                                $is_payment_done = 1;
                                $pay_st = 'SUCCESS';  
                                //SMS CONTETN TO BE DEFINE ACCORDING TO THE TYPE OF FEE SUBMITED
                                $sms_content = "Dear ".$can_rec[0]['name'].", You have successfully completed the submission of the THSTI application form with ref no. ".$can_rec[0]['rn_no'];																									
                            }
                            else if($pay_st == '0399')
                            { 	
                                $payment_status = 0;
                                $pay_st = 'FAILED';
                                //SMS CONTETN TO BE DEFINE ACCORDING TO THE TYPE OF FEE SUBMITED
                                $sms_content = "Dear ".$can_rec[0]['name'].", Your Transaction for the application has been FAILED. Please login at Dashboard and click on pay online.";										 
                            }		
                            
                            //update the record in response table of billdesk
                            //$res['pay_status'] = $pay_st;
                            /*echo "<pre>";
                            print_r($res);
                            exit;
                            */
                            $feeTransRec = FeeTransactions::where('customer_id', $customer_id)->update($res);
                            // add record in Fee status transactions table start
                            $feeStatusTrans['job_apply_id'] = $can_rec[0]['job_apply_id'];
                            $feeStatusTrans['pay_status_code'] = $pay_status_code;
                            if($pay_status_code == '0300'){
                                $feeStatusTrans['code_description'] = "Success";
                            }
                            else if($pay_status_code == '0399'){
                                $feeStatusTrans['code_description'] = "Failure";
                                if($res['error_description'] != "NA" && !empty($res['error_description'])){
                                    $feeStatusTrans['code_description'] = $res['error_description'];
                                }
                            }
                            else if($pay_status_code == 'NA'){
                                $feeStatusTrans['code_description'] = "Error Condition";
                                if($res['error_description'] != "NA" && !empty($res['error_description'])){
                                    $feeStatusTrans['code_description'] = $res['error_description'];
                                }
                            }
                            else if($pay_status_code == '0002'){
                                $feeStatusTrans['code_description'] = "Pending/Abandoned";
                                if($res['error_description'] != "NA" && !empty($res['error_description'])){
                                    $feeStatusTrans['code_description'] = $res['error_description'];
                                }
                            }
                            else if($pay_status_code == '0001'){
                                $feeStatusTrans['code_description'] = "Pending/Abandoned";
                                if($res['error_description'] != "NA" && !empty($res['error_description'])){
                                    $feeStatusTrans['code_description'] = $res['error_description'];
                                }
                            }else{

                            }
                            $feeStatusTrans['msg_json'] = $originalMsg;
                            
                            FeeStatusTransactions::create($feeStatusTrans);
                            // add record in Fee status transactions table end

                            //create sms param parameteres to send to the candidate
                            $mobile = $can_rec[0]['mobile'];	
                            /*							
                            $sms_param = Helper::sms_parameter($mobile, $sms_content);										
                            $sms_res = Helper::send_message($sms_param);
                            $json = json_decode($sms_res, true);	
                            
                            $sms_id = str_replace("Message ID : ",'',$json['Response']['Message']); 
                            $sms_st = $json['Status']; 					
                                                                                                    
                                                
                            //update sms response in bd response table
                            //$smsDetails['sms_res'] = $sms_res;
                            $smsDetails['sms_id'] = $sms_id;
                            $smsDetails['sms_status'] = $sms_st;
                            FeeTransactions::where('customer_id', $customer_id)->update($smsDetails);
                            //$result_jobs=@mysqli_query($conn,"UPDATE `bd_pay_response` SET `sms_res`='".$sms_res."', `sms_id`='".$sms_id."', `sms_st`='".$sms_st."' WHERE `customer_id`='".$customer_id."'");													
                            */                                                
                            $bdcid=base64_encode($customer_id);
                            //get receipt url from the pg_config table
                            $job_apply_id = $can_rec[0]['job_apply_id'];
                            $jobApplyIdEnc = Helper::encodeId($job_apply_id);  
                             
                            if($payment_status == 1) 
                            {   
                                //update record and status in apply_job master table
                                $jobApplyData['payment_status'] = $payment_status;
                                $jobApplyData['is_payment_done'] = $is_payment_done;
                                $jobApplyData['is_completed'] = 1;
                                CandidatesJobsApply::where('id',$job_apply_id)->update($jobApplyData);
                                //$result_jobs=@mysqli_query($conn,"UPDATE `apply_job` SET `txn_id`='".$txn_id."', `pay_st`='".$pay_st."' WHERE `id`='".$id."'");	
                                //header("Location: https://thsti.in/bdpay/pay_receipt.php?bdcid='".$bdcid."'");  
                            }   
                            $finalSubmitTabIdEnc = Helper::encodeId(7);  
                            $finalSubmitRoute = route('final_submission_after_payment', $jobApplyIdEnc);
                            $finalSubmitRouteUrl = $finalSubmitRoute."/".$finalSubmitTabIdEnc;
                            return redirect($finalSubmitRouteUrl)->with('success','Your payment completed. Please check status.');
                            /*    
                            else 
                            {   header('Location: https://thsti.in/bdpay/error.php?ercd=103'); }     
                        	*/
                                                        
                    }								
                }
                else
                {
                    return redirect()->route('dashboard')->with('error_msg','Your recent transaction was not done. Please check status.');
                    //header('Location: https://thsti.in/bdpay/error.php?ercd=102');
                }
                
            // check if $_REQUEST variable is set is set

            }
        }catch(\Exception $e){
            
            $errorMsg = $e->getMessage();
            //echo $errorMsg;exit;
            //DB::rollback();
            // log error in file
            Helper::logErrorInFile($e);
            return redirect()->route('dashboard')->with('error_msg',$errorMsg);
        }   

    }

    // crone job to check and update candidate payment status
    public function croneCheckCandidatePaymentStatus(){

        //https://www.billdesk.com/pgidsk/PGIQueryController
        try{
            /*
            $pendingFeeRec = FeeTransactions::where('pay_status','0002')
                        ->get('fee_transactions.*')
                        ->toArray();
            */
            $feeCroneJobArr['status'] = 2;// 2 for initiated
            $insertedData = FeeCroneJob::create($feeCroneJobArr);
            if(isset($insertedData->id)){
                $feeCroneJobId = $insertedData->id;
                // pay status 0002 is pending or abandoned
                $pendingFeeRec = FeeTransactions::where('pay_status', '=', '0300')
                                                ->get('fee_transactions.*')
                                                ->toArray();
                /*
                $pendingFeeRec = FeeTransactions::where('customer_id', '=', 'THSTI_13_JobFee_14_20230602095431')
                                                ->get('fee_transactions.*')
                                                ->toArray();                                
                */                                 
                /*
                $pendingFeeRec = FeeTransactions::where(function ($query) {
                                                        $query->where('pay_status', '=', '0300')
                                                            ->orWhere('pay_status', '=', null);
                                                    })
                                                ->get('fee_transactions.*')
                                                ->toArray();
                                                */
                /*echo "<pre>";
                print_r($pendingFeeRec);
                exit; */                               
                if(!empty($pendingFeeRec)){
                    $requestType = "0122"; // fixed value
                    $crone_api_url = config('app.bildesk.crone_api_url');
                    $merchantId = config('app.bildesk.merchant_id');
                    foreach($pendingFeeRec as $pendingReq){
                        $customerId = $pendingReq['customer_id'];//"THSTI_JobFee_24739_20230119201708";//
                        $currentDateTimeStamp = date('YmdHis');
                        // checksum
                        $msg = $requestType."|".$merchantId."|".$customerId."|".$currentDateTimeStamp;
                        
                        
                        $msg_encode_checksum = Helper::msg_encrypt($msg);
                        $finalMsg = $msg."|".$msg_encode_checksum;
                        //echo "finalMsg: ".$finalMsg;
                        $crone_api_url .= "?msg=".$finalMsg; 
                        // send request to API
                        //echo "crone_api_url: ".$crone_api_url."<br>";
                        //exit;
                        
                        $response = Http::get($crone_api_url);
                        
                        if(isset($response)){
                            
                            $resStatus = $response->status();
                            $resBody = $response->body();
                            /*echo "resStatus: ".$resStatus;
                            echo "<br>";
                            echo "resBody: ".$resBody;
                            exit;
                            */
                            $bd_res = explode("|",$resBody);			
                
                            $arr_count = sizeof($bd_res);
                            if($arr_count > 20){
                                $this->crone_api_response_data($resBody);
                            }
                            // entry in transaction table
                            $data['fee_crone_job_id'] = $feeCroneJobId;
                            $data['status_code'] = $resStatus;
                            $data['msg_body'] = $resBody;
                            /*echo "<pre>";
                            print_r($data);
                            exit;*/
                            FeeCroneJobTrans::create($data);
                        }
                    }
                }

                FeeCroneJob::where('id', $feeCroneJobId)->update(['status'=>1]);
            }
        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            //DB::rollback();
            // log error in file
            Helper::logErrorInFile($e);
            return redirect()->back()->withInput()->with('error_msg',$errorMsg);
        }     

    }

    public function crone_api_response_data($msg_string){

            try{
                $bd_res = explode("|",$msg_string);			
                
                $arr_count = sizeof($bd_res);
                $checksum_res = $bd_res[$arr_count-1]; 
                
                //validating checksum values in the response string.		
                //array_pop($bd_res);	
                $msg_res = $msg_string;//implode("|",$bd_res);
                
                $checksum_cal = Helper::msg_encrypt($msg_res);//hash_hmac('sha256',$msg_res,'K6UQ3zS8RdctMiiPNjbn6wjDQ9cHUHQm', false);
                $checksum_cal = strtoupper($checksum_cal);
                
                if($checksum_cal == $checksum_res)
                {
                    //fetch values from response and assigned to the array
                    $res = array();
                    $request_type = $bd_res[0];
                    $merchant_id = $bd_res[1];
                    $customer_id = $bd_res[2];
                    //fetch information to send sms
                    $can_rec = FeeTransactions::join('candidates_jobs_apply','candidates_jobs_apply.id','=','fee_transactions.job_apply_id')
                    ->join('rn_nos','rn_nos.id','=','candidates_jobs_apply.rn_no_id')
                    ->where('customer_id', $customer_id)
                    ->get(['fee_transactions.name','fee_transactions.mobile','fee_transactions.txn_reference_no','rn_nos.rn_no','candidates_jobs_apply.id as job_apply_id'])
                    ->toArray();

                    $res['txn_reference_no'] = $bd_res[3];		
                    $res['bank_ref_no'] = $bd_res[4];
                    $res['bank_id'] = $bd_res[5];
                    //$res['bank_id'] = $bd_res[6];
                    $res['currency_type'] = $bd_res[9];
                    $txn_date = $bd_res[14];
                    $dateArr=explode(" ",$txn_date);
                    $ymdDate = Helper::rev_date($dateArr[0]);
                    $res['txn_date'] = $ymdDate." ".$dateArr[1];
                    
                    $pay_status_code = $bd_res[15];
                    $res['pay_status'] = $pay_status_code;
                    $res['error_status'] = $bd_res[24];
                    $res['error_description'] = $bd_res[25];
                    $refund_status = $bd_res[27];
                    $res['checksum_res'] = $checksum_res;
                    $res['msg_res'] = $_REQUEST['msg'];		
                    
                    // add record in Fee status transactions table start
                    $fee_transaction_id = $can_rec[0]['id'];
                    $feeStatusTrans['pay_status_code'] = $pay_status_code;
                    $payment_status = 0;
                    if($pay_status_code == '0300' && $refund_status == "NA"){
                        $feeStatusTrans['code_description'] = "Success";
                        $payment_status = 1;
                    }
                    else if($pay_status_code == '0300' && $refund_status == "0699"){
                        $feeStatusTrans['code_description'] = "Cancellation";
                        if($res['error_description'] != "NA" && !empty($res['error_description'])){
                            $feeStatusTrans['code_description'] = $res['error_description'];
                        }
                    }
                    else if($pay_status_code == '0300' && $refund_status == "0799"){
                        $feeStatusTrans['code_description'] = "Refund";
                        if($res['error_description'] != "NA" && !empty($res['error_description'])){
                            $feeStatusTrans['code_description'] = $res['error_description'];
                        }
                    }
                    else if($pay_status_code == 'NA'){
                        $feeStatusTrans['code_description'] = "Error Condition";
                        if($res['error_description'] != "NA" && !empty($res['error_description'])){
                            $feeStatusTrans['code_description'] = $res['error_description'];
                        }
                    }
                    else if($pay_status_code == '0002'){
                        $feeStatusTrans['code_description'] = "Pending/Abandoned";
                        if($res['error_description'] != "NA" && !empty($res['error_description'])){
                            $feeStatusTrans['code_description'] = $res['error_description'];
                        }
                    }
                    else if($pay_status_code == '0001'){
                        $feeStatusTrans['code_description'] = "Pending/Abandoned";
                        if($res['error_description'] != "NA" && !empty($res['error_description'])){
                            $feeStatusTrans['code_description'] = $res['error_description'];
                        }
                    }else{

                    }
                    $feeStatusTrans['msg_json'] = $msg_string;
                    $feeStatusTrans['is_by_crone_job'] = 1;
                    FeeStatusTransactions::create($feeStatusTrans);

                    //update the record in response table of billdesk
                    //$res['pay_status'] = $pay_st;
                    $feeTransRec = FeeTransactions::where('customer_id', $customer_id)->update($res);

                    if($payment_status == 1) 
                    {   
                        //update record and status in apply_job master table
                        $jobApplyData['payment_status'] = $payment_status;
                        $jobApplyData['is_payment_done'] = 1;
                        $jobApplyData['is_completed'] = 1;
                        $job_apply_id = $can_rec[0]['job_apply_id'];
                        CandidatesJobsApply::where('id',$job_apply_id)->update($jobApplyData);
                        
                    }
                }
            }catch(\Exception $e){
                $errorMsg = $e->getMessage();
                Helper::logErrorInFile($e);
            }       
    }

    public function pay_receipt($candidateJobApplyEncID, $formTabIdEnc=""){

        $job_apply_id = Helper::decodeId($candidateJobApplyEncID);
        //$pay_rec = CandidatesJobsApply::where('id',$job_apply_id)->get('candidates_jobs_apply.*')->toArray();
        $pay_rec = CandidatesJobsApply::join('jobs','jobs.id','=','candidates_jobs_apply.job_id')
                                                    ->where('candidates_jobs_apply.id', $job_apply_id)
                                                    ->get(['candidates_jobs_apply.*','jobs.age_limit_as_on_date','jobs.age_limit','jobs.job_validation_id']);
        
        $candidateJobApplyDetail = $pay_rec;
        $feeTransRec = [];
        if(isset($pay_rec) && !empty($pay_rec)){
            $feeTransRec = FeeTransactions::orderBy('id','desc')->where('job_apply_id', $job_apply_id)->limit(1)->get(['fee_transactions.*'])->toArray();
        }
        $jobValidations = [];
        if(!empty($candidateJobApplyDetail) && isset($candidateJobApplyDetail[0]['job_validation_id'])){
            $job_validation_id = $candidateJobApplyDetail[0]['job_validation_id'];
            $jobValidations = JobValidation::leftJoin('job_min_education_trans','job_min_education_trans.job_validation_id','=','job_validation.id')
                                                    ->where('job_validation.id', $job_validation_id)
                                                    ->where('job_min_education_trans.status', 1)
                                                    ->get(['job_validation.is_age_validate','job_validation.is_exp_tab','job_validation.is_publication_tab','job_validation.is_patent_tab','job_validation.is_research_tab','job_validation.is_proposal_tab','job_min_education_trans.education_id','job_min_education_trans.job_validation_id'])
                                                    ->toArray(); 
        }
        return view('application/pay_receipt', compact('pay_rec','feeTransRec','formTabIdEnc','candidateJobApplyDetail','candidateJobApplyEncID','jobValidations'));
    }

    public function preview_application_final_submit($job_apply_id_enc, $formTabIdEnc=""){

        $candidateJobApplyEncID = $job_apply_id_enc;
        $job_apply_id = Helper::decodeId($job_apply_id_enc);
        $nextId = "";
        $previousId = "";
        $jobDetails = [];
        $candidateDetails = [];
        $candidateAcademicsDetails = [];
        $candidatesAcademicsDocuments = [];
        $candidatesCommonDocuments = [];
        $candidatesExperienceDetails = [];
        $candidatesExperienceDocuments = [];
        $candidatesPublicationsDetails = [];
        $candidatesPHDResearchDetails = [];
        $candidatesRefreeDetails = [];
        $feeTransactions = [];
        $candidatesJobHRRemarks = [];
        $previousRec = [];
        $nextRec = [];
        $jobAgeRelaxation = [];
        $jobExperienceValidation = [];
        $jobEducationValidation = [];

        $candidateJobApplyDetail = CandidatesJobsApply::join('jobs','jobs.id','=','candidates_jobs_apply.job_id')
                                                    ->where('candidates_jobs_apply.id', $job_apply_id)
                                                    ->get(['candidates_jobs_apply.*','jobs.age_limit_as_on_date','jobs.age_limit','jobs.job_validation_id']);
        $rnNoEncId = "";
        $jobEncId = "";
        if(isset($candidateJobApplyDetail) && !empty($candidateJobApplyDetail)){
            $candidate_id = $candidateJobApplyDetail[0]['candidate_id'];
            $jobId = $candidateJobApplyDetail[0]['job_id'];
            $rn_no_id = $candidateJobApplyDetail[0]['rn_no_id'];
            $job_validation_id = $candidateJobApplyDetail[0]['job_validation_id'];
            $rnNoEncId = Helper::encodeId($rn_no_id);
            $jobEncId = Helper::encodeId($jobId);
            $jobDetails = Jobs::join('rn_nos','rn_nos.id','=','jobs.rn_no_id')
                              ->where('jobs.id', $jobId)
                              ->get(['jobs.*','rn_nos.rn_no']);

            $jobValidations = JobValidation::leftJoin('job_min_education_trans','job_min_education_trans.job_validation_id','=','job_validation.id')
                              ->where('job_validation.id', $job_validation_id)
                              ->where('job_min_education_trans.status', 1)
                              ->get(['job_validation.is_age_validate','job_validation.is_exp_tab','job_validation.is_publication_tab','job_validation.is_patent_tab','job_validation.is_research_tab','job_validation.is_proposal_tab','job_min_education_trans.education_id','job_min_education_trans.job_validation_id'])
                              ->toArray();                  
            // candidate personal details                  
            $candidateDetails = RegisterCandidate::where('id', $candidate_id)->get(['register_candidates.*']);    
            // candidate academics details
            $candidateAcademicsDetails = CandidatesAcademicsDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_academics_details.*'])->toArray();  
            // candidate academics documents
            $candidatesAcademicsDocuments = CandidatesAcademicsDocuments::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_academics_documents.*'])->toArray();
            // candidate common documents
            $candidatesCommonDocuments = CandidatesCommonDocuments::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_common_documents.*'])->toArray();
            // candidate experience details
            $candidatesExperienceDetails = CandidatesExperienceDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_experience_details.*'])->toArray();
            // Candidates Experience Documents
            $candidatesExperienceDocuments = CandidatesExperienceDocuments::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_experience_documents.*'])->toArray();
            // Candidates Publications Details
            $candidatesPublicationsDetails = CandidatesPublicationsDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_publications_details.*'])->toArray();
            // Candidates PHDResearch Details
            $candidatesPHDResearchDetails = CandidatesPHDResearchDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_phd_research_details.*'])->toArray();
            // Candidates Refree Details
            $candidatesRefreeDetails = CandidatesRefreeDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_refree_details.*'])->toArray();
            
        }
        
        // get all code_names join with code_master
        $masterDataArr = Helper::getCodeNames();
        return view("application/candidate_preview_final_submit",compact('candidateJobApplyDetail','masterDataArr','jobDetails','candidateDetails','candidateAcademicsDetails','candidatesAcademicsDocuments','candidatesCommonDocuments','candidatesExperienceDetails','candidatesExperienceDocuments','candidatesPublicationsDetails','candidatesPHDResearchDetails','candidatesRefreeDetails','job_apply_id_enc','rnNoEncId','jobEncId','jobValidations','candidateJobApplyEncID','formTabIdEnc'));
    }

    public function application_final_submission(Request $request, $job_apply_id_enc, $formTabIdEnc=""){

        try{
            $postData = $request->post();
            /*
            $declaration = $postData['declaration'];
            if($declaration == 1){
            */    
                // update candidate is_final_submission_done
                $jobApplyArr['is_final_submission_done'] = 1;
                $candidateJobApplyID = Helper::decodeId($job_apply_id_enc);
                CandidatesJobsApply::where('id', $candidateJobApplyID)->update($jobApplyArr);
                $candidatesJobsApplyArr = CandidatesJobsApply::where('id', $candidateJobApplyID)->get(['candidates_jobs_apply.*'])->toArray();
                $is_payment_done = $candidatesJobsApplyArr[0]['is_payment_done'];
                $redirectUrl = "";
                if($is_payment_done == 1){
                    $redirectUrl = route('pay_receipt',$job_apply_id_enc);
                }else{
                    $redirectUrl = route('checkout',$job_apply_id_enc);
                }
                $formTabIdEnc = Helper::encodeId(6);   
                $redirectUrl .= "/".$formTabIdEnc;
                return redirect($redirectUrl);
            /*    
            }else{
                $errorMsg = "Please select the declaration checkbox.";
                return redirect()->back()->withInput()->with('error_msg',$errorMsg);
            }
            */
        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            //$errorMsg = "Something went wrong. Please contact administrator.";
            DB::rollback();
            // log error in file
            Helper::logErrorInFile($e);
            return redirect()->back()->withInput()->with('error_msg',$errorMsg);
        }
        

    }

    
    //////////////////  after payment final submission start  //////////////////////////////
    public function final_submission_after_payment($job_apply_id_enc, $formTabIdEnc=""){

        $final_submission_after_payment = 1;
        $candidateJobApplyEncID = $job_apply_id_enc;
        $job_apply_id = Helper::decodeId($job_apply_id_enc);
        $nextId = "";
        $previousId = "";
        $jobDetails = [];
        $candidateDetails = [];
        $candidateAcademicsDetails = [];
        $candidatesAcademicsDocuments = [];
        $candidatesCommonDocuments = [];
        $candidatesExperienceDetails = [];
        $candidatesExperienceDocuments = [];
        $candidatesPublicationsDetails = [];
        $candidatesPHDResearchDetails = [];
        $candidatesRefreeDetails = [];
        $feeTransactions = [];
        $candidatesJobHRRemarks = [];
        $previousRec = [];
        $nextRec = [];
        $jobAgeRelaxation = [];
        $jobExperienceValidation = [];
        $jobEducationValidation = [];

        $candidateJobApplyDetail = CandidatesJobsApply::join('jobs','jobs.id','=','candidates_jobs_apply.job_id')
                                                    ->where('candidates_jobs_apply.id', $job_apply_id)
                                                    ->get(['candidates_jobs_apply.*','jobs.age_limit_as_on_date','jobs.age_limit','jobs.job_validation_id']);
        $rnNoEncId = "";
        $jobEncId = "";
        if(isset($candidateJobApplyDetail) && !empty($candidateJobApplyDetail)){
            $candidate_id = $candidateJobApplyDetail[0]['candidate_id'];
            $jobId = $candidateJobApplyDetail[0]['job_id'];
            $rn_no_id = $candidateJobApplyDetail[0]['rn_no_id'];
            $job_validation_id = $candidateJobApplyDetail[0]['job_validation_id'];
            $rnNoEncId = Helper::encodeId($rn_no_id);
            $jobEncId = Helper::encodeId($jobId);
            $jobDetails = Jobs::join('rn_nos','rn_nos.id','=','jobs.rn_no_id')
                              ->where('jobs.id', $jobId)
                              ->get(['jobs.*','rn_nos.rn_no']);

            $jobValidations = JobValidation::leftJoin('job_min_education_trans','job_min_education_trans.job_validation_id','=','job_validation.id')
                              ->where('job_validation.id', $job_validation_id)
                              ->where('job_min_education_trans.status', 1)
                              ->get(['job_validation.is_age_validate','job_validation.is_exp_tab','job_validation.is_publication_tab','job_validation.is_patent_tab','job_validation.is_research_tab','job_validation.is_proposal_tab','job_min_education_trans.education_id','job_min_education_trans.job_validation_id'])
                              ->toArray();                  
            // candidate personal details                  
            $candidateDetails = RegisterCandidate::where('id', $candidate_id)->get(['register_candidates.*']);    
            // candidate academics details
            $candidateAcademicsDetails = CandidatesAcademicsDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_academics_details.*'])->toArray();  
            // candidate academics documents
            $candidatesAcademicsDocuments = CandidatesAcademicsDocuments::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_academics_documents.*'])->toArray();
            // candidate common documents
            $candidatesCommonDocuments = CandidatesCommonDocuments::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_common_documents.*'])->toArray();
            // candidate experience details
            $candidatesExperienceDetails = CandidatesExperienceDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_experience_details.*'])->toArray();
            // Candidates Experience Documents
            $candidatesExperienceDocuments = CandidatesExperienceDocuments::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_experience_documents.*'])->toArray();
            // Candidates Publications Details
            $candidatesPublicationsDetails = CandidatesPublicationsDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_publications_details.*'])->toArray();
            // Candidates PHDResearch Details
            $candidatesPHDResearchDetails = CandidatesPHDResearchDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_phd_research_details.*'])->toArray();
            // Candidates Refree Details
            $candidatesRefreeDetails = CandidatesRefreeDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_refree_details.*'])->toArray();
            // Fee Transactions Details
            $feeTransactions = FeeTransactions::orderBy('id','desc')->where('job_apply_id', $job_apply_id)->limit(1)->get(['fee_transactions.*'])->toArray();
                
        }
        
        // get all code_names join with code_master
        $masterDataArr = Helper::getCodeNames();
        return view("application/candidate_preview_final_submit",compact('candidateJobApplyDetail','masterDataArr','jobDetails','candidateDetails','candidateAcademicsDetails','candidatesAcademicsDocuments','candidatesCommonDocuments','candidatesExperienceDetails','candidatesExperienceDocuments','candidatesPublicationsDetails','candidatesPHDResearchDetails','candidatesRefreeDetails','job_apply_id_enc','rnNoEncId','jobEncId','jobValidations','candidateJobApplyEncID','formTabIdEnc','final_submission_after_payment','feeTransactions'));
    }

    public function save_final_submission_after_payment(Request $request, $job_apply_id_enc, $formTabIdEnc=""){

        try{
            $postData = $request->post();
            $declaration = $postData['declaration'];
            if($declaration == 1){
                // update candidate is_final_submission_done
                $jobApplyArr['is_final_submit_after_payment'] = 1;
                $candidateJobApplyID = Helper::decodeId($job_apply_id_enc);
                CandidatesJobsApply::where('id', $candidateJobApplyID)->update($jobApplyArr);
                $redirectUrl = route('dashboard');
                $this->exportCandidateDetailsPdf($job_apply_id_enc);
                return redirect($redirectUrl);
            }else{
                $errorMsg = "Please select the declaration checkbox.";
                return redirect()->back()->withInput()->with('error_msg',$errorMsg);
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
    //////////////////  after payment final submission end  //////////////////////////////

    public function send_mail(){

        //$mobile = "9517886722";
        //$sms_content = "Test sms from new recruitment module.";
        //$sms_param = Helper::sms_parameter($mobile, $sms_content);										
        //$sms_res = Helper::send_message($sms_param);
        //$json = json_decode($sms_res, true);
        //echo "<pre>";
        //print_r($json);
        //Helper::send_mail();
        $msg = "Test email laravel.";
        $to_name = "kambojanuj1992@gmail.com";
        $to_email = "kambojanuj1992@gmail.com";
        $subject = "THSTI recruitment";
        //$res = Mail::to($to_email)->send($msg);
        $SENDER_EMAIL_ADDRESS = config('app.sender_email_address');
        $title = "THSTI";
        $candidateName = "Anuj Kamboj";
        $msgBody = "You are shortlisted for exam.";
        $data = array('name'=>$candidateName, 'body' => $msgBody);
        
        //$html = "Hello <strong>{{name}}</strong>,<p>{{body}}</p>";
        $res = Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email, $subject, $title, $SENDER_EMAIL_ADDRESS) {
                    $message->to($to_email, $to_name)->subject($subject)->from($SENDER_EMAIL_ADDRESS,$title);
                });
        /*$res = Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email, $SENDER_EMAIL_ADDRESS) {
                    $message->to($to_email, $to_name)->subject('Laravel Test Mail')->from($SENDER_EMAIL_ADDRESS,'Test Mail');
                });        
        */       
        print_r($res);
        exit;
    }

    public function get_email_otp(Request $request){

        try{
            $status = 0;
            $msg = "Kindly enter your email id in email field.";
            $postData = $request->post();
            if(isset($postData['email']) && !empty($postData['email'])){
                $email = $postData['email'];
                $to_name = $email;
                $subject = "THSTI recruitment registration OTP";
                $sender_email_address = config('app.sender_email_address');
                $title = "THSTI";
                
                $status = 1;
                $otp = Helper::generateNumericOTP();
                $emailStatus = Helper::send_otp_mail($email, $to_name, $subject, $msg, $title, $otp, $sender_email_address);
                if($emailStatus == 1){
                    $msg = "OTP sent on your email id. Kindly use it to complete registration.";
                }else{
                    $msg = "Something went wrong. Kindly contact support.";
                }
                $this->save_email_otp($email, $otp, $emailStatus);
            }
        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            DB::rollback();
            // log error in file
            Helper::logErrorInFile($e);
            $status = 0;
            $msg = $errorMsg;
        }
        $retData['status'] = $status;
        $retData['msg'] = $msg;
        return $retData;
    }

    public function save_email_otp($email, $otp, $status){

        $dataArray['email_id'] = $email;
        $dataArray['otp'] = $otp;
        $dataArray['status'] = $status;
        RegistrationOTP::create($dataArray);
        return 1;
    }


    public function exportCandidateDetailsPdf($job_apply_id_enc) {
        
        $job_apply_id = Helper::decodeId($job_apply_id_enc);
        $jobDetails = [];
        $candidateDetails = [];
        $candidateAcademicsDetails = [];
        $candidatesAcademicsDocuments = [];
        $candidatesCommonDocuments = [];
        $candidatesExperienceDetails = [];
        $candidatesExperienceDocuments = [];
        $candidatesPublicationsDetails = [];
        $candidatesPHDResearchDetails = [];
        $candidatesRefreeDetails = [];
        $feeTransactions = [];
        
        $candidateApplyDetails = CandidatesJobsApply::join('jobs','jobs.id','=','candidates_jobs_apply.job_id')
                                                    ->where('candidates_jobs_apply.id', $job_apply_id)
                                                    ->get(['candidates_jobs_apply.*','jobs.age_limit_as_on_date','jobs.age_limit','jobs.job_validation_id'])
                                                    ->toArray();
        $rnNoEncId = "";
        $jobEncId = "";
        $candidate_id = "";
        $is_after_payment_mail_sent = $candidateApplyDetails[0]['is_after_payment_mail_sent'];
        if($is_after_payment_mail_sent == 0){
        
            if(isset($candidateApplyDetails) && !empty($candidateApplyDetails)){
                $candidate_id = $candidateApplyDetails[0]['candidate_id'];
                $jobId = $candidateApplyDetails[0]['job_id'];
                $rn_no_id = $candidateApplyDetails[0]['rn_no_id'];
                $job_validation_id = $candidateApplyDetails[0]['job_validation_id'];
                $rnNoEncId = Helper::encodeId($rn_no_id);
                $jobEncId = Helper::encodeId($jobId);
                $jobDetails = Jobs::join('rn_nos','rn_nos.id','=','jobs.rn_no_id')
                                ->where('jobs.id', $jobId)
                                ->get(['jobs.*','rn_nos.rn_no']);
                // candidate personal details                  
                $candidateDetails = RegisterCandidate::where('id', $candidate_id)->get(['register_candidates.*']);    
                // candidate academics details
                $candidateAcademicsDetails = CandidatesAcademicsDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_academics_details.*'])->toArray();  
                // candidate academics documents
                $candidatesAcademicsDocuments = CandidatesAcademicsDocuments::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_academics_documents.*'])->toArray();
                // candidate common documents
                $candidatesCommonDocuments = CandidatesCommonDocuments::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_common_documents.*'])->toArray();
                // candidate experience details
                $candidatesExperienceDetails = CandidatesExperienceDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_experience_details.*'])->toArray();
                // Candidates Experience Documents
                $candidatesExperienceDocuments = CandidatesExperienceDocuments::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_experience_documents.*'])->toArray();
                // Candidates Publications Details
                $candidatesPublicationsDetails = CandidatesPublicationsDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_publications_details.*'])->toArray();
                // Candidates PHDResearch Details
                $candidatesPHDResearchDetails = CandidatesPHDResearchDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_phd_research_details.*'])->toArray();
                // Candidates Refree Details
                $candidatesRefreeDetails = CandidatesRefreeDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_refree_details.*'])->toArray();
                // Fee Transactions Details
                $feeTransactions = FeeTransactions::orderBy('id','desc')->where('job_apply_id', $job_apply_id)->limit(1)->get(['fee_transactions.*'])->toArray();
                
            }
        
            // get all code_names join with code_master
            $masterDataArr = Helper::getCodeNames();
            $isPDFGenerating = 1;
            //return view("application/candidate_details_pdf",compact('candidateApplyDetails','masterDataArr','jobDetails','candidateDetails','candidateAcademicsDetails','candidatesAcademicsDocuments','candidatesCommonDocuments','candidatesExperienceDetails','candidatesExperienceDocuments','candidatesPublicationsDetails','candidatesPHDResearchDetails','candidatesRefreeDetails','feeTransactions','job_apply_id_enc','rnNoEncId','jobEncId','isPDFGenerating'));
            
            $pdf = PDF::loadView("application/candidate_details_pdf",compact('candidateApplyDetails','masterDataArr','jobDetails','candidateDetails','candidateAcademicsDetails','candidatesAcademicsDocuments','candidatesCommonDocuments','candidatesExperienceDetails','candidatesExperienceDocuments','candidatesPublicationsDetails','candidatesPHDResearchDetails','candidatesRefreeDetails','feeTransactions','job_apply_id_enc','rnNoEncId','jobEncId','isPDFGenerating'));
            ////////////////////////////// PDF work start
            //$pdf = PDF::loadView('application.test'); // <--- load your view into theDOM wrapper;
            $folderPath = config('app.candidates_details_pdf_doc_path'); // <--- folder to store the pdf documents into the server;
            $detailsFileName = "details_".time().'_'.$candidate_id.'_'.$job_apply_id.'.pdf' ; // <--giving the random filename,
            $filePath = $folderPath . '/' . $detailsFileName;
            // save as pdf in folder
            $pdf->save($filePath);
            $details_pdf_link = url($filePath);
            //echo $generated_pdf_link;

            // payment receipt pdf
            $pay_rec = $candidateApplyDetails;//CandidatesJobsApply::where('id',$job_apply_id)->get('candidates_jobs_apply.*')->toArray();
            $feeTransRec = $feeTransactions;
            $pay_pdf = PDF::loadView('application/pay_receipt_pdf', compact('pay_rec','feeTransRec'));
            $payfileName = "pay_receipt_".time().'_'.$candidate_id.'_'.$job_apply_id.'.pdf' ; // <--giving the random filename,
            $payfilePath = $folderPath . '/' . $payfileName;
            // save as pdf in folder
            $pay_pdf->save($payfilePath);
            $pay_receipt_pdf_link = url($payfilePath);
            //echo "details_pdf_link: ".$details_pdf_link."<br>";
            //echo "pay_receipt_pdf_link: ".$pay_receipt_pdf_link;
            $to_email = $feeTransRec[0]['email'];
            $to_name = $to_email;
            $subject = "Application form submitted details & payment receipt.";
            $title = "THSTI";
            $mailTemplate = "emails.after_payment";
            $candidateName = $feeTransRec[0]['name'];
            $dataArr = [
                'name' => $candidateName,
                'profile_pdf_link' => $details_pdf_link,
                'payment_receipt_pdf_link' => $pay_receipt_pdf_link
            ];
            $sender_email_address = config('app.sender_email_address');
            $emailStatus = Helper::send_mail($to_email, $to_name, $subject, $title, $mailTemplate,$dataArr, $sender_email_address);
            if($emailStatus == 1){
                $updateDataArr = [
                    'details_pdf_name' => $detailsFileName,
                    'pay_receipt_pdf_name' => $payfileName,
                    'is_after_payment_mail_sent' => 1
                ];
                CandidatesJobsApply::where('id', $job_apply_id)->update($updateDataArr);
                $msg = "Kindly check your email to download filled details and payment receit.";
            }else{
                $msg = "Something went wrong. Kindly contact support.";
            }
        }else{
            $msg = "Email already sent.";
        }
        return $msg;
        //return 1;
        //return $pdf->stream('candidate_details.pdf');
        //return response()->json($generated_pdf_link);
    }

    public function croneSendEmailAfterPayment(){

        try{
            $candidatesArray = CandidatesJobsApply::where('is_after_payment_mail_sent', 0)
                                                    ->where('payment_status', 1)
                                                    ->where('is_completed', 1)
                                                    ->get(['id'])
                                                    ->toArray();

            foreach($candidatesArray as $data){
                $job_apply_id_enc = Helper::encodeId($data['id']);
                $this->exportCandidateDetailsPdf($job_apply_id_enc);
            }
            return 1;
        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            DB::rollback();
            // log error in file
            Helper::logErrorInFile($e);
            return 0;
        }    
    }

}