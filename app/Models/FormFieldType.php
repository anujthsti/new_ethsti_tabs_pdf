<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormFieldType extends Model
{
    use HasFactory;
    protected $fillable = ['field_type','is_multiple_option','status'];
    protected $table = "form_field_types";


}
