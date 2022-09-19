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
     * Vybereme všechny záznamy z tabulky zamestnanci podle jejich ID
     */
     $zamestnanci = Db::queryAll('
             SELECT *
             FROM zamestnanci
             ORDER BY zamestnanci_id
             ');
?>

<H1>Výpis zaměstnanců firmy</H1>


<?php
     echo('<table id="zamestnanci">');
     echo('<tr>');
     echo('<td><center><strong>Jméno</strong></center></td>');
     echo('<td><center><strong>Datum narození</strong></center></td>');
     echo('</tr>');
     
     /**
      * Pomocí cyklu foreach vypíšeme zaměstnance firmy
      */
     foreach ($zamestnanci as $zamestnanec)
     {
         echo('<tr><td>
                 <a href="index.php?stranka=detail&zamestnanci_id=' . htmlspecialchars($zamestnanec['zamestnanci_id']) . '">
                     ' . htmlspecialchars($zamestnanec['jmeno']) . ' ' . htmlspecialchars($zamestnanec['prijmeni']) .
             '</a></td>');
         $datumNarozeni = date("d.m.Y", strtotime($zamestnanec['datum_narozeni'])); // Převedeme databázové datum na naše datum
         echo('<td>' . htmlspecialchars($datumNarozeni) . '</td></tr>');
     }
     echo('</table>');
?>

