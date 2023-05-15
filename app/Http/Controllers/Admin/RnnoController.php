<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rn_no;
use App\Models\RnTypeDetails;
use Helper;

class RnnoController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function __construct(){
        //$unique = config("validations.unique");
        // get all code_names join with code_master
        $this->codeNamesArr = Helper::getCodeNames();
        // filter rn no. types by code from array
        $this->rn_no_types = Helper::getCodeNamesByCode($this->codeNamesArr,'code','rn_no_type');
        // filter THS RN types by code from array
        $this->ths_rn_types = Helper::getCodeNamesByCode($this->codeNamesArr,'code','ths_rn_types');
        
    }
        
    public function index()
    {
        $rn_nos = Rn_no::orderBy('id','desc')->get();
        return view('rn_no.manage_rn_no', compact('rn_nos'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function add_rnno($encodedId="")
    {
        $rnno = [];
        if(!empty($encodedId)){
            $id = Helper::decodeId($encodedId);
            $rnno = Rn_no::find($id);
        }
        $rn_no_types = $this->rn_no_types;
        $ths_rn_types = $this->ths_rn_types;
        /*
        echo "<pre>";
        print_r($rn_no_types);
        exit;*/
        return view('rn_no.add_rn_no',compact('rnno','rn_no_types','ths_rn_types'));
    }

    public function generate_new_rnno(){

        $rn_type_id = $_POST['rn_type_id'];
        $rn_type_code = $_POST['rn_type_code'];
        $ths_rn_type_id = $_POST['ths_rn_type_id'];
        $ths_rn_type_code = $_POST['ths_rn_type_code'];
        $maxRNNo = [];
        $rnTypeDetail = [];
        $isClinicalOrRollingRNNo = 0;
        $clinicalOrRollingRNNo = "";
        $sequenceCode = "";
        $cycle = "";
        $numCycle = "";
        $year = date('Y');
        $month = date('m');
        // get Max Rn No.
        $maxRNNo = Rn_no::orderBy('id','desc')
                             ->where('status',1)
                             ->where('rn_type_id',$rn_type_id)
                             ->limit(1)
                             ->get(['sequence_no','year','month','cycle'])
                             ->toArray();
        // get Rn Type details
        $rnTypeDetail = RnTypeDetails::where('status',1)
                             ->where('rn_type_id',$rn_type_id)
                             ->get(['prefix','sequence_start_from'])    
                             ->toArray();  

        if($rn_type_code == 'thsti'){
            // for THSTI
            if($ths_rn_type_code == 'other'){     
                // for other            
            }else{
                // for Clinical and Rolling
                $isClinicalOrRollingRNNo = 1;
                $maxRNNoOfClinicalOrRolling = Rn_no::orderBy('id','desc')
                             ->where('status',1)
                             ->where('rn_type_id',$rn_type_id)
                             ->where('ths_rn_type_id',$ths_rn_type_id)
                             ->where('year',$year)
                             ->where('month',$month)
                             ->limit(1)
                             ->get(['sequence_no','year','month','cycle'])
                             ->toArray();
                if(!empty($maxRNNoOfClinicalOrRolling)){             
                    $numCycle = $maxRNNoOfClinicalOrRolling[0]['cycle'];
                    $numCycle = $numCycle + 1;
                }else{
                    $numCycle = 1;
                }
                if($ths_rn_type_code == 'clinical'){ 
                    // for clinical
                    $sequenceCode = "02";
                    
                }
                else if($ths_rn_type_code == 'rolling'){
                    // for rolling
                    $sequenceCode = "01";
                }else{

                }
            }

        }   

        $prefix = "";
        if(!empty($rnTypeDetail)){
            $sequence_start_from = $rnTypeDetail[0]['sequence_start_from'];
            $prefix = $rnTypeDetail[0]['prefix'];
            $sequence_no = $sequence_start_from;
        }   
        if($isClinicalOrRollingRNNo == 0){
            if($rn_type_code == 'cdsa'){
                $sequence_no = 1;
            }else{
                $sequence_no = 3;
            }
            //print_r($maxRNNo);exit;           
            if(!empty($maxRNNo)){
                $max_sequence_no = $maxRNNo[0]['sequence_no'];
                $sequence_no = $max_sequence_no + 1;
            }
            $sequence_no = sprintf("%02d", $sequence_no);
            $sequenceCode = $sequence_no;
            $newRNNo = $prefix.'/'.$sequence_no.'/'.$year;
        }else{
            $month = date('m');
            $cycle = Helper::numberToRomanRepresentation($numCycle);
            $clinicalOrRollingRNNo = $prefix.'/'.$sequenceCode.'/'.$year.'/'.$month.'-'.$cycle;

            $newRNNo = $clinicalOrRollingRNNo;
        }
        $retData['newRNNo'] = $newRNNo;
        $retData['sequenceCode'] = $sequenceCode;
        $retData['cycle'] = $numCycle;
        return response()->json($retData);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function save_rnno(Request $request, $encodedId="")
    {
        $unique = config("validations.unique");
        $required = config("validations.required");
        $rnnoValidation = $unique.':rn_nos,rn_no';
        if(!empty($encodedId)){
            $rnnoValidation = $required;
        }
        $request->validate([
            'rn_no' => $rnnoValidation
        ]);
        $postData = $request->post();
        $postNewArray = [];
        if(isset($postData['rn_type']) && !empty($postData['rn_type'])){
            $postNewArray['rn_type_id'] = $postData['rn_type'];
        }
        if(isset($postData['ths_types']) && !empty($postData['ths_types'])){
            $postNewArray['ths_rn_type_id'] = $postData['ths_types'];
            $clinicalOrRollingIds = [115,116];
            if(in_array($postNewArray['ths_rn_type_id'], $clinicalOrRollingIds)){
                $postNewArray['month'] = (int)date('m');
                $postNewArray['cycle'] = (int)$postData['cycle'];
            }
        }
        //print_r($postNewArray);exit;
        if(isset($postData['sequenceCode']) && !empty($postData['sequenceCode'])){
            $postNewArray['sequence_no'] = (int)$postData['sequenceCode'];
        }
        $postNewArray['year'] = (int)date('Y');
        $postNewArray['rn_no'] = $postData['rn_no'];

        // file upload section start
        if(!empty($request->file('rn_file'))){
            try{
                $fileData = $request->file('rn_file');
                $destinationPath = "upload/rn_document";
                $maxFileSizeKB = 5*1024*1024;// in KB
                $fileExtentionArr = ['pdf'];// should be array
                $fileUploadRetArr = Helper::upload($fileData,$destinationPath,$maxFileSizeKB,$fileExtentionArr);
                if($fileUploadRetArr['status'] == 1){
                    $fileName = $fileData->getClientOriginalName();
                    $postNewArray['rn_document'] = $fileName;
                }else{
                    $errorMsg = $fileUploadRetArr['msg'];
                    //print_r($fileUploadRetArr);exit;
                    return redirect()->back()->with('file_error',$errorMsg);
                }
            }catch(\Exception $e){
                $errorMsg = $e->getMessage();
                return redirect()->back()->with('file_error',$errorMsg);
            }
        }
        
        // file upload section end
        if(!empty($encodedId)){
            $id = Helper::decodeId($encodedId);
            $rnnoData = Rn_no::find($id);
            $rnnoData->fill($postNewArray);
            $rnnoData->save();
            $rnnoData = "RN No. has been updated successfully";
        }else{
            /*
            echo "<pre>";
            print_r($postNewArray);
            exit;
            */
            Rn_no::create($postNewArray);
            $successMsg = "RN No. has been created successfully";
        }
        return redirect()->route('manage_rnno')->with('success','RN No. has been created successfully.');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Rn_no  $rn_no
    * @return \Illuminate\Http\Response
    */
    public function delete_rnno($encodedId)
    {
        //print_r($rn_no);exit;
        $postNewArray['status'] = 3;
        $id = Helper::decodeId($encodedId);
        $rnnoData = Rn_no::find($id);
        $rnnoData->fill($postNewArray);
        $rnnoData->save();
        return redirect()->route('manage_rnno')->with('success','RN No. has been deleted successfully');
    }

    
    ///////////////////////////////// manage RN Type Details functions ends
    public function manage_rn_type_details(){

        $rnTypeDetails = RnTypeDetails::join('code_names','code_names.id','=','rn_type_details.rn_type_id')
                                        ->where('rn_type_details.status', 1)
                                        ->get(['rn_type_details.*','code_names.code_meta_name']);
        return view('rn_no.manage_rn_type_details',compact('rnTypeDetails'));
        
    }

    public function add_rn_type_details($encodedId="")
    {
        $rnTypeDetail = [];
        if(!empty($encodedId)){
            $id = Helper::decodeId($encodedId);
            $rnTypeDetail = RnTypeDetails::find($id);
        }
        $master_code = 'rn_no_type';
        $rnTypes = Helper::getCodeNamesByMasterCode($master_code);
        return view('rn_no.add_rn_type_detail',compact('rnTypeDetail','rnTypes'));
    }

    public function save_rn_type_details(Request $request, $encodedId=""){

        $request->validate([
            'rn_type_id' => 'required',
            'prefix' => 'required',
            'sequence_start_from' => 'required'
        ]);

        $postData = $request->post();
        $postNewArray = $postData;
        // transactions start
        DB::beginTransaction();
        try{
            if(!empty($encodedId)){
                $id = Helper::decodeId($encodedId);
                RnTypeDetails::where('id', $id)->update(['status' => 3]);
                $successMsg = "RN type details has been updated successfully";
            }else{
                $successMsg = "RN type details has been created successfully";
            }
            RnTypeDetails::create($postNewArray);
            DB::commit();
            return redirect()->route('manage_rn_type_details')->with('success',$successMsg);
        }catch(\Exception $e){
            $errorMsg = $e->getMessage();
            DB::rollback();
            return redirect()->back()->with('error_msg',$errorMsg);
        }
        
    }

    ///////////////////////////////// manage RN Type Details functions ends


}
