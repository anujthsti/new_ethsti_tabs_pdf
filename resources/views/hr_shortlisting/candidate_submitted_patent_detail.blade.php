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
                    <!-- patent informations end -->
                    <?php } ?>
                    <?php if(isset($candidatesPHDResearchDetails[0]['research_statement']) && !empty($candidatesPHDResearchDetails[0]['research_statement'])){?>
                        <!-- Research Statement start -->
                        <tr><td colspan="3" align="left" valign="top">&nbsp;</td></tr> 
                        <tr>
                            <td colspan="3" align="left">
                                <div style="background-color:#CCC;">
                                    <strong>Research statement</strong>
                                </div>
                                <?php echo $candidatesPHDResearchDetails[0]['research_statement']; ?>
                            </td>
                        </tr>
                        <!-- Research Statement end -->
                    <?php } ?>

                <?php } ?>