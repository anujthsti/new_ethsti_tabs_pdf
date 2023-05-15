<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormFieldsConfiguration extends Model
{
    use HasFactory;
    protected $fillable = ['form_config_id','form_tab_field_id','is_tab_field','status'];
    protected $table = "form_fields_configuration";

}
