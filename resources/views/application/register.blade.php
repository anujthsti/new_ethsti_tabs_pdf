<!-- include header -->
@include('application.header')
@include('application.application_registeration_head')
<?php
$save_url = route('save_registration_details');

?>
<!-- main container start -->
<div class="container-fluid border-top pt-5">                                          
    <div class="text-primary text-center mb-5 h4">Registration Details</div>
    <form id="online-form" name="registration-form" method="post" action="{{ $save_url }}" enctype="multipart/form-data" >        
      @csrf
        <!-- include candidate personal details form -->
        @include('application.candidate_personal_detail_form')  
        <!-- Permanent state, city, pincode section end -->
        <!-- SECURITY CAPTCHA CODE start -->                                                   
        <hr />                 			             
        <div class="form-group row" align="center">            
            <div class="col-12" align="center">		
                <span width="85" id="captcha" height="40" class="mb-1 captcha"/>{{ $captcha_code }}</span>
                <input name="security_code" type="text" autocomplete="off" maxlength="6" id="security_code" style="text-transform:none; margin-top: 10px;" class="form-control col-lg-2 col-md-2 col-sm-2" />
                <span class="btn" id="refresh_security_code"><i class="fa fa-refresh"></i></span>
                <br />
                @error('security_code')
                  <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror           
            </div>
            <div class="col-12" align="center">
                <input class="btn btn-success col-lg-2 col-md-2 col-sm-5"  id="submit" name="submit" type="submit" value="Verify and Submit"/>
            </div>                
        </div>    
        <!-- SECURITY CAPTCHA CODE end -->       
            
    <!-- end of registration form -->  
    </form>                                                   
 </div> 
</div> 
<!-- main container end -->

<!-- include footer -->
@include('application.footer')
