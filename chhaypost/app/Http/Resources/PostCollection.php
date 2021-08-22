<?php

namespace App\Http\Resources;

class PostCollection extends AbstractCollection
{
    protected function handleData($request)
    {
        return PostResource::collection($this->collection);
    }
}
