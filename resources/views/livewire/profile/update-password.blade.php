<form wire:submit.prevent="update">
    <div class="shadow sm:overflow-hidden sm:rounded-md">
        <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
            <div class="grid grid-cols-3 gap-6">

                <div class="col-span-3 sm:col-span-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe Actuelle</label>
                    <div class="mt-1 flex rounded shadow-sm">
                        <input type="password" name="password" id="password"
                               wire:model.lazy="password"
                               class="block w-full flex-1 rounded-none border-gray-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="Mot de passe Actuelle">
                    </div>
                    @error('password') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-3 sm:col-span-2">
                    <label for="newPassword" class="block text-sm font-medium text-gray-700">Nouveau Mot de
                        Passe</label>
                    <div class="mt-1 flex rounded shadow-sm">
                        <input type="password" name="newPassword" id="newPassword"
                               wire:model.lazy="newPassword"
                               class="block w-full flex-1 rounded-none border-gray-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="Nouveau mot de passe">
                    </div>
                    @error('newPassword') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-3 sm:col-span-2">
                    <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirmer votre mot de
                        passe</label>
                    <div class="mt-1 flex rounded shadow-sm">
                        <input type="password" name="confirmPassword" id="confirmPassword"
                               wire:model.lazy="confirmPassword"
                               class="block w-full flex-1 rounded-none border-gray-500 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="confirmer votre mot de passe">
                    </div>
                    @error('confirmPassword') <span class="error text-red-700 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 text-center sm:px-6">
            <button type="submit"
                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Modifier
            </button>
        </div>
    </div>
</form>
