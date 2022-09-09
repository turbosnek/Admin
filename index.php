<?php
    session_start();
    require('Db.php');
    Db::connect('localhost', 'zamestnanci_system', 'root', 'root');

    if (isset($_SESSION['uzivatel_id']))
    {
        header('Location: administrace/index.php');
        exit();
    }

    if ($_POST) // V poli _POST něco je, odeslal se formulář
    {
        $uzivatel = Db::queryOne('
            SELECT uzivatele_id, heslo, admin
            FROM uzivatele
            WHERE jmeno=?
        ', $_POST['jmeno']);
        if (!$uzivatel || !password_verify($_POST['heslo'], $uzivatel['heslo'])) // Pokud je zadané špatné jméno nebo heslo, zobrazíme hlášku
            $zprava = 'Neplatné uživatelské jméno nebo heslo';
        else
        {
            $_SESSION['uzivatel_id'] = $uzivatel['uzivatele_id'];
            $_SESSION['uzivatel_jmeno'] = $_POST['jmeno'];
            $_SESSION['uzivatel_admin'] = $uzivatel['admin'];
            header('Location: administrace/index.php'); // Pokud se přihlášení podaří, přesměrujeme na stánku administrace/index.php
            exit();
        }
    }
?>


<!DOCTYPE html>
<html lang="cs-cz">

	<head>
		<meta charset="utf-8" />
		<meta name="description" content="" /> <!-- Popis stránky -->
		<meta name="keywords" content="" /> <!-- Klíčová slova -->
		<meta name="author" content="" /> <!-- Autor webu -->
		<link rel="shortcut icon" href="obrazky/ikona.ico" />
		<link rel="stylesheet" href="styl.css" type="text/css" />
		<title>Přihlášení</title>
	</head>

	<body>
        <center><H1>Přílášení do firemního systému</H1></center>

        <?php
            if (isset($zprava)) // Pokud je něco špatně zadáno, zobrazíme chybovou hlášku
            {
                echo('<p>' . $zprava . '</p>');
            }
        ?>

        <form method="POST">
            <table>
                <tr>
                    <td>Přihlašovací jméno: </td>
                    <td><input type="text" name="jmeno" /></td>
                </tr>
                <ttr>
                    <td>Heslo: </td>
                    <td><input type="password" name="heslo" /></td>
                </ttr>
                <tr>
                    <td><input type="submit" value="Přihlásit" /></td>
                </tr>
            </table>
        </form>
	</body>
</html>