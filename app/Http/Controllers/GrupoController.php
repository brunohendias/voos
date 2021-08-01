<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GrupoController extends Controller
{
    private string $key = 'fare';

    private string $api = 'API_123MILHAS';

    public function index() : array
    {
        try {

            $data = collect(json_decode(
                Http::get(env($this->api).'/flights')
            ))->whereNotNull($this->key);

            if ($data->isEmpty())
                return array(
                    'code' => 204,
                    'msg' => __('return.nocontent')
                );

            $flights = collect();
            $groups = collect();

            $data->each(function ($item) use ($flights) {
                $flights->push($item->flightNumber);
            });

            $fareGroups = $data->groupBy($this->key);
            $fareGroups->each(function ($group, $key) use ($groups) {
                $groups->push([
                    'uniqueId' => $key,
                    'totalPrice' => $group->sum('price'),
                    'outbound' => $group->where('outbound', 1),
                    'inbound' => $group->where('inbound', 1)
                ]);
            });

            $sorted = $groups->sortBy(['totalPrice', 'asc']);
            return array(
                'flights' => $flights,
                'groups' => $sorted,
                'totalGroups' => $groups->count(),
                'totalFlights' => $data->count(),
                'cheapestPrice' => $sorted[0]['totalPrice'],
                'cheapestGroup' => $sorted[0]['uniqueId']
            );
        } catch (\Exception $e) {
            $msg = __('return.exception');

            Log::error($msg, array(
                'route' => $_SERVER['REQUEST_URI'],
                'error' => $e->getMessage()
            ));

            return array('code' => 500, 'msg' => $msg);
        }
    }
}

/*
    $cheapestPrice = $groups->min('totalPrice');
    $cheapestGroup = $groups->where('totalPrice', $cheapestPrice)[0]['uniqueId'];

    Essa seria a logica correta,
    porem como a ordenacao sempre deixara o mais barato primeiro
    conclui que posso pegar o primeiro e mostrar como o mais barato
    o beneficio disso e a reducao de processamento
*/