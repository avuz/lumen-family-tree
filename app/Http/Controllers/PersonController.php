<?php

namespace App\Http\Controllers;

use App\Person;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PersonController extends Controller
{
    /**
     * @param $id
     * @return array
     */
    public function show($id)
    {
        $person = Person::query()->with(['father', 'mother'])->where('id', $id)->first();
        if ($person) {
            return [
                'success' => true,
                'person' => $person
            ];
        }

        return [
            'success' => false,
            'error' => [
                'code' => 404,
                'message' => 'Person not found'
            ]
        ];
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|min:1|max:255',
            'last_name' => 'required|string|min:1|max:255',
            'year_of_birth' => 'required|integer|min:1|max:' . date("Y"),
            'father_id' => [
                'integer',
                Rule::exists('persons', 'id')->where(function ($query) use ($request) {
                    $query->where('year_of_birth', '<', $request->year_of_birth);
                })
            ],
            'mother_id' => [
                'integer',
                Rule::exists('persons', 'id')->where(function ($query) use ($request) {
                    $query->where('year_of_birth', '<', $request->year_of_birth);
                })
            ],
        ]);

        $person = Person::create($request->all());

        return [
            'success' => true,
            'person' => $person
        ];
    }
}
