<?php
                if(isset($candidatesCommonDocuments) && !empty($candidatesCommonDocuments)){
                ?>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <?php
                         if(empty($candidatesCommonDocuments[0]['id_card']) && empty($candidatesCommonDocuments[0]['project_proposal']) && empty($candidatesCommonDocuments[0]['candidate_cv']) && empty($candidatesCommonDocuments[0]['publication'])){
                        ?>
                         <h5 class="text-danger">NO DOCUMENT ATTACHED</h5>
                         <?php 
                        }else{ ?>
                        <div style="background-color:#CCC;"><strong>Attachments:</strong></div>
                        <?php } ?>
                        <!-- cv doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['candidate_cv'])){
                            $candidate_cv = $candidatesCommonDocuments[0]['candidate_cv'];
                            $cvPath = $candidates_docs_path."/".$candidate_cv;
                            $cvPath = url($cvPath);
                        ?>
                        <div class="row">
                            <div class="col-md-6 text-right">CV:</div> 
                            <div class="col-md-6 text-left">
                                <a target="_new" href="<?php echo $cvPath; ?>"><?php echo $candidate_cv; ?></a>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- cv doc end -->
                        <!-- age proof doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['age_proof'])){
                            $age_proof = $candidatesCommonDocuments[0]['age_proof'];
                            $age_proofPath = $candidates_docs_path."/".$age_proof;
                            $age_proofPath = url($age_proofPath);
                        ?>
                            <div class="row">
                                <div class="col-md-6 text-right">AGE PROOF:</div> 
                                <div class="col-md-6 text-left">
                                    <a target="_new" href="<?php echo $age_proofPath; ?>"><?php echo $age_proof; ?></a>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- age proof doc end -->
                        <!-- NOC doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['noc_certificate'])){
                            $noc_certificate = $candidatesCommonDocuments[0]['noc_certificate'];
                            $noc_certificatePath = $candidates_docs_path."/".$noc_certificate;
                            $noc_certificatePath = url($noc_certificatePath);
                        ?>
                            <div class="row">
                                <div class="col-md-6 text-right">NOC FOR PRESENT EMPLOYER:</div> 
                                <div class="col-md-6 text-left">
                                    <a target="_new" href="<?php echo $noc_certificatePath; ?>"><?php echo $noc_certificate; ?></a>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- NOC doc end -->
                        <!-- LIST OF PUBLICATIONS doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['listpublication'])){
                            $listpublication = $candidatesCommonDocuments[0]['listpublication'];
                            $listpublicationPath = $candidates_docs_path."/".$listpublication;
                            $listpublicationPath = url($listpublicationPath);
                        ?>
                            <div class="row">
                                <div class="col-md-6 text-right">LIST OF PUBLICATIONS:</div> 
                                <div class="col-md-6 text-left">
                                    <a target="_new" href="<?php echo $listpublicationPath; ?>"><?php echo $listpublication; ?></a>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- LIST OF PUBLICATIONS doc end -->
                        <!-- BEST FIVE/TEN PUBLICATIONS doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['publication'])){
                            $publication = $candidatesCommonDocuments[0]['publication'];
                            $publicationPath = $candidates_docs_path."/".$publication;
                            $publicationPath = url($publicationPath);
                        ?>
                            <div class="row">
                                <div class="col-md-6 text-right">BEST FIVE/TEN PUBLICATIONS:</div> 
                                <div class="col-md-6 text-left">
                                    <a target="_new" href="<?php echo $publicationPath; ?>"><?php echo $publication; ?></a>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- BEST FIVE/TEN PUBLICATIONS doc end -->
                        <!-- PROJECT PROPOSAL doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['project_proposal'])){
                            $project_proposal = $candidatesCommonDocuments[0]['project_proposal'];
                            $project_proposalPath = $candidates_docs_path."/".$project_proposal;
                            $project_proposalPath = url($project_proposalPath);
                        ?>
                            <div class="row">
                                <div class="col-md-6 text-right">PROJECT PROPOSAL:</div> 
                                <div class="col-md-6 text-left">
                                    <a target="_new" href="<?php echo $project_proposalPath; ?>"><?php echo $project_proposal; ?></a>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- PROJECT PROPOSAL doc end -->
                        <!-- STATEMENT OF PURPOSE doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['stmt_proposal'])){
                            $stmt_proposal = $candidatesCommonDocuments[0]['stmt_proposal'];
                            $stmt_proposalPath = $candidates_docs_path."/".$stmt_proposal;
                            $stmt_proposalPath = url($stmt_proposalPath);
                        ?>
                            <div class="row">
                                <div class="col-md-6 text-right">STATEMENT OF PURPOSE:</div> 
                                <div class="col-md-6 text-left">
                                    <a target="_new" href="<?php echo $stmt_proposalPath; ?>"><?php echo $stmt_proposal; ?></a>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- STATEMENT OF PURPOSE doc end -->
                        <!-- ID Card doc start -->
                        <?php
                        if(!empty($candidatesCommonDocuments[0]['id_card'])){
                            $id_card = $candidatesCommonDocuments[0]['id_card'];
                            $id_cardPath = $candidates_docs_path."/".$id_card;
                            $id_cardPath = url($id_cardPath);
                        ?>
                            <div class="row">
                                <div class="col-md-6 text-right">ID Card:</div> 
                                <div class="col-md-6 text-left">
                                    <a target="_new" href="<?php echo $id_cardPath; ?>"><?php echo $id_card; ?></a>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- ID Card doc end -->
                    </td>
                </tr>    
                <?php } ?>