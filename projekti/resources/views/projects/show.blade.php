<x-app-layout>
<div class="container">

    <h1>{{ $project->name }}</h1>

    <p><strong>Opis:</strong> {{ $project->description }}</p>

    <p><strong>Cijena:</strong> {{ $project->price }}</p>

    <p><strong>Datum početka:</strong> {{ $project->start_date }}</p>
    <p><strong>Datum završetka:</strong> {{ $project->end_date }}</p>

    <p><strong>Voditelj:</strong> {{ $project->owner->name }}</p>

    <p><strong>Članovi tima:</strong>
        @foreach($project->users as $u)
            {{ $u->name }}@if(!$loop->last), @endif
        @endforeach
    </p>

    <p><strong>Obavljeni poslovi:</strong><br>
        {{ $project->obavljeni_poslovi }}
    </p>

    <a href="{{ route('projects.edit', $project) }}">Uredi</a>

</div>
</x-app-layout>