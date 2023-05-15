<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatesJobsApply extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id','rn_no_id','job_id','domain_id','appointment_method_id','is_ex_serviceman','is_esm_reservation_avail','is_govt_servent','type_of_employment','type_of_employer','is_pwd','category_id','marital_status','application_status','trainee_category_id','institute_name','is_experience','total_experience','age_calculated','is_publication','relative_name','relative_designation','relative_relationship','data_status','file_status','payment_status','is_completed','is_screened','shortlisting_status','hr_additional_remarks','status'];
    protected $table = "candidates_jobs_apply";
}
