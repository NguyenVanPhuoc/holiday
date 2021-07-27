<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Pages;
use App\Article;

class ErrorController extends Controller
{    
    public function notfound()
    {
    	$page = Pages::find(26);
        $seo = get_seo(26,'page');
        $data = [
            'page'=> $page,
            'seo'=> $seo,
        ];
        return view('errors.404',$data);
    }
    public function fatal()
    {
        return view('errors.500');
    } 
}