<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Helper;
//use DataTables;
//use DB;
use App\Models\CodeMaster;
use App\Models\CodeNames;


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
    
}
