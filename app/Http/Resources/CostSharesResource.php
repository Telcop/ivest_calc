<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CostSharesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'prod_code' => $this->prod_code,
            'prod_name' => $this->prod_name,
            'date'      => $this->date,
            'quotes'    => $this->quotes,
            'created_at'=> $this->created_at
        ];
    }
}
