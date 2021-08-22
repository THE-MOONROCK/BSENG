<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class AbstractCollection extends ResourceCollection
{

    abstract protected function handleData($request);

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $fromRecord = ($this->currentPage() * $this->perPage() - $this->perPage()) + 1;
        $pathUrl = Str::replaceLast('?page=1','', $this->url(1));
        $data = $this->handleData($request);
        return [
            'data' => $data,
            'current_page' => $this->currentPage(),
            'total' => $this->total(),
            'from' => $fromRecord,
            'to' => $this->count(), // record counts of current page
            'per_page' => $this->perPage(),
            'last_page' => $this->lastPage(),
            'path' => $pathUrl,
            'first_page_url' => $this->url(1),
            'last_page_url' => $this->url($this->lastPage()),
            'next_page_url' => $this->nextPageUrl(),
            'prev_page_url' => $this->previousPageUrl(),
        ];
    }

    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);
        unset($jsonResponse['links'],$jsonResponse['meta']);
        $response->setContent(json_encode($jsonResponse));
    }
}
