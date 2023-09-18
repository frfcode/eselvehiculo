<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Codes;
use App\Models\Products;
use App\Models\Vehicules;
use Illuminate\Http\Request;
use stdClass;

class ProductsController extends Controller
{

    public function addProduct(Request $data){

        $productCode = $data->input('product_code');
        $productName = $data->input('product_name');
        $productVechiuleCompatible = '';
        if($data->input('product_vehicule_compatible') != ''){
            $productVechiuleCompatible = $data->input('product_vehicule_compatible');
        }
        $productPriceBuy = $data->input('product_price_buy');
        $productPriceSell = $data->input('product_price_sell');
        $productQuantity = $data->input('product_quantity');
        $productEarning = $data->input('product_earning');
        $productListCategory = $data->input('product_categories');
        $productImage = 'example.jpg';
        $productDescription = $data->input('product_description');

        foreach ($productListCategory as $key => $category) {

            Products::create([
                'code' => $productCode,
                'product_name' => $productName,
                'product_buying' => $productPriceBuy,
                'product_selling' => $productPriceSell,
                'product_quantity' => $productQuantity,
                'product_earnings' => $productEarning,
                'product_category_compatibility' => $category,
                'product_image' => $productImage,
                'product_description' => $productDescription,
                'product_vehicule_compatibility' => $productVechiuleCompatible
            ]);

        }

        return response()->json([
            'success' => true,
            'message' => 'Producto creado exitosamente.',
        ]);
    }

    public function findProduct($productID){
        $product = Products::where('id',$productID)->get();
        return response()->json([
            'success' => true,
            'products' => $product,
        ]);
    }

    public function editProduct(Request $data){

        $productCode = $data->input('product_code');
        $productName = $data->input('product_edit_name');
        $productBuy = $data->input('product_edit_price_buy');
        $productSell = $data->input('product_edit_price_sell');
        $productQuantity = $data->input('product_edit_quantity');
        $productEarning = $data->input('product_edit_earnings');

        Products::where('id', '=', $productCode)->update([
            'product_name' => $productName,
            'product_buying' => floatval($productBuy),
            'product_selling' => floatval($productSell),
            'product_quantity' => intval($productQuantity),
            'product_earnings' => intval($productEarning)
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Producto Actualizado exitosamente.',
        ]);

    }

    public function getProducts(){

        $products = Products::orderBy('id', 'DESC')->get();
        $vehicules = Vehicules::get();

        $ouput = [];
        foreach ($products as $key => $product) {
            $objProduct = new stdClass();
            $code = Codes::where('id', $product['code'])->get();
            $categories = Categories::where('id', $product['product_category_compatibility'])->get();
            $categoryOutput = $categories[0]['name'];
            $vehiculeOutput = 'NO';

            if($product['product_vehicule_compatibility'] != ''){
                $vehicules = Vehicules::where('id', $product['product_vehicule_compatibility'])->get();
                $vehiculeOutput = $vehicules[0]['vehicule_brand_model'].$vehicules[0]['vehicule_date'].$vehicules[0]['vehicule_motor_lits'].$vehicules[0]['vehicule_motor_type'].$vehicules[0]['vehicule_motor_system'];
            }
            if(count($code) > 0){
                $objProduct->id=$product['id'];
                $objProduct->code=$code[0]['code'];
                $objProduct->name=$product['product_name'];
                $objProduct->product_category_compatibility=$categoryOutput;
                $objProduct->product_buying=$product['product_buying'];
                $objProduct->product_selling=$product['product_selling'];
                $objProduct->product_quantity=$product['product_quantity'];
                $objProduct->product_earnings=$product['product_earnings'];
                $objProduct->product_image=$product['product_image'];
                $objProduct->product_vehicule_compability=$vehiculeOutput;
                $objProduct->status='DISPONIBLE';
                array_push($ouput, $objProduct);
            }
        }

       return response()->json([
            'success' => true,
            'products' => $ouput,
        ]);
    }


    public function getProductsDistict(){
        $dataSelect = ['product_name','code','product_buying', 'product_selling', 'product_quantity', 'product_quantity', 'product_vehicule_compatibility'];
        $products = Products::select($dataSelect)->distinct()->orderBy('product_name', 'ASC')->get();
        $code = '';
        $output = [];
        foreach ($products as $key => $product) {
            $productList = new stdClass();
            $code = Codes::where('id', $product['code'])->get();
            if(count($code) > 0 ){
                $productList->code=$code[0]['code'];
                $productList->product_name=$product['product_name'];
                $productList->product_buying=$product['product_buying'];
                $productList->product_selling=$product['product_selling'];
                $productList->product_quantity=$product['product_quantity'];
                array_push($output, $productList);
            }
        }

        return response()->json([
            'success' => true,
            'products' => $output,
        ]);
    }

    public function deleteProduct($productID){
        Products::where('id',$productID)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente.',
        ]);
    }
}
