<!-- include header -->
@include('application.header')
<div class="inst-body">
    <div class="container-fluid bg-dark shadow">
        <div class="h2 text-light text-center p-3">Instructions for the candidates to fill up online application form</div>
    </div> 
    <br><br><br> 
    <div class="container-fluid">   	     
        
        <div class="row p-3">	    
                
            <div class="col-lg-8 col-md-12 border border-muted">
                <div style="text-align: justify;">
                    <span style="font-size: 16px;">
                        a.
                        <span style="white-space: pre;"> </span>
                        Before filling online application, do keep the following documents handy:
                    </span>
                </div>
                <div style="text-align: justify;">
                    &nbsp;</div>
                <div style="margin-left: 40px; text-align: justify;">
                    <span style="font-size: 16px;">i.&nbsp; &nbsp;A soft copy of your passport size photo.</span>
                </div>
                <div style="margin-left: 40px; text-align: justify;">
                    <span style="font-size: 16px;">ii. A comprehensive CV (PDF format only) containing details ofqualification, positions held, professional experience/distinctions etc.</span>
                </div>
                <div style="margin-left: 40px; text-align: justify;">
                    &nbsp;
                </div>
                <div style="text-align: justify;">
                    <span style="font-size: 16px;">b.&nbsp;Candidates are requested to use Google Chrome internet&nbsp; browser&nbsp; for best results in&nbsp;</span><span style="font-size: 16px;">submission of online application.</span>
                </div>
                <div style="text-align: justify;">
                    &nbsp;
                </div>
                <div style="text-align: justify;">
                    <span style="font-size: 16px;">c.<span style="white-space: pre;"> </span>Once online application is submitted,no correction/modification is possible.</span>
                </div>
                <div style="text-align: justify;">
                    &nbsp;
                </div>
                <div style="text-align: justify;">
                    <span style="font-size: 16px;">d.&nbsp;<span style="white-space: pre;"> </span>In case of difficulty in filling up the online form, please send an email to personnel@thsti.res.in</span>
                </div>
                <div style="text-align: justify;">
                    &nbsp;
                </div>
                <div style="text-align: justify;">
                    <span style="font-size: 16px;">e.&nbsp;On successful submission of your application, an auto-generated email containing a reference number will be sent to the email&nbsp; address provided. Please keep a note of the reference number for future correspondence.</span>
                </div>
            </div>      
            
            <div class="col-lg-4 col-md-4 col-sm-3 text-center">                                 	     
                <a class="btn btn-primary h3 shadow" type="btn" href="{{ route('candidate_dashboard_login') }}"><h3>Login/Register</h3></a>
                <h6 class="text-danger text-center mb-3">#Login Dashboard to apply, update, print & pay online. </h6>                           
            </div>
    
        </div>  

        <div class="row mb-5 mt-5">
            <div class="container">
                <p class="h2 text-danger text-center">IT IS RECOMMENDED TO USE GOOGLE CHROME / MICROSOFT EDGE BROWSER</p>
            </div>
        </div>
    </div>
</div>
<!-- end of container-->



<!-- include footer -->
@include('application.footer')
