<?php if(isset($candidatesPHDResearchDetails) && !empty($candidatesPHDResearchDetails)){?>
                <tr>
                    <td colspan="3" align="left" valign="top">&nbsp;</td>
                </tr> 
                    <?php if(isset($candidatesPHDResearchDetails[0]['patent_information']) && !empty($candidatesPHDResearchDetails[0]['patent_information'])){?>
                    <!-- patent informations start -->
                    <tr>
                        <td colspan="3" align="left">
                            <div style="background-color:#CCC;">
                                <strong>Patent/s</strong>
                            </div>
                            <?php echo $candidatesPHDResearchDetails[0]['patent_information']?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left" valign="top">
                            <table class="table table-bordered table-hover"  width="100%" border="1" cellpadding="0" cellspacing="0">
                                <tr>
                                    <th>Number of patents filed (National)</th>
                                    <th>Number of patents granted (National)</th>
                                    <th>Number of patents filed (International)</th>
                                    <th>Number of patents granted (International)</th>
                                </tr>
                                <tr>
                                    <td align="center"><?php echo $candidatesPHDResearchDetails[0]['no_patents_filed_national']?></td>
                                    <td align="center"><?php echo $candidatesPHDResearchDetails[0]['no_patents_granted_national']?></td>
                                    <td align="center"><?php echo $candidatesPHDResearchDetails[0]['no_patents_filed_international']?></td>
                                    <td align="center"><?php echo $candidatesPHDResearchDetails[0]['no_patents_granted_international']?></td>
                                </tr>  
                                
                            </table>
                            
                        </td>
                    </tr>
                    <!-- patent informations end -->
                    <?php } ?>
                    <?php if(isset($candidatesPHDResearchDetails[0]['research_statement']) && !empty($candidatesPHDResearchDetails[0]['research_statement'])){?>
                        <!-- Research Statement start -->
                        <tr><td colspan="3" align="left" valign="top">&nbsp;</td></tr> 
                        <tr>
                            <td colspan="3" align="left">
                                <div style="background-color:#CCC;">
                                    <strong>Research statement/proposal</strong>
                                </div>
                                <?php echo $candidatesPHDResearchDetails[0]['research_statement']; ?>
                            </td>
                        </tr>
                        <!-- Research Statement end -->
                    <?php } ?>

                <?php } ?>