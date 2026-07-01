<div class="block">
    <div>
        <select wire:model="selectedLevel"  class="shadow border rounded p-2">
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
    </div>

    <form wire:submit.prevent="import">
        <label class="block space-x-5 space-y-5">
            <span class="text-gray-500">Utiliser le modèle de "Liste des admis" dans l'option exporter</span>
            <span class="sr-only">Choisir un fichier excel</span>
            <input type="file" wire:model="excelFile" class=" block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
            <button wire:loading.remove wire:target="import" class="bg-green-500 text-white hover:bg-green-700 shadow-md px-3 py-1 mt-6 ml-2 rounded" type="submit">Importer</button>
            <span wire:loading.delay wire:target="import">Chargement...</span>
            <button class="bg-red-500 float-right right-0 w-16 text-white hover:bg-red-700 shadow-md px-3 py-1 mt-6 ml-2 rounded" wire:click="confirmDeleteAdmis">Vider</button>
        </label>

{{--        <input type="file" wire:model="ue" class=" block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>--}}
{{--        <button class="bg-red-500 text-white hover:bg-red-700 shadow-md px-3 py-1 mt-6 ml-2 rounded" wire:click="tmpAdd">Vider</button>--}}

    </form>
    <div wire:loading class="fixed bottom-0 right-0 w-1/7 p-5 -mt-14">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
    </div>
</div>




