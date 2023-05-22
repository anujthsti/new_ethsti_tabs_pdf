<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatesJobsApply extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id','rn_no_id','job_id','domain_id','appointment_method_id','is_ex_serviceman','is_esm_reservation_avail','is_govt_servent','type_of_employment','type_of_employer','is_pwd','category_id','marital_status','application_status','trainee_category_id','institute_name','is_experience','total_experience','age_calculated','is_publication','relative_name','relative_designation','relative_relationship','is_basic_info_done','is_qualification_exp_done','is_phd_details_done','is_document_upload_done','is_final_submission_done','is_payment_done','payment_status','is_completed','is_screened','shortlisting_status','hr_additional_remarks','details_pdf_name','pay_receipt_pdf_name','is_after_payment_mail_sent','status'];
    protected $table = "candidates_jobs_apply";
}
