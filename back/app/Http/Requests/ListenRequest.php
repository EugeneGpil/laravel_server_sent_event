<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $battle_id
 * @property string $last_turn_number
 */
class ListenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'battle_id'        => 'required|int',
            'last_turn_number' => 'required|int',
        ];
    }
}
