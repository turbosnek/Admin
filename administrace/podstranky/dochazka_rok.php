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

    /***********************************************************
     * Načteme zaměstnance podle osobního čísla a rok docházky
     *********************************************************/
    if (isset($_GET['osobni_cislo']) || isset($_GET['rok']))
    {
        $nactenyZamestnanec = Db::queryOne('
                    SELECT *
                    FROM zamestnanci
                    WHERE osobni_cislo=?
                ', $_GET['osobni_cislo']);

        $nactenaDochazkaRok = DB::queryOne('
                SELECT rok
                FROM dochazka
                WHERE rok=?
            ', $_GET['rok']);

        $nactenaDochazka = Db::queryAll('
            SELECT DISTINCT mesic
            FROM dochazka
            WHERE osobni_cislo=? AND rok=?
        ', $_GET['osobni_cislo'], $_GET['rok']);
    }
?>

<H1>Docházka zaměstnance za rok <?= htmlspecialchars($nactenaDochazkaRok['rok']) ?></H1>
<center><H2><u><?= htmlspecialchars($nactenyZamestnanec['jmeno']) . ' ' . htmlspecialchars($nactenyZamestnanec['prijmeni']) ?> </u></H2></center>

<?php
    foreach ($nactenaDochazka as $dochazka)
    {
        echo (htmlspecialchars($dochazka['mesic']) . '<br />');
    }
?>
