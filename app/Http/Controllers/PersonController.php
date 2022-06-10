<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Person;
use App\Models\Profession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        // Get list of all professions sorted by name.
        $professions = Profession::orderByDesc('name')
            ->get();

        // Call the Person/Create view, sending the professions data.
        return view(
            'person.create',
            ['professions' => $professions]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validate if the request received correct data.
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'document' => 'required|numeric',
                'birth_date' => 'nullable|date',
                'profession' => 'nullable',
                'username' => 'required',
                'password' => 'required',
                'phone_1' => 'nullable|numeric',
                'phone_2' => 'nullable|numeric',
                'email' => 'nullable|email',
            ]);

            // Instance a new Person and set some values.
            $person = new Person();

            $person->first_name = $request->first_name;
            $person->last_name = $request->last_name;
            $person->document = $request->document;

            if ($request->birth_date) {
                $person->birth_date = $request->birth_date;
            }

            // Open a transaction on database.
            DB::beginTransaction();

            // Save Person and refresh model to obtain the Person ID.
            $person->save();
            $person->refresh();

            // Instance a new User and set some values.
            $user = new User();

            $user->username = $request->username;
            $user->password = Hash::make($request->password); // Encrypt the received password.

            // Save the user on database.
            $person->users()->save($user);

            // Validate the contact types and add on array to save.
            $contacts = [];

            if ($request->phone_1) {
                array_push($contacts, new Contact([
                    'description' => 'Telefone',
                    'contact' => $request->phone_1
                ]));
            }

            if ($request->phone_2) {
                array_push($contacts, new Contact([
                    'description' => 'Celular',
                    'contact' => $request->phone_2
                ]));
            }

            if ($request->email) {
                array_push($contacts, new Contact([
                    'description' => 'E-mail',
                    'contact' => $request->email
                ]));
            }

            // If have contacts on array, save the contacts on database.
            if (sizeof($contacts) > 0) {
                $person->contacts()->saveMany($contacts);
            }

            // If have a profession, save him on database.
            if ($request->profession) {
                $person->professions()->attach($request->profession);
            }

            // Confirm the database transaction.
            DB::commit();

            // Redirect to homepage.
            return redirect('/');
        } catch (\Throwable $th) {
            // If have a error during the transaction, cancel all changes.
            DB::rollBack();

            throw $th;
        }
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

            // If not encounter a user, redirect to homepage.
            if (!$person) {
                return redirect('/');
            }

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
    public function edit(Request $request)
    {
        // Get list of all professions sorted by name.
        $professions = Profession::orderByDesc('name')
            ->get();

        // Select the person with id is equal to received id
        // on route, along with all your relationships.
        $person = Person::with(['contacts', 'professions', 'users'])
            ->where('id', $request->id)
            ->first();

        // If not encounter a user, redirect to homepage.
        if (!$person) {
            return redirect('/');
        }

        // If encountered a profession, return the ID of him.
        if (sizeof($person->professions) > 0) {
            foreach ($person->professions as $profession) {
                $person->professionValue = $profession->id;
            }
        }

        // If encountered contacts, also return.
        if (sizeof($person->contacts) > 0) {
            foreach ($person->contacts as $contact) {
                if ($contact->description === 'Telefone') {
                    $person->phone1Value = $contact->contact;
                }
                elseif ($contact->description === 'Celular') {
                    $person->phone2Value = $contact->contact;
                }
                else {
                    $person->emailValue = $contact->contact;
                }
            }
        }

        // If encountered a user, also return.
        if (sizeof($person->users) > 0) {
            $person->usernameValue = $person->users[0]->username;
        }

        // Call the Person/Edit view, sending the person and professions data.
        return view('person.edit', [
            'professions' => $professions,
            'person' => $person
        ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            // Select the person with id is equal to received id on route.
            $person = Person::find($request->id);

            // If not encounter a user, redirect to homepage.
            if (!$person) {
                return redirect('/');
            }

            // Validate if the request received correct data.
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'birth_date' => 'nullable|date',
                'profession' => 'nullable',
                'password' => 'nullable',
                'phone_1' => 'nullable|numeric',
                'phone_2' => 'nullable|numeric',
                'email' => 'nullable|email',
            ]);

            // Set a edited values on model.
            $person->first_name = $request->first_name;
            $person->last_name = $request->last_name;
            $person->birth_date = $request->birth_date;

            // Delete the profession register.
            if (sizeof($person->professions) > 0) {
                $person->professions()->delete();
            }

            // If received a profession ID, create a new register from him.
            if ($request->profession) {
                $person->professions()->attach($request->profession);
            }

            // Delete all contacts and if have a edited contacts, register all of them.
            if (sizeof($person->contacts) > 0) {
                $person->contacts()->delete();

                $contacts = [];

                if ($request->phone_1) {
                    array_push($contacts, new Contact([
                        'description' => 'Telefone',
                        'contact' => $request->phone_1
                    ]));
                }

                if ($request->phone_2) {
                    array_push($contacts, new Contact([
                        'description' => 'Celular',
                        'contact' => $request->phone_2
                    ]));
                }

                if ($request->email) {
                    array_push($contacts, new Contact([
                        'description' => 'E-mail',
                        'contact' => $request->email
                    ]));
                }

                if (sizeof($contacts) > 0) {
                    $person->contacts()->saveMany($contacts);
                }
            }

            // If changed the password, encrypt him.
            if ($request->password) {
                $person->users[0]->password = Hash::make($request->password);
            }

            // Open a transaction on database.
            DB::beginTransaction();

            // Save changes on Person.
            $person->save();

            // Confirm the database transaction.
            DB::commit();

            // Redirect from Person/View page.
            return redirect("/person/{$request->id}");
        } catch (\Throwable $th) {
            // If have a error during the transaction, cancel all changes.
            DB::rollBack();

            throw $th;
        }
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
            // If have a error during the transaction, cancel all changes.
            DB::rollBack();

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

            if (!$person) {
                return redirect('/');
            }

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
