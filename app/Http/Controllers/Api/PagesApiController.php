<?php

namespace App\Http\Controllers\Api;

use App\Models\StaticSeo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AboutUsBlock;

class PagesApiController extends Controller
{
    public function getPages(Request $request)
    {
        $lang = request('lang');
        $slug = request('slug');
        $data['pages'] = AboutUsBlock::where('slug',$slug)->join('translates as c_title', 'c_title.id', 'about_us_blocks.title')
        ->join('translates as c_description', 'c_description.id', 'about_us_blocks.description')
        ->select('about_us_blocks.id','c_description.'.$lang.' as description','c_title.'.$lang.' as title', 'about_us_blocks.image')->first();

        $data['page_meta'] = StaticSeo::where('static_seos.page', $slug)->join('translates as title','title.id','static_seos.meta_title')->join('translates as description','description.id','static_seos.meta_title')
        ->select('static_seos.id','title.'.$lang.' as meta_title','description.'.$lang.' as meta_description','static_seos.created_at')->first();
        return response()->json($data);
    }
}