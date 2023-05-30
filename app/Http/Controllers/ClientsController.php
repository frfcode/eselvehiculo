<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    //
    public function createClient( Request $data){
        $clientName = $data->input('client_name');
        $clientType = $data->input('type_client');
        $clientDNI = $data->input('client_dni');
        $clientPhone = $data->input('client_phone');
        
        Clients::create([
            'name' => $clientName,
            'person_type' => $clientType,
            'dni' => $clientDNI,
            'phone_number' => $clientPhone
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Cliente creado exitosamente.',
        ]);
    }

    public function getClients(){

        $clients = Clients::orderBy('id', 'DESC')->get();
        return response()->json([
            'success' => true,
            'clients' => $clients,
        ]);
    }

    public function deleteClient($clientID){
        Clients::where('id',$clientID)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Cliente eliminado exitosamente.',
        ]);
    }
}
