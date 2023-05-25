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
                            <th><span class='text-danger'>All required application steps</span> <br /></th>
                            <th>Payment Receipt</th>
                            <th>Application Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidateJobApplyDetailArr as $appliedJob)
                            <?php
                            $candidateJobApplyDetail[0] = $appliedJob;
                            $encId = Helper::encodeId($appliedJob['id']);
                            $job_validation_id = $appliedJob['job_validation_id'];
                            $candidateJobApplyEncID = $encId;
                            $is_publication_tab = "";
                            $formTabIdEnc = "gNTsS1S7wI0=";// echo Helper::encodeId(111);exit;
                            $jobValidations = Helper::get_job_validation_for_phd($job_validation_id);
                            if(!empty($jobValidations)){
                                $is_publication_tab = $jobValidations[0]['is_publication_tab'];
                            }                    
                            $postMasterDetail = Helper::getCodeNamesByCode($postsMasterArr, 'id', $appliedJob['post_id']);
                            $postName = "";
                            if(!empty($postMasterDetail)){
                                $domainMasterDetail = Helper::getCodeNamesByCode($domainAreaArr, 'id', $appliedJob['domain_id']);
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
                            $applicationStatus = "";
                            
                            $paymentReceiptHtml = "";
                            if($appliedJob['is_payment_required'] == 1 && $appliedJob['payment_status'] == 1 && $appliedJob['is_completed'] == 1){
                                $payReceiptUrl = route('pay_receipt',$encId );//https://thsti.in/bdpay/pay_receipt.php?txn_id=<?= base64_encode(strip_tags($u_rec['txn_id']))
                                $paymentReceiptHtml = '<a class="btn btn-success" href="'.$payReceiptUrl.'">Payment Receipt</button>';
                            }
                            
                            if ($appliedJob['payment_status'] == 0) {
                                $applicationStatus = "PENDING";
                            } 
                            else if ($appliedJob['payment_status'] == 1) {
                                $applicationStatus = 'RECEIVED';
                            }
                            else if ($appliedJob['payment_status'] == 2) {
                                $applicationStatus = 'Failed';
                            }
                            ?>
                            <tr align="center">
                                <td>{{ $appliedJob['rn_no'] }}</td>
                                <td><?php echo $postName; ?></td>
                                <td>
                                    <!-- candidate form steps --> 
                                    @include('application.candidate_form_steps')  
                                </td>
                                <td><?php echo $paymentReceiptHtml; ?></td>
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
