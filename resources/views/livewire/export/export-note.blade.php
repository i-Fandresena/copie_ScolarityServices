<div>
    <div class="flex flex-row justify-between w-full mt-8 ">
        <div class="flex flex-row justify-start mt-auto">
            <select wire:model="selectedLevel" class="shadow border rounded p-2 w-16 mr-5">
                @if(Auth()->user()->role === 'Licence')
                    <option selected >L1</option>
                    <option>L2</option>
                    <option>L3</option>
                @endif
                @if(Auth()->user()->role === 'Master')
                    <option value="M1" >M1</option>
                    <option value="M2" >M2</option>
                    <option value="M2-R" >Master Recherche</option>
                @endif
            </select>
        </div>
        <div class="flex flex-row justify-self-end mt-auto w-48">Niveau:  @if($niveau == 'M2-R') {{ "Master Recherche"}} @else {{ $niveau }} @endif </div>
    </div>

    <div class="w-full grid">
        <form  method="POST" action="{{ route('export-note' , $niveau) }}">
            @csrf
            <fieldset class="border-[1px] border-green-700 p-16 h-72">
                <legend>NOTES</legend>
{{--                <div class="flex justify-between mb-5">--}}
{{--                    <div>--}}
{{--                        <div>--}}
{{--                            <select wire:model="id_ue" name="" id="" class="shadow border rounded p-2 w-full">--}}
{{--                                <option>Unité d'enseignement</option>--}}
{{--                                @foreach($ue as $u)--}}
{{--                                    <option value="{{ $u->idUE }}">{{ $u->designation }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('id_ue') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <select wire:model="id_ec" name="idMatiere" id="matiere" class="shadow border rounded p-2 w-full">--}}
{{--                                <option value=""></option>--}}
{{--                                @foreach($ec as $e)--}}
{{--                                    <option value="{{ $e->idMatiere }}">{{ $e->matiere }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('id_ec') <span--}}
{{--                                class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    @if($selectedEC !== null and $selectedUE !== null)--}}
{{--                        <div class="">--}}
{{--                            <h3>UE : {{ $selectedUE->designation }}</h3>--}}
{{--                            <h3>EC : {{ $selectedEC->matiere }}</h3>--}}
{{--                            <h3>ENSEIGNANT : {{ $selectedEC->enseignant }}</h3>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}

                <div class="grid grid-cols-2 h-1/2">
                    <div class="flex flex-row mt-auto w-full">
                        <div class="flex flex-row mt-auto space-x-10">
                            <label for="sn"> Session Normale
                                <input checked type="radio" value="noteSN" name="typeNote">
                                <span class="checkmark"></span>
                            </label>
                            <label for="sr"> Session de ratrapage
                                <input type="radio" value="noteSR"  name="typeNote">
                                <span class="checkmark"></span>
                            </label>
                            <label for="final"> Résultat final
                                <input type="radio" value="final"  name="typeNote">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    @if($niveau == 'L3')
                        <div class="flex flex-row">
                            <select name="parcours" class="shadow border rounded p-2 h-1/2 bg-white">
                                <option selected >--Parcours--</option>
                                <option value="1">Education Générale</option>
                                <option value="2">Education Préscolaire</option>
                            </select>
                            <span class="mt-2">(Education Générale ou Education Préscolaire)</span>
                        </div>
                    @elseif($niveau == 'M2-R')
                        <div class="flex justify-between mb-5">
                            <div class="flex flex-col">
                                <select name="parcours" class="shadow border rounded p-2 bg-white">
                                    <option selected value="Maths">Mathématique</option>
                                    <option value="PC">Physique-Chimie</option>
                                    <option value="SE">Science de l'Education</option>
                                </select>
                            </div>
                        </div>
                    @endif
                </div>

            </fieldset>
            <div class="flex flex-row justify-start w-full">
                <div class="flex flex-row mt-auto space-x-6">
                    <div x-data="{ open: false }" class="flex justify-between">
                        <div class="flex flex-col mt-auto space-x-10">
                            <label class="flex flex-row space-x-2" for="archive">
                                <input type="checkbox" x-on:click="open = !open" name="archive" value="true">
                                <span class="checkmark"> Archive </span>
                            </label>

                        </div>
                        <div x-show="open" x-cloak class="flex flex-col ml-7">
                            <label class="flex flex-row space-x-2" for="annee">
                                <span class="checkmark"> Année </span>
{{--                                <input type="text" name="annee" placeholder="Année Universitaire" class=" rounded pl-1 border-l-2 border-r-2">--}}
                                <select name="annee" class="rounded pl-1 border-l-2 border-r-2">
                                    <option selected  value=""> xxxx </option>
                                    @foreach($annees as $annee)
                                        <option value="{{ $annee->anneeUnivers }}">{{ $annee->anneeUnivers }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-row justify-end mt-auto">
                <div class="mx-2 mt-6">
                    <input type="submit" value="Exporter"
                           class="bg-green-500 text-white hover:bg-green-700 transition
                                    ease-in-out duration-500 rounded-md shadow-md w-full block px-4 py-2 mt-3">
                </div>
            </div>
        </form>
    </div>
</div>
