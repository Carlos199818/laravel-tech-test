<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    
    public function index()
    {

        $clients = Client::all();

        if ($clients->isEmpty()) {
            $data = [
                'message' => 'No hay clientes disponibles',
                'status' => 200,
            ];

            return response()->json($data, 200);
        }

        $data = [
            'clients' => $clients,
            'status' => 200,
        ];

        return response()->json($data, 200);        
    }

    public function show($id)
    {
        $client = Client::find($id);

        if (!$client) {
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404,
            ];

            return response()->json($data, 404);
        }

        $data = [
            'client' => $client,
            'status' => 200,
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'tipo_cliente' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error validando los datos',
                'errors' => $validator->errors(),
                'status' => 422,
            ];

            return response()->json($data, 422);
        }

        $client = Client::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'tipo_cliente' => $request->tipo_cliente,
        ]);

        if (!$client) {
            $data = [
                'message' => 'Error creando el cliente',
                'status' => 500,
            ];

            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Cliente creado correctamente',
            'client' => $client,
            'status' => 201,
        ];
        
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404,
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'tipo_cliente' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error validando los datos',
                'errors' => $validator->errors(),
                'status' => 422,
            ];

            return response()->json($data, 422);
        }

        $client->update([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'tipo_cliente' => $request->tipo_cliente,
        ]);

        if (!$client) {
            $data = [
                'message' => 'Error actualizando el cliente',
                'status' => 500,
            ];

            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Cliente actualizado correctamente',
            'client' => $client,
            'status' => 200,
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $client = Client::find($id);

        if (!$client) {
            $data = [
                'message' => 'Cliente no encontrado',
                'status' => 404,
            ];

            return response()->json($data, 404);
        }

        $client->delete();

        $data = [
            'message' => 'Cliente eliminado correctamente',
            'status' => 200,
        ];
        
        return response()->json($data, 200);
    }
}
