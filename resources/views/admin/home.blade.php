@extends('admin.layouts.app')

@section('contentAdmin')

    <div class="mx-auto w-full" >
        <div>
            <!-- Card stats -->
            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-1/3 px-4">
                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                        <div class="flex-auto p-4">
                            <div class="flex flex-wrap">
                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                    <h5 class="text-gray-500 uppercase font-bold text-xs">
                                        Utilisateur
                                    </h5>
                                    <span class="font-semibold text-xl text-gray-800">
                          {{ $users->count() }}
                        </span>
                                </div>
                                <div class="relative w-auto px-2 flex-initial">
                                    <div
                                        class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-orange-500">
                                        <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                             stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-4">
                      <span class="text-red-500 mr-2">
                        <i class="fas fa-arrow-down"></i>
                      </span>
                                <span class="whitespace-no-wrap">
                      </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 px-4">
                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                        <div class="flex-auto p-4">
                            <div class="flex flex-wrap">
                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                    <h5 class="text-gray-500 uppercase font-bold text-xs">
                                        Licence
                                    </h5>
                                    <span class="font-semibold text-xl text-gray-800">
                          {{ $L1 + $L2 + $L3 }}
                        </span>
                                </div>
                                <div class="relative w-auto flex-initial">
                                    <div
                                        class="text-white text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48px" height="48px" viewBox="0 0 24 24"><path fill="#ec4899" d="M9 7v10h6v-2h-4V7H9m3-5a10 10 0 0 1 10 10a10 10 0 0 1-10 10A10 10 0 0 1 2 12A10 10 0 0 1 12 2Z"/></svg>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-4">
                      <span class="whitespace-no-wrap">
                        L1:
                      </span>
                      <span class="text-orange-500 mr-2">
                        <i class="fas fa-arrow-down"></i> {{ $L1 }}
                      </span>

                      <span class="whitespace-no-wrap">
                        L2:
                      </span>
                      <span class="text-orange-500 mr-2">
                        <i class="fas fa-arrow-down"></i> {{ $L2 }}
                      </span>

                      <span class="whitespace-no-wrap">
                        L3:
                      </span>
                      <span class="text-orange-500 mr-2">
                        <i class="fas fa-arrow-down"></i> {{ $L3 }}
                      </span>


                            </p>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 px-4">
                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                        <div class="flex-auto p-4">
                            <div class="flex flex-wrap">
                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                    <h5 class="text-gray-500 uppercase font-bold text-xs">
                                        Master
                                    </h5>
                                    <span class="font-semibold text-xl text-gray-800">
                          {{ $M1 + $M2 + $MR }}
                        </span>
                                </div>
                                <div class="relative w-auto px-2 flex-initial">
                                    <div
                                        class="text-white text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48px" height="48px" viewBox="0 0 64 64"><path fill="#3b82f6" d="M32 2C15.431 2 2 15.432 2 32s13.432 30 30 30c16.568 0 30-13.432 30-30S48.568 2 32 2zm15 47h-6V24l-9 9l-9-9v25h-6V15h6l9 9l9-9h6v34z"/></svg>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-4">
                      <span class="whitespace-no-wrap">
                        M1:
                      </span>
                                <span class="text-orange-500 mr-2">
                        <i class="fas fa-arrow-down"></i> {{ $M1 }}
                      </span>

                                <span class="whitespace-no-wrap">
                        M2:
                      </span>
                                <span class="text-orange-500 mr-2">
                        <i class="fas fa-arrow-down"></i> {{ $M2 }}
                      </span>

                                <span class="whitespace-no-wrap">
                        Master Récherche:
                      </span>
                                <span class="text-orange-500 mr-2">
                        <i class="fas fa-arrow-down"></i> {{ $MR }}
                      </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-12">
        <h2 class="text-2xl font-medium">Tables</h2>
        <div class="mt-4">
            <div class="flex flex-col">
                <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6">
                    <div
                        class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                        <table class="min-w-full">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                    style="text-align: start">
                                    Nom et Prenoms
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                    style="text-align: start">
                                    Mail
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                    style="text-align: start">
                                    Roles
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                                    style="text-align: start">
                                    Status
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($user->images != 'default.jpg')
                                                    <img class="h-10 w-10 rounded-full object-cover" src="/storage/{{ $user->images }}" alt="Photo de profil">
                                                @else
                                                    <img class="h-10 w-10 rounded-full object-cover" src="/images/{{ $user->images }}" alt="Photo de profil">
                                                @endif
                                            </div>
                                            <div class="mx-2">
                                                <div class="text-sm leading-5 font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm leading-5 font-medium text-gray-700">{{ $user->prenom }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        {{ $user->role }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        @if($user->status == 1)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                              Activé
                                          </span>
                                        @elseif($user->status == 0)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                              Descativé
                                          </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 font-medium">
                                        <form method="POST" action="{{ route('changeStatus', $user->id) }}">
                                            @csrf
                                            @if($user->status == 1) <button class="text-red-600 hover:text-red-900">Désactiver</button> @endif
                                            @if($user->status == 0) <button class="text-green-600 hover:text-green-900">Activer</button> @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-data = "{showModal : false}">
        <div class="fixed bottom-0 right-0 p-6">
            <div class="mt-2">
                <button x-on:click="showModal = ! showModal" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded">
                    Nouveau +
                </button>
            </div>
        </div>

        <!--Edit Modal-->

        <div x-cloak x-show="showModal"  x-on:click="showModal = false" class="modal-backdrop absolute top-0 left-0 w-full h-full bg-gray-900 opacity-70"></div>

        <div x-cloak class="block absolute top-1/2 left-1/2  h-11/12 overflow-auto bg-white rounded-2xl shadow-lg" x-show="showModal"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 transform"
             x-transition:enter-end="opacity-100 transform" x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 transform" x-transition:leave-end="opacity-0 transform"
             style="transform: translate(-50%, -50%);">
            <div class="modal-content w-11/12 md:max-w-md mx-auto rounded-lg shadow-lg z-50 overflow-y-auto w-full">
                <div class="modal-header py-2 px-6 flex flex-row justify-between">
                    <div class="text-2xl font-bold"><span x-text="studentEdit.numInscrit"></span></div>
                    <button @click="showModal = false" class="text-3xl leading-none font-bold text-gray-800 hover:text-gray-600 focus:outline-none focus:text-gray-800">×</button>
                </div>
                <div class="content flex justify-center items-center">
                    <form method="POST" action="{{ route('registerUser') }}" class="rounded-lg border shadow-md p-5 w-96 mb-5">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block font-semibold text-gray-700 mb-2">Nom d'utilisateur</label>
                            <input id="name" type="text" name="name" class="shadow border rounded w-full p-2" value="{{ old('name') }}"
                                   autocomplete="name" placeholder="Nom d'utilisateur" autofocus>
                            @error('name')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="prenom" class="block font-semibold text-gray-700 mb-2">Prenoms d'utilisateur</label>
                            <input id="prenom" type="text" name="prenom" class="shadow border rounded w-full p-2"
                                   value="{{ old('prenom') }}" autocomplete="prenom" placeholder="Prenoms d'utilisateur" autofocus>
                            @error('prenom')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block font-semibold text-gray-700 mb-2">Email</label>
                            <input id="email" type="email" name="email" class="shadow border rounded w-full p-2"
                                   value="{{ old('email') }}" autocomplete="email" placeholder="Votre email" autofocus>
                            @error('email')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block font-semibold text-gray-700 mb-2">Mot de passe</label>
                            <input id="password" type="password" name="password" class="shadow border rounded w-full p-2"
                                   value="{{ old('password') }}" autocomplete="password" placeholder="Votre mot de passe" autofocus>
                            @error('password')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block font-semibold text-gray-700 mb-2">Confirmation du mot de
                                passe</label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   class="shadow border rounded w-full p-2" value="{{ old('password_confirmation') }}"
                                   autocomplete="password_confirmation" placeholder="Retapez votre mot de passe" autofocus>
                        </div>

                        <div class="flex flex-row space-x-3">
                            <div><p for="role-select" class="font-semibold text-gray-700">Utlisateur:</p></div>
                            <div class="flex justify-between items-center">
                                <div class="bg-green-300 rounded px-2">
                                    <label for="licence">Licence
                                        <input type="radio" value="Licence" id="licence" name="role">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label for="master">Master
                                        <input type="radio" value="Master" id="master" name="role">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>

                            </div>
                            @error('role')
                            <span class="text-red-400 text-sm block">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                                class="bg-green-500 text-white hover:bg-green-700 transition ease-in-out duration-500 rounded-md shadow-md w-full block px-4 py-2 mt-3">
                            Créer
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!--End Edit Modal-->
    </div>
@endsection
