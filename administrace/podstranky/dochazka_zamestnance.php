<?php
    if (!isset($_SESSION['uzivatel_id']))
    {
        header('Location: ../index.php'); // Pokud není uživatel přihlášenej, přesměrujeme ho na přihlášení
        exit();
    }

    if (isset($_GET['odhlasit']))
    {
        session_destroy();
        header('Location: ../index.php'); // Po odhlášení přesměrujeme na přihlášení
        exit();
    }

    /* Načteme zaměstnance z databáze pomocí jeho osobniho_cisla */
    if (isset($_GET['osobni_cislo']))
    {
        $nactenyZamestnanec = Db::queryOne('
                SELECT *
                FROM zamestnanci
                WHERE osobni_cislo=?
            ', $_GET['osobni_cislo']);
        if ($nactenyZamestnanec)
            $zamestnanec = $nactenyZamestnanec;
        else
            $zprava = 'Zaměstnanec nebyl nalezen';
    }
?>

<H1>Docházka zaměstnance</H1>

<center><H2><u><?= htmlspecialchars($nactenyZamestnanec['jmeno']) . ' ' . htmlspecialchars($nactenyZamestnanec['prijmeni']) ?> </u></H2></center>
