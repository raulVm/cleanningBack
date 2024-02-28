<?php

namespace App\Http\Controllers\Cat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalogos\CatEstado;
use App\Pais;
use Illuminate\Support\Facades\Cache;
use Session;
use DB;

class CatalogoController extends Controller
{
    public function getEstados()
    {
        if (!Cache::store('file')->has('estados')) {
            Cache::store('file')->put('estados', CatEstado::select('id', 'nombre')->get());
        }
        $items = Cache::store('file')->get('estados');
        //$items = CatEstado::select('id', 'nombre')->get();
        return response()->json($items);
    }

    public function getMunicipios($idEstado)
    {
        if (!Cache::store('file')->has('municipios-'.$idEstado)) {
            Cache::store('file')->put('municipios-'.$idEstado, 
                \App\Models\Catalogos\CatMunicipio::select('cve_mun', 'nombre')
                ->where('cve_ent',$idEstado)->get()
            );
        }
        $items = Cache::store('file')->get('municipios-'.$idEstado);
        // $items = \App\Models\Catalogos\CatMunicipio::select('cve_mun', 'nombre')
        //             ->where('cve_ent',$idEstado)
        //             ->get();
        return response()->json($items);
    }

    public function getLocalidades($cveEdo, $cveMun)
    {
        $items = \App\Models\Catalogos\CatLocalidad::select('cve_loc', 'nombre')
                    ->where('cve_ent',$cveEdo)
                    ->where('cve_mun',$cveMun)
                    ->get();
        return response()->json($items);
    }

    public function getColonias($cveEdo, $cveMun)
    {
        $items = \App\Models\Catalogos\CatColonia::select('id', 'asentamiento')
                    ->where('cve_ent',$cveEdo)
                    ->where('cve_mun',$cveMun)
                    ->get();
        return response()->json($items);
    }

   
    function getPais()
    {
        $items = Pais::select('id', 'nombre')
                ->get();
        return response()->json($items);
    }   

    }