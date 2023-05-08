<?php

namespace App\Http\Controllers;

use App\Consts\CachePrefixes;
use App\Http\Requests\ListenRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ListenController extends Controller
{
    public function __invoke(ListenRequest $request): JsonResponse|StreamedResponse|array
    {
        $battle = Cache::get(CachePrefixes::BATTLE . $request->battle_id);

        if ($battle === null) {
            return response()->json([
                'status' => false,
                'error'  => 'battle_not_found',
            ], 404);
        }

        ignore_user_abort(true);

        $response = new StreamedResponse(static function () use ($battle): void {
            echo 'battle: ' . json_encode($battle, JSON_THROW_ON_ERROR) . "\n";

            ob_flush();
            flush();

            $battleId = $battle['id'];
            $turnNumber = $battle['turn'] + 1;

            while (true) {
                $turn = Cache::get(CachePrefixes::TURN . $battleId . '_' . $turnNumber);

                if ($turn !== null) {
                    echo 'turn: ' . json_encode($turn, JSON_THROW_ON_ERROR) . "\n";

                    $battle = Cache::get(CachePrefixes::BATTLE . $battleId);

                    echo 'battle: ' . json_encode($battle, JSON_THROW_ON_ERROR) . "\n";

                    ob_flush();
                    flush();

                    ++$turnNumber;
                }

                if (connection_aborted()) {
                    exit();
                }

                echo "heartbeat:\n";
                ob_flush();
                flush();

                sleep(2);
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cache-Control', 'no-cache');
        return $response;
    }
}
