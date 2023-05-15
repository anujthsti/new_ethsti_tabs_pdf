<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobEducationValidation extends Model
{
    use HasFactory;
    protected $fillable = ['post_id','job_validation_id','education_id','status'];
    protected $table = "job_min_education_trans";

}
