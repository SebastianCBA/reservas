<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Usuario;
use App\Models\Detalle;
use DB;
use Session;
use Illuminate\Support\Facades\Storage;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function disponibilidad($dia, $mes, $ano)
    {
        
        $fecha = date("Y-m-d",strtotime("$dia/$mes/$ano"));

        $matriz = array();
        for($i = 0; $i<5; $i++)
            {
             for($j = 0; $j<10; $j++)   
                 {
                  $matriz[$i][$j]=0;                
                 }
            }   
        
        $reservas = DB::Table('detalles')
                        ->join('reservas', 'detalles.reserva_id','=', 'reservas.id')
                        ->where('reservas.fecha', $fecha)
                        ->select('fila', 'columna')
                        ->get();

        foreach($reservas as $reserva)
            {
            $matriz[$reserva->fila][$reserva->columna] = 1;
            }
        return response()->json($matriz);
    }

    public function buscoreserva($id)
    {
        
        $matriz = array();
        for($i = 0; $i<5; $i++)
            {
             for($j = 0; $j<10; $j++)   
                 {
                  $matriz[$i][$j]=0;                
                 }
            }   
        $reserva = Reserva::Find($id);
        $butacas = DB::Table('detalles')
                        ->join('reservas', 'detalles.reserva_id','=', 'reservas.id')
                        ->where('reservas.id', $id)
                        ->select('fila', 'columna')
                        ->get();

        foreach($butacas as $butaca)
            {
            $matriz[$butaca->fila][$butaca->columna] = 2;
            }
 
        $butacas = DB::Table('detalles')
                        ->join('reservas', 'detalles.reserva_id','=', 'reservas.id')
                        ->where('reservas.fecha', $reserva->fecha)
                        ->where('reservas.id', '<>', $reserva->id)
                        ->select('fila', 'columna')
                        ->get();

        foreach($butacas as $butaca)
            {
            $matriz[$butaca->fila][$butaca->columna] = 1;
            }            
        return response()->json($matriz);
    }

    public function index()
    {
        $reservas = Reserva::paginate(20);
        return view('reservas.index')->with('reservas', $reservas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios = Usuario::Select(DB::raw('concat(nombres, " ", apellidos) as name'), 'id')->pluck('name', 'id');      
        
        return view('reservas.create')->with('usuarios', $usuarios);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
             
        //dd($request->fecha);
        $reserva = new Reserva();
        $reserva->usuario_id = $request->usuario_id;
        $reserva->fecha = date('Y/m/d 00:00:00',strtotime($request->fecha));
        $reserva->cantidad = $request->cantidad;
        $reserva->codigo = '';
        $reserva->save();
        $reserva->codigo = str_pad($reserva->id, 6, "0", STR_PAD_LEFT);
        $reserva->save();
        $matriz = $request->butacas;

        $usuario = Usuario::Find($request->usuario_id);
        $texto = "El usuario ".$usuario->nombres." ".$usuario->apellidos." ha registrado la siguiente reserva para ".$request->cantidad." personas para la fecha ".date('d-m-Y',strtotime($request->fecha)).", las siguientes butacas: ";
        
        for($fila = 0; $fila < 5; $fila++)
            {
                $row = $matriz[$fila];
                for($columna = 0; $columna < 10; $columna++)
                    {
                    if($row[$columna] == '2')
                        {
                            $detalle = new Detalle();
                            $detalle->reserva_id = $reserva->id;
                            $detalle->fila = $fila;
                            $detalle->columna = $columna;
                            $texto .= "(".$fila."-".$columna.")";
                            $detalle->save();
                        }    

                    }

            }
        Storage::disk('local')->put($reserva->codigo.'.txt', $texto);    
        return response()->json('ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reserva = Reserva::find($id);
        $usuarios = Usuario::Select(DB::raw('concat(nombres, " ", apellidos) as name'), 'id')->pluck('name', 'id');      
        
        return view('reservas.edit')
                    ->with('reserva', $reserva)     
                    ->with('usuarios', $usuarios);        
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
        $detalles = Detalle::Where('reserva_id', $id)->get();
        foreach($detalles as $detalle)
            {
             $row = Detalle::Find($detalle->id);
             $row->delete();
            }

        $reserva = Reserva::Find($id);
        
        
        $reserva->usuario_id = $request->usuario_id;
        $reserva->fecha = date('Y/m/d 00:00:00',strtotime($request->fecha));
        $reserva->cantidad = $request->cantidad;
        
        $reserva->save();
        $matriz = $request->butacas;
        
        for($fila = 0; $fila < 5; $fila++)
            {
                $row = $matriz[$fila];
                for($columna = 0; $columna < 10; $columna++)
                    {
                    if($row[$columna] == '2')
                        {
                            $detalle = new Detalle();
                            $detalle->reserva_id = $reserva->id;
                            $detalle->fila = $fila;
                            $detalle->columna = $columna;
                            $detalle->save();
                        }    

                    }

            }
        return response()->json('ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reserva = Reserva::find($id);
        $reserva->delete();
        return redirect()->route('reservas')
                            ->with('error',"La reserva ".$reserva->codigo." ha sido eliminada");
    }
}
