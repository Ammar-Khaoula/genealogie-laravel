@extends('layouts.app')

@section('content')
<h1>Créer une nouvelle personne</h1>
<form action="{{ route('people.store') }}" method="POST">
    @csrf
    <label for="first_name">Prénom :</label>
    <input type="text" name="first_name" id="first_name" required>

    <label for="last_name">Nom :</label>
    <input type="text" name="last_name" id="last_name" required>

    <label for="date_of_birth">Date de naissance :</label>
    <input type="date" name="date_of_birth" id="date_of_birth">

    <button type="submit" class="btn btn-success">Enregistrer</button>
</form>
@endsection
