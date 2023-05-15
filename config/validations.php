<?php
return [
     'name'=>'required|max:255',
     'email'=>'required|max:255|email',
     'email_optional'=>'max:255|email',
     'address' => 'required|max:255',
     'unique' => 'required|unique',
     'required' => 'required',
     'numeric' => 'numeric'
];
?>