<div x-data="{showProcess: false}" x-cloak @show-process.window="showProcess = true" @hide-process.window="showProcess = false" class="w-full h-full">
    <div x-show="showProcess" class="modal-backdrop absolute top-0 left-0 w-full h-full bg-black opacity-80">
        <div class="flex items-center justify-center w-full h-full">
            <img style="width: 20%; height: auto" style="top: 50%; left: 50%; transform: translate(-50%, -50%);" src="/images/animation.gif">
        </div>
    </div>
</div>
