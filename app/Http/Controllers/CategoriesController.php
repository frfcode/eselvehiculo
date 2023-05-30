<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use stdClass;

class CategoriesController extends Controller
{
    //
    public function createCategory(Request $data){
        $categorieName = $data->input('category_name');
        
        Categories::create([
            'name' => $categorieName,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Categoria creado exitosamente.',
        ]);
    }

    public function configMenu(Request $data){
        $categorieItems = $data->input('menu_items');
        Storage::put('menu_items.json', json_encode($categorieItems));
        return response()->json([
            'success' => true,
            'message' => 'Configuracion guardada.',
        ]);
    }

    public function getCategories(){
        $categories = json_decode(Categories::orderBy('id', 'DESC')->get(), true);
        $filename = 'menu_items.json';
        $menu_items = '';
        if (Storage::exists($filename)) {
            $menu_items = json_decode(Storage::get($filename), true);
        }
        
    
        $output = [];
        $validate = false;
        foreach ($categories as $key => $categorie) {
            $obj = new stdClass();
            foreach ($menu_items as $key => $item) {
                if($item['name'] == $categorie['name']){
                    $validate = true;
                }
            }
            if($validate == true){
                $obj->name = $categorie['name'];
                $obj->id = $categorie['id'];
                $obj->check = true;
                array_push($output, $obj);
            }else{
                $obj->name = $categorie['name'];
                $obj->id = $categorie['id'];
                $obj->check = false;
                array_push($output, $obj);
            }
            $validate = false;
        }

        return response()->json([
            'success' => true,
            'categories' => $output,
        ]);
    }

    public function deleteCategory($categoryID){
        Categories::where('id',$categoryID)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Categoria eliminado exitosamente.',
        ]);
    }
}
