<div class="flex flex-row justify-between w-full mt-8 ">
    <div>
    </div>
    <div class="flex flex-row pr-5 pl-5 text-white bg-[#2777e5]">
        Attestation numéro : {{ sprintf('%03d', strval($lastAttestation)) }}
    </div>
</div>
<div class="w-full grid">
    <form>
        @csrf
        <fieldset class="border-[1px] border-green-700 p-16 information">
            <legend>ATTESTATION</legend>
            <div class="grid grid-cols-2 justify-between">
                <div class="flex flex-col w-2/3 justify-self-start space-y-4">
                    <div class="flex flex-col">
                        <label for="numInscrit" class="text-gray-400">Numéro d'inscription :</label>
                        <input type="text" required id="numInscrit" name="numInscrit"
                               wire:model="numero"
                               @isset($student[$index])  value="{{ $student[$index]->numInscrit }}" @endisset >
                        @error('numInscrit') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="nom"  class="text-gray-400">Nom :</label>
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
                </div>
            </div>
        </fieldset>
        <div class="flex flex-row justify-between">
            <div class="flex flex-row justify-start mt-auto">

            </div>

            <div class="flex flex-col justify-center">
                @if ($verify)
                    @if($exist)
                        <div class="flex flex-col text-center rounded-md bg-red-200 shadow-md w-full py-2 mt-3">
                            <span>{{ $message }}</span>
                        </div>
                    @endif
                    @if(!$exist)
                            <div class="flex flex-col text-center rounded-md bg-green-200 shadow-md w-full py-2 mt-3">
                                <span>{{ $message }}</span>
                            </div>
                    @endif
                    <div class="flex flex-row ml-40 mr-40 p-5">
                        <button wire:click="render()" formmethod="post" formaction="{{ route('export-attestation',  $lastAttestation) }}" formtarget="_blank" value="validate" name="button"
                                class="inline-flex items-center m-1 px-5 py-1.5 bg-green-500 hover:bg-green-600 text-white font-medium text-xs leading-normal rounded-full">
                            <div class="flex flex-row space-x-0">
                                <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11Zm-8 4v-5h2v3h12v-3h2v5Z"/></svg>
                                <span>Valider</span>
                            </div>
                        </button>


                        <button class="inline-flex items-center m-1 px-5 py-1.5 bg-red-500 hover:bg-red-600 text-black font-medium text-xs leading-normal rounded-full">
                            <svg class="mt-0.5" xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path fill="currentColor" d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6Zm3.6 5q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Z"/></svg>
                            Annuler
                        </button>
                    </div>
                @endif
            </div>
            <div>

            </div>
        </div>
    </form>

    <div class="flex flex-row justify-end mt-auto">
        @if (!$verify)
            <button wire:click="confirmAttestation('checkIfExistAttestation', '{{ $numero }}')"
                    class="inline-flex items-center mt-8 px-5 py-1.5 bg-green-500 hover:bg-green-600 text-white font-medium text-xs leading-normal uppercase rounded-full">
                <div class="flex flex-row space-x-0">
                    <svg class="mt-0.6" xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="#fff" d="M20 12a8 8 0 0 1-8 8a8 8 0 0 1-8-8a8 8 0 0 1 8-8c.76 0 1.5.11 2.2.31l1.57-1.57A9.822 9.822 0 0 0 12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10M7.91 10.08L6.5 11.5L11 16L21 6l-1.41-1.42L11 13.17l-3.09-3.09Z"/></svg>
                    <span>Valider</span>
                </div>
            </button>
        @endif
    </div>



</div>
