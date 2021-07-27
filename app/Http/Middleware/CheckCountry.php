<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Countries;
use App\Guides;

class CheckCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $slug_country = $request->slug_country;   
        $country = Countries::findBySlug($slug_country);
        if($country || $slug_country==='multi-country'){
            return $next($request);
        } 
        elseif($slug_country == 'admin'){
            return $next($request);
        }
        else{
            return redirect()->route('home');
        } 
    }
}
