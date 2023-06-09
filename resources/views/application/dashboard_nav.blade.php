<style>
.dashboard_nav_class{
    margin: 0 10%;
}
.space_nav_class{
    display: block;
}
.back_btn{
    float: right;
}
@media screen and (max-width: 768px) {
    .dashboard_nav_class{
        margin: 0 0%;
    }
    .space_nav_class{
        display: none;
    }
}
</style>
<div class="dashboard_nav_class" style="">
    <div class="row bg-light pb-2">    
        <div class="col-6 pt-2 border-dark">
            <a href="<?php echo route('dashboard'); ?>">
                <button class="btn btn-light float-left border-dark" ><i class="fa fa-dashboard">&nbsp;Dashboard</i></button>
            </a>
        </div>
        <!--
        <div class="col-10 text-center text-danger pt-2 space_nav_class"></div>      
        -->
        <div class="col-6 pt-2 border-dark">
            <a href="<?php echo route('dashboard'); ?>">
                <button class="btn btn-light float-right1111 border-dark back_btn" ><i class="fa fa-arrow-left">&nbsp;Back</i></button>
            </a>
        </div>
    </div> 
</div>   