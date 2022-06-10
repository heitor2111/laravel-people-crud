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
        $professions = Profession::orderByDesc('name')
            ->get();

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

            $person = new Person();

            $person->first_name = $request->first_name;
            $person->last_name = $request->last_name;
            $person->document = $request->document;

            if ($request->birth_date) {
                $person->birth_date = $request->birth_date;
            }

            DB::beginTransaction();

            $person->save();
            $person->refresh();

            $user = new User();

            $user->username = $request->username;
            $user->password = Hash::make($request->password);

            $person->users()->save($user);

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

            if ($request->profession) {
                $person->professions()->attach($request->profession);
            }

            DB::commit();

            return redirect('/');
        } catch (\Throwable $th) {
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
        $professions = Profession::orderByDesc('name')
            ->get();

        // Select the person with id is equal to received id
        // on route, along with all your relationships.
        $person = Person::with(['contacts', 'professions', 'users'])
            ->where('id', $request->id)
            ->first();

        if (!$person) {
            return redirect('/');
        }

        if (sizeof($person->professions) > 0) {
            foreach ($person->professions as $profession) {
                $person->professionValue = $profession->id;
            }
        }

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

        if (sizeof($person->users) > 0) {
            $person->usernameValue = $person->users[0]->username;
        }

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
            $person = Person::find($request->id);

            if (!$person) {
                return redirect('/');
            }

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

            $person->first_name = $request->first_name;
            $person->last_name = $request->last_name;
            $person->birth_date = $request->birth_date;

            if (sizeof($person->professions) > 0) {
                $person->professions()->delete();
            }

            if ($request->profession) {
                $person->professions()->attach($request->profession);
            }

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

            if ($request->password) {
                $person->users[0]->password = Hash::make($request->password);
            }

            DB::beginTransaction();

            $person->save();
            $person->refresh();

            DB::commit();

            return redirect("/person/{$request->id}");
        } catch (\Throwable $th) {
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
