<ul>
    @foreach(\App\Models\PersonnelModel::where('statut', \App\Enums\UserStateEnum::STATE_DISABLED)->get() as $personnel)
        @php($user = $personnel->getUser())
        <li>{{ $user->nom }} {{ $user->prenom }}</li>
    @endforeach
</ul>
