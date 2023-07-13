<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $validations = [
        'title'     => 'required|string|min:5|max:100',
        'url_image' => 'required|url|max:200',
        'image'     => 'nullable|image|max:2048',
        'content'   => 'required|string',
        'type_id'   => 'required|integer|exists:types,id',
        'technologies'          => 'nullable|array',
        'technologies.*'        => 'integer|exists:technologies,id',
    ];

    private $validation_messages = [
        'required'  => 'Il campo :attribute è obbligatorio',
        'min'       => 'Il campo :attribute deve avere almeno :min caratteri',
        'max'       => 'Il campo :attribute non può superare i :max caratteri',
        'url'       => 'Il campo deve essere un url valido',
        'exists'    => 'Valore non valido',
    ];
    public function index()
    {
        $projects = Project::paginate(5);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technology = Technology::all();
        return view("admin.projects.create", compact('types', 'technology'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validare i dati del form
        $request->validate($this->validations, $this->validation_messages);

        $data = $request->all();

        $imagePath = Storage::put('uploads', $data['image']);
        // salvare i dati nel db se validi
        $newProject = new Project();
        $newProject->slug      = Project::slugger($data['title']);
        $newProject->title     = $data['title'];
        $newProject->type_id   = $data['type_id'];
        $newProject->url_image = $data['url_image'];
        $newProject->image     = $imagePath;
        $newProject->content   = $data['content'];
        $newProject->save();

        $newProject->technologies()->sync($data['technology'] ?? []);

        // ridirezionare su una rotta di tipo get
        return to_route('admin.projects.show', ['project' => $newProject]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        // validare i dati del form
        $request->validate($this->validations, $this->validation_messages);

        $data = $request->all();

        if ($data['image']) {
            // salvare l'immagine nuova
            $imagePath = Storage::put('uploads', $data['image']);

            // eliminare l'immagine vecchia
            if ($project->image) {
                Storage::delete($project->image);
            }

            // aggiormare il valore nella colonna con l'indirizzo dell'immagine nuova
            $project->image = $imagePath;
        }
        // aggiornare i dati nel db se validi
        $project->title     = $data['title'];
        $project->slug     = Project::slugger($data['title']);
        $project->url_image = $data['url_image'];
        $project->type_id  = $data['type_id'];
        $project->content   = $data['content'];
        $project->update();

        $project->technologies()->sync($data['technologies'] ?? []);
        // ridirezionare su una rotta di tipo get
        return to_route('admin.projects.show', compact('project'));
        //['project' => $project]
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        $project->technologies()->detach();
        if ($project->image) {
            Storage::delete($project->image);
        }
        $project->delete();

        return to_route('admin.projects.index')->with('delete_success', $project);
    }
}
