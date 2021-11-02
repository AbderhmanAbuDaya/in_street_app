<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OperationPath;
use App\Models\Regine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperationPathController extends Controller
{
    public function getAllSource()
    {
        $lang=\request()->header('lang');
        if (!array_search($lang,['','en','ar']))
            $lang='en';
        \request()->lang=$lang;
        $sources_ids=OperationPath::select([DB::raw("DISTINCT `source`")])->pluck('source');
        $sources=Regine::select('id','name_'.$lang.' as name')->whereIn('id',$sources_ids)->get();
        return response()->json([
           'code'=>200,
           'message'=>'success',
           'data'=>$sources
        ]);
    }

    public function getAllDestination($source)
    {
        $lang=\request()->header('lang');
        if (!array_search($lang,['','en','ar']))
            $lang='en';
        \request()->lang=$lang;
       $source= Regine::select('id','name_'.$lang.' as name')->where('id',$source)->first();
        if (!$source)
            return response()->json([
                'code' => 404,
                'message' => 'Source Not found ',
            ]);
        $destination_ids=OperationPath::select([DB::raw("DISTINCT `destination`")])->where('source',$source->id)->pluck('destination');
        $destinations=Regine::select('id','name_'.$lang.' as name')->whereIn('id',$destination_ids)->get();
        return response()->json([
            'code'=>200,
            'message'=>'success',
            'source'=>$source,
            'data'=>$destinations
        ]);
    }
}
