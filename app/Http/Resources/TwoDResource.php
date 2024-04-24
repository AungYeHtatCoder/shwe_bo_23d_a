<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TwoDResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $collection = $this->collection ?? [];

        $plays = [];
        if (!empty($collection)) {
            $plays = $collection->map(function ($item) {
                return [
                    'id' => $item->id ?? null, // Handle potential missing id property
                    'user_name' => $item->user->name ?? 'N/A',
                    'bet_digit' => $item->lottery_two_digit_pivot->bet_digit ?? null,
                    'sub_amount' => $item->lottery_two_digit_pivot->sub_amount ?? null,
                    'session' => $item->session,
                    'created_at' => $item->created_at->toDateTimeString(),
                ];
            });
        }

        $totalSubAmount = 0;
        if (!empty($collection)) {
            $totalSubAmount = $collection->sum(function ($item) {
                return $item->lottery_two_digit_pivot->sub_amount ?? 0;
            });
        }

        return [
            'plays' => $plays,
            'total_sub_amount' => $totalSubAmount,
        ];
    }
}