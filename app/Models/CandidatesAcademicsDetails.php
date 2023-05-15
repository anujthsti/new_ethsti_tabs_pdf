<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatesAcademicsDetails extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id','job_id','candidate_job_apply_id','education_id','month','year','duration_of_course','degree_or_subject','board_or_university','percentage','cgpa','division','status'];
    protected $table = "candidates_academics_details";
}
