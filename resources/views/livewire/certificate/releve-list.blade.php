<div>
    <div class="my_table pr-10 pl-10 pt-5 overflow-auto">
        <table class="w-full">
            <thead>
            <tr>
                <th class="num">Numéro d'ordre</th>
                <th class="nom">Numero d'inscription</th>
                <th class="prenoms">Nom</th>
                <th class="prenoms">Prénoms</th>
                <th class="prenoms">Date de délivrance</th>
                <th class="">Actions</th>
            </tr>
            </thead>
            <tbody>
                @forelse($releves as $releve)
                    <tr class="shadow" style="cursor: pointer">
                        <td class="num">
                            {{ $releve->numReleve }}
                        </td>
                        <td class="nom">
                            {{ $releve->numInscrit }}
                        </td>
                        <td class="prenoms">
                            {{ $releve->nom }}
                        </td>
                        <td class="prenoms">
                            {{ $releve->prenom }}
                        </td>
                        <td class="prenoms">
                            {{ date("d/m/Y", strtotime($releve->dateDelivrance)) }}
                        </td>

                        <td>
                            @if($loop->last)
                                <div class="flex flex-row">
                                    <button wire:click="confirmReleve({{ $releve->id }}, {{ $releve->numReleve}})"
                                            class="text-black hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35px" height="35px" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2c5.53 0 10 4.47 10 10s-4.47 10-10 10S2 17.53 2 12S6.47 2 12 2m5 5h-2.5l-1-1h-3l-1 1H7v2h10V7M9 18h6a1 1 0 0 0 1-1v-7H8v7a1 1 0 0 0 1 1Z"/></svg>
                                    </button>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="6" >Aucune données pour l'instant !</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
