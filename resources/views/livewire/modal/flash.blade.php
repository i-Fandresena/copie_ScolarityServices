<div class="fixed bottom-0 right-0 w-1/3 p-6 -mt-14">
    <div x-data ="{ open: false}" @flash-message.window="open = true; setTimeout(() => open = false, 6000);"
         x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-20"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90">
        @if($type === 'success')
            <div x-show="open" x-cloak class="relative"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90">
                <input
                    class="appearance-none border placeholder-green-500 focus:placeholder-gray-600 border-green-300 hover:border-green-400 transition-colors rounded-md w-full py-2 px-3 text-gray-600 leading-tight focus:outline-none focus:ring-gray-600 focus:border-gray-400 focus:shadow-outline"
                    id="username"
                    type="text"
                    disabled
                    placeholder="{{ $message }}"
                />
                <div class="absolute right-0 inset-y-0 flex items-center">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 mr-3 bg-green-500 rounded-full text-white p-1"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                </div>
            </div>
        @endif

        @if($type === 'warning')
            <div x-show="open" x-cloak class="relative"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90">
                <input
                    class="appearance-none border placeholder-orange-500 focus:placeholder-gray-600 border-orange-300 hover:border-red-400 transition-colors rounded-md w-full py-2 px-3 text-gray-600 leading-tight focus:outline-none focus:ring-gray-600 focus:border-gray-400 focus:shadow-outline"
                    id="username"
                    type="text"
                    disabled
                    placeholder="{{ $message  }}"
                />
                <div class="absolute right-0 inset-y-0 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 bg-orange-500 rounded-full text-white p-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        @endif

        @if($type === 'error')
            <div x-show="open" x-cloak class="relative"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90">
                <input
                    class="appearance-none border placeholder-red-500 focus:placeholder-gray-600 border-red-300 hover:border-red-400 transition-colors rounded-md w-full py-2 px-3 text-gray-600 leading-tight focus:outline-none focus:ring-gray-600 focus:border-gray-400 focus:shadow-outline"
                    id="username"
                    type="text"
                    disabled
                    placeholder="{{ $message  }}"
                />
                <div class="absolute right-0 inset-y-0 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 bg-red-500 rounded-full text-white p-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        @endif

        @if($type === 'info')
            <div x-show="open" x-cloak class="relative"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90">
                <input
                    class="appearance-none border placeholder-blue-600 focus:placeholder-gray-600 border-blue-300 hover:border-blue-400 transition-colors rounded-md w-full py-2 px-3 text-gray-600 leading-tight focus:outline-none focus:ring-gray-600 focus:border-gray-400 focus:shadow-outline"
                    id="username"
                    type="text"
                    disabled
                    placeholder="{{ $message  }}"
                />
                <div class="absolute right-0 inset-y-0 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 bg-blue-500 rounded-full text-white p-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        @endif

    </div>
</div>

