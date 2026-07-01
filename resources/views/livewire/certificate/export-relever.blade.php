<div class="flex flex-row justify-between w-full mt-8 ">
    <div>
    </div>
    <div class="flex flex-row pr-5 pl-5 text-white bg-[#2777e5]">
        Attestation numéro : {{ sprintf('%03d', strval($lastRelever)) }}
    </div>
</div>
<div class="w-full grid">
    <form  method="POST" target="_blank" action="{{route('export-relever', $lastRelever)}}">
        @csrf
        <input type="hidden" name="archive" value="{{ $archive }}">
        <input type="hidden" name="annee" value="{{ $year }}">

        <fieldset class="border-[1px] border-green-700 p-16 information">
            <legend>RELEVE DE NOTE</legend>
            @if($niveau == 'L3')
                <div class="flex justify-between mb-5">
                    <div class="flex flex-row">
                        <label>
                            <select wire:model="parcours" class="shadow border rounded p-2 bg-white">
                                <option value=""  selected >--Parcours--</option>
                                <option>Education Générale</option>
                                <option>Education Préscolaire</option>
                            </select>
                        </label>

                        <span class="mt-2">(Education Générale ou Education Préscolaire)</span>
                    </div>
                </div>
            @endif
            <div class="grid grid-cols-2 justify-between">
                <div class="flex flex-col w-2/3 justify-self-start space-y-4">
                    <div class="flex flex-col">
                        <label for="numInscrit" class="text-gray-400">Numéro d'inscription :</label>
                        <input type="text" required id="numInscrit" name="numInscrit" @isset($student[$index]) value="{{ $student[$index]->numInscrit }}" @endisset >
                        @error('numInscrit') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="nom" class="text-gray-400">Nom :</label>
                        <input type="text" required id="nom" name="nom" @isset($student[$index]) value="{{ $student[$index]->nom }}" @endisset >
                        @error('nom') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="prenom" class="text-gray-400">Prénoms :</label>
                        <input type="text" id="nom" name="prenom" @isset($student[$index])  value="{{ $student[$index]->prenom }}" @endisset>
                        @error('prenom') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex flex-col w-2/3 justify-self-end space-y-4">
                    <div class="flex flex-col">
                        <label for="dateNaissance" class="text-gray-400">Date de Naissance :</label>
                        <input type="date" required id="dateNaissance" name="dateNaissance" @isset($student[$index]) value="{{ $student[$index]->dateNaissance }}" @endisset>
                        @error('dateNaissance') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="lieuNaissance" class="text-gray-400">Lieu de Naissance :</label>
                        <input type="text" required id="nom" name="lieuNaissance" @isset($student[$index]) value="{{ $student[$index]->lieuNaissance }}" @endisset>
                        @error('lieuNaissance') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="anneeUnivers" class="text-gray-400">Année Universitaire :</label>
                        <input type="text" required id="anneeUnivers" name="anneeUnivers" @isset($student[$index]) value="{{ $student[$index]->anneeUnivers - 1 }}-{{ $student[$index]->anneeUnivers }}" @endisset>
                        @error('anneeUnivers') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="parcours" class="text-gray-400">Parcours :</label>
                        <input type="text" required id="dateNaissance" name="parcours" @isset($parcours) value="{{ $parcours }}" @endisset>
                        @error('dateNaissance') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

            </div>
        </fieldset>
        <div class="flex flex-row justify-between">
            <div class="flex flex-row justify-start mt-auto">

            </div>

            <div class="flex flex-col justify-center mt-auto">
            </div>

            <div class="flex flex-row justify-end mt-auto">
                <button wire:click="render()" value="{{ $niveau }}" name="niveau"
                        class="inline-flex items-center mt-8 px-5 py-1.5 bg-green-500 hover:bg-green-600 text-white font-medium text-xs leading-normal uppercase rounded-full">
                    <div class="flex flex-row space-x-0">
                        <svg class="mt-0.6" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="#fff" d="M20 12a8 8 0 0 1-8 8a8 8 0 0 1-8-8a8 8 0 0 1 8-8c.76 0 1.5.11 2.2.31l1.57-1.57A9.822 9.822 0 0 0 12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10M7.91 10.08L6.5 11.5L11 16L21 6l-1.41-1.42L11 13.17l-3.09-3.09Z"/></svg>
                        <span>Valider</span>
                    </div>
                </button>
            </div>


        </div>
    </form>
</div>
