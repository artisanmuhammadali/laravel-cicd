<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\SellerSurveyQuestion;
use App\Models\SellerProgram;

use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function sellerProgram()
    {
        return view('front.seller-program.index', get_defined_vars());
    }

    public function sellerSurvey()
    {
        $is_validate = $this->validateSellerForSurvey();
        if($is_validate)
        {
            return redirect()->route('index')->with('error',$is_validate);
        }

        $question = SellerSurveyQuestion::with('answers')->where('type','!=','answer')->orderBy('type','asc')->get();
        if($question->count() <=0 )
        {
            return redirect()->route('index')->with('error', "Sorry, but there are no more spots available for our Seller's Programme. 
            Check back later or look out for updates through our social media!");
        }
        return view('front.seller-program.seller-survey', get_defined_vars());
    }

    public function validateSellerForSurvey()
    {
        $user = auth()->user();
        if(!$user || ($user && ($user->role != 'seller' && $user->role != 'business')))
        {
            return 'Please login with a valid seller account!';
        }
        return !$user->sellerProgram ? null : 'You have already completed this survey!';
    }

    public function sellerSuccess(){
        if(auth()->user() && (url()->previous() == route('seller.survey.store'))){
            return view('front.seller-program.success-message', get_defined_vars());
        } else {
            return redirect()->back();
        }
    }
    
    public function storeSurvey(Request $req)
    {
        $is_pass = 1;
        $array = [];
        $user = auth()->user();
        foreach($req->question as $key => $ans){
            $question = SellerSurveyQuestion::findOrFail($key);
            if($question->type =='Text')
            {
                $array[$key] = ['question' => $question->option,'answer' => $ans, 'status' => 1,'type' => $question->type];
            }
            else{
                $answer = SellerSurveyQuestion::findOrFail($ans);
                if($answer->status == 1)
                {
                    $is_pass = 0;
                }
                $array[$key] = ['question' => $question->option,'answer' => $answer->option, 'status' => $is_pass,'type' => $question->type];
            }
          
        }
        $content = json_encode($array);
        if($is_pass == 0)
        {
            sendMail([
                'view' => 'email.seller-survey.survey-fail',
                'to' => $user->email,
                'subject' => "We Value Your Feedback - Complete Our Seller's Programme Survey",
                'data' => [
                    'subject'=>'Survey Email',
                    'user'=>$user,
                    'date'=>now()->format('Y/m/d'),
                ]
            ]);
        } else {
            sendMail([
                'view' => 'email.seller-survey.survey-pass',
                'to' => $user->email,
                'subject' => "We Value Your Feedback - Complete Our Seller's Programme Survey",
                'data' => [
                    'subject'=>'Survey Email',
                    'user'=>$user,
                    'date'=>now()->format('Y/m/d'),
                ]
            ]);
        }

        SellerProgram::create([
            'user_id' => $user->id,
            'content' => $content,
            'is_pass' => $is_pass,
        ]);
        
        return redirect()->route('seller.success')->with('success',' Submitted Successfully!');   
        
    }
}
