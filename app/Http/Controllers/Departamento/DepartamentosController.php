<?php

namespace App\Http\Controllers\Departamento;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Departamento;
use Illuminate\Http\Request;

class DepartamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $departamentos = Departamento::where('nombre', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $departamentos = Departamento::latest()->paginate($perPage);
        }

        return view('departamento.departamentos.index', compact('departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('departamento.departamentos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'nombre' => 'required|max:30'
		]);
        $requestData = $request->all();
        
        Departamento::create($requestData);

        return redirect('departamento/departamentos')->with('flash_message', 'Departamento added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $departamento = Departamento::findOrFail($id);

        return view('departamento.departamentos.show', compact('departamento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $departamento = Departamento::findOrFail($id);

        return view('departamento.departamentos.edit', compact('departamento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'nombre' => 'required|max:30'
		]);
        $requestData = $request->all();
        
        $departamento = Departamento::findOrFail($id);
        $departamento->update($requestData);

        return redirect('departamento/departamentos')->with('flash_message', 'Departamento updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Departamento::destroy($id);

        return redirect('departamento/departamentos')->with('flash_message', 'Departamento deleted!');
    }
}
