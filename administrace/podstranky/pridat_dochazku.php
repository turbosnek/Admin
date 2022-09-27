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

     if ($_POST) // V poli _POST něco je, odeslal se formulář
     {
         Db::query('
            INSERT INTO dochazka (osobni_cislo, mesic, den, zacatek, konec, prestavka, produktivita)
            VALUES  (?, ?, ?, ?, ?, ?, ?)
            ', $_POST['zamestnanec_osobni_cislo'], $_POST['rok'], $_POST['mesic'], $_POST['den'], $_POST['zacatek'],
            $_POST['konec'], $_POST['prestavka'], $_POST['produktivita']);
         header('Location: ../index.php'); // Po odeslání do databáze přesměrujeme na hlavní stránku
         exit();
     }

?>

<H1>Přidat docházku zaměstnance</H1>

<center><H2><u><?= htmlspecialchars($nactenyZamestnanec['jmeno']) . ' ' . htmlspecialchars($nactenyZamestnanec['prijmeni']) ?> </u></H2></center>

<form method="POST">
    <table id="zamestnanci">
        <tr>
            <td><strong>Jméno zaměstnance:</strong></td>
            <td>
                <select name="zamestnanec_osobni_cislo">
                    <?= zamestnanci($zamestnanci) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><strong>Rok:</strong></td>
            <td><input type="text" name="rok" value="<?= date('Y') ?>" /></td>
        </tr>
        <tr>
            <td><strong>Měsíc:</strong></td>
            <td>
                <select name="mesic">
                    <?= mesice() ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><strong>Den:</strong></td>
            <td>
                <select name="den">
                    <?= dny() ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><strong>Začátek pracovní doby:</strong></td>
            <td>
                <input type="text" name="zacatek" />
            </td>
        </tr>
        <tr>
            <td><strong>Konec pracovní doby:</strong></td>
            <td>
                <input type="text" name="konec" />
            </td>
        </tr>
        <tr>
            <td><strong>Přestávka:</strong></td>
            <td>
                <input type="text" name="prestavka" />
            </td>
        </tr>
        <tr>
            <td><strong>Produktivita:</strong></td>
            <td>
                <input type="text" name="produktivita" />
            </td>
        </tr>
        <tr>
            <td><input type="submit" value="Přidat docházku" /></td>
        </tr>
    </table>
</form>