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

/*******************************************************************
 * Načteme zaměstnance podle osobního čísla, roku a měsíce docházky
 ******************************************************************/
if (isset($_GET['osobni_cislo']) || isset($_GET['rok']) || isset($_GET['mesic']))
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

    $nactenaDochazkaMesic = Db::queryOne('
            SELECT mesic
            FROM dochazka
            WHERE mesic=?
        ', $_GET['mesic']);

    $nactenaDochazka = Db::queryAll('
            SELECT *
            FROM dochazka
            WHERE osobni_cislo=? AND rok=? AND mesic=?
        ', $_GET['osobni_cislo'], $_GET['rok'], $_GET['mesic']);
}
?>

    <H1>Docházka zaměstnance za rok <?= htmlspecialchars($nactenaDochazkaRok['rok']) ?> a měsíc <?= htmlspecialchars($nactenaDochazkaMesic['mesic']) ?></H1>
    <center><H2><u><?= htmlspecialchars($nactenyZamestnanec['jmeno']) . ' ' . htmlspecialchars($nactenyZamestnanec['prijmeni']) ?> </u></H2></center>