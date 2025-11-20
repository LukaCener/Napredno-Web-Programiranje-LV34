<x-app-layout>
<div class="container">
    <h1>Moji projekti</h1>

    <h2>Projekti koje sam otvorio</h2>
    @if($owned->isEmpty())
        <p>Nema projekata koje si otvorio.</p>
    @else
        <ul>
            @foreach($owned as $p)
                <li>
                    <a href="{{ route('projects.show', $p) }}">{{ $p->name }}</a>
                    (početak: {{ $p->start_date ?? '-' }}, kraj: {{ $p->end_date ?? '-' }})
                </li>
            @endforeach
        </ul>
    @endif

    <h2>Projekti na kojima sam član</h2>
    @if($member->isEmpty())
        <p>Nema projekata na kojima si član.</p>
    @else
        <ul>
            @foreach($member as $p)
                <li>
                    <a href="{{ route('projects.show', $p) }}">{{ $p->name }}</a>
                    (voditelj: {{ $p->owner->name }})
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('projects.create') }}" class="btn">Kreiraj novi projekt</a>
</div>
</x-app-layout>