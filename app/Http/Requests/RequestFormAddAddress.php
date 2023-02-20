<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestFormAddAddress extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'fullName' => ['required','string', 'max:25'],
            'phoneNumber' => ['required','numeric','regex:/^0[0-9]{9}$/'],
            'province' => ['required'],
            'district' => ['required'],
            'ward' => ['required'],
            'addressDetail' => ['required','string', 'max:200'],         
        ];
            
    }
    public function messages()
{
    return [
    'fullName.required' => 'Vui lòng nhập họ và tên',
    'fullName.string' => 'Họ và tên phải là chuỗi ký tự',
    'fullName.max' => 'Họ và tên tối đa :max ký tự',
    'phoneNumber.required' => 'Vui lòng nhập số điện thoại',
    'phoneNumber.numeric' => 'Số điện thoại phải là số',
    'phoneNumber.regex' => 'Số điện thoại phải có 10 chữ số',
    'province.required' => 'Vui lòng chọn tỉnh / thành phố',
    'district.required' => 'Vui lòng chọn quận / huyện',
    'ward.required' => 'Vui lòng chọn phường / xã',
    'addressDetail.required' => 'Vui lòng nhập địa chỉ chi tiết',
    ];
}
}
