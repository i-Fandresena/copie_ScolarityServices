<div class="content">
    <div class="content_header">
        <div class="content_header_right" x-data="{showYear: false}">
            <div>
                <input type="text" class="shadow border search_input p-2" placeholder="recherche..." wire:model.debounce.700ms="search" wire:keydown.enter = "increment" >
            </div>
            <div class="btn_search">
                <select wire:model="niveau" x-on:change="showPay = ''" class="shadow w-16 border rounded p-2 bg-white">
                    @if(Auth()->user()->role === 'Licence')
                        <option value="L1">L1</option>
                        <option value="L2">L2</option>
                        <option value="L3">L3</option>
                    @endif
                    @if(Auth()->user()->role === 'Master')
                        <option >M1</option>
                        <option >M2</option>
                        <option >MR</option>
                    @endif
                </select>

            </div>
            <div class="ml-32 mr-3 mt-2" >
                <input type="checkbox" value="archive"  wire:model="archive" wire:click="resetIndex" x-model="showYear" x-on:click="showInfo = false">
                <span class="checkmark"> Archives </span>
            </div>
            <div x-cloak x-show="showYear">
{{--                <input wire:model="year" placeholder="année" class="shadow border rounded p-2 w-1/2">--}}
                <select wire:model="year" class="shadow w-18 border rounded p-2 bg-white">
                    <option selected  value=""> xxxx </option>
                    @foreach($annees as $annee)
                        <option value="{{ $annee->anneeUnivers }}">{{ $annee->anneeUnivers }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="content_header_left">

        </div>

    </div>

    <hr>

    <div>
        {{--start onglet--}}
        <div class="md:grid md:grid-cols-2 md:gap-6 w-full">
            <div @if(Auth()->user()->role === 'Licence') x-data="{ tab: 'tab2' }" @else x-data="{ tab: 'tab1' }"  @endif  class="mt-5 md:col-span-2 md:mt-0 ml-5">
                <div class="flex">
                    @if(Auth()->user()->role === 'Master')
                        <button class="px-4 py-2 mr-2 text-gray-700 hover:text-gray-900" x-bind:class="{ 'bg-gray-200': tab === 'tab1' }" x-on:click="tab = 'tab1'">Attestation</button>
                    @endif
                    <button class="px-4 py-2 mr-2 text-gray-700 hover:text-gray-900" x-bind:class="{ 'bg-gray-200': tab === 'tab2' }" x-on:click="tab = 'tab2'">Relevé de note</button>
                    <button class="px-4 py-2 mr-2 text-gray-700 hover:text-gray-900" x-bind:class="{ 'bg-gray-200': tab === 'tab3' }" x-on:click="tab = 'tab3'">Justificatif Bordereau</button>
                    @if(Auth()->user()->role === 'Master')
                        <button class="px-4 py-2 mr-2 text-gray-700 hover:text-gray-900" x-bind:class="{ 'bg-gray-200': tab === 'tab4' }" x-on:click="tab = 'tab4'">Liste attestation</button>
                    @endif
                    <button class="px-4 py-2 mr-2 text-gray-700 hover:text-gray-900" x-bind:class="{ 'bg-gray-200': tab === 'tab5' }" x-on:click="tab = 'tab5'">Liste relevé</button>
                </div>
                @if(Auth()->user()->role === "Master")
                    <div x-show="tab === 'tab1'" class="w-full">
                        {{--                    attestation                   --}}
                        <div class="md:col-span-1 w-full">
                            @include('livewire.certificate.export-attestation')
                        </div>
                    </div>
                @endif

                <div x-show="tab === 'tab2'" class="w-full">
                    {{--                    releve de note                   --}}
                    <div class="md:col-span-1 w-full">
                        @include('livewire.certificate.export-relever')
                    </div>
                </div>

                <div x-cloak x-show="tab === 'tab3'" class="w-full">
                    {{--                    bordereau                   --}}
                    <div class="md:col-span-1 w-full">
                        @include('livewire.certificate.export-bordereau')
                    </div>
                </div>

                @if(Auth()->user()->role === "Master")
                    <div x-cloak x-show="tab === 'tab4'" class="w-full">
                        {{--                    liste attestation                   --}}
                        <div class="md:col-span-1 w-full">
                            @include('livewire.certificate.attestation-list')
                        </div>
                    </div>
                @endif

                <div x-cloak x-show="tab === 'tab5'" class="w-full">
                    {{--                    liste releve                   --}}
                    <div class="md:col-span-1 w-full">
                        @include('livewire.certificate.releve-list')
                    </div>
                </div>
            </div>
        </div>
        {{--end onglet--}}
    </div>
</div>
