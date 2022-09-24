<?php

    /* Funkce pro výpis zaměstnanců do rozbalovacího seznamu */
    function zamestnanci($zamestnanci)
    {
        foreach ($zamestnanci as $zamestnani)
        {
            echo ('<option value="jmeno">' . htmlspecialchars($zamestnani['jmeno']) . ' ' . htmlspecialchars($zamestnani['prijmeni']) . '</option>');
        }
    }

    /* Funkce pro výpis měsíců do rozbalovacího menu */
    function mesice()
    {
        $mesice = array('Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen', 'Červenec', 'Srpen', 'Září', 'Řijen', 'Listopad', 'Prosinec');

        foreach ($mesice as $mesic)
        {
            echo ('<option value="mesic">' . htmlspecialchars($mesic) . '</option>');
        }
    }

    /* Funkce pro výpis dnů v měsíci do rozbalovacího menu */
    function dny()
    {
        $dny = array();

        for ($i = 1; $i < 32; $i++) // Naplníme pole číslama dnů
        {
            $dny[] = $i;
        }

        foreach ($dny as $den)
        {
            echo ('<option value="den">' . htmlspecialchars($den) . '</option>');
        }
    }