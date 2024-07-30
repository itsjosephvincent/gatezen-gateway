<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KycApplicationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->proof_of_id) {
            return [
                'document_type_id' => 'required',
                'proof_of_id' => ['required', 'file', 'mimetypes:image/jpeg,image/png,image/heic,application/pdf', 'max:5120'],
            ];
        } else {
            return [
                'document_type_id' => 'required',
                'proof_of_address' => ['required', 'file', 'mimetypes:image/jpeg,image/png,image/heic,application/pdf', 'max:5120'],
            ];
        }
    }
}
