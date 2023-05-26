<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RnnoController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\JobsController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Admin\HRShortlistingController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('manage_rnno');
});

//Route::prefix('admin')->namespace('Admin')->group(['middleware' => ['auth', 'verified']], function() {
Route::group(['prefix'=>'admin','middleware' => ['auth', 'verified']], function() {
    
    //Route::resource('roles', RoleController::class);
    //Route::resource('users', UserController::class);
    //Route::resource('products', ProductController::class);
    
    // dashboard route
    /*
    Route::get('/', function () {
        
        return view('dashboard');
    })->name('dashboard');
    */
    //Route::resource('admin/rnno', RnnoController::class);

    //Route::get('admin/rnnolist', 'Admin\RnnoController@list')->name('rnno.list');
    
    // ajax request route to get list
    //Route::get('rnno/list', [RnnoController::class, 'list']);
    //Route::get('/admin/rnno/getAjaxRNNos', 'App\Http\Controllers\RnnoController@getAjaxRNNos')->name('rnno.list');
    // RN No. start
    Route::controller(RnnoController::class)->group(function () {
        // manage RN No. start
        Route::get('manage_rnno', 'index')->name('manage_rnno');
        Route::get('rnno/add_rnno', 'add_rnno')->name('add_rnno');
        Route::get('rnno/edit_rnno/{id}', 'add_rnno')->name('edit_rnno');
        Route::post('rnno/save_rnno/{id?}', 'save_rnno')->name('save_rnno');
        Route::get('rnno/delete_rnno/{id}', 'delete_rnno')->name('delete_rnno');
        Route::post('generate_new_rnno','generate_new_rnno')->name('generate_new_rnno');
        // manage RN No. end
        // manage RN Type Details start
        Route::get('manage_rn_type_details', 'manage_rn_type_details')->name('manage_rn_type_details');
        Route::get('add_rn_type_details', 'add_rn_type_details')->name('add_rn_type_details');
        Route::get('rnno/edit_rn_type_details/{id}', 'add_rn_type_details')->name('edit_rn_type_details');
        Route::post('rnno/save_rn_type_details/{id?}', 'save_rn_type_details')->name('save_rn_type_details');
        // manage RN Type Details end
    });
    // RN No. end
    // Code Master start
    Route::controller(MasterController::class)->group(function () {
        // routes for manage codes start
        Route::get('manage_codes', 'manage_codes')->name('manage_codes');
        Route::get('add_code', 'add_code')->name('add_code');
        Route::get('edit_code/{id}', 'edit_code')->name('edit_code');
        Route::post('save_code/{id?}', 'save_code')->name('save_code');
        Route::delete('delete_code/{id}', 'delete_code')->name('delete_code');
        // routes for manage codes end
        // routes for manage codes names start
        Route::get('manage_code_names/{id?}', 'manage_code_names')->name('manage_code_names');
        Route::get('add_code_name', 'add_code_name')->name('add_code_name');
        Route::get('edit_code_name/{id}', 'edit_code_name')->name('edit_code_name');
        Route::post('save_code_name/{id?}', 'save_code_name')->name('save_code_name');
        Route::delete('destroy_code_name/{id}', 'destroy_code_name')->name('destroy_code_name');
        // routes for manage codes names end
        
    });
    // Code Jobs route start
    Route::controller(JobsController::class)->group(function () {
        // routes for manage jobs start
        Route::get('manage_jobs', 'index')->name('manage_jobs');
        Route::get('add_job', 'add_job')->name('add_job');
        Route::get('edit_job/{id}', 'add_job')->name('edit_job');
        Route::post('save_job/{id?}', 'save_job')->name('save_job');
        Route::get('delete_job/{id}', 'delete_job')->name('delete_job');
        // routes for manage jobs end
        // routes for jobs validations start
        Route::get('manage_jobs_validation', 'manage_jobs_validation')->name('manage_jobs_validation');
        Route::get('add_job_validation', 'add_job_validation')->name('add_job_validation');
        Route::get('edit_job_validation/{id}', 'add_job_validation')->name('edit_job_validation');
        Route::post('save_job_validation/{id?}', 'save_job_validation')->name('save_job_validation');
        Route::get('delete_job_validation/{id}', 'delete_job_validation')->name('delete_job_validation');
        Route::post('ajaxGetJobsDropdownhtml', 'ajaxGetJobsDropdownhtml')->name('ajaxGetJobsDropdownhtml');
        // routes for jobs validations end

        // routes for form tabs start
        Route::get('manage_form_tabs', 'manage_form_tabs')->name('manage_form_tabs');
        Route::get('add_form_tab', 'add_form_tab')->name('add_form_tab');
        Route::get('edit_form_tab/{id}', 'add_form_tab')->name('edit_form_tab');
        Route::post('save_form_tab/{id?}', 'save_form_tab')->name('save_form_tab');
        Route::get('delete_form_tab/{id}', 'delete_form_tab')->name('delete_form_tab');
        Route::post('update_form_tabs_sorting', 'update_form_tabs_sorting')->name('update_form_tabs_sorting');
        // routes for form tabs end

        // routes for form tab field start
        Route::get('manage_form_fields', 'manage_form_fields')->name('manage_form_fields');
        Route::get('add_form_field', 'add_form_field')->name('add_form_field');
        Route::get('edit_form_field/{id}', 'add_form_field')->name('edit_form_field');
        Route::post('save_form_field/{id?}', 'save_form_field')->name('save_form_field');
        Route::get('delete_form_field/{id}', 'delete_form_field')->name('delete_form_field');
        // routes for form tab field end

        // routes for form configuration start
        Route::get('manage_form_configuration', 'manage_form_configuration')->name('manage_form_configuration');
        Route::get('add_form_configuration', 'add_form_configuration')->name('add_form_configuration');
        Route::get('edit_form_configuration/{id}', 'add_form_configuration')->name('edit_form_configuration');
        Route::post('save_form_configuration/{id?}', 'save_form_configuration')->name('save_form_configuration');
        Route::get('delete_form_configuration/{id}', 'delete_form_configuration')->name('delete_form_configuration');
        // routes for form configuration end

        // routes for exam center mapping start
        Route::get('add_exam_center_mapping/{id?}', 'add_exam_center_mapping')->name('add_exam_center_mapping');
        Route::post('save_exam_center_mapping/{id?}','save_exam_center_mapping')->name('save_exam_center_mapping');
        Route::get('manage_exam_centers_mapping','manage_exam_centers_mapping')->name('manage_exam_centers_mapping');
        
        Route::get('edit_exam_center_mapping/{id?}/{jobId?}','add_exam_center_mapping')->name('edit_exam_center_mapping');
        Route::get('delete_exam_center_mapping/{id?}/{jobId?}','delete_exam_center_mapping')->name('delete_exam_center_mapping');
        
        // routes for exam center mapping end
        
        // routes for form field types start
        /*
        Route::get('manage_form_field_types', 'manage_form_field_types')->name('manage_form_field_types');
        Route::get('add_form_field_type', 'add_form_field_type')->name('add_form_field_type');
        Route::get('edit_form_field_type/{id}', 'add_form_field_type')->name('edit_form_field_type');
        Route::post('save_form_field_type/{id?}', 'save_form_field_type')->name('save_form_field_type');
        Route::get('delete_form_field_type/{id}', 'delete_form_field_type')->name('delete_form_field_type');
        */
        // routes for form field types end
        


    });
    // Code Jobs route end

    // hr shortlisting route start
    Route::controller(HRShortlistingController::class)->group(function () {
        Route::get('candidate_list/{rn_type_id?}/{ths_rn_type_id?}/{rn_no_id?}/{post_id?}/{filter_id?}', 'candidate_list')->name('candidate_list');
        Route::get('candidate_print/{id}', 'candidate_print')->name('candidate_print');
        Route::post('save_candidate_shortlisting/{id}', 'save_candidate_shortlisting')->name('save_candidate_shortlisting');
        Route::get('candidates_export_to_excel/{rn_no_id?}/{post_id?}/{filter_id?}', 'candidates_export_to_excel')->name('candidates_export_to_excel');
        
        
    });
    // hr shortlisting route end
    
});

Route::group(['prefix'=>'application'], function() {

    // non-login routes
    Route::controller(ApplicationController::class)->group(function () {

        // routes for candidates 
        // to view jobs
        Route::get('jobs/{id?}', 'jobs')->name('jobs_list');
        Route::get('instructions/{id?}','instructions')->name('jobs_instructions');
        Route::get('login','login')->name('candidate_dashboard_login');
        Route::post('check_login','check_login')->name('check_login');
        Route::get('logout','logout')->name('dashboard_logout');
        /*
        Route::get('online_registration','online_registration')->name('online_registration');
        Route::post('calculate_age','calculate_age')->name('calculate_age');
        Route::get('refresh_captcha','refresh_captcha')->name('refresh_captcha');
        Route::post('save_registration_details','save_registration_details')->name('save_registration_details');
        Route::get('dashboard','dashboard')->name('dashboard');
        Route::get('edit_candidate_applied_job_details/{id}','edit_candidate_applied_job_details')->name('edit_candidate_applied_job_details');
        Route::get('upload_candidate_documents/{id}','upload_candidate_documents')->name('upload_candidate_documents');
        Route::post('update_candidate_upload_documents/{id}','update_candidate_upload_documents')->name('update_candidate_upload_documents');
        Route::post('calculate_experience','calculate_experience')->name('calculate_experience');
        Route::post('calculate_grand_total_exp','calculate_grand_total_exp')->name('calculate_grand_total_exp');
        Route::post('update_candidate_applied_job_details/{id}','update_candidate_applied_job_details')->name('update_candidate_applied_job_details');
        */
        Route::get('online_registration','online_registration')->name('online_registration');
        Route::post('calculate_age','calculate_age')->name('calculate_age');
        Route::get('refresh_captcha','refresh_captcha')->name('refresh_captcha');
        Route::post('save_registration_details','save_registration_details')->name('save_registration_details');
        Route::post('calculate_experience','calculate_experience')->name('calculate_experience');
        Route::post('calculate_grand_total_exp','calculate_grand_total_exp')->name('calculate_grand_total_exp');
        Route::get('payment_response','payment_response')->name('payment_response');
        Route::get('pay_receipt/{id}/{tab_id?}','pay_receipt')->name('pay_receipt');
        Route::get('croneCheckCandidatePaymentStatus','croneCheckCandidatePaymentStatus')->name('croneCheckCandidatePaymentStatus');
        
        Route::post('get_email_otp','get_email_otp')->name('get_email_otp');

        Route::get('send_mail','send_mail')->name('send_mail');
        Route::get('exportCandidateDetailsPdf/{id}','exportCandidateDetailsPdf')->name('exportCandidateDetailsPdf');
        Route::get('croneSendEmailAfterPayment','croneSendEmailAfterPayment')->name('croneSendEmailAfterPayment');
    });

});

Route::group(['prefix'=>'application','middleware' => 'candidatesession'], function() {

    // non-login routes
    Route::controller(ApplicationController::class)->group(function () {

        // routes for candidates 
        // to view jobs
        /*
        Route::get('jobs/{id?}', 'jobs')->name('jobs_list');
        Route::get('instructions/{id?}','instructions')->name('jobs_instructions');
        Route::get('login','login')->name('candidate_dashboard_login');
        Route::post('check_login','check_login')->name('check_login');
        Route::get('logout','logout')->name('dashboard_logout');
        */
        Route::get('dashboard','dashboard')->name('dashboard');
        Route::get('edit_candidate_applied_job_details/{id}/{tabid?}','edit_candidate_applied_job_details')->name('edit_candidate_applied_job_details');
        Route::get('upload_candidate_documents/{id}/{tab_id?}','upload_candidate_documents')->name('upload_candidate_documents');
        Route::post('update_candidate_upload_documents/{id}/{tab_id?}','update_candidate_upload_documents')->name('update_candidate_upload_documents');
        Route::post('update_candidate_applied_job_details/{id}/{tab_id?}','update_candidate_applied_job_details')->name('update_candidate_applied_job_details');
        Route::get('preview_application_final_submit/{id}/{tab_id?}','preview_application_final_submit')->name('preview_application_final_submit');
        Route::post('application_final_submission/{id}/{tab_id?}','application_final_submission')->name('application_final_submission');
        Route::get('checkout/{id}/{tab_id?}','checkout')->name('checkout');
        Route::post('add_fee_transaction/{id}','add_fee_transaction')->name('add_fee_transaction');
        Route::get('final_submission_after_payment/{id}/{tab_id?}','final_submission_after_payment')->name('final_submission_after_payment');
        
        Route::post('save_final_submission_after_payment/{id}/{tab_id?}','save_final_submission_after_payment')->name('save_final_submission_after_payment');
        
    });

});


/*
Route::prefix('admin')->namespace('Admin')->group(static function() {

    Route::middleware('auth')->group(static function () {
        //...
        Route::resource('rnno', '\App\Http\Controllers\Admin\RnnoController');
    });
});
*/
//Route::get('admin/rnno/list', [RnnoController::class, 'list']);
/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('rnno', RnnoController::class)->middleware(['auth', 'verified']);
*/
require __DIR__.'/auth.php';
