<?php

    /* Funkce pro overeni admina pro editovaní údajů zaměstnance */
function editujZamestnance()
{
    if (!empty($_SESSION['uzivatel_admin']))
    {
        $editovat = 'index.php?stranka=editor_zamestnance&zamestnanci_id=';

        return $editovat;
    }
}

/* Funkce pro overeni admina pro smazání zaměstnance zaměstnance */
function vymazZamestnance()
{
    if (!empty($_SESSION['uzivatel_admin']))
    {
        $odstranit = 'index.php?stranka=detail_zamestnance&odstranit=';

        return $odstranit;
    }
}
