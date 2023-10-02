
@php
    use App\Models\commission_xpress ;
    $commissionXpress=commission_xpress::first()->value('Montant');
@endphp
<x-filament-widgets::widget>
    <x-filament::section>
        <h1 class="text-5xl text-slate-400">Total commissions</h1>
        <p class="text-xl">{{$commissionXpress}}</p>
    </x-filament::section>
</x-filament-widgets::widget>
