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
    
    /* Obslužný blok pro odstranění zaměstnance */
    if (isset($_GET['odstranit']) && !empty($_SESSION['uzivatel_admin']))
    {
        Db::query('
            DELETE FROM zamestnanci
            WHERE zamestnanci_id=?
        ', $_GET['odstranit']);
        header('Location: index.php?stranka=vypis_zamestnancu');
        exit();
    }
    
    /* Načteme zaměstnance z databáze pomocí jeho ID */
    if (isset($_GET['zamestnanci_id']))
    {
        $nactenyZamestnanec = Db::queryOne('
            SELECT *
            FROM zamestnanci
            WHERE zamestnanci_id=?
        ', $_GET['zamestnanci_id']);
        if ($nactenyZamestnanec)
            $zamestnanec = $nactenyZamestnanec;
        else
            $zprava = 'Zaměstnanec nebyl nalezen';
    }
    
    $datumNarozeni = ceskeDatumNarozeni($nactenyZamestnanec); // Převedeme databázové datum na naše datum
    $datumNastupu = ceskeDatumNastupu($nactenyZamestnanec); // Převedeme databázové datum na naše datum
?>

<H1>Detail zaměstnance</H1>

<center><H2><u><?= htmlspecialchars($nactenyZamestnanec['jmeno']) . ' ' . htmlspecialchars($nactenyZamestnanec['prijmeni']) ?> </u></H2></center>

<table id="zamestnanci">
    <tr>
        <td><strong>Jméno:</strong></td>
        <td><center><?= htmlspecialchars($nactenyZamestnanec['jmeno']) ?></center></td>
    </tr>
    <tr>
        <td><strong>Příjmení:</strong></td>
        <td><center><?= htmlspecialchars($nactenyZamestnanec['prijmeni']) ?></center></td>
    </tr>
    <tr>
        <td><strong>Osobní číslo:</strong></td>
        <td><center><?= htmlspecialchars($nactenyZamestnanec['osobni_cislo']) ?></center></td>
    </tr>
    <tr>
        <td><strong>Adresa:</strong></td>
        <td><center><?= htmlspecialchars($nactenyZamestnanec['adresa']) ?></center></td>
    </tr>
    <tr>
        <td><strong>Telefon:</strong></td>
        <td><center><?= htmlspecialchars($nactenyZamestnanec['telefon']) ?></center></td>
    </tr>
    <tr>
        <td><strong>Datum narození:</strong></td>
        <td><center><?= htmlspecialchars($datumNarozeni) ?></center></td>
    </tr>
    <tr>
        <td><strong>Datum nástupu:</strong></td>
        <td><center><?= htmlspecialchars($datumNastupu) ?></center></td>
    </tr>
    <tr>
        <td><strong>Pracovní pozice:</strong></td>
        <td><center><?= htmlspecialchars($nactenyZamestnanec['pracovni_pozice']) ?></center></td>
    </tr>
    <tr>
        <td><strong>Hodinová mzda:</strong></td>
        <td><center><?= htmlspecialchars($nactenyZamestnanec['hodinova_mzda']) ?></center></td>
    </tr>
    <tr>
        <td><a href="<?= editujZamestnance() . htmlspecialchars($zamestnanec['zamestnanci_id']) ?>">Editovat</a></td>
        <td><a href="<?= vymazZamestnance() . htmlspecialchars($nactenyZamestnanec['zamestnanci_id']) ?>">Odstranit</a></td>
    </tr>
</table>