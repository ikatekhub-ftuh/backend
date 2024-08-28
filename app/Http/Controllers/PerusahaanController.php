<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PerusahaanController extends Controller
{
    public function get(Request $request)
    {
        $query = Perusahaan::query();

        if ($request->has('id')) {
            $query->where('id_perusahaan', $request->id);
            $result = $query->first();

            if (!$result) {
                return response()->json([
                    'message' => 'error',
                    'errors' => 'Data not found'
                ], 404);
            }

            return response()->json([
                'message' => 'success',
                'request' => $request->all(),
                'data' => $result
            ], 200);
        }

        $result = $query->get();

        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $result
        ], 200);
    }

    public function delete(Request $request)
    {
        $perusahaan = Perusahaan::where('id_perusahaan', $request->id)->first();

        if (!$perusahaan) {
            return response()->json([
                'message' => 'error',
                'errors' => 'Data not found'
            ], 404);
        }

        $perusahaan->delete();
        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $perusahaan
        ], 200);
    }
    public function post(Request $request)
    {
        $v = Validator::make($request->all(), [
            'nama_perusahaan' => 'required|string',
            'logo' => 'required|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($v->fails()) {
            return response()->json([
                'message' => 'error',
                'errors' => $v->errors()
            ], 400);
        }

        $validatedData = $v->validated();

        $logoUrl = $request->file('logo')->store('logo/perusahaan', 'public');
        $validatedData['logo'] = $logoUrl;

        $perusahaan = Perusahaan::create($validatedData);

        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $perusahaan
        ], 200);
    }
}
