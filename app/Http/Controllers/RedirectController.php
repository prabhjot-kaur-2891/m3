<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UrlTokens;

use Carbon\Carbon;

class RedirectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //Get the destination URL through shortURL
    public function visit(string $token)
    {
        try { 
            $currentTime = Carbon::now();
            $url = UrlTokens::select('destinationUrl', 'expiry')
                    ->where('shortUrl', $token)
                    ->first();
            if($url) {
                if($url->expiry && strtotime($url->expiry) < strtotime($currentTime)) {
                    abort(404);
                } else {                    
                    return view('url', [
                        'url' => env('APP_URL').'/'.$url->destinationUrl,
                    ]);
                }
            } else {
                abort(404);
            }
        } catch (Exception $e) {
            return array('error'=>true, 'message'=>$e->getMessage());
        }
    }

}
