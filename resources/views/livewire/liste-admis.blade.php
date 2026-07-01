<div class="default">
    <!--Contenu-->

    <div class="content"  x-data="{open: false, showForm: false, candidat: {}, dataRegister: {centreExamen: '', email: '', parcours: '1',mention: 'Mathematique', profession: '', statut: '', montantBrd1: '', dateBrd1: '', situationMat: 'Célibataire', observation: '', agenceBrd1: 'B.O.A'}}" @end-submit.window="(e) => {
        showForm = false;
    }"
    @reset-data.window = "(e) => {
    dataRegister.centreExamen = ''
    dataRegister.email = ''
    dataRegister.situationMat = ''
    dataRegister.profession = ''
    dataRegister.statut = ''
    dataRegister.montantBrd1 = ''
    dataRegister.dateBrd1 = '{{ date('Y-m-d') }}'
    dataRegister.observation = ''
    dataRegister.mention = 'Mathematique'
    }">

        <!--Header_Content-->

        <header class="content_header">
            <div class="content_header_right">
                <div><input type="text" class="search_input p-2" placeholder="recherche..." wire:model="search"></div>
                <div class="btn_search">
                    <select wire:model="selectedLevel" class="shadow border rounded w-16 p-2 bg-white" @change="showForm = false">
                        @if(Auth()->user()->role === 'Licence')
                            <option value="L1">L1</option>
                            <option value="L2">L2</option>
                            <option value="L3">L3</option>
                        @endif
                        @if(Auth()->user()->role === 'Master')
                            <option >M1</option>
                            <option >M2</option>
                            <option value="M2R" >Master Recheche</option>
                        @endif
                    </select>
                    <select wire:model="case" class="shadow border rounded p-2 bg-white" @change="showForm = false">
                        <option value="P">Passant</option>
                        <option value="R">Redoublant</option>
                    </select>
                </div>
            </div>
            <div class="content_header_left">

            </div>
        </header>

        <hr width="100%">

        <!--End Header_Content-->

        <!--Start Table Content-->

        <div class="view_content">
            <div class="table_view">
                <div class="my_table">
                    <table>
                        <thead>
                        <tr>
                            <th>Numéro</th>
                            <th>Nom</th>
                            <th>Prénoms</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($candidats as $candidat)
                                <tr>
                                    <td class="num">
                                        {{ $candidat->numInscrit }}
                                    </td>
                                    <td class="nom">
                                        {{ $candidat->nom }}
                                    </td>
                                    <td class="prenoms">
                                        {{ $candidat->prenom }}
                                    </td>
                                    <td>
                                        <button x-on:click="showForm = true,  candidat = {{$candidat}}" class="bg-green-500 text-white hover:bg-green-700 shadow-md px-3 py-1 rounded">
                                            <div class="flex flex-row space-x-1">
                                                <svg class="mt-1" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M20 13V5.749a.6.6 0 0 0-.176-.425l-3.148-3.148A.6.6 0 0 0 16.252 2H4.6a.6.6 0 0 0-.6.6v18.8a.6.6 0 0 0 .6.6H14"/><path d="M16 2v3.4a.6.6 0 0 0 .6.6H20m-4 13h6m0 0l-3-3m3 3l-3 3"/></g></svg>
                                                <span>Inscrire</span>
                                            </div>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="4" >Aucune données pour l'instant !</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div wire:loading class="fixed bottom-0 right-0 w-1/7 p-5 -mt-14">
                <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
            </div>

            <div class="info_view">
                <div x-show="showForm" x-cloak>
                    <form class="w-full rounded-lg border shadow-md p-5  mb-5">
                        <h1 x-text="candidat.numInscrit" class="font-semibold text-gray-700 mb-2"></h1>
                        @csrf
                        @if(Auth()->user()->role === "Licence" and $selectedLevel !== "L2" and $selectedLevel !== "L3")
                            <div class="mb-4">
                                <label for="centreExamen" class="block font-semibold text-gray-700 mb-2">Centre d'Examen : </label>
    {{--                            <input id="centreExamen" type="text" name="centreExamen" class="shadow border rounded w-full p-2" x-model="dataRegister.centreExamen" autofocus>--}}
    {{--                            <label for="centreExamen"> Centre d'examen : </label>--}}
                                <select x-model="dataRegister.centreExamen" class="shadow border rounded w-full p-2" autofocus>
                                    <option selected>--Province--</option>
                                    <option>Antananarivo</option>
                                    <option>Antsiranana</option>
                                    <option>Fianarantsoa</option>
                                    <option>Toamasina</option>
                                    <option>Mahajanga</option>
                                    <option>Toliara</option>
                                </select>
                                @error('centreExamen')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block font-semibold text-gray-700 mb-2">Email : </label>
                                <input id="email" type="email" name="email" class="shadow border rounded w-full p-2"
                                       x-model="dataRegister.email" autofocus>
                                @error('email')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="situationMat" class="block font-semibold text-gray-700 mb-2">Situation matrimoniale : </label>
                                <select class="shadow border rounded w-full p-2" x-model="dataRegister.situationMat">
                                    <option>Célibataire</option>
                                    <option>Marié(e)</option>
                                    <option>Divorcé(e)</option>
                                    <option>Veuf(ve)</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="profession" class="block font-semibold text-gray-700 mb-2">Profession : </label>
                                <input id="profession" type="text" name="profession" class="shadow border rounded w-full p-2"
                                       x-model="dataRegister.profession" autofocus>
                                @error('profession')
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <p for="role-select" class="font-semibold text-gray-700">Statut :</p>
                            <div class="flex justify-between items-center">
                                <label for="fonctionnaire">Fonctionnaire
                                    <input x-model="dataRegister.statut" type="radio" value="Fonctionnaire" id="fonctionnaire">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="non-fonctionnaire">Non Fonctionnaire
                                    <input x-model="dataRegister.statut" type="radio" value="Non Fonctionnaire" id="non-fonctionnaire">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            @error('statut')
                                <span class="text-red-400 text-sm block">{{ $message }}</span>
                            @enderror
                            <br>
                        @endif
                        @if($selectedLevel === 'L3')
                            <p for="role-select" class="font-semibold text-gray-700">Parcours :</p>
                            <div class="flex mb-4 justify-between items-center">
                                <label >Education Génerale
                                    <input x-model="dataRegister.parcours" type="radio" value="1">
                                    <span class="checkmark"></span>
                                </label>
                                <label >Education Préscolaire
                                    <input x-model="dataRegister.parcours" type="radio" value="2">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            @error('parcours')
                            <span class="text-red-400 text-sm block">{{ $message }}</span>
                            @enderror
                            <br>
                        @endif
                        @if($selectedLevel === 'M2R')
                            <p for="role-select" class="font-semibold text-gray-700">Mention :</p>
                            <select class="shadow border rounded w-full p-2 mb-4" x-model="dataRegister.mention">
                                <option disabled selected >- Mention -</option>
                                <option>Mathematique</option>
                                <option>Physique-Chimie</option>
                                <option>Science de l'Education</option>
                            </select>
                            @error('mention')
                            <span class="text-red-400 text-sm block">{{ $message }}</span>
                            @enderror
                            <br>
                        @endif
                        <div class="mb-4">
                            <label for="reference" class="block font-semibold text-gray-700 mb-2">Référence Bordereau : </label>
                            <input id="reference" type="text" name="reference" class="shadow border rounded w-full p-2"
                                   wire:model.lazy="referenceBrd1" autofocus>
                            @error('referenceBrd1')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="montantBrd1" class="block font-semibold text-gray-700 mb-2">Montant : </label>
                            <input id="montantBrd1" placeholder="xxx xxx" type="text" name="montantBrd1" class="shadow border rounded w-full p-2"
                                   x-model="dataRegister.montantBrd1" autofocus>
                            @error('montantBrd1')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="dateBrd1" class="block font-semibold text-gray-700 mb-2">Date du bordereau : </label>
                            <input id="dateBrd1" type="date" name="dateBrd1" class="shadow border rounded w-full p-2"
                                   x-model="dataRegister.dateBrd1" autofocus>
                            @error('dateBrd1')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="agence" class="block font-semibold text-gray-700 mb-2">Agence : </label>
                            <select class="shadow border rounded w-full p-2" x-model="dataRegister.agenceBrd1">
                                <option>B.O.A</option>
                                <option>B.N.I</option>
                                <option>B.F.V</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="observationn" class="block font-semibold text-gray-700 mb-2">Observation : </label>
                            <textarea placeholder="Aucune" type="text" x-model="dataRegister.observation" rows="3" class="mt-1 p-2 block w-full rounded-md border-gray-100 shadow-sm bg-gray-100"></textarea>
                        </div>
                        @php
                            $tmp = json_decode($errors, true);
                        @endphp

                        @if($errors->any())
                            <span class="text-red-400 text-sm"> Veuillez verifier les champs vide !</span>
                        @endif
{{--                        <div class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 font-medium">--}}
{{--                            <div>--}}
{{--                                <span--}}
{{--                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">--}}
{{--                                    Verifié--}}
{{--                                </span>--}}
{{--                                <span--}}
{{--                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">--}}
{{--                                    Droit incomplet--}}
{{--                                </span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </form>

                    <div class="flex flex-row justify-center items-center space-x-2">
                        <button x-on:click="$wire.dataRegisterSet(dataRegister, candidat, 'inscrire')" class="bg-green-500 text-white hover:bg-green-700 shadow-md px-3 py-1 rounded">
                            <div class="flex flex-row space-x-0">
                                <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="#fff" d="M20 12a8 8 0 0 1-8 8a8 8 0 0 1-8-8a8 8 0 0 1 8-8c.76 0 1.5.11 2.2.31l1.57-1.57A9.822 9.822 0 0 0 12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10M7.91 10.08L6.5 11.5L11 16L21 6l-1.41-1.42L11 13.17l-3.09-3.09Z"/></svg>
                                <span>Valider</span>
                            </div>
                        </button>
                        <button x-on:click="$wire.dataRegisterSet(dataRegister, candidat, 'notnow')" class="bg-blue-500 text-white hover:bg-blue-700 shadow-md px-3 py-1 rounded">
                            <div class="flex flex-row space-x-0">
                                <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 16 16"><path fill="currentColor" d="M8 15c-3.86 0-7-3.14-7-7s3.14-7 7-7s7 3.14 7 7s-3.14 7-7 7M8 2C4.69 2 2 4.69 2 8s2.69 6 6 6s6-2.69 6-6s-2.69-6-6-6"/><path fill="currentColor" d="M10 10.5c-.09 0-.18-.02-.26-.07l-2.5-1.5A.495.495 0 0 1 7 8.5v-4c0-.28.22-.5.5-.5s.5.22.5.5v3.72l2.26 1.35a.502.502 0 0 1-.26.93"/></svg>
                                <span>Pas maintenant</span>
                            </div>
                        </button>
                        <button x-on:click="showForm = false" class="bg-red-500 text-white hover:bg-red-700 shadow-md px-3 py-1 rounded flex flex-row text-black">
                            <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6Zm3.6 5q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z"/></svg>
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!--End Table Content-->

    </div>

    <!--End Contenu-->
</div>

<script>
    document.getElementById('montantBrd1').addEventListener('input', function(e) {
        let inputValue = e.target.value.replace(/\D/g, ''); // Remove non-digit characters
        e.target.value = formatNumber(inputValue);
    });

    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }


    document.getElementById('email').addEventListener('input', function(e) {
        let inputValue = e.target.value;
        if(inputValue.includes('@gmail.com')){
            return;
        }

        // Vérifie si l'utilisateur a tapé "@g" dans le champ de saisie
        if (inputValue.includes('@g')) {
            if(inputValue.includes('@gmail.com')){
                return;
            }
            // Vérifie si l'adresse e-mail se termine déjà par "@gmail.com"
            if (!inputValue.endsWith('@gmail.com')) {
                // Ajoute automatiquement "@gmail.com" à la fin de l'adresse e-mail
                e.target.value = inputValue + 'mail.com';
            }
        }

        // Vérifie si l'utilisateur a tapé "@y" dans le champ de saisie
        if (inputValue.includes('@y')) {
            if(inputValue.includes('@yahoo.com')){
                return;
            }
            // Vérifie si l'adresse e-mail se termine déjà par "@gmail.com"
            if (!inputValue.endsWith('@yahoo')) {
                // Ajoute automatiquement "@gmail.com" à la fin de l'adresse e-mail
                e.target.value = inputValue + 'ahoo.com';
            }
        }
    });

</script>
