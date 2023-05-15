<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatesPublicationsDetails extends Model
{
    use HasFactory;
    protected $fillable = ['candidate_id','job_id','candidate_job_apply_id','publication_number','authors','article_title','journal_name','year_volume','doi','pubmed_pmid','status'];
    protected $table = "candidates_publications_details";
}
