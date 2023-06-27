<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rn_no extends Model
{
    use HasFactory;
    protected $fillable = ['rn_no','rn_type_id','sequence_no','rn_document','status','ths_rn_type_id','year','month','cycle','emails_to'];
    protected $table = "rn_nos";
}
