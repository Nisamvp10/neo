<?php
namespace App\Controllers;
class CollectionsController extends BaseController{
    public function index($slug){
        $custProducts = getCollections($slug);
        $page = '';
        if ($slug == 'all') {
            $page = "Best Seller";
        }else{
            $page = ($custProducts ? str_replace('_',' ',ucfirst($slug). ' Products') : "");
        }
        return view('frontend/collections/collections',compact('custProducts','page'));
    }
    public function neonSign(){
       // return view('frontend/collections/neon-sign');
    }
}