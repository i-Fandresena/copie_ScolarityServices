<div class="default w-full h-full" x-data="Component" @reset-data.window = "(e) => {
    data.nom = ''
    data.prenom = ''
    data.lieuNaissance = ''
    data.telCandidat = ''
    data.dateBrd1 = '{{ date('Y-m-d') }}'
    data.observation = ''
    data.etablissement = ''
    data.parcours = ''
    data.cursus = ''
    data.profession = ''
    data.centreExamen = ''
    data.universite = ''
    data.statut = false
    data.situationMat = 'Célibataire'
    data.montant = '{{$montant}}'
}">
    <div class="content">
        <header class="content_header">
            <div class="content_header_right">
                <div><input class="search_input p-2" type="text" placeholder="recherche..." disabled></div>
                <div class="btn_search">
                    <select wire:model="selectedLevel" class="shadow border rounded w-16 p-2 bg-white">
                        @if(Auth()->user()->role === 'Licence')
                            <option value="L1">L1</option>
                        @endif
                        @if(Auth()->user()->role === 'Master')
                            <option >M1</option>
                            <option >M2</option>
                            <option value="M2-R">M2 Recherche</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="content_header_left w-1/4">
                <label class="block space-x-5 flex-row">
                    <input type="file" wire:model="excelFile" class=" block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:rounded-full file:border-0 file:text-x-sm file:font-semibold file:bg-blue-50 file:text-green-700 hover:file:bg-green-100"/>
                    <button wire:loading.remove wire:target="verifyImport" wire:click="verifyImport">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="#34a853" d="M6 20q-.825 0-1.412-.587Q4 18.825 4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413Q18.825 20 18 20Zm6-4l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11Z"/></svg>
                    </button>
                    <span wire:loading.delay wire:target="verifyImport" class="text-green-400 mt-1.5">Chargement...</span>
                </label>
        </div>
        </header>
        <hr width="100%">

        <div class="overflow-auto m-12">
            <form>
                @csrf
                <div class="grid grid-cols-2 gap-x-16 justify-between" >
                    {{-- content left --}}
                    <div class="information m-1">
                        <fieldset class="border-[1px] border-green-700 grid grid-cols-2 gap-x-10 gap-y-10">
                            <legend>INFORMATION PERSONNELLE</legend>
                            <div class="flex flex-col space-y-0">
                                <label for="nom">Nom :</label>
                                <input class="focus:border-blue-600 focus:shadow-lg" required type="text" id="nom" value="" x-model="data.nom">
                                @error('nom') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex flex-col space-y-0">
                                <label for="prenom">Prénoms :</label>
                                <input class="focus:border-blue-600 focus:shadow-lg" type="text" id="prenom" x-model="data.prenom">
                                @error('prenom') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex flex-col space-y-0">
                                <label for="date">Date de naissance :</label>
                                <input class="focus:border-blue-600 focus:shadow-lg" required type="date" pattern="dd/mm/YYYY" id="date" x-model="data.dateNaissance">
                                @error('dateNaissance') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex flex-col space-y-0">
                                <label for="lieuNaissance">Lieu de naissance :</label>
                                <input class="focus:border-blue-600 focus:shadow-lg" type="text" id="lieuNaissance" x-model="data.lieuNaissance">
                                @error('lieuNaissance') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex flex-col space-y-0">
                                <label for="telCandidat">Téléphone :</label>
                                <input class="focus:border-blue-600 focus:shadow-lg" placeholder="xxx xx xxx xx" type="text" id="telCandidat" x-model="data.telCandidat">
                                @error('telCandidat') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                            </div>


                            <div class="flex flex-col space-y-0">
                                <label for="cin">CIN :</label>
                                <input class="focus:border-blue-600 focus:shadow-lg" placeholder="xxx xxx xxx xxx" type="text" id="cin" wire:model.lazy="cin">
                                @error('cin') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                            </div>

                            @if(Auth()->user()->role === 'Master')
                                <div class="flex flex-col space-y-0">
                                    <label for="cin">Email : </label>
                                    <input class="focus:border-blue-600 focus:shadow-lg" type="email" id="email" wire:model.lazy="email">
                                    @error('email') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex flex-col space-y-0">
                                    <label for="cin">Situation Matrimoniale :</label>
                                    <select  x-model="data.situationMat" class="shadow border rounded p-2 bg-white focus:border-blue-600 focus:shadow-lg">
                                        <option selected disabled>--Situation--</option>
                                        <option>Célibataire</option>
                                        <option>Marié(e)</option>
                                        <option>Divorcé(e)</option>
                                        <option>Veuf(ve)</option>
                                    </select>
                                    @error('situationMat') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                </div>
                            @endif

                            <div class="flex flex-col space-y-0">
                                <label for="nationalite">Nationalité :</label>
                                <select required wire:model="nationalite" class="shadow border rounded p-2 bg-white focus:border-blue-600 focus:shadow-lg">
                                    <option selected>Malagasy</option>
                                    <option>Etranger</option>
                                </select>
                                @error('nationalite') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex flex-col space-y-0">
                                <label for="genre">Genre :</label>
                                <select x-model="data.genre" class="shadow border rounded p-2 bg-white focus:border-blue-600 focus:shadow-lg">
                                    <option selected disabled>--Genre--</option>
                                    <option>Masculin</option>
                                    <option>Féminin</option>
                                </select>
                                @error('genre') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                            </div>

                            @if(Auth()->user()->role === 'Master')
                                <div class="flex flex-col space-y-0">
                                    <label for="profession">Profession : </label>
                                    <input class="focus:border-blue-600 focus:shadow-lg" type="text" x-model="data.profession">
                                    @error('profession') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex flex-col space-y-0">
                                    <label for="statut">Statut : </label>
                                    <div class="flex border-b-2 border-black">
                                        <input class="focus:border-blue-600 focus:shadow-lg" type="checkbox" x-model="data.statut" value="Fonctionnaire"><span>  Fonctionnaire</span>
                                    </div>
                                    @error('statut') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                </div>

                                @if($selectedLevel !== "M2-R")
                                    <div class="flex flex-col space-y-0">
                                        <label for="centreExamen"> Centre d'examen : </label>
                                        <select x-model="data.centreExamen" class="shadow border rounded p-2 bg-white focus:border-blue-600 focus:shadow-lg">
                                            <option selected>--Province--</option>
                                            <option>Antananarivo</option>
                                            <option>Antsiranana</option>
                                            <option>Fianarantsoa</option>
                                            <option>Toamasina</option>
                                            <option>Mahajanga</option>
                                            <option>Toliara</option>
                                        </select>
                                        @error('centreExamen') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                @endif
                            @endif

                            <div class="flex flex-col space-y-0">
                                <label for="anneeUnivers">Anneé Universitaire :</label>
                                <input class="focus:border-blue-600 focus:shadow-lg" placeholder="xxxx" required type="number" x-model="data.anneeUnivers">
                                @error('anneeUnivers') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                            </div>

                        </fieldset>
                    </div>
                    {{-- content left --}}
                    <div class="diplome m-1">
                        <fieldset class="border-[1px] border-green-700 grid grid-cols-2 gap-x-10 gap-y-10">
                            <legend>DIPLOME</legend>
                            {{--****************************Licence****************************--}}
                            @if(Auth()->user()->role === 'Licence')
                                <div class="flex flex-col space-y-0">
                                    <label for="anneeBacc"> Année Baccalauréat :</label>
                                    <input class="focus:border-blue-600 focus:shadow-lg" placeholder="xxxx" required type="number" id="anneeBacc" x-model="data.anneeBacc">
                                    @error('anneeBacc') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex flex-col space-y-0">
                                    <label for="mentionBacc"> Serie Baccalauréat :</label>
                                    <select required x-model="data.serieBacc" class="shadow border rounded p-2 bg-white focus:border-blue-600 focus:shadow-lg">
                                        <option selected disabled>--Serie--</option>
                                        <option>A1</option>
                                        <option selected>A2</option>
                                        <option>C</option>
                                        <option>D</option>
                                        <option>S</option>
                                        <option>TECHNIQUE</option>
                                        <option>OSE</option>
                                        <option>L</option>
                                    </select>
                                    @error('serieBacc') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex flex-col space-y-0">
                                    <label for="mentionBacc"> Mention Baccalauréat :</label>
                                    <select required x-model="data.mentionBacc" class="shadow border rounded p-2 bg-white focus:border-blue-600 focus:shadow-lg">
                                        <option selected disabled>--Mention--</option>
                                        <option>Passable</option>
                                        <option>Assez Bien</option>
                                        <option>Bien</option>
                                        <option>Très Bien</option>
                                    </select>
                                    @error('mentionBacc') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                </div>
                            @endif
                            {{--****************************Master****************************--}}
                            @if(Auth()->user()->role === 'Master')
                                <div class="flex flex-col space-y-0">
                                    <label for="etablissement">Etablissement d'origine :</label>
                                    <input class="focus:border-blue-600 focus:shadow-lg" required type="text" x-model="data.etablissement">
                                    @error('etablissement') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex flex-col space-y-0">
                                    @if($selectedLevel === "M2")
                                        <label for="parcours"> Diplôme MasterOne : </label>
                                    @elseif($selectedLevel === "M2-R")
                                        <label for="parcours"> Diplôme MasterOne : </label>
                                    @else
                                        <label for="parcours"> Diplôme licence : </label>
                                    @endif
                                    <input class="focus:border-blue-600 focus:shadow-lg" required type="text" id="parcours" x-model="data.parcours">
                                    @error('parcours') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex flex-col space-y-0">
                                    <label for="universite"> Université : </label>
                                    <input class="focus:border-blue-600 focus:shadow-lg" required type="text" id="universite" x-model="data.universite">
                                    @error('universite') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                </div>

                                @if($selectedLevel === "M2-R")
                                    <div class="flex flex-col space-y-0">
                                        <label for="cursus"> Cursus : </label>
                                        <input class="focus:border-blue-600 focus:shadow-lg" required type="text" id="cursus" x-model="data.cursus">
                                        @error('cursus') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                @endif

                            @endif
                        </fieldset>
                        <div class="droit m-1">
                            <fieldset class="border-[1px] border-green-700 grid grid-cols-2 gap-x-10 gap-y-10">
                                <legend>DROIT</legend>
                                <div class="flex flex-col space-y-0">
                                    <label for="referenceBrd1">Réference :</label>
                                    <input class="focus:border-blue-600 focus:shadow-lg" required type="text" wire:model.lazy="referenceBrd1">
                                    @error('referenceBrd1') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                </div>


                                <div class="flex flex-col space-y-0">
                                    <label for="montant">Montant ({{ $montant }} Ar) : </label>
                                    <input id="inputNumberMontant" class="focus:border-blue-600 focus:shadow-lg" x-model="data.montant" placeholder="{{ $montant }}"  required type="text">
                                    @error('montant') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                </div>


                                <div class="flex flex-col space-y-0">
                                    <label for="date">Date :</label>
                                    <input class="focus:border-blue-600 focus:shadow-lg" required type="date" pattern="dd/mm/yyyy" x-model="data.dateBrd1">
                                    @error('dateBrd1') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex flex-col space-y-0">
                                    <select x-model="data.agenceBrd1" class="shadow border rounded p-2 bg-white focus:border-blue-600 focus:shadow-lg">
                                        <option selected>B.O.A</option>
                                        <option>B.N.I</option>
                                        <option>B.F.V</option>
                                    </select>
                                    @error('agence') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </fieldset>
                            <div class="mt-6">
                                <label for="observation" class="block text-sm font-medium font-gray-700">Observation</label>
                                <div class="mt-1">
                                    <textarea name="observation" id="observation" rows="3" placeholder="Aucune"
                                              x-model="data.observation"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100
                                              focus:border-blue-600 focus:shadow-lg">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="btn mt-14">
                <div class="mx-2">
                    <button x-on:click="$wire.dataSet(data, 'inscrire')" value="Valider"  class="bg-green-500 text-white hover:bg-green-700 transition ease-in-out duration-500
                         rounded-md shadow-md w-full block px-4 py-2 mt-3">
                        <div class="flex flex-row space-x-0">
                            <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="#fff" d="M20 12a8 8 0 0 1-8 8a8 8 0 0 1-8-8a8 8 0 0 1 8-8c.76 0 1.5.11 2.2.31l1.57-1.57A9.822 9.822 0 0 0 12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10M7.91 10.08L6.5 11.5L11 16L21 6l-1.41-1.42L11 13.17l-3.09-3.09Z"/></svg>
                            <span>Valider</span>
                        </div>
                    </button>
                </div>
                <div class="mx-2">
                    <button x-on:click="$wire.dataSet(data, 'NN')" value="Valider"  class="bg-blue-500 text-white hover:bg-blue-700 transition ease-in-out duration-500
                         rounded-md shadow-md w-full block px-4 py-2 mt-3">
                        <div class="flex flex-row space-x-0">
                            <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 16 16"><path fill="currentColor" d="M8 15c-3.86 0-7-3.14-7-7s3.14-7 7-7s7 3.14 7 7s-3.14 7-7 7M8 2C4.69 2 2 4.69 2 8s2.69 6 6 6s6-2.69 6-6s-2.69-6-6-6"/><path fill="currentColor" d="M10 10.5c-.09 0-.18-.02-.26-.07l-2.5-1.5A.495.495 0 0 1 7 8.5v-4c0-.28.22-.5.5-.5s.5.22.5.5v3.72l2.26 1.35a.502.502 0 0 1-.26.93"/></svg>
                            <span>Pas maintenant</span>
                        </div>
                    </button>
                </div>
                <div class="mx-2">
                    <button x-on:click="$wire.resetData()"  type="button" value="Annuler" class="bg-red-500 hover:bg-red-700 transition ease-in-out duration-500
                         rounded-md shadow-md w-full px-4 py-2 mt-3 flex flex-row text-black">
                        <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6Zm3.6 5q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z"/></svg>
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- loading --}}
    <div wire:loading class="fixed bottom-0 right-0 w-1/7 p-5 -mt-14">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
    </div>
</div>

<script>
    function component() {
        return {
            data: {
                nom: "",
                prenom: "",
                dateNaissance: null,
                lieuNaissance: "",
                telCandidat: "",
                anneeUnivers: new Date().getFullYear(),
                anneeBacc: "",
                dateBrd1: new Date().toISOString().slice(0, 10),
                genre: "Masculin",
                serieBacc: "A2",
                mentionBacc: "Passable",
                agenceBrd1: "B.O.A",
                observation:"",
                //Master
                etablissement:"",
                parcours:"",
                universite:"",
                montant:"{{$montant}}",

                @if (Auth()->user()->role === 'Master')
                    centreExamen: " ",
                    profession: "",
                    statut: false,
                    situationMat: "Célibataire",
                    cursus: ""
                @endif


            }
        };
    }

    // format number for montant
    document.addEventListener("alpine:init", () => {
        Alpine.data('Component', component);
    });

    document.getElementById('inputNumberMontant').addEventListener('input', function(e) {
        let inputValue = e.target.value.replace(/\D/g, ''); // Remove non-digit characters
        e.target.value = formatNumber(inputValue);
    });

    document.getElementById('cin').addEventListener('input', function(e) {
        let inputValue = e.target.value.replace(/\D/g, ''); // Remove non-digit characters
        e.target.value = formatNumber(inputValue);
    });

    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }


    // format number for telCandidat
    document.getElementById('telCandidat').addEventListener('input', function(e) {
        let inputValue = e.target.value.replace(/\D/g, ''); // Remove non-digit characters
        e.target.value = formatPhoneNumber(inputValue);
    });


    function formatPhoneNumber(number) {
        let formattedNumber = '';
        for (let i = 0; i < number.length; i++) {
            if (i === 3 || i === 5 || i === 8 || i === 11) {
                formattedNumber += ' ';
            }
            formattedNumber += number[i];
        }
        return formattedNumber.trim();
    }

</script>
