<?php

namespace App\Http\Controllers\Matricula;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Matricula;
use Illuminate\Http\Request;

class MatriculasController extends Controller
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
            $matriculas = Matricula::where('idDepartamento', 'LIKE', "%$keyword%")
                ->orWhere('idCiudad', 'LIKE', "%$keyword%")
                ->orWhere('nombre', 'LIKE', "%$keyword%")
                ->orWhere('documento', 'LIKE', "%$keyword%")
                ->orWhere('edad', 'LIKE', "%$keyword%")
                ->orWhere('estrato', 'LIKE', "%$keyword%")
                ->orWhere('valor', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $matriculas = Matricula::latest()->paginate($perPage);
        }

        return view('matricula.matriculas.index', compact('matriculas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('matricula.matriculas.create');
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
			'idDepartamento' => 'required',
			'idCiudad' => 'required',
			'nombre' => 'required|max:100',
			'documento' => 'required|max:20',
            'valor' => 'required',
            'edad' => 'integer|min:1',
		]);
        $requestData = $request->all();
        
        Matricula::create($requestData);

        return redirect('matricula/matriculas')->with('flash_message', 'Matricula added!');
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
        $matricula = Matricula::findOrFail($id);

        return view('matricula.matriculas.show', compact('matricula'));
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
        $matricula = Matricula::findOrFail($id);

        return view('matricula.matriculas.edit', compact('matricula'));
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
			'idDepartamento' => 'required',
			'idCiudad' => 'required',
			'nombre' => 'required|max:100',
			'documento' => 'required|max:20',
			'valor' => 'required'
		]);
        $requestData = $request->all();
        
        $matricula = Matricula::findOrFail($id);
        $matricula->update($requestData);

        return redirect('matricula/matriculas')->with('flash_message', 'Matricula updated!');
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
        Matricula::destroy($id);

        return redirect('matricula/matriculas')->with('flash_message', 'Matricula deleted!');
    }
}
