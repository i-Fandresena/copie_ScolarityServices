<div>
    <div class="flex flex-row justify-between w-full mt-8 ">
        <div class="flex flex-row justify-start mt-auto">
            <label>
                <select wire:model="selectedLevel" class="shadow border rounded p-2 w-16 mr-5">
                    @if(Auth()->user()->role === 'Licence')
                        <option selected >L1</option>
                        <option>L2</option>
                        <option>L3</option>
                    @endif
                    @if(Auth()->user()->role === 'Master')
                        <option value="M1" >M1</option>
                        <option value="M2" >M2</option>
                        <option value="M2R" >Master Recherche</option>
                    @endif
                </select>
            </label>
        </div>
        <div class="flex flex-row justify-self-end mt-auto w-48">Niveau:  @if($niveau == 'M2R') {{ "Master Recherche"}} @else {{ $niveau }} @endif </div>
    </div>

    <div class="w-full grid">
        <form  method="POST" action="{{ route('export-model' , $niveau) }}">
            @csrf
            <fieldset class="border-[1px] border-green-700 p-16 h-72">
                <legend> MODEL EXCEL </legend>
                {{--                    // ** candidat L1 ** //                   --}}
                @if($niveau == 'L3')
                    <div class="flex justify-between mb-5">
                        <div class="flex flex-row">
                            <label>
                                <select name="parcours" class="shadow border rounded p-2 bg-white">
                                    <option value="" selected >--Parcours--</option>
                                    <option value="Générale">Education Générale</option>
                                    <option value="Préscolaire">Education Préscolaire</option>
                                </select>
                            </label>

                            <span class="mt-2">(Education Générale ou Education Préscolaire)</span>
                        </div>
                    </div>
                    {{--                    // ** candidat M1 ** //                   --}}
                @elseif($niveau == 'M2-R')
                    <div class="flex justify-between mb-5">
                        <div class="flex flex-col">
                            <label>
                                <select name="parcours" class="shadow border rounded p-2 bg-white">
                                    <option selected value="Maths">Mathématique</option>
                                    <option value="PC">Physique-Chimie</option>
                                    <option value="SE">Science de l'Education</option>
                                </select>
                            </label>
                        </div>
                    </div>
                @endif
                <div class="grid grid-cols-1 h-1/2 w-full">
                    <div class="flex flex-row mt-auto w-full">
                        <div class="flex flex-row mt-auto justify-between w-full">
                            <label for="type"> Liste des admis
                                <input checked type="radio" value="admis" name="type">
                                <span class="checkmark"></span>
                            </label>
                            <label for="sr"> Preselection
                                <input type="radio" value="preselection"  name="type">
                                <span class="checkmark"></span>
                            </label>
                            <label for="sr"> Liste des matières
                                <input type="radio" value="note"  name="type">
                                <span class="checkmark"></span>
                            </label>
                            <label for="sr"> Archive des étudiants
                                <input type="radio" value="archive"  name="type">
                                <span class="checkmark"></span>
                            </label>
                            <label for="sr"> Liste étudiants
                                <input type="radio" value="listStd"  name="type">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>

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
