<?php

namespace App\Http\Controllers;

use App\Models\Codes;
use App\Models\Products;
use Illuminate\Http\Request;

class CodesController extends Controller
{
    //
    public function createCode(Request $data){
        $productAddCode = $data->input('code');

        $checkCode = Codes::where('code',$productAddCode)->get();

        if(count($checkCode) > 0){

            return response()->json([
                'success' => false,
                'message' => 'Código ya existe.',
            ]);

        }

        Codes::create([
            'code' => $productAddCode,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Código creado exitosamente.',
        ]);
    }

    public function getCodes(){

        $codes = Codes::orderBy('id', 'DESC')->get();
        return response()->json([
            'success' => true,
            'codes' => $codes,
        ]);
    }

    public function deleteCode($codeID){
        Codes::where('id',$codeID)->delete();
        Products::where('code',$codeID)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Código eliminado exitosamente.',
        ]);
    }
}
