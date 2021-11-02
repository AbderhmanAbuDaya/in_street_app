<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LookupName;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function getWhoWeAre()
    {
        $lang=\request()->header('lang');
        if (!array_search($lang,['','en','ar']))
            $lang='en';
        $whoWeAre=LookupName::with(['values'=>function ($q) use($lang){
            $q->select('lookup_values.id','name_'.$lang.' as text');
        }])->where('name','who_we_are')->first();
        return response()->json([
           'code'=>200,
            'message'=>'success',
            'data'=>$whoWeAre->values->first()->text
        ]);
    }

    public function getTermsConditions()
    {
        $lang=\request()->header('lang');
        if (!array_search($lang,['','en','ar']))
            $lang='en';
        $terms_and_conditions=LookupName::with(['values'=>function ($q) use($lang){
            $q->select('lookup_values.id','name_'.$lang.' as text');
        }])->where('name','terms_and_conditions')->first();
        return response()->json([
            'code'=>200,
            'message'=>'success',
            'data'=>$terms_and_conditions->values->first()->text
        ]);
    }

    public function getFeedback()
    {
        $lang=\request()->header('lang');
        if (!array_search($lang,['','en','ar']))
            $lang='en';
        $feedback_text=LookupName::with(['values'=>function ($q) use($lang){
            $q->select('lookup_values.id','name_'.$lang.' as text');
        }])->where('name','feedback_text')->first();
        return response()->json([
            'code'=>200,
            'message'=>'success',
            'data'=>$feedback_text->values->first()->text
        ]);
    }

    public function getSupport()
    {
        $lang=\request()->header('lang');
        if (!array_search($lang,['','en','ar']))
            $lang='en';
        $support_text=LookupName::with(['values'=>function ($q) use($lang){
            $q->select('lookup_values.id','name_'.$lang.' as text');
        }])->where('name','support_text')->first();
        return response()->json([
            'code'=>200,
            'message'=>'success',
            'data'=>$support_text->values->first()->text
        ]);
    }
    public function getSocialMedia()
    {
        $socialMedia=LookupName::with('values',function ($q){
            $q->select('id','name_en as name','name_ar as value');
        })->where('name','social_media')->first();
        return response()->json([
            'code'=>200,
            'message'=>'success',
            'data'=>$socialMedia->values
        ]);
    }
}
