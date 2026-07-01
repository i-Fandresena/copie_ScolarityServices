<div>
    <div class="flex flex-row justify-between w-full mt-8 ">
        <div class="flex flex-row justify-start mt-auto">
            <select wire:model="selectedLevel" class="shadow border rounded p-2 w-16 mr-5">
                @if(Auth()->user()->role === 'Licence')
                    <option selected >L1</option>
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
        <form  method="POST" action="{{ route('export-candidat' , $niveau) }}">
            @csrf
            <fieldset class="border-[1px] border-green-700 p-16 h-72">
                <legend>CANDIDATS</legend>
                    <div class="grid grid-cols-7">
                        <div class="flex justify-between ">
                            <div class="flex flex-col">
                                <label class="flex flex-row space-x-2" for="numInscrit">
                                    <input checked name="numInscrit" class="my_check1" type="checkbox" value="numInscrit">
                                    <span class="checkmark"> Numéro </span>
                                </label>
                                <label class="flex flex-row space-x-2" for="nom">
                                    <input checked type="checkbox" class="my_check1" name="nom" value="nom">
                                    <span class="checkmark"> Nom </span>
                                </label>
                                <label class="flex flex-row space-x-2" for="prenom">
                                    <input checked type="checkbox" class="my_check1" name="prenom" value="prenom">
                                    <span class="checkmark"> Prénoms </span>
                                </label>
                                <label class="flex flex-row space-x-2" for="genre">
                                    <input type="checkbox" class="my_check1" name="genre" value="genre">
                                    <span class="checkmark"> Genre </span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                <label class="flex flex-row space-x-2" for="dateNaissance">
                                    <input type="checkbox" class="my_check1" name="dateNaissance" value="dateNaissance">
                                    <span class="checkmark"> Date de Naissance</span>
                                </label>
                                <label class="flex flex-row space-x-2" for="lieuNaissance">
                                    <input type="checkbox" class="my_check1" name="lieuNaissance" value="lieuNaissance">
                                    <span class="checkmark"> Lieu de Naissance </span>
                                </label>
                                <label class="flex flex-row space-x-2" for="telCandidat">
                                    <input type="checkbox" class="my_check1" name="telCandidat" value="telCandidat">
                                    <span class="checkmark"> Télèphone</span>
                                </label>
                                <label class="flex flex-row space-x-2" for="cin">
                                    <input type="checkbox" class="my_check1" name="cin" value="cin">
                                    <span class="checkmark"> Numéro CIN </span>
                                </label>

                            </div>
                        </div>

                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                @if($niveau != 'L1')
                                    <label class="flex flex-row space-x-2" for="email">
                                        <input type="checkbox" class="my_check1" name="email" value="email">
                                        <span class="checkmark"> Email </span>
                                    </label>
                                    <label class="flex flex-row space-x-2" for="situationMat">
                                        <input type="checkbox" class="my_check1" name="situationMat" value="situationMat">
                                        <span class="checkmark"> Situation matrimoniale </span>
                                    </label>
                                    <label class="flex flex-row space-x-2" for="profession">
                                        <input type="checkbox" class="my_check1" name="profession" value="profession">
                                        <span class="checkmark"> Profession </span>
                                    </label>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                @if($niveau != 'L1')
                                    <label class="flex flex-row space-x-2" for="statut">
                                        <input type="checkbox" class="my_check1" name="statut" value="statut">
                                        <span class="checkmark"> Status </span>
                                    </label>
                                    @if($niveau != 'M2-R')
                                        <label class="flex flex-row space-x-2" for="centreExamen">
                                            <input type="checkbox" class="my_check1" name="centreExamen" value="centreExamen">
                                            <span class="checkmark"> Centre d'examen </span>
                                        </label>
                                    @endif
                                @endif
                            </div>
                        </div>

                        {{--                    // ** candidate L1 ** //                   --}}
                        @if($niveau == 'L1')
                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                <label class="flex flex-row space-x-2" for="serieBacc">
                                    <input type="checkbox" class="my_check1" name="serieBacc" value="serieBacc">
                                    <span class="checkmark"> Série Bacc </span>
                                </label>
                                <label class="flex flex-row space-x-2" for="mentionBacc">
                                    <input type="checkbox" class="my_check1" name="mentionBacc" value="mentionBacc">
                                    <span class="checkmark"> Mention Bacc </span>
                                </label>
                                <label class="flex flex-row space-x-2" for="anneeBacc">
                                    <input type="checkbox" class="my_check1" name="anneeBacc" value="anneeBacc">
                                    <span class="checkmark"> Année Bacc </span>
                                </label>
                            </div>
                        </div>

                        {{--                    // ** candidate M1 ** //                   --}}
                        @elseif($niveau == 'M1' or $niveau == 'M2' or $niveau == 'M2-R')

                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                <label class="flex flex-row space-x-2" for="etablissement">
                                    <input type="checkbox" class="my_check1" name="etablissement" value="etablissement">
                                    <span class="checkmark"> Etablissement d'origine </span>
                                </label>
                                @if($niveau == 'M1')
                                <label class="flex flex-row space-x-2" for="etablissement">
                                    <input type="checkbox" class="my_check1" name="etablissement" value="etablissement">
                                    <span class="checkmark"> Diplome de Licence </span>
                                </label>
                                @endif

                                {{--                    // ** candidate M2 ** //                   --}}

                                @if($niveau == 'M2' or $niveau == 'M2-R')
                                <label class="flex flex-row space-x-2" for="parcours">
                                    <input type="checkbox" class="my_check1" name="parcours" value="parcours">
                                    <span class="checkmark"> Diplome de Master </span>
                                </label>
                                @endif
                                <label class="flex flex-row space-x-2" for="universite">
                                    <input type="checkbox" class="my_check1" name="universite" value="universite">
                                    <span class="checkmark"> Université </span>
                                </label>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                @if($niveau == 'M2-R')
                                    <label class="flex flex-row space-x-2" for="cursus">
                                        <input type="checkbox" class="my_check1" name="cursus" value="cursus">
                                        <span class="checkmark"> Cursus </span>
                                    </label>
                                @endif
                            </div>
                        </div>

                        @endif
                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                <label class="flex flex-row space-x-2" for="idBrdC">
                                    <input type="checkbox" class="my_check1" name="idBrdC" value="idBrdC">
                                    <span class="checkmark"> Bordereau </span>
                                </label>

                                <label class="flex flex-row space-x-2" for="nationalite">
                                    <input type="checkbox" class="my_check1" name="nationalite" value="nationalite">
                                    <span class="checkmark"> Nationalité </span>
                                </label>

                                <label class="flex flex-row space-x-2" for="observation">
                                    <input type="checkbox" class="my_check1" name="observation" value="observation">
                                    <span class="checkmark"> Observation </span>
                                </label>
                            </div>
                        </div>
                </div>
            </fieldset>
            <div class="flex flex-row justify-start">
                <div class="flex flex-row justify-end mt-auto text-cyan-500 space-x-6">
                    <label class="flex flex-row space-x-2" >
                        <input id="check-all-btn-1" type="checkbox">
                        <span class="checkmark"> Tout sélectionner </span>
                    </label>
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

