<?php

class Prijavni_model extends CI_Model{

    

    public function preveriUporabnika($podatki_array){
        $this->db->select("idOseba, ime, priimek, datumRojstva, spol, eNaslov, vloga, uporabniskoIme, sola_has_oseba.Sola_idSola, letnik.Program_idProgram, oddelek.Letnik_idLetnik, oseba.Oddelek_idOddelek, letnik.stevilka, oddelek.crka, sola.nazivSole, program.nazivPrograma");
        $this->db->from("oseba");
        $this->db->join("sola_has_oseba", "oseba.idOseba = sola_has_oseba.Oseba_idOseba", "left");
        $this->db->join("oddelek", "oddelek.idOddelek = oseba.Oddelek_idOddelek", "left");
        $this->db->join("letnik", "letnik.idLetnik = oddelek.Letnik_idLetnik", "left");
        $this->db->join("program", "program.idProgram = letnik.Program_idProgram", "left");
        $this->db->join("sola", "sola.idSola = program.Sola_idSola", "left");
        $this->db->where(array(
            "oseba.eNaslov" => $podatki_array["email"],
            "oseba.geslo" => $podatki_array["geslo"]
        ));
        $query = $this->db->get();
        return $rezultat = $query->row_array();
    }

    public function vstavljanjeUporabnika($podatki_array){
        return $this->db->insert("oseba", $podatki_array);
    }

    public function pridobiSole(){
        $this->db->select("nazivSole, idSola");
        $this->db->from("sola");
        $query = $this->db->get();
        return $rezultat = $query->result_array();
    }

    public function fetch_programe($idSola){
        $this->db->select("nazivPrograma, idProgram");
        $this->db->from("program");
        $this->db->where("Sola_idSola", $idSola);
        $query = $this->db->get();
        $output = '<option value="">Izberite program</option>';
        foreach($query->result() as $row){
            $output .= '<option value="' . $row->idProgram . '">' . $row->nazivPrograma . '</option>';
        }
        return $output;
    }

    public function fetch_letnike($idProgram){
        $this->db->select("stevilka, idLetnik");
        $this->db->from("letnik");
        $this->db->where("Program_idProgram", $idProgram);
        $query = $this->db->get();
        $output = '<option value="">Izberite letnik</option>';
        foreach($query->result() as $row){
            $output .= '<option value="' . $row->idLetnik . '">' . $row->stevilka . "." . '</option>';
        }
        return $output;
    }

    public function fetch_oddelke($idLetnik){
        $this->db->select("crka, idOddelek");
        $this->db->from("oddelek");
        $this->db->where("Letnik_idLetnik", $idLetnik);
        $query = $this->db->get();
        $output = '<option value="">Izberite oddelek</option>';
        foreach($query->result() as $row){
            $output .= '<option value="' . $row->idOddelek . '">' . $row->crka . '</option>';
        }
        return $output;
    }

    
    public function pridobiKratice($naziv){

        $this->db->select("kratica");
        $this->db->from("sola");
        $this->db->where("idSola", $naziv);
        $query = $this->db->get();
        return $result = $query->result_array();
    }


    public function sestaviEmail($podatki, $kratica){
        $ime = $podatki["ime"];
        $priimek = $podatki["priimek"];
        $pretvornik1 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z', "č", "š", "ž", "Č", "Š", "Ž", "Ć", "ć");
        $pretvornik2 = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', "c", "s", "z", "c", "s", "z", "c", "c");
        $ime = str_replace($pretvornik1, $pretvornik2, $ime);
        $priimek = str_replace($pretvornik1, $pretvornik2, $priimek);
        $email = $ime . "." . $priimek . "@" . $podatki["vloga"] . "-" . $kratica . ".si";
        return($email);
    }

    public function sestaviUporabniskoIme($podatki){
        $ime = $podatki["ime"];
        $priimek = $podatki["priimek"];
        $pretvornik1 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z', "č", "š", "ž", "Č", "Š", "Ž", "Ć", "ć");
        $pretvornik2 = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', "c", "s", "z", "c", "s", "z", "c", "c");
        $ime = str_replace($pretvornik1, $pretvornik2, $ime);
        $priimek = str_replace($pretvornik1, $pretvornik2, $priimek);
        $upor = $ime . "." . $priimek;
        return($upor);
    }

    public function iskanjeIDOsebe(){
        $this->db->select("idOseba");
        $this->db->from("oseba");
        $this->db->order_by("idOseba", "DESC");
        $this->db->limit("1");
        $query = $this->db->get();
        return $rezultat = $query->row_array();
    }

    public function vstavljanjeSolaHasOseba($podatki_array){
        return $this->db->insert("sola_has_oseba", $podatki_array);
    }

    public function isciUporabnika($niz){
        $this->db->select("idOseba, ime, priimek, vloga, eNaslov, spol");
        $this->db->from("oseba");
        $this->db->like("ime", $niz);
        $this->db->or_like("priimek", $niz);
        $this->db->or_like("vloga", $niz);
        $this->db->order_by("vloga", "DESC");
        $this->db->order_by("priimek", "ASC");
        $query = $this->db->get();
        return $rezultat = $query->result_array();
    }
    

}