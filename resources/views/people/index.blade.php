@extends('layouts.app')

@section('content')
    <h1>Liste des personnes</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <table class="table">
        <thead>
            <tr >
                <th class="p-3 mb-2 bg-black text-white">Nom</th>
                <th class="p-3 mb-2 bg-black text-white">Créateur</th>
                <th class="p-3 mb-2 bg-black text-white">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($people as $person)
                <tr>
                    <td>{{ $person->first_name }} {{ $person->last_name }}</td>
                    <td>{{ $person->creator->name }}</td>
                    <td>
                        <a href="{{ route('people.show', $person->id) }}" class="btn btn-info">Voir</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('people.create') }}" class="btn btn-success">Créer une nouvelle personne</a>
@endsection
