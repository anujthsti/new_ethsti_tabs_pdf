  <div class="container">
      <div class="text-center h6">
        For any technical issue or support kindly contact at <a href="mailto:kambojanuj@thsti.res.in">kambojanuj@thsti.res.in</a>
      </div>
  </div>
  <!--Footer-->
  <footer class="application-footer bg-dark11 shadow application_footer" style="">
    <div class="container">
      <div class="text-center text-light h6">Copyright <?php echo date('Y'); ?> Translational Health Science and Technology Institute. All rights reserved.</div>
    </div>
  </footer>

  <script>
    <?php
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    if (strpos($url,'login') === false) {
    ?>
    var scale = window.innerWidth / 1280;
    $('head').append('<meta name="viewport" content="width=1280, initial-scale=' + scale + ', maximum-scale=' + scale + ', user-scalable=0">');
    <?php } ?>  

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function getCalculatedAge(dob, as_on_date){
        $.ajax({
            type:'POST',
            url:"{{ route('calculate_age') }}",
            data:{dob:dob, as_on_date:as_on_date},
            success:function(data){
              $('#age_id').val(data); 
            }
        });
    }

    function getCalculatedExperience(index, from_date, to_date){
        $.ajax({
            type:'POST',
            url:"{{ route('calculate_experience') }}",
            data:{from_date:from_date, to_date:to_date},
            success:function(data){
              $('#exp tbody tr:eq('+index+') td').find('.exp_total').val(data);
              $('#exp_grand_total').trigger('click');
            }
        });
    }

    $('#refresh_security_code').click(function(){
        $.ajax({
            type:'get',
            url:"{{ route('refresh_captcha') }}",
            success:function(data){
              $('#captcha').text(data); 
            }
        });
    });

    // grand total experience
    $('#exp_grand_total').click(function(){	  										
          $('.exp_grand_total').val('');
          let totalExp = $("input[name='exp_total[]']").map(function(){
                                                          var value = $(this).val();
                                                          value = value.replace(/, /g, "-");
                                                          return value;
                                                        }).get();
          //console.log('totalExp: '+totalExp);
          $.ajax({
              type:'post',
              url:"{{ route('calculate_grand_total_exp') }}",
              data:{totalExp:totalExp},
              success:function(data){
                $('#exp_grand_total').val(data); 
              }
          });
    });

    // get email otp
    $("#getEmailOtp").click(function(){
        let email = $("#email_id").val();
        if(email.length == 0){
          alert("Kindly enter your email id.");
        }else{
          $("#loader").show();
          $.ajax({
              type:'post',
              url:"{{ route('get_email_otp') }}",
              data:{email:email},
              success:function(data){
                $("#loader").hide();
                alert(data['msg']); 
              }
          });
        }
    });

    //$(document).ready(function(){
        
      function send_pay_receipt_email(job_apply_id_enc){

        let routeUrl = '{{ route("exportCandidateDetailsPdf",":id") }}';
        routeUrl = routeUrl.replace(':id', job_apply_id_enc);
        //alert(routeUrl);
        $.ajax({
              type:'get',
              url:routeUrl,
              success:function(msg){
                alert(msg); 
              }
          });
      }
      
    //});
  </script>

</body>
</html>