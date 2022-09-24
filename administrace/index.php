<?php
    session_start();
    require('../Db.php');
    require_once ('knihovny/pridatDochazku.php'); // Knihovna s funkcemi pro přidání docházky

    Db::connect('localhost', 'zamestnanci_system', 'root', 'root');

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
		<title></title>
	</head>

	<body>
        <header>
            <H1>Firemní systém</H1>

            <nav class="dropdownmenu">
                <ul>
                    <li><a href="index.php?stranka=domu">Domů</a></li>
                    <li><a href="#">Zaměstnanci</a>
                        <ul id="submenu">
                            <li><a href="index.php?stranka=vypis_zamestnancu">Výpis zaměstnanců</a></li>
                            <li><a href="index.php?stranka=pridat_zamestnance">Přidat zaměstnance</a></li>
                            <li><a href="index.php?stranka=pridat_dochazku">Přidat docházku</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Pracovní pozice</a>
                        <ul id="submenu">
                            <li><a href="index.php?stranka=vychystavac">Vychystávači</a></li>
                            <li><a href="index.php?stranka=retrakar">Retrakáři</a></li>
                            <li><a href="index.php?stranka=prijem">Fyzický příjem</a></li>
                            <li><a href="index.php?stranka=expedice">Expedice</a></li>
                        </ul>
                    </li>
                    <li><a href="index.php?odhlasit">Odhlásit</a></li>
                </ul>
            </nav>
        </header>

        <article>
            <section>
            <?php
                if (isset($_GET['stranka']))
                    $stranka = $_GET['stranka'];
                else
                    $stranka = 'domu';
                if (preg_match('/^[a-z0-9A-Z_]+$/', $stranka))
                {
                    $vlozeno = include('podstranky/' . $stranka . '.php');
                    if (!$vlozeno)
                        echo('Podstránka nenalezena');
                }
                else
                    echo('Neplatný parametr.');
            ?>
            </section>
        </article>

        <footer>
            <p>&copy; 2022 - <?php echo(date('Y')); ?> Lukáš Havlíček</p>
        </footer>
	</body>
</html>