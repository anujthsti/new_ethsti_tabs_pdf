<?php
$str = 'TESTME|UATTXN0001|NA|2|NA|NA|NA|INR|NA|R|NA|NA|NA|F|Andheri|Mumbai|02240920005|support@billdesk.com|NA|NA|NA|https://www.billdesk.com';

$checksum = hash_hmac('sha256',$str,'Your-Checksum-Key-Here', false);
$checksum = strtoupper($checksum);
echo $checksum;
?>
