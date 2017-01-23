<?php

namespace App\Http\Controllers;

use App\Artista;
use App\payuFactura;
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
            'obr.valor_venta'
            );
        if($request->id){
            $inscripciones = $inscripciones->where('ins.id', '=', $request->id);
        }
        if($request->nombre){
            $inscripciones = $inscripciones->where('art.nombre', 'like', '%' . $request->nombre . '%');
        }
        if($request->apellido){
            $inscripciones = $inscripciones->where('art.apellido', 'like', '%' . $request->apellido . '%');
        }
        if($request->titulo){
            $inscripciones = $inscripciones->where('obr.titulo', 'like', '%' . $request->titulo . '%');
        }

        $inscripciones = $inscripciones->paginate(10);

        return view('inscripciones', ['inscripciones' => $inscripciones, 'request' => $request]);
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
            'art.pais_id',
            'art.fecha_nacimiento',
            'art.direccion_postal',
            'art.email',
            'art.telefono_movil',
            'art.perfil_artista',
            'art.ruta_hoja_vida',
            'obr.titulo',
            'obr.sintesis_conceptual',
            'obr.ruta_fotos_obra',
            'obr.tipo_obra',
            'obr.alto_medida',
            'obr.ancho_medida',
            'obr.peso',
            'obr.tema',
            'obr.tecnica',
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

    /**
     * Página de respuesta payU
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function payUresponse(Request $request){
        $ApiKey = "4Vj8eK4rloUd272L48hsrarnUA";
        $merchant_id = $request->merchantId;
        $referenceCode = $request->referenceCode;
        $TX_VALUE = $request->TX_VALUE;
        $New_value = number_format($TX_VALUE, 1, '.', '');
        $currency = $request->currency;
        $transactionState = $request->transactionState;
        $firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
        $firmaCreada = md5($firma_cadena);
        $firma = $request->signature;

        if ($request->transactionState == 4 ) {
            $estadoTx = "Transacción aprobada";
        }
        else if ($request->transactionState == 6 ) {
            $estadoTx = "Transacción rechazada";
        }
        else if ($request->transactionState == 104 ) {
            $estadoTx = "Error";
        }
        else if ($request->transactionState == 7 ) {
            $estadoTx = "Transacción pendiente";
        }
        else {
            $estadoTx=$request->mensaje;
        }

        return view('respuestaPayU', ['infoRespuesta' => $request, 'estadoTx' => $estadoTx, 'firma' => $firma, 'firmaCreada' => $firmaCreada]);
    }

    /**
     * Operaciones de confirmación
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function payUconfirmation(Request $request){
        $ApiKey = "4Vj8eK4rloUd272L48hsrarnUA";
        $New_value = number_format($request->value, 1, '.', '');
        $firma_cadena = "$ApiKey~$request->merchant_id~$request->reference_sale~$New_value~$request->currency~$request->state_pol";
        $firmaCreada = md5($firma_cadena);
        $firma = $request->merchant_id;

        if (strtoupper($firma) == strtoupper($firmacreada)) {
            payuFactura::update(['merchant_id' => $request->merchant_id, 
                             'state_pol' => $request->state_pol, 
                             'response_code_pol' => $request->response_code_pol, 
                             'reference_sale' => $request->reference_sale,
                             'reference_pol' => $request->reference_pol, 
                             'payment_method_type' => $request->payment_method_type, 
                             'value' => $request->value, 
                             'tax' => $request->tax,
                             'transaction_date' => $request->transaction_date, 
                             'currency' => $request->currency, 
                             'email_buyer' => $request->email_buyer, 
                             'cus' => $request->cus,
                             'pse_bank' => $request->pse_bank, 
                             'description' => $request->description, 
                             'billing_address' => $request->billing_address, 
                             'shipping_address' => $request->shipping_address,
                             'phone' => $request->phone, 
                             'office_phone' => $request->office_phone, 
                             'account_number_ach' => $request->account_number_ach, 
                             'account_type_ach' => $request->account_type_ach,
                             'authorization_code' => $request->authorization_code, 
                             'bank_id' => $request->bank_id, 
                             'billing_city' => $request->billing_city, 
                             'billing_country' => $request->billing_country,
                             'customer_number' => $request->customer_number, 
                             'date' => $request->date, 
                             'error_code_bank' => $request->error_code_bank, 
                             'error_message_bank' => $request->error_message_bank,
                             'exchange_rate' => $request->exchange_rate, 
                             'ip' => $request->ip, 
                             'payment_method_id' => $request->payment_method_id, 
                             'payment_request_state' => $request->payment_request_state,
                             'pseReference1' => $request->pseReference1, 
                             'pseReference2' => $request->pseReference2, 
                             'pseReference3' => $request->pseReference3, 
                             'response_message_pol' => $request->response_message_pol,
                             'shipping_city' => $request->shipping_city, 
                             'shipping_country' => $request->shipping_country, 
                             'transaction_bank_id' => $request->transaction_bank_id, 
                             'transaction_id' => $request->transaction_id,
                             'payment_method_name' => $request->payment_method_name]
            );
        }
    }
}
