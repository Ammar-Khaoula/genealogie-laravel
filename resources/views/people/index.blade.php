@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-around m-4">
        <h1 class="text-center">Liste des personnes</h1>
        <a href="{{ route('people.create') }}" class="btn btn-primary">Créer une nouvelle personne</a>
    </div>

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
                <th class="p-3 mb-2 bg-black text-white">Nom-Prénom</th>
                <th class="p-3 mb-2 bg-black text-white">Nom De Naissance</th>
                <th class="p-3 mb-2 bg-black text-white">Pseudo</th>
                <th class="p-3 mb-2 bg-black text-white">Date de naissance</th>
                <th class="p-3 mb-2 bg-black text-white">Créateur</th>
                <th class="p-3 mb-2 bg-black text-white">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($people as $person)
                <tr>
                    <td> {{ $person->last_name }} {{ $person->first_name }}</td>
                    <td>{{ $person->birth_name }} </td>
                    <td>{{ $person->middle_names }}</td>
                    <td>{{ $person->date_of_birth }}</td>
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
