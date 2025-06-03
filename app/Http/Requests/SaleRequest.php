<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class SaleRequest extends FormRequest
{
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
        return [
            'seller_id' => [
                'required',
                'integer',
                'exists:sellers,id'
            ],
            'value' => [
                'required',
                'numeric',
                'min:0.01',
                'max:999999.99',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            'sale_date' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'before_or_equal:today',
                'after:2020-01-01'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'seller_id.required' => 'O vendedor é obrigatório.',
            'seller_id.integer' => 'O ID do vendedor deve ser um número inteiro.',
            'seller_id.exists' => 'O vendedor selecionado não existe.',
            
            'value.required' => 'O valor da venda é obrigatório.',
            'value.numeric' => 'O valor da venda deve ser um número.',
            'value.min' => 'O valor da venda deve ser maior que zero.',
            'value.max' => 'O valor da venda não pode exceder R$ 999.999,99.',
            'value.regex' => 'O valor da venda deve ter no máximo 2 casas decimais.',
            
            'sale_date.required' => 'A data da venda é obrigatória.',
            'sale_date.date' => 'A data da venda deve ser uma data válida.',
            'sale_date.date_format' => 'A data da venda deve estar no formato YYYY-MM-DD.',
            'sale_date.before_or_equal' => 'A data da venda não pode ser no futuro.',
            'sale_date.after' => 'A data da venda deve ser posterior a 01/01/2020.'
        ];
    }

    public function attributes(): array
    {
        return [
            'seller_id' => 'vendedor',
            'value' => 'valor da venda',
            'sale_date' => 'data da venda'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Dados inválidos.',
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'value' => is_string($this->value) ? 
                (float) str_replace([',', 'R$', ' '], ['', '', ''], $this->value) : 
                $this->value,
            'sale_date' => $this->sale_date ? 
                Carbon::parse($this->sale_date)->format('Y-m-d') : 
                $this->sale_date
        ]);
    }
}
