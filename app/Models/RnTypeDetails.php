<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RnTypeDetails extends Model
{
    use HasFactory;
    protected $fillable = ['rn_type_id','prefix','suffix','sequence_start_from','status'];
    protected $table = "rn_type_details";

}
