<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobValidation extends Model
{
    use HasFactory;
    protected $fillable = ['post_id','is_age_validate','is_exp_tab','is_publication_tab','is_patent_tab','is_research_tab','is_proposal_tab','status'];
    protected $table = "job_validation";

}
