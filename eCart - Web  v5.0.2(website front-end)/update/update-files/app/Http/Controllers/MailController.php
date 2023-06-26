<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {
    public function sendEmail(Request $request) {
     
        $ss = $this->validate($request, [ 'name' => 'required', 'email' => 'required|email', 'message' => 'required',  'g-recaptcha-response' => 'required|recaptchav3:recaptcha,0.5' ]);
        dd($ss);
        $data = array('name'=>$request->name,'email'=>$request->email,'msg'=>$request->message,'phone'=>$request->phone);

        // Mail::send(['text'=>'themes/eCart_01/mail'], $data, function($message) use ($data){
        //     $message->to('noreply@wrteam.in')->subject
        //     ('Contact From Website');
        //     $message->from($data['email']);
        // });
        dd('tes');
        //return redirect()->route('contact')->with('suc','Email send sucesssfully..!'); 
    }

}