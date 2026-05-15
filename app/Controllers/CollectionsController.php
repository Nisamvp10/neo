<?php
namespace App\Controllers;
class CollectionsController extends BaseController{
    public function index($slug){
        $custProducts = getCollections($slug);
        return view('frontend/collections/collections',compact('custProducts'));
    }
}