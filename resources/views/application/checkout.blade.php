<!-- include header -->
@include('application.header')
<?php
$page_title = "Confirm Payment | THSTI Payment Portal";
?>
@include('application.application_head')

<style type="text/css">
	#bdCheckoutFormInline { 
    height: 668px; 
    background: url('assets/images/slider/iFramemodalWindow.jpg') no-repeat center center; 
  } 
  .slider-product-image { 
    height: 588px; 
    background: url('assets/images/slider/modalWindow.jpg') no-repeat center center; 
  } 
  #bdCheckoutFormInline img { 
    max-width: none !important; 
  } 
  .single-slider .slider-bg { 
    background-color: #fff; 
  } 
  .showcase-active { 
    background-color: #eee; 
  } 
  #showcase { 
    background-color: #fffaf6; 
  } 

  .main-btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    border: 1px solid #fe7865;
    padding: 0 35px;
    font-size: 16px;
    line-height: 48px;
    color: #fff;
    cursor: pointer;
    z-index: 5;
    -webkit-transition: all 0.4s ease-out 0s;
    -moz-transition: all 0.4s ease-out 0s;
    -ms-transition: all 0.4s ease-out 0s;
    -o-transition: all 0.4s ease-out 0s;
    transition: all 0.4s ease-out 0s;
    background-color: #fe7865;
  }

  .main-btn:hover {
    background-color: #fff;
    color: #fe7865;
    border-color: #fe7865;
  }

  a:hover {
    text-decoration: none;
  }

  h1 {
    font-size: 1.5rem;
  }

  @media (max-width: 768px) { 
    .single-showcase::before { display: none; } 
    #bdCheckoutFormInline { width: 100%; } 
    #bdCheckoutFormInline img { max-width: 100% !important; } 
  } 
</style>

<?php
//$merchant_id = 'THSTI'; //'BDSKUATY';//
$merchant_id = config('app.bildesk.merchant_id');
$security_id = config('app.bildesk.security_id');
//$security_id = 'thsti';//'NA';//
$fee_type = "";
$txn_amt = $amountToPay;

$email = "";
$mobile = "";
$name = "";
$job_apply_id = $candidateJobApplyID;
$customer_id = "";
$msgData = [];
    
if(!empty($candidateData)){
    $email = $candidateData[0]['email_id'];
    $mobile = $candidateData[0]['mobile_no'];
    $name = $candidateData[0]['full_name'];
    $candidate_id = $candidateData[0]['id'];
    //$customer_id = "THSTI_".$candidate_id."_".$job_apply_id."_".date('YmdHis');
    $customer_id = Helper::get_customer_id($candidate_id, $job_apply_id);

    // data array to get message
    $msgData['merchant_id'] = $merchant_id;
    $msgData['customer_id'] = $customer_id;
    $msgData['txn_amt'] = $txn_amt;
    $msgData['security_id'] = $security_id;
    $msgData['email'] = $email;
    $msgData['mobile'] = $mobile;
    $msgData['name'] = $name;
    $msgData['job_apply_id'] = $job_apply_id;
}

//get msg string
//$msg = $merchant_id."|".$customer_id."|NA|".$txn_amt."|NA|NA|NA|INR|NA|R|".$security_id."|NA|NA|F|".$email."|".$mobile."|".$name."|".$job_apply_id."|NA|NA|NA|NA"; 	 
$msg = Helper::get_checkout_msg($msgData);
//echo $msg;exit;
// for test purpose
//$msg = "BDSKUATY|".$customer_id."|NA|".$txn_amt."|NA|NA|NA|INR|NA|R|NA|NA|NA|F|".$email."|".$mobile."|".$name."|".$job_apply_id."|NA|NA|NA|NA";  
//get checksum of the msg value
$msg_encode = Helper::msg_encrypt($msg);
$_SESSION['checksum'] = $msg_encode;
$msg_dtl = $msg."|".$msg_encode;
?>

<div class="container border" style="max-width: 500px; margin-top: 40px;">
        <div class="text-center h2 text-danger">
          Confirm Details
        </div>                 
        <form method="post" action="" name="confirm_pay">
          @csrf
          <input type="hidden" value="<?php echo $msg_encode; ?>" name="checksum" id="checksum" />             
          <input type="hidden" value="<?php echo $encJobApplyId; ?>" name="job_apply_id">
          <label>Reference No</label>
          <input class="form-control" value="<?php echo $customer_id; ?>" name="customer_id" id="customer_id" disabled />      
          
          <label>Name</label>
          <input class="form-control" value="<?php echo $name; ?>" name="name" id="name" disabled />      
          
          <label>Mobile</label>
          <input class="form-control" value="<?php echo $mobile; ?>" name="mobile" id="mobile" disabled /> 
          
          <label>Email</label>
          <input class="form-control" value="<?php echo $email; ?>" name="email" id="email" disabled />
          
          <label>Total Amount</label>
          <input class="form-control" value="<?php echo $amountToPay; ?>" name="txn_amt" id="txn_amt" disabled /> 
                  
          <input name="msg" id="msg" type="hidden" value="<?php echo $msg_dtl; ?>" class="col-lg-12"  />
          
          <div class="text-center">
              <!--<input value="Confirm and Pay" type="submit" class="btn btn-primary" id="submit_btn"  />-->
              <a id="bd_btn" class="main-btn" href="javascript:void(0)" data-animation="fadeInUp" data-delay="1.5s">Pay with BillDesk &nbsp;<code class="icon noselect">&gt;</code></a>
          </div>
        
        </form>
</div>

<script type="text/javascript">
$(document).ready(function(){		
  
  $('#bd_btn').click(function(){			
    //call ajex for submiting form values						
    //alert('test');
    var customer_id=$('#customer_id').val();
    var name=$('#name').val();
    var mobile=$('#mobile').val();
    var email=$('#email').val();
    var txn_amt=$('#txn_amt').val();
    var msg=$('#msg').val();
    var checksum=$('#checksum').val();
    //alert(11);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    xhr = $.ajax({
            type: 'POST',
            url: '<?php echo route('add_fee_transaction', $encJobApplyId); ?>',//'bd_update_data.php',
            data: {'customer_id':customer_id, 'name':name, 'mobile':mobile, 'email':email, 'txn_amt':txn_amt, 'msg':msg, 'checksum':checksum},
            success: function(result){  	
              //alert(22);	
              SubmitPay();
            }	  	 	  				  
          });//ajax 							  								
  });		
  	
});
</script>
<!--<script type="text/javascript" id="resourceScript" src="https://services.billdesk.com/checkout-widget/src/app.bundle.js" async></script> -->
<script type="text/javascript" src="https://pgi.billdesk.com/payments-checkout-widget/src/app.bundle.js"></script>
<script type="text/javascript">
    function SubmitPay() {        
        bdPayment.initialize ({
            "msg":"<?php echo $msg_dtl; ?>",
            "options": {
                        "enableChildWindowPosting": true,
                        "enablePaymentRetry": true,
                        "retry_attempt_count": 3
                      },
            "callbackUrl": "<?php echo config('app.bildesk.callback_url'); ?>"
        });		
    }	
</script>