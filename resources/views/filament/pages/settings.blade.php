{{-- <x-filament-panels::page> --}}
    <x-filament::page>
        <form wire:submit="save">
            {{ $this->form }}

            <div style="margin-top:25px;">
                <x-filament::button form="save" type="submit">
                    Save Changes
                </x-filament::button>
            </div>
        </form>
    </x-filament::page>
{{-- </x-filament-panels::page> --}}
