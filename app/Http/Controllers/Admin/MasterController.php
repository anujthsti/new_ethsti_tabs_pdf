<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Helper;
//use DataTables;
//use DB;
use App\Models\CodeMaster;
use App\Models\CodeNames;
use App\Models\ShortlistedResults;
use App\Models\Rn_no;
use App\Models\Jobs;

class MasterController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function __construct(){
        
    }
    
    /*    
    public function index()
    {
        $rn_nos = Rn_no::orderBy('id','desc')->get();
        return view('rn_no.manage_rn_no', compact('rn_nos'));
    }
    */
    /********************** CodeMaster functions start ***********************/
    public function manage_codes()
    {
        $codes = CodeMaster::orderBy('id','desc')->get();
        return view('masters.manage_codes', compact('codes'));
    }


    public function add_code($encodedId=""){

            return view('masters.add_code');
    }

    public function edit_code($encodedId){
        $id = Helper::decodeId($encodedId);
        $code = CodeMaster::find($id);
        return view('masters.add_code',compact('code'));
    }

    public function save_code(Request $request, $encodedId="")
    {

        $nameValidation = config("validations.name");
        $request->validate([
            'code_name' => $nameValidation
        ]);
        if(!empty($encodedId)){
            $id = Helper::decodeId($encodedId);
            $codeMaster = CodeMaster::find($id);
            $postArr = $request->all();
            $insertArr['code_name'] = $postArr['code_name'];
            $codeMaster->fill($request->all());
            $codeMaster->save();
            $successMsg = "Code has been updated successfully";
        }else{
            $insertData = $request->post();
            $code_name = trim(strtolower($insertData['code_name']));
            $code_name = str_replace(" ", "_", $code_name);
            $insertData['code'] = $code_name;
            CodeMaster::create($insertData);
            $successMsg = "Code has been created successfully";
        }
        
        return redirect()->route('manage_codes')->with('success',$successMsg);

    }

    public function delete_code($encodedId)
    {
        //print_r($rn_no);exit;
        /*
        $id = Helper::decodeId($encodedId);
        $rnno = CodeMaster::find($id);
        $rnno->delete();
        */
        return redirect()->route('manage_codes')->with('success','Code has been deleted successfully');

    }

    /********************** CodeMaster functions end ***********************/

    /********************** CodeNames functions start ***********************/    

    public function manage_code_names($masterEncId=""){
        $codesMasters = CodeMaster::orderBy('id','desc')->get();
        if(isset($masterEncId) && !empty($masterEncId)){
            $masterId = Helper::decodeId($masterEncId);
            $code_names = CodeNames::join('code_master', 'code_master.id', '=', 'code_names.code_id')
            ->where('code_id', $masterId)
            ->get(['code_names.id', 'code_names.code_id', 'code_names.code_meta_name','code_master.code_name','code_names.code']);
        }else{
            $code_names = CodeNames::join('code_master', 'code_master.id', '=', 'code_names.code_id')
                        ->get(['code_names.id', 'code_names.code_id', 'code_names.code_meta_name','code_master.code_name','code_names.code']);
        }
        //print_r($code_names);exit;
        return view('masters.manage_code_names', compact('code_names','codesMasters','masterEncId'));
    }

    public function add_code_name($encodedId=""){
        $codes = CodeMaster::orderBy('id','desc')->get();
        return view('masters.add_code_name',compact('codes'));
    }

    public function edit_code_name($encodedId){
        $id = Helper::decodeId($encodedId);
        $code_name = CodeNames::find($id);
        $codes = CodeMaster::orderBy('id','desc')->get();
        return view('masters.add_code_name',compact('code_name','codes'));
    }

    public function save_code_name(Request $request, $encodedId="")
    {

        $nameValidation = config("validations.name");
        $requiredValidation = config("validations.required");
        $request->validate([
            'code_meta_name' => $nameValidation,
            'code_id' => $requiredValidation
        ]);
        if(!empty($encodedId)){
            $id = Helper::decodeId($encodedId);
            $codeName = CodeNames::find($id);
            $insertData = $request->all();
            //$code_meta_name = trim(strtolower($insertData['code_meta_name']));
            //$code_meta_name = str_replace(" ", "_", $code_meta_name);
            //$insertData['code'] = $code_meta_name;
            //print_r($insertData);exit;
            $codeName->fill($insertData);
            
            $codeName->save();
            $successMsg = "Code Name has been updated successfully";
        }else{
            $insertData = $request->post();
            $code_meta_name = trim(strtolower($insertData['code_meta_name']));
            $code_meta_name = str_replace(" ", "_", $code_meta_name);
            $insertData['code'] = $code_meta_name;
            CodeNames::create($insertData);
            $successMsg = "Code Name has been created successfully";
        }
        
        return redirect()->route('manage_code_names')->with('success',$successMsg);

    }

    public function destroy_code_name($encodedId)
    {
        //print_r($rn_no);exit;
        /*
        $id = Helper::decodeId($encodedId);
        $rnno = CodeNames::find($id);
        $rnno->delete();
        */
        return redirect()->route('manage_code_names')->with('success','Code Name has been deleted successfully');
    }

    /********************** CodeNames functions end ***********************/    
    
    /********************** Shortlisted Results start *********************/
    public function manage_shortlisted_results(){

        $shortlistedResults = ShortlistedResults::join('rn_nos','rn_nos.id','=','shortlisted_results.rn_no_id')
                                                ->join('jobs','jobs.id','=','shortlisted_results.job_id')
                                                ->orderBy('shortlisted_results.id','desc')
                                                ->where('shortlisted_results.status',1)
                                                ->get(['rn_nos.rn_no','shortlisted_results.*','jobs.post_id'])
                                                ->toArray();
        $postMasterId = 15;                                        
        $postsArr = CodeNames::where('code_id','postMasterId')->get(['code_names.*'])->toArray();
                                                
        return view("shortlist_result/manage_shortlisted_results",compact('shortlistedResults','postsArr'));
    }

    public function delete_shortlisted_results($encodedId)
    {
        $id = Helper::decodeId($encodedId);
        $rnno = ShortlistedResults::where('id', $id)->update(['status' => 3]);
        return redirect()->route('manage_shortlisted_results')->with('success','Code Name has been deleted successfully');
    }

    public function add_shortlisted_results($encodedId=""){

        $rnNos = Rn_no::orderBy('id','desc')->get()->toArray();
        $shortlistedResults = [];
        if(!empty($encodedId)){
            $id = Helper::decodeId($encodedId);
            $shortlistedResults = ShortlistedResults::where('id', $id)->get()->toArray();
        }
        return view("shortlist_result/add_shortlisted_results", compact('rnNos', 'shortlistedResults', 'encodedId'));
    }

    public function get_posts_by_rnno(Request $request){
        
        $postData = $request->post();
        $rn_no_id = $postData['rn_no_id'];
        $job_id = "";
        if(isset($postData['job_id']) && !empty($postData['job_id'])){
            $job_id = $postData['job_id'];
        }
        $postsArr = [];
        if(isset($rn_no_id) && !empty($rn_no_id)){
            $postsArr = Jobs::join('code_names','code_names.id','=','jobs.post_id')
                            ->where('rn_no_id', $rn_no_id)
                            ->get(['jobs.id','code_names.code_meta_name'])
                            ->toArray();
        }
        $html = '<option value="">Select Job</option>';   
        foreach($postsArr as $post){
            $selected = "";
            if($post['id'] == $job_id){
                $selected = "selected";
            }
            $html .= '<option value="'.$post['id'].'" '.$selected.'>'.$post['code_meta_name'].'</option>';
        }
        echo $html;
    }


    public function save_shortlisted_results(Request $request, $encodedId=""){

        $requiredValidation = config("validations.required");
        $request->validate([
            'rn_no_id' => $requiredValidation,
            'job_id' => $requiredValidation,
            'shortlisted_title' => $requiredValidation,
            'date_of_interview' => $requiredValidation,
            'alternate_text' => $requiredValidation,
            'upload_file' => $requiredValidation,
            'announcement' => $requiredValidation
        ]);
        $fileName = "";
        if(!empty($request->file('upload_file'))){
            $fileData = $request->file('upload_file');
            $destinationParentFolderPath = config('app.shortlisted_result_doc_path');
            $destinationPath = $destinationParentFolderPath;
            $maxFileSizeKB = 1000*1024;// 200 KB
            $fileExtentionArr = ['pdf'];// should be array
            $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
            if($fileUploadRetArr['status'] == 1){
                $fileName = $fileData->getClientOriginalName();
                $isDocsUploaded = 1;
            }else{
                $errorMsg = $fileUploadRetArr['msg'];
                array_push($errorMsgArr,$errorMsg);
                $isFileUploadError = 1;
                return redirect()->back()->withInput()->with('file_error',$errorMsg);
            }
        }

        if(!empty($encodedId)){
            $id = Helper::decodeId($encodedId);
            $shortListedResult = ShortlistedResults::find($id);
            $insertData = $request->all();
            if(!empty($fileName)){
                $insertData['upload_file'] = $fileName;
            }
            $shortListedResult->fill($insertData);
            
            $shortListedResult->save();
            $successMsg = "Result has been updated successfully";
        }else{
            $insertData = $request->post();
            if(!empty($fileName)){
                $insertData['upload_file'] = $fileName;
            }
            ShortlistedResults::create($insertData);
            $successMsg = "Result has been created successfully";
        }
        
        return redirect()->route('manage_shortlisted_results')->with('success',$successMsg);

    }
    
    /********************** Shortlisted Results end *********************/

}
