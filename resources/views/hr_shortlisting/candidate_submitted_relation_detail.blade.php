<?php if(!empty($candidateApplyDetails)){?>
                <tr style="background-color:#CCC;">
                    <td colspan="3" align="left" valign="top"><strong>Do you have any near relative/friend working in THSTI. If so, please state ?</strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <table class="table table-bordered table-hover"  width="100%" border="1" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="30%" align="center"><strong>Name of the person(s)</strong></td>
                                <td width="30%" align="center"><strong>Designation</strong></td>
                                <td width="40%" align="center"><strong>Relationship with the candidate</strong></td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <?php
                                    if(isset($candidateApplyDetails[0]['relative_name']) && !empty($candidateApplyDetails[0]['relative_name'])){
                                        echo $candidateApplyDetails[0]['relative_name'];
                                    }
                                    ?>
                                </td>
                                <td align="center">
                                    <?php
                                    if(isset($candidateApplyDetails[0]['relative_designation']) && !empty($candidateApplyDetails[0]['relative_designation'])){
                                        echo $candidateApplyDetails[0]['relative_designation'];
                                    }
                                    ?>
                                </td>
                                <td align="center">
                                    <?php
                                    if(isset($candidateApplyDetails[0]['relative_relationship']) && !empty($candidateApplyDetails[0]['relative_relationship'])){
                                        echo $candidateApplyDetails[0]['relative_relationship'];
                                    }
                                    ?>
                                </td>
                            </tr>    
                        </table>
                    </td>
                </tr>
                <?php } ?>     