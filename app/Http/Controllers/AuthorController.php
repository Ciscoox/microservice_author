<?php

namespace App\Http\Controllers;


use App\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
   
    use ApiResponser;

   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
    * Retornamos un listado de author
    * @return Illuminate\Http\Response
    */   

    public function index()
    {
        $authors = Author::all();

        return $this->successResponse($authors);
    }

    /**
     * Retornamos un author especifico
     * @return Illuminate\Http\Response
     */
    public function show($author)
    {

        $authors = Author::findOrFail($author);

        return $this->successResponse($authors);
    }

     /**
     * Creamos un instacia de author
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [

            'name' => 'required|max:255',
            'gender' => 'required|max:255|in:male,female',
            'country' => 'required|max:255'
        ];

        $this->validate($request,$rules);

        $authors = Author::create($request->all());

        return $this->successResponse($authors,Response::HTTP_CREATED);
    }

    /**
     * Actualizamos la información de un author
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $author)
    {

        $rules = [

            'name' => 'max:255',
            'gender' => 'max:255|in:male,female',
            'country' => 'max:255'
        ];

        $this->validate($request,$rules);

        $authors = Author::findOrFail($author);


        $authors->fill($request->all());

        if($authors->isClean())
        {
            return $this->errorResponse('Al menos un valor debe ser cambiado', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $authors->save();


        return $this->successResponse($authors);
    }

    /**
     * Eliminamos un author
     * @return Illuminate\Http\Response
     */
    public function destroy($author)
    {

        $authors = Author::findOrFail($author);

        $authors->delete();

        return $this->successResponse($authors);

    }
}
