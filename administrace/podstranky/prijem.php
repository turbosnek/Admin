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
     * Vybereme všechny záznamy z tabulky "zamestnanci" podle jejich pracovní pozice "Retrakář"
     */
     $zamestnanci = Db::queryAll('
             SELECT *
             FROM zamestnanci
             WHERE pracovni_pozice="Příjem"
             ORDER BY zamestnanci_id
             ');
?>


<H1>Výpis zaměstnanců firmy na pozici "Fyzický příjem"</H1>

<?php
     echo('<table id="zamestnanci">');
     echo('<tr>');
     echo('<td><center><strong>Jméno</strong></center></td>');
     echo('</tr>');
     
     /**
      * Pomocí cyklu foreach vypíšeme zaměstnance firmy na pozici Fyzický příjem
      */
     foreach ($zamestnanci as $zamestnanec)
     {
         echo('<tr><td><center>
                 <a href="index.php?stranka=detail_zamestnance&zamestnanci_id=' . htmlspecialchars($zamestnanec['zamestnanci_id']) . '">
                     ' . htmlspecialchars($zamestnanec['jmeno']) . ' ' . htmlspecialchars($zamestnanec['prijmeni']) .
             '</a></center></td></tr>');
     }
     echo('</table>');
?>