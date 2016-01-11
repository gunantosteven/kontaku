<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ContactFormRequest extends Request {

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
	    return [
	    'name' => 'required',
	    'email' => 'required|email',
	    'message' => 'required',
	  ];
  }

}