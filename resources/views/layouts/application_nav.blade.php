<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img class="logo" src="{{asset('thsti_logo.jpg')}}" alt="THSTI">
            </a>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 mx-auto">
            <h1 class="align-right">THSTI Recruitment</h1>
        </div>
    </div>
</div>
<!-- navigation start -->
<!--
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="https://thsti.res.in/"><i class="fa fa-home"></i> HOME</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://thsti.in/application/terms-conditions.pdf" target="_blank">TERMS & CONDITIONS</a>
        </li>
        <li class="nav-item">
            <a button="" type="button" class="btn btn-warning" href="https://thsti.in/application/dashboard.php"><i class="fa fa-sign-in">&nbsp;Dashboard</i></a>
        </li>
      </ul>
      
    </div>
  </div>
</nav>
-->
<!-- navigation end -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">  
        <a class="navbar-brand"  href="<?php echo route('dashboard'); ?>"><i class="fa fa-home"></i> HOME</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="https://thsti.in/application/terms-conditions.pdf" target="_blank">TERMS & CONDITIONS</a>
                </li>
                <li class="nav-item">
                    <a button="" type="button" class="btn btn-warning" href="<?php echo route('dashboard'); ?>"><i class="fa fa-sign-in">&nbsp;Dashboard</i></a>
                </li>
            </ul>
            
        </div>
    </div>
</nav>

