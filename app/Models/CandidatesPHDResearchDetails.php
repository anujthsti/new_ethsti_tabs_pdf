<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatesPHDResearchDetails extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id','job_id','candidate_job_apply_id','is_have_patents','patent_information','is_submitted_research_statement','research_statement','funding_agency','rank','admission_test','fellowship_valid_up_to','is_fellowship_activated','active_institute_name','activation_date','is_exam_qualified','exam_name','exam_score','exam_qualified_val_up_to','status'];
    protected $table = "candidates_phd_research_details";
}
