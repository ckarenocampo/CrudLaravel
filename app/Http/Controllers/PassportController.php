<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PassportController extends Controller
{
    //
        public function create()
    {
        return view('create');
    }
    public function store(Request $request)
    {
        if($request->hasfile('filename'))
         {
            $file = $request->file('filename');
            //$name=time().$file->getClientOriginalName();
            $name=$file->getClientOriginalName();
            $file->move(public_path().'/images/', $name);
         }
        $passport= new \App\Passport;
        $passport->name=$request->get('name');
        $passport->email=$request->get('email');
        $passport->number=$request->get('number');
       // $date=date_create($request->get('date'));
       // $format = date_format($date,"Y-m-d");
       // $passport->date = strtotime($format);
        $passport->date=$request->get('date');
        $passport->office=$request->get('office');
        $passport->filename=$name;
        $passport->save();
        
        return redirect('passports')->with('success', 'Information has been added');
    }
    public function index()
    {
        $passports=\App\Passport::all();
        return view('index',compact('passports'));
    }
    public function edit($id)
    {
        $passport = \App\Passport::find($id);
        return view('edit',compact('passport','id'));
    }
    public function destroy($id)
    {
        $passport = \App\Passport::find($id);
        $passport->delete();
        return redirect('passports')->with('success','Information has been  deleted');
    }
    public function update(Request $request, $id)
    {
        $passport= \App\Passport::find($id);
        $passport->name=$request->get('name');
        $passport->date=$request->get('date');
        $passport->filename=$request->get('filename');
        $passport->email=$request->get('email');
        $passport->number=$request->get('number');
        $passport->office=$request->get('office');
        $passport->save();
        return redirect('passports');
    }

}
