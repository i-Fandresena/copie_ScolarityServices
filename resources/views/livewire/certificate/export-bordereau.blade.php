<div class="flex flex-row justify-between w-full mt-8 ">
    <div>
    </div>
    <div class="flex flex-row pr-5 pl-5 text-white bg-[#2777e5]">

    </div>
</div>
<div class="w-full grid">
    <form  method="POST" target="_blank" action="{{route('export-bordereau', $niveau)}}">
        @csrf


        <fieldset class="border-[1px] border-green-700 p-16 information">
            <legend>BORDEREAU</legend>
            <div class="grid grid-cols-2 justify-between">
                <div class="flex flex-col w-2/3 justify-self-start space-y-4">
                    <div class="flex flex-col">
                        <label for="numInscrit" class="text-gray-400">Numéro d'inscription :</label>
                        <input required type="text"  id="numInscrit" name="numInscrit" @isset($student[$index]) value="{{ $student[$index]->numInscrit }}" @endisset >
                        @error('numInscrit') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="nom" class="text-gray-400">Nom :</label>
                        <input required type="text"  id="nom" name="nom" @isset($student[$index]) value="{{ $student[$index]->nom }}" @endisset >
                        @error('nom') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="prenom" class="text-gray-400">Prénoms :</label>
                        <input type="text" id="nom" name="prenom" @isset($student[$index])  value="{{ $student[$index]->prenom }}" @endisset>
                        @error('prenom') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="anneeUnivers" class="text-gray-400">Année Universitaire :</label>
                        <input type="text" id="anneeUnivers" name="anneeUnivers" @isset($student[$index])  value="{{ $student[$index]->anneeUnivers - 1 }}-{{ $student[$index]->anneeUnivers }}" @endisset>
                        @error('anneeUnivers') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex flex-col w-2/3 justify-self-end space-y-4">
                    <div class="flex flex-col">
                        <label for="droit" class="text-gray-400">Droit (<span class="italic">en Ariary</span>) :</label>
                        <input required type="text" id="droit" name="droit" @isset($student[$index])  value="{{ number_format($student[$index]->bordereau->montantBrd1 + $student[$index]->bordereau->montantBrd2, 0, '', ' ')  }}" @endisset>
                        @error('droit') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="referenceBrd1" class="text-gray-400">Référence Bordereau 1 :</label>
                        <input required type="text"  id="referenceBrd1" name="referenceBrd1" @isset($student[$index]) value="{{ $student[$index]->bordereau->referenceBrd1 }}" @endisset>
                        @error('referenceBrd1') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="dateBrd1" class="text-gray-400">Date Bordereau 1 :</label>
                        <input required type="date"  id="dateBrd1" name="dateBrd1" @isset($student[$index]) value="{{ $student[$index]->bordereau->dateBrd1 }}" @endisset>
                        @error('dateBrd1') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="referenceBrd2" class="text-gray-400">Référence Bordereau 2 :</label>
                        <input type="text"  id="referenceBrd2" name="referenceBrd2" @isset($student[$index]) value="{{ $student[$index]->bordereau->referenceBrd2 }}" @endisset>
                        @error('referenceBrd2') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="dateBrd2" class="text-gray-400">Date Bordereau 2 :</label>
                        <input type="date"  id="dateBrd2" name="dateBrd2" @isset($student[$index]) value="{{ $student[$index]->bordereau->dateBrd2 }}" @endisset>
                        @error('dateBrd2') <span class="error text-red-700 text-xs text-xs">{{ $message }}</span> @enderror
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
                <button value="{{ $niveau }}" name="niveau"
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
