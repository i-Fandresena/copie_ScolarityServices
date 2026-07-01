<div>
    <form wire:submit.prevent="updateProfile({{ Auth()->user()->id }})">
        <div class="shadow sm:overflow-hidden sm:rounded-md">
            <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-3 sm:col-span-2">
                        <label for="company-website" class="block text-sm font-medium text-gray-700">Nom</label>
                        <div class="mt-1 flex rounded shadow-sm">
                            <input type="text" name="nom" id="nom"
                                   x-model="data.nom"
                                   wire:model.lazy="nom"
                                   class="block w-full flex-1 rounded-none border-gray-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   placeholder="nom">
                        </div>
                        @error('nom') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-3 sm:col-span-2">
                        <label for="company-website" class="block text-sm font-medium text-gray-700">Prènoms</label>
                        <div class="mt-1 flex rounded shadow-sm">
                            <input type="text" name="prenom" id="prenom"
                                   x-model="data.prenom"
                                   wire:model.lazy="prenom"
                                   value="dsd"
                                   class="block w-full flex-1 rounded-none border-gray-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   placeholder="Prènoms">
                        </div>
                        @error('prenom') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-3 sm:col-span-2">
                        <label for="company-website" class="block text-sm font-medium text-gray-700">E-mail</label>
                        <div class="mt-1 flex rounded shadow-sm">
                            <input type="email" name="email" id="email"
                                   x-model="data.email"
                                   wire:model.lazy="email"
                                   class="block w-full flex-1 rounded-none border-gray-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   placeholder="addresse email">
                        </div>
                        @error('email') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                    </div>

                </div>

            </div>
            <div class="bg-gray-50 px-4 py-3 text-center sm:px-6">
                <button type="submit"
                        x-on:click="$wire.dataSet({{ Auth()->user()->id }} ,data)"
                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Enregistrer
                </button>
            </div>
        </div>
    </form>
</div>

