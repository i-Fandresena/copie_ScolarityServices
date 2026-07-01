<div class="default">
    <div class="content">
        <div class="content_header">
            <div class="content_header_right">
                <div>
                    <input type="text" class="shadow border search_input p-2" placeholder="recherche..." wire:model="search">
                </div>
                <div class="btn_search">
                    <select wire:model="niveau" class="shadow w-36 border rounded p-2 bg-white">
                        @if(Auth()->user()->role === 'Licence')
                            <option value="L1">L1</option>
                            <option value="L2">L2</option>
                            <option value="L3">L3</option>
                            <option value="PL">Préselection L1</option>
                        @endif
                        @if(Auth()->user()->role === 'Master')
                            <option selected >M1</option>
                            <option >M2</option>
                            <option value="PM1" >Préselection M1</option>
                            <option value="PM2" >Préselection M2</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <hr>
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
                        @forelse($students as $student)
                            <tr class="shadow" :key="$student->idEtd" style="cursor: pointer">
                                <td class="num">
                                    {{ $student->numInscrit }}
                                </td>
                                <td class="nom">
                                    {{ $student->nom }}
                                </td>
                                <td class="prenoms">
                                    {{ $student->prenom }}
                                </td>
                                <td>
                                    <div class="flex items-center">
                                        <div x-data="{
                                            openStd: false,
                                            openCdtL1: false,
                                            openCdtM1: false,
                                            openCdtM2: false,
                                            candidatL1 : {},
                                            candidatM1 : {},
                                            candidatM2 : {},
                                            student : {},
                                            bordereau : {
                                                montantBrd : '',
                                                dateBrd : '',
                                                agenceBrd : ''
                                            }
                                        }"
                                             @reset-data.window = "(e) => {
                                                openStd = false
                                                openCdtL1 = false
                                                openCdtM1 = false
                                                openCdtM2 = false
                                                candidatL1 = {}
                                                candidatM1 = {}
                                                candidatM2 = {}
                                                student = {}
                                                bordereau = {
                                                    montantBrd: '',
                                                    dateBrd: '',
                                                    agenceBrd: ''
                                                }
                                            }">

                                            @if($niveau === 'PL')
                                                <button x-on:click="(e) => {
                                                    openCdtL1 = !openCdtL1
                                                    candidatL1 = {{$student}}
                                                }" class="px-4 py-2 bg-indigo-500 text-white rounded-md">
                                                    <div class="flex flex-row space-x-1">
                                                        <svg class="mt-1" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M20 13V5.749a.6.6 0 0 0-.176-.425l-3.148-3.148A.6.6 0 0 0 16.252 2H4.6a.6.6 0 0 0-.6.6v18.8a.6.6 0 0 0 .6.6H14"/><path d="M16 2v3.4a.6.6 0 0 0 .6.6H20m-4 13h6m0 0l-3-3m3 3l-3 3"/></g></svg>
                                                        <span>Inscrire</span>
                                                    </div>
                                                </button>
                                            @elseif($niveau === 'PM1')
                                                <button x-on:click="(e) => {
                                                    openCdtM1 = !openCdtM1
                                                    candidatM1 = {{$student}}
                                                }" class="px-4 py-2 bg-indigo-500 text-white rounded-md">
                                                    <div class="flex flex-row space-x-1">
                                                        <svg class="mt-1" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M20 13V5.749a.6.6 0 0 0-.176-.425l-3.148-3.148A.6.6 0 0 0 16.252 2H4.6a.6.6 0 0 0-.6.6v18.8a.6.6 0 0 0 .6.6H14"/><path d="M16 2v3.4a.6.6 0 0 0 .6.6H20m-4 13h6m0 0l-3-3m3 3l-3 3"/></g></svg>
                                                        <span>Inscrire</span>
                                                    </div>
                                                </button>
                                            @elseif($niveau === 'PM2')
                                                <button x-on:click="(e) => {
                                                    openCdtM2 = !openCdtM2
                                                    candidatM2 = {{$student}}
                                                }" class="px-4 py-2 bg-indigo-500 text-white rounded-md">
                                                    <div class="flex flex-row space-x-1">
                                                        <svg class="mt-1" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M20 13V5.749a.6.6 0 0 0-.176-.425l-3.148-3.148A.6.6 0 0 0 16.252 2H4.6a.6.6 0 0 0-.6.6v18.8a.6.6 0 0 0 .6.6H14"/><path d="M16 2v3.4a.6.6 0 0 0 .6.6H20m-4 13h6m0 0l-3-3m3 3l-3 3"/></g></svg>
                                                        <span>Inscrire</span>
                                                    </div>
                                                </button>
                                            @else
                                                <button x-on:click="(e) => {
                                                    openStd = !openStd
                                                    student = {{$student}}
                                                }" class="px-4 py-2 bg-indigo-500 text-white rounded-md">
                                                    <div class="flex flex-row space-x-1">
                                                        <svg class="mt-1" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M20 13V5.749a.6.6 0 0 0-.176-.425l-3.148-3.148A.6.6 0 0 0 16.252 2H4.6a.6.6 0 0 0-.6.6v18.8a.6.6 0 0 0 .6.6H14"/><path d="M16 2v3.4a.6.6 0 0 0 .6.6H20m-4 13h6m0 0l-3-3m3 3l-3 3"/></g></svg>
                                                        <span>Inscrire</span>
                                                    </div>
                                                </button>
                                            @endif
                                            <button wire:click="confirmDelete({{ $student->idEtd }})" class="bg-transparent text-black hover:text-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h4a1 1 0 1 1 0 2h-1.069l-.867 12.142A2 2 0 0 1 17.069 22H6.93a2 2 0 0 1-1.995-1.858L4.07 8H3a1 1 0 0 1 0-2h4V4zm2 2h6V4H9v2zM6.074 8l.857 12H17.07l.857-12H6.074zM10 10a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1z"/></svg>
                                            </button>

                                            <!-- Modal for student -->
                                            <div id="Student" x-show="openStd" x-cloak class="fixed inset-0 px-2 z-10 overflow-hidden flex items-center justify-center">
                                                <div x-show="openStd" x-cloak
                                                     x-transition:enter="transition-opacity ease-out duration-300"
                                                     x-transition:enter-start="opacity-0"
                                                     x-transition:enter-end="opacity-100"
                                                     x-transition:leave="transition-opacity ease-in duration-300"
                                                     x-transition:leave-start="opacity-100"
                                                     x-transition:leave-end="opacity-0"
                                                     class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                                                <!-- Modal Content -->
                                                <div x-show="openStd" x-cloak
                                                     x-transition:enter="transition-transform ease-out duration-300"
                                                     x-transition:enter-start="transform scale-75"
                                                     x-transition:enter-end="transform scale-100"
                                                     x-transition:leave="transition-transform ease-in duration-300"
                                                     x-transition:leave-start="transform scale-100"
                                                     x-transition:leave-end="transform scale-75"
                                                     class="bg-white rounded-md shadow-xl overflow-auto w-full sm:w-96 md:w-1/2 lg:w-2/3 m z-50"
                                                     style="max-height: 98vh;"
                                                     @click.outside="openStd = false">
                                                    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
                                                        <div class="rounded-t bg-white mb-0 px-6 py-6">
                                                            <div class="text-center flex justify-between">
                                                                <h6 class="text-blueGray-700 text-xl font-bold">
                                                                    {{$drNiv . " " . $student->numInscrit}}
                                                                </h6>
                                                                <button x-on:click="openStd = false" class="bg-red-500 text-white active:bg-red-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150" type="button">
                                                                    X
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                                                            <form>
                                                                <h6 class="text-green-500 text-sm mt-3 mb-6 font-bold text-center uppercase">
                                                                    Informations personnelles
                                                                </h6>
                                                                <div class="flex flex-wrap bg-red-700 bg-opacity-5 rounded-2xl pt-2 pb-2">
                                                                    <div class="w-full lg:w-6/12 px-4">
                                                                        <div class="relative w-full mb-3">
                                                                            <label class="block uppercase text-sm text-blueGray-600 font-bold mb-2" htmlfor="grid-password">
                                                                                Nom
                                                                            </label>
                                                                            <input type="text"
                                                                                   x-model="student.nom"
                                                                                   class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 uppercase"
                                                                                   placeholder="Nom">
                                                                            @error('nom') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="w-full lg:w-6/12 px-4">
                                                                        <div class="relative w-full mb-3">
                                                                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                Prenoms
                                                                            </label>
                                                                            <input type="text"
                                                                                   x-model="student.prenom"
                                                                                   class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                   placeholder="Prénoms">
                                                                        </div>
                                                                    </div>
                                                                    <div class="w-full lg:w-6/12 px-4">
                                                                        <div class="relative w-full mb-3">
                                                                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                Date de naissance
                                                                            </label>
                                                                            <input type="date"
                                                                                   x-model="student.dateNaissance"
                                                                                   class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                            @error('dateNaissance') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="w-full lg:w-6/12 px-4">
                                                                        <div class="relative w-full mb-3">
                                                                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                Lieu de naissance
                                                                            </label>
                                                                            <input type="text"
                                                                                   x-model="student.lieuNaissance"
                                                                                   class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                   placeholder="Lieu de naissance">
                                                                        </div>
                                                                    </div>
                                                                    <div class="w-full lg:w-6/12 px-4">
                                                                        <div class="relative w-full mb-3">
                                                                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                Telephone
                                                                            </label>
                                                                            <input type="text"
                                                                                   x-model="student.telCandidat"
                                                                                   class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                   placeholder="Téléphone XXX XX XXX XX">
                                                                        </div>
                                                                    </div>
                                                                    <div class="w-full lg:w-6/12 px-4">
                                                                        <div class="relative w-full mb-3">
                                                                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                CIN
                                                                            </label>
                                                                            <input type="text"
                                                                                   x-model="student.cin"
                                                                                   id="cin"
                                                                                   class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                   placeholder="CIN">
                                                                        </div>
                                                                    </div>
                                                                    <div class="w-full lg:w-6/12 px-4">
                                                                        <div class="relative w-full mb-3">
                                                                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                Nationalite
                                                                            </label>
                                                                            <select x-model="student.nationalite"
                                                                                    class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                <option selected>Malagasy</option>
                                                                                <option>Etranger</option>
                                                                            </select>
                                                                            @error('nationalite') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="w-full lg:w-6/12 px-4">
                                                                        <div class="relative w-full mb-3">
                                                                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                Genre
                                                                            </label>
                                                                            <select x-model="student.genre"
                                                                                class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                <option selected disabled>--Genre--</option>
                                                                                <option value="Masculin">Masculin</option>
                                                                                <option value="Féminin">Féminin</option>
                                                                            </select>
                                                                            @error('genre') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>

                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Email
                                                                                </label>
                                                                                <input type="email"
                                                                                       wire:model.lazy="email"
                                                                                       x-model="student.email"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Email">
                                                                                @error('email') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Situation matrimoniale
                                                                                </label>
                                                                                <select x-model="student.situationMat"
                                                                                    class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option selected disabled>--Situation--</option>
                                                                                    <option>Célibataire</option>
                                                                                    <option>Marié(e)</option>
                                                                                    <option>Divorcé(e)</option>
                                                                                    <option>Veuf(ve)</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Profession
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="student.profession"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Profession">
                                                                                @error('profession') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Statut
                                                                                </label>
                                                                                <select x-model="student.statut"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option>--Statut--</option>
                                                                                    <option value="Fonctionnaire">Fonctionnaire</option>
                                                                                    <option value="Non Fonctionnaire">Non Fonctionnaire</option>
                                                                                </select>
                                                                                @error('statut') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Centre d'examen
                                                                                </label>
                                                                                <select x-model="student.centreExamen"
                                                                                    class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
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
                                                                        </div>
                                                                    @if($niveau == "L3")
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Parcours
                                                                                </label>
                                                                                <select x-model="student.idParcours"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option selected>--Parcours--</option>
                                                                                    <option value="1">Education Générale</option>
                                                                                    <option value="2">Préscolaire</option>
                                                                                </select>
                                                                                @error('centreExamen') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                    @endif

                                                                </div>

                                                                <hr class="mt-6 border-b-1 border-blueGray-300">

                                                                <h6 class="text-green-500 text-sm mt-3 mb-6 font-bold text-center uppercase">
                                                                    DROIT
                                                                </h6>
                                                                <div class="flex flex-wrap bg-red-700 bg-opacity-5 rounded-2xl pt-2 pb-2">
                                                                    <div class="w-full lg:w-6/12 px-4">
                                                                        <div class="relative w-full mb-3">
                                                                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                Référence
                                                                            </label>
                                                                            <input type="text"
                                                                                   wire:model.lazy="referenceBrd1"
                                                                                   class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                   placeholder="Référence">
                                                                            @error('referenceBrd1') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="w-full lg:w-6/12 px-4">
                                                                        <div class="relative w-full mb-3">
                                                                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                Montant
                                                                            </label>
                                                                            <input type="text"
                                                                                   wire:model="montant"
                                                                                   id="inputNumberMontant"
                                                                                   class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                   placeholder="Montant">
                                                                            <input type="checkbox" wire:model="isFull"><span class="text-sm">Droit complet</span>
                                                                            @error('montant') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="w-full lg:w-6/12 px-4">
                                                                        <div class="relative w-full mb-3">
                                                                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                Date
                                                                            </label>
                                                                            <input type="Date"
                                                                                   x-model="bordereau.dateBrd"
                                                                                   class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                            @error('dateBrd1') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="w-full lg:w-6/12 px-4">
                                                                        <div class="relative w-full mb-3">
                                                                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                Banque
                                                                            </label>
                                                                            <select x-model="bordereau.agenceBrd"
                                                                                class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                <option selected>B.O.A</option>
                                                                                <option>B.N.I</option>
                                                                                <option>B.F.V</option>
                                                                            </select>
                                                                            @error('agence') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="text-green-500 text-sm mt-3 mb-6 font-bold text-center uppercase">
                                                                    Observation
                                                                </h6>
                                                                <div class="flex flex-wrap">
                                                                    <div class="w-full lg:w-12/12 px-4">
                                                                        <div class="relative w-full mb-3">
                                                                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                Observation
                                                                            </label>
                                                                            <textarea type="text"
                                                                                      x-model="student.observation"
                                                                                      class="border-2 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded-2xl shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" rows="4"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="btn mb-5">
                                                            <div class="mx-2">
                                                                <button x-on:click="$wire.setDataStudent(student, bordereau)" value="Valider"  class="bg-green-500 text-white hover:bg-green-700 transition ease-in-out duration-500
                         rounded-md shadow-md w-full block px-4 py-2 mt-3">
                                                                    <div class="flex flex-row space-x-0">
                                                                        <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="#fff" d="M20 12a8 8 0 0 1-8 8a8 8 0 0 1-8-8a8 8 0 0 1 8-8c.76 0 1.5.11 2.2.31l1.57-1.57A9.822 9.822 0 0 0 12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10M7.91 10.08L6.5 11.5L11 16L21 6l-1.41-1.42L11 13.17l-3.09-3.09Z"/></svg>
                                                                        <span>Valider</span>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                            <div class="mx-2">
                                                                <button x-on:click="openStd = false"  type="button" value="Annuler" class="bg-red-500 hover:bg-red-700 transition ease-in-out duration-500
                         rounded-md shadow-md w-full px-4 py-2 mt-3 flex flex-row text-black">
                                                                    <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6Zm3.6 5q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z"/></svg>
                                                                    Annuler
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Modal for candidat L1 -->
                                            <div id="candidatL1" x-show="openCdtL1" x-cloak class="fixed inset-0 px-2 z-10 overflow-hidden flex items-center justify-center">
                                                    <div x-show="openCdtL1" x-cloak
                                                         x-transition:enter="transition-opacity ease-out duration-300"
                                                         x-transition:enter-start="opacity-0"
                                                         x-transition:enter-end="opacity-100"
                                                         x-transition:leave="transition-opacity ease-in duration-300"
                                                         x-transition:leave-start="opacity-100"
                                                         x-transition:leave-end="opacity-0"
                                                         class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                                                    <!-- Modal Content -->
                                                    <div x-show="openCdtL1" x-cloak
                                                         x-transition:enter="transition-transform ease-out duration-300"
                                                         x-transition:enter-start="transform scale-75"
                                                         x-transition:enter-end="transform scale-100"
                                                         x-transition:leave="transition-transform ease-in duration-300"
                                                         x-transition:leave-start="transform scale-100"
                                                         x-transition:leave-end="transform scale-75"
                                                         class="bg-white rounded-md shadow-xl overflow-auto w-full sm:w-96 md:w-1/2 lg:w-2/3 m z-50"
                                                         style="max-height: 98vh;">
                                                        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
                                                            <div class="rounded-t bg-white mb-0 px-6 py-6">
                                                                <div class="text-center flex justify-between">
                                                                    <h6 class="text-blueGray-700 text-xl font-bold">
                                                                        {{$drNiv . " " . $student->numInscrit}}
                                                                    </h6>
                                                                    <button x-on:click="openCdtL1 = false" class="bg-red-500 text-white active:bg-red-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150" type="button">
                                                                        X
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                                                                <form>
                                                                    <h6 class="text-green-500 text-sm mt-3 mb-6 font-bold text-center uppercase">
                                                                        Informations personnelles
                                                                    </h6>
                                                                    <div class="flex flex-wrap bg-red-700 bg-opacity-5 rounded-2xl pt-2 pb-2">
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-sm text-blueGray-600 font-bold mb-2" htmlfor="grid-password">
                                                                                    Nom
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatL1.nom"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 uppercase"
                                                                                       placeholder="Nom">
                                                                                @error('nom') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Prenoms
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatL1.prenom"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Prénoms">
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Date de naissance
                                                                                </label>
                                                                                <input type="date"
                                                                                       x-model="candidatL1.dateNaissance"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                @error('dateNaissance') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Lieu de naissance
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatL1.lieuNaissance"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Lieu de naissance">
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Telephone
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatL1.telCandidat"
                                                                                       id="telCandidat"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Téléphone XXX XX XXX XX">
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    CIN
                                                                                </label>
                                                                                <input type="text"
                                                                                       wire:model.lazy="cin"
                                                                                       x-model="candidatL1.cin"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="CIN">
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Nationalite
                                                                                </label>
                                                                                <select x-model="candidatL1.nationalite"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option selected>Malagasy</option>
                                                                                    <option>Etranger</option>
                                                                                </select>
                                                                                @error('nationalite') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Genre
                                                                                </label>
                                                                                <select x-model="candidatL1.genre"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option selected disabled>--Genre--</option>
                                                                                    <option>Masculin</option>
                                                                                    <option>Féminin</option>
                                                                                </select>
                                                                                @error('genre') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                        <hr class="mt-6 border-b-1 border-blueGray-300">


                                                                        <h6 class="text-green-500 text-sm mt-3 mb-6 font-bold text-center uppercase">
                                                                            DIPLOME
                                                                        </h6>

                                                                        <div class="flex flex-wrap bg-red-700 bg-opacity-5 rounded-2xl pt-2 pb-2">
                                                                            <div class="w-full lg:w-4/12 px-4">
                                                                                <div class="relative w-full mb-3">
                                                                                    <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                        Année Bacc
                                                                                    </label>
                                                                                    <input type="number"
                                                                                           x-model="candidatL1.anneeBacc"
                                                                                           class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                           value="Année Bacc">
                                                                                    @error('anneeBacc') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-full lg:w-4/12 px-4">
                                                                                <div class="relative w-full mb-3">
                                                                                    <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                        Serie
                                                                                    </label>
                                                                                    <select x-model="candidatL1.serieBacc"
                                                                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                        <option selected>--Serie--</option>
                                                                                        <option>A1</option>
                                                                                        <option>A2</option>
                                                                                        <option>C</option>
                                                                                        <option>D</option>
                                                                                        <option>S</option>
                                                                                        <option>TECHNIQUE</option>
                                                                                        <option>OSE</option>
                                                                                        <option>L</option>
                                                                                    </select>
                                                                                    @error('serieBacc') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-full lg:w-4/12 px-4">
                                                                                <div class="relative w-full mb-3">
                                                                                    <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                        Mention
                                                                                    </label>
                                                                                    <select x-model="candidatL1.mentionBacc"
                                                                                            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                        <option selected disabled>--Mention--</option>
                                                                                        <option>Passable</option>
                                                                                        <option>Assez Bien</option>
                                                                                        <option>Bien</option>
                                                                                        <option>Très Bien</option>
                                                                                    </select>
                                                                                    @error('mentionBacc') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    <hr class="mt-6 border-b-1 border-blueGray-300">

                                                                    <h6 class="text-green-500 text-sm mt-3 mb-6 font-bold text-center uppercase">
                                                                        DROIT
                                                                    </h6>
                                                                    <div class="flex flex-wrap bg-red-700 bg-opacity-5 rounded-2xl pt-2 pb-2">
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Référence
                                                                                </label>
                                                                                <input type="text"
                                                                                       wire:model.lazy="referenceBrd1"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Référence">
                                                                                @error('referenceBrd1') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Montant
                                                                                </label>
                                                                                <input type="text"
                                                                                       wire:model="montant"
                                                                                       id="inputNumberMontant"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Montant">
                                                                                @error('montant') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Date
                                                                                </label>
                                                                                <input type="Date"
                                                                                       x-model="bordereau.dateBrd"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                @error('dateBrd1') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Banque
                                                                                </label>
                                                                                <select x-model="bordereau.agenceBrd"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option selected>B.O.A</option>
                                                                                    <option>B.N.I</option>
                                                                                    <option>B.F.V</option>
                                                                                </select>
                                                                                @error('agence') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <h6 class="text-green-500 text-sm mt-3 mb-6 font-bold text-center uppercase">
                                                                        Observation
                                                                    </h6>
                                                                    <div class="flex flex-wrap">
                                                                        <div class="w-full lg:w-12/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Observation
                                                                                </label>
                                                                            <textarea type="text"
                                                                                      x-model="candidatL1.observation"
                                                                                      class="border-2 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded-xl shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" rows="4"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="btn mb-5">
                                                                <div class="mx-2">
                                                                    <button x-on:click="$wire.setDataCandidatL1(candidatL1, bordereau)" value="Valider"  class="bg-green-500 text-white hover:bg-green-700 transition ease-in-out duration-500
                         rounded-md shadow-md w-full block px-4 py-2 mt-3">
                                                                        <div class="flex flex-row space-x-0">
                                                                            <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="#fff" d="M20 12a8 8 0 0 1-8 8a8 8 0 0 1-8-8a8 8 0 0 1 8-8c.76 0 1.5.11 2.2.31l1.57-1.57A9.822 9.822 0 0 0 12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10M7.91 10.08L6.5 11.5L11 16L21 6l-1.41-1.42L11 13.17l-3.09-3.09Z"/></svg>
                                                                            <span>Valider</span>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                                <div class="mx-2">
                                                                    <button x-on:click="openCdtL1 = false"  type="button" value="Annuler" class="bg-red-500 hover:bg-red-700 transition ease-in-out duration-500
                         rounded-md shadow-md w-full px-4 py-2 mt-3 flex flex-row text-black">
                                                                        <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6Zm3.6 5q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z"/></svg>
                                                                        Annuler
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            <!-- Modal for candidat M1 -->
                                            <div id="candidatM1" x-show="openCdtM1" x-cloak class="fixed inset-0 px-2 z-10 overflow-hidden flex items-center justify-center">
                                                    <div x-show="openCdtM1" x-cloak
                                                         x-transition:enter="transition-opacity ease-out duration-300"
                                                         x-transition:enter-start="opacity-0"
                                                         x-transition:enter-end="opacity-100"
                                                         x-transition:leave="transition-opacity ease-in duration-300"
                                                         x-transition:leave-start="opacity-100"
                                                         x-transition:leave-end="opacity-0"
                                                         class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                                                    <!-- Modal Content -->
                                                    <div x-show="openCdtM1" x-cloak
                                                         x-transition:enter="transition-transform ease-out duration-300"
                                                         x-transition:enter-start="transform scale-75"
                                                         x-transition:enter-end="transform scale-100"
                                                         x-transition:leave="transition-transform ease-in duration-300"
                                                         x-transition:leave-start="transform scale-100"
                                                         x-transition:leave-end="transform scale-75"
                                                         class="bg-white rounded-md shadow-xl overflow-auto w-full sm:w-96 md:w-1/2 lg:w-2/3 m z-50"
                                                         style="max-height: 98vh;"
                                                         @click.outside="openCdtM1 = false">
                                                        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
                                                            <div class="rounded-t bg-white mb-0 px-6 py-6">
                                                                <div class="text-center flex justify-between">
                                                                    <h6 class="text-blueGray-700 text-xl font-bold">
                                                                        {{$drNiv . " " . $student->numInscrit}}
                                                                    </h6>
                                                                    <button x-on:click="openCdtM1 = false" class="bg-red-500 text-white active:bg-red-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150" type="button">
                                                                        X
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                                                                <form>
                                                                    <h6 class="text-green-500 text-sm mt-3 mb-6 font-bold text-center uppercase">
                                                                        Informations personnelles
                                                                    </h6>
                                                                    <div class="flex flex-wrap bg-red-700 bg-opacity-5 rounded-2xl pt-2 pb-2">
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-sm text-blueGray-600 font-bold mb-2" htmlfor="grid-password">
                                                                                    Nom
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatM1.nom"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 uppercase"
                                                                                       placeholder="Nom">
                                                                                @error('nom') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Prenoms
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatM1.prenom"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Prénoms">
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Date de naissance
                                                                                </label>
                                                                                <input type="date"
                                                                                       x-model="candidatM1.dateNaissance"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                @error('dateNaissance') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Lieu de naissance
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatM1.lieuNaissance"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Lieu de naissance">
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Telephone
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatM1.telCandidat"
                                                                                       id="telCandidat"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Téléphone XXX XX XXX XX">
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    CIN
                                                                                </label>
                                                                                <input type="text"
                                                                                       wire:model.lazy="cin"
                                                                                       x-model="candidatM1.cin"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="CIN">
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Nationalite
                                                                                </label>
                                                                                <select x-model="candidatM1.nationalite"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option selected>Malagasy</option>
                                                                                    <option>Etranger</option>
                                                                                </select>
                                                                                @error('nationalite') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Genre
                                                                                </label>
                                                                                <select x-model="candidatM1.genre"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option selected disabled>--Genre--</option>
                                                                                    <option>Masculin</option>
                                                                                    <option>Féminin</option>
                                                                                </select>
                                                                                @error('genre') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Email
                                                                                </label>
                                                                                <input type="email"
                                                                                       wire:model.lazy="email"
                                                                                       x-model="candidatM1.email"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Email">
                                                                                @error('email') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Situation matrimoniale
                                                                                </label>
                                                                                <select x-model="candidatM1.situationMat"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option selected disabled>--Situation--</option>
                                                                                    <option>Célibataire</option>
                                                                                    <option>Marié(e)</option>
                                                                                    <option>Divorcé(e)</option>
                                                                                    <option>Veuf(ve)</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Profession
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatM1.profession"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Profession">
                                                                                @error('profession') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Statut
                                                                                </label>
                                                                                <select x-model="CandidatM1.statut"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option>--Statut--</option>
                                                                                    <option value="Fonctionnaire">Fonctionnaire</option>
                                                                                    <option value="Non Fonctionnaire">Non Fonctionnaire</option>
                                                                                </select>
                                                                                @error('statut') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Centre d'examen
                                                                                </label>
                                                                                <select x-model="candidatM1.centreExamen"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
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
                                                                        </div>
                                                                    </div>

                                                                    <hr class="mt-6 border-b-1 border-blueGray-300">


                                                                    <h6 class="text-green-500 text-sm mt-3 mb-6 font-bold text-center uppercase">
                                                                        DIPLOME
                                                                    </h6>

                                                                    <div class="flex flex-wrap bg-red-700 bg-opacity-5 rounded-2xl pt-2 pb-2">
                                                                                <div class="w-full lg:w-4/12 px-4">
                                                                                    <div class="relative w-full mb-3">
                                                                                        <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                            Etablissement d'origine
                                                                                        </label>
                                                                                        <input type="text"
                                                                                               x-model="candidatM1.etablissement"
                                                                                               class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                               placeholder="Etablissement d'origine">
                                                                                        @error('etablissement') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="w-full lg:w-4/12 px-4">
                                                                                    <div class="relative w-full mb-3">
                                                                                        <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                            Diplôme licence
                                                                                        </label>
                                                                                        <input type="text"
                                                                                               x-model="candidatM1.parcours"
                                                                                               class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                               placeholder="Diplôme">
                                                                                        @error('parcours') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="w-full lg:w-4/12 px-4">
                                                                                    <div class="relative w-full mb-3">
                                                                                        <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                            Université
                                                                                        </label>
                                                                                        <input type="text"
                                                                                               x-model="candidatM1.universite"
                                                                                               class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                               placeholder="Université">
                                                                                        @error('universite') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                    <hr class="mt-6 border-b-1 border-blueGray-300">

                                                                    <h6 class="text-green-500 text-sm mt-3 mb-6 font-bold text-center uppercase">
                                                                        DROIT
                                                                    </h6>
                                                                    <div class="flex flex-wrap bg-red-700 bg-opacity-5 rounded-2xl pt-2 pb-2">
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Référence
                                                                                </label>
                                                                                <input type="text"
                                                                                       wire:model.lazy="referenceBrd1"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Référence">
                                                                                @error('referenceBrd1') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Montant
                                                                                </label>
                                                                                <input type="text"
                                                                                       wire:model="montant"
                                                                                       id="inputNumberMontant"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Montant">
                                                                                @error('montant') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Date
                                                                                </label>
                                                                                <input type="Date"
                                                                                       x-model="bordereau.dateBrd"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                @error('dateBrd1') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Banque
                                                                                </label>
                                                                                <select x-model="bordereau.agenceBrd"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option selected>B.O.A</option>
                                                                                    <option>B.N.I</option>
                                                                                    <option>B.F.V</option>
                                                                                </select>
                                                                                @error('agence') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <h6 class="text-green-500 text-sm mt-3 mb-6 font-bold text-center uppercase">
                                                                        Observation
                                                                    </h6>
                                                                    <div class="flex flex-wrap">
                                                                        <div class="w-full lg:w-12/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Observation
                                                                                </label>
                                                                                <textarea type="text"
                                                                                          x-model="candidatM1.observation"
                                                                                      class="border-2 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded-xl shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" rows="4"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="btn mb-5">
                                                                <div class="mx-2">
                                                                    <button x-on:click="$wire.setDataCandidatM(candidatM1, bordereau)" value="Valider"  class="bg-green-500 text-white hover:bg-green-700 transition ease-in-out duration-500
                         rounded-md shadow-md w-full block px-4 py-2 mt-3">
                                                                        <div class="flex flex-row space-x-0">
                                                                            <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="#fff" d="M20 12a8 8 0 0 1-8 8a8 8 0 0 1-8-8a8 8 0 0 1 8-8c.76 0 1.5.11 2.2.31l1.57-1.57A9.822 9.822 0 0 0 12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10M7.91 10.08L6.5 11.5L11 16L21 6l-1.41-1.42L11 13.17l-3.09-3.09Z"/></svg>
                                                                            <span>Valider</span>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                                <div class="mx-2">
                                                                    <button x-on:click="openCdtM1 = false"  type="button" value="Annuler" class="bg-red-500 hover:bg-red-700 transition ease-in-out duration-500
                         rounded-md shadow-md w-full px-4 py-2 mt-3 flex flex-row text-black">
                                                                        <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6Zm3.6 5q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z"/></svg>
                                                                        Annuler
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            <!-- Modal for candidat M2 -->
                                            <div id="candidatM2" x-show="openCdtM2" x-cloak class="fixed inset-0 px-2 z-10 overflow-hidden flex items-center justify-center">
                                                    <div x-show="openCdtM2" x-cloak
                                                         x-transition:enter="transition-opacity ease-out duration-300"
                                                         x-transition:enter-start="opacity-0"
                                                         x-transition:enter-end="opacity-100"
                                                         x-transition:leave="transition-opacity ease-in duration-300"
                                                         x-transition:leave-start="opacity-100"
                                                         x-transition:leave-end="opacity-0"
                                                         class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                                                    <!-- Modal Content -->
                                                    <div x-show="openCdtM2" x-cloak
                                                         x-transition:enter="transition-transform ease-out duration-300"
                                                         x-transition:enter-start="transform scale-75"
                                                         x-transition:enter-end="transform scale-100"
                                                         x-transition:leave="transition-transform ease-in duration-300"
                                                         x-transition:leave-start="transform scale-100"
                                                         x-transition:leave-end="transform scale-75"
                                                         class="bg-white rounded-md shadow-xl overflow-auto w-full sm:w-96 md:w-1/2 lg:w-2/3 m z-50"
                                                         style="max-height: 98vh;"
                                                         @click.outside="openCdtM2 = false">
                                                        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
                                                            <div class="rounded-t bg-white mb-0 px-6 py-6">
                                                                <div class="text-center flex justify-between">
                                                                    <h6 class="text-blueGray-700 text-xl font-bold">
                                                                        {{$drNiv . " " . $student->numInscrit}}
                                                                    </h6>
                                                                    <button x-on:click="openCdtM2 = false" class="bg-red-500 text-white active:bg-red-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150" type="button">
                                                                        X
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                                                                <form>
                                                                    <h6 class="text-green-500 text-sm mt-3 mb-6 font-bold text-center uppercase">
                                                                        Informations personnelles
                                                                    </h6>
                                                                    <div class="flex flex-wrap bg-red-700 bg-opacity-5 rounded-2xl pt-2 pb-2">
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-sm text-blueGray-600 font-bold mb-2" htmlfor="grid-password">
                                                                                    Nom
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatM2.nom"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150 uppercase"
                                                                                       placeholder="Nom">
                                                                                @error('nom') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Prenoms
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatM2.prenom"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Prénoms">
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Date de naissance
                                                                                </label>
                                                                                <input type="date"
                                                                                       x-model="candidatM2.dateNaissance"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                @error('dateNaissance') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Lieu de naissance
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatM2.lieuNaissance"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Lieu de naissance">
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Telephone
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatM2.telCandidat"
                                                                                       id="telCandidat"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Téléphone XXX XX XXX XX">
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    CIN
                                                                                </label>
                                                                                <input type="text"
                                                                                       wire:model.lazy="cin"
                                                                                       x-model="candidatM2.cin"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="CIN">
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Nationalite
                                                                                </label>
                                                                                <select x-model="candidatM2.nationalite"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option selected>Malagasy</option>
                                                                                    <option>Etranger</option>
                                                                                </select>
                                                                                @error('nationalite') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Genre
                                                                                </label>
                                                                                <select x-model="candidatM2.genre"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option selected disabled>--Genre--</option>
                                                                                    <option>Masculin</option>
                                                                                    <option>Féminin</option>
                                                                                </select>
                                                                                @error('genre') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Email
                                                                                </label>
                                                                                <input type="email"
                                                                                       wire:model.lazy="email"
                                                                                       x-model="candidatM2.email"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Email">
                                                                                @error('email') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Situation matrimoniale
                                                                                </label>
                                                                                <select x-model="candidatM2.situationMat"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option selected disabled>--Situation--</option>
                                                                                    <option>Célibataire</option>
                                                                                    <option>Marié(e)</option>
                                                                                    <option>Divorcé(e)</option>
                                                                                    <option>Veuf(ve)</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Profession
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatM2.profession"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Profession">
                                                                                @error('profession') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Statut
                                                                                </label>
                                                                                <select x-model="candidatM2.statut"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option>--Statut--</option>
                                                                                    <option value="Fonctionnaire">Fonctionnaire</option>
                                                                                    <option value="Non Fonctionnaire">Non Fonctionnaire</option>
                                                                                </select>
                                                                                @error('statut') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Centre d'examen
                                                                                </label>
                                                                                <select x-model="candidatM2.centreExamen"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
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
                                                                        </div>
                                                                    </div>

                                                                    <hr class="mt-6 border-b-1 border-blueGray-300">


                                                                    <h6 class="text-green-500 text-sm mt-3 mb-6 font-bold text-center uppercase">
                                                                        DIPLOME
                                                                    </h6>

                                                                    <div class="flex flex-wrap bg-red-700 bg-opacity-5 rounded-2xl pt-2 pb-2">
                                                                        <div class="w-full lg:w-4/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Etablissement d'origine
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatM2.etablissement"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Etablissement d'origine">
                                                                                @error('etablissement') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-4/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Diplôme Master One
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatM2.parcours"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Diplôme">
                                                                                @error('parcours') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-4/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Université
                                                                                </label>
                                                                                <input type="text"
                                                                                       x-model="candidatM2.universite"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Université">
                                                                                @error('universite') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <hr class="mt-6 border-b-1 border-blueGray-300">

                                                                    <h6 class="text-green-500 text-sm mt-3 mb-6 font-bold text-center uppercase">
                                                                        DROIT
                                                                    </h6>
                                                                    <div class="flex flex-wrap bg-red-700 bg-opacity-5 rounded-2xl pt-2 pb-2">
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Référence
                                                                                </label>
                                                                                <input type="text"
                                                                                       wire:model.lazy="referenceBrd1"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Référence">
                                                                                @error('referenceBrd1') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Montant
                                                                                </label>
                                                                                <input type="text"
                                                                                       wire:model="montant"
                                                                                       id="inputNumberMontant"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                                                                       placeholder="Montant">
                                                                                @error('montant') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Date
                                                                                </label>
                                                                                <input type="Date"
                                                                                       x-model="bordereau.dateBrd"
                                                                                       class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                @error('dateBrd1') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="w-full lg:w-6/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Banque
                                                                                </label>
                                                                                <select x-model="bordereau.agenceBrd"
                                                                                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                                                                                    <option selected>B.O.A</option>
                                                                                    <option>B.N.I</option>
                                                                                    <option>B.F.V</option>
                                                                                </select>
                                                                                @error('agence') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <h6 class="text-green-500 text-sm mt-3 mb-6 font-bold text-center uppercase">
                                                                        Observation
                                                                    </h6>
                                                                    <div class="flex flex-wrap">
                                                                        <div class="w-full lg:w-12/12 px-4">
                                                                            <div class="relative w-full mb-3">
                                                                                <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" htmlfor="grid-password">
                                                                                    Observation
                                                                                </label>
                                                                                <textarea type="text"
                                                                                      x-model="candidatM2.observation"
                                                                                      class="border-2 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded-xl shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" rows="4"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="btn mb-5">
                                                                <div class="mx-2">
                                                                    <button x-on:click="$wire.setDataCandidatM(candidatM2, bordereau)" value="Valider"  class="bg-green-500 text-white hover:bg-green-700 transition ease-in-out duration-500
                         rounded-md shadow-md w-full block px-4 py-2 mt-3">
                                                                        <div class="flex flex-row space-x-0">
                                                                            <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="#fff" d="M20 12a8 8 0 0 1-8 8a8 8 0 0 1-8-8a8 8 0 0 1 8-8c.76 0 1.5.11 2.2.31l1.57-1.57A9.822 9.822 0 0 0 12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10M7.91 10.08L6.5 11.5L11 16L21 6l-1.41-1.42L11 13.17l-3.09-3.09Z"/></svg>
                                                                            <span>Valider</span>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                                <div class="mx-2">
                                                                    <button x-on:click="openCdtM2 = false"  type="button" value="Annuler" class="bg-red-500 hover:bg-red-700 transition ease-in-out duration-500
                         rounded-md shadow-md w-full px-4 py-2 mt-3 flex flex-row text-black">
                                                                        <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6Zm3.6 5q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z"/></svg>
                                                                        Annuler
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr class="text-center">
                                <td colspan="4" >Aucune données pour l'instant !</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    @if($students->count() > 0)
                        <div class="absolute w-[76%] bottom-2">
                            {{ $students->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
    <div wire:loading class="fixed bottom-0 right-0 w-1/7 p-5 -mt-14">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
    </div>
</div>

