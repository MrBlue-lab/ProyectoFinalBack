<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tablero;
use App\Models\Tarjeta;
use App\Models\Columna;

class CalendarioController extends Controller {

    //
    public function getTarjetasDate(Request $request) {
        $id = $request->input("id");
        /*
         * SELECT tarjetas.* FROM `tableros`,columna,tarjetas WHERE tableros.id_Creador=1 AND tableros.id =columna.idTablero AND tarjetas.id_Columna = columna.id AND (tarjetas.not_fecha_inicio=true OR tarjetas.not_fecha_fin=true)
         */
        $tarjetas = Tarjeta::whereIn('id_Columna', function ($query) use ($id) {
                    $query->select('id')
                            ->from('columna')
                            ->whereIn('idTablero', function ($query) use ($id) {
                                $query->select('id')
                                ->from('tableros')
                                ->where('id_Creador', $id);
                            });
                })->where('not_fecha_fin', '=', true)->orWhere('not_fecha_inicio', '=', true)->orderByDesc('Fecha_inicio', 'Fecha_fin')->get();
        return response()->json(['code' => 200, 'message' => ['tarjetas' => $tarjetas]]);
    }

    public function getTarjetaDate(Request $request) {
        $id = $request->input("id");
        $date = $request->input("date");
        /*
         * SELECT tarjetas.* FROM `tableros`,columna,tarjetas WHERE tableros.id_Creador=1 AND tableros.id =columna.idTablero AND tarjetas.id_Columna = columna.id AND (tarjetas.not_fecha_inicio=true OR tarjetas.not_fecha_fin=true) AND (Fecha_inicio = '2021-05-31' OR Fecha_fin = '2021-05-31')
         */
        $tarjetas = Tarjeta::whereIn('id_Columna', function ($query) use ($id) {
                            $query->select('id')
                            ->from('columna')
                            ->whereIn('idTablero', function ($query) use ($id) {
                                $query->select('id')
                                ->from('tableros')
                                ->where('id_Creador', $id);
                            });
                        })
                        ->where(function ($query) use ($date) {
                            $query
                            ->where('Fecha_inicio','=', $date)
                            ->orWhere('Fecha_fin', '=',$date);
                        })
                        ->orderByDesc('Fecha_fin','Fecha_inicio')->get();
        return response()->json(['code' => 200, 'message' => ['tarjetas' => $tarjetas]]);
    }

}
