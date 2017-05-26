<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Http\Requests\SaveUserContacts;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    
    /**
     * Create contact
     *
     * @param SaveUserContacts $request
     *
     * @return \Illuminate\Http\Response
     */
    public function create(SaveUserContacts $request)
    {
        $name = $request->input('name');
        $nick_name = $request->input('nick_name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $company = $request->input('company');
        $birth_date = $request->input('birth_date');
		
		if($birth_date=="")
			$birth_date=Carbon::now()->toDateString();
		
        $gender = $request->input('gender');
        
        $newContact = new Contact;
        
        $newContact->name = $name;
        $newContact->user_id = Auth::id();
        $newContact->nick_name = $nick_name;
        $newContact->email = $email;
        $newContact->phone = $phone;
        $newContact->address = $address;
        $newContact->company = $company;
        $newContact->birth_date = $birth_date;
        $newContact->gender = $gender;
        
        $newContact->save();
    }
    
    /**
     * Get contacts list
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
		if($request->input('query')=='' )
		$contacts=Contact::all();
	else
		$contacts=Contact::where('name','LIKE',$request->input('query')."%")->get(); 
	
		foreach ($contacts as $contact) {
			
			$contact->age=$contact->age();
			
			$contact->birth=$contact->birth_date->toDateString() ;
					
			switch($contact->gender)
			{
				case "0"; $contact->gender="-";$contact->gender_flag=0;break;
				case "1"; $contact->gender="Male";$contact->gender_flag=1;break;
				case "2"; $contact->gender="Female";$contact->gender_flag=2;break;
			}
		}
	//var_dump($contacts);
		return $contacts;
    }
    
    /**
     * Delete contact
     *
     * @param $request
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $contact = Contact::find($id);
        $contact->delete();
    }
    
    /**
     * Updatecontact
     *
     * @param $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		$id = $request->input('id');
        $name = $request->input('name');
        $nick_name = $request->input('nick_name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $company = $request->input('company');
		
        $birth_date = $request->input('birth_date');
		if($birth_date=="")
			$birth_date=Carbon::now()->toDateString() ;
		
		
        $gender = $request->input('gender');
		
		$validator = Validator::make($request->all(), Contact::updateRequestRules($id));
		
        $contact = Contact::find($id);

        $contact->name = $name;
		$contact->user_id = Auth::id();
        $contact->nick_name = $nick_name;
        $contact->email = $email;
        $contact->phone = $phone;
        $contact->address = $address;
        $contact->company = $company;
        $contact->birth_date = $birth_date;
        $contact->gender = $gender;
        
        $contact->save();
    }
}
