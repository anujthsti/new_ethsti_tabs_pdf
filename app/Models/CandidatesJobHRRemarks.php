<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatesJobHRRemarks extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_job_apply_id','remarks_code_id','status'];
    protected $table = "candidates_job_hr_remarks";

}
