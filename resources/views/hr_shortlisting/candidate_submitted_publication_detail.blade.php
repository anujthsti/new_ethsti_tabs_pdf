<?php if(isset($candidatesPublicationsDetails) && !empty($candidatesPublicationsDetails)){?>
                <tr style="background-color:#CCC;">
                    <td colspan="3" align="left" valign="top"><strong>Publication/s Details</strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <table class="table table-bordered table-hover"  width="100%" border="1" cellpadding="0" cellspacing="0">
                            <tr>
                                <th>Select Number in Publication</th>
                                <th>List of authors</th>
                                <th>Title of the article</th>
                                <th>Journal name</th>
                                <th>Year/Volume(Issue)</th>        
                                <th>Doi</th>        
                                <th>PubMed PMID</th>        
                            </tr>
                            <?php    
                            foreach($candidatesPublicationsDetails as $publicationDetails){   
                            ?>     
                            <tr>
                                <td align="center"><?php echo $publicationDetails['publication_number']; ?></td>
                                <td align="center"><?php echo $publicationDetails['authors']; ?></td>
                                <td align="center"><?php echo $publicationDetails['article_title']; ?></td>
                                <td align="center"><?php echo $publicationDetails['journal_name']; ?></td>
                                <td align="center"><?php echo $publicationDetails['year_volume']; ?></td>
                                <td align="center"><?php echo $publicationDetails['doi']; ?></td>
                                <td align="center"><?php echo $publicationDetails['pubmed_pmid']; ?></td>
                            </tr>  
                            <?php } ?>
                        
                        </table>
                        
                    </td>
                </tr>
                <?php } ?>