<div class="content">
    <div class="content_header">
        <div class="content_header_right">
            <div>
                <input type="text" class="shadow border search_input p-2" placeholder="recherche...">
            </div>
        </div>

        <div class="content_header_left">

        </div>

    </div>

    <hr>

    <div>
        {{--start onglet--}}
        <div class="md:grid md:grid-cols-2 md:gap-6 w-full">
            <div x-data="{ tab: 'tab1' }" class="mt-5 md:col-span-2 md:mt-0 ml-5">
                <div class="flex">
                    <button class="px-4 py-2 mr-2 text-gray-700 hover:text-gray-900" x-bind:class="{ 'bg-gray-200': tab === 'tab1' }" x-on:click="tab = 'tab1'">Candidats</button>
                    <button class="px-4 py-2 mr-2 text-gray-700 hover:text-gray-900" x-bind:class="{ 'bg-gray-200': tab === 'tab2' }" x-on:click="tab = 'tab2'">Étudiants</button>
                    <button class="px-4 py-2 mr-2 text-gray-700 hover:text-gray-900" x-bind:class="{ 'bg-gray-200': tab === 'tab3' }" x-on:click="tab = 'tab3'">Notes</button>
                    <button class="px-4 py-2 mr-2 text-gray-700 hover:text-gray-900" x-bind:class="{ 'bg-gray-200': tab === 'tab4' }" x-on:click="tab = 'tab4'">Model Excel</button>
                </div>
                <div x-show="tab === 'tab1'" class="w-full">
                    {{--                    candidat                   --}}
                    <div class="md:col-span-1 w-full">
                        @livewire('export.export-candidat')
                    </div>
                </div>

                <div x-cloak x-show="tab === 'tab2'" class="w-full">
                    {{--                    etudiants                   --}}
                    <div class="md:col-span-1 w-full">
                        @livewire('export.export-etudiant')
                    </div>
                </div>

                <div x-cloak x-show="tab === 'tab3'" class="w-full">
                    {{--                    notes                   --}}
                    <div class="md:col-span-1 w-full">
                        @livewire('export.export-note')
                    </div>
                </div>
                <div x-cloak x-show="tab === 'tab4'" class="w-full">
                    {{--                    model excel                   --}}
                    <div class="md:col-span-1 w-full">
                        @livewire('export.export-model')
                    </div>
                </div>
            </div>
        </div>
        {{--end onglet--}}
    </div>
</div>

<script>
    document.getElementById('check-all-btn-1').addEventListener('click', function () {
        let checkboxes = document.querySelectorAll('.my_check1');
        for (let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });

    document.getElementById('check-all-btn-2').addEventListener('click', function () {
        let checkboxes = document.querySelectorAll('.my_check2');
        for (let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });
</script>
