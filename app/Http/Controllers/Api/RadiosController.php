<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Radio;

class RadiosController extends Controller
{

    /**
     * Restorna todas las radios.
     * 
     * @return object
     */
    public function all(Request $request)
    {
        $count = $request->input('count');

        $radios = Radio::ofActive()
                ->state()
                ->city()
                ->modulation()
                ->ofSelect()
                ->orderBy('name', 'desc')
                ->take($count)
                ->get();

        return response()->json($radios);
    }

    /**
     * Crear una radio nueva.
     * 
     * @param array $request Datos de la radio.
     * 
     * @return object
     */
    public function create(Request $request)
    {
        $radio = Radio::create($request->all());
        return response()->json(['created' => true], 201);
    }

    /**
     * Retornar los datos de la radio que se busca.
     * 
     * @param string $q Nombre de la radio.
     * 
     * @return object
     */
    public function search(Request $request)
    {
        $q = $request->input('q');
        $count = $request->input('count');

        $radio = Radio::where('radios.name', 'like', '%' . $q . '%')
                ->ofActive()
                ->state()
                ->city()
                ->modulation()
                ->ofSelect()
                ->take($count)
                ->get();

        return response()->json($radio);
    }

    /**
     * Retornar una radio.
     * 
     * @param int $id Identificador unico de la radio.
     * 
     * @return object
     */
    public function show($id)
    {
        $radio = Radio::find($id)
                ->ofActive()
                ->state()
                ->city()
                ->modulation()
                ->ofSelect()
                ->get();
                
        return response()->json($radio);
    }

    /**
     * Actualizar una radio.
     * 
     * @param array $request Datos de la radio.
     * @param int $id Identificador unico de la radio.
     * 
     * @return object
     */
    public function update(Request $request, $id)
    {
        $radio = Radio::find($id);
        $radio->state_id      = $request->state_id;
        $radio->city_id       = $request->city_id;
        $radio->modulation_id = $request->modulation_id;
        $radio->name          = $request->name;
        $radio->frequency     = $request->frequency;
        $radio->streaming     = $request->streaming;
        $radio->active        = $request->active;
        $radio->save();

        return response()->json($radio);
    }

    /**
     * Eliminar una radio.
     * 
     * @param int $id Identificador unico de la radio.
     * 
     * @return object
     */
    public function destroy($id)
    {
        $radio = Radio::find($id);
        $radio->delete();

        return response()->json(['deleted'], 204);
    }
}