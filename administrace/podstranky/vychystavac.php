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
    
    /**
     * Vybereme všechny záznamy z tabulky "zamestnanci" podle jejich pracovní pozice "Vychystávač"
     */
     $zamestnanci = Db::queryAll('
             SELECT *
             FROM zamestnanci
             ORDER BY pracovni_pozice="Vychystávač"
             ');
?>


<H1>Výpis zaměstnanců firmy na pozici "vychystávač"</H1>

<?php
    foreach ($zamestnanci as $zamestnanec)
         {
             echo('
                     <a href="index.php?stranka=detail&zamestnanci_id=' . htmlspecialchars($zamestnanec['zamestnanci_id']) . '">
                         ' . htmlspecialchars($zamestnanec['jmeno']) . ' ' . htmlspecialchars($zamestnanec['prijmeni']) .
                         '</a>');
         }
?>