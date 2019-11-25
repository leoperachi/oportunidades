<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class OperadorRequest extends FormRequest
{
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
            'senha' => 'required|max:30|min:8|confirmed',
            'senha_confirmation' => 'required|max:30|min:8',
            'perfil' => 'required',
            'nome' => 'required',
            'cpf' => 'required|min:11|max:11',
            'apelido' => 'nullable|max:20',
            'email' => 'required',
            'operadora' => 'required',
            'unidade' => 'required_with:operadora',
            'telefone' => 'required',
            'celular' => 'nullable',
            'ramal' => 'nullable',
            'cep' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute precisa ser preenchido!',
            'senha.min' => 'O campo :attribute precisa ter pelo menos 8 caracteres.',
            'senha_confirmation.min' => 'O campo :attribute precisa ter pelo menos 8 caracteres.',
            'senha.regex' => 'É necessário ao menos um caracter especial!!',
            'confirmed' => 'As senhas não conferem!',
            'numeric' => 'O campo :attribute é somente números.',
        ];
    }
    public function attributes()
    {
        return [
            'senha_confirmation' => 'Confirmação de Senha',
        ];
    }

}
