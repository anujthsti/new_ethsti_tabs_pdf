<!-- include header -->
@include('application.header')
<?php
$page_title = "Pay Receipt";
$form_action = "";
$pay_status = $feeTransRec[0]['pay_status'];
?>
@include('application.application_head')

<div class="container-fluid">	
    <!-- old existed file -> new_online-form_up.php -->
    <!-- old existing submit form file -> online-update.php -->
    <!-- include dashboard navigation -->
    @include('application.dashboard_nav')
    <div class="container-fluid border-top pt-5">                          
        <div class="container" id="mail_content">
    <?php //require_once("../ethsti/includes/ethsti_print_header.php"); ?>    
        
    <?php if($pay_rec[0]['payment_status'] == 1) {?>
        <div class="text-center h2 text-danger">Pay Receipt</div>                     
    <?php }else{ ?>		
        <div class="text-center h2 text-primary">Provisional Pay Receipt</div>
    <?php } ?>
        
            <table class="table table-sm table-bordered" id="" border="1">		
            <tr>
                <td>Full Name</td>
                <td><?php echo $feeTransRec[0]['name']; ?></td>
            </tr>
            <tr>
                <td>Mobile</td>
                <td><?php echo $feeTransRec[0]['mobile']; ?></td>
            </tr>
            <tr>
                <td>Email ID</td>
                <td><?php echo $feeTransRec[0]['email']; ?><input type="hidden" id="email" value="<?php echo $feeTransRec[0]['email']; ?>" /></td>
            </tr>
            
            <tr>
                <td>Transaction Ref. No.</td>
                <td><?php echo $feeTransRec[0]['customer_id']; ?></td>
            </tr>
            <tr>
                <td>Transaction ID</td>
                <td><?php echo ($feeTransRec[0]['txn_reference_no']!='')?$feeTransRec[0]['txn_reference_no']:'-'; ?></td>
            </tr> 
            <tr>
                <td>Transaction Date</td>
                <td><?php echo ($feeTransRec[0]['txn_date']!='')?$feeTransRec[0]['txn_date']:'-'; ?></td>
            </tr> 
            <tr>
                <td>Transaction Amount</td>
                <td><?php echo $feeTransRec[0]['currency_type']; ?>&nbsp; <?php echo $feeTransRec[0]['txn_amount']?></td>
            </tr>
            <tr>
                <td>Transaction Charges</td>
                <td><?php echo ($feeTransRec[0]['txn_charges']!='')?$feeTransRec[0]['txn_charges']:'-';?></td>
            </tr>
            <tr>
                <td>Payment Status</td>
                <td><?php echo Helper::get_status($pay_status); ?></td>
            </tr>  
            <?php /*if($pay_status == '0002'){ ?>
            <tr>
                <td colspan="2"> 
                    <a class="btn btn-warning" href="https://thsti.in/bdpay/receipt.php">Payment Status</a> 
                </td>
            </tr>    
            <?php }*/ ?>
            </table>  
        </div>  
                                                            
            
        <div class="col-lg-12 mt-2 mb-2">
            <div class="text-center"> 
                <a class="btn btn-primary col-lg-2 col-md-2 col-sm-2 text-light" id="print_id"> <i class='fa fa-print'></i> Print </a>
                <!--<a class="btn btn-primary col-lg-2 col-md-2 col-sm-2 text-light" id="mail_receipt"> <i class="fa fa-envelope"></i> Mail Receipt </a>-->                               
            </div>
        </div>

    </div>
    </div>  
    
</div>

<script type="application/javascript" >

	$(document).ready(function(){
		
		//alert("Click on Mail button to send the payment receipt in your register email address"); 
		
		$("#print_id").click(function(){
			window.print();
			window.close();
		});
		
	   $("#mail_receipt").click(function(){ 			
		var email = $('#email').val();
		var mail_content = $('#mail_content').html();
		xhr = $.ajax({
		type: 'POST',
		url: 'bd_search.php',
		data: { 'mail_content':mail_content, 'email': email, 'case': 1},
		success: function(html)
		{ 
		  if(html == 'Sent') 
		  { alert("A payment slip has been sent to your email "+ email +" for future reference.");	}
		}	  	 	
		});
	   });
	   
	});

</script>
<!-- include footer -->
@include('application.footer')