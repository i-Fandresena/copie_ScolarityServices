<div class="mat relative mt-5">
    <div class="flex flex-row" x-data="{ showYear: false}">
        <select wire:model="searchField" class="shadow border rounded p-2 bg-white">
            <option value="ue">Unité d'enseignement</option>
            <option value="ec">matiere</option>
        </select>
        <input type="text" placeholder="Recherche..." class="shadow border rounded p-2 w-1/2" wire:model="search">
        <select wire:model="niveau" class="shadow border rounded p-2">
            @if(Auth()->user()->role === 'Licence')
                <option value="L1">L1</option>
                <option value="L2">L2</option>
                <option value="L3">L3</option>
            @endif
            @if(Auth()->user()->role === 'Master')
                <option >M1</option>
                <option >M2</option>
                <option >M2-R</option>
            @endif
        </select>
        <div class="ml-5 mr-3 mt-2">
            <input type="checkbox" wire:model="archive" x-model="showYear">
            <span class="checkmark"> Archives </span>
        </div>
        <div x-show="showYear" x-cloak>
            <div class="flex flex-col space-y-0">
{{--                <input wire:model.defer="year" wire:keydown.enter="setYear" placeholder="année" class="shadow border rounded p-2 w-1/2">--}}
                <select wire:model.defer="year" wire:keydown.enter="setYear" class="shadow w-18 border rounded p-2 bg-white">
                    <option selected  value=""> xxxx </option>
                    @foreach($annees as $annee)
                        <option value="{{ $annee->anneeUnivers }}">{{ $annee->anneeUnivers }}</option>
                    @endforeach
                </select>
                @error('year') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <div class="overflow-auto t-fix p-5">
        <table class="table shadow mr-10 w-full">
            <thead>
            <tr>
                <th>UE</th>
                <th>Credit</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($ue as $u)
                    <tr>
                        <td>{{ $u[0]->designation }}</td>
                        <td>{{ $u[0]->credit }}</td>
                        <td class="flex space-x-2">
                            <button wire:click="showMat({{ $u[0] }})" class="bg-yellow-500 text-white hover:bg-yellow-700 shadow-md px-3 py-1 rounded">Voir</button>
                            <button wire:click="editUE({{ $u[0] }})" class="bg-green-500 text-white hover:bg-green-700 shadow-md px-3 py-1 rounded">Modifier</button>
                            <button wire:click="deleteUE({{ $u[0] }})" class="bg-red-500 text-white hover:bg-red-700 shadow-md px-3 py-1 rounded">Supprimer</button>
                        </td>
                    </tr>

                    @if ($idEditUE === $u[0]->idUE)
                        <tr>
                            <td colspan="3">
                                <div class="flex flex-col items-center justify-center space-y-2 w-full">
                                    <div class="flex flex-col space-y-2 w-1/2">
                                        <h1 class="font-semibold">Désignation</h1>
                                        <textarea class="shadow border rounded p-2 w-full" type="text" name="designation" wire:model="tmp_design"></textarea>
                                        @error('tmp_design') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex flex-col space-y-2 w-1/2">
                                        <h1 class="font-semibold">Poids</h1>
                                        <input class="shadow border rounded p-2 w-full" type="text" wire:model="tmp_poidUE">
                                        @error('tmp_poidUE') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <input wire:click="submitUE_edit({{ $u[0]->idUE }})" type="submit" value="Modifier" class="bg-green-500 text-white hover:bg-green-700 transition ease-in-out duration-500
                                        rounded-md shadow-md block px-4 py-2 mt-3">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif


                    @if($idShow ===  $u[0]->idUE)

                        <tr>
                            <td colspan="3">


                                <div class="flex flex-col items-center justify-center">
                                    <table class="shadow">
                                        <thead>
                                            <tr class="p-2" style="border-bottom: 2px solid #707070">
                                                <th>Matiere</th>
                                                <th>Poids</th>
                                                <th>Parcours</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($u[0]->element as $e)
                                            <tr class="p-2" style="border-bottom: 2px solid #707070">
                                                <td> {{$e->matiere}} </td>
                                                <td> {{$e->poids}} </td>
                                                <td> {{ $e->parcours }}</td>
                                                <td>
                                                    <button wire:click="editMat({{ $e }})" class="bg-green-500 text-white hover:bg-green-700 shadow-md px-3 py-1 rounded">Modifier</button>
                                                    <button wire:click="deleteMat({{ $e->idMatiere }})" class="bg-red-500 text-white hover:bg-red-700 shadow-md px-3 py-1 rounded">Supprimer</button>
                                                </td>
                                            </tr>

                                            @if ($idEditMat === $e->idMatiere)
                                            <tr>
                                                <td colspan="3" class="flex items-center justify-center w-full">
                                                    <div class="flex flex-col space-y-2 items-center justify-center w-full border rounded shadow space-x-5 mx-auto p-4">
                                                        <h1 class="text-xl">MODIFIER MATIERE</h1>
                                                        <div class="flex flex-col space-y-2 w-full">
                                                            <h1>Matière</h1>
                                                            <div class="flex flex-col space-y-0 w-full">
                                                                <textarea wire:model="tmp_mat" class="shadow border rounded p-2" type="text" placeholder="Matière"></textarea>
                                                                @error('tmp_mat') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                            </div>
                                                            <h1>Poids</h1>
                                                            <div class="flex flex-col space-y-0 w-full">
                                                                <input wire:model="tmp_poidMat" class="shadow border rounded p-2" type="text" placeholder="Poids">
                                                                @error('tmp_poidMat') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                            </div>
                                                            <h1>Enseignant</h1>
                                                            <div class="flex flex-col space-y-0 w-full">
                                                                <input wire:model="tmp_enseignant" class="shadow border rounded p-2" type="text" placeholder="Enseignant">
                                                                @error('tmp_enseignant') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                                                            </div>
                                                            <div class="flex flex-col space-y-2">
                                                                <select class="shadow border rounded p-2 bg-white" wire:model="tmp_parcours">
                                                                    <option>Tronc commun</option>
                                                                    <option>Générale</option>
                                                                    <option>Préscolaire</option>
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <input wire:click="submitMat_edit({{ $e->idMatiere }})" type="submit" value="Modifier" class="bg-green-500 text-white hover:bg-green-700 transition ease-in-out duration-500
                                                            rounded-md shadow-md block px-4 py-2 mt-3">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif

                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div>

                                    <div x-on:click="showNewM = !showNewM" class="nouveau">
                                        <button class="bg-green-500 text-white hover:bg-green-700 shadow-md px-3 py-1 rounded">Nouveau +</button>
                                    </div>

                                </div>
                                <div x-show="showNewM" x-cloak @click.outside="showNewM = false" class="flex flex-col space-y-2 items-center justify-center w-1/2 border rounded shadow space-x-5 mx-auto p-4">
                                    <h1 class="text-xl">AJOUTER MATIERE</h1>
                                    <div class="flex flex-col space-y-2 w-full">
                                        <h1>Matière</h1>
                                        <div class="flex flex-col space-y-0 w-full">
                                            <textarea wire:model="newMt" class="shadow border rounded p-2" type="text" placeholder="Matière"></textarea>
                                            @error('newMt') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <h1>Poids</h1>
                                        <div class="flex flex-col space-y-0 w-full">
                                            <input wire:model="newMat_poid" class="shadow border rounded p-2" type="text" placeholder="Poids">
                                            @error('newMat_poid') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <h1>Enseignant</h1>
                                        <div class="flex flex-col space-y-0 w-full">
                                            <input wire:model="newMat_prof" class="shadow border rounded p-2" type="text" placeholder="Enseignant">
                                        </div>
                                        <div class="flex flex-row justify-center space-x-5 mt-5">
                                            <button type="button" x-on:click="showNewM = !showNewM" class="w-1/4 bg-red-500 text-white hover:bg-red-700 shadow-md px-3 py-1 rounded">Annuler</button>
                                            <button type="button" wire:click="addMat('{{$u[0]}}')" class="w-1/4 bg-green-500 text-white hover:bg-green-700 shadow-md px-3 py-1 rounded">Ajouter</button>
                                        </div>
                                    </div>
                                </div>


                            </td>
                        </tr>

                    @endif

                @endforeach

            </tbody>
        </table>
    </div>

        <div>
            <button type="button" class="gm-open-modal bg-green-500 text-white hover:bg-green-700 shadow-md px-3 py-1 rounded" data-open="gm-modal1">
                Nouveau +
            </button>
        </div>
        <div wire:loading class="fixed bottom-0 right-0 w-1/7 p-5 -mt-14">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
        </div>

    <div wire:ignore>
        <div class="gm-modal" id="gm-modal1" data-animation="slideInOutLeft">
            <div class="gm-modal-dialog">
                <header class="gm-modal-header">
                    AJOUTER UNITE D'ENSEIGNEMENT
                    <button class="gm-close-modal text-red-600" aria-label="close modal" data-close>
                        ✕
                    </button>
                </header>
                <section class="gm-modal-content">
                    <div>
                        <h1>Unité d'enseignement</h1>
                        <textarea wire:model="newUE" class="shadow border rounded p-2 w-full" type="text" placeholder="Unite d'enseignement"></textarea>
                        @error('newUE') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col space-y-0 mt-2">
                        <h1>Crédit</h1>
                        <input wire:model="newUE_credit" class="shadow border rounded p-2" type="text" placeholder="Crédit">
                        @error('newUE_credit') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col space-y-0 mt-2">
                        <h1>Session</h1>
                        <input wire:model="newUE_session" class="shadow border rounded p-2" type="text" placeholder="Session">
                        @error('newUE_session') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <h1 class="mt-2">Niveau</h1>
                    <select wire:model="newUE_niv" class="shadow border rounded p-2 bg-white w-1/2">
                        @if(Auth()->user()->role === 'Licence')
                            <option value="L1">L1</option>
                            <option value="L2">L2</option>
                            <option value="L3">L3</option>
                        @endif
                        @if(Auth()->user()->role === 'Master')
                            <option >M1</option>
                            <option >M2</option>
                            <option >M2-R</option>
                        @endif
                    </select>
                </section>
                <footer class="gm-modal-footer flex flex-row justify-end">
                    <button wire:click="addUE" class="bg-green-500 text-white hover:bg-green-700 shadow-md px-3 py-1 rounded">Ajouter</button>
                </footer>
            </div>
        </div>
    </div>


</div>

<script>
    const openEls = document.querySelectorAll("[data-open]");
    const closeEls = document.querySelectorAll("[data-close]");
    const isVisible = "is-visible";

    for (const el of openEls) {
        el.addEventListener("click", function() {
            const modalId = this.dataset.open;
            document.getElementById(modalId).classList.add(isVisible);
        });
    }

    for (const el of closeEls) {
        el.addEventListener("click", function() {
            this.parentElement.parentElement.parentElement.classList.remove(isVisible);
        });
    }

    document.addEventListener("click", e => {
        if (e.target == document.querySelector(".gm-modal.is-visible")) {
            document.querySelector(".gm-modal.is-visible").classList.remove(isVisible);
        }
    });

    document.addEventListener("keyup", e => {
        // if we press the ESC
        if (e.key == "Escape" && document.querySelector(".gm-modal.is-visible")) {
            document.querySelector(".gm-modal.is-visible").classList.remove(isVisible);
        }
    });
</script>

