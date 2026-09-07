<?php
namespace App\Controllers;

use CodeIgniter\Controller;
class BusinessController extends BaseController {

    function __construct() {

    }

    public function index() {
        $page = "Business Logo";
        return view('frontend/business-logo',compact('page'));
    }
}