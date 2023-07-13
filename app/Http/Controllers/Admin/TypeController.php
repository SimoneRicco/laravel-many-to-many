<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    private $validations = [
        'name'     => 'required|string',
        'description' => 'required|string',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::all();
        return view('admin.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validations);
        $data = $request->all();

        $newType = new Type();
        $newType->name = $data['name'];
        $newType->description = $data['description'];
        $newType->save();

        return to_route('admin.types.show', ['type' => $newType]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        return view('admin.types.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        return view('admin.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        $request->validate($this->validations);

        $data = $request->all();
        $type->name = $data['name'];
        $type->description = $data['description'];
        $type->update();

        return to_route('admin.types.show', compact('type'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        if ($type->id != 1) {
            foreach ($type->projects as $project) {
                $project->type_id = 1;
                $project->update();
            }

            $type->delete();
            return to_route('admin.types.index')->with('delete_success', $type);
        } else {
            return to_route('admin.types.index')->with('delete_failed', $type);
        }
    }
}
