<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GatewayController extends Controller
{
    private Client $client;
    public function __construct() { $this->client = new Client(['http_errors' => false]); }

    public function health() { return response()->json(['status'=>'ok']); }

    public function products(Request $request, $path = '')
    {
        $base = env('PRODUCT_SERVICE_URL', 'http://localhost:8100');
        return $this->proxy($request, $base, 'products/'. $path);
    }

    public function orders(Request $request, $path = '')
    {
        $base = env('ORDER_SERVICE_URL', 'http://localhost:8200');
        return $this->proxy($request, $base, 'orders/'. $path);
    }

    private function proxy(Request $request, $base, $path)
    {
        $resp = $this->client->request($request->method(), rtrim($base,'/').'/'.ltrim($path,'/'), [
            'headers' => [
                'Content-Type' => $request->header('Content-Type') ?: 'application/json',
                'Accept' => 'application/json'
            ],
            'body' => in_array($request->method(), ['POST','PUT','PATCH']) ? $request->getContent() : null
        ]);
        return response($resp->getBody()->getContents(), $resp->getStatusCode())
            ->header('Content-Type', $resp->getHeaderLine('Content-Type') ?: 'application/json');
    }
}
