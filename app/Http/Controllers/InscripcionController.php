<?php

namespace App\Http\Controllers;

use App\Artista;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;


class InscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $inscripciones = DB::table('inscripcion as ins')
        ->join('artista as art','art.id','=','ins.artista_id')
        ->join('obra as obr','obr.id','=','ins.obra_id')
        ->select('ins.id as id_inscripcion',
            'ins.created_at as fecha_inscripcion',
            'art.nombre',
            'art.apellido',
            'obr.titulo',
            'obr.tipo_obra',
            'obr.valor_venta'
            );
        if($request->nombre){
            $inscripciones = $inscripciones->where('art.nombre', 'like', '%' . $request->nombre . '%');
        }
        if($request->apellido){
            $inscripciones = $inscripciones->where('art.apellido', 'like', '%' . $request->apellido . '%');
        }
        $inscripciones = $inscripciones->paginate(10);

        return view('inscripciones', compact('inscripciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inscripcion = DB::table('inscripcion as ins')
        ->join('artista as art','art.id','=','ins.artista_id')
        ->join('obra as obr','obr.id','=','ins.obra_id')
        ->select('ins.id as id_inscripcion',
            'ins.created_at as fecha_inscripcion',
            'art.nombre',
            'art.apellido',
            'obr.titulo',
            'obr.tipo_obra',
            'obr.valor_venta'
            )
        ->where('ins.id', '=', $id);

        return view('inscripcion', compact('inscripcion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
