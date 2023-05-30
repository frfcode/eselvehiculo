<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Clients;
use App\Models\Products;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class AdminController extends Controller
{
    //
    public function code() {
        return view('admin.codes');
    }
    public function vehiculos() {
        return view('admin.vehiculos');
    }
    public function products() {
        return view('admin.products');
    }
    public function exports() {
        $getExport = explode('/',url()->current());
        $search = str_replace('_',' ',$getExport[count($getExport) - 1]);

        if($search == 'clients'){
            $clients = Clients::orderBy('id', 'DESC')->get();
            $pdf = Pdf::loadView('pdf.clients_pdf', compact('clients'));
            return $pdf->stream('lista_clientes.pdf');
        }

        if($search == 'products'){
            ini_set('max_execution_time', 300);
            ini_set("memory_limit","512M");
            $dataSelect = ['product_name','code','product_buying', 'product_selling', 'product_quantity', 'product_earnings', 'product_vehicule_compatibility'];
            $products = Products::select($dataSelect)->distinct()->orderBy('product_name', 'ASC')->get();
            $pdf = Pdf::loadView('pdf.products_pdf', compact('products'));
            return $pdf->stream('lista_productos.pdf');
        }
    }
    public function selling(){
        $factureID = Billing::max('id');
        return view('admin.selling', compact('factureID'));
    }

    public function categories(){
        return view('admin.categories');
    }

    public function history(){
        return view('admin.history');
    }

    public function clients(){
        return view('admin.clients');
    }

    public function change_password(){
        return view('admin.reset');
    }
}
