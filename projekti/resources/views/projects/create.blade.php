<x-app-layout>
<div class="container">
    <h1>Kreiraj projekt</h1>
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <div>
            <label>Naziv</label>
            <input name="name" required>
        </div>
        <div>
            <label>Opis</label>
            <textarea name="description"></textarea>
        </div>
        <div>
            <label>Cijena</label>
            <input name="price" type="number" step="0.01">
        </div>
        <div>
            <label>Datum početka</label>
            <input name="start_date" type="date">
        </div>
        <div>
            <label>Datum završetka</label>
            <input name="end_date" type="date">
        </div>

        <div>
            <label>Članovi tima</label>
            <select name="members[]" multiple>
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                @endforeach
            </select>
        </div>

        <button type="submit">Spremi</button>
    </form>
</div>
</x-app-layout>