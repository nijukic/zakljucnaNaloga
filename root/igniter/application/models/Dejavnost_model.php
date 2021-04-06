<?php

class Dejavnost_model extends CI_Model{

public function pridobiDejavnosti($idOseba){
    $query = $this->db->query("SELECT * FROM dejavnost 
    JOIN oseba_has_dejavnost ON oseba_has_dejavnost.Dejavnost_idDejavnost=Dejavnost.idDejavnost
    WHERE moznaMesta > 0 AND Oseba_idOseba != $idOseba AND avtor = 1 AND Dejavnost_idDejavnost NOT IN (SELECT Dejavnost_idDejavnost from oseba_has_dejavnost where Oseba_idOseba = $idOseba)");
    return $rezultat = $query->result_array();
}

public function pridobiPrograme($idSole){
    $this->db->select("nazivPrograma, idProgram");
    $this->db->from("program");
    $this->db->where("Sola_idSola", $idSole);
    $query = $this->db->get();
    return $rezultat = $query->result_array();
}

public function pridobiSole($idOseba){
    $this->db->select("idSola, nazivSole");
    $this->db->from("sola");
    $this->db->join("sola_has_oseba", "sola_has_oseba.Sola_idSola=sola.idSola", "inner");
    $this->db->where("sola_has_oseba.Oseba_idOseba", $idOseba);
    $query = $this->db->get();
    return $rezultat = $query->result_array();
}

public function vstavljanjeDejavnosti($podatki_array){
    return $this->db->insert("dejavnost", $podatki_array);
}

public function vstavljanjeAvtorja($podatki_array){
    return $this->db->insert("oseba_has_dejavnost", $podatki_array);
}

public function iskanjeID(){
    $this->db->select("idDejavnost");
    $this->db->from("dejavnost");
    $this->db->order_by("idDejavnost", "DESC");
    $this->db->limit("1");
    $query = $this->db->get();
    return $rezultat = $query->row_array();
}

public function mojeDejavnosti($idOseba){
    $this->db->select("*");
    $this->db->from("dejavnost");
    $this->db->join("oseba_has_dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost");
    $this->db->where("oseba_has_dejavnost.Oseba_idOseba", $idOseba);
    $query = $this->db->get();
    return $rezultat = $query->result_array();
}

public function mojeDejavnostiDijak($idOseba){
    $this->db->select("*");
    $this->db->from("dejavnost");
    $this->db->join("oseba_has_dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost");
    $this->db->where("oseba_has_dejavnost.Oseba_idOseba", $idOseba);
    $this->db->where("odobreno", 1);
    $query = $this->db->get();
    return $rezultat = $query->result_array();
}

public function fetch_programe($idSola){
    $this->db->select("nazivPrograma, idProgram");
    $this->db->from("program");
    $this->db->where_in("Sola_idSola", $idSola);
    $query = $this->db->get();
    $output = '';
    foreach($query->result() as $row){
        $output .= '<option value="' . $row->idProgram . '">' . $row->nazivPrograma . '</option>';
    }
    return $output;
}

public function fetch_letnike($idProgram){
    $this->db->select("stevilka, idLetnik");
    $this->db->from("letnik");
    $this->db->where_in("Program_idProgram", $idProgram);
    $query = $this->db->get();
    $output = '';
    foreach($query->result() as $row){
        $output .= '<option value="' . $row->idLetnik . '">' . $row->stevilka . "." . '</option>';
    }
    return $output;
}

public function fetch_oddelke($idLetnik){
    $this->db->select("crka, idOddelek");
    $this->db->from("oddelek");
    $this->db->where_in("Letnik_idLetnik", $idLetnik);
    $query = $this->db->get();
    $output = '';
    foreach($query->result() as $row){
        $output .= '<option value="' . $row->idOddelek . '">' . $row->crka . '</option>';
    }
    return $output;
}

public function imenaSol($id){
    $this->db->select("nazivSole");
    $this->db->from("sola");
    $this->db->where_in("idSola", $id);
    $query = $this->db->get();
    return $rezultat = $query->result_array();    
}

public function imenaProgramov($id){
    $this->db->select("nazivPrograma");
    $this->db->from("program");
    $this->db->where_in("idProgram", $id);
    $query = $this->db->get();
    return $rezultat = $query->result_array();    
}

public function imenaLetnikov($id){
    $this->db->select("stevilka");
    $this->db->from("letnik");
    $this->db->where_in("idLetnik", $id);
    $query = $this->db->get();
    return $rezultat = $query->result_array();    
}

public function imenaOddelkov($id){
    $this->db->select("crka");
    $this->db->from("oddelek");
    $this->db->where_in("idOddelek", $id);
    $query = $this->db->get();
    return $rezultat = $query->result_array();    
}

public function poveziVse($idSola, $sezProgramov, $sezLetnikov, $sezOddelkov){
    $this->db->select("nazivSole, nazivPrograma, stevilka, crka");
    $this->db->from("sola");
    $this->db->join("program", "program.Sola_idSola=sola.idSola", "inner");
    $this->db->join("letnik", "letnik.Program_idProgram=program.idProgram", "inner");
    $this->db->join("oddelek", "oddelek.Letnik_idLetnik=letnik.idLetnik", "inner");
    $this->db->where("idSola", $idSola);
    $this->db->where_in("idProgram", $sezProgramov);
    $this->db->where_in("idLetnik", $sezLetnikov);
    $this->db->where_in("idOddelek", $sezOddelkov);
    $query = $this->db->get();
    return $rezultat = $query->result_array();
}

public function pridobiSoleAdmin(){
    $this->db->select("idSola, nazivSole");
    $this->db->from("sola");
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function prosnjaZaPrijavo($prosnja){
    return $this->db->insert("oseba_has_dejavnost", $prosnja);
}

public function preveriRazpoložljivost($idDejavnost){
    $this->db->select("idDejavnost");
    $this->db->from("dejavnost");
    $this->db->where("idDejavnost", $idDejavnost);
    $this->db->where("moznaMesta > 0");
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function pridobiProsnjeDejavnost($idOseba){
    $this->db->select("Dejavnost_idDejavnost");
    $this->db->from("oseba_has_dejavnost");
   // $this->db->where("(SELECT '*' from 'oseba_has_dejavnost' where 'Oseba_idOseba', $idOseba)");
    $this->db->where("Oseba_idOseba", $idOseba);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function pridobiProsnjeUcenec($sezDejavnosti){
    $this->db->select("*");
    $this->db->from("oseba_has_dejavnost");
    $this->db->where_in("Dejavnost_idDejavnost", $sezDejavnosti);
    $this->db->where("odobreno", 0);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function pridobiProsnjeUcenecAdmin($sezDejavnosti){
    $this->db->select("*");
    $this->db->from("oseba_has_dejavnost");
    $this->db->where_in("Dejavnost_idDejavnost", $sezDejavnosti);
    $this->db->where("odobreno", 1);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function preveriObstojProsnje($prosnja){
    $this->db->select("Oseba_idOseba");
    $this->db->from("oseba_has_dejavnost");
    $this->db->where("Dejavnost_idDejavnost", $prosnja["Dejavnost_idDejavnost"]);
    $this->db->where("Oseba_idOseba", $prosnja["Oseba_idOseba"]);
    //$this->db->where("avtor", $prosnja["avtor"]);
    //$this->db->where("odobreno", $prosnja["odobreno"]);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function dijaKiJePoslalProsnjo($idOseba, $idDejavnost){
    $this->db->select("*");
    $this->db->from("oseba_has_dejavnost");
    $this->db->join("oseba", "oseba.idOseba=oseba_has_dejavnost.Oseba_idOseba", "inner");
    $this->db->join("dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost", "inner");
    $this->db->where("Dejavnost_idDejavnost", $idDejavnost);
    $this->db->where("Oseba_idOseba", $idOseba);
    $query = $this->db->get();
    return $rezultat = $query->row_array(); 
}

public function prijavaNiMozna($idOseba){
    $this->db->select("Dejavnost_idDejavnost");
    $this->db->from("oseba_has_dejavnost");
    $this->db->where("Oseba_idOseba", $idOseba);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function brisiDejavnost($id){
    
    $this->db->where("Dejavnost_idDejavnost", $id);
    $this->db->delete("oseba_has_dejavnost");

    $this->db->where("idDejavnost", $id);
    $this->db->delete("dejavnost");

    return(1);
}

public function spreminjanjeDejavnosti($id){
    $this->db->select("*");
    $this->db->from("dejavnost");
    $this->db->where("idDejavnost", $id);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function posodobitevDejavnosti($podatki){
    $this->db->set("moznaMesta", $podatki["moznaMesta"]);
    $this->db->set("opis", $podatki["opis"]);
    $this->db->set("malica", $podatki["malica"]);
    $this->db->set("naziv", $podatki["naziv"]);
    $this->db->set("datumZacetek", $podatki["datumZacetek"]);
    $this->db->set("datumKonec", $podatki["datumKonec"]);
    $this->db->where('idDejavnost', $podatki["idDejavnost"]);
    $this->db->update('dejavnost');

    return(1);
}

public function pridobiProsnjeDejavnostAdmin(){
    $this->db->select("*");
    $this->db->from("oseba_has_dejavnost");
    $this->db->where("avtor", 0);
    $this->db->where("odobreno", 1);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function vseDejavnosti(){
    $this->db->select("Oseba_idOseba, Dejavnost_idDejavnost, avtor, idDejavnost, moznaMesta, opis, malica, naziv, datumZacetek, datumKonec, mozneSole, mozniProgrami, mozniLetniki, mozniOddelki, ime, priimek");
    $this->db->from("dejavnost");
    $this->db->join("oseba_has_dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost");
    $this->db->join("oseba", "oseba.idOseba=oseba_has_dejavnost.Oseba_idOseba");
    $this->db->where("avtor", 1);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function rocnaPrijava(){
    $this->db->select("*");
    $this->db->from("dejavnost");
    $this->db->join("oseba_has_dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost");
    $this->db->where("avtor", 1);
    $this->db->where("moznaMesta > 0");
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function mozniDijaki($sezOddelkov, $id){

$this->db->distinct();
$this->db->select('Oseba_idOseba');
$this->db->from('oseba_has_dejavnost');
$this->db->where("Dejavnost_idDejavnost", $id);
$this->db->where("avtor", 0);
$this->db->where("odobreno", 1);

$where_clause = $this->db->get_compiled_select();

$this->db->select('idOseba');
$this->db->from('oseba');
$this->db->where_in("Oddelek_idOddelek", $sezOddelkov);

$where_clause2 = $this->db->get_compiled_select();


$this->db->distinct();
$this->db->select('idOseba, ime, priimek');
$this->db->from('oseba');
$this->db->where("`idOseba` NOT IN ($where_clause)", NULL, FALSE);
$this->db->where("`idOseba` IN ($where_clause2)", NULL, FALSE);

$query = $this->db->get();
return $rezultat = $query->result_array();
}

public function prosnjaZaPrijavoPotrjeno($prosnja, $id){
    $this->db->set("moznaMesta", "moznaMesta-1", FALSE);
    $this->db->where("idDejavnost", $id);
    $this->db->update("dejavnost");

    return $this->db->insert("oseba_has_dejavnost", $prosnja);
}

public function rocnaPrijavaProfesor($idOseba){
    $this->db->select("*");
    $this->db->from("dejavnost");
    $this->db->join("oseba_has_dejavnost", "dejavnost.idDejavnost=oseba_has_dejavnost.Dejavnost_idDejavnost");
    $this->db->where("avtor", 1);
    $this->db->where("moznaMesta > 0");
    $this->db->where("Oseba_idOseba", $idOseba);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function avtomatskaPrijavaPridobiLetnike($id){
    $this->db->select("mozniOddelki");
    $this->db->from("dejavnost");
    $this->db->where("idDejavnost", $id);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function avtomatskaPrijavaPridobiMoznaMesta($id){
    $this->db->select("moznaMesta");
    $this->db->from("dejavnost");
    $this->db->where("idDejavnost", $id);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function avtomatskaPrijavaPridobiDijake($oddelki, $moznaMesta){
    #Create where clause
    $this->db->distinct();
    $this->db->select('Oseba_idOseba');
    $this->db->from('oseba_has_dejavnost');


    $where_clause = $this->db->get_compiled_select();


    #Create main query
    $this->db->distinct();
    $this->db->select('idOseba');
    $this->db->from('oseba');
    $this->db->where("`idOseba` NOT IN ($where_clause)", NULL, FALSE);
    $this->db->where_in("Oddelek_idOddelek", $oddelki);
    $this->db->limit($moznaMesta);
    $query = $this->db->get();
    return $rezultat = $query->result_array();
}

public function avtomatskaPrijavaUstvariRelacijo($id, $relacija){
    $this->db->set("moznaMesta", "moznaMesta-1", FALSE);
    $this->db->where("idDejavnost", $id);
    $this->db->update("dejavnost");

    return $this->db->insert("oseba_has_dejavnost", $relacija);
}

public function pridobiProsnjeDejavnostProfesor($idProfesor){
    #Create where clause
    $this->db->distinct();
    $this->db->select('Dejavnost_idDejavnost');
    $this->db->from('oseba_has_dejavnost');
    $this->db->where("Oseba_idOseba", $idProfesor);


    $where_clause = $this->db->get_compiled_select();


    #Create main query
    $this->db->distinct();
    $this->db->select('*');
    $this->db->from('oseba_has_dejavnost');
    $this->db->where("`Dejavnost_idDejavnost` IN ($where_clause)", NULL, FALSE);
    $this->db->where("avtor", 0);
    $this->db->where("odobreno", 1);
    $query = $this->db->get();
    return $rezultat = $query->result_array();
}

public function izbrisiProsnjoCeObstaja($prosnja){
    $this->db->where("Dejavnost_idDejavnost", $prosnja["Dejavnost_idDejavnost"]);
    $this->db->where("Oseba_idOseba", $prosnja["Oseba_idOseba"]);
    $this->db->delete("oseba_has_dejavnost");
}

public function domovDijak($idOseba){
    $this->db->select("odobreno, naziv, casVnosa");
    $this->db->from("oseba");
    $this->db->join("oseba_has_dejavnost", "idOseba=Oseba_idOseba");
    $this->db->join("dejavnost", "Dejavnost_idDejavnost=idDejavnost");
    $this->db->where("idOseba", $idOseba);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function pridobiVseProsnje(){
    $this->db->select("Dejavnost_idDejavnost");
    $this->db->from("oseba_has_dejavnost");
   // $this->db->where("(SELECT '*' from 'oseba_has_dejavnost' where 'Oseba_idOseba', $idOseba)");
    $this->db->where("avtor", 1);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function pridobiUdelezence($idDejavnost){
    $this->db->select("ime, priimek, naziv, stevilka, crka, nazivPrograma, nazivSole");
    $this->db->from("oseba_has_dejavnost");
    $this->db->join("dejavnost", "Dejavnost_idDejavnost=idDejavnost");
    $this->db->join("oseba", "oseba.idOseba=oseba_has_dejavnost.Oseba_idOseba");
    $this->db->join("oddelek", "oddelek.idOddelek = oseba.Oddelek_idOddelek");
    $this->db->join("letnik", "letnik.idLetnik = oddelek.Letnik_idLetnik");
    $this->db->join("program", "program.idProgram = letnik.Program_idProgram");
    $this->db->join("sola", "sola.idSola = program.Sola_idSola");
    $this->db->where("idDejavnost", $idDejavnost);
    $this->db->where("avtor", 0);
    $this->db->where("odobreno", 1);
    $query = $this->db->get();
    return $rezultat = $query->result_array(); 
}

public function ustvariPrisotnost($idDejavnosti, $idDijaka, $zacetek, $konec){

    $stDni = $konec->diff($zacetek)->format("%a");

    $this->db->select("trajanje, idProgram");
    $this->db->from("program");
    $this->db->where("Sola_idSola", $idSole);


    $this->db->select("nazivPrograma, idProgram");
    $this->db->from("program");
    $this->db->where("Sola_idSola", $idSole);
    $query = $this->db->get();
    $rezultat = $query->result_array(); 
    
}







}