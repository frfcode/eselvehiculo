<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Clients;
use App\Models\Codes;
use App\Models\HistorySellings;
use App\Models\Products;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class BillingController extends Controller
{
    //
    public function create(Request $data ){
        date_default_timezone_set('America/Caracas');
        $vendorName = $data->input('vendor');
        $clientName = $data->input('client');
        $iva = $data->input('iva');
        $totalPrice = $data->input('total_price');
        $billing = $data->input('facture');
        $products = $data->input('products');

        foreach ($products as $key => $product) {
            $codeID = Codes::select('id')->where('code', '=' ,$product["code"])->get();
            if(count($codeID) > 1){
                return response()->json([
                    'success' => false,
                    'message' => 'Error, el codigo de facturacion esta repetido en el inventario',
                ]);
            }
        }

        $getNameClient = Clients::select('name')->where('id',$clientName)->get();

        Billing::create([
            'id'=>$billing,
            'vendor'=>$vendorName,
            'client'=>$getNameClient[0]->name,
            'iva'=>$iva,
            'total_price'=>$totalPrice
        ]);

        foreach ($products as $key => $product) {

            HistorySellings::create([
                'n_facture'=>$billing,
                'code'=> $product["code"],
                'product'=> $product["name"],
                'price'=> $product["price"],
                'product_cant'=> $product["product_cant"],
                'created_at'=> Carbon::now()
            ]);

            //DISCOUNT PRODUCT QUANTITY
            $codeID = Codes::select('id')->where('code', '=' ,$product["code"])->get();
            $getCodeID = $codeID[0]->id;
            $findNameProduct = strtoupper($product["name"]);
            $maxQuantity = Products::select('product_quantity')->where('code', $getCodeID)->where('product_name', $findNameProduct)->get();
            $restQuantity = (int) $maxQuantity[0]['product_quantity'] - (int) $product["product_cant"];
            Products::where('code', '=', $codeID[0]->id)->where('product_name','=', $findNameProduct)->update(['product_quantity'=>$restQuantity]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Facturación exitosa, generando factura',
        ]);

    }

    public function generateFacture($factureID){

        $products = HistorySellings::where('n_facture','=',$factureID)->orderBy('product', 'ASC')->get();
        $total = Billing::where('id','=',$factureID)->get();
        $pdf = Pdf::loadView('pdf.recibe_pdf', compact('products', 'factureID', 'total'));
        //return view('pdf.recibe_pdf', compact('products', 'factureID', 'total'));
        return $pdf->stream('recibo_'.$factureID.'.pdf');
    }

    public function historySales(){


        date_default_timezone_set('America/Caracas');

        //TODAY
        $dateToday = date("Y-m-d");

        //WEEK
        $dateInit = '2023-05-15';
        $date = $this->getDateSellingByWeek($dateInit);

        //MONTH


        //BY DAY
        $init = '00:00:00';
        $finish = '23:59:59';

        //TODAY
        $startDate = Carbon::parse($dateToday)->setTimeFromTimeString($init);
        $finishDate = Carbon::parse($dateToday)->setTimeFromTimeString($finish);
        //BY WEEK
        $startDateWeek = Carbon::parse($date)->setTimeFromTimeString($init)->startOfWeek();
        $finishDateWeek = Carbon::parse($date)->setTimeFromTimeString($finish)->startOfWeek();
        //BY MONTH
        $startDateMonth = Carbon::parse($date)->setTimeFromTimeString($init)->startOfMonth();
        $finishDateMonth = Carbon::parse($date)->setTimeFromTimeString($finish)->startOfMonth();

        $sellingToday = '';
        $sellingWeek = '';
        $sellingMonth = '';

        if(Auth::user()->rol != 'GERENCIA'){
            $sellingToday = Billing::whereDate('created_at','>=',$startDate)->whereDate('created_at','<=',$finishDate)->orderBy('id', 'DESC')->get();
            $sellingWeek = Billing::whereDate('created_at','>=',$startDateWeek)->whereDate('created_at','<=',$finishDateWeek)->orderBy('id', 'DESC')->get();
            $sellingMonth = Billing::whereDate('created_at','>=',$startDateMonth)->whereDate('created_at','<=',$finishDateMonth)->orderBy('id', 'DESC')->get();
        }else{
            $sellingToday = Billing::whereDate('created_at','>=',$startDate)->whereDate('created_at','<=',$finishDate)->where('vendor','=',Auth::user()->name)->orderBy('id', 'DESC')->get();
        }

        $today = [];
        $week = [];
        $month = [];

        foreach ($sellingToday as $key => $sellings) {
            $obj = new stdClass();
            $obj->vendor = $sellings->vendor;
            $obj->id = $sellings->id;
            $obj->iva = $sellings->iva;
            $obj->total_price = $sellings->total_price;
            $obj->created_at = $sellings->created_at->setTimezone('America/Caracas')->format('d-m-Y H:i:s');
            array_push($today, $obj);

        }

        foreach ($sellingWeek as $key => $sellings) {
            $obj = new stdClass();
            $obj->vendor = $sellings->vendor;
            $obj->id = $sellings->id;
            $obj->iva = $sellings->iva;
            $obj->total_price = $sellings->total_price;
            $obj->created_at = $sellings->created_at->setTimezone('America/Caracas')->format('d-m-Y H:i:s');
            array_push($week, $obj);

        }

        foreach ($sellingMonth as $key => $sellings) {
            $obj = new stdClass();
            $obj->vendor = $sellings->vendor;
            $obj->id = $sellings->id;
            $obj->iva = $sellings->iva;
            $obj->total_price = $sellings->total_price;
            $obj->created_at = $sellings->created_at->setTimezone('America/Caracas')->format('d-m-Y H:i:s');
            array_push($month, $obj);

        }


        return response()->json([
            'success' => true,
            'history' => [$today, $week, $month],
        ]);
    }

    public function deleteSales($factureID){
        Billing::where('id',$factureID)->delete();
        DB::delete('delete from history_sales where n_facture = ?',[$factureID]);
        $idFacture = Billing::max('id');
        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente.',
            'factureID' => $idFacture
        ]);
    }

    private function getDateSellingByWeek($initDate){
        date_default_timezone_set('America/Caracas');
        $dateNow = date("Y-m-d");
        $dateActually = Carbon::parse($dateNow);
        $dateWeek = Carbon::parse($initDate)->startOfWeek();
        return $dateWeek;
        /*
        if ($dateActually->greaterThan($dateWeek)) {
            $this->getDateSellingByWeek($dateNow);
        } elseif ($dateActually->lessThan($dateWeek)) {
            return $dateActually;
        }
        */
    }
}
