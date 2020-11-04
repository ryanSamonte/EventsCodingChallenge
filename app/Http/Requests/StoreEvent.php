<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvent extends FormRequest
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
            'event_name' => 'required|max:150',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'days' => 'required'
        ];
    }
    
    public function messages()
    {
        return [
            'event_name.required' => 'Event name is required',
            'event_name.max' => 'Event name max character is 150',
            'from_date.required' => 'From Date is required',
            'from_date.date' => 'Invalid date format',
            'to_date.required' => 'To Date is required',
            'to_date.date' => 'Invalid date format',
            'to_date.after_or_equal' => 'To Date must be after or equal to from date',
            'days.required' => 'Must select at least one (1) day',
        ];
    }
}
