<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatesExperienceDetails extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id','job_id','candidate_job_apply_id','organization_name','designation','nature_of_duties','from_date','to_date','total_experience','pay_level','gross_pay','status'];
    protected $table = "candidates_experience_details";
}
