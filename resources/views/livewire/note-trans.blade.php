@php use App\Models\ElementConstitutif; @endphp
<div class="default" x-data="{ showConfirmation: false, showNote: false, showYear: false}">
    <!--Contenu-->

    <div x-show="showNote == false" class="content">
        <!--Header_Content-->

        <div class="content_header">
            <div class="content_header_right">
                <div>
                    <input type="text" class="shadow border search_input_note p-2" placeholder="recherche..."
                           wire:model="search">
                </div>
                <div class="btn_search flex flex-row space-x-2">
                    <select wire:model="niveau" class="shadow border rounded w-16 p-2 bg-white">
                        @if(Auth()->user()->role === 'Licence')
                            <option value="L1">L1</option>
                            <option value="L2">L2</option>
                            <option value="L3">L3</option>
                        @endif
                        @if(Auth()->user()->role === 'Master')
                            <option>M1</option>
                            <option>M2</option>
                        @endif
                    </select>
                    <select wire:model="session" class="shadow border rounded p-2 bg-white">
                        <option value="SN">Session Normale</option>
                        <option value="SR">Session de Rattrapage</option>
                    </select>
                    <div class="ml-5 mr-3 mt-2">
                        <input type="checkbox" wire:model="archive" x-model="showYear">
                        <span class="checkmark"> Archives </span>
                    </div>
                    <div x-show="showYear" x-cloak>
                        <div class="flex flex-col space-y-0">
{{--                            <input wire:model.defer="year" wire:keydown.enter="setYear" placeholder="année" class="shadow border rounded p-2 w-1/2">--}}
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
            </div>
            <div class="content_header_left w-1/4">
                <label class="block space-x-5 flex flex-row">
                    <input type="file" wire:model="excelFile"
                           class=" block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:rounded-full file:border-0 file:text-x-sm file:font-semibold file:bg-blue-50 file:text-green-700 hover:file:bg-green-100"/>
                    <button wire:loading.remove wire:target="verifyImport" wire:click="verifyImport">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                            <path fill="#34a853"
                                  d="M6 20q-.825 0-1.412-.587Q4 18.825 4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413Q18.825 20 18 20Zm6-4l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11Z"/>
                        </svg>
                    </button>
                    <span wire:loading.delay wire:target="verifyImport" class="text-green-400 mt-1.5">Chargement...</span>
                </label>
            </div>

        </div>

        <hr>

        <!--End Header_Content-->

        <!--Start Table Content-->
        <div>
            <div class="flex flex-row space-x-20 w-full mt-5">
                <div class="flex flex-col bg-gray-100 p-5 space-y-5 w-1/4 rounded-lg shadow">
                    <div>
                        <select wire:model="id_ue" name="" id="" class="shadow border rounded p-2 w-full">
                            <option>Unité d'enseignement</option>
                            @foreach($ue as $u)
                                <option value="{{ $u->idUE }}">{{ $u->designation }}</option>
                            @endforeach
                        </select>
                        @error('id_ue') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <div>
                            <select wire:model="id_ec" name="" id="" class="shadow border rounded p-2 w-full">
                                <option value=""></option>
                                @foreach($ec as $e)
                                    <option value="{{ $e->idMatiere }}">{{ $e->matiere }}</option>
                                @endforeach
                            </select>
                            @error('id_ec') <span
                                class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                @if($selectedEC !== null and $selectedUE !== null)
                    <div class="">
                        <h3>UE : {{ $selectedUE->designation }}</h3>
                        <h3>EC : {{ $selectedEC->matiere }}</h3>
                        <h3>ENSEIGNANT : {{ $selectedEC->enseignant }}</h3>
                    </div>
                @endif
            </div>
                <div>
                    <div class="my_table pr-10 pl-10 pt-5 overflow-auto">
                        <table class="w-full">
                            <thead>
                            <tr>
                                <th class="num">Numéro</th>
                                <th class="nom">Nom</th>
                                <th class="prenoms">Prénoms</th>
                                @if($this->session == "SN")
                                    <th class="text-center bg-green-100 text-green-800">Session Normale</th>
                                    <th class="text-center">Session Ratrapage</th>
                                @else
                                    <th class="text-center">Session Normale</th>
                                    <th class="text-center bg-green-100 text-green-800">Session Ratrapage</th>
                                @endif
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($students as $student)
                                <tr class="shadow" :key="$student->idEtd" style="cursor: pointer">
                                    <td class="num">
                                        <span
                                            class="px-2 py-3 inline-flex text-lg leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $student->numInscrit }}
                                        </span>
                                    </td>
                                    <td class="nom">
                                        {{ $student->nom }}
                                    </td>
                                    <td class="prenoms">
                                        {{ $student->prenom }}
                                    </td>

                                    <td class="prenoms text-center @if($this->session == "SN")bg-green-100 text-green-800 @endif">
                                        @if($selectedEC !== null)
                                            @if ($student->note)
                                                @foreach ($student->note->where('idMatiereN', $selectedEC->idMatiere)->all() as $note)
                                                    {{ optional($note->note)->noteSN }}
                                                @endforeach
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center @if($this->session == "SR")bg-green-100 text-green-800 @endif">
                                        @if($selectedEC !== null)
                                            @if ($student->note)
                                                @foreach ($student->note->where('idMatiereN', $selectedEC->idMatiere)->all() as $note)
                                                    {{ optional($note->note)->noteSR }}
                                                @endforeach
                                            @endif
                                        @endif
                                    </td>

                                    <td>
                                        <div class="flex flex-row space-x-1">
                                            <div class="flex flex-col w-1/4">
                                                <input wire:model.defer="note"
                                                       placeholder="xx.xx"
                                                       wire:keydown.enter="noteValidation({{ $student }})" type="text"
                                                       class="shadow border rounded p-2 text-center">
                                                @error('note') <span
                                                    class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            {{--                       transcrire                     --}}
                                            <button wire:click="noteValidation({{ $student }})"
                                                    class="bg-green-300 text-white hover:bg-green-500 shadow-md px-3 py-1 rounded">
                                                Transcrire
                                            </button>
                                            {{--                       delete                     --}}
                                            <button wire:click="deleteMessage({{ $student }})"
                                                    class="bg-transparent text-black hover:text-red-600 py-1 rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em"
                                                     viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                          d="M7 21q-.825 0-1.412-.587Q5 19.825 5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413Q17.825 21 17 21ZM17 6H7v13h10ZM9 17h2V8H9Zm4 0h2V8h-2ZM7 6v13Z"/>
                                                </svg>
                                            </button>
                                            {{--                       voir                     --}}
                                            <button x-on:click="showNote = true"
                                                    wire:click="setNumSelect({{ $student }})"
                                                    class="bg-transparent text-black hover:text-blue-600 py-1 rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em"
                                                     viewBox="0 0 32 32">
                                                    <circle cx="16" cy="16" r="4" fill="currentColor"/>
                                                    <path fill="currentColor"
                                                          d="M30.94 15.66A16.69 16.69 0 0 0 16 5A16.69 16.69 0 0 0 1.06 15.66a1 1 0 0 0 0 .68A16.69 16.69 0 0 0 16 27a16.69 16.69 0 0 0 14.94-10.66a1 1 0 0 0 0-.68ZM16 22.5a6.5 6.5 0 1 1 6.5-6.5a6.51 6.51 0 0 1-6.5 6.5Z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        Aucun étudiant trouvé
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        @if($students->count() > 0)
                            <div class="absolute bottom-2 mx-auto">
                                {{ $students->links() }}
                            </div>
                        @endif
                    </div>
                </div>

        </div>

    </div>
    <!--End Table Content-->
    <div wire:loading class="fixed bottom-0 right-0 w-1/7 p-5 -mt-14">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
    </div>
    <div x-show="showNote" x-cloak class="content">
        <button class="absolute right-5 top-2 bg-gray-300 text-white hover:bg-gray-500 shadow-md px-3 py-1 rounded none"
                id="print">PDF
        </button>
        @if($numSelect)
            NUMERO : {{$numSelect['numInscrit']}} <br>
            NOM : {{$numSelect['nom']}} <br>
            PRENOMS : {{$numSelect['prenom']}} <br>
            <table class="tableNote">
                <thead>
                <tr class="p-10 border">
                    <th class="p-5 w-1/4 border">Unité d'enseignement</th>
                    <th class="p-5 w-1/4">Elément constitutifs</th>
                    <th class="p-5 border">Note</th>
                    <th class="p-5 border">Coeff</th>
                    <th class="p-5 border">Créée par</th>
                    <th class="p-5 border">Modifiée par</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($UE as $u)
                    @php
                        $new = ElementConstitutif::where('idUE', $u->idUE)->get();
                        $count = $new->count();
                    @endphp
                    @foreach($new as $e)
                        <tr class="p-10 border">
                            @if($new->first()->idMatiere === $e->idMatiere)
                                <td class="p-5 border" rowspan="{{$count}}">{{$u->designation}}</td>
                            @endif
                            <td class="p-5 border">{{$e->matiere}}</td>
                            <td class="p-5 border text-center">
                                @foreach($numSelect['note'] as $note)
                                    @if($note['idMatiereN'] == $e->idMatiere)
                                        {{ max($note['note']['noteSN'], $note['note']['noteSR']) * $note['matiere']['poids'] }}
                                    @endif
                                @endforeach
                            </td>
                            <td class="p-5 border text-center">{{$e->poids}}</td>
                            <td class="p-5 border text-center">
                                @foreach($numSelect['note'] as $note)
                                    @if($note['idMatiereN'] == $e->idMatiere)
                                        {{ $note['note']['createdBy'] }}
                                    @endif
                                @endforeach
                            </td>
                            <td class="p-5 border text-center">
                                @foreach($numSelect['note'] as $note)
                                    @if($note['idMatiereN'] == $e->idMatiere)
                                        {{ $note['note']['updatedBy'] }}
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!--End Contenu-->
</div>

<script>
    let print_btn = document.querySelector('#print')
    print_btn.onclick = function (){
        sidebar.classList.remove('active')
        window.print()
    }
</script>
