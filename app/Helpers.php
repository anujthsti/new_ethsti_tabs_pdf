<?php

namespace App\Helpers;
// models call
use App\Models\Jobs;
use App\Models\CodeMaster;
use App\Models\CodeNames;
use App\Models\FormConfiguration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Helper {

    // encode function start
    public static function encodeId($id){
        
        // Store the cipher method
        $ciphering = config('app.encryptVars.ciphering');
        
        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        
        // Non-NULL Initialization Vector for encryption
        $encryption_iv = config('app.encryptVars.encryption_iv');
        
        // Store the encryption key
        $encryption_key = config('app.encryptVars.encryption_key');
        
        // replace / or + with - or _ and base64 encoding
        $encId = str_replace(array('+', '/'), array('-', '_'), base64_encode($id));        
        
        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($encId, $ciphering,
                    $encryption_key, $options, $encryption_iv);
        // replace / or + with  - or _
        $encryption = str_replace(array('+', '/'), array('-', '_'), $encryption);    

             
        return $encryption;            
    }
    // encode function end

    // decode function start
    public static function decodeId($encId){
        
        // Store the cipher method
        $ciphering = config('app.encryptVars.ciphering');
        
        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        
        // Non-NULL Initialization Vector for encryption
        $decryption_iv = config('app.encryptVars.encryption_iv');
        
        // Store the encryption key
        $decryption_key = config('app.encryptVars.encryption_key');
        
        // replace - or _ with / or + 
        $encId = str_replace(array('-', '_'), array('+', '/'), $encId);  
        
        // Use openssl_decrypt() function to decrypt the data
        $decId=openssl_decrypt ($encId, $ciphering, 
                $decryption_key, $options, $decryption_iv); 
        // base64 decode used to remove special character in encoded string like slash or star        
        $decryption = base64_decode(str_replace(array('-', '_'), array('+', '/'), $decId));

        // replace - or _ with / or +
        $decryption = str_replace(array('-', '_'), array('+', '/'), $decryption);    
                
        return $decryption;
    }
    // decode function end

    // get code names function start
    public static function getCodeNames(){

        $resultData = CodeNames::join('code_master', 'code_master.id', '=', 'code_names.code_id')
                    ->orderBy('id','asc')
                    ->get(['code_names.id', 'code_names.code_id', 'code_names.code_meta_name','code_names.code as meta_code','code_master.code_name','code_master.code'])
                    ->toArray();
        
        return $resultData;
    }
    // get code names function end

    // get code names by code query start
    public static function getCodeNamesByMasterCode($master_code){

        $resultData = CodeNames::join('code_master', 'code_master.id', '=', 'code_names.code_id')
                    ->orderBy('code_names.id','asc')
                    ->where('code_master.code', $master_code)
                    ->get(['code_names.id', 'code_names.code_id', 'code_names.code_meta_name','code_names.code as meta_code','code_master.code_name','code_master.code'])
                    ->toArray();
        return $resultData;
    }
    // get code names by code query end

    // get code names by code function start
    public static function getCodeNamesByCode($array, $key, $keyValue){
        $retArray = array_filter($array, function($value) use ($key, $keyValue) {
                        return $value[$key] == $keyValue; 
                    });
        $retArray = array_values($retArray);
        return $retArray;            
    }
    // get code names by code function start

    // get code names ids function start
    public static function getCodeNamesIdsByCodes($masterCode, $codeNamesArr){

        $resultData = CodeNames::join('code_master', 'code_master.id', '=', 'code_names.code_id')
                    ->orderBy('code_names.id','asc')
                    ->where('code_master.code',$masterCode)
                    ->whereIn('code_names.code', $codeNamesArr)
                    ->get('code_names.id')
                    ->toArray();
        $resultData = array_column($resultData, 'id');
        return $resultData;
    }
    // get code names function end

    // get code names details by Id
    public static function getCodeNameDetailById($masterCode, $codeNameId){

        $resultData = CodeNames::join('code_master', 'code_master.id', '=', 'code_names.code_id')
                    ->orderBy('code_names.id','asc')
                    ->where('code_master.code',$masterCode)
                    ->whereIn('code_names.id', $codeNameId)
                    ->get('code_names.code')
                    ->toArray();
        $resultData = array_column($resultData, 'code');
        return $resultData;            
    }

    // convert dabe format from dd/mm/yyyy to yyyy-mm-dd function start
    public static function convertDateDMYtoYMD($date){
        $newDate = str_replace('/', '-', $date);
        $newDate = date('Y-m-d', strtotime($newDate));
        return $newDate;
    }
    // convert dabe format from dd/mm/yyyy to yyyy-mm-dd function end

    // convert dabe format from yyyy-mm-dd to dd/mm/yyyy function start
    public static function convertDateYMDtoDMY($date){
        $newDate = date("d-m-Y", strtotime($date));  
        $newDate = str_replace('-', '/', $newDate);
        return $newDate;
    }
    // convert dabe format from yyyy-mm-dd to dd/mm/yyyy function end

    // Reverse date function start
    public static function rev_date($date){
            $array=explode("-",$date);
            $rev=array_reverse($array);
            $date=implode("-",$rev);
            return $date;
    }
    // Reverse date function end

    // upload file function start
    public static function upload($file,$destinationPath,$maxFileSizeKB,$fileExtentionArr){
        $status = 1;// success = 1, error = 2
        $msg = "File uploaded successfully.";
        //get File Name
        $fileName = $file->getClientOriginalName();
        
        //get File Extension
        $fileExtention = $file->getClientOriginalExtension();
        if(!in_array($fileExtention, $fileExtentionArr)){
            $arrayString = implode(',', $fileExtentionArr);
            $status = 2;
            $msg = "File extention should be match with list: ".$arrayString;
        }
        
        //get File Real Path
        $fileRealPath = $file->getRealPath();
        
        //Display File Size
        $fileSize = $file->getSize();
        //echo $fileSize;exit;
        if($fileSize > $maxFileSizeKB){
            $maxFileSizeKB = $maxFileSizeKB/1024;
            $status = 2;
            $msg = "File size should be less than or equal to ".$maxFileSizeKB." KB";
        }
        
        //Display File Mime Type
        $fileMIMEType = $file->getMimeType();
        
        //Move Uploaded File
        try{
            $retArr = $file->move($destinationPath,$fileName);
            //print_r($retArr);exit;
        }catch(\Exception $e){
            
            $status = 2;
            $msg = $e->getMessage();
        }

        $retData['status'] = $status;
        $msg = "File Name: ".$fileName." ".$msg;
        $retData['msg'] = $msg;
        return $retData;
        
    }
    // upload file function end

    // random captcha code start
    public static function get_captcha_code(){
        $random_alpha = md5(rand());
        $captcha_code = substr($random_alpha, 0, 6);
        return $captcha_code;
    }
    // random captcha code end

    // convert number into Roman
    public static function numberToRomanRepresentation($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    public static function logErrorInFile($e){

        $errorMsg = $e->getMessage();
        $lineNo = $e->getLine();
        $fileName = $e->getFile();
        $logErrorMsg = $errorMsg.' - Line No: '.$lineNo.' - File Name: '.$fileName;
        Log::error($logErrorMsg);

    }

    public static function getFormConfigUrl($postId, $postIdEnc){

        $formConfigRec = FormConfiguration::where('post_id', $postId)
                                                              ->where('status', 1)
                                                              ->get(['form_configuration.*'])
                                                              ->toArray();
        $formConfigUrl = route('add_form_configuration','postId='.$postIdEnc);                                  
        if(!empty($formConfigRec)){
            $formConfigIdEnc = Helper::encodeId($formConfigRec[0]['id']);
            $formConfigUrl = route('edit_form_configuration',$formConfigIdEnc);   
        }
        return $formConfigUrl;
    }

    public static function getFormValidationUrl($postId, $postIdEnc){

        $formValidationRec = JobValidation::where('post_id', $postId)
                                                              ->where('status', 1)
                                                              ->get(['job_validation.*'])
                                                              ->toArray();
        $formValidationUrl = route('add_job_validation','postId='.$postIdEnc);                                  
        if(!empty($formValidationRec)){
            $formValidationIdEnc = Helper::encodeId($formValidationRec[0]['id']);
            $formValidationUrl = route('edit_job_validation',$formValidationIdEnc);   
        }
        return $formValidationUrl;
    }

    //encrypt msg string
    public static function msg_encrypt($string){  	
        //$string='TESTME|UATTXN0001|NA|2|NA|NA|NA|INR|NA|R|NA|NA|NA|F|Andheri|Mumbai|02240920005|support@billdesk.com|NA|NA|NA|https://www.billdesk.com';
        // test key
        //$thstiChecksumKey = config('app.bildesk.test_checksum_key');
        // thsti original key
        $thstiChecksumKey = config('app.bildesk.thsti_checksum_key');
        $checksum = hash_hmac('sha256',$string,$thstiChecksumKey, false);
        $checksum = strtoupper($checksum);
        return $checksum;	  
    }

    // get fee for candidate
    public static function get_fee_for_candidate($candidateData, $candidateJobApplyDetail, $job_id){
        $candidateFee = 0;
        if(!empty($candidateJobApplyDetail) && !empty($candidateData)){
            $jobFeesRec = Jobs::join('job_application_fee_trans','job_application_fee_trans.job_validation_id','=','jobs.job_validation_id')
                            ->join('code_names','code_names.id','=','job_application_fee_trans.fee_category_id')
                            ->where('jobs.id', $job_id)
                            ->where('job_application_fee_trans.status', 1)
                            ->get(['job_application_fee_trans.fee_category_id','job_application_fee_trans.fee','code_names.code'])
                            ->toArray();
            if(!empty($jobFeesRec)){        
                $feeCodesArr = array_column($jobFeesRec, 'code');     
                 
                // If candidate from any Trainee Category
                $key = "";// for not found
                if(isset($candidateJobApplyDetail[0]['trainee_category_id']) && !empty($candidateJobApplyDetail[0]['trainee_category_id'])){
                    
                    $trainee_category_id = $candidateJobApplyDetail[0]['trainee_category_id'];
                    $traineeCatIdsArr = [$trainee_category_id];
                    $masterCode = "trainee_category";
                    $traineeCatCodeArr = Helper::getCodeNameDetailById($masterCode, $traineeCatIdsArr);
                    if(in_array('govt',$traineeCatCodeArr)){
                        $key = array_search ('fee_for_govt', $feeCodesArr);
                    }
                    else if(in_array('non_govt',$traineeCatCodeArr)){
                        $key = array_search ('fee_for_non_govt', $feeCodesArr);
                    }
                    else if(in_array('esic',$traineeCatCodeArr)){
                        $key = array_search ('fee_for_esic', $feeCodesArr);
                    }
                    else{

                    }
                }else{
                    // If candidate applying for any job
                    $genderId = $candidateData[0]['gender'];
                    $masterCode = "gender";
                    $codeNamesArr = ['female'];
                    $genderIdsArr = Helper::getCodeNamesIdsByCodes($masterCode, $codeNamesArr);
                      
                    // if Candidate is Female
                    if(in_array($genderId, $genderIdsArr)){
                        $key = array_search ('fee_for_women', $feeCodesArr);
                    }else{
                        
                        // If candidate is male
                        $is_pwd = $candidateJobApplyDetail[0]['is_pwd'];
                        $category_id = $candidateJobApplyDetail[0]['category_id'];
                        if($is_pwd == 1){
                            $key = array_search ('fee_for_pwbd', $feeCodesArr);
                        }
                        else{
                            $categoryIdsArr = [$category_id];
                            $casteCategoryCodeArr = Helper::getCodeNameDetailById("cast_categories", $categoryIdsArr);
                            
                            if(in_array('gen',$casteCategoryCodeArr)){
                                $key = array_search ('fee_for_ur', $feeCodesArr);
                            }
                            else if(in_array('sc',$casteCategoryCodeArr) || in_array('st',$casteCategoryCodeArr)){
                                $key = array_search ('fee_for_scst', $feeCodesArr);
                            }
                            else if(in_array('obc',$casteCategoryCodeArr)){
                                $key = array_search ('fee_for_obc', $feeCodesArr);
                            }
                            else if(in_array('ews',$casteCategoryCodeArr)){
                                $key = array_search ('fee_for_ews', $feeCodesArr);
                            }
                            else{

                            }

                        }
                        
                        
                    }

                }
                if(isset($jobFeesRec[$key]['fee']) && !empty($jobFeesRec[$key]['fee'])){
                    $candidateFee = $jobFeesRec[$key]['fee'];
                }
            }

        }

        return $candidateFee;
    }

    //create sms parameter array 
    public static function sms_parameter($can_mob, $sms_content)
    {	
        //SMS PARAMETERE configuration set	
        $smsTemplateId = '1707162729358153319';
        $Phno = $can_mob;   
        $Msg = $sms_content;
        $Password = config('app.sms_settings.Password');
        $SenderID = config('app.sms_settings.SenderID');//'ETHSTI';
        $UserID = config('app.sms_settings.UserID');//'thsti';
        $EntityID = config('app.sms_settings.EntityID');
        $TemplateID = $smsTemplateId;

        $sms_array = array(
            "Phno" => $Phno,
            "Msg" => urlencode($Msg),
            "Password" => $Password,
            "SenderID"=>$SenderID,
            "UserID"=>$UserID,
            "EntityID"=>$EntityID,
            "TemplateID"=>$TemplateID
         );
                
        return $sms_array;
    }
        


    //sending sms
    public static function send_message($params)
    {
        $postData = '';
        foreach($params as $k => $v) 
        { 
            $postData .= $k . '='.$v.'&'; 
        }
        $postData = rtrim($postData, '&');
        
        $url = config('app.sms_settings.smsAPIUrl');//'http://nimbusit.biz/api/SmsApi/SendBulkApi';

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER, false); 
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    

        $output = curl_exec($ch);

        curl_close($ch);
        return $output;
    }

    public static function get_checkout_msg($data){

        $merchant_id = $data['merchant_id'];
        $customer_id = $data['customer_id'];
        $txn_amt = $data['txn_amt'];
        $security_id = $data['security_id'];
        $email = $data['email'];
        $mobile = $data['mobile'];
        $name = $data['name'];
        $job_apply_id = $data['job_apply_id'];
        $currency_type = config('app.bildesk.currency_type');

        $msg = $merchant_id."|".$customer_id."|NA|".$txn_amt."|NA|NA|NA|".$currency_type."|NA|R|".$security_id."|NA|NA|F|".$email."|".$mobile."|".$name."|".$job_apply_id."|NA|NA|NA|NA"; 	 
        return $msg;
    }

    public static function get_customer_id($candidate_id, $job_apply_id){

        $customer_id = "THSTI_".$candidate_id."_JobFee_".$job_apply_id."_".date('YmdHis');
        return $customer_id;
    }

    public static function get_status($status){
        $statusHtml = '<span class="text-warning">Pending</span>';
        if($status == '0300'){ 
            $statusHtml = '<span class="text-success">Success</span>'; 
        }
        else if($status == '0399'){ 
            $statusHtml = '<span class="text-danger">Failed</span>'; 
        }
        else if($status == '0002'){ 
            $statusHtml = '<span class="text-primary">Pending (Please check the payment status after sometime) </span>'; 
        }
        else if($status == '0001' || $status == 'NA'){ 
            $statusHtml = '<span class="text-dark">Technical Error. Please try again.</span>'; 
        }		
        else{ 
            $statusHtml = '<span class="text-warning">Pending</span>'; 
        }
        return $statusHtml;
    }

    // get month name by number function
    public static function getMonthName($monthNumber) {
        $months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        return $months[$monthNumber - 1];
    }

    // get array by values
    public static function filterHRRemarksByValue($arrayData, $value){
        $new = array_filter($arrayData, function ($var) use ($value) {
            return ($var['category'] == $value);
        });
        return $new;
    }

    public static function cleanData(&$str) 
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"'))
        $str = '"' . str_replace('"', '""', $str) . '"'; 
    }

    public static function age_validate($dateOfBirth, $dateAsOn){

        // Create DateTime object from date of birth
        //$birthDate = new DateTime($dateOfBirth);
        $diff = abs(strtotime($dateAsOn) - strtotime($dateOfBirth));

        $years = floor($diff / (365*60*60*24));
        // Calculate age difference between birth date and today
        //$age = $dateAsOn->diff($birthDate)->y;
        return $years;

    }

    // grand total experience
    public static function grand_total_exp_year($totalExp){

        //grand total experience calculation
        $years = 0;
        $months = 0;
        $days = 0;
        foreach($totalExp as $exp_val){
            $exp = explode(",",$exp_val);	
            $yr = explode(" ",trim($exp[0]));
            $mn = explode(" ",trim($exp[1]));	
            $dy = explode(" ",trim($exp[2]));
               //print_r($mn);exit;
            $years = $years+$yr[0];
            $months = $months+$mn[0];
            $days = $days+$dy[0];		
                
            while($days>=31)
            {
                $months++;
                $days = $days-31;		
            }	
            while($months>=12)
            {
                $years++;
                $months = $months-12;										
            }				
        }
        //$retData = $years." YEARS,".$months." MONTHS,".$days." DAYS";
        return $years;
    }
    
}