<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $owned  = $user->projectsOwned()->latest()->get();
        $member = $user->projectsMember()->latest()->get();

        return view('projects.index', compact('owned', 'member'));
    }

    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'nullable|numeric',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'members'     => 'nullable|array',
            'members.*'   => 'exists:users,id',
        ]);

        $project = Project::create([
            'user_id'     => Auth::id(),
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'] ?? null,
            'start_date'  => $data['start_date'] ?? null,
            'end_date'    => $data['end_date'] ?? null,
        ]);

        if (!empty($data['members'])) {
            $project->users()->attach($data['members']);
        }

        return redirect()
            ->route('projects.show', $project)
            ->with('status', 'Projekt kreiran.');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        $users = User::where('id', '!=', Auth::id())->get();

        return view('projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $user = Auth::user();

        if ($user->id === $project->user_id) {
            $data = $request->validate([
                'name'           => 'required|string|max:255',
                'description'    => 'nullable|string',
                'price'          => 'nullable|numeric',
                'start_date'     => 'nullable|date',
                'end_date'       => 'nullable|date|after_or_equal:start_date',
                'obavljeni_poslovi' => 'nullable|string',
                'members'        => 'nullable|array',
                'members.*'      => 'exists:users,id',
            ]);

            $project->update([
                'name'              => $data['name'],
                'description'       => $data['description'] ?? null,
                'price'             => $data['price'] ?? null,
                'start_date'        => $data['start_date'] ?? null,
                'end_date'          => $data['end_date'] ?? null,
                'obavljeni_poslovi' => $data['obavljeni_poslovi'] ?? $project->obavljeni_poslovi,
            ]);

            if (isset($data['members'])) {
                $project->users()->sync($data['members']);
            }

            return redirect()
                ->route('projects.show', $project)
                ->with('status', 'Projekt ažuriran.');
        }

        if ($project->users()->where('user_id', $user->id)->exists()) {
            $data = $request->validate([
                'obavljeni_poslovi' => 'required|string',
            ]);

            $project->update([
                'obavljeni_poslovi' => $data['obavljeni_poslovi'],
            ]);

            return redirect()
                ->route('projects.show', $project)
                ->with('status', 'Obavljeni poslovi ažurirani.');
        }

        abort(403, 'Nemaš pravo uređivati ovaj projekt.');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('status', 'Projekt obrisan.');
    }
}