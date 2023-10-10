<div class="text-sm">
    @php
        use carbon\carbon;

        $returnArray = [];
        $number=0;
        for ($i= 0; $i < count($getRecord()->Montant); $i++){

            $returnArray [] =  number_format($getRecord()->Montant[$i]['valeur'], 0, '.', '.');
        }
    @endphp

        {{ implode(" , ", $returnArray )}}

</div>
