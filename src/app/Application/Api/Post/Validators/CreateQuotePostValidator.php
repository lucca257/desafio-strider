<?php

namespace App\Application\Api\Post\Validators;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use function response;

class CreateQuotePostValidator extends FormRequest
{
    /**
     * Disable validator redirect back to use in API
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "content" => "required|max:777",
            "post_id" => "required|exists:posts,id"
        ];
    }
}
