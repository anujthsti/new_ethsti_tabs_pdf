<!-- include header -->
@include('application.header')
<?php
$page_title = "Dashboard";
?>
@include('application.application_head')
<style>
    .btn-pay{
        background: linear-gradient(90deg, #f58920 31%, #f04d09 72%, #e04421 91%);
        color: #ffffff;
    }
</style>
<div class="">
    
    <div class="container-fluid align-middle">   	     
        <div class="">    
            <!-- heading bar start -->
            <div class="row mt-5">
                <div class="col-lg-6 col-md-6 col-sm-12 text-left">
                    <span class="text-primary">
                        <h5> Welcome: {{ $candidate_details->full_name }}</h5>
                    </span>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                    <button class="btn btn-danger shadow" onclick="window.location.href='<?php echo route('dashboard_logout'); ?>'"><i class="fa fa-sign-out">&nbsp;Logout</i></button>
                </div>
            </div>
            <!-- heading bar end -->  
            <div class="row">    
                <div class="col-lg-12 text-center text-danger h5">
                    You can modify the application form prior to final submission.
                </div>   
            </div>  
            @if(session('success'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('success') }}
            </div>
            @endif
            @if (session('error_msg'))
                <div class="alert alert-danger mb-1 mt-1"> 
                    {{ session('error_msg') }}
                </div>
            @endif
            <!-- table content start -->
            <div class="table-responsive">
                <table class="table table-bordered table-sm table-hover">
                    <thead>
                        <tr valign="top" align="center">
                            <th>RN No</th>
                            <th>Name of the Post Applied</th>
                            <th><span class='text-danger'>Step 1</span> <br /> Update Details</th>
                            <th><span class='text-danger'>Step 2 </span> <br /> Upload Files</th>
                            <th><span class='text-danger'>Step 3 </span> <br /> Pay Online</th>
                            <th><span class='text-danger'>Step 4 </span> <br />Submission and Print</th>
                            <th>Application Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidateJobsApplied as $appliedJob)
                            <?php
                            $postMasterDetail = Helper::getCodeNamesByCode($postsMasterArr, 'id', $appliedJob->post_id);
                            $postName = "";
                            if(!empty($postMasterDetail)){
                                $domainMasterDetail = Helper::getCodeNamesByCode($domainAreaArr, 'id', $appliedJob->domain_id);
                                $postName = $postMasterDetail[0]['code_meta_name'];
                                if(!empty($postName) && !empty($domainMasterDetail)){
                                    $domainName = $domainMasterDetail[0]['code_meta_name'];
                                    if(!empty($domainName)){
                                        $postName .= ' ('.$domainName.')';
                                    }
                                }
                            }

                            // if application status is completed
                            $btnHtml = '<button class="btn"><i class="fa fa-check" style="color:Green"></i></button>';
                            $step1Html = $btnHtml;
                            $step2Html = $btnHtml;
                            $step3Html = $btnHtml;
                            $step4Html = $btnHtml;
                            $applicationStatus = "";
                            // if application status is pending
                            if($appliedJob->application_status == 0){
                                $encId = Helper::encodeId($appliedJob->id);
                                //$encId = Helper::encodeId($appliedJob->id);
                                // candidate details edit button
                                $editDetailsUrl = route('edit_candidate_applied_job_details', $encId);
                                $editBtn = '<i class="fa fa-edit edit-green"></i>';
                                if($appliedJob->is_completed == 0){
                                    $step1Html = '<a href="'.$editDetailsUrl.'">'.$editBtn.'</a>';
                                }
                                // document upload button
                                $editUploadDocsUrl = route('upload_candidate_documents', $encId);
                                if($appliedJob->data_status == 1 && $appliedJob->is_completed == 0){
                                    $step2Html = '<a href="'.$editUploadDocsUrl.'">'.$editBtn.'</a>';
                                }else{
                                    $step2Html = '<button class="btn"> - </button>';
                                }

                                $step3Html = "";
                                if($appliedJob->is_payment_required == 1 && $appliedJob->data_status == 1 && $appliedJob->file_status == 1 && $appliedJob->payment_status != 1 && $appliedJob->is_completed == 0){

                                    $checkoutUrl = route('checkout',$encId );//"https://thsti.in/bdpay/verify_pay_st.php?msg=".$encId;
                                    $step3Html = '<a class="btn btn-pay" href="'.$checkoutUrl.'">Pay Online</a>';
                                }
                            }

                            $step4Html = "";
                            if($appliedJob->is_payment_required == 1 && $appliedJob->payment_status == 1 && $appliedJob->is_completed == 1){
                                $payReceiptUrl = route('pay_receipt',$encId );//https://thsti.in/bdpay/pay_receipt.php?txn_id=<?= base64_encode(strip_tags($u_rec['txn_id']))
                                $step4Html = '<a class="btn btn-success" href="'.$payReceiptUrl.'">Payment Receipt</button>';
                            }
                            
                            if ($appliedJob->payment_status == 0) {
                                $applicationStatus = "PENDING";
                            } 
                            else if ($appliedJob->payment_status == 1) {
                                $applicationStatus = 'RECEIVED';
                            }
                            else if ($appliedJob->payment_status == 2) {
                                $applicationStatus = 'Failed';
                            }
                            ?>
                            <tr align="center">
                                <td>{{ $appliedJob->rn_no }}</td>
                                <td><?php echo $postName; ?></td>
                                <td><?php echo $step1Html; ?></td>
                                <td><?php echo $step2Html; ?></td>
                                <td><?php echo $step3Html; ?></td>
                                <td><?php echo $step4Html; ?></td>
                                <td><?php echo $applicationStatus; ?></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>    
            </div>
            <!-- table content end -->
        </div>
    </div>
</div>
<!-- end of container-->

<!-- include footer -->
@include('application.footer')
