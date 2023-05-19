<!-- include header -->
@include('application.header')
@include('application.application_registeration_head')
<?php
$save_url = route('save_registration_details');
$rn_no_id = $jobData[0]['rn_no_id'];
$job_title = $jobData[0]['code_meta_name'];
$rn_no = $jobData[0]['rn_no'];
$apply_end_date = $jobData[0]['apply_end_date'];
$job_type_id = $jobData[0]['job_type_id'];

$masterCode = 'job_types';
$codeMetaCodeArr = ['train_program'];
$jobTypeIDs = Helper::getCodeNamesIdsByCodes($masterCode, $codeMetaCodeArr);
$jobTitleLabel = "Post Applied For";
if(in_array($job_type_id, $jobTypeIDs)){
    $jobTitleLabel = "Training Applied For";
}

$is_register_form = 1;
?>

<!-- main container start -->
<div class="container-fluid border-top pt-5">                                          
    <div class="text-primary text-center mb-5 h4">Registration Details</div>
    <form id="online-form" name="registration-form" method="post" action="{{ $save_url }}" enctype="multipart/form-data" >        
      @csrf
        <!-- hidden fields-->      		       
        <input name="rn_no_id" type="hidden" value="{{ $rnNoId }}" readonly="readonly" id="rn_id" />
        <input name="job_id" type="hidden" value="{{ $jobId }}" readonly="readonly" id="rn_id" />
        <!-- Autofetched Details-->                       
      <div class="row">       
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="form-group">     
            <label for="staticrn_no" class="form-label">RN No.</label>
            <input type="text" readonly class="form-control" id="staticrn_no" value="{{ $rn_no }}" required="" />   
          </div>
        </div> 
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="form-group">    
            <label for="staticrn_job_title" class="form-label">{{ $jobTitleLabel }}</label> 
            <input type="text" readonly class="form-control" id="staticrn_job_title" value="{{ $job_title }}" required=""  />
          </div>
        </div>   
      </div>
        <!-- include candidate personal details form -->
        @include('application.candidate_personal_detail_form')  
        <!-- Permanent state, city, pincode section end -->
        <!-- SECURITY CAPTCHA CODE start -->                                                   
        <hr />                 			             
        <div class="form-group row" align="center">            
            <div class="col-12" align="center">	
              <?php /* ?>	
                <span width="85" id="captcha" height="40" class="mb-1 captcha"/>{{ $captcha_code }}</span>
                <input name="security_code" type="text" autocomplete="off" maxlength="6" id="security_code" style="text-transform:none; margin-top: 10px;" class="form-control col-lg-2 col-md-2 col-sm-2" />
                <span class="btn" id="refresh_security_code"><i class="fa fa-refresh"></i></span>
                <br />
                @error('security_code')
                  <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror  
                <?php */ ?>  
                <a href="javascript:void(0);" id="getEmailOtp" class="btn btn-success">Get Email OTP</a> 
                <!-- loader html start -->
                <div id="loader"></div>
                <!-- loader html end -->
                <input name="email_otp" type="text" autocomplete="off" id="email_otp" style="text-transform:none; margin: 10px;" class="form-control col-lg-2 col-md-2 col-sm-2" placeholder="Enter Email OTP" />
                @error('email_otp')
                  <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror      
            </div>
            <div class="form-group col-12" align="center">
              <input class="btn btn-primary col-lg-2 col-md-2 col-sm-3" id="draft" type="button" value="Verify Form" />&nbsp;
              <input class="btn btn-success col-1" style="display:none;" id="update" name="update" type="submit" value="Update" onclick="disableSubmitButton();" />
            </div>               
        </div>    
        <!-- SECURITY CAPTCHA CODE end -->       
            
    <!-- end of registration form -->  
    </form>                                                   
 </div> 
</div> 
<!-- main container end -->
<script>
  //saving data as draft and verify start
  $('#draft').click(function(){
    
      var isvalid = true;
      var datavalid = true;			 	  	 	 			   	  	 	 	 	 
      $('#domain_area_id').trigger('change');	 	 
      $('input[type="text"]:visible,input[type="date"]:visible, input[type="email"]:visible, input[type="radio"]:visible, input[type="number"]:visible, input[type="file"]:visible, select:visible, textarea:visible').each(function(){												  	 
          if($(this).val()==''){	
              isvalid=false;		 	 	 	  		
              $(this).css({"border":"2px solid red"});		 
              $(this).focus();		
              return false;			 
          }else{			 				  			
              $(this).css({"border":""}); 
              isvalid=true; 			   
          }	 					 	  
      });	
      
      // course duration validation
      $('.duration_of_course:visible').each(function(){
            if($(this).val()=='')
            {
                isvalid = false; 	
                alert("Enter the value");
                $(this).focus();
                datavalid = false;
                return false;
            }else{
                isvalid=true; 	
            }			
      });
      
      if(isvalid==true){			
          var code_check=$('#captcha_error_check').val();
          //var exp_tick=$('.exp_check').val();
          var exp_tick = $('input[name=exp_check]:checked').val();
          //alert(exp_tick);
          var exp_check=$('#exp_error_check').val();
          var required_exp=$('#required_exp').val();	
          		   
          if(code_check==0){
              datavalid=false;		 	 	 	  		
              $('#security_code').css({"border":"2px solid red"});		 
              $('#security_code').focus();		
              return false;
          }
          else if(exp_tick==1){

              
              // check if column is empty or not
              $('.exp_gross').each(function(){
                //console.log("val: "+$(this).val());
                    if($(this).val() == 0 || $(this).val() == "") {
                        isvalid=false; 	
                        alert("Enter the value");
                        $(this).focus();
                        datavalid=false; 
                        return false; 
                    }else{
                        isvalid=true; 	
                    }
              });
              
              /*
              var exp_check=$('#exp_error_check').val();		  
              var required_exp=$('#required_exp').val();	
              if(exp_check==0 && required_exp>0){
                  datavalid=false;		 	 	 	  						 		 							  
                  $('#exp_error').html('*Your experience is less than the required experience for this position.');			 
                  $('#exp_grand_total').css({"border":"2px solid red"});
                  $('#exp_grand_total').focus();		
                  return false;			
              }else{ 
                  datavalid=false; 
                  return false; 
              }
              */
          }
          else{  
              datavalid=true;  
          }
      }
      
      if(datavalid==true && isvalid==true){ 						  
          $('#draft').hide();
          var app_id = $('#app_id').val();
          if(app_id!=''){	
              $('#update').show(); 
          }
          else{ 
              $('#submit').show(); 
          }
          alert("Your form has been verified!!!!");	  
          return true;	
      }
  });


  //form submit
  $('#online-form').submit(function(){			
      var ans=confirm("Do you want to submit?");	
      if(ans){  
          return true; 
      }else{  
          return false; 
      }	
  });

  // hide submit button after click on it
  function disableSubmitButton()
  {
    $(this).hide();
  }

</script>
<!-- include footer -->
@include('application.footer')
