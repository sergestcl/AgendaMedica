<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = User::Patients()->get();
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name'=> 'required|min:3',
            'email' => 'required|email',
            'cedula'=> 'required|digits:10',
            'address'=> 'nullable|min:6',
            'phone' => 'required',
       ];
       $messages = [
        'name.required'=> 'El nombre del paciente es obligatorio',
        'name.min'=> 'El nombre del paciente debe tener más de 3 caracteres',
        'email.required'=> 'El correo electrónico es obligatorio',
        'email.email'=> 'Ingresa una dirección de correo válida',
        'cedula.required'=> 'La cédula es obligatorio',
        'cedula.digits'=> 'La cédula debe tener 10 digitos',
        'address.min'=> 'La dirección debe tener al menos 6 caracteres',
        'phone.min'=> 'El número de teléfono es obligatorio',
       ];

       $this->validate($request, $rules, $messages);

       User::create(
        $request->only('name','email','cedula','address','phone')
        + [
            'role' => 'paciente',
            'password' => bcrypt($request->input('password'))
        ]
       );

       $notification = ' El paciente se ha registrado correctamente.';
       return redirect('/pacientes')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $patient = User::Patients()->findOrFail($id);
       return view('patients.edit', compact('patient'));
    }

    /**
     * Acutalización Pacientes
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name'=> 'required|min:3',
            'email' => 'required|email',
            'cedula'=> 'required|digits:10',
            'address'=> 'nullable|min:6',
            'phone' => 'required',
       ];
       $messages = [
        'name.required'=> 'El nombre del paciente es obligatorio',
        'name.min'=> 'El nombre del paciente debe tener más de 3 caracteres',
        'email.required'=> 'El correo electrónico es obligatorio',
        'email.email'=> 'Ingresa una dirección de correo válida',
        'cedula.required'=> 'La cédula es obligatorio',
        'cedula.digits'=> 'La cédula debe tener 10 digitos',
        'address.min'=> 'La dirección debe tener al menos 6 caracteres',
        'phone.min'=> 'El número de teléfono es obligatorio',
       ];

       $this->validate($request, $rules, $messages);
       $user = User::Patients()->findOrFail($id);

       $data = $request->only('name','email','cedula','address','phone');
       $password = $request->input('password');

       if($password)
            $data['password'] = bcrypt($password);
       $user->fill($data);
       $user->save();

       $notification = 'El paciente se ha actualizado correctamente.';
       return redirect('/pacientes')->with(compact('notification'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::Patients()->findOrFail($id);
        $PacienteName = $user->name;
        $user->delete();

        $notification = "El paciente $PacienteName se eliminó correctamente";

        return redirect('/pacientes')->with(compact('notification'));
    }
}
