@extends('layouts.app')
@section('title', 'Gestion comptes')

@section('content')
    @foreach(\App\Models\Utilisateur::all() as $user)
        @php($input_disabled = $user->isAdmin() ? 'disabled' : '')
        @php($state_disabled = $user->getState() === \App\Enums\UserStateEnum::STATE_DISABLED)

        <div class="card w-50 mx-auto text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $user->getFullName() }}</h5>
                <div class="d-flex flex-row justify-content-center">
                    @if($state_disabled)
                        <form method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <input type="hidden" name="action" value="validate">
                            <button class="ml-2 btn btn-success"><i class="fas fa-check mr-2"></i>Valider!</button>
                        </form>
                    @else
                        <form method="POST" class="ml-2">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <input type="hidden" name="action" value="modify">
                            <button class="btn btn-primary" {{ $input_disabled }}><i class="fas fa-user-edit mr-2"></i>Modifier
                            </button>
                            {{-- Ajouter du js pour afficher un form permettant de modifier le profil --}}
                        </form>
                        <form method="POST" class="ml-2">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <input type="hidden" name="action" value="change-password">
                            <button class="btn btn-dark" {{ $input_disabled }}><i class="fas fa-unlock mr-2"></i>Changer
                                de mot de passe
                            </button>
                        </form>
                        <form method="POST" class="ml-2">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <input type="hidden" name="action" value="disable">
                            <button class="btn btn-danger" {{ $input_disabled }}><i class="fas fa-ban mr-2"></i>Désactiver</button>
                        </form>
                    @endif
                    <form method="POST" class="ml-2">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <input type="hidden" name="action" value="delete">
                        <button class="btn btn-danger" {{ $input_disabled }}><i class="fas fa-user-slash mr-2"></i>Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
