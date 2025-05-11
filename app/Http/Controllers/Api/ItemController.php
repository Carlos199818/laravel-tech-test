<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{

    public function index()
    {
        $items = Item::all();

        if ($items->isEmpty()) {
            $data = [
                'message' => 'No hay artículos disponibles',
                'status' => 200,
            ];

            return response()->json($data, 200);
        }

        $data = [
            'items' => $items,
            'status' => 200,
        ];

        return response()->json($data, 200);        
    }

    public function show($id)
    {
        $item = Item::find($id);

        if (!$item) {
            $data = [
                'message' => 'Artículo no encontrado',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $data = [
            'item' => $item,
            'status' => 200,
        ];
        return response()->json($data, 200);
    }
    
    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'codigo_barra' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'fabricante' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error validando los datos',
                'errors' => $validator->errors(),
                'status' => 422,
            ];
            return response()->json($data, 422);
        }

        $item = Item::create($request->all());

        if (!$item) {
            $data = [
                'message' => 'Error creando el artículo',
                'status' => 500,
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Artículo creado correctamente',
            'item' => $item,
            'status' => 201,
        ];

        return response()->json($data, 201);
    }

    public function update(Request $request, $id) 
    {
        $item = Item::find($id);

        if (!$item) {
            $data = [
                'message' => 'Artículo no encontrado',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'codigo_barra' => 'string|max:255',
            'descripcion' => 'string|max:255',
            'fabricante' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error validando los datos',
                'errors' => $validator->errors(),
                'status' => 422,
            ];
            return response()->json($data, 422);
        }

        $item->update($request->all());

        if (!$item) {
            $data = [
                'message' => 'Error actualizando el artículo',
                'status' => 500,
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Artículo actualizado correctamente',
            'item' => $item,
            'status' => 200,
        ];
        return response()->json($data, 200);
    }

    public function destroy($id) 
    {
        $item = Item::find($id);

        if (!$item) {
            $data = [
                'message' => 'Artículo no encontrado',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $item->delete();

        $data = [
            'message' => 'Artículo eliminado correctamente',
            'status' => 200,
        ];

        return response()->json($data, 200);
    }
}
