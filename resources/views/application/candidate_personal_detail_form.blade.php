<?php
$apply_end_date = $jobData[0]['apply_end_date'];
$job_type_id = $jobData[0]['job_type_id'];

$domain_area_id = old('domain_area');
$method_of_appointment = old('method_of_appointment');
$email_id = old('email_id');
$mobile_no = old('mobile_no');
$salutation_id = old('salutation');
$full_name = old('full_name');
$father_name = old('father_name');
$mother_name = old('mother_name');
$dob = old('dob');
$gender_id = old('gender');
$esm_check = old('esm_check');
$is_esm_reservation_avail = old('is_esm_reservation_avail');
$is_govt_servent = old('is_govt_servent');
$type_of_employment = old('type_of_employment');
$type_of_employer = old('type_of_employer');

$pwd_check = old('pwd_check');
//$category = old('category');
$cast_category = old('cast_category');
$trainee_category = old('trainee_category');
$nationality = old('nationality');
$nationality_type = old('nationality_type');
$institute_name = old('institute_name');
$correspondes_address = old('correspondes_address');
$present_state = old('present_state');
$present_city = old('present_city');
$present_pincode = old('present_pincode');
$permanent_address = old('permanent_address');
$permanent_state = old('permanent_state');
$permanent_city = old('permanent_city');
$permanent_pincode = old('permanent_pincode');
$marital_status = old('marital_status');
$date_of_release = old('date_of_release');

if(isset($candidateJobApplyDetail) && !empty($candidateJobApplyDetail)){
    $candidateDetails = $candidateJobApplyDetail[0];
    $domain_area_id = $candidateDetails['domain_id'];
    $method_of_appointment = $candidateDetails['appointment_method_id'];
    $email_id = $candidateDetails['email_id'];
    $mobile_no = $candidateDetails['mobile_no'];
    $salutation_id = $candidateDetails['salutation'];
    $full_name = $candidateDetails['full_name'];
    $father_name = $candidateDetails['father_name'];
    $mother_name = $candidateDetails['mother_name'];
    $dob = $candidateDetails['dob'];
    if(!empty($dob)){
        $dob = date('Y-m-d', strtotime($dob));
    }
    $gender_id = $candidateDetails['gender'];
    $esm_check = $candidateDetails['is_ex_serviceman'];
    $is_esm_reservation_avail = $candidateDetails['is_esm_reservation_avail'];
    $date_of_release = $candidateDetails['date_of_release'];
    $is_govt_servent = $candidateDetails['is_govt_servent'];
    $type_of_employment = $candidateDetails['type_of_employment']; 
    $type_of_employer = $candidateDetails['type_of_employer'];

    $pwd_check = $candidateDetails['is_pwd'];
    //$category = old('category');
    $cast_category = $candidateDetails['category_id'];
    $trainee_category = $candidateDetails['trainee_category_id'];
    $nationality = $candidateDetails['nationality'];
    $nationality_type = $candidateDetails['nationality_type'];
    $institute_name = $candidateDetails['institute_name'];
    $correspondes_address = $candidateDetails['correspondence_address'];
    $present_state = $candidateDetails['cors_state_id'];
    $present_city = $candidateDetails['cors_city'];
    $present_pincode = $candidateDetails['cors_pincode'];
    $permanent_address = $candidateDetails['permanent_address'];
    $permanent_state = $candidateDetails['perm_state_id'];
    $permanent_city = $candidateDetails['perm_city'];
    $permanent_pincode = $candidateDetails['perm_pincode'];
    $marital_status = $candidateDetails['marital_status'];
}

$typeOfEmployerArr = Helper::getCodeNamesByMasterCode('type_of_employer');
?>
      
      <div class="row">
        <!-- domain area start --> 
        @if(!empty($fieldsArray) && in_array('domain_area', $fieldsArray))
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="form-group">
            <label for="domain_area_id" class="form-label" >Domain</label>
            <select name='domain_area' id='domain_area_id' class="form-control" required="">  		 
                <option value="">Select Domain</option>
                @foreach($domainAreas as $domainArea)
                    <?php
                    $selected = "";
                    if($domain_area_id == $domainArea->id){
                      $selected = "selected=selected";
                    }
                    ?>
                    <option value="{{ $domainArea->id }}" {{ $selected }}>{{ $domainArea->code_meta_name }}</option>
                @endforeach
            </select>     
            @error('domain_area')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
          </div>          
        </div>
        @endif
        <!-- domain area end -->

        <!-- method of appointment start -->
        <!-- data from code_names table -->
        @if(!empty($fieldsArray) && in_array('method_of_appointment', $fieldsArray))
        <?php
          // method of appointments
          // filter methods of appointments by code from array
          $methodOfAppointments = Helper::getCodeNamesByCode($codeNamesArr,'code','method_of_appointment');
        ?>
        <!-- row start -->
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="form-group">
            <label for="method" class="form-label" >Method of Appointment</label>
            <select name='method_of_appointment' id='method_id' class="form-control" required="" />  		 
                <option value="">Select Method</option>
                @foreach($methodOfAppointments as $method)  
                  <?php
                  $selected = "";
                  if($method_of_appointment == $method['id']){
                    $selected = "selected";
                  }
                  ?>
                  <option value="{{ $method['id'] }}" {{ $selected }}>{{ $method['code_meta_name'] }}</option>
                @endforeach
            </select> 
            @error('method_of_appointment')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror    
          </div>          
        </div>
        @endif
        <!-- method of appointment end -->
      </div>  

      <hr>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <h4>Contact Details</h4>
        </div>
      </div>
       
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="form-group">
            <label for="email_id" class="form-label" >Email ID </label>
            <input class="form-control" name="email_id" id="email_id" value="{{ $email_id }}"  type="email" autocomplete="off" required="" maxlength="100" />  
            @error('email_id')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror 
          </div>
        </div>  
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="form-group">
            <label for="mobile" class="form-label">Mobile no. </label>
            <input class="form-control" name="mobile_no" id="mobile_no" value="{{ $mobile_no }}" autocomplete="off"  type="number" maxlength="10" required="" />     
            @error('mobile_no')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror  
          </div>    
        </div> 
      </div>  	           
      
      <hr>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <h4>Personal Details</h4>
        </div>
      </div>
      
      <div class="row">
        <!-- Personal Information Section -->
        <!-- name start -->
        <!-- data from code_names table -->
        @if(!empty($fieldsArray) && in_array('full_name', $fieldsArray))
        <?php
          // filter salutations by code from array
          $salutations = Helper::getCodeNamesByCode($codeNamesArr,'code','salutation');
        ?>
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="form-group">
            <label for="full_name" class="form-label">Full Name <b>(as per the matriculation certificate)</b></label>
            <div class="row">
              <div class="col-xs-3 col-sm-3 col-md-3">
                <select name='salutation' id='salutation' class="form-control" required="">  		 
                  <option value="" selected>SELECT</option>               
                  @foreach($salutations as $salutation)
                  <?php
                      $selected = "";
                      if($salutation_id == $salutation['id']){
                        $selected = "selected";
                      }
                      ?>
                      <option value="{{ $salutation['id'] }}" {{ $selected }}>{{ $salutation['code_meta_name'] }}</option>
                  @endforeach
                </select>
              </div>  
              <!-- full name field -->
              <div class="col-xs-9 col-sm-9 col-md-9">
                <input class="form-control" id="full_name" name="full_name" value="{{ $full_name }}" autocomplete="off" type="text" placeholder="Full Name" required=""/>
                @error('full_name')
                  <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror 
              </div>  
            </div>  
          </div>  
        </div>   
        @endif     
        <!-- name end -->   
        <!-- father & mother names fields start -->   
        @if(!empty($fieldsArray) && (in_array('fathers_name', $fieldsArray) || in_array('mothers_name', $fieldsArray)))
        
          @if(in_array('fathers_name', $fieldsArray))
          <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="form-group">       
              <label for="father_name" class="form-label">Father's Name </label>
              <input class="form-control" id="father_name" name="father_name" value="{{ $father_name }}" type="text" autocomplete="off" maxlength="100" required="" />
              @error('father_name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
            </div>  
          </div>
          @endif
          @if(in_array('mothers_name', $fieldsArray))
          <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="form-group">
              <label for="mother_name" class="form-label">Mother's Name </label>
              <input class="form-control" id="mother_name" name="mother_name" value="{{ $mother_name }}" type="text" autocomplete="off" maxlength="100" required="" />
              @error('mother_name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
            </div>  
          </div>
          @endif      
        
        @endif
        <!-- father & mother names fields end -->     
        <!-- dob & age fields start -->    
        @if(!empty($fieldsArray) && in_array('date_of_birth', $fieldsArray))
        <div class="col-xs-12 col-sm-12 col-md-4">
          <div class="form-group">
            <label for="dob_id" class="form-label">
              <?php $applyEndDate = Helper::convertDateYMDtoDMY($apply_end_date); ?>
              Date of Birth (as on {{ $applyEndDate }} 
              <input id="last_dt" name="as_on_date" value="{{ $apply_end_date }}" type="hidden"/>)  
            </label>
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-6">
                <input required="" class="form-control" name="dob" type="date" id="dob_id" value="<?php echo $dob; ?>" placeholder="DD-MM-YYYY" />
                @error('dob')
                  <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-xs-12 col-sm-12 col-md-6">
                <input required="" class="form-control" name="age" type="text" id="age_id" value="" readonly="readonly" placeholder="age" disabled />  
              </div>  
            </div>  
          </div>      
        </div>  
        @endif
        <!-- dob & age fields end -->        
        
          @if(!empty($fieldsArray) && in_array('gender', $fieldsArray))   
          <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="form-group">
              <?php
              // filter cast categories by code from array
              $genderArr = Helper::getCodeNamesByCode($codeNamesArr,'code','gender');
              ?>    
              <label class="form-label">Gender</label><br>
              @foreach($genderArr as $gender)  
              <label class="radio-inline">
                <input type="radio" name="gender" value="{{ $gender['id'] }}" <?php echo ($gender_id==$gender['id'])?'checked':''; ?> >
                {{ $gender['code_meta_name'] }}
              </label>
              @endforeach
              @error('gender')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
            </div>  
          </div>    
          @endif

          <!-- marital status start -->
          <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="form-group">
              <label class="form-label">Marital Status</label><br>
              <select class="form-control" name="marital_status">
                <option value="">Select Marital Status</option>
                <option value="1" <?php if($marital_status == 1){ echo "selected"; } ?>>Single</option>
                <option value="2" <?php if($marital_status == 2){ echo "selected"; } ?>>Married</option>
                <option value="3" <?php if($marital_status == 3){ echo "selected"; } ?>>Divorced</option>
              </select>
              @error('marital_status')
                <div class="alert alert-danger mt-1 mb-1">{{ $marital_status }}</div>
              @enderror
            </div>  
          </div>             
          <!-- marital status end -->
          @if(!empty($fieldsArray) && in_array('ex-servicemen', $fieldsArray)) 
          <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="form-group">
              <label for="esm_check" class="form-label">Ex-Servicemen?</label><br>
              <label class="radio-inline">
                <input name="esm_check" class="esm_check" type="radio" value="0" required="" <?php echo ($esm_check==0)?'checked':''; ?> />
                No
              </label>
              <label class="radio-inline">
                <input name="esm_check" class="esm_check" type="radio" value="1" required="" <?php echo ($esm_check==1)?'checked':''; ?> />
                Yes
              </label>
            </div> 
            @error('esm_check')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-xs-12 col-sm-12 col-md-4 is_esm_reservation_avail_div">
              <label for="esm_check" class="form-label">Date of release</label><br>
              <input required="" class="form-control" name="date_of_release" type="date" id="date_of_release" value="<?php echo $date_of_release; ?>" placeholder="DD-MM-YYYY" />
          </div>
          <!-- Is Ex-serviceman reservation avail start -->
          <div class="col-xs-12 col-sm-12 col-md-4 is_esm_reservation_avail_div">
            <div class="form-group">
              <label for="esm_check" class="form-label">Have you avail the reservation available to ESM in civil side?</label><br>
              <label class="radio-inline">
                <input name="is_esm_reservation_avail" class="is_esm_reservation_avail" type="radio" value="0" required="" <?php echo ($is_esm_reservation_avail==0)?'checked':''; ?> />
                No
              </label>
              <label class="radio-inline">
                <input name="is_esm_reservation_avail" class="is_esm_reservation_avail" type="radio" value="1" required="" <?php echo ($is_esm_reservation_avail==1)?'checked':''; ?> />
                Yes
              </label>
            </div> 
            @error('esm_check')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
          </div>
          <!-- Is Ex-serviceman reservation avail end -->
          @endif
          
          @if(!empty($fieldsArray) && in_array('person_with_disability', $fieldsArray)) 
          <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="form-group">
              <label for="pwd_check" class="form-label">Person with disability?</label> <br>
              <label class="radio-inline">
                <input name="pwd_check" class="pwd_check" type="radio" value="0" required=""  <?php echo ($pwd_check==0)?'checked':''; ?> />
                No
              </label>
              <label class="radio-inline">
                <input name="pwd_check" class="pwd_check" type="radio" value="1" required="" <?php echo ($pwd_check==1)?'checked':''; ?> />
                Yes
              </label>        
            </div>       
            @error('pwd_check')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror   
          </div>  
          @endif
          @if(!empty($fieldsArray) && in_array('category', $fieldsArray))    
          <?php
            // filter cast categories by code from array
            $castCategories = Helper::getCodeNamesByCode($codeNamesArr,'code','cast_categories');
            // get PHD JobTypeId
            $pHD_jobTypeIdArr = Helper::getCodeNamesByCode($codeNamesArr, 'meta_code', 'phd_students');
            $pHD_jobTypeId = "";
            if(!empty($pHD_jobTypeIdArr)){
                $pHD_jobTypeId = $pHD_jobTypeIdArr[0]['id'];
            }
          ?>
          <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="form-group">
              <label for="category" class="form-label" >Category</label><br>      
              @foreach($castCategories as $castCategory)     
                <?php 
                $showCheckbox = 1;
                if($castCategory['meta_code'] && $job_type_id == $pHD_jobTypeId){ 
                  $showCheckbox = 0;
                }
                ?>
                @if($showCheckbox == 1)
                <label class="radio-inline">
                  <input name="cast_category" type="radio" value="{{ $castCategory['id'] }}" class="category" required=""  <?php echo ($cast_category==$castCategory['id'])?'checked':''; ?> />
                  {{ $castCategory['code_meta_name'] }}
                </label>
                @endif
              @endforeach    
            </div> 
            @error('cast_category')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror              
          </div>   
          @endif
          @if(!empty($fieldsArray) && in_array('traineecategory', $fieldsArray))
          <?php
            // filter cast categories by code from array
            $traineeCategories = Helper::getCodeNamesByCode($codeNamesArr,'code','trainee_category');
          ?>
          <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="form-group">
              <label for="trainee_category" class="form-label" >Trainee Category</label><br>       
              @foreach($traineeCategories as $traineeCat)       
              <label class="radio-inline">
                  <input name="trainee_category" type="radio" value="{{ $traineeCat['id'] }}"  class="trainee_category" required="" <?php echo ($trainee_category==$traineeCat['id'])?"checked":''; ?> />
                  {{ $traineeCat['code_meta_name'] }}
              </label>
              @endforeach
            </div>   
            @error('trainee_category')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror              
          </div>    
          @endif      
          
        </div>   
        <!-- row end -->
      @if(!empty($fieldsArray) && in_array('isgovtservent', $fieldsArray)) 
      <div class="row">
          <!-- Is govt servent start -->
          <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="form-group">
              <label for="is_govt_servent" class="form-label">Are you a govt. servent?</label> <br>
              <label class="radio-inline">
                <input name="is_govt_servent" class="is_govt_servent" type="radio" value="0" required=""  <?php echo ($is_govt_servent==0)?'checked':''; ?> />
                No
              </label>
              <label class="radio-inline">
                <input name="is_govt_servent" class="is_govt_servent" type="radio" value="1" required="" <?php echo ($is_govt_servent==1)?'checked':''; ?> />
                Yes
              </label>        
            </div>       
          </div>  
          <!-- Is govt servent end -->
          <!-- type of employment start -->
          <div class="col-xs-12 col-sm-12 col-md-4 type_of_employment_div">
            <div class="form-group">
              <label for="type_of_employment" class="form-label">Type of employment</label> <br>
              <label class="radio-inline">
                <input name="type_of_employment" class="type_of_employment" type="radio" value="1" <?php echo ($type_of_employment==1)?'checked':''; ?> />
                Permanent
              </label>
              <label class="radio-inline">
                <input name="type_of_employment" class="type_of_employment" type="radio" value="2" <?php echo ($type_of_employment==2)?'checked':''; ?> />
                Temporary
              </label>        
            </div>       
          </div>      
          <!-- type of employment end -->
          <!-- type of employer start -->
          <div class="col-xs-12 col-sm-12 col-md-4 type_of_employer_div">
            <div class="form-group">
              <label for="domain_area_id" class="form-label" >Type of employer</label>
              <select name='type_of_employer' id='type_of_employer' class="form-control type_of_employer">  		 
                  <option value="">Select Employer Type</option>
                  @foreach($typeOfEmployerArr as $typeOfEmployer)
                      <?php
                      $selected = "";
                      if($type_of_employer == $typeOfEmployer['id']){
                        $selected = "selected=selected";
                      }
                      ?>
                      <option value="{{ $typeOfEmployer['id'] }}" {{ $selected }}>{{ $typeOfEmployer['code_meta_name'] }}</option>
                  @endforeach
              </select>     
            </div> 
          </div>      
          <!-- type of employer end -->
      </div>
      @endif
      <div class="row">          
        <!-- nationality section start -->
        @if(!empty($fieldsArray) && in_array('nationality', $fieldsArray))
        <div class="col-xs-12 col-sm-12 col-md-2 nationality_type_div">
            <div class="form-group">
              <label for="nationality_type" class="form-label">Nationality</label> <br>
              <label class="radio-inline">
                <input name="nationality_type" class="nationality_type" type="radio" value="1" <?php echo ($nationality_type==1)?'checked':''; ?> />
                Indian
              </label>
              <label class="radio-inline">
                <input name="nationality_type" class="nationality_type" type="radio" value="2" <?php echo ($nationality_type==2)?'checked':''; ?> />
                Other
              </label>        
            </div>       
        </div> 
        <?php
        $countryNameDisplay = "";
        if(isset($nationality_type) && !empty($nationality_type) && $nationality_type == 1){
          $countryNameDisplay = "display:none;";
        }
        ?>
        <div class="col-xs-12 col-sm-12 col-md-4 country_name" style="<?php echo $countryNameDisplay; ?>">
          <div class="form-group">
            <label for="nationality" class="form-label" >Country Name</label>
            <input class="form-control" name="nationality" autocomplete="off" type="text" maxlength="100" value="<?php echo ($nationality)?$nationality:''; ?>"  />
            @error('nationality')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror  
          </div>
        </div>
        @endif      
        <!-- nationality section end -->

        <!-- Institute name & address start -->
        <?php
        // get job_type train_program id
        $train_program_idArr = Helper::getCodeNamesByCode($codeNamesArr, 'meta_code', 'train_program');
        $train_program_id = "";
        if(!empty($train_program_idArr)){
            $train_program_id = $train_program_idArr[0]['id'];
        }
        if($job_type_id == $train_program_id){
        ?>
        <div class="col-xs-12 col-sm-12 col-md-6">
          <div class="form-group">
            <label for="institute_add" class="form-label" >Institute Name and address </label>
            <input class="form-control" name="institute_name" autocomplete="off" type="text" required=""  value="<?php echo ($institute_name)?$institute_name:''; ?>"  />
            @error('institute_name')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror  
          </div>
        </div>
        <?php } ?>
        <!-- Institute name & address end -->
      </div>    
      
      <!-- Correspondence address start -->  
      @if(!empty($fieldsArray) && in_array('correspondence_address', $fieldsArray))
      <hr>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <h4>Address Details</h4>
        </div>
      </div>
      
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3">
          <div class="form-group">
            <label for="ca" class="form-label" >Correspondence Address</label>
            <textarea  class="form-control" name="correspondes_address" id="ca"  style="resize:vertical; height:50px;"  autocomplete="off" required="">{{ $correspondes_address }}</textarea>
            @error('correspondes_address')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror              
          </div>
        </div>
        <!-- Correspondence address end -->
        <!-- Correspondence state, city, pincode section start -->
        <div class="col-xs-12 col-sm-12 col-md-3">
          <div class="form-group">
            <!-- states dropdown start -->
            <?php
            $statesArr = Helper::getCodeNamesByCode($codeNamesArr, 'code', 'states');
            ?>
            <label for="present_state" class="form-label">State</label>
            <select class="form-control" name="present_state" id="present_state" required="" />                                  	 
                <option value="" selected>SELECT STATE</option>
                @foreach($statesArr as $state)
                <?php
                $stateSelected = "";
                if($state['id'] == $present_state){
                  $stateSelected = "selected=selected";
                }
                ?>
                <option value="{{ $state['id'] }}" <?php echo $stateSelected; ?> >{{ $state['code_meta_name'] }}</option>        
                @endforeach           
            </select>
            @error('present_state')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror     
          </div>
        </div>   
        <!-- states dropdown end -->    
        <!-- city field start -->
        <div class="col-xs-12 col-sm-12 col-md-3">
          <div class="form-group">
            <label for="present_city" class="form-label">City</label>
            <input class="form-control" name="present_city" id="present_city"  autocomplete="off" required="" value="<?php echo $present_city; ?>" /> 
            @error('present_city')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror                                   
          </div>
        </div> 
        <!-- city field end -->
        <!-- pincode field start -->
        <div class="col-xs-12 col-sm-12 col-md-3">
          <div class="form-group">
            <label for="present_pincode" class="form-label">Pincode</label>
            <input class="form-control" name="present_pincode" id="present_pincode" type="number" maxlength="6" autocomplete="off" required="" value="<?php echo $present_pincode; ?>" />
            @error('present_pincode')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror                        
          </div>
        </div>
        <!-- pincode field end -->
      </div>  
      <!-- Correspondence state, city, pincode section end -->
      @endif
        
      <!-- checkbox to make same permanent address start -->  
      @if(!empty($fieldsArray) && in_array('permanent_address', $fieldsArray))  
        <?php
        $sameAddressChecked = "";
        if(!empty($correspondes_address) && $permanent_address == $correspondes_address){
            $sameAddressChecked = "checked";
        }
        ?>
        <div class="row">  
          <div class="form-group col-xs-12 col-sm-12 col-md-12">
            <label for="" class="" >Same as Above </label>
            <input type="checkbox" id="same_id" add="same_id" name="same_add" {{ $sameAddressChecked }}/>
          </div>
        </div>  
      @endif
      <!-- checkbox to make same permanent address end -->  
        
      @if(!empty($fieldsArray) && in_array('permanent_address', $fieldsArray))  
      <div class="row">
        <!-- permanent address start -->      
        <div class="col-xs-12 col-sm-12 col-md-3">
          <div class="form-group ">
            <label for="pa" class="form-label" >Permanent Address</label>
            <textarea class="form-control" name="permanent_address" id="pa" style="resize:vertical; height:50px;" autocomplete="off" required="" >{{ $permanent_address }}</textarea>
            @error('permanent_address')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <!-- permanent address end -->
            
        <!-- Permanent state, city, pincode section start -->
        <div class="col-xs-12 col-sm-12 col-md-3">
          <!-- Permanent state section start -->
          <div class="form-group ">
            <label for="permanent_state" class="form-label">State</label>
            <select class="form-control" name="permanent_state" id="permanent_state" required="" />                                  	 
                <option value="" selected>SELECT</option>
                @foreach($statesArr as $cState)
                <?php
                $cStateSelected = "";
                if($cState['id'] == $permanent_state){
                  $cStateSelected = "selected=selected";
                }
                ?>
                <option value="{{ $cState['id'] }}" <?php echo $cStateSelected; ?> >{{ $cState['code_meta_name'] }}</option>        
                @endforeach             
            </select>
            @error('permanent_state')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
          </div>  
        </div>
        <!-- Permanent state section end -->
        <!-- Permanent city section start -->
        <div class="col-xs-12 col-sm-12 col-md-3">
          <div class="form-group ">
            <label for="permanent_city" class="form-label">City</label>
            <input class="form-control" name="permanent_city" id="permanent_city"  autocomplete="off" required="" value="{{ $permanent_city }}" />
            @error('permanent_city')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror    
          </div>  
        </div>                                
        <!-- Permanent city section end -->
        <!-- Permanent pincode section start -->
        <div class="col-xs-12 col-sm-12 col-md-3">
          <div class="form-group ">
            <label for="permanent_pincode" class="form-label">Pincode</label>
            <input class="form-control" name="permanent_pincode" id="permanent_pincode" type="number" maxlength="6"  autocomplete="off" required="" value="{{ $permanent_pincode }}" />
            @error('permanent_pincode')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
          </div>
        </div>                                  
        <!-- Permanent pincode section end -->    
        </div>
      @endif

<script>
  
  //remove special charcter and make upper case
  var r={'special':/[\W]/g}
  function valid(o,w){ 
    o.value = o.value.replace(/[^a-z0-9@.,_-\s]/gi, '').toUpperCase();  
  }

  //update pa from ca
  $('#same_id').click(function(){				
	  if($('#same_id').is(':checked')){ 
            $('#pa').val($('#ca').val()); 
            let present_city = $('#present_city').val();
            let present_pincode = $('#present_pincode').val();
            var present_state = $('#present_state').find(":selected").val();
            $('#permanent_city').val(present_city);
            $('#permanent_pincode').val(present_pincode);
            $('#permanent_state option[value="'+present_state+'"]').attr("selected", "selected");
      }
	  else{  
            $('#pa').val(''); 
            $('#permanent_city').val('');
            $('#permanent_pincode').val('');
      }										
  });	
	
  //get age as on date
  $('#dob_id').change(function(){		  
      $('#age_id').val(''); 		
      var dob=$('#dob_id').val();		  
      var as_on_date=$('#last_dt').val();	
      getCalculatedAge(dob,as_on_date);	
  });


  $('#age_id').click(function(){	  
	  $('#dob_id').trigger('change');
  });   		

  $(document).ready(function(){
      $('#dob_id').trigger('change');

      @if($esm_check == 1)
        $('.is_esm_reservation_avail_div').show();
      @else
        $('.is_esm_reservation_avail_div').hide();
      @endif

      @if($is_govt_servent == 1)
        $('.type_of_employment_div').show();
      @else
        $('.type_of_employment_div').hide();
      @endif

      @if($type_of_employment == 1 && !empty($type_of_employment))
        $('.type_of_employer_div').show();
      @else
        $('.type_of_employer_div').hide();
      @endif
      
      $('input:radio[name="is_govt_servent"]').change(function() {
          if($(this).val() == 1){
            $('.type_of_employment_div').show();
            if($('input[name="type_of_employment"]:checked').val() == 1){
              $('.type_of_employer_div').show();
            }
          }else{
            $('.type_of_employment_div').hide();
            $('.type_of_employer_div').hide();
          }
      });

      $('input:radio[name="type_of_employment"]').change(function() {
          if($(this).val() == 1){
            $('.type_of_employer_div').show();
          }else{
            $('.type_of_employer_div').hide();
          }
      });

      $('input:radio[name="esm_check"]').change(function(){
          if($(this).val() == 1){
            $('.is_esm_reservation_avail_div').show();
          }else{
            $('.is_esm_reservation_avail_div').hide();
          }
      });
      
      $('input:radio[name="nationality_type"]').change(function(){
          if($(this).val() == 1){
            $('.country_name').hide();
          }else{
            $('.country_name').show();
          }
      });

  });
</script>      
      