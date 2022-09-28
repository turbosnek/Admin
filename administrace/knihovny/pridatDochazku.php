<?php
    /* Funkce pro přidání měsíce do docházky jako rozbalovací seznam */
    function mesic()
    {
        $mesice = array('Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen', 'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec');

        foreach($mesice as $mesic)
        {
            echo('<option>' . $mesic . '</option>');
        }
    }
