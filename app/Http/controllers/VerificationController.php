<?php

namespace App\Http\controllers\VerificationController;
//C:\xampp\htdocs\Portal\app\Http\controllers\VerificationController.php
use App\Http\controllers\Controller;

use DB;
use Illuminate\Http\Request;
use Mail;

class VerificationController extends Controller
{
    
    // --- === Verification View Function === --- \\
    public function Verification($school_token)
    {
        $data = DB::table('p_schools')->where('p_schools.school_token', $school_token)->get();
       
        return view('Web.Home.Verification', ['data' => $data]);
    }
    // --- === Verification View Function === --- \\

   public function SendOTP(Request $req){
$otp = rand(100000,999999);
    $check = DB::table('otp_storage')
    ->where('email', $req->input('email'))
    ->get();

if(count($check) > 0){
    $updateotp = DB::table('otp_storage')
    ->where('email', $req->input('email'))
    ->update(['otp' => $otp]);
    // return response()->json(['message' => "entry exists", 'data' => $check]);    
}
else{
    $storeotp = DB::insert('insert into otp_storage (otp, email) values (?, ?)', [$otp, $req->input('email')]);
    // return response()->json(['message' => "entry does not exists", 'data' => $storeotp]);
}

    $html="<h1>Thanks For Registering your token is ".$otp."</h1>";
    Mail::html($html, function($message) use($req) {
 $message->to($req->input('email'), 'Qazi Talha')->subject
    ('Campus Connect Verification Code');
});
    return response()->json(['success' => true, 'message' => 'School registration successfully completed.']);
   }

   public function VerifyOTP(Request $req){
    $check = DB::table('otp_storage')
    ->where('otp', $req->input('otp'))
    ->get();

if (count($check) > 0) {
    return response()->json(['success' => true, 'message' => 'Successfull']);
} else {
    return response()->json(['success' => false, 'message' => 'Error']);
}
   }
}
