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

        foreach ($products as $product) {
            $codeID = Codes::where('code', '=' ,$product["code"])->get();
            if(count($codeID) > 1){
                return response()->json([
                    'success' => false,
                    'message' => 'Error, el codigo '.$product["code"].' esta repetido en el inventario, por favor eliminelo de su lista de ventas, asi mismo vaya a Codigos y elimine los codigos repetidos incluyendo el original luego vuelva cree nuevamente el codigo y agregue los productos correspondientes',
                ]);
            }

            if(empty($codeID)){
                return response()->json([
                    'success' => false,
                    'message' => 'Error, el codigo '.$product["code"].' no existe en el inventario, por favor agregue el codigo y vuelva a intentar',
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

        $productsADD = 0;

        foreach ($products as $product) {
            try {
                HistorySellings::create([
                    'n_facture'=>$billing,
                    'code'=> $product["code"],
                    'product'=> $product["name"],
                    'price'=> $product["price"],
                    'product_cant'=> $product["product_cant"],
                    'created_at'=> Carbon::now()
                ]);
                $productsADD++;
            } catch (\Exception $e) {
                if ($e instanceof \Illuminate\Database\QueryException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error a insertar datos del producto '.$product["name"],
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error de base de datos se detuvo en producto '.$product["name"],
                    ]);
                }
            }
        }

        if(count($products) == $productsADD){
            foreach ($products as $product) {
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

        //MONTH
        $dateByMonth = date('Y').'-'.date('m').'-15';
        $dateByMonth = $this->getDateSellingByWeek($dateByMonth);

        //YEAR
        $dateInit = date('Y').'-01-01';
        $dateInit = $this->getDateSellingByWeek($dateInit);

        //HOURS BY DAY
        $init = '00:00:00';
        $finish = '23:59:59';

        //TODAY
        $startDate = Carbon::parse($dateToday)->setTimeFromTimeString($init);
        $finishDate = Carbon::parse($dateToday)->setTimeFromTimeString($finish);
        //BY WEEK
        //$startDateWeek = Carbon::parse($date)->setTimeFromTimeString($init)->startOfWeek();
        //$finishDateWeek = Carbon::parse($date)->setTimeFromTimeString($finish)->startOfWeek();
        //BY MONTH
        //$startDateMonth = Carbon::parse($date)->setTimeFromTimeString($init)->startOfMonth();
        //$finishDateMonth = Carbon::parse($date)->setTimeFromTimeString($finish)->startOfMonth();

        $sellingToday = '';
        //$sellingWeek = '';
        $sellingMonth = '';

        if(Auth::user()->rol != 'GERENCIA'){
            $sellingToday = Billing::whereDate('created_at','>=',$startDate)->whereDate('created_at','<=',$finishDate)->orderBy('id', 'DESC')->get();
            //$sellingWeek = Billing::whereDate('created_at','>=',$startDateWeek)->whereDate('created_at','<=',$finishDateWeek)->orderBy('id', 'DESC')->get();
            $sellingMonth = Billing::whereDate('created_at','>=',$dateInit)->orderBy('id', 'DESC')->get();
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
        /*
        foreach ($sellingWeek as $key => $sellings) {
            $obj = new stdClass();
            $obj->vendor = $sellings->vendor;
            $obj->id = $sellings->id;
            $obj->iva = $sellings->iva;
            $obj->total_price = $sellings->total_price;
            $obj->created_at = $sellings->created_at->setTimezone('America/Caracas')->format('d-m-Y H:i:s');
            array_push($week, $obj);

        }
        */

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

        $getHistoyProductsByFacture = HistorySellings::where('n_facture', $factureID)->get();
        $updateProducts = 0;
        foreach ($getHistoyProductsByFacture as $key => $oldProduct) {
            try {
                $codeID = Codes::select('id')->where('code', $oldProduct["code"])->get();
                if(count($codeID) == 0){
                    HistorySellings::where('n_facture',$factureID)->delete();
                    return response()->json([
                        'success' => false,
                        'message' => 'Error el codigo no existe, se eliminara esta factura automaticamente, por favor refrescar la pagina',
                    ]);
                }
                $findNameProduct = strtoupper($oldProduct["product"]);
                $maxQuantity = Products::select('product_quantity')->where('product_name', $findNameProduct)->get();
                $sumQuantity = (int) $maxQuantity[0]['product_quantity'] + (int) $oldProduct["product_cant"];
                Products::where('code', '=', $codeID[0]->id)->where('product_name','=', $findNameProduct)->update(['product_quantity'=>$sumQuantity]);
                $updateProducts++;
            } catch (\Exception $e) {
                if ($e instanceof \Illuminate\Database\QueryException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error al actualizar los datos de '.$oldProduct["product"].' '.$e,
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Error de base de datos se detuvo en producto '.$oldProduct["product"].' '.$e,
                    ]);
                }
            }
        }

        if(count($getHistoyProductsByFacture) == $updateProducts){
            Billing::where('id',$factureID)->delete();
            DB::delete('delete from history_sales where n_facture = ?',[$factureID]);
            $idFacture = Billing::max('id');

            return response()->json([
                'success' => true,
                'message' => 'Factura eliminada y Devolución exitosa.',
                'factureID' => $idFacture
            ]);
        }
    }

    private function getDateSellingByWeek($initDate){
        date_default_timezone_set('America/Caracas');
        $month = Carbon::parse($initDate)->addMonth();
        return $month;
    }
}
