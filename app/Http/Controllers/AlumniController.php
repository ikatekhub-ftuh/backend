<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function get(Request $request)
    {
        $query = Alumni::query();

        // $limit = $request->has('limit') ? $request->limit : 10;

        $request->has('id') ? $query->where('id_alumni', $request->id) : null;
        // $request->has('page') ? $query->offset($limit * ($request->page - 1)) : null;
        
        // $query->limit($limit);
        $result = $query->get();

        return response()->json([
            'message' => 'success',
            'request' => $request->all(),
            'data' => $result
        ], 200);
    }

    // public function delete(Request $request)
    // {
    //     $alumni = Alumni::where('id_alumni', $request->id)->first();
    //     $alumni->delete();
    //     return response()->json([
    //         'message' => 'Berhasil menghapus Alumni.'
    //     ], 200);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function getAllDataAlumni()
    // {
    //     $data = Alumni::all();
    //     return response()->json($data, 200);
    // }

    /**
     * Display the specified data by id
     * 
     * @param int $id
     * @return \Illuminate\Http\Response 
     * 
     */
    // public function getDataAlumniById($id)
    // {
    //     $data = Alumni::find($id);

    //     if ( is_null($data) ) {
    //         $res = [
    //             'success'=> false,
    //             'message'=> "Product not found",
    //         ];
    //         return response()->json($res, 404);
    //     }

    //     return response()->json($data, 200);
    // }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function addDataAlumni(Request $request, Alumni $alumni) {      

    //     return response()->json([], 'Add alumni succesfully.');
    // }
    
    /**
     * Remove the specified data by id.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     * 
     */
    // public function deleteDataAlumniById($id) {
    //     $alumni = Alumni::findOrFail($id);

    //     $alumni->delete();
        
    //     return response()->json('Successfully deleted', 200);
    // }
}
