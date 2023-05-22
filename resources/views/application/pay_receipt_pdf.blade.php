<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Pay Receipt</title>
</head>
<body>
    <?php
    $pay_status = $feeTransRec[0]['pay_status'];
    ?>
    <div class="container-fluid">	
        
        <div class="container-fluid border-top pt-5">                          
            <div class="container" id="mail_content">
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
                        <td><?php echo Helper::get_payment_status($pay_status); ?></td>
                    </tr>  
                </table>  
            </div>  
            
        </div>  
        
    </div>

</body>
</html>