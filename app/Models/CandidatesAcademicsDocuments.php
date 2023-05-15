<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatesAcademicsDocuments extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id','job_id','candidate_job_apply_id','education_id','folder_name','file_name','status'];
    protected $table = "candidates_academics_documents";
}
