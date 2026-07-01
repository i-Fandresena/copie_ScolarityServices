@extends('layouts.app')

@section('content')
    <div class="p-0 content" x-data="{dataDroit: {typeDroit: '', montantDroit: ''}, data: {nom: '{{ Auth()->user()->name }}', prenom: '{{ Auth()->user()->prenom }}', email: '{{ Auth()->user()->email }}'}, showNew: false, showNewM: false}">
        <div class="p-2 bg-white shadow mt-24">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="grid grid-cols-3 text-center order-last md:order-first mt-20 md:mt-0">
                    @if(Auth()->user()->role === 'Licence')
                        <div><p class="font-bold text-gray-700 text-xl">{{ $l1 }}</p>
                            <p class="text-gray-400">L1</p></div>
                        <div><p class="font-bold text-gray-700 text-xl">{{ $l2 }}</p>
                            <p class="text-gray-400">L2</p></div>
                        <div><p class="font-bold text-gray-700 text-xl">{{ $l3 }}</p>
                            <p class="text-gray-400">L3</p></div>
                    @elseif(Auth()->user()->role === 'Master')
                        <div><p class="font-bold text-gray-700 text-xl">{{ $m1 }}</p>
                            <p class="text-gray-400">M1</p></div>
                        <div><p class="font-bold text-gray-700 text-xl">{{ $m2 }}</p>
                            <p class="text-gray-400">M2</p></div>
                    @endif
                </div>
                <div class="relative">
                    <div class="w-40 h-40 bg-indigo-100 mx-auto rounded-full shadow-2xl absolute inset-x-0 top-0 -mt-24 flex items-center justify-center text-indigo-500">
                            @if(Auth::user()->images != 'default.jpg')
                                <img class="w-full h-full rounded-full object-cover" src="/storage/{{ Auth::user()->images }}" alt="">
                            @else
                                <img class="w-full h-full rounded-full object-cover" src="/images/{{ Auth::user()->images }}" alt="">
                            @endif
                    </div>
                </div>
                <div class="space-x-8 flex justify-between mt-32 md:mt-0 md:justify-center">
                    <form method="POST" action="{{ route('user.profile.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <label for="images"
                               class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 ">
                            <span>Importer une images </span>
                            <input id="images" type="file"
                                   class="sr-only form-control @error('images') is-invalid @enderror" name="images"
                                   value="{{ old('images') }}" required autocomplete="images">
                        </label>
                        <button
                            class="text-white py-2 px-4 uppercase rounded bg-gray-700 hover:bg-gray-800 shadow hover:shadow-lg font-medium transition transform hover:-translate-y-0.5"
                            type="submit">
                            Changer
                        </button>
                    </form>
                </div>
            </div>
            <div class="mt-20 text-center border-b pb-4">
                <h1 class="text-4xl font-medium text-gray-700">{{ Auth::user()->name}}</h1>
                <p class="font-light text-gray-600 mt-3">{{ Auth::user()->prenom }}</p>
                <p class="mt-8 text-gray-500">Responsable - {{ Auth::user()->role }}</p>
            </div>
            {{--start onglet--}}
            <div class="md:grid md:grid-cols-2 md:gap-6 w-full">
                <div x-data="{ tab: 'tab1' }" class="mt-5 md:col-span-2 md:mt-0 ml-5">
                    <div class="flex">
                        <button class="px-4 py-2 mr-2 text-gray-700 hover:text-gray-900" x-bind:class="{ 'bg-gray-200': tab === 'tab1' }" x-on:click="tab = 'tab1'">Information d'utilisateur</button>
                        <button class="px-4 py-2 mr-2 text-gray-700 hover:text-gray-900" x-bind:class="{ 'bg-gray-200': tab === 'tab2' }" x-on:click="tab = 'tab2'">Gestion de mot de passe</button>
                        <button class="px-4 py-2 mr-2 text-gray-700 hover:text-gray-900" x-bind:class="{ 'bg-gray-200': tab === 'tab3' }" x-on:click="tab = 'tab3'">Liste de matières</button>
                        <button class="px-4 py-2 mr-2 text-gray-700 hover:text-gray-900" x-bind:class="{ 'bg-gray-200': tab === 'tab4' }" x-on:click="tab = 'tab4'">Droits</button>
                        <button class="px-4 py-2 mr-2 text-gray-700 hover:text-gray-900" x-bind:class="{ 'bg-gray-200': tab === 'tab5' }" x-on:click="tab = 'tab5'">Gestion admis</button>
                        <button class="px-4 py-2 mr-2 text-gray-700 hover:text-gray-900" x-bind:class="{ 'bg-gray-200': tab === 'tab6' }" x-on:click="tab = 'tab6'">Gestion des archives</button>
                    </div>

                    <div x-show="tab === 'tab1'" class="w-full">
                        {{--                    information user                   --}}
                        @if (Auth::check())
                            <div>
                                @livewire('profile.edit-profile')
                            </div>
                        @endif
                    </div>

                    <div x-show="tab === 'tab2'" class="w-full">
                        {{--                    confirmation mdp                   --}}
                        <div class="md:col-span-1 w-full">
                            @if (Auth::check())
                                <div>
                                    @livewire('profile.update-password')
                                </div>
                            @endif

                        </div>
                    </div>

                    <div x-show="tab === 'tab3'" class="w-full">
                        {{--                    gestion de matieres                   --}}
                        <div class="md:col-span-1 w-full">
                            @livewire('profile.gestion-matiere')
                        </div>
                    </div>

                    <div x-show="tab === 'tab4'" class="w-full">
                        {{--                    gestion de droit                   --}}
                        <div class="md:col-span-1 w-full">
                            @livewire('profile.gestion-droit')
                        </div>
                    </div>

                    <div x-show="tab === 'tab5'" class="w-full">
                        {{--                    gestion de admis                   --}}
                        <div class="md:col-span-1 w-full">
                            @livewire('profile.gestion-admis')
                        </div>
                    </div>

                    <div x-show="tab === 'tab6'" class="w-full">
                        {{--                    gestion des archives                   --}}
                        <div class="md:col-span-1 w-full">
                            @livewire('profile.gestion-archive')
                        </div>
                    </div>
                </div>
            </div>
            {{--end ongle--}}
        </div>
    </div>


@endsection
