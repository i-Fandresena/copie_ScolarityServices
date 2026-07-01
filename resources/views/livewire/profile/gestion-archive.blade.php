<div>
    <div class="flex flex-row justify-between">
        <div>
            <select wire:model="selectedLevel"  class="shadow border rounded p-2 bg-white">
                @if(Auth()->user()->role === 'Licence')
                <option value="L1">L1</option>
                <option value="L2">L2</option>
                <option value="L3">L3</option>
                @endif
                @if(Auth()->user()->role === 'Master')
                <option >M1</option>
                <option >M2</option>
                <option value="M2R" >Master Recheche</option>
                @endif
            </select>
            <div>
                <p>
                    Archiver les étudiant du niveau courant.
                </p>
                <button wire:loading.remove wire:target="writtingArchive" wire:click="writtingArchive" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Archiver
                </button>
                <span wire:loading.delay wire:target="writtingArchive">Chargement...</span>
            </div>
        </div>
        <div>
            <select wire:model="niveauCdt"  class="shadow border rounded p-2 bg-white">
                @if(Auth()->user()->role === 'Licence')
                <option value="L1">Candidat L1</option>
                @endif
                @if(Auth()->user()->role === 'Master')
                <option value="M1">Candidat M1</option>
                <option value="M2">Candidat M2</option>
                <option value="M2R" >Candidat Master Recheche</option>
                @endif
            </select>
            <p>Archiver les données concernant les candidats</p>
            <button wire:click="confirmArchiveCdt" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                Archiver
            </button>
        </div>
    </div>
    <div wire:loading class="fixed bottom-0 right-0 w-1/7 p-5 -mt-14">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
    </div>
</div>
