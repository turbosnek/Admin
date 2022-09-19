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
    
    $datumNarozeni = date("d.m.Y", strtotime($nactenyZamestnanec['datum_narozeni'])); // Převedeme databázové datum na naše datum
    $datumNastupu = date("d.m.Y", strtotime($nactenyZamestnanec['datum_nastupu'])); // Převedeme databázové datum na naše datum
    
    $zprava = '';
    
    if ($_POST) // V poli _POST něco je, odeslal se formulář
    {
        $datumNarozeni = date("Y-m-d:s", strtotime($_POST['datum_narozeni'])); // Převedeme datum na databázový formát
        $datumNastupu = date("Y-m-d:s", strtotime($_POST['datum_nastupu'])); // Převedeme datum na databázový formát
        
        /* Odešleme formulář do databáze a aktualizujeme údaje */
        Db::query('
                UPDATE zamestnanci
                SET jmeno=?, prijmeni=?, osobni_cislo=?, adresa=?, telefon=?, datum_narozeni=?, datum_nastupu=?, pracovni_pozice=?, hodinova_mzda=?
                WHERE zamestnanci_id=?
                ', $_POST['jmeno'], $_POST['prijmeni'], $_POST['osobni_cislo'], $_POST['adresa'],$_POST['telefon'], $datumNarozeni, $datumNastupu, $_POST['pracovni_pozice'], $_POST['hodinova_mzda'], $_POST['zamestnanci_id']);
        
        header('Location: index.php?stranka=vypisZamestnancu');
        exit();
    }
?>

<H1>Aktualizace údajů zaměstnance</H1>

<center><H2><u><?= htmlspecialchars($nactenyZamestnanec['jmeno'] . ' ' . htmlspecialchars($nactenyZamestnanec['prijmeni'])) ?></u></H2></center>

<?php
    if ($zprava)
    {
        echo('<p>' . htmlspecialchars($zprava) . '</p>');
    }
?>
<form method="POST">
    <table id="editor">
        <tr>
            <td><input type="hidden" name="zamestnanci_id" value="<?= htmlspecialchars($nactenyZamestnanec['zamestnanci_id']) ?>" /></td>
        </tr>
        <tr>
            <td>Jméno: </td>
            <td><input type="text" name="jmeno" value="<?= htmlspecialchars($nactenyZamestnanec['jmeno']) ?>" /></td>
        </tr>
        <tr>
            <td>Příjmení: </td>
            <td><input type="text" name="prijmeni" value="<?= htmlspecialchars($nactenyZamestnanec['prijmeni']) ?>" /></td>
        </tr>
        <tr>
            <td>Osobní číslo: </td>
            <td><input type="text" name="osobni_cislo" value="<?= htmlspecialchars($nactenyZamestnanec['osobni_cislo']) ?>" /></td>
        </tr>
        <tr>
            <td>Adresa: </td>
            <td><textarea cols="37" rows="7" name="adresa"><?= htmlspecialchars($nactenyZamestnanec['adresa']) ?></textarea></td>
        </tr>
        <tr>
            <td>Telefonní číslo: </td>
            <td><input type="text" name="telefon" value="<?= htmlspecialchars($nactenyZamestnanec['telefon']) ?>" /></td>
        </tr>
        <tr>
            <td>Datum narození: </td>
            <td><input type="text" name="datum_narozeni" value="<?= htmlspecialchars($datumNarozeni) ?>" /></td>
        </tr>
        <tr>
            <td>Datum nástupu: </td>
            <td><input type="text" name="datum_nastupu" value="<?= htmlspecialchars($datumNastupu) ?>" /></td>
        </tr>
        <tr>
            <td>Pracovní pozice: </td>
            <td><input type="text" name="pracovni_pozice" value="<?= htmlspecialchars($nactenyZamestnanec['pracovni_pozice']) ?>" /></td>
        </tr>
        <tr>
            <td>Hodinová mzda: </td>
            <td><input type="text" name="hodinova_mzda" value="<?= htmlspecialchars($nactenyZamestnanec['hodinova_mzda']) ?>" /></td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="Aktualizovat údaje" />
            </td>
        </tr>
    </table>
</form>