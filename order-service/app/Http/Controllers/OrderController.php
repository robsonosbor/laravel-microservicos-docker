<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    private Client $client;
    public function __construct() { $this->client = new Client(['http_errors' => false]); }

    public function create(Request $request)
    {
        $data = $request->validate(['productIds' => 'required|array|min:1']);
        $gateway = env('GATEWAY_URL', 'http://localhost:8700');
        $items = []; $total = 0;

        foreach ($data['productIds'] as $id) {
            $resp = $this->client->get(rtrim($gateway,'/')."/products/{$id}", [
                'headers' => ['Authorization' => 'Bearer '.env('TOKEN_REQUIRED','secret123')]
            ]);
            if ($resp->getStatusCode() === 200) {
                $p = json_decode($resp->getBody()->getContents(), true);
                $items[] = $p;
                $total += (float)($p['price'] ?? 0);
            }
        }

        return response()->json([
            'orderId' => Str::random(6),
            'items' => $items,
            'total' => round($total, 2),
            'status' => 'CREATED'
        ], 201);
    }
}
