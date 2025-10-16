<?php

namespace App\Http\Controllers\Api;

use App\Models\Module;
use App\Models\User_module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modules = Module::all('id', 'name', 'description') ;

        return response()->json(
            $modules
        ,200);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function activate(Request $request)
    {        
        $module = Module::findOrFail($request->id);
        if (!is_null($module)) {
            $user_module = User_module::where([['user_id', '=',  Auth::user()->id], ['module_id', '=', $module->id]])->first();
            if (!$user_module) {
                $user_module = User_module::create([
                    'user_id' => Auth::user()->id,
                    'module_id' => $module->id,
                    'active' => 1
                    ]
                    
                );
            } else{
                $user_module->active = 1;
                $user_module->save();
            }
            return response()->json([
                "message" => "Module activated"
            ], 200);
        } else {
            return response()->json([
                "message" => "Module not found"
            ], 404);
        }
    }

    public function desactivate(Request $request)
    {        
        $module = Module::findOrFail($request->id);
        if (!is_null($module)) {
            $user_module = User_module::where([['user_id', '=',  Auth::user()->id], ['module_id', '=', $module->id]])->first();
            if (!$user_module) {
                $user_module = User_module::create([
                    'user_id' => Auth::user()->id,
                    'module_id' => $module->id,
                    'active' => 0
                    ]
                    
                );
            } else{
                $user_module->active = 0;                
                $user_module->save();
            }
            return response()->json([
                "message" => "Module desactivated"
            ], 200);
            
        }else {
            return response()->json([
                "message" => "Module not found"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
