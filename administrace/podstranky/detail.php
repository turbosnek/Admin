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
        header('Location: index.php?stranka=vypisZamestnancu');
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
?>

<H1>Detail zaměstnance</H1>

<?php
    echo ('<center><strong><H2><u>' . htmlspecialchars($nactenyZamestnanec['jmeno']) . ' ' . htmlspecialchars($nactenyZamestnanec['prijmeni']) . '</u></H2></strong></center>');
    
    /* Do tabulky vypíšeme údaje o zaměstnanci */
    echo ('<table id="zamestnanci">');
    echo ('<tr><td><strong><u>Jméno:</u></strong></td><td>' . htmlspecialchars($nactenyZamestnanec['jmeno']) . '</td></tr>');
    echo ('<tr><td><strong><u>Příjmení:</u></strong></td><td>' . htmlspecialchars($nactenyZamestnanec['prijmeni']) . '</td></tr>');
    echo ('<tr><td><strong><u>Osobní číslo:</u></strong></td><td>' . htmlspecialchars($nactenyZamestnanec['osobni_cislo']) . '</td></tr>');
    echo ('<tr><td><strong><u>Adresa:</u></strong></td><td>' . htmlspecialchars($nactenyZamestnanec['adresa']) . '</td></tr>');
    echo ('<tr><td><strong><u>Telefonní číslo:</u></strong></td><td>' . htmlspecialchars($nactenyZamestnanec['telefon']) . '</td></tr>');
    $datumNarozeni = date("d.m.Y", strtotime($nactenyZamestnanec['datum_narozeni'])); // Převedeme databázové datum na naše datum
    echo ('<tr><td><strong><u>Datum narození:</u></strong></td><td>' . htmlspecialchars($datumNarozeni) . '</td></tr>');
    echo ('<tr><td><strong><u>Pracovní pozice:</u></strong></td><td>' . htmlspecialchars($nactenyZamestnanec['pracovni_pozice']) . '</td></tr>');
    echo ('<tr><td><strong><u>Hodinová mzda:</u></strong></td><td>' . htmlspecialchars($nactenyZamestnanec['hodinova_mzda']) . '</td></tr>');
    
    /* Pokud je řihlášenej administrátor s právama, zobrazíme mu možnost editovat a mazat zaměstnance */
    if (!empty($_SESSION['uzivatel_admin']))
        echo ('<tr><td><a href="index.php?stranka=editor&zamestnanci_id=' . htmlspecialchars($zamestnanec['zamestnanci_id']) .'">Editovat</a></td>
                <td><a href="index.php?stranka=detail&odstranit=' . htmlspecialchars($nactenyZamestnanec['zamestnanci_id']) . '">Odtranit</a>
                    ');
    echo ('</td></tr>');
    echo ('</table>');
    
    
?>