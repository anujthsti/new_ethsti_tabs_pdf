<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatesCommonDocuments extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id','job_id','candidate_job_apply_id','folder_name','category_certificate','esm_certificate','pwd_certificate','candidate_photo','candidate_sign','fellowship_certificate','exam_qualified_certificate','id_card','age_proof','noc_certificate','stmt_proposal','candidate_cv','listpublication','publication','project_proposal','status'];
    protected $table = "candidates_common_documents";
}
