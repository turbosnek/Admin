<?php

/* Funkce na převod datumu narozeni z databázového formátu na české datum */
function ceskeDatumNarozeni($nactenyZamestnanec)
{
    $ceskeDatumNarozeni = date("d.m.Y", strtotime($nactenyZamestnanec['datum_narozeni']));
    return $ceskeDatumNarozeni;
}

/* Funkce na převod datumu nastupu z databázového formátu na české datum */
function ceskeDatumNastupu($nactenyZamestnanec)
{
    $ceskeDatumNastupu = date("d.m.Y", strtotime($nactenyZamestnanec['datum_nastupu']));
    return $ceskeDatumNastupu;
}

/* Funkce na převod datumu narození z českého formátu na databázový formát */
function databazovyFormatNarozeni()
{
    $databazovyDatumNarozeni = date("Y-m-d:s", strtotime($_POST['datum_narozeni']));
    return $databazovyDatumNarozeni;
}

/* Funkce na převod datumu nastupu z českého formátu na databázový formát */
function databazovyFormatNastupu()
{
    $databazovyDatumNastupu = date("Y-m-d:s", strtotime($_POST['datum_nastupu']));
    return $databazovyDatumNastupu;
}
