<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static function ResponseMapTransaction($transactions)
    {
        return [
            'id' => $transactions->id,
            'title' => $transactions->title,
            'value' => $transactions->value,
            'type' => $transactions->type
        ];
    }
}
