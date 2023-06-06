<?php if(isset($candidatesPHDResearchDetails) && !empty($candidatesPHDResearchDetails)){?>
                <tr style="background-color:#CCC;">
                    <td colspan="3" align="left" valign="top"><strong>Publication/s Details</strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <table class="table table-bordered table-hover"  width="100%" border="1" cellpadding="0" cellspacing="0">
                            <tr>
                                <th>Total number of publications</th>
                                <th>Total number of first author publications</th>
                                <th>Total number of publications as corresponding author</th>
                                <th>Total number of publications during the last five years in journals with impact factor > 5</th>
                                <th>Total number of citations</th>
                            </tr>
                            <?php    
                            foreach($candidatesPHDResearchDetails as $publicationDetails){   
                            ?>     
                            <tr>
                                <td align="center"><?php echo $publicationDetails['no_of_pub']; ?></td>
                                <td align="center"><?php echo $publicationDetails['no_of_first_author_pub']; ?></td>
                                <td align="center"><?php echo $publicationDetails['no_of_cors_author_pub']; ?></td>
                                <td align="center"><?php echo $publicationDetails['no_of_pub_impact_fact']; ?></td>
                                <td align="center"><?php echo $publicationDetails['no_of_citations']; ?></td>
                            </tr>  
                            <?php } ?>
                        
                        </table>
                        
                    </td>
                </tr>
                <?php } ?>