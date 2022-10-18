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

        $nactenaDochazka = Db::queryAll('
            SELECT DISTINCT rok
            FROM dochazka
            WHERE osobni_cislo=?
        ', $_GET['osobni_cislo']);
    }
?>

<H1>Docházka zaměstnance</H1>

<center><H2><u><?= htmlspecialchars($nactenyZamestnanec['jmeno']) . ' ' . htmlspecialchars($nactenyZamestnanec['prijmeni']) ?> </u></H2></center>

<?php
    foreach ($nactenaDochazka as $dochazka)
    {
        echo ('<a href="index.php?stranka=dochazka_rok&osobni_cislo=' . htmlspecialchars($nactenyZamestnanec['osobni_cislo']) . '&rok=' . htmlspecialchars($dochazka['rok']) . '">' . htmlspecialchars($dochazka['rok']) . '<br /></a>');
    }
?>