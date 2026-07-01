<div x-data ="{ open: false}" @modal-message.window="open = true" x-show="open" class="absolute top-0 left-0">
    @if($Modaltype === 'confirm')
        <div x-cloak x-show="open"
             class="modal fade fixed h-72 bottom-0 right-0 p-6 -mt-16 outline-none overflow-x-hidden overflow-y-auto"
             tabindex="-1" aria-modal="true" role="dialog"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90">
            <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-[#93c2da] bg-clip-padding rounded-md outline-none text-current">
                    <div class="modal-header text-center w-full flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-xl font-medium leading-normal text-gray-800">
                            Confirmation
                        </h5>
                    </div>
                    <div class="modal-body relative p-4">
                        <p>Il existe déja une note pour cet étudiant,</p>
                        <p>Vous voulez changer le note d'étudiant en {{ $note }}</p>
                    </div>
                    <div
                        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-center space-x-2 p-4 border-t border-gray-200 rounded-b-md">
                        <button type="button"
                                class="inline-block px-5 py-2.5 bg-green-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1"
                                wire:click="updateNote"
                                x-on:click="open = false">
                            Changer
                        </button>
                        <button type="button"
                                class="inline-block px-5 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"
                                data-bs-dismiss="modal"
                                x-on:click="open = false">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($Modaltype === 'delete')
        <div x-cloak x-show="open"
             class="modal fade fixed h-72 bottom-0 right-0 p-6 -mt-16 outline-none overflow-x-hidden overflow-y-auto"
             tabindex="-1" aria-modal="true" role="dialog"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90">
            <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-[#93c2da] bg-clip-padding rounded-md outline-none text-current">
                    <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-xl font-medium leading-normal text-gray-800">
                            Confirmation
                        </h5>
                        <button type="button"
                                class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body relative p-4">
                        <p>Souhaitez-vous vraiment supprimer cette note ?</p>
                    </div>
                    <div
                        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-center space-x-2 p-4 border-t border-gray-200 rounded-b-md">
                        <button type="button"
                                class="inline-block px-5 py-2.5 bg-green-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1"
                                wire:click="updateNote"
                                x-on:click="open = false">
                            Supprimer
                        </button>
                        <button type="button"
                                class="inline-block px-5 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"
                                data-bs-dismiss="modal"
                                x-on:click="open = false">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($Modaltype === 'deleteAttestation')
        <div x-cloak x-show="open"
             class="modal fade fixed h-72 bottom-0 right-0 p-6 -mt-16 outline-none overflow-x-hidden overflow-y-auto"
             tabindex="-1" aria-modal="true" role="dialog"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90">
            <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-[#93c2da] bg-clip-padding rounded-md outline-none text-current">
                    <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-xl font-medium leading-normal text-gray-800">
                            Confirmation
                        </h5>
                        <button type="button"
                                class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body relative p-4">
                        <p>Souhaitez-vous vraiment supprimer cette attestation ?</p>
                        <p>Numéro : {{ $numeroAttestation }}</p>
                    </div>
                    <div
                        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-center space-x-2 p-4 border-t border-gray-200 rounded-b-md">
                        <button type="button"
                                class="inline-block px-5 py-2.5 bg-green-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1"
                                wire:click="deleteAttestation"
                                x-on:click="open = false">
                            Supprimer
                        </button>
                        <button type="button"
                                class="inline-block px-5 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"
                                data-bs-dismiss="modal"
                                x-on:click="open = false">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($Modaltype === 'deleteReleve')
            <div x-cloak x-show="open"
                 class="modal fade fixed h-72 bottom-0 right-0 p-6 -mt-16 outline-none overflow-x-hidden overflow-y-auto"
                 tabindex="-1" aria-modal="true" role="dialog"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90">
                <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                    <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-[#93c2da] bg-clip-padding rounded-md outline-none text-current">
                        <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                            <h5 class="text-xl font-medium leading-normal text-gray-800">
                                Confirmation
                            </h5>
                            <button type="button"
                                    class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                    data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body relative p-4">
                            <p>Souhaitez-vous vraiment supprimer cette demande de relevé ?</p>
                            <p>Numéro {{ $numeroAttestation }}</p>
                        </div>
                        <div
                            class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-center space-x-2 p-4 border-t border-gray-200 rounded-b-md">
                            <button type="button"
                                    class="inline-block px-5 py-2.5 bg-green-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1"
                                    wire:click="deleteAttestation"
                                    x-on:click="open = false">
                                Supprimer
                            </button>
                            <button type="button"
                                    class="inline-block px-5 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"
                                    data-bs-dismiss="modal"
                                    x-on:click="open = false">
                                Annuler
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @if($Modaltype === 'deleteUE')
        <div x-cloak x-show="open"
             class="modal fade fixed h-72 bottom-0 right-0 p-6 -mt-16 outline-none overflow-x-hidden overflow-y-auto"
             tabindex="-1" aria-modal="true" role="dialog"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90">
            <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-[#93c2da] bg-clip-padding rounded-md outline-none text-current">
                    <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-xl font-medium leading-normal text-gray-800">
                            Confirmation
                        </h5>
                        <button type="button"
                                class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body relative p-4">
                        <p>Souhaitez-vous vraiment supprimer cet Unité d'enseignement ?</p>
                    </div>
                    <div
                        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-center space-x-2 p-4 border-t border-gray-200 rounded-b-md">
                        <button type="button"
                                class="inline-block px-5 py-2.5 bg-green-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1"
                                wire:click="updateNote"
                                x-on:click="open = false">
                            Confirmer
                        </button>
                        <button type="button"
                                class="inline-block px-5 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"
                                data-bs-dismiss="modal"
                                x-on:click="open = false">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($Modaltype === 'deleteMat')
        <div x-cloak x-show="open"
             class="modal fade fixed h-72 bottom-0 right-0 p-6 -mt-16 outline-none overflow-x-hidden overflow-y-auto"
             tabindex="-1" aria-modal="true" role="dialog"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90">
            <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-[#93c2da] bg-clip-padding rounded-md outline-none text-current">
                    <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-xl font-medium leading-normal text-gray-800">
                            Confirmation
                        </h5>
                        <button type="button"
                                class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body relative p-4">
                        <p>Souhaitez-vous vraiment supprimer cette matière?</p>
                    </div>
                    <div
                        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-center space-x-2 p-4 border-t border-gray-200 rounded-b-md">
                        <button type="button"
                                class="inline-block px-5 py-2.5 bg-green-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1"
                                wire:click="updateNote"
                                x-on:click="open = false">
                            Confirmer
                        </button>
                        <button type="button"
                                class="inline-block px-5 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"
                                data-bs-dismiss="modal"
                                x-on:click="open = false">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($Modaltype === 'deleteStudent')
        <div x-cloak x-show="open"
             class="modal fade fixed h-72 bottom-0 right-0 p-6 -mt-16 outline-none overflow-x-hidden overflow-y-auto"
             tabindex="-1" aria-modal="true" role="dialog"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90">
            <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-[#93c2da] bg-clip-padding rounded-md outline-none text-current">
                    <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-xl font-medium leading-normal text-gray-800">
                            Confirmation
                        </h5>
                        <button type="button"
                                class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body relative p-4">
                        <p>Souhaitez-vous vraiment effacer cet étudiant de ce niveau?</p>
                    </div>
                    <div
                        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-center space-x-2 p-4 border-t border-gray-200 rounded-b-md">
                        <button type="button"
                                class="inline-block px-5 py-2.5 bg-green-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1"
                                wire:click="updateNote"
                                x-on:click="open = false">
                            Confirmer
                        </button>
                        <button type="button"
                                class="inline-block px-5 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"
                                data-bs-dismiss="modal"
                                x-on:click="open = false">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($Modaltype === 'deleteAdmis')
            <div x-cloak x-show="open"
                 class="modal fade fixed h-72 bottom-0 right-0 p-6 -mt-16 outline-none overflow-x-hidden overflow-y-auto"
                 tabindex="-1" aria-modal="true" role="dialog"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90">
                <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                    <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-[#93c2da] bg-clip-padding rounded-md outline-none text-current">
                        <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                            <h5 class="text-xl font-medium leading-normal text-gray-800">
                                Confirmation
                            </h5>
                            <button type="button"
                                    class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                    data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body relative p-4">
                            <p>Voulez-vous vraiment supprimer la liste des admis de ce niveau ?</p>
                        </div>
                        <div
                            class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-center space-x-2 p-4 border-t border-gray-200 rounded-b-md">
                            <button type="button"
                                    class="inline-block px-5 py-2.5 bg-green-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1"
                                    wire:click="deleteAdmis"
                                    x-on:click="open = false">
                                Confirmer
                            </button>
                            <button type="button"
                                    class="inline-block px-5 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"
                                    data-bs-dismiss="modal"
                                    x-on:click="open = false">
                                Annuler
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($Modaltype === 'archiveCdt')
            <div x-cloak x-show="open"
                 class="modal fade fixed h-72 bottom-0 right-0 p-6 -mt-16 outline-none overflow-x-hidden overflow-y-auto"
                 tabindex="-1" aria-modal="true" role="dialog"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90">
                <div class="modal-dialog modal-dialog-centered relative w-auto pointer-events-none">
                    <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-[#93c2da] bg-clip-padding rounded-md outline-none text-current">
                        <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                            <h5 class="text-xl font-medium leading-normal text-gray-800">
                                Confirmation
                            </h5>
                            <button type="button"
                                    class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                    data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body relative p-4">
                            <p>Souhaitez-vous vraiment archiver la liste des archives de ce niveau ?</p>
                        </div>
                        <div
                            class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-center space-x-2 p-4 border-t border-gray-200 rounded-b-md">
                            <button type="button"
                                    class="inline-block px-5 py-2.5 bg-green-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1"
                                    wire:click="updateNote"
                                    x-on:click="open = false">
                                Confirmer
                            </button>
                            <button type="button"
                                    class="inline-block px-5 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out"
                                    data-bs-dismiss="modal"
                                    x-on:click="open = false">
                                Annuler
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
</div>
