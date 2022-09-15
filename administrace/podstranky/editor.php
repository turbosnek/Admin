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
    
    $zprava = '';
    
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

<H1>Aktualizace údajů zaměstnance</H1>

<?php
    echo ('<center><strong><H2><u>' . htmlspecialchars($nactenyZamestnanec['jmeno']) . ' ' . htmlspecialchars($nactenyZamestnanec['prijmeni']) . '</u></H2></strong></center>');
?>

<?php
    if ($zprava)
    {
        echo('<p>' . htmlspecialchars($zprava) . '</p>');
    }

    /**
     * Pokud je něco špatně vyplněno, nevymaže se nám formulář
     */
    $jmeno = $nactenyZamestnanec = isset(($_POST['jmeno'])) ? $_POST['jmeno'] : '';
    $prijmeni = isset(($_POST['prijmeni'])) ? $_POST['prijmeni'] : '';
    $osobniCislo = isset(($_POST['osobni_cislo'])) ? $_POST['osobni_cislo'] : '';
    $adresa = isset(($_POST['adresa'])) ? $_POST['adresa'] : '';
    $telefon = isset(($_POST['telefon'])) ? $_POST['telefon'] : '';
    $datumNarozeni = isset(($_POST['datum_narozeni'])) ? $_POST['datum_narozeni'] : '';
    $datumNastupu = isset(($_POST['datum_nastupu'])) ? $_POST['datum_nastupu'] : '';
    $pracovniPozice = isset(($_POST['pracovni_pozice'])) ? $_POST['pracovni_pozice'] : '';
    $hodinovaMzda = isset(($_POST['hodinova_mzda'])) ? $_POST['hodinova_mzda'] : '';
?>
<form method="POST">
    <table id="zamestnanci">
        <tr>
            <td>Jméno: </td>
            <td><input type="text" name="jmeno" value="<?= htmlspecialchars($jmeno) ?>" /></td>
        </tr>
        <tr>
            <td>Příjmení: </td>
            <td><input type="text" name="prijmeni" value="<?= htmlspecialchars($prijmeni['prijmeni']) ?>" /></td>
        </tr>
        <tr>
            <td>Osobní číslo: </td>
            <td><input type="text" name="osobni_cislo" value="<?= htmlspecialchars($osobniCislo['osobni_cislo']) ?>" /></td>
        </tr>
        <tr>
            <td>Adresa: </td>
            <td><textarea cols="37" rows="7" name="adresa"><?= htmlspecialchars($adresa['adresa']) ?></textarea></td>
        </tr>
        <tr>
            <td>Telefonní číslo: </td>
            <td><input type="text" name="telefon" value="<?= htmlspecialchars($telefon['telefon']) ?>" /></td>
        </tr>
        <tr>
            <td>Datum narození: </td>
            <td><input type="text" name="datum_narozeni" value="<?= htmlspecialchars($datumNarozeni['datum_narozeni']) ?>" /></td>
        </tr>
        <tr>
            <td>Datum nástupu: </td>
            <td><input type="text" name="datum_nastupu" value="<?= htmlspecialchars($datumNastupu['datum_nastupu']) ?>" /></td>
        </tr>
        <tr>
            <td>Pracovní pozice: </td>
            <td><input type="text" name="pracovni_pozice" value="<?= htmlspecialchars($pracovniPozice['pracovni_pozice']) ?>" /></td>
        </tr>
        <tr>
            <td>Hodinová mzda: </td>
            <td><input type="text" name="hodinova_mzda" value="<?= htmlspecialchars($hodinovaMzda['hodinova_mzda']) ?>" /></td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="Aktualizovat údaje" />
            </td>
        </tr>
    </table>
</form>