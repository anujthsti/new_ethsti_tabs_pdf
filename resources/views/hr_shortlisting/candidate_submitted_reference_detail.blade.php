<?php if(isset($candidatesRefreeDetails) && !empty($candidatesRefreeDetails)){?>
                <tr style="background-color:#CCC;">
                    <td colspan="3" align="left" valign="top"><strong>Name of the Referee/s</strong><strong></strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <table class="table table-bordered table-hover" width="100%" border="1" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="24%" align="center" valign="top"><strong>Name of Refree</strong></td>
                                <td width="16%" align="center" valign="top"><strong>Designation</strong></td>
                                <td width="16%" align="center" valign="top"><strong>Organisation</strong></td>
                                <td width="18%" align="center" valign="top"><strong>Email Id</strong></td>
                                <td width="14%"  align="center" valign="top"><strong>Phone No</strong></td>
                                <td width="12%" align="center" valign="top"><strong>Mobile No</strong></td>
                            </tr>
                            <?php    
                            foreach($candidatesRefreeDetails as $refreeDetails){   
                            ?>       
                            <tr>
                                <td align="center"><?php echo $refreeDetails['refree_name']; ?></td>
                                <td align="center"><?php echo $refreeDetails['designation']; ?></td>
                                <td align="center"><?php echo $refreeDetails['organisation']; ?></td>
                                <td align="center"><?php echo $refreeDetails['email_id']; ?></td>
                                <td align="center"><?php echo $refreeDetails['phone_no']; ?></td>
                                <td align="center"><?php echo $refreeDetails['mobile_no']; ?></td>
                            </tr>
                            <?php } ?>
                        </table>      
                    </td>
                </tr>
                <?php } ?>