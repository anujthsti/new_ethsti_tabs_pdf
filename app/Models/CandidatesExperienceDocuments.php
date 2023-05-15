<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatesExperienceDocuments extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id','job_id','candidate_job_apply_id','candidate_experience_detail_id','folder_name','file_name','status'];
    protected $table = "candidates_experience_documents";
}
