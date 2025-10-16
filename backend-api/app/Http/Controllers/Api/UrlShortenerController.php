<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Models\UrlShortener;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UrlShortenerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urls = UrlShortener::where("user_id", "=", Auth::user()->id)->get(['id', 'original_url', 'code', 'clicks', 'created_at']);        
        return response()->json($urls, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'original_url' => 'required|string',
                'custom_code' => 'string|max:10|unique:urlshortener',
            ]);
            if (!Str::isUrl($validated['original_url'])) {
                throw ValidationException::withMessages(['original_url' => 'This value is must be a valid url']);
            }
            if (!isset($validated['custom_code'])) {
                do {
                    $validated['custom_code'] = $this->getRandomString(10);
                } while (UrlShortener::where('code', '=', $validated['custom_code'])->count());
            }
            $url = UrlShortener::create([
                'user_id' => Auth::user()->id,
                'original_url' => $validated['original_url'],
                'code' => $validated['custom_code'],
                'clicks' => 0,
            ]);

            return response()->json(
                [
                    'id' => $url->id,
                    'user_id' => $url->user_id,
                    'original_url' => $url->original_url,
                    'code' => $url->code,
                    'clicks' => 0,
                    'created_at' => $url->created_at,
                ],
                201,
            );
        } catch (ValidationException $error) {
            return response()->json(
                [
                    'message' => $error->getMessage() ? $error->getMessage() : 'you should provide right values',
                ],
                422,
            );
        }
    }

    public function getRandomString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = random_int(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code)
    {
        $newURL = UrlShortener::where("code", "=", $code)->first();     
        header('Location: '.$newURL->original_url);
            $newURL->clicks ++;
            $newURL->save();    
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $url = UrlShortener::findOrFail($id);       
        if($url->user_id == Auth::user()->id){

            $url->delete();
            
            return response()->json(
                [
                    "message" => "Link deleted successfully"
                ],
                200
            );
        } else {
            return response()->json(
                [
                    "message" => "You cannot delete another user's link"
                ],
                405
            );
        }
    }
}
