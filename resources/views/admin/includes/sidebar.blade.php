<aside class="w-full md:w-64 bg-gray-800 md:min-h-screen" x-data="{ isOpen: false }">
    <div class="flex items-center justify-between bg-gray-900 p-4 h-16">
        <a href="#" class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" preserveAspectRatio="xMidYMid meet" viewBox="0 0 36 36"><circle cx="14.67" cy="8.3" r="6" fill="red" class="clr-i-solid clr-i-solid-path-1"/><path fill="red" d="M16.44 31.82a2.15 2.15 0 0 1-.38-2.55l.53-1l-1.09-.33a2.14 2.14 0 0 1-1.5-2.1v-2.05a2.16 2.16 0 0 1 1.53-2.07l1.09-.33l-.52-1a2.17 2.17 0 0 1 .35-2.52a18.92 18.92 0 0 0-2.32-.16A15.58 15.58 0 0 0 2 23.07v7.75a1 1 0 0 0 1 1h13.44Z" class="clr-i-solid clr-i-solid-path-2"/><path fill="red" d="m33.7 23.46l-2-.6a6.73 6.73 0 0 0-.58-1.42l1-1.86a.35.35 0 0 0-.07-.43l-1.45-1.46a.38.38 0 0 0-.43-.07l-1.85 1a7.74 7.74 0 0 0-1.43-.6l-.61-2a.38.38 0 0 0-.36-.25h-2.08a.38.38 0 0 0-.35.26l-.6 2a6.85 6.85 0 0 0-1.45.61l-1.81-1a.38.38 0 0 0-.44.06l-1.47 1.44a.37.37 0 0 0-.07.44l1 1.82a7.24 7.24 0 0 0-.65 1.43l-2 .61a.36.36 0 0 0-.26.35v2.05a.36.36 0 0 0 .26.35l2 .61a7.29 7.29 0 0 0 .6 1.41l-1 1.9a.37.37 0 0 0 .07.44L19.16 32a.38.38 0 0 0 .44.06l1.87-1a7.09 7.09 0 0 0 1.4.57l.6 2.05a.38.38 0 0 0 .36.26h2.05a.38.38 0 0 0 .35-.26l.6-2.05a6.68 6.68 0 0 0 1.38-.57l1.89 1a.38.38 0 0 0 .44-.06L32 30.55a.38.38 0 0 0 .06-.44l-1-1.88a6.92 6.92 0 0 0 .57-1.38l2-.61a.39.39 0 0 0 .27-.35v-2.07a.4.4 0 0 0-.2-.36Zm-8.83 4.72a3.34 3.34 0 1 1 3.33-3.34a3.34 3.34 0 0 1-3.33 3.34Z" class="clr-i-solid clr-i-solid-path-3"/><path fill="none" d="M0 0h36v36H0z"/></svg>
            <span class="text-gray-300 text-xl font-semibold mx-2">Admin ENS</span>
        </a>
        <div class="flex md:hidden">
            <button type="button" @click="isOpen = !isOpen"
                    class="text-gray-300 hover:text-gray-500 focus:outline-none focus:text-gray-500">
                <svg class="fill-current w-8" fill="none" stroke-linecap="round" stroke-linejoin="round"
                     stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>
    <div class="px-2 py-6 md:block" :class="isOpen? 'block': 'hidden'" >
        <ul>
            <li class="px-2 py-3 bg-gray-900 rounded">
                <a href="#" class="flex items-center">
                    <svg class="w-6 text-gray-500" fill="none" stroke-linecap="round"
                         stroke-linejoin="round"
                         stroke-width="2"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="mx-2 text-gray-300">Dashboard</span>
                </a>
            </li>
{{--            <li class="px-2 py-3 hover:bg-gray-900 rounded mt-2">--}}
{{--                <a href="#" class="flex items-center">--}}
{{--                    <svg class="w-6 text-gray-500" fill="none" stroke-linecap="round"--}}
{{--                         stroke-linejoin="round"--}}
{{--                         stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                        <path--}}
{{--                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>--}}
{{--                    </svg>--}}
{{--                    <span class="mx-2 text-gray-300">Projects</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="px-2 py-3 hover:bg-gray-900 rounded mt-2">--}}
{{--                <a href="#" class="flex items-center">--}}
{{--                    <svg class="w-6 text-gray-500" fill="none" stroke-linecap="round"--}}
{{--                         stroke-linejoin="round"--}}
{{--                         stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                        <path--}}
{{--                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>--}}
{{--                    </svg>--}}
{{--                    <span class="mx-2 text-gray-300">Calendar</span>--}}
{{--                </a>--}}
{{--            </li>--}}
            <li class="px-2 py-3 hover:bg-gray-900 rounded mt-2">
                <a href="#" class="flex items-center">
                    <svg class="w-6 text-gray-500" fill="none" stroke-linecap="round"
                         stroke-linejoin="round"
                         stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <span class="mx-2 text-gray-300">Import</span>
                </a>
            </li>
{{--            <li class="px-2 py-3 hover:bg-gray-900 rounded mt-2">--}}
{{--                <a href="#" class="flex items-center">--}}
{{--                    <svg class="w-6 text-gray-500" fill="none" stroke-linecap="round"--}}
{{--                         stroke-linejoin="round"--}}
{{--                         stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                        <path--}}
{{--                            d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>--}}
{{--                    </svg>--}}
{{--                    <span class="mx-2 text-gray-300">Reports</span>--}}
{{--                </a>--}}
{{--            </li>--}}
        </ul>
        <div class="border-t border-gray-700 -mx-2 mt-2 md:hidden"></div>
        <ul class="mt-6 md:hidden">
{{--            <li class="px-2 py-3 hover:bg-gray-900 rounded mt-2">--}}
{{--                <a href="#" class="mx-2 text-gray-300">Account Settings</a>--}}
{{--            </li>--}}
            <li class="px-2 py-3 hover:bg-gray-900 rounded mt-2">
                <button class="mx-2 text-gray-300" @click="logout">Logout</button>
            </li>
        </ul>
    </div>
</aside>
