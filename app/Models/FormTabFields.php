<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormTabFields extends Model
{
    use HasFactory;
    protected $fillable = ['field_name','field_slug','form_tab_id','sort_order','status'];
    protected $table = "form_tab_fields";

}
