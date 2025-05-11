<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Placement;
use Illuminate\Support\Facades\Validator;

class PlacementController extends Controller
{
    public function index() 
    {
        $placements = Placement::all();

        if ($placements->isEmpty()) {
            $data = [
                'message' => 'No hay colocaciones disponibles',
                'status' => 200,
            ];

            return response()->json($data, 200);
        }

        $data = [
            'placements' => $placements,
            'status' => 200,
        ];

        return response()->json($data, 200);        
    }

    public function show($id)
    {
        $placement = Placement::find($id);

        if (!$placement) {
            $data = [
                'message' => 'Colocación no encontrada',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $data = [
            'placement' => $placement,
            'status' => 200,
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'articulo_id' => 'required|exists:tblarticulo,articulo_id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $placement = Placement::create($request->all());

        $data = [
            'placement' => $placement,
            'status' => 201,
        ];

        return response()->json($data, 201);
    }

    public function update(Request $request, $id) 
    {
        $placement = Placement::find($id);

        if (!$placement) {
            $data = [
                'message' => 'Colocación no encontrada',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'precio' => 'sometimes|required|numeric',
            'articulo_id' => 'sometimes|required|exists:tblarticulo,articulo_id',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error validando los datos',
                'errors' => $validator->errors(),
                'status' => 422,
            ];
            return response()->json($data, 422);
        }

        $placement->update($request->all());

        $data = [
            'placement' => $placement,
            'status' => 200,
        ];

        return response()->json($data, 200);
    }

    public function destroy($id) 
    {
        $placement = Placement::find($id);

        if (!$placement) {
            $data = [
                'message' => 'Colocación no encontrada',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $placement->delete();

        $data = [
            'message' => 'Colocación eliminada correctamente',
            'status' => 200,
        ];

        return response()->json($data, 200);
    }

    public function getItems($id)
    {
        $placement = Placement::find($id);

        if (!$placement) {
            $data = [
                'message' => 'Colocación no encontrada',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $items = $placement->item;

        if ($items->isEmpty()) {
            $data = [
                'message' => 'No hay artículos disponibles para esta colocación',
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
}
