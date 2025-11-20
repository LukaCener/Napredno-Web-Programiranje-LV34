<x-app-layout>
<div class="container">

    <h1>Uredi projekt</h1>

    <form method="POST" action="{{ route('projects.update', $project) }}">
        @csrf
        @method('PUT')

        @if(auth()->id() === $project->user_id)
            {{-- Voditelj može mijenjati sve --}}
            <label>Naziv:</label>
            <input type="text" name="name" value="{{ $project->name }}">

            <label>Opis:</label>
            <textarea name="description">{{ $project->description }}</textarea>

            <label>Cijena:</label>
            <input type="number" name="price" value="{{ $project->price }}">

            <label>Datum početka:</label>
            <input type="date" name="start_date" value="{{ $project->start_date }}">

            <label>Datum završetka:</label>
            <input type="date" name="end_date" value="{{ $project->end_date }}">

            <label>Članovi tima:</label>
            <select name="members[]" multiple>
                @foreach($users as $u)
                    <option value="{{ $u->id }}"
                        @if($project->users->contains($u->id)) selected @endif>
                        {{ $u->name }}
                    </option>
                @endforeach
            </select>
        @endif

        {{-- Član tima i voditelj mogu uređivati obavljene poslove --}}
        <label>Obavljeni poslovi:</label>
        <textarea name="obavljeni_poslovi">{{ $project->obavljeni_poslovi }}</textarea>

        <button type="submit">Spremi</button>
    </form>

</div>
</x-app-layout>