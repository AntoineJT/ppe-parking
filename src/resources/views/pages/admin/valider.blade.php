<ul>
    @foreach(\App\Models\Personnel::where('statut', \App\Enums\UserStateEnum::STATE_DISABLED)->get() as $personnel)
        @php($user = $personnel->getUser())
        <li>
            <form>
                @csrf
                {{ $user->nom }} {{ $user->prenom }}
                <input type="hidden" name="id" value="{{ $user->id }}">
                <button class="ml-2 btn btn-success"><i class="fas fa-check mr-2"></i>Valider!</button>
            </form>
        </li>
    @endforeach
</ul>
