<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListenRequest;
use Illuminate\Routing\Controller;

class ListenController extends Controller
{
    public function __invoke(ListenRequest $request): array
    {
        return [
            'status' => 'ok1',
        ];
    }
}
