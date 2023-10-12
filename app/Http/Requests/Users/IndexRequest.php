<?php

namespace App\Http\Requests\Users;

use App\Support\AppConstant;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'filter' => ['sometimes', 'string'],
            'range'  => ['sometimes', 'string'],
            'sort'   => ['sometimes', 'string'],
        ];
    }

    /**
     * @return array<mixed>
     */
    public function validated($key = null, $default = null): array
    {
        $data = parent::validated($key, $default);

        $result = [];

        if (array_key_exists('filter', $data)) {
            $result['filter'] = json_decode($data['filter'], true);
        }

        if (array_key_exists('sort', $data)) {
            $sortArr = json_decode($data['sort'], true);
            if (count($sortArr) == 2) {
                $result[AppConstant::SEARCH_SORT] = $sortArr[0];
                $result[AppConstant::SEARCH_SORT_BY] = $sortArr[1];
            }
        }

        if (array_key_exists('range', $data)) {
            $rangeArr = json_decode($data['range'], true);
            if (count($rangeArr) == 2) {
                if ($rangeArr[0] >= 0 && $rangeArr[1] > $rangeArr[0]) {
                    $result[AppConstant::SEARCH_FROM] = $rangeArr[0];
                    $result[AppConstant::SEARCH_TO] = $rangeArr[1];
                }
            }
        }

        return $result;
    }
}
