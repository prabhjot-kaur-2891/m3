<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UrlTokens;

class UrlController extends Controller
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
        
        try {
            $inputJSON = file_get_contents('php://input');
            $inputUrls = json_decode($inputJSON, TRUE);
            $arShortUrls = array();
            $arErros = array();
            foreach($inputUrls as $input) {
                if($input['url']) {
                    $longUrl = $input['url'];
                    $expiry = $input['expiry']?? null;
                    $token = $this->generateUniqueId();
    
                    $url = UrlTokens::create([
                        'destinationUrl' => $longUrl,
                        'shortUrl' => $token,
                        'expiry'=> $expiry,
                    ]);
                    $arShortUrls[$longUrl]['shorturl']= env('APP_URL').'/'.$token;
                    $arShortUrls[$longUrl]['expiry']= $expiry;
                }
            }
            return array('error'=>false, 'urls'=>json_encode($arShortUrls));
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
