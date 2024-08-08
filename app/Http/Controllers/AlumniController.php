<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllDataAlumni()
    {
        $data = Alumni::all();
        return response()->json($data, 200);
    }

    /**
     * Display the specified data by id
     * 
     * @param int $id
     * @return \Illuminate\Http\Response 
     * 
     */
    public function getDataAlumniById($id)
    {
        $data = Alumni::find($id);

        if ( is_null($data) ) {
            $res = [
                'success'=> false,
                'message'=> "Product not found",
            ];
            return response()->json($res, 404);
        }

        return response()->json($data, 200);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addDataAlumni(Request $request, Alumni $alumni) {      

        return response()->json([], 'Add alumni succesfully.');
    }
    
    /**
     * Remove the specified data by id.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     * 
     */
    public function deleteDataAlumniById($id) {
        $alumni = Alumni::findOrFail($id);

        $alumni->delete();
        
        return response()->json('Successfully deleted', 200);
    }
}
