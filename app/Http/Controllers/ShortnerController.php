<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UrlTokens;

class ShortnerController extends Controller
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

    // Generate Short Url
    public function store(Request $request) { 

        $request->validate([
            'url' => 'required',
            'expiry' => 'date'
        ]);

        $longUrl = $request->input('url');
        $expiry = $request->input('expiry')?? null;
        $token = $this->generateUniqueId();
        
        try { 
            $url = UrlTokens::create([
                'destinationUrl' => $longUrl,
                'shortUrl' => $token,
                'expiry'=> $expiry,
            ]);
            $shortUrl = env('APP_URL').'/'.$token;
            return array('error'=>false, 'url'=>$shortUrl);
        } catch (Exception $e) {
            return array('error'=>true, 'message'=>$e->getMessage());
        }
    }

    private function generateUniqueId() {        
        $token = substr(md5(uniqid(rand(), true)),0,8);

        $url = UrlTokens::select('*')
                    ->where('shortUrl', $token)
                    ->first();
        if($url){
            $this->generateUniqueId();
        }
        return $token;
    }
}
