<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobExperienceValidation extends Model
{
    use HasFactory;
    protected $fillable = ['post_id','job_validation_id','education_id','years','status'];
    protected $table = "job_min_experience_trans";

}
