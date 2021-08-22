<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

        /**
     * Used to return success response
     * @return Response
     */

    public function success($items = null, $status = 200)
    {
        $data = ['status' => 'success'];

        if ($items instanceof Arrayable) {
            $items = $items->toArray();
        }

        if ($items) {
            foreach($items as $key => $item) {
                $data[$key] = $item;
            }
        }

        return response()->json($data, $status);
    }

    /**
     * Used to return error response
     * @param null $items
     * @param int $status
     * @param int $indexBacktrack
     * @return Response
     * @throws \ReflectionException
     */
    public function error($items = null, $status = 422, $indexBacktrack = 1)
    {
        $data = array();
        $message = '';
        if ($items) {
            foreach($items as $key => $item) {
                $data['errors'][$key][] = $item;
            }
            $message = is_array($items) && array_key_exists('message', $items) && $items['message'] ? ' - ' . $items['message'] : '';
        }

        $className = (new \ReflectionClass($this))->getShortName();
        Log::error('Error raised in controller: ' . $className
            . ' - ' . debug_backtrace()[$indexBacktrack]['function']
            . ' ' . $status . $message);
        return response()->json($data, $status);
    }

    /**
     * @param null $items
     * @param int $status
     * @return Response
     * @throws \ReflectionException
     */
    public function error_functional($items = null, $status = 417) {
        return $this->error($items, $status, 2);
    }
}
