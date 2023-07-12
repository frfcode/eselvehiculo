<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use App\Models\Vehicules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiculoController extends Controller
{
    //

    public function index(){
        $getBrandVehicule = explode('/',url()->current());
        //GET NAME BRAND OF VEHICULE
        $search = str_replace('_',' ',$getBrandVehicule[count($getBrandVehicule) - 1]);
        //GET DATA OF DATABASE
        $menu = json_decode(file_get_contents(storage_path() . "/app/menu_items.json"), true);
        $vehicule = Vehicules::where('vehicule_brand_model', 'like', '%' . $search . '%')->get();

        $title = 'Repuestos para '.strtoupper($search).' | eselvehiculo';
        $description = 'venta de repuestos para '.$search.', bujías, correas y accesorios para tú vehículo o carro con los mejores precios del mercado y gran variedad de marcas disponibles';

        //SET VIEW AND DATA
        return view('vehicule_brand', compact('menu', 'vehicule', 'title', 'description', 'search'));
    }

    public function compatible(){
        $getModelBrandVehicule = explode('/',url()->current());
        $getModelId = explode('_',$getModelBrandVehicule[count($getModelBrandVehicule) - 1]);
        //GET ID VEHICULE MODEL
        $search = $getModelId[count($getModelId) - 1];
        //GET DATA OF DATABASE
        $menu = json_decode(file_get_contents(storage_path() . "/app/menu_items.json"), true);

        $vehicule = Vehicules::select('vehicule_brand_model')->where('id',$search)->get();

        $title = 'Repuestos para '.$vehicule[0]->vehicule_brand_model.' | eselvehiculo';
        $description = 'venta de repuestos para '.$vehicule[0]->vehicule_brand_model.' '.$search.', bujías, correas y accesorios para tú vehículo o carro con los mejores precios del mercado y gran variedad de marcas disponibles';

        $products = Products::where('product_vehicule_compatibility', $search)->get();

        return view('vehicule_brand_model_details', compact('menu', 'vehicule', 'title', 'description', 'products'));
    }

    public function getVehicules(){
        $vehicules = Vehicules::orderBy('vehicule_brand_model', 'ASC')->get();
        return response()->json([
            'success' => true,
            'vehicules' => $vehicules,
        ]);
    }
}
