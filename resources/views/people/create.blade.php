@extends('layouts.app')

@section('content')
    <div class="container" style="width: 60%;">
        <h1>Créer une nouvelle personne</h1>
            <form action="{{ route('people.store') }}" method="POST" class="border ">
                @csrf
                <div class="mb-3">
                    <label for="first_name" class="form-label">Prénom :</label>
                    <input type="text" name="first_name" id="first_name" required>
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Nom :</label>
                    <input type="text" name="last_name" id="last_name" required>
                </div>

                <div class="mb-3">
                    <label for="birth_name" class="form-label">Nom De Naissance:</label>
                    <input type="text" name="birth_name " id="birth_name ">
                </div>
                <div class="mb-3">
                    <label for="middle_names" class="form-label">pseudo :</label>
                    <input type="text" name="middle_names " id="middle_names ">
                </div>

                <div class="mb-3">
                    <label for="date_of_birth" class="form-label">Date de naissance :</label>
                    <input type="date" name="date_of_birth" id="date_of_birth">
                </div>

                <button type="submit" class="btn btn-success">Enregistrer</button>
            </form>
    </div>
@endsection
