<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeNames extends Model
{
    use HasFactory;
    protected $fillable = ['code_id','code_meta_name','code'];
    protected $table = "code_names";


}
