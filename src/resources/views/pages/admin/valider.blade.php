@foreach(\App\Models\PersonnelModel::where('statut', '=', \App\Enums\UserStateEnum::STATE_DISABLED) as $user)
    {{ $user->nom }}
@endforeach
