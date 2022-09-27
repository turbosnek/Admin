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

    if ($_POST) // V poli _POST něco je, odeslal se formulář
    {
        $datumNarozeni = databazovyFormatNarozeni(); // Převedeme datum na databázový formát pomocí vytvořené funkce
        $datumNastupu = databazovyFormatNastupu(); // Převedeme datum na databázový formát pomocí vytvořené funkce

        /**
         * Zjistíme, jestli už nemáme zaměstnance se zadaným osobním číslem v databázi
         */
        $existuje = Db::querySingle('
                    SELECT COUNT(*)
                    FROM zamestnanci
                    WHERE osobni_cislo=?
                    LIMIT 1
                    ', $_POST['osobni_cislo']);
        if ($existuje) // Když zaměstnanec se zadaným osobním číslem už existuje, vypíšeme zprávu
            $zprava = 'Zaměstnanec s tímto osobním číslem je už u nás zaměstnán';
        else
        {
            /**
             * Pokud je vše v pořádku, vložíme nového zaměstnance do databáze
             */
            Db::query('
                        INSERT INTO zamestnanci (jmeno, prijmeni, osobni_cislo,
                        adresa, telefon, datum_narozeni, datum_nastupu,
                        pracovni_pozice, hodinova_mzda)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                        ', $_POST['jmeno'], $_POST['prijmeni'], $_POST['osobni_cislo'],
                $_POST['adresa'], $_POST['telefon'], $datumNarozeni,
                $datumNastupu, $_POST['pracovni_pozice'], $_POST['hodinova_mzda']);
            header('Location: ../index.php'); // Po odeslání dat do databáze, přesměrujeme na hlavní stránku
            exit();
        }
    }
?>


<H1>Přidání nového zaměstnance</H1>

<?php
    if ($zprava)
    {
        echo('<p>' . htmlspecialchars($zprava) . '</p>');
    }

    /**
     * Pokud je něco špatně vyplněno, nevymaže se nám formulář
     */
    $jmeno = (isset($_POST['jmeno'])) ? $_POST['jmeno'] : '';
    $prijmeni = (isset($_POST['prijmeni'])) ? $_POST['prijmeni'] : '';
    $osobniCislo = (isset($_POST['osobni_cislo'])) ? $_POST['osobni_cislo'] : '';
    $adresa = (isset($_POST['adresa'])) ? $_POST['adresa'] : '';
    $telefon = (isset($_POST['telefon'])) ? $_POST['telefon'] : '';
    $datumNarozeni = (isset($_POST['datum_narozeni'])) ? $_POST['datum_narozeni'] : '';
    $datumNastupu = (isset($_POST['datum_nastupu'])) ? $_POST['datum_nastupu'] : '';
    $pracovniPozice = (isset($_POST['pracovni_pozice'])) ? $_POST['pracovni_pozice'] : '';
    $hodinovaMzda = (isset($_POST['hodinova_mzda'])) ? $_POST['hodinova_mzda'] : '';
?>
<form method="POST">
    <table id="zamestnanci">
        <tr>
            <td>Jméno: </td>
            <td><input type="text" name="jmeno" value="<?= htmlspecialchars($jmeno) ?>" /></td>
        </tr>
        <tr>
            <td>Příjmení: </td>
            <td><input type="text" name="prijmeni" value="<?= htmlspecialchars($prijmeni) ?>" /></td>
        </tr>
        <tr>
            <td>Osobní číslo: </td>
            <td><input type="text" name="osobni_cislo" value="<?= htmlspecialchars($osobniCislo) ?>" /></td>
        </tr>
        <tr>
            <td>Adresa: </td>
            <td><textarea cols="37" rows="7" name="adresa"><?= htmlspecialchars($adresa) ?></textarea></td>
        </tr>
        <tr>
            <td>Telefonní číslo: </td>
            <td><input type="text" name="telefon" value="<?= htmlspecialchars($telefon) ?>" /></td>
        </tr>
        <tr>
            <td>Datum narození: </td>
            <td><input type="text" name="datum_narozeni" placeholder="dd.mm.YY" value="<?= htmlspecialchars($datumNarozeni) ?>" /></td>
        </tr>
        <tr>
            <td>Datum nástupu: </td>
            <td><input type="text" name="datum_nastupu" placeholder="dd.mm.YY" value="<?= htmlspecialchars($datumNastupu) ?>" /></td>
        </tr>
        <tr>
            <td>Pracovní pozice: </td>
            <td><input type="text" name="pracovni_pozice" value="<?= htmlspecialchars($pracovniPozice) ?>" /></td>
        </tr>
        <tr>
            <td>Hodinová mzda: </td>
            <td><input type="text" name="hodinova_mzda" value="<?= htmlspecialchars($hodinovaMzda) ?>" /></td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="Přidat zaměstnance" />
                <input type="reset" value="Vymazat formulář" />
            </td>
        </tr>
    </table>
</form>