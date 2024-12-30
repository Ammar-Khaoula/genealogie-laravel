@extends('layouts.app')

@section('content')
    <div class="card text-center" style="width: 60%;">

        <h1 class="p-3 mb-2 bg-black text-white">{{ $person->first_name }} {{ $person->last_name }}</h1>
        <p class="card-text">Date de naissance : {{ $person->date_of_birth }}</p>
        <p class="card-text">Créé par : {{ $person->creator->name }}</p>

        <h3 class="p-3 mb-2 bg-dark-subtle text-white">Enfants</h3>
        <ul>
            @foreach($person->children as $child)
                <li>{{ $child->first_name }} {{ $child->last_name }}</li>
            @endforeach
        </ul>

        <h3 class="p-3 mb-2 bg-dark-subtle text-white">Parents</h3>
        <ul>
            @foreach($person->parents as $parent)
                <li>{{ $parent->first_name }} {{ $parent->last_name }}</li>
            @endforeach
        </ul>

        <a href="{{ route('people.index') }}" class="btn btn-info">Retour à la liste</a>
    </div>
@endsection
