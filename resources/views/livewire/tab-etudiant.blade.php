<div class="default" x-data="{showInfo: false,
     showPay: '',
      dataPay: {agenceBrd2: 'B.O.A', montantBrd2: '', dateBrd2: ''},
       student: {},
        dataShow: {},
         showModal: false,
          studentEdit: {},
          candidatL: {},
          candidatLShow: false,
          candidatM1: {},
          candidatM1Show: false,
          candidatM2: {},
          candidatM2Show: false,
          candidatM2R: {},
          candidatM2RShow: false,
          dataShowStudent: null,
          dataShowBordereau: null,
          load: false,
           showYear: false}" @end-edit.window="(e) => {
            showModal = false;
            candidatLShow = false;
            candidatM1Show = false;
            candidatM2Show = false;
            candidatM2RShow = false;
           }" @end-pay.window="(e) => {
            showPay = '';
           }"
    >
    <!--Contenu-->

    <div class="content">
    <!--Header_Content-->

        <div class="content_header">
            <div class="content_header_right">
                <div>
                    <input type="text" class="shadow border search_input p-2" placeholder="recherche..." wire:model="search" wire:keydown.debounce.1500ms="resetId">
                </div>
                <div class="btn_search">
                    <select wire:model="niveau" wire:change="resetId" class="shadow w-16 border rounded p-2 bg-white">
                        @if(Auth()->user()->role === 'Licence')
                            <option value="L1">L1</option>
                            <option value="L2">L2</option>
                            <option value="L3">L3</option>
                            <option value="PL">Préselection L1</option>
                        @endif
                        @if(Auth()->user()->role === 'Master')
                            <option selected >M1</option>
                            <option >M2</option>
                            <option >MR</option>
                            <option value="PM1" >Préselection M1</option>
                            <option value="PM2" >Préselection M2</option>
                        @endif
                    </select>
                </div>
                <div class="ml-5 mr-3 mt-2">
                    <input type="checkbox" wire:model="archive" x-model="showYear" wire:change="resetId">
                    <span class="checkmark"> Archives </span>
                </div>
                <div x-show="showYear" x-cloak>
                    <div class="flex flex-col space-y-0">
                        <select wire:model.defer="year" wire:change="setYear" class="shadow w-18 border rounded p-2 bg-white">
                            <option selected  value=""> xxxx </option>
                            @foreach($annees as $annee)
                                <option value="{{ $annee->anneeUnivers }}">{{ $annee->anneeUnivers }}</option>
                            @endforeach
                        </select>
                        @error('year') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            @if($niveau != 'PM1' and $niveau != 'PM2' and $niveau != 'PMR')
            <div class="content_header_left w-1/4">
                <label class="block space-x-5 flex flex-row">
                    <input type="file" wire:model="excelFile" class=" block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:rounded-full file:border-0 file:text-x-sm file:font-semibold file:bg-blue-50 file:text-green-700 hover:file:bg-green-100"/>
                    <button wire:loading.remove wire:target="orderType" wire:click="orderType">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="#34a853" d="M6 20q-.825 0-1.412-.587Q4 18.825 4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413Q18.825 20 18 20Zm6-4l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11Z"/></svg>
                    </button>
                    <span wire:loading.delay wire:target="orderType" class="text-green-400 mt-1.5">Chargement...</span>
                </label>
            </div>
            @endif
        </div>

        <hr>

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
                        <tbody @click.outside="showPay = ''">
                            @forelse($students as $student)
                                <tr class="shadow" :key="$student->idEtd" style="cursor: pointer" wire:click="setId('{{ $student->idEtd }}')">
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
                                        @if($niveau !== 'PL' and $niveau !== 'PM1' and $niveau !== 'PM2' and $niveau !== 'PMR')
                                            <button @if($student->RAD <= 0) disabled @endif x-on:click="(e) => {
                                                if (showPay === '{{ $student->idEtd }}') showPay = 0;
                                                else showPay = '{{ $student->idEtd }}';
                                              }, student = {{ $student }}" class="bg-transparent text-black hover:text-yellow-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1.7em" height="1.7em" viewBox="0 0 24 24"><path fill="currentColor" d="M7 4C4.8 4 3 5.8 3 8s1.8 4 4 4s4-1.8 4-4s-1.8-4-4-4m0 6c-1.1 0-2-.9-2-2s.9-2 2-2s2 .9 2 2s-.9 2-2 2m0 4c-3.9 0-7 1.8-7 4v2h11v-2H2c0-.6 1.8-2 5-2c1.8 0 3.2.5 4 1v-2.2c-1.1-.5-2.5-.8-4-.8M22 4h-7c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m-6 14h-1V6h1v12m6 0h-4V6h4v12Z"/></svg>
                                            </button>
                                        @endif
                                        @if($niveau === 'PL')
                                            <button x-on:click="candidatLShow = !candidatLShow, candidatL = {{ $student }}" class="bg-transparent text-black hover:text-green-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1.7em" height="1.7em" viewBox="0 0 24 24"><g fill="none" stroke="#39b159" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3l8.385-8.415zM16 5l3 3"/></g></svg>
                                            </button>
                                        @elseif($niveau === 'PM1')
                                            <button x-on:click="candidatM1Show = !candidatM1Show, candidatM1 = {{ $student }}" class="bg-transparent text-black hover:text-green-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1.7em" height="1.7em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3l8.385-8.415zM16 5l3 3"/></g></svg>
                                            </button>
                                        @elseif($niveau === 'PM2')
                                            <button x-on:click="candidatM2Show = !candidatM2Show, candidatM2 = {{ $student }}" class="bg-transparent text-black hover:text-green-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1.7em" height="1.7em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3l8.385-8.415zM16 5l3 3"/></g></svg>
                                            </button>
                                        @elseif($niveau === 'PMR')
                                            <button x-on:click="candidatM2RShow = !candidatM2RShow, candidatM2R = {{ $student }}" class="bg-transparent text-black hover:text-green-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1.7em" height="1.7em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3l8.385-8.415zM16 5l3 3"/></g></svg>
                                            </button>
                                        @else
                                            <button x-on:click="showModal = !showModal, studentEdit = {{ $student }}" class="bg-transparent text-black hover:text-green-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1.7em" height="1.7em" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M7 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97L9 12v3h3l8.385-8.415zM16 5l3 3"/></g></svg>
                                            </button>
                                        @endif
                                        @if(!$archive)
                                            <button wire:click="confirmDelete({{ $student->idEtd }})" class="bg-transparent text-black hover:text-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h4a1 1 0 1 1 0 2h-1.069l-.867 12.142A2 2 0 0 1 17.069 22H6.93a2 2 0 0 1-1.995-1.858L4.07 8H3a1 1 0 0 1 0-2h4V4zm2 2h6V4H9v2zM6.074 8l.857 12H17.07l.857-12H6.074zM10 10a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1z"/></svg>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                <tr x-show="showPay === '{{ $student->idEtd }}'"  class="bg-emerald-100" x-cloak>
                                    <td colspan="4" style="text-align: center">
                                        <div class="flex flex-row space-x-2 justify-center items-center h-[90px]">
                                            <form action="">
                                                @csrf
                                                <div class="flex flex-row space-x-2 justify-center items-center">
                                                    <div class="flex flex-col space-y-0">
                                                        <input class="rounded p-2" type="text" name="reference" placeholder="Référence" wire:model="referenceBrd2">
                                                    </div>
                                                    <div class="flex flex-col space-y-0">
                                                        <input class="rounded p-2" type="text" name="montant" placeholder="Montant" x-model="dataPay.montantBrd2">

                                                    </div>
                                                    <div class="flex flex-col space-y-0">
                                                        <input class="rounded p-2" type="date" pattern="dd/mm/yyyy" name="date" x-model="dataPay.dateBrd2">

                                                    </div>
                                                    <div class="flex flex-col">
                                                        <select class="rounded p-2.5" x-model="dataPay.agenceBrd2">
                                                            <option>B.O.A</option>
                                                            <option>B.F.V</option>
                                                            <option>B.N.I</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="flex justify-center items-center">
                                                <button x-on:click="$wire.dataPaySet(dataPay, student)" value="Valider" class="bg-green-500 text-white hover:bg-green-700 transition ease-in-out duration-500
                                                                rounded-md shadow-md block px-4 py-2 ml-6">
                                                    <div class="flex flex-row space-x-0">
                                                        <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="#fff" d="M20 12a8 8 0 0 1-8 8a8 8 0 0 1-8-8a8 8 0 0 1 8-8c.76 0 1.5.11 2.2.31l1.57-1.57A9.822 9.822 0 0 0 12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10M7.91 10.08L6.5 11.5L11 16L21 6l-1.41-1.42L11 13.17l-3.09-3.09Z"/></svg>
                                                        <span>Valider</span>
                                                    </div>
                                                </button>
                                                <div class="p-2 flex flex-col items-start">
                                                    <div>@error('referenceBrd2')<span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror</div>
                                                    <div>@error('montantBrd2')<span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror</div>
                                                    <div>@error('dateBrd2')<span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror</div>
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


                    <!--Edit Modal-->

                    <div x-show="showModal" x-cloak x-on:click="showModal = false" class="modal-backdrop absolute top-0 left-0 w-full h-full bg-gray-900 opacity-70"></div>
                    <div x-show="candidatLShow" x-cloak  x-on:click="candidatLShow = false" class="modal-backdrop absolute top-0 left-0 w-full h-full bg-gray-900 opacity-70"></div>
                    <div x-show="candidatM1Show" x-cloak x-on:click="candidatM1Show = false" class="modal-backdrop absolute top-0 left-0 w-full h-full bg-gray-900 opacity-70"></div>
                    <div x-show="candidatM2Show" x-cloak x-on:click="candidatM2Show = false" class="modal-backdrop absolute top-0 left-0 w-full h-full bg-gray-900 opacity-70"></div>
                    <div x-show="candidatM2RShow" x-cloak x-on:click="candidatM2RShow = false" class="modal-backdrop absolute top-0 left-0 w-full h-full bg-gray-900 opacity-70"></div>

                    <div class="edit_modal border-[1px] border-black" x-show="showModal" x-cloak
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 transform"
                    x-transition:enter-end="opacity-100 transform" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform" x-transition:leave-end="opacity-0 transform">
                    {{-----------------------------------edit M1-M2-MR-------------------------------------}}
                        <div class="modal-content mx-auto rounded-lg z-50 overflow-y-auto w-full h-full">
                            <div class="modal-header py-2 px-6 flex flex-row justify-between">
                                <div class="text-2xl font-bold"><span x-text="studentEdit.numInscrit"></span></div>
                                <button @click="showModal = false" class="text-3xl leading-none font-bold text-red-600 hover:text-gray-600 focus:outline-none focus:text-gray-800">×</button>
                            </div>
                            <form>
                                @csrf
                                <div class="modal-body px-8 py-4 w-full grid grid-cols-2 justify-between">
                                    <div>
                                        <ul>
                                            <li>
                                                <span>Nom</span>: <br>
                                                <input class="shadow border h-[42px] rounded p-2 w-full" type="text" x-model="studentEdit.nom"> <br>
                                                @error('nom') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                            </li>
                                            <li>
                                                <span>Prénoms</span>: <br>
                                                <input class="shadow border h-[42px] rounded p-2 w-full" type="text" x-model="studentEdit.prenom">
                                            </li>
                                            <li>
                                                <div class="grid grid-cols-2 gap-x-5">
                                                    <div>
                                                        <span>Date de naissance</span>: <br>
                                                        <input class="shadow border h-[42px] rounded p-2 w-full" type="date" x-model="studentEdit.dateNaissance"> <br>
                                                        @error('dateNaissance') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div>
                                                        <span>Lieu de naissance</span>: <br>
                                                        <input class="shadow border h-[42px] rounded p-2 w-full" type="text" x-model="studentEdit.lieuNaissance">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <span>Téléphone</span>: <br>
                                                <input class="shadow border h-[42px] rounded p-2 w-full" type="text" x-model="studentEdit.telCandidat">
                                            </li>
                                            <li>
                                                <span>CIN</span>: <br>
                                                <input class="shadow border h-[42px] rounded p-2 w-full" type="text" x-model="studentEdit.cin">
                                            </li>
                                            <li>
                                                <span>Nationalité</span>: <br>
                                                <input class="shadow border h-[42px] rounded p-2 w-full" type="text" x-model="studentEdit.nationalite"> <br>
                                                @error('nationalite') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                            </li>
{{--                                            <li>--}}
{{--                                                <span>Année Universitaire</span>: <br>--}}
{{--                                                <input class="shadow border rounded p-2 w-full" type="text" x-model="studentEdit.anneeUnivers"> <br>--}}
{{--                                                @error('anneeUnivers') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror--}}
{{--                                            </li>--}}
                                            <li>
                                                <div class="grid grid-cols-2 gap-x-5">
                                                    <div>
                                                        <span>Genre</span>: <br>
                                                        {{--                                            <input class="shadow border rounded p-2 w-full" type="text" x-model="studentEdit.genre"> <br>--}}
                                                        <select x-model="studentEdit.genre" class="shadow border h-[42px] rounded p-2 w-full bg-white">
                                                            <option selected disabled>-</option>
                                                            <option value="Masculin">Masculin</option>
                                                            <option value="Féminin">Féminin</option>
                                                        </select>
                                                        @error('genre') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                    </div>
                                                    @if($niveau === 'L3')
                                                        <div>
                                                            <span>Genre</span>: <br>
                                                            <select x-model="studentEdit.idParcours " class="shadow border rounded w-full p-2" autofocus>
                                                                <option selected disabled >--Parcours--</option>
                                                                <option value="1">Education Générale</option>
                                                                <option value="2">Education Préscolaire</option>
                                                            </select>
                                                        </div>
                                                    @endif
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <ul>
                                            <li>
                                                @if($niveau != 'MR')
                                                    <span>Centre Examen</span>: <br>
                                                    {{--<input class="shadow border rounded p-2 w-full" type="text" x-model="studentEdit.centreExamen"> <br>--}}
                                                    <select x-model="studentEdit.centreExamen" class="shadow border h-[42px] rounded p-2 w-full bg-white">
                                                        <option selected disabled> - </option>
                                                        <option>Antananarivo</option>
                                                        <option>Antsiranana</option>
                                                        <option>Fianarantsoa</option>
                                                        <option>Toamasina</option>
                                                        <option>Mahajanga</option>
                                                        <option>Toliara</option>
                                                    </select>
                                                    @error('centreExamen') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                @endif
                                            </li>
                                            <li>
                                                <span>Email</span>: <br>
                                                <input class="shadow border h-[42px] rounded p-2 w-full" type="text" x-model="studentEdit.email"> <br>
                                                @error('email') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                            </li>
                                            <li>
                                                <span>Situation matrimoniale</span>: <br>
                                                {{--                                            <input class="shadow border rounded p-2 w-full" type="text" x-model="studentEdit.situationMat">--}}
                                                <select x-model="studentEdit.situationMat" class="shadow border h-[42px] rounded p-2 w-full bg-white">
                                                    <option selected disabled>-</option>
                                                    <option>Célibataire</option>
                                                    <option>Marié(e)</option>
                                                    <option>Divorcé(e)</option>
                                                    <option>Veuf(ve)</option>
                                                </select>
                                            </li>
                                            <li>
                                                <span>Profession</span>: <br>
                                                <input class="shadow border h-[42px] rounded p-2 w-full" type="text" x-model="studentEdit.profession"> <br>
                                                @error('profession') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                            </li>
                                            <li>
                                                <span>Statut</span>: <br>
                                                {{--                                            <input class="shadow border rounded p-2 w-full" type="text" x-model="studentEdit.statut"> <br>--}}
                                                <select x-model="studentEdit.statut" class="shadow border h-[42px] rounded p-2 w-full bg-white">
                                                    <option disabled>-</option>
                                                    <option>Fonctionnaire</option>
                                                    <option>Non Fonctionnaire</option>
                                                </select>
                                                @error('statut') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                            </li>
                                            <li>
                                                <span>Reste à payer</span>: <br>
                                                <input class="shadow border rounded h-[42px] p-2 w-full" type="text" x-model="studentEdit.RAD"> <br>
                                                @error('RAD') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                            </li>
                                            <li>
                                                <span>Observation</span>: <br>
                                                <textarea type="text" x-model="studentEdit.observation" rows="3" class="mt-1 block w-full h-[120px] rounded-md border-gray-300 shadow-sm bg-gray-100"></textarea>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <div class="edit_foot">
                                <button x-on:click="$wire.dataEditSet(studentEdit)" class="bg-green-500 hover:bg-green-700 shadow-md px-3 py-1 rounded flex flex-row text-white w-[160px] text-center justify-center">
                                        <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="#fff" d="M20 12a8 8 0 0 1-8 8a8 8 0 0 1-8-8a8 8 0 0 1 8-8c.76 0 1.5.11 2.2.31l1.57-1.57A9.822 9.822 0 0 0 12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10M7.91 10.08L6.5 11.5L11 16L21 6l-1.41-1.42L11 13.17l-3.09-3.09Z"/></svg>
                                        Valider
                                </button>
                                <button x-on:click="showModal = false" class="bg-red-500 hover:bg-red-700 shadow-md px-3 py-1 rounded flex flex-row text-black w-[160px] text-center justify-center">
                                    <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6Zm3.6 5q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z"/></svg>
                                    Annuler
                                </button>
                            </div>
                        </div>
                    </div>

{{--                    EDIT MODAL PL--}}

                        <div class="edit_modal shadow-lg" x-show="candidatLShow" x-cloak
                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 transform"
                             x-transition:enter-end="opacity-100 transform" x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform" x-transition:leave-end="opacity-0 transform">
                            <div class="modal-content mx-auto rounded-lg z-50 overflow-y-auto w-full h-full">
                                <div class="modal-header py-2 px-6 flex flex-row justify-between">
                                    <div class="text-2xl font-bold"><span x-text="candidatL.numInscrit"></span></div>
                                    <button @click="candidatLShow = false" class="text-3xl leading-none font-bold text-red-600 hover:text-gray-600 focus:outline-none focus:text-gray-800">×</button>
                                </div>
                                <form>
                                    @csrf
                                    <div class="modal-body px-6 py-4 w-full grid grid-cols-2 justify-between">
                                        <div>
                                            <ul>
                                                <li>
                                                    <span>Nom</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatL.nom"> <br>
                                                    @error('nom') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Prénoms</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatL.prenom">
                                                </li>
                                                <li>
                                                    <span>Date de naissance</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="date" x-model="candidatL.dateNaissance"> <br>
                                                    @error('dateNaissance') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Lieu de naissance</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatL.lieuNaissance">
                                                </li>
                                                <li>
                                                    <span>Téléphone</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatL.telCandidat">
                                                </li>
                                                <li>
                                                    <span>CIN</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatL.cin">
                                                </li>
                                                <li>
                                                    <span>Nationalité</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatL.nationalite"> <br>
                                                    @error('nationalite') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
{{--                                                <li>--}}
{{--                                                    <span>Année Universitaire</span>: <br>--}}
{{--                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatL.anneeUnivers"> <br>--}}
{{--                                                    @error('anneeUnivers') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror--}}
{{--                                                </li>--}}
                                            </ul>
                                        </div>
                                        <div>
                                            <ul>
                                                <li>
                                                    <span>Genre</span>: <br>
                                                    {{--                                                <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatL.genre"> <br>--}}
                                                    <select required x-model="candidatL.genre" class="shadow border rounded p-2 w-full bg-white">
                                                        <option selected disabled>-</option>
                                                        <option>Masculin</option>
                                                        <option>Féminin</option>
                                                    </select>
                                                    @error('genre') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Série Baccalaurét</span>: <br>
                                                    {{--                                                <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatL.serieBacc"> <br>--}}
                                                    <select required x-model="candidatL.serieBacc" class="shadow border rounded p-2 w-full bg-white">
                                                        <option selected disabled>Serie</option>
                                                        <option>A1</option>
                                                        <option>A2</option>
                                                        <option>C</option>
                                                        <option>D</option>
                                                        <option>S</option>
                                                        <option>TECHNIQUE</option>
                                                        <option>OSE</option>
                                                        <option>L</option>
                                                    </select>
                                                    @error('centreExamen') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Année Baccalauréat</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatL.anneeBacc">
                                                </li>
                                                <li>
                                                    <span>Mention Baccalauréat</span>: <br>
                                                    {{--                                                <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatL.mentionBacc"> <br>--}}
                                                    <select required x-model="candidatL.mentionBacc" class="shadow border rounded p-2 w-full bg-white">
                                                        <option selected disabled>Mention</option>
                                                        <option>Passable</option>
                                                        <option>Assez Bien</option>
                                                        <option>Bien</option>
                                                        <option>Très Bien</option>
                                                    </select>
                                                    @error('profession') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Observation</span>: <br>
                                                    <textarea type="text" x-model="candidatL.observation" rows="3" class="mt-1 block w-full h-[225px] rounded-md border-gray-300 shadow-sm bg-gray-100"></textarea>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="edit_foot mt-14">
                                    <button x-on:click="$wire.dataSetCandidatL(candidatL)" class="bg-green-500 hover:bg-green-700 shadow-md px-3 py-1 rounded flex flex-row text-white w-[160px] text-center justify-center">
                                        <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="#fff" d="M20 12a8 8 0 0 1-8 8a8 8 0 0 1-8-8a8 8 0 0 1 8-8c.76 0 1.5.11 2.2.31l1.57-1.57A9.822 9.822 0 0 0 12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10M7.91 10.08L6.5 11.5L11 16L21 6l-1.41-1.42L11 13.17l-3.09-3.09Z"/></svg>
                                        Valider
                                    </button>
                                    <button x-on:click="candidatLShow = false" class="bg-red-500 hover:bg-red-700 shadow-md px-3 py-1 rounded flex flex-row text-black w-[160px] text-center justify-center">
                                        <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6Zm3.6 5q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z"/></svg>
                                        Annuler
                                    </button>
                                </div>
                            </div>
                        </div>

{{--                    EDIT MODAL PM1--}}

                        <div class="edit_modal shadow-lg" x-show="candidatM1Show" x-cloak
                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 transform"
                             x-transition:enter-end="opacity-100 transform" x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform" x-transition:leave-end="opacity-0 transform">
                            <div class="modal-content mx-auto rounded-lg z-50 overflow-y-auto w-full">
                                <div class="modal-header py-2 px-6 flex flex-row justify-between">
                                    <div class="text-2xl font-bold"><span x-text="candidatM1.numInscrit"></span></div>
                                    <button @click="candidatM1Show = false" class="text-3xl leading-none font-bold text-gray-800 hover:text-gray-600 focus:outline-none focus:text-gray-800">×</button>
                                </div>
                                <form>
                                    @csrf
                                    <div class="modal-body px-6 py-4 w-full grid grid-cols-2 justify-between">
                                        <div>
                                            <ul>
                                                <li>
                                                    <span>Nom</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.nom"> <br>
                                                    @error('nom') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Prénoms</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.prenom">
                                                </li>
                                                <li>
                                                    <div class="grid grid-cols-2 justify-between gap-x-5">
                                                        <div>
                                                            <span>Date de naissance</span>: <br>
                                                            <input class="shadow border rounded p-2 w-full" type="date" x-model="candidatM1.dateNaissance"> <br>
                                                            @error('dateNaissance') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div>
                                                            <span>Lieu de naissance</span>: <br>
                                                            <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.lieuNaissance">
                                                        </div>
                                                    </div>
                                                </li>

                                                <li>
                                                    <span>Téléphone</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.telCandidat">
                                                </li>
                                                <li>
                                                    <span>CIN</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.cin">
                                                </li>
                                                <li>
                                                    <span>Nationalité</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.nationalite"> <br>
                                                    @error('nationalite') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
{{--                                                <li>--}}
{{--                                                    <span>Année Universitaire</span>: <br>--}}
{{--                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.anneeUnivers"> <br>--}}
{{--                                                    @error('anneeUnivers') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror--}}
{{--                                                </li>--}}
                                                <li>
                                                    <div class="grid grid-cols-2 justify-between gap-x-5">
                                                        <div>
                                                            <span>Genre</span>: <br>
                                                            {{--                                                <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.genre"> <br>--}}
                                                            <select x-model="candidatM1.genre" class="shadow border rounded p-2 w-full bg-white">
                                                                <option disabled selected >genre</option>
                                                                <option>Masculin</option>
                                                                <option>Féminin</option>
                                                            </select>
                                                            @error('genre') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div>
                                                            <span>Centre Examen</span>: <br>
                                                            {{--                                                <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.centreExamen"> <br>--}}
                                                            <select x-model="candidatM1.centreExamen" class="shadow border rounded p-2 w-full bg-white">
                                                                <option selected disabled >Centre d'examen</option>
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
                                                </li>
                                                <li>
                                                    <span>Email</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.email"> <br>
                                                    @error('email') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                            </ul>
                                        </div>
                                        <div>
                                            <ul>
                                                <li>
                                                    <span>Situation matrimoniale</span>: <br>
{{--                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.situationMat">--}}
                                                    <select x-model="candidatM1.situationMat" class="shadow border h-[42px] rounded p-2 w-full bg-white">
                                                        <option selected disabled>-</option>
                                                        <option>Célibataire</option>
                                                        <option>Marié(e)</option>
                                                        <option>Divorcé(e)</option>
                                                        <option>Veuf(ve)</option>
                                                    </select>
                                                </li>
                                                <li>
                                                    <span>Profession</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.profession"> <br>
                                                    @error('profession') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Statut</span>: <br>
{{--                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.statut"> <br>--}}
                                                    <select x-model="candidatM1.statut" class="shadow border h-[42px] rounded p-2 w-full bg-white">
                                                        <option disabled>-</option>
                                                        <option>Fonctionnaire</option>
                                                        <option>Non Fonctionnaire</option>
                                                    </select>

                                                    @error('statut') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Diplôme licence</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.parcours"> <br>
                                                    @error('centreExamen') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Etablissement</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.etablissement">
                                                </li>
                                                <li>
                                                    <span>Université</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM1.universite"> <br>
                                                    @error('profession') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Observation</span>: <br>
                                                    <textarea type="text" x-model="candidatM1.observation" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100"></textarea>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="edit_foot">
                                    <button x-on:click="$wire.dataSetcandidatM1(candidatM1)" class="bg-green-500 hover:bg-green-700 shadow-md px-3 py-1 rounded flex flex-row text-white w-[160px] text-center justify-center">
                                        <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="#fff" d="M20 12a8 8 0 0 1-8 8a8 8 0 0 1-8-8a8 8 0 0 1 8-8c.76 0 1.5.11 2.2.31l1.57-1.57A9.822 9.822 0 0 0 12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10M7.91 10.08L6.5 11.5L11 16L21 6l-1.41-1.42L11 13.17l-3.09-3.09Z"/></svg>
                                        Valider
                                    </button>
                                    <button x-on:click="candidatM1Show = false" class="bg-red-500 hover:bg-red-700 shadow-md px-3 py-1 rounded flex flex-row text-black w-[160px] text-center justify-center">
                                        <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6Zm3.6 5q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z"/></svg>
                                        Annuler
                                    </button>
                                </div>
                            </div>

                        </div>

{{--                    EDIT MODAL PM2--}}

                        <div class="edit_modal shadow-lg" x-show="candidatM2Show" x-cloak
                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 transform"
                             x-transition:enter-end="opacity-100 transform" x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform" x-transition:leave-end="opacity-0 transform">
                            <div class="modal-content mx-auto rounded-lg z-50 overflow-y-auto w-full">
                                <div class="modal-header py-2 px-6 flex flex-row justify-between">
                                    <div class="text-2xl font-bold"><span x-text="candidatM2.numInscrit"></span></div>
                                    <button @click="candidatM2Show = false" class="text-3xl leading-none font-bold text-gray-800 hover:text-gray-600 focus:outline-none focus:text-gray-800">×</button>
                                </div>
                                <form>
                                    @csrf
                                    <div class="modal-body px-6 py-4 w-full grid grid-cols-2 justify-between">
                                        <div>
                                            <ul>
                                                <li>
                                                    <span>Nom</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.nom"> <br>
                                                    @error('nom') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Prénoms</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.prenom">
                                                </li>
                                                <li>
                                                    <div class="grid grid-cols-2 gap-x-5">
                                                        <div>
                                                            <span>Date de naissance</span>: <br>
                                                            <input class="shadow border rounded p-2 w-full" type="date" x-model="candidatM2.dateNaissance"> <br>
                                                            @error('dateNaissance') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div>
                                                            <span>Lieu de naissance</span>: <br>
                                                            <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.lieuNaissance">
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>Téléphone</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.telCandidat">
                                                </li>
                                                <li>
                                                    <span>CIN</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.cin">
                                                </li>
                                                <li>
                                                    <span>Nationalité</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.nationalite"> <br>
                                                    @error('nationalite') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
{{--                                                <li>--}}
{{--                                                    <span>Année Universitaire</span>: <br>--}}
{{--                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.anneeUnivers"> <br>--}}
{{--                                                    @error('anneeUnivers') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror--}}
{{--                                                </li>--}}
                                                <li>
                                                    <div class="grid grid-cols-2 gap-x-5">
                                                        <div>
                                                            <span>Genre</span>: <br>
                                                            {{--                                                <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.genre"> <br>--}}
                                                            <select x-model="candidatM2.genre" class="shadow border rounded p-2 w-full bg-white">
                                                                <option>Masculin</option>
                                                                <option>Féminin</option>
                                                            </select>
                                                            @error('genre') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div>
                                                            <span>Centre Examen</span>: <br>
                                                            {{--                                                <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.centreExamen"> <br>--}}
                                                            <select x-model="candidatM2.centreExamen" class="shadow border rounded p-2 bg-white w-full">
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
                                                </li>

                                                <li>
                                                    <span>Email</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.email"> <br>
                                                    @error('email') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                            </ul>
                                        </div>
                                        <div>
                                            <ul>
                                                <li>
                                                    <span>Situation matrimoniale</span>: <br>
{{--                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.situationMat">--}}
                                                    <select x-model="candidatM2.situationMat" class="shadow border h-[42px] rounded p-2 w-full bg-white">
                                                        <option selected disabled>-</option>
                                                        <option>Célibataire</option>
                                                        <option>Marié(e)</option>
                                                        <option>Divorcé(e)</option>
                                                        <option>Veuf(ve)</option>
                                                    </select>
                                                </li>
                                                <li>
                                                    <span>Profession</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.profession"> <br>
                                                    @error('profession') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Statut</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.statut"> <br>
                                                    @error('statut') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Diplôme MasterOne</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.parcours"> <br>
                                                    @error('centreExamen') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Etablissement</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.etablissement">
                                                </li>
                                                <li>
                                                    <span>Université</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2.universite"> <br>
                                                    @error('profession') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Observation</span>: <br>
                                                    <textarea type="text" x-model="candidatM2.observation" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100"></textarea>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="edit_foot">
                                    <button x-on:click="$wire.dataSetcandidatM1(candidatM2)" class="bg-green-500 hover:bg-green-700 shadow-md px-3 py-1 rounded flex flex-row text-white w-[160px] text-center justify-center">
                                        <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="#fff" d="M20 12a8 8 0 0 1-8 8a8 8 0 0 1-8-8a8 8 0 0 1 8-8c.76 0 1.5.11 2.2.31l1.57-1.57A9.822 9.822 0 0 0 12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10M7.91 10.08L6.5 11.5L11 16L21 6l-1.41-1.42L11 13.17l-3.09-3.09Z"/></svg>
                                        Valider
                                    </button>
                                    <button x-on:click="candidatM2Show = false" class="bg-red-500 hover:bg-red-700 shadow-md px-3 py-1 rounded flex flex-row text-black w-[160px] text-center justify-center">
                                        <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6Zm3.6 5q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z"/></svg>
                                        Annuler
                                    </button>
                                </div>
                            </div>

                        </div>

{{--                    EDIT MODAL PM2R--}}

                        <div class="edit_modal shadow-lg" x-show="candidatM2RShow" x-cloak
                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 transform"
                             x-transition:enter-end="opacity-100 transform" x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform" x-transition:leave-end="opacity-0 transform">
                            <div class="modal-content mx-auto rounded-lg z-50 overflow-y-auto w-full">
                                <div class="modal-header py-2 px-6 flex flex-row justify-between">
                                    <div class="text-2xl font-bold"><span x-text="candidatM2R.numInscrit"></span></div>
                                    <button @click="candidatM2RShow = false" class="text-3xl leading-none font-bold text-gray-800 hover:text-gray-600 focus:outline-none focus:text-gray-800">×</button>
                                </div>
                                <form>
                                    @csrf
                                    <div class="modal-body px-6 py-4 w-full grid grid-cols-2 justify-between">
                                        <div>
                                            <ul>
                                                <li>
                                                    <span>Nom</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.nom"> <br>
                                                    @error('nom') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Prénoms</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.prenom">
                                                </li>
                                                <li>
                                                    <div class="grid grid-cols-2 gap-x-5">
                                                        <div>
                                                            <span>Date de naissance</span>: <br>
                                                            <input class="shadow border rounded p-2 w-full" type="date" x-model="candidatM2R.dateNaissance"> <br>
                                                            @error('dateNaissance') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div>
                                                            <span>Lieu de naissance</span>: <br>
                                                            <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.lieuNaissance">
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <span>Téléphone</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.telCandidat">
                                                </li>
                                                <li>
                                                    <span>CIN</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.cin">
                                                </li>
                                                <li>
                                                    <span>Nationalité</span>: <br>
{{--                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.nationalite"> <br>--}}
                                                    <select x-model="candidatM2R.nationalite" class="shadow border rounded p-2 w-full bg-white">
                                                        <option>Malagasy</option>
                                                        <option>Etranger</option>
                                                    </select>
                                                    @error('nationalite') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
{{--                                                <li>--}}
{{--                                                    <span>Année Universitaire</span>: <br>--}}
{{--                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.anneeUnivers"> <br>--}}
{{--                                                    @error('anneeUnivers') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror--}}
{{--                                                </li>--}}
                                                <li>
                                                    <span>Genre</span>: <br>
                                                    {{--                                                <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.genre"> <br>--}}
                                                    <select x-model="candidatM2R.genre" class="shadow border rounded p-2 w-full bg-white">
                                                        <option>Masculin</option>
                                                        <option>Féminin</option>
                                                    </select>
                                                    @error('genre') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Email</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.email"> <br>
                                                    @error('email') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                            </ul>
                                        </div>
                                        <div>
                                            <ul>
                                                <li>
                                                    <span>Situation matrimoniale</span>: <br>
{{--                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.situationMat">--}}
                                                    <select x-model="candidatM2R.situationMat" class="shadow border h-[42px] rounded p-2 w-full bg-white">
                                                        <option selected disabled>-</option>
                                                        <option>Célibataire</option>
                                                        <option>Marié(e)</option>
                                                        <option>Divorcé(e)</option>
                                                        <option>Veuf(ve)</option>
                                                    </select>
                                                </li>
                                                <li>
                                                    <span>Profession</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.profession"> <br>
                                                    @error('profession') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Statut</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.statut"> <br>
                                                    @error('statut') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Diplôme MasterOne</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.parcours"> <br>
                                                    @error('parcours') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Etablissement</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.etablissement">
                                                    @error('etablissement') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Université</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.universite"> <br>
                                                    @error('universite') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Cursus</span>: <br>
                                                    <input class="shadow border rounded p-2 w-full" type="text" x-model="candidatM2R.cursus"> <br>
                                                    @error('cursus') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                                </li>
                                                <li>
                                                    <span>Observation</span>: <br>
                                                    <textarea type="text" x-model="candidatM2R.observation" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100"></textarea>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="edit_foot">
                                    <button x-on:click="$wire.dataSetcandidatM1(candidatM2R)" class="bg-green-500 hover:bg-green-700 shadow-md px-3 py-1 rounded flex flex-row text-white w-[160px] text-center justify-center">
                                        <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="#fff" d="M20 12a8 8 0 0 1-8 8a8 8 0 0 1-8-8a8 8 0 0 1 8-8c.76 0 1.5.11 2.2.31l1.57-1.57A9.822 9.822 0 0 0 12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10M7.91 10.08L6.5 11.5L11 16L21 6l-1.41-1.42L11 13.17l-3.09-3.09Z"/></svg>
                                        Valider
                                    </button>
                                    <button x-on:click="candidatM2RShow = false" class="bg-red-500 hover:bg-red-700 shadow-md px-3 py-1 rounded flex flex-row text-black w-[160px] text-center justify-center">
                                        <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6Zm3.6 5q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z"/></svg>
                                        Annuler
                                    </button>
                                </div>
                            </div>

                        </div>

<!--                    End Edit Modal-->
<!--                    <div wire:loading class="fixed bottom-0 right-0 w-1/7 p-5 -mt-14">-->
<!--                        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>-->
<!--                    </div>-->
                </div>
            </div>

            {{--            inforamtion view        --}}
            <div class="info_view "
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 transform"
            x-transition:enter-end="opacity-100 transform" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 transform" x-transition:leave-end="opacity-0 transform">
                @if($item === null)
                    <div class="w-full text-center">Aucune données pour l'instant</div>
                @else
                    <div class="number font-bold text-white bg-[#2777e5]">
                        <h3>{{ $item->numInscrit }}</h3>
                    </div>
                    <div class="info_about">
                        <ul>
                            <li><span class="unlined">Nom</span> : {{ $item->nom }}</li>
                            <li><span class="unlined">Prénoms</span> : {{ $item->prenom }}</li>
                            <li><span class="unlined">Date de naissance</span> : {{ date("d/m/Y", strtotime($item->dateNaissance)) }} </li>
                            <li><span class="unlined">Lieu de naissance</span> : {{ $item->lieuNaissance }} </li>
                            <li><span class="unlined">Genre</span> : {{ $item->genre }} </li>
                            <li><span class="unlined">Situation matrimoniale</span> : {{ $item->situationMat }} </li>
                            <li><span class="unlined">Status</span> : {{ $item->statut }} </li>
                            @if($niveau != 'PL' and $niveau != 'MR' and $niveau != 'PMR')
                                <li><span class="unlined">Centre d'examen</span> : {{ $item->centreExamen }}</li>
                            @endif
                            @if($niveau === 'MR')
                                <li><span class="unlined">Mention </span> : {{ $item->mention }}</li>
                            @endif
                            @if($niveau === 'L3')
                                @if($item->idParcours === 1)
                                        <li><span class="unlined">Parcours</span> : Education Générale</li>
                                @endif
                                @if($item->idParcours === 2)
                                    <li><span class="unlined">Parcours</span> : Education Préscolaire</li>
                                @endif
                            @endif
                            <li><span class="unlined">Email</span> : {{ $item->email }}</li>
                            <li><span class="unlined">Téléphone</span> : {{ $item->telCandidat }}</li>
                            <li><span class="unlined">CIN</span> : {{ $item->cin }}</li>
                            @if($niveau === 'PL')
                                <li><span class="unlined">Serie Baccalauréat</span> : {{ $item->serieBacc }} </li>
                                <li><span class="unlined">Année Baccalauréat</span> : {{ $item->anneeBacc }} </li>
                                <li><span class="unlined">Mention Baccalauréat</span> : {{ $item->mentionBacc }} </li>
                            @endif
                            @if($niveau === 'PM1' or $niveau === 'PM2' or $niveau === 'PMR')
                                <li><span class="unlined">Diplôme</span> : {{ $item->parcours }} </li>
                                <li><span class="unlined">Etablissement</span> : {{ $item->etablissement }} </li>
                                <li><span class="unlined">Université</span> : {{ $item->universite }} </li>
                            @endif
                            @if($niveau === 'PMR')
                                <li><span class="unlined">Cursus</span> : {{ $item->cursus }} </li>
                            @endif
                            <li><span class="unlined">1<sup>ère</sup> tranche</span> : {{ number_format($item->bordereau->montantBrd1, 0, '', ' ') }} ariary {{ $item->bordereau->referenceBrd1 }} du {{ date("d/m/Y", strtotime($item->bordereau->dateBrd1)) }}  {{$item->bordereau->agenceBrd1}}</li>
                            @if($item->bordereau->referenceBrd2)
                                <li><span class="unlined">2<sup>ème</sup> tranche</span> : {{ number_format($item->bordereau->montantBrd2, 0, '', ' ') }} ariary {{ $item->bordereau->referenceBrd2 }} du {{ date("d/m/Y", strtotime($item->bordereau->dateBrd2)) }}  {{$item->bordereau->agenceBrd2}}</li>
                            @endif
                            <li><span class="unlined">Observation</span> : {{ $item->observation }}</li>
                        </ul>
                    </div>
                    @if($niveau !== 'PL' and $niveau !== 'PM1' and $niveau !== 'PM2' and $niveau !== 'PMR')
                        <div class="compte">
                            <h3>Reste à payer : {{ number_format($item->RAD, 0, '', ' ') }} ariary</h3>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        <!--End Table Content-->
    </div>
    <!--End Contenu-->
</div>
