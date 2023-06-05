<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShortUrlController extends Controller
{
    const tinyurl = 'https://tinyurl.com/api-create.php?url=';
    
    public function create(Request $request)
    {
        $url = $request->input('url');
        
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return response()->json(['error' => 'Invalid URL'], 400);
        }
        
        $tinyUrl = file_get_contents(self::tinyurl . urlencode($url));
        
        return response()->json(['url' => $tinyUrl], 201);
    }
}
