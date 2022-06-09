<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // Select the first 20 people sorted by creation date.
            $people = Person::orderByDesc('created_at')
                ->paginate(20);

            // Call the Person/Index view, sending the people data.
            return view(
                'person.index',
                ['people' => $people]
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('person.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            // Select the person with id is equal to received id
            // on route, along with all your relationships.
            $person = Person::with(['contacts', 'professions', 'users'])
                ->where('id', $request->id)
                ->first();

            // Call the Person/Show view, sending the person data.
            return view(
                'person.show',
                ['person' => $person]
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        return view('person.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        try {
            // Open a transaction on database.
            DB::beginTransaction();

            // Delete the received person.
            $response = $person->delete();

            // Confirm the database transaction.
            DB::commit();

            return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Receive ID from view and call the "PersonController@destroy" method.
     *
     * @param integer $id
     * @return void
     */
    public static function delete($id)
    {
        try {
            // Select the person with id is equal to received id on route.
            $person = Person::find($id);

            // Call the "destroy" method, to delete the selected person.
            $controller = new PersonController();
            $controller->destroy($person);

            // Redirects to homepage after delete the person.
            return redirect('/');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
