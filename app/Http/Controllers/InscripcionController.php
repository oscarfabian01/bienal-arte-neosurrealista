<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use App\Artista;
use App\Inscripcion;
use App\Obra;
use Storage;

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
        return view('registro');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()){
            return redirect()->action('InscripcionController@create')->withErrors($validator)
                ->withInput();
        }else{

            $cv = $request->file('cv');

            $cvRoute = time().'_'.$cv->getClientOriginalName();

            Storage::disk('cv')->put($cvRoute, file_get_contents( $cv->getRealPath() ));

            $artista = Artista::create(['nombre' => $request->nombre
                ,'apellido' => $request->apellido
                ,'pais_id' => $request->pais
                ,'fecha_nacimiento' => $request->Fnacimiento
                ,'direccion_postal' => $request->direccion
                ,'email' => $request->email
                ,'telefono_movil' => $request->telMovil
                ,'perfil_artista' => $request->perfil
                ,'ruta_hoja_vida' => $cvRoute
            ]);

            $fotosObra = $request->file('fotosObra');

            $fotosObraRoute = time().'_'.$fotosObra->getClientOriginalName();

            Storage::disk('fotos')->put($fotosObraRoute, file_get_contents( $fotosObra->getRealPath() ));

            $obra = Obra::create(['titulo' => $request->titulo
                ,'sintesis_conceptual' => $request->sintesis
                ,'ruta_fotos_obra' => $fotosObraRoute
                ,'tipo_obra' => $request->tipoObra
                ,'alto_medida' => $request->alto
                ,'ancho_medida' => $request->ancho
                ,'peso' => $request->peso
                ,'tema' => $request->tema
                ,'tecnica' => $request->tecnica
                ,'valor_venta' => $request->venta
            ]);

            Inscripcion::create(['artista_id' => $artista->id, 'obra_id' => $obra->id]);

        }

    }
    /**
     * Validacion formulario inscripción
     */
    private function validator(array $array){

        $rules = ['nombre' => 'required|max:255'
            ,'apellido' => 'required|max:255'
            ,'pais' => 'required|numeric|not_in:0'
            ,'Lnacimiento' => 'required'
            ,'Fnacimiento' => 'required'
            ,'direccion' => 'required|max:255'
            ,'email' => 'required|email|max:255'
            ,'telMovil' => 'required|numeric'
            ,'perfil' => 'required|numeric|not_in:0'
            ,'cv' => 'required|mimes:doc,pdf'
            ,'titulo' => 'required|max:255'
            ,'sintesis' => 'required|max:255'
            ,'tema' => 'required|numeric|not_in:0'
            ,'tecnica' => 'required|numeric|not_in:0'
            ,'fotosObra' => 'required|mimes:doc,pdf'
            ,'alto' => 'required|numeric'
            ,'tipoObra' => 'required|numeric|not_in:0'
            ,'anchop' => 'numeric'
            ,'peso' => 'numeric'

        ];

        return Validator::make($array, $rules);
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
        ->where('ins.id', '=', $id)
        ->first();

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
