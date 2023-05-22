<tr style="background-color:#CCC;">
                    <td colspan="3" align="left" valign="top"><strong>Transaction Details</strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <table class="table table-bordered table-hover"  width="100%" border="1" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center"><strong>Transaction No</strong></td>
                                <td align="center"><strong>Transaction Date</strong></td>
                                <td align="center"><strong>Payment Status</strong></td>
                            </tr>
                            <?php if(isset($feeTransactions) && !empty($feeTransactions)){ ?>
                            <tr>
                                <td align="center"><?php echo $feeTransactions[0]['txn_reference_no']; ?></td>
                                <td align="center"><?php echo $feeTransactions[0]['txn_date']; ?></td>
                                <td align="center">
                                    <?php
                                    if($payment_status == 1){
                                        echo '<span class="text-success">Success</span>';
                                    }
                                    else if($payment_status == 1){
                                        echo '<span class="text-warning">Pending</span>';
                                    }
                                    else{
                                        echo '<span class="text-danger">Failed</span>';
                                    }
                                    ?>
                                </td>
                            </tr>   
                            <?php } ?>         
                        </table>
                    </td>
                </tr>