<style>
/* Custom CSS */
ul#wizardStatus{
  list-style:none;
  margin:15px 0;
  padding:0;
  text-align:center;
}
ul#wizardStatus li a{
    color: #ffffff !important;
}
ul#wizardStatus li{
  background-color:#d9d9ce;
  color:#3d4c4f;
  display:inline-block;
  margin:0;
  font-family:Arial,"Helvetica Neue",Helvetica,sans-serif;
  font-size:14px;
  line-height:30px;
  padding:0 25px 0 40px;
  position:relative
}

ul#wizardStatus li:first-child{
  padding-left:25px;
  -webkit-border-top-left-radius:3px;
  border-top-left-radius:3px;
  -webkit-border-bottom-left-radius:3px;
  border-bottom-left-radius:3px
}

ul#wizardStatus li:last-child{
  -webkit-border-top-right-radius:3px;
  border-top-right-radius:3px;
  -webkit-border-bottom-right-radius:3px;
  border-bottom-right-radius:3px
}

ul#wizardStatus li:after,
ul#wizardStatus li:before {
  background-color:#d9d9ce;
  content:"";
  display:block;
  position:absolute
}

ul#wizardStatus li:after{
  -webkit-border-radius:3px;
  border-radius:3px;
  border-right:3px solid white;
  border-top:3px solid white;
  height:21px;
  right:-15px;
  top:3px;
  -webkit-transform:rotate(45deg);
  -moz-transform:rotate(45deg);
  -ms-transform:rotate(45deg);
  -o-transform:rotate(45deg);
  transform:rotate(45deg);
  width:21px;
  z-index:5
}

ul#wizardStatus li:before{
  height:30px;
  right:3px;
  width:20px;
  z-index:6
}

ul#wizardStatus li:last-child:after,
ul#wizardStatus li:last-child:before{
  display:none
}

ul#wizardStatus li.current{
  background-color:#0597c5;
  color:#fff;
}

ul#wizardStatus li.current:after,
ul#wizardStatus li.current:before{
  background-color:#0597c5
}

ul#wizardStatus li.completed{
  background-color:#84BC00;
  color:#fff;
}

ul#wizardStatus li.completed:after,
ul#wizardStatus li.completed:before{
  background-color:#84BC00;
}

ul#wizardStatus li.notcompleted{
    background-color: orange;
    color:#fff;
}
ul#wizardStatus li.notcompleted:after,
ul#wizardStatus li.notcompleted:before{
  background-color: orange;
}

</style>
<?php
$candidateJobFormUrl = route('edit_candidate_applied_job_details', $candidateJobApplyEncID);
// basic information url start
$basicInformationRouteUrl = $candidateJobFormUrl;
//$basicInformationTabIdEnc = Helper::encodeId(1);  
// basic information url end
// qualification & experience information url start
$qualificationTabIdEnc = Helper::encodeId(2);  
$qualificationExperienceRouteUrl = $candidateJobFormUrl."/".$qualificationTabIdEnc;
// qualification & experience information url end
// phd detail information url start
$phdTabIdEnc = Helper::encodeId(3);  
$phdDetailsRouteUrl = $candidateJobFormUrl."/".$phdTabIdEnc;
// phd detail information url end
// documents upload information url start
$documentUploadTabIdEnc = Helper::encodeId(4);  
$documentUploadRoute = route('upload_candidate_documents', $candidateJobApplyEncID);
$documentUploadRouteUrl = $documentUploadRoute."/".$documentUploadTabIdEnc;
// documents upload information url end
// preview & final submit route start
$finalSubmitTabIdEnc = Helper::encodeId(5);  
$finalSubmitRoute = route('preview_application_final_submit', $candidateJobApplyEncID);
$finalSubmitRouteUrl = $finalSubmitRoute."/".$finalSubmitTabIdEnc;
// preview & final submit route end
// checkout route start
$checkoutPaymentTabIdEnc = Helper::encodeId(6);  
$checkoutPaymentRoute = route('preview_application_final_submit', $candidateJobApplyEncID);
$checkoutPaymentRouteUrl = $checkoutPaymentRoute."/".$checkoutPaymentTabIdEnc;
// checkout route end
?>
<ul id="wizardStatus"> 
    <li class="completed">
        <a href="<?php echo $basicInformationRouteUrl; ?>">Basic Information</a>
    </li>  
    <li class="current">
        <a href="<?php echo $qualificationExperienceRouteUrl; ?>">Qualification & Experience</a>
    </li>  
    @if($is_publication_tab == 1)  
    <li class="notcompleted">
        <a href="<?php echo $phdDetailsRouteUrl; ?>">PHD Details</a>
    </li>
    @endif
    <li class="notcompleted">
        <a href="<?php echo $documentUploadRouteUrl; ?>">Documents Upload</a>
    </li>  
    
    <li class="notcompleted">
        <a href="<?php echo $finalSubmitRouteUrl; ?>">Preview Application & Final Submit</a>
    </li>
    <li class="notcompleted">
        <a href="<?php echo $checkoutPaymentRouteUrl; ?>">Payment</a>
    </li>
</ul>
