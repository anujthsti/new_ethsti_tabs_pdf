<!-- include header -->
@include('application.header')
<?php
$page_title = "THSTI Recruitment";
?>
@include('application.application_head')
<div class="" style="min-height:84vh;">
    
    <div class="container-fluid align-middle">   	     
        <div class="container">    
            <br><br><br>
            <div class="row">              
                <div class="col-lg-6 border mb-2 bg-dark11 rounded shadow application_header">         
                    <h3 class="col-lg-12 text-light mt-3 text-center">Login</h3>                                               
                    <div id="myform" class="container mt-2 col-12"> 
                    @if(session('errorMsg'))
                    <div class="alert alert-danger mb-1 mt-1">
                        {{ session('errorMsg') }}
                    </div>
                    @endif
                        <form action="{{ route('check_login') }}" method="post">     
                            @csrf
                            <div class="form-group">
                                <label for="email" class="text-light">Email address:</label>
                                <input type="email" class="form-control" name="email" id="c_email" placeholder="Email ID" aria-describedby="emailHelp" required />
                                @error('email')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="mobile" class="text-light">Mobile:</label>
                                <input type="text" class="form-control" name="mobile" id="c_mobile" placeholder="Mobile No" required />
                                @error('mobile')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div> 
                            <!--                    
                            <div class="form-group">
                                <label for="card" class="text-light"><input type="checkbox" name="card" value="card" /> &nbsp; Download admit card</label>    
                            </div>
                            -->
                            <div class="container form-group text-center">
                                <button id="submit" type="submit" class="btn btn-success text-center" name="submit" value="submit">Submit</button>               
                            </div>        
                        </form> 
                            
                    </div>             
                </div> 
                    
                <div class="col-lg-6 text-center ">   
                    <a href="{{ route('online_registration') }}" class="btn btn-primary p-4 shadow">New User Registration</a> 
                </div>
                        
            </div>                    
        
            <!--
            <div class="row mb-5 mt-5">
                <div class="container">
                    <p class="h2 text-danger text-center">IT IS RECOMMENDED TO USE GOOGLE CHROME / MICROSOFT EDGE BROWSER</p>
                </div>
            </div>
            -->
        </div>
    </div>
</div>
<!-- end of container-->



<!-- include footer -->
@include('application.footer')
