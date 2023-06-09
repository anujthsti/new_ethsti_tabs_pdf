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
use App\Models\CandidatesJobsApply;
use App\Models\RegisterCandidate;
use App\Models\CandidatesAcademicsDetails;
use App\Models\CandidatesCommonDocuments;
use App\Models\CandidatesAcademicsDocuments;
use App\Models\CandidatesExperienceDetails;
use App\Models\CandidatesExperienceDocuments;
use App\Models\CandidatesPublicationsDetails;
use App\Models\CandidatesRefreeDetails;
use App\Models\CandidatesPHDResearchDetails;
use App\Models\FeeTransactions;
use App\Models\FeeStatusTransactions;
use App\Models\HRRemarks;
use App\Models\CandidatesJobHRRemarks;


class HRShortlistingController extends Controller
{
    public function __construct(){
        
    }

    public function candidate_list($rnNoTypeEncId="",$thsRNTypeEncId="", $rn_no_EncId="",$jobEncId="", $filterId=""){

        $rn_nos = [];
        $positionsArr = [];
        $candidatesList = [];
        $masterData = [];
        $cdsaTypeIdEnc = "";
        // get rolling job type
        $rnNoTypesArr = Helper::getCodeNamesByMasterCode("rn_no_type");
        $ths_rn_types = [];
        if(isset($rnNoTypeEncId) && !empty($rnNoTypeEncId)){
            $rnNoTypeId = Helper::decodeId($rnNoTypeEncId);
            if($rnNoTypeId == 109){ // for thsti RN Types
                $ths_rn_types = Helper::getCodeNamesByMasterCode("ths_rn_types");
                if(!empty($thsRNTypeEncId)){
                    $ths_typesId = Helper::decodeId($thsRNTypeEncId);
                    $rn_nos = Rn_no::orderBy('id','desc')
                                ->where('rn_type_id', $rnNoTypeId)
                                ->where('ths_rn_type_id', $ths_typesId)
                                ->get();
                }
            }else{
                $cdsaTypeIdEnc = Helper::encodeId(1010);
                $rn_nos = Rn_no::orderBy('id','desc')
                                ->where('rn_type_id', $rnNoTypeId)
                                ->get();
            }
            
            if(isset($rn_no_EncId) && !empty($rn_no_EncId)){
                $rnNoId = Helper::decodeId($rn_no_EncId);
                $positionsArr = Jobs::join('code_names','code_names.id','=','jobs.post_id')
                                    ->where('rn_no_id', $rnNoId)
                                    ->where('jobs.status', 1)
                                    ->get(['code_names.*','jobs.id as job_id']);
                                
                if(isset($jobEncId) && !empty($jobEncId)){
                    $jobId = Helper::decodeId($jobEncId);
                    $selectArray = ['register_candidates.*','candidates_jobs_apply.id as candidate_job_apply_id','candidates_jobs_apply.domain_id','candidates_jobs_apply.category_id','candidates_jobs_apply.application_status','candidates_jobs_apply.total_experience','candidates_jobs_apply.payment_status','candidates_jobs_apply.is_completed','candidates_jobs_apply.age_calculated'];

                    // If shortlisted filter
                    if(isset($filterId) && !empty($filterId)){
                        if($filterId == 1 || $filterId == 2 || $filterId == 3){
                            // 1 for shortlistd, 2 for rejected, 3 provisional shortlisted
                            $candidatesList = CandidatesJobsApply::join('register_candidates','register_candidates.id','=','candidates_jobs_apply.candidate_id')
                                                                    ->where('candidates_jobs_apply.job_id', $jobId)
                                                                    ->where('candidates_jobs_apply.shortlisting_status', $filterId)
                                                                    ->where('candidates_jobs_apply.status', 1)
                                                                    ->get($selectArray);
                        }
                        else if($filterId == 4){
                            // for screened records filter
                            $candidatesList = CandidatesJobsApply::join('register_candidates','register_candidates.id','=','candidates_jobs_apply.candidate_id')
                                                                    ->where('candidates_jobs_apply.job_id', $jobId)
                                                                    ->where('candidates_jobs_apply.is_screened', 1)
                                                                    ->where('candidates_jobs_apply.status', 1)
                                                                    ->get($selectArray);
                        }
                    }
                    else{
                        $candidatesList = CandidatesJobsApply::join('register_candidates','register_candidates.id','=','candidates_jobs_apply.candidate_id')
                                                            ->where('candidates_jobs_apply.job_id', $jobId)
                                                            ->where('candidates_jobs_apply.status', 1)
                                                            ->get($selectArray);
                    }
                    // get all code_names join with code_master
                    if(!empty($candidatesList)){
                        $masterData = Helper::getCodeNames();  
                    }                                   
                                                    
                }                    

            }
        }
        return view("hr_shortlisting/candidates_list", compact('rn_nos','positionsArr','candidatesList','masterData','rn_no_EncId','jobEncId','filterId','rnNoTypesArr','rnNoTypeEncId','ths_rn_types','thsRNTypeEncId','cdsaTypeIdEnc'));
    }

    public function candidate_print($job_apply_id_enc){

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

        $candidateApplyDetails = CandidatesJobsApply::join('jobs','jobs.id','=','candidates_jobs_apply.job_id')
                                                    ->where('candidates_jobs_apply.id', $job_apply_id)
                                                    ->get(['candidates_jobs_apply.*','jobs.age_limit_as_on_date','jobs.age_limit','jobs.job_validation_id']);
        $candidateJobApplyDetail = $candidateApplyDetails;                                            
        $rnNoEncId = "";
        $jobEncId = "";
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
            // Candidates Job HRRemarks
            $candidatesJobHRRemarks = CandidatesJobHRRemarks::join('apply_job_hr_remarks','apply_job_hr_remarks.id','=','candidates_job_hr_remarks.remarks_code_id')
                                                            ->orderBy('id','asc')
                                                            ->where('candidate_job_apply_id', $job_apply_id)
                                                            ->where('candidates_job_hr_remarks.status', 1)
                                                            ->get(['candidates_job_hr_remarks.*','apply_job_hr_remarks.code'])
                                                            ->toArray();
            // get previous candidate
            $previousRec = CandidatesJobsApply::orderBy('id','desc')->where('id', '<', $job_apply_id)->get(['id'])->first();
            // get next candidate
            $nextRec = CandidatesJobsApply::orderBy('id','desc')->where('id', '>', $job_apply_id)->get(['id'])->first();
            // get job validations
            if(isset($job_validation_id) && !empty($job_validation_id)){
                $jobAgeRelaxation = JobAgeRelaxation::where('job_validation_id', $job_validation_id)
                                                    ->where('job_age_limit_validation_trans.status', 1)
                                                    ->get(['job_age_limit_validation_trans.*'])
                                                    ->toArray();
                // min experience transaction
                $jobExperienceValidation = JobExperienceValidation::where('job_validation_id', $job_validation_id)
                                                    ->where('job_min_experience_trans.status', 1)
                                                    ->get(['job_min_experience_trans.*'])
                                                    ->toArray();  
                // min experience transaction
                $jobExperienceValidation = JobExperienceValidation::where('job_validation_id', $job_validation_id)
                                                                    ->where('job_min_experience_trans.status', 1)
                                                                    ->get(['job_min_experience_trans.*'])
                                                                    ->toArray();  
                // min education transaction
                $jobEducationValidation = JobEducationValidation::where('job_validation_id', $job_validation_id)
                                                                    ->where('job_min_education_trans.status', 1)
                                                                    ->get(['job_min_education_trans.*'])
                                                                    ->toArray(); 
                                                                    
            }
        }
        
        // HR Remarks List
        $hRRemarks = HRRemarks::get(['apply_job_hr_remarks.*'])->toArray();
        // get all code_names join with code_master
        $masterDataArr = Helper::getCodeNames();
        return view("hr_shortlisting/candidate_print",compact('candidateApplyDetails','candidateJobApplyDetail','masterDataArr','jobDetails','candidateDetails','candidateAcademicsDetails','candidatesAcademicsDocuments','candidatesCommonDocuments','candidatesExperienceDetails','candidatesExperienceDocuments','candidatesPublicationsDetails','candidatesPHDResearchDetails','candidatesRefreeDetails','feeTransactions','hRRemarks','candidatesJobHRRemarks','job_apply_id_enc','previousRec','nextRec','rnNoEncId','jobEncId','jobAgeRelaxation','jobExperienceValidation','jobEducationValidation'));
    }

    public function save_candidate_shortlisting(Request $request, $job_apply_id_enc){

        try{
            $job_apply_id = Helper::decodeId($job_apply_id_enc);
            $postData = $request->post();
            
            if(isset($postData) && !empty($postData)){
                $candidateApplyDetailArr = [];
                if(isset($postData['sl_status']) && !empty($postData['sl_status'])){
                    $candidateApplyDetailArr['shortlisting_status'] = $postData['sl_status'];
                    $candidateApplyDetailArr['is_screened'] = 1;
                    if(isset($postData['hr_add_remarks']) && !empty($postData['hr_add_remarks'])){
                        $candidateApplyDetailArr['hr_additional_remarks'] = $postData['hr_add_remarks'];
                    }
                    CandidatesJobsApply::where('id', $job_apply_id)->update($candidateApplyDetailArr);
                    // if candidate is rejected or provisionaly selected -- start
                    if(isset($postData['hr_remarks']) && !empty($postData['hr_remarks'])){
                        $hr_remarks = $postData['hr_remarks'];
                        if(!empty($hr_remarks)){
                            $candidatesJobHRRemarks = CandidatesJobHRRemarks::where('candidate_job_apply_id', $job_apply_id)
                                                                            ->where('status', 1)    
                                                                            ->get(['candidates_job_hr_remarks.*'])
                                                                            ->toArray();
                            $newIds = []; 
                            $oldIds = [];                                               
                            if(!empty($candidatesJobHRRemarks)){
                                $remarksIds = array_column($candidatesJobHRRemarks, 'remarks_code_id');                                            
                                // new IDs to insert
                                $newIds = array_diff($hr_remarks, $remarksIds);   
                                // old IDs to delete    
                                $oldIds = array_diff($remarksIds, $hr_remarks);  
                                if(!empty($oldIds)){
                                    // mark deleted
                                    CandidatesJobHRRemarks::where('candidate_job_apply_id', $job_apply_id)
                                                            ->where('status', 1)
                                                            ->whereIn('remarks_code_id', $oldIds)    
                                                            ->update(['status' => 3]);
                                }
                            }else{
                                $newIds = $hr_remarks;
                            }                          

                            $batchInsertArr = [];
                            foreach($hr_remarks as $remark){
                                $remarks_id = $remark;
                                $postRemarksArr['candidate_job_apply_id'] = $job_apply_id;
                                $postRemarksArr['remarks_code_id'] = $remarks_id;
                                // push in batch insert array
                                if(!empty($newIds) && in_array($remarks_id, $newIds)){
                                    array_push($batchInsertArr, $postRemarksArr);
                                }
                            }
                            // batch insert
                            if(!empty($batchInsertArr)){
                                CandidatesJobHRRemarks::insert($batchInsertArr);
                            }
                        }
                    }
                    // if candidate is rejected or provisionaly selected -- end
                    return redirect()->back()->withInput()->with('success',"Remarks updated successfully.");
                        
                }
                
            }
                   
        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            DB::rollback();
            // log error in file
            Helper::logErrorInFile($e);
            return redirect()->back()->withInput()->with('error_msg',$errorMsg);
        }    

    }

    public function candidates_export_to_excel($rn_no_EncId="", $jobEncId=""){

        $rn_nos = Rn_no::orderBy('id','desc')->get();
        $positionsArr = [];
        $candidatesList = [];
        $masterData = [];
        if(isset($rn_no_EncId) && !empty($rn_no_EncId)){
            $rnNoId = Helper::decodeId($rn_no_EncId);
            $positionsArr = Jobs::join('code_names','code_names.id','=','jobs.post_id')
                                ->where('rn_no_id', $rnNoId)
                                ->where('jobs.status', 1)
                                ->get(['code_names.*','jobs.id as job_id']);
                            
            if(isset($jobEncId) && !empty($jobEncId)){
                $jobId = Helper::decodeId($jobEncId);
                $selectArray = ['register_candidates.*','candidates_jobs_apply.id as candidate_job_apply_id','candidates_jobs_apply.domain_id','candidates_jobs_apply.category_id','candidates_jobs_apply.application_status','candidates_jobs_apply.total_experience','candidates_jobs_apply.payment_status','candidates_jobs_apply.is_completed','candidates_jobs_apply.age_calculated'];

                
                $candidatesList = CandidatesJobsApply::join('register_candidates','register_candidates.id','=','candidates_jobs_apply.candidate_id')
                                                        ->where('candidates_jobs_apply.job_id', $jobId)
                                                        ->where('candidates_jobs_apply.status', 1)
                                                        ->get($selectArray)->toArray();
                
                // get all code_names join with code_master
                if(!empty($candidatesList)){
                    $masterData = Helper::getCodeNames();  
                }                                   
                                                 
            }                    

        }
        
        // Excel file name for download 
        $fileName = "THSTI_applicant_rec.xls"; 
        
        // Headers for download 
        ob_end_clean(); // this is solution
        //ob_start();
        header("Content-Disposition: attachment; filename=\"$fileName\""); 
        header("Content-Type: application/vnd.ms-excel"); 
        // headings start
        $headArr = [];
        $headArr[0] = "S. NO.";
        $headArr[1] = "FULL NAME";
        $headArr[2] = "FATHER NAME";
        $headArr[3] = "EMAIL";
        $headArr[4] = "MOBILE";
        $headArr[5] = "CATEGORY";
        $headArr[6] = "GENDER";
        $headArr[7] = "AGE";
        $headArr[8] = "EXAM ~ YEAR PASS";
        $headArr[9] = "TOTAL EXPERIENCE";
        $headArr[10] = "PAY STATUS";
        $headArr[11] = "HR REMARKS";
        $headArr[12] = "COMMITTEE REMARKS";

        echo implode("\t", $headArr) . "\n"; 
        // headings end

        // filter caste categories by code from array
        $cast_categories = Helper::getCodeNamesByCode($masterData,'code','cast_categories');
        $cast_categories_ids = array_column($cast_categories, 'id');
        // filter genders by code from array
        $genderArr = Helper::getCodeNamesByCode($masterData,'code','gender');
        $gender_ids = array_column($genderArr, 'id');
        // filter education by code from array
        $educationArr = Helper::getCodeNamesByCode($masterData,'code','education');
        $education_ids = array_column($educationArr, 'id');

        $index = 1;
        
        foreach($candidatesList as $row) { 
            
            // filter data 
            //array_walk($row, 'cleanData'); 
            // candidate academics details start
            $education_fill = "";
            $job_apply_id = $row['candidate_job_apply_id'];
            
            $candidateAcademicsDetails = CandidatesAcademicsDetails::where('candidate_job_apply_id', $job_apply_id)->where('status', 1)->get(['candidates_academics_details.*'])->toArray();  
            if(isset($candidateAcademicsDetails) && !empty($candidateAcademicsDetails)){
                $i = 0;
                foreach($candidateAcademicsDetails as $academicDetails){ 
                    $education_id = $academicDetails['education_id'];
                    $educationIdKey = array_search($education_id, $education_ids);
                    if(isset($educationArr[$educationIdKey]['code_meta_name'])){
                        $educationName = $educationArr[$educationIdKey]['code_meta_name'];
                        if($i > 0){
                            $education_fill .= " ~ ";
                        }
                        $education_fill .= $educationName." - ".$academicDetails['year'];
                    }
                    $i++;
                }
            }
            
            // candidate academics details end
            // HR Remarks start
            $hrRemarks = "";                                                
            $candidatesJobHRRemarks = CandidatesJobHRRemarks::join('apply_job_hr_remarks','apply_job_hr_remarks.id','=','candidates_job_hr_remarks.remarks_code_id')
                                                            ->orderBy('candidates_job_hr_remarks.id','asc')
                                                            ->where('candidate_job_apply_id', $job_apply_id)
                                                            ->where('candidates_job_hr_remarks.status', 1)
                                                            ->get(['apply_job_hr_remarks.code'])
                                                            ->toArray();
            if(!empty($candidatesJobHRRemarks)){
                $hrRemarksCodeArr = array_column($candidatesJobHRRemarks, 'code');
                $hrRemarks = implode(' , ', $hrRemarksCodeArr);
            }      
                                                      
            // HR Remarks end
            // payment status
            $paymentStatus = 'PENDING';
            if($row['payment_status'] == 1){
                $paymentStatus = 'SUCCESS';
            }
            else if($row['payment_status'] == 2){
                $paymentStatus = 'FAILED';
            }
            else{}
            
            // application status
            $applicationStatus = 'PENDING';
            if($row['application_status'] == 1){
                $applicationStatus = 'COMPLETED';
            }

            
            // category
            $categoryName = "";
            if(isset($row['category_id']) && !empty($row['category_id'])){
                $key = array_search($row['category_id'], $cast_categories_ids);
                $categoryName = $cast_categories[$key]['code_meta_name'];
            }
            // gender
            $gender = "";
            if(isset($row['gender']) && !empty($row['gender'])){
                $key = array_search($row['gender'], $gender_ids);
                $gender = $genderArr[$key]['code_meta_name'];
            }
            $dataArray = [];
            $dataArray[0] = $index;
            $dataArray[1] = $row['full_name'];
            $dataArray[2] = $row['father_name'];
            $dataArray[3] = $row['email_id'];
            $dataArray[4] = $row['mobile_no'];
            $dataArray[5] = $categoryName;
            $dataArray[6] = $gender;
            $dataArray[7] = $row['age_calculated'];
            $dataArray[8] = $education_fill;
            $dataArray[9] = $row['total_experience'];
            $dataArray[10] = $paymentStatus;
            $dataArray[11] = $hrRemarks;
            $dataArray[12] = "";

            echo implode("\t", $dataArray) . "\n"; 
            $index++;
        } 
        
        exit;

    }

    



}