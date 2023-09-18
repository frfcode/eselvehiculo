<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Categories;
use App\Models\Codes;
use App\Models\Products;
use App\Models\Vehicules;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $title = 'Venta de repuestos para tú vehículo | eselvehiculo';
        $description = 'Venta de filtros, bujías, correas y accesorios para tú vehículo o carro con los mejores precios del mercado y gran variedad de marcas disponibles';
        $menu = json_decode(file_get_contents(storage_path() . "/app/menu_items.json"), true);
        $vehicule = Vehicules::get();
        return view('home', compact('vehicule', 'menu', 'title', 'description'));
    }

    public function admin()
    {
        $date = date("Y-m-d");
        //BY DAY
        $startDate = $date.' 00:00:00';
        $finishDate = $date.' 23:59:59';

        if(Auth::user()->rol == 'GERENCIA'){
            $sales = Billing::where('created_at','>=',$startDate)->where('created_at','<=',$finishDate)->where('vendor','=', Auth::user()->name)->orderBy('id', 'DESC')->get();
            $todaySell = $sales->count('id');
        }else{
            $sales = Billing::where('created_at','>=',$startDate)->where('created_at','<=',$finishDate)->orderBy('id', 'DESC')->get();
            $todaySell = $sales->count('id');
        }

        $sumEarning = 0;
        $allProducts = Products::get()->count('id');

        foreach ($sales as $key => $sale) {
            $sumEarning = (int) str_replace(',','', $sale['total_price']) + $sumEarning;
        }
        //TOTAL PRICE
        return view('admin.home', compact('date', 'todaySell', 'sumEarning', 'allProducts'));
    }


    public function exports(){
        ini_set('max_execution_time', 300);
        ini_set("memory_limit","512M");
        $dataSelect = ['product_name','code','product_buying', 'product_selling', 'product_quantity', 'product_vehicule_compatibility'];
        $products = Products::select($dataSelect)->distinct()->orderBy('product_name', 'ASC')->get();
        $pdf = Pdf::loadView('pdf.catalog_pdf', compact('products'));
        return $pdf->stream('catalogo_productos.pdf');
    }

    public function searchCategory($category)
    {
        $menu = json_decode(file_get_contents(storage_path() . "/app/menu_items.json"), true);
        $categoryValidate = false;
        $getCategoryID = '';
        $products = '';

        foreach ($menu as $key => $item) {
            if($item['name'] == $category){
                $categoryValidate = true;
                $getCategoryID = Categories::select('id')->where('name', $category)->get();
                $products = Products::where('product_category_compatibility', $getCategoryID[0]['id'])->orderBy('product_name', 'ASC')->get();
            }
        }
        if($categoryValidate == false){
            $error_number = 404;
            return view('errors.layout', compact('error_number'));
        }

        $title = 'Venta de '.$category.' | eselvehiculo';
        $description = 'venta de '.$category.', repuestos, bujías, correas y accesorios para tú vehículo o carro con los mejores precios del mercado y gran variedad de marcas disponibles';

        return view('category', compact('products', 'category', 'menu', 'title', 'description'));
    }


    private function CheckDatabaseData($data){
        if(count($data) > 0){
            return $data;
        }
        return [];
    }
}
