<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['client', 'article', 'placement'])->get();

        if ($purchases->isEmpty()) {
            $data = [
                'message' => 'No hay compras disponibles',
                'status' => 200,
            ];

            return response()->json($data, 200);
        }

        $data = [
            'purchases' => $purchases,
            'status' => 200,
        ];

        return response()->json($data, 200);
    }

    public function show($id)
    {
        $purchase = Purchase::with(['client', 'article', 'placement'])->find($id);

        if (!$purchase) {
            $data = [
                'message' => 'Compra no encontrada',
                'status' => 404,
            ];

            return response()->json($data, 404);
        }

        $data = [
            'purchase' => $purchase,
            'status' => 200,
        ];

        return response()->json($purchase, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required|exists:tblcliente,cliente_id',
            'articulo_id' => 'required|exists:tblarticulo,articulo_id',
            'colocacion_id' => 'required|exists:tblcolocacion,colocacion_id',
            'unidades' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error validando los datos',
                'errors' => $validator->errors(),
                'status' => 422,
            ];

            return response()->json($data, 422);
        }

        $existing = Purchase::where('cliente_id', $request->cliente_id)
            ->where('articulo_id', $request->articulo_id)
            ->where('colocacion_id', $request->colocacion_id)
            ->first();

        if ($existing) {
            $existing->unidades += $request->unidades;
            $existing->save();

            $data = [
                'message' => 'Compra actualizada',
                'purchase' => $existing,
                'status' => 200,
            ];

            return response()->json($existing, 200);
        } else {
            $purchase = Purchase::create($request->all());

            if (!$purchase) {
                $data = [
                    'message' => 'Error creando la compra',
                    'status' => 500,
                ];

                return response()->json($data, 500);
            }

            $data = [
                'message' => 'Compra creada',
                'purchase' => $purchase,
                'status' => 201,
            ];

            return response()->json($purchase, 201);
        }
    }

    public function update(Request $request, $id)
    {
        $purchase = Purchase::find($id);

        if (!$purchase) {
            $data = [
                'message' => 'Compra no encontrada',
                'status' => 404,
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'unidades' => 'sometimes|required|integer|min:1',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error validando los datos',
                'errors' => $validator->errors(),
                'status' => 422,
            ];

            return response()->json($data, 422);
        }

        $purchase->units = $request->units;
        $purchase->save();
        
        $data = [
            'message' => 'Compra actualizada',
            'purchase' => $purchase,
            'status' => 200,
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $purchase = Purchase::find($id);
        
        if (!$purchase) {
            $data = [
                'message' => 'Compra no encontrada',
                'status' => 404,
            ];

            return response()->json($data, 404);
        }

        $purchase->delete();
        
        $data = [
            'message' => 'Compra eliminada',
            'status' => 200,
        ];

        return response()->json($data, 200);
    }
}
