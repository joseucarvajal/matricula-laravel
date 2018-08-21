<?php

namespace App\Http\Controllers\Ciudad;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CiudadsController extends Controller
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
            $ciudads = Ciudad::where('idDepartamento', 'LIKE', "%$keyword%")
                ->orWhere('nombre', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $ciudads = Ciudad::latest()->paginate($perPage);
        }

        return view('ciudad.ciudads.index', compact('ciudads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('ciudad.ciudads.create');
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
			'nombre' => 'required|max:100',
			'idDepartamento' => 'required'
		]);
        $requestData = $request->all();
        
        Ciudad::create($requestData);

        return redirect('ciudad/ciudads')->with('flash_message', 'Ciudad added!');
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
        $ciudad = Ciudad::findOrFail($id);

        return view('ciudad.ciudads.show', compact('ciudad'));
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
        $ciudad = Ciudad::findOrFail($id);

        return view('ciudad.ciudads.edit', compact('ciudad'));
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
			'nombre' => 'required|max:100',
			'idDepartamento' => 'required'
		]);
        $requestData = $request->all();
        
        $ciudad = Ciudad::findOrFail($id);
        $ciudad->update($requestData);

        return redirect('ciudad/ciudads')->with('flash_message', 'Ciudad updated!');
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
        Ciudad::destroy($id);

        return redirect('ciudad/ciudads')->with('flash_message', 'Ciudad deleted!');
    }

    public function ciudadesByDepartamento(Request $request)
    {        
        $ciudades = Ciudad::where('idDepartamento', $request->idDepartamento)->get();
        $ciudadesHTML = "";
        foreach($ciudades as $ciudad){
            $ciudadesHTML .= "<option value='$ciudad->id'>$ciudad->nombre</option>";
        }
        return response($ciudadesHTML, 200);
    }    
}
