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
        <form  method="POST" action="{{ route('export-etudiant' , $niveau) }}">
            @csrf
            <fieldset class="border-[1px] border-green-700 p-16 h-72">
                <legend>ETUDIANTS</legend>
                    {{--                    // ** candidate L1 ** //                   --}}
                    @if($niveau == 'L3')
                        <div class="flex justify-between mb-5">
                            <div class="flex flex-row">
                                <select name="parcours" class="shadow border rounded p-2 bg-white">
                                    <option disabled selected >--Parcours--</option>
                                    <option value="1">Education Générale</option>
                                    <option value="2">Education Préscolaire</option>
                                </select>

                                <span class="mt-2">(Education Générale ou Education Préscolaire)</span>
                            </div>
                        </div>
                        {{--                    // ** candidate M1 ** //                   --}}
                    @elseif($niveau == 'M2-R')
                        <div class="flex justify-between mb-5">
                            <div class="flex flex-col">
                                <select name="parcours" class="shadow border rounded p-2 bg-white">
                                    <option selected value="Tout">Tout</option>
                                    <option value="Maths">Mathématique</option>
                                    <option value="PC">Physique-Chimie</option>
                                    <option value="SE">Science de l'Education</option>
                                </select>
                            </div>
                        </div>
                    @endif
                    <div class="grid grid-cols-6">
                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                <label class="flex flex-row space-x-2" for="numInscrit">
                                    <input checked class="my_check2" name="numInscrit"  type="checkbox" value="numInscrit">
                                    <span class="checkmark"> Numéro </span>
                                </label>
                                <label class="flex flex-row space-x-2" for="nom">
                                    <input checked class="my_check2" type="checkbox" name="nom" value="nom">
                                    <span class="checkmark"> Nom </span>
                                </label>
                                <label class="flex flex-row space-x-2" for="prenom">
                                    <input checked class="my_check2" type="checkbox" name="prenom" value="prenom">
                                    <span class="checkmark"> Prénoms </span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                <label class="flex flex-row space-x-2" for="dateNaissance">
                                    <input type="checkbox" class="my_check2" name="dateNaissance" value="dateNaissance">
                                    <span class="checkmark"> Date de Naissance</span>
                                </label>
                                <label class="flex flex-row space-x-2" for="lieuNaissance">
                                    <input type="checkbox" class="my_check2" name="lieuNaissance" value="lieuNaissance">
                                    <span class="checkmark"> Lieu de Naissance </span>
                                </label>
                                <label class="flex flex-row space-x-2" for="statut">
                                    <input type="checkbox" class="my_check2" class="my_check2" name="statut" value="statut">
                                    <span class="checkmark"> Statut </span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                <label class="flex flex-row space-x-2" for="telCandidat">
                                    <input type="checkbox" class="my_check2" name="telCandidat" value="telCandidat">
                                    <span class="checkmark"> Télèphone</span>
                                </label>
                                <label class="flex flex-row space-x-2" for="cin">
                                    <input type="checkbox" class="my_check2" name="cin" value="cin">
                                    <span class="checkmark"> Numéro CIN </span>
                                </label>
                                <label class="flex flex-row space-x-2" for="genre">
                                    <input type="checkbox" class="my_check2" class="my_check2" name="genre" value="genre">
                                    <span class="checkmark"> Genre </span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                <label class="flex flex-row space-x-2" for="email">
                                    <input type="checkbox" class="my_check2" class="my_check2" name="email" value="email">
                                    <span class="checkmark"> Email </span>
                                </label>
                                <label class="flex flex-row space-x-2" for="situationMat">
                                    <input type="checkbox" class="my_check2" class="my_check2" name="situationMat" value="situationMat">
                                    <span class="checkmark"> Situation matrimoniale </span>
                                </label>
                                <label class="flex flex-row space-x-2" for="profession">
                                    <input type="checkbox" class="my_check2" class="my_check2" name="profession" value="profession">
                                    <span class="checkmark"> Profession </span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                <label class="flex flex-row space-x-2" for="idBrdE">
                                    <input type="checkbox" class="my_check2" class="my_check2" name="idBrdE" value="idBrdE">
                                    <span class="checkmark"> Bordereau </span>
                                </label>

                                <label class="flex flex-row space-x-2" for="RAD">
                                    <input type="checkbox" class="my_check2" class="my_check2" name="RAD" value="RAD">
                                    <span class="checkmark"> Reste à payé </span>
                                </label>

                                <label class="flex flex-row space-x-2" for="observation">
                                    <input type="checkbox" class="my_check2" class="my_check2" name="observation" value="observation">
                                    <span class="checkmark"> Observation </span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                @if($niveau != 'M2-R')
                                    <label class="flex flex-row space-x-2" for="centreExamen">
                                        <input type="checkbox" class="my_check2" class="my_check2" name="centreExamen" value="centreExamen">
                                        <span class="checkmark"> Centre d'examen </span>
                                    </label>
                                @endif
                                <label class="flex flex-row space-x-2" for="nationalite">
                                    <input type="checkbox" class="my_check2" class="my_check2" name="nationalite" value="nationalite">
                                    <span class="checkmark"> Nationalité </span>
                                </label>
                            </div>
                        </div>
                </div>
            </fieldset>
            <div class="flex flex-row justify-start w-full">
                <div class="flex flex-row mt-auto space-x-6">
                    <label class="flex flex-row space-x-2 text-cyan-500">
                        <input id="check-all-btn-2" type="checkbox">
                        <span class="checkmark"> Tout sélectionner </span>
                    </label>
                    <label for="condition">Etudiant dont le droit sont complet
                        <input type="radio" value="satify" name="condition">
                        <span class="checkmark"></span>
                    </label>
                    <label for="condition">Etudiant dont le droit sont incomplet
                        <input type="radio" value="insatify" name="condition">
                        <span class="checkmark"></span>
                    </label>
                    <label for="master">Tous les étudiants
                        <input checked type="radio" value="all"  name="condition">
                        <span class="checkmark"></span>
                    </label>
{{--                    pl-2 pr-2 pb-1 rounded-b-[5px] bg-[#36705ccc]--}}
                    <div x-data="{ open: false }" class="flex justify-between">
                        <div class="flex flex-col mt-auto">
                            <label class="flex flex-row space-x-2" for="archive">
                                <input type="checkbox" x-on:click="open = !open" name="archive" value="true">
                                <span class="checkmark"> Archive </span>
                            </label>

                        </div>
                        <div x-show="open" x-cloak class="flex flex-col ml-7">
                            <label class="flex flex-row space-x-2" for="annee">
                                <span class="checkmark"> Année :</span>
{{--                                <input type="text" placeholder="Année Universitaire" name="annee" class="rounded pl-1 border-l-2 border-r-2">--}}
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

