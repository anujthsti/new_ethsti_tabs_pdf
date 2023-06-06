<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatesPHDResearchDetails extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id','job_id','candidate_job_apply_id','is_have_patents','patent_information','is_submitted_research_statement','research_statement','funding_agency','rank','admission_test','fellowship_valid_up_to','is_fellowship_activated','active_institute_name','activation_date','is_exam_qualified','exam_name','exam_score','exam_qualified_val_up_to','no_of_pub','no_of_first_author_pub','no_of_cors_author_pub','no_of_pub_impact_fact','no_of_citations','status','no_patents_filed_national','no_patents_granted_national','no_patents_filed_international','no_patents_granted_international'];
    protected $table = "candidates_phd_research_details";
}
