<div>
    <x-filament::breadcrumbs :breadcrumbs="[
        '/admin/users' => 'Users',
        '' => 'List',
    ]" />
    <div class="flex justify-between mt-1">
        <div class="font-bold text-3xl">Users</div>
        <div>
            {{ $data }}
        </div>
    </div>
    <div>
        <form wire:submit="save" class="w-full max-w-sm flex mt-2">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="fileInput">
                    CSV Upload Users
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus: shadow-out line pr-4" id="fileInput" type="file" wire:model='file'>
            </div>
            <div class="flex items-center justify-between mt-3">
                <button class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-primary fi-btn-color-primary fi-size-md fi-btn-size-md gap-1.5 px-3.5 py-3.5 text-sm inline-grid shadow-sm bg-primary-600 text-white hover:bg-primary-500 dark:bg-primary-500 dark:hover:bg-primary-400 focus-visible:ring-primary-500/50 dark:focus-visible:ring-primary-400/50 fi-ac-btn-action" type="submit">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>
