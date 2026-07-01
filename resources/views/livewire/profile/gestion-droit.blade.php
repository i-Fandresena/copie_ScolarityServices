
<div class="shadow sm:overflow-hidden sm:rounded-md">
{{--    <div class="block">--}}
{{--        <div class="territ">--}}
{{--                <div class="types flex flex-col">--}}
{{--                    <label>Type</label>--}}
{{--                    <select class="mr-2 shadow border p-2" wire:model="typeDroit">--}}
{{--                        @if(Auth()->user()->role === "Licence")--}}
{{--                            <option selected value="PL" >Préselection L1</option>--}}
{{--                            <option>L1</option>--}}
{{--                            <option>L2</option>--}}
{{--                            <option>L3</option>--}}
{{--                        @endif--}}
{{--                        @if(Auth()->user()->role === "Master")--}}
{{--                            <option selected value="PM1" >Préselection M1</option>--}}
{{--                            <option selected value="PM2" >Préselection M2</option>--}}
{{--                            <option selected value="M2R" >Préselection M2 Recherche</option>--}}
{{--                            <option>M1</option>--}}
{{--                            <option>M2</option>--}}
{{--                        @endif--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                <div class="Montants flex flex-col m-4">--}}
{{--                    <label>Montant (Ariary)</label>--}}
{{--                    <input type="text" wire:model="montantDroit" class="shadow border rounded w-full p-2">--}}
{{--                    @error('montantDroit') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror--}}
{{--                </div>--}}
{{--                <div class="Montants flex flex-col m-4">--}}
{{--                    <label>Libellé</label>--}}
{{--                    <input type="text" wire:model="designation" class="shadow border rounded w-full p-2">--}}
{{--                    @error('designation') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="validers">--}}
{{--                <button wire:click="save" class="bg-green-500 text-white hover:bg-green-700 shadow-md px-3 py-1 rounded">Valider</button>--}}
{{--            </div>--}}
{{--    </div>--}}
    <div class="second ml-10 w-full">
        <table class="w-full table shadow  mr-10" @click.outside="showEditDroit = ''">
            <thead>
            <tr>
                <th>Type</th>
                <th>Montant</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>

            @foreach($droits as $droit)
                <tr>
                    <td>{{ $droit->designation }}</td>
                    <td>{{ $droit->montantDroit }} Ar</td>
                    <td class="flex space-x-2">
                        <button wire:click="setShowEditDroit({{ $droit->idDroit }})" class="bg-yellow-500 text-white hover:bg-yellow-700 shadow-md px-3 py-1 rounded">Modifier</button>
                    </td>
                </tr>

                @if($showEditDroit === $droit->idDroit)
                    <tr>
                        <td colspan="3">
                            <div class="flex flex-row space-x-3 items-center justify-center">
                                <div class="">
                                    <div class="flex flex-col">
                                        <input type="text" x-model="dataDroit.montantDroit" class="shadow border rounded w-full p-2" placeholder="Montant">
                                        @error('montantDroitEdit') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="">
                                    <button x-on:click="$wire.editDroit(dataDroit)" class="bg-green-500 text-white hover:bg-green-700 shadow-md px-3 py-1 rounded">Editer</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endif

            @endforeach
            </tbody>
        </table>

    </div>
{{--    <div wire:loading class="fixed bottom-0 right-0 w-1/7 p-5 -mt-14">--}}
{{--        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>--}}
{{--    </div>--}}

</div>
