@extends('layouts.app')
@section('title', 'Réserver une place')

@section('content')
    <div class="card mb-2 mt-2 w-50 mx-auto text-center">
        <div class="card-body">
            <span class="card-title h5">Réserver une place</span>

            <form method="POST">
                @csrf
                <button class="btn btn-primary">Réserver une place</button>
            </form>
        </div>
    </div>
@endsection
