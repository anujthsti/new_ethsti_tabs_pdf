<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatesRefreeDetails extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id','job_id','candidate_job_apply_id','refree_name','designation','organisation','email_id','phone_no','mobile_no','status'];
    protected $table = "candidates_refree_details";
}
