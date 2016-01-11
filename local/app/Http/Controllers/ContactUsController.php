<?php namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;

class ContactUsController extends Controller {

    public function create()
    {
        return view('contact');
    }

    public function store(ContactFormRequest $request)
    {
    	\Mail::send('emails.contact',
        array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'user_message' => $request->get('message')
        ), function($message)
	    {
	        $message->from('noreply@kontakku.com');
	        $message->to('gunantosteven@gmail.com', 'Admin')->subject('Kontakku Feedback');
	    });

	  	return \Redirect::route('contact')->with('message', 'Thanks for contacting us!');
    }

}