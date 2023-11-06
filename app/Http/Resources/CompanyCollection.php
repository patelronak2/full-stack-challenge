<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Company */
class CompanyCollection extends ResourceCollection
{
    public function toArray(Request $request)
    {
        return $this->collection->toArray();
    }
}
