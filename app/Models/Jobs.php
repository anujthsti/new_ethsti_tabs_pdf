<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;
    protected $table = "jobs";
    protected $fillable = ['rn_no_id','post_id','job_validation_id','job_configuration_id','job_type_id','center_id','payment_mode_id','post_domain_id','apply_start_date','apply_end_date','hard_copy_submission_date','no_of_posts','age_limit','age_limit_as_on_date','phd_document','announcement','alt_text','email_id','is_payment_required','is_permanent','status','exam_shift_id','interview_shift_id'];
}
