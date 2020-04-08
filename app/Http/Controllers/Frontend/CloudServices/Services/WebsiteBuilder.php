<?php

namespace App\Http\Controllers\Frontend\CloudServices\Services;

use App\CloudService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonFunctions\Entrosement;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

use App\ServiceModel\CloudAPIBuilder\CloudAPIBuilder;
use App\MyService;
use DB;
use App\ServiceModel\QulintBuilder\QulintPage;
class WebsiteBuilder extends Controller
{
    public static function main_activity($service_id)
    {
        $get_pages_published = QulintPage::get_published_pages();
        $get_pages_unpublished = QulintPage::get_unpublished_pages();

        $tanle = [
            'get_pages_published' => $get_pages_published,
            'get_pages_unpublished' => $get_pages_unpublished,
            'service_id' => $service_id
        ];

        return $tanle;
    }

    public function insert_page (Request $request)
    {
        $page_title = $request->page_title;
        $service_id = $request->service_id;
        $page_type = $request->page_type;

        $get_page_id = QulintPage::create_qulint_pages($page_title,$service_id,$page_type,0,null,null,null);

        return back();
    }

    public function builder_panel ($q_id,$service_id)
    {

        return view('frontend.user.service_pages.QulintBuilder.pages.builder',
            [
                'service_id'=> $service_id,
                'q_id'=> $q_id,
            ]
            );
    }

    public function save_page (Request $request)
    {
        $q_id = $request->q_id;
        $html = $request->html;

        QulintPage::save_page($q_id,$html);


    }


    public function preview_qulint ($q_id)
    {
       $get_qulint = DB::table('qulint_pages')
           ->where('q_id',$q_id)
           ->where('user_id',auth()->user()->id)
           ->first();

       return view('frontend.user.service_pages.QulintBuilder.pages.page_preview',['get_qulint'=>$get_qulint]);
    }





}