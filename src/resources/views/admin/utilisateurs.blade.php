@extends('layouts.app')
@section('title', 'Gestion comptes')

@section('content')
    @php
        $ligues = \App\Models\Ligue::all();
    @endphp

    @foreach(\App\Models\Utilisateur::all() as $user)
        @php
            $input_disabled = $user->isAdmin() ? 'disabled' : '';
            $state = $user->getState();
            $enabled = $state === \App\Enums\UserStateEnum::STATE_ENABLED;
            $personnel = $user->toPersonnel();
            $ligue_id = ($personnel !== null) ? $personnel->id_ligue : null;
        @endphp

        <div class="card w-50 mx-auto text-center">
            <div class="card-body">
                <span class="card-title font-weight-light h3">{{ $user->getFullName() }}</span>
                <div class="mb-2">
                    @if($state === \App\Enums\UserStateEnum::STATE_NEWLY_CREATED)
                        <p class="font-italic">Cet utilisateur n'a pas encore validé son adresse de courriel!</p>
                    @elseif($enabled)
                        <div class="card mb-2 mt-2 w-50 mx-auto">
                            <div class="card-body">
                                <span class="card-title h5">Infos</span>
                                <form method="POST" class="mt-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <input type="hidden" name="action" value="modify">

                                    <div class="input-group">
                                        <span class="input-group-text input-group-prepend w-25">Statut</span>
                                        <span class="form-control bg-light">{{ $personnel !== null ? 'Personnel' : 'Administrateur' }}</span>
                                    </div>
                                    <div class="input-group">
                                        <label class="input-group-text input-group-prepend w-25" for="nom">Nom</label>
                                        <input type="text" name="nom" value="{{ $user->nom }}"
                                               class="form-control" {{ $input_disabled }}>
                                    </div>
                                    <div class="input-group">
                                        <label class="input-group-text input-group-prepend w-25">Prénom</label>
                                        <input type="text" name="prenom" value="{{ $user->prenom }}"
                                               class="form-control" {{ $input_disabled }}>
                                    </div>
                                    <div class="input-group">
                                        <label class="input-group-text input-group-prepend w-25">E-mail</label>
                                        <input type="email" name="courriel" value="{{ $user->mail }}"
                                               class="form-control" {{ $input_disabled }}>
                                    </div>
                                    {{-- if user is a personnel --}}
                                    @if ($personnel !== null)
                                        <div class="input-group">
                                            <label class="input-group-text input-group-prepend w-25"
                                                   for="ligue">Ligue</label>
                                            <select name="ligue" class="form-control">
                                                @foreach($ligues as $ligue)
                                                    <option
                                                        value="{{ $ligue->id }}" {{ $ligue->id === $ligue_id ? 'selected' : '' }}>{{ $ligue->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <button class="btn btn-primary mt-2" {{ $input_disabled }}><i
                                            class="fas fa-user-edit mr-2"></i>Modifier
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="d-flex flex-row justify-content-center">
                    @if($state === \App\Enums\UserStateEnum::STATE_DISABLED)
                        <form method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <input type="hidden" name="action" value="validate">
                            <button class="ml-2 btn btn-success"><i class="fas fa-check mr-2"></i>Valider!</button>
                        </form>
                    @elseif($enabled)
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
                            <button class="btn btn-danger" {{ $input_disabled }}><i class="fas fa-ban mr-2"></i>Désactiver
                            </button>
                        </form>
                    @endif
                    <form method="POST" class="ml-2">
                        @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <input type="hidden" name="action" value="delete">
                        <button class="btn btn-danger" {{ $input_disabled }}><i class="fas fa-user-slash mr-2"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
