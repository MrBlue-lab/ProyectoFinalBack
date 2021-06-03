<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tablero;
use App\Models\Tarjeta;
use App\Models\Columna;

class TableroController extends Controller {/**
  public function getTableros(Request $request) {
  $Tablero = Tablero::create([
  'id_Creador' =>  $request->input('id_Creador'),
  'nombre' =>  $request->input('nombre'),
  'tipo' =>  $request->input('tipo'),
  'descripcion' =>  $request->input('descripcion')
  ]);
  if (!$Tablero) {
  return response()->json(['errors' => array(['code' => 404, 'message' => 'No se ha podido registrar el Tablero ' . $Tablero])], 404);
  }
  //Asignar alumno a curso
  $Tablero->save();

  return response()->json(['code' => 201, 'message' => 'Datos insertados correctamente', 'Tablero' => $Tablero], 201);
  } */

    public function getTableros(Request $request) {
        $Tableros = Tablero::where('id_Creador', '=', $request->input('id_Creador'))
                ->get();
        return response()->json(['code' => 200, 'message' => $Tableros]);
    }

    public function getTablero(Request $request) {
        $Tablero = Tablero::where('id_Creador', '=', $request->input('id_Creador'))
                ->where('id', '=', $request->input('id'))
                ->get();
        return response()->json(['code' => 200, 'message' => ['tablero' => $Tablero]]);
    }

    public function setTableros(Request $request) {
        $Tablero = Tablero::create([
                    'id_Creador' => $request->input("id_Creador"),
                    'nombre' => $request->input("nombre"),
                    'tipo' => $request->input("tipo"),
                    'descripcion' => $request->input("descripcion")
        ]);
        if ($request->input("tipo") == 1) {
            if (Columna::where('idTablero', '=', $Tablero->id)->first() == null) {
                Columna::create([
                    'idTablero' => $Tablero->id,
                    'posicion' => 0,
                    'nombre' => 'To Do']);
                Columna::create([
                    'idTablero' => $Tablero->id,
                    'posicion' => 1,
                    'nombre' => 'In Progress']);
                Columna::create([
                    'idTablero' => $Tablero->id,
                    'posicion' => 2,
                    'nombre' => 'Done']);
            }
        }
        if (Tablero::where('id_Creador', '=', $request->input('id_Creador'))->count() >= 1) {
            return response()->json(['code' => 200, 'message' => $Tablero]);
        }
        return response()->json(['message' => 'error ya existe el Tablero', 'code' => 201], 201);
    }

    public function updateTarjetaCol(Request $request) {
        $tarj = $request->input("datos");
        $columna = $request->input("id_destino");

        $tarjeta = Tarjeta::find($tarj[$request->input("id_pre")]['id']);
        $columnaact = $tarjeta['id_Columna'];
        $tarjeta->update([
            'id_Columna' => $request->input('id_destino'),
            'posicion' => $request->input('id_pos')
        ]);

        $tarjetas = Tarjeta::where('id_Columna', '=', $columna)->orderBy('posicion')->orderByDesc('updated_at')->get();
        $this->functionName($tarjetas);
        $this->functionName(Tarjeta::where('id_Columna', '=', $columnaact)->orderBy('posicion')->orderBy('updated_at')->get());

        return response()->json(['message' => 'Columna tarjeta actualizada', 'code' => 201], 201);
    }

    public function updateTarjeta(Request $request) {
        $tarjeta = Tarjeta::find($request->input("id"));
        $tarjeta->update([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'Fecha_fin' => $request->input('datefin'),
            'Time_fin' => $request->input('timefin'),
            'Fecha_inicio' => $request->input('dateinit'),
            'Time_inicio' => $request->input('timeinit'),
            'check_fin' => $request->input('check_fin'),
            'not_fecha_fin' => $request->input('not_fecha_fin'),
            'not_fecha_inicio' => $request->input('not_fecha_inicio'),
        ]);
        return response()->json(['message' => ['mens' => 'Tarjeta actualizada', 'Tarjeta' => $tarjeta, 'Fecha_inicio' => date('Y-m-d', strtotime($request->input('dateinit')))], 'code' => 201], 201);
    }

    public function updateTarjetaPos(Request $request) {
        $tarj = $request->input("datos");
        $columna = $tarj[0]['id_Columna'];
        $tarjeta = Tarjeta::find($tarj[$request->input("id_pre")]['id']);
        $tarjeta->update([
            'posicion' => $request->input('id_pos')
        ]);
        if ($request->input("id_pre") > $request->input('id_pos')) {
            $tarjetas = Tarjeta::where('id_Columna', '=', $columna)->orderBy('posicion')->orderByDesc('updated_at')->get();
            $this->functionName($tarjetas);
        } else {
            $tarjetas = Tarjeta::where('id_Columna', '=', $columna)->orderBy('posicion')->orderBy('updated_at')->get();
            $this->functionName($tarjetas);
        }
        return response()->json(['message' => ['mens' => 'Posición tarjeta actualizada', 'tarjetas' => $tarjetas], 'code' => 201], 201);
    }

    private function functionName($tarjetas) {
        foreach ($tarjetas as $i => $dato) {
            $tarjeta = Tarjeta::find($dato['id']);
            $tarjeta->update(['posicion' => $i]);
        }
    }

    public function setTarjeta(Request $request) {
        $pos = (int) Tarjeta::where('id_Columna', '=', $request->input("columna"))->max('posicion');
        if ($pos == 0) {
            //return response()->json(['code' => 200, 'message' => ['existe'=>$exis]]);
            if (Tarjeta::where('id_Columna', '=', $request->input("columna"))->where('posicion', '=', $pos)->count() == 1) {

                $Tarjeta = Tarjeta::create([
                            'id_Columna' => $request->input("columna"),
                            'nombre' => $request->input("nombre"),
                            'tipo' => "normal",
                            'posicion' => ($pos + 1),
                            'descripcion' => $request->input("descripcion")
                ]);
            } else {
                $Tarjeta = Tarjeta::create([
                            'id_Columna' => $request->input("columna"),
                            'nombre' => $request->input("nombre"),
                            'tipo' => "normal",
                            'posicion' => ($pos),
                            'descripcion' => $request->input("descripcion")
                ]);
            }
        } else {
            $Tarjeta = Tarjeta::create([
                        'id_Columna' => $request->input("columna"),
                        'nombre' => $request->input("nombre"),
                        'tipo' => "normal",
                        'posicion' => ($pos + 1),
                        'descripcion' => $request->input("descripcion")
            ]);
        }
        if (Tablero::where('id_Creador', '=', $request->input('id_Creador'))->count() == 1) {
            return response()->json(['code' => 200, 'message' => $Tarjeta]);
        }
        return response()->json(['message' => 'error en la creacion de la tarjeta', 'code' => 201], 201);
    }

    public function getTarjetas(Request $request) {
        $tarjetas = Tarjeta::where('id_Columna', '=', $request->input('idColumna'))
                ->get();
        return response()->json(['code' => 200, 'message' => ['tarjetas' => $tarjetas]]);
    }

    public function getTarjeta(Request $request) {
        $tarjeta = Tarjeta::where('id', '=', $request->input('idTarjeta'))
                ->get();
        /*
          return response()->json(['code' => 200, 'message' => ['tarjeta' => $tarjeta]]);

          if($tarjeta->not_fecha_fin==1){
          $tarjeta->not_fecha_fin=true;
          }else{
          $tarjeta->not_fecha_fin=false;
          }
          if($tarjeta->not_fecha_inicio==0){
          $tarjeta->not_fecha_inicio=true;
          }else{
          $tarjeta->not_fecha_inicio=false;
          } */
        return response()->json(['code' => 200, 'message' => ['tarjeta' => $tarjeta]]);
    }

    public function getColumna(Request $request) {
        $columna = Columna::where('id', '=', $request->input('id'))->first();
        return response()->json(['code' => 200, 'message' => ['columna' => $columna]]);
    }

    public function getColumnas(Request $request) {
        $columnas = Columna::where('idTablero', '=', $request->input('idTablero'))->orderBy('posicion', 'ASC')
                ->get();
        return response()->json(['code' => 200, 'message' => ['columnas' => $columnas]]);
    }

    public function getColumnasfull(Request $request) {
        $columnas = Columna::where('idTablero', '=', $request->input('idTablero'))->orderBy('posicion', 'ASC')
                ->get();
        $size = Columna::where('idTablero', '=', $request->input('idTablero'))
                ->count();

        for ($i = 0; $i < $size; $i++) {
            $tarjetas = Tarjeta::where('id_Columna', '=', $columnas[$i]->id)->orderBy('posicion', 'ASC')
                    ->get();
            $columnas[$i]->tarjetas = $tarjetas;
        }
        return response()->json(['code' => 200, 'message' => ['columnas' => $columnas]]);
    }

    public function updateColumna(Request $request) {
        if (Columna::where('id', '=', $request->input("id"))->count() == 1) {
            $columna = Columna::where('id', '=', $request->input("id"))->first();
            $pre = $columna->posicion;
            $tab = $columna->idTablero;

            $columna->update(['nombre' => $request->input('nombre'), 'posicion' => $request->input('posicion')]);

            if ($pre > $request->input('posicion')) {
                $columnas = Columna::where('idTablero', '=', $tab)->orderBy('posicion')->orderByDesc('updated_at')->get();
                foreach ($columnas as $i => $dato) {
                    $columna = Columna::find($dato['id']);
                    $columna->update(['posicion' => $i]);
                }
            } else {
                $columnas = Columna::where('idTablero', '=', $tab)->orderBy('posicion')->orderBy('updated_at')->get();
                foreach ($columnas as $i => $dato) {
                    $columna = Columna::find($dato['id']);
                    $columna->update(['posicion' => $i]);
                }
            }
            return response()->json(['message' => 'Columna actualizada', 'code' => 201], 201);
        }
        return response()->json(['message' => 'error en la actualizacion de la Columna', 'code' => 201], 201);
    }

    public function addColumna(Request $request) {
        if (Columna::where('idTablero', '=', $request->input("idTablero"))->first() != null) {
            $pos = (int) Columna::where('idTablero', '=', $request->input("idTablero"))->max('posicion');
            $pos++;
        } else {
            $pos = 0;
        }
        $Columna = Columna::create([
                    'idTablero' => $request->input("idTablero"),
                    'posicion' => $pos,
                    'nombre' => $request->input("nombre")
        ]);
        if (Columna::where('idTablero', '=', $request->input("idTablero"))
                        ->where('posicion', '=', $request->input("posicion"))
                        ->count() == 1) {
            return response()->json(['code' => 200, 'message' => $Columna]);
        }
        return response()->json(['message' => 'error en la creacion de la tarjeta', 'code' => 201], 201);
    }

    public function dropTarjeta(Request $request) {
        $destroy = Tarjeta::destroy('id', '=', $request->input('id'));
        if (!$destroy) {
            return response()->json(['message' => 'No se ha podido eliminar la tarjeta ' . $id, 'code' => 400], 400);
        } else {

            return response()->json(['code' => 201, 'message' => 'tarjeta eliminada correctamente'], 201);
        }
    }

    public function dropColumna(Request $request) {
        $columna = Columna::where('id', '=', $request->input('id'))->first();
        $tab = $columna->idTablero;
        $destroy = Columna::destroy('id', '=', $request->input('id'));
        if (!$destroy) {
            return response()->json(['message' => 'No se ha podido eliminar la columna ' . $id, 'code' => 400], 400);
        } else {
            $columnas = Columna::where('idTablero', '=', $tab)->orderBy('posicion')->orderBy('updated_at')->get();
            foreach ($columnas as $i => $dato) {
                $columna = Columna::find($dato['id']);
                $columna->update(['posicion' => $i]);
            }
            self::dropTarjetas($request->input('id'));
            return response()->json(['code' => 201, 'message' => 'tarjeta columna correctamente'], 201);
        }
    }

    public static function dropColumnas($id) {
        $size = Columna::where('idTablero', '=', $id)
                ->count();
        for ($i = 0; $i < $size; $i++) {
            self::dropTarjetas($i);
        }
        $deleteColumnas = Columna::where('idTablero', $id)->delete();
        if (!$deleteColumnas) {
            return response()->json(['message' => 'No se han podido eliminar las Columnas ' . $id, 'code' => 400], 400);
        } else {
            return response()->json(['code' => 201, 'message' => 'Columnas eliminadas correctamente'], 201);
        }
    }

    public static function dropTarjetas($id) {
        $deletatarjetas = Tarjeta::where('id_Columna', $id)->delete();
        if (!$deletatarjetas) {
            return response()->json(['message' => 'No se han podido eliminar las tarjetas ' . $id, 'code' => 400], 400);
        } else {
            return response()->json(['code' => 201, 'message' => 'tarjetas eliminadas correctamente'], 201);
        }
    }

    public function dropTablero(Request $request) {
        self::dropColumnas($request->input('id'));
        $deleteTablero = Tablero::where('id', $request->input('id'))->delete();
        if (!$deleteTablero) {
            return response()->json(['message' => 'No se ha podido eliminar el tablero ' . $request->input('id'), 'code' => 400], 400);
        } else {

            return response()->json(['code' => 201, 'message' => 'tablero eliminado correctamente'], 201);
        }
    }

    public function updateTablero(Request $request) {
        if (Tablero::where('id', '=', $request->input("id"))->count() == 1) {
            $tablero = Tablero::where('id', '=', $request->input("id"))->first();

            $tablero->update(['nombre' => $request->input('nombre')]);
            return response()->json(['message' => 'Tablero actualizado', 'code' => 201], 201);
        }
        return response()->json(['message' => 'error en la actualizacion del tablero', 'code' => 201], 201);
    }
}
