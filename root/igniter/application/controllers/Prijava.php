<?php

class Prijava extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model("prijavni_model");
    }

    public function login(){

        $this->load->view("vpis/prijava");

    }

    public function logout(){

        session_destroy();
        $this->load->view("vpis/prijava");
 

    }

    public function fetch_programe(){

        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        if($this->input->post('sola_id')){
            echo $this->prijavni_model->fetch_programe($this->input->post("sola_id"));
        }
    }

    public function fetch_letnike(){

        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        if($this->input->post('program_id')){
            echo $this->prijavni_model->fetch_letnike($this->input->post("program_id"));
        }
    }

    public function fetch_oddelke(){

        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        if($this->input->post('letnik_id')){
            echo $this->prijavni_model->fetch_oddelke($this->input->post("letnik_id"));
        }
    }


    public function prijava_submit(){


        //pravila, ki jih morajo vnešeni podatki upoštevati

        $config_pravila = array(
            array(
                "field"=>"txt_email",
                "label"=>"E-poštni naslov",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_geslo",
                "label"=>"Geslo",
                "rules"=>"required"
            )
        );
        
        //podatki gredo čez pravila

        $this->form_validation->set_rules($config_pravila);

        //preverjamo rezultat 

        if($this->form_validation->run()==FALSE){

            //dobili smo errorje, zato jih moramo prikazati

            $this->login();
        }
        else{

            //vpisane podatke shranimo

            $podatki = $this->input->post();
            $podatki_array = array(
                "email"=>$podatki["txt_email"],
                "geslo"=>$podatki["txt_geslo"]
            );
            $podatki_array["geslo"] = hash('sha256', $podatki_array["geslo"]);
            

            //zaženemo metodo za pregled uporabnikov

            $rezultat = $this->prijavni_model->preveriUporabnika($podatki_array);

            //če je vračilo drugačno od null pomeni, da se je uporabnik prijavil

            if ($rezultat!=null){

                $this->session->set_userdata("ime", $rezultat["ime"]);
                $this->session->set_userdata("idOseba", $rezultat["idOseba"]);
                $this->session->set_userdata("priimek", $rezultat["priimek"]);
                $this->session->set_userdata("datumRojstva", $rezultat["datumRojstva"]);
                $this->session->set_userdata("spol", $rezultat["spol"]);
                $this->session->set_userdata("eNaslov", $rezultat["eNaslov"]);
                $this->session->set_userdata("vloga", $rezultat["vloga"]);
                $this->session->set_userdata("uporabniskoIme", $rezultat["uporabniskoIme"]);
                $this->session->set_userdata("oddelekID", $rezultat["Oddelek_idOddelek"]);
                $this->session->set_userdata("letnikID", $rezultat["Letnik_idLetnik"]);
                $this->session->set_userdata("programID", $rezultat["Program_idProgram"]);
                $this->session->set_userdata("solaID", $rezultat["Sola_idSola"]);
                $this->session->set_userdata("nazivSole", $rezultat["nazivSole"]);
                $this->session->set_userdata("nazivPrograma", $rezultat["nazivPrograma"]);
                $this->session->set_userdata("stevilka", $rezultat["stevilka"]);
                $this->session->set_userdata("crka", $rezultat["crka"]);


                redirect("");


            }

            else{
                $this->session->set_flashdata("error", "Nepravilno geslo");
                $this->load->view("vpis/prijava");
            }


        }

    }

    public function dodajanjeUporabnikov_dijak(){

        if($this->session->userdata("vloga") == "admin"){

            $vseOpcije["sole"] = $this->prijavni_model->pridobiSole();

            $this->load->view("vpis/dijak/dodajanje",$vseOpcije);

        }
        else{

            redirect("");
        }



    }

    public function dodajanje_submit_dijak(){

        if($this->session->userdata("vloga") != "admin"){
            redirect("");
        }

        //pravila, ki jih morajo vnešeni podatki upoštevati

        $config_pravila = array(
            array(
                "field"=>"txt_ime",
                "label"=>"Ime",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_priimek",
                "label"=>"Priimek",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_geslo",
                "label"=>"Geslo",
                "rules"=>"required|min_length[5]"
            ),
            array(
                "field"=>"txt_sola",
                "label"=>"Šola",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_program",
                "label"=>"Program",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_letnik",
                "label"=>"Letnik",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_oddelek",
                "label"=>"Oddelek",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_datum",
                "label"=>"Datum rojstva",
                "rules"=>"required"
            )
            
        );

        //|max_length[20]|trim in |is_unique[uporabniki.email]

        $this->form_validation->set_rules($config_pravila);

        if($this->form_validation->run()==FALSE){
            //dobili smo errorje
            $this->dodajanjeUporabnikov_dijak();
        }
        else{
            //uspešni submit obrazca
            //$data = $this->input->post();
            //echo "<h1>Form data</h1>";
            //echo $data["txt_name"]. " , " . $data["txt_email"];
            
            $podatki = $this->input->post();
            $podatki_array = array(
                "ime"=>$podatki["txt_ime"],
                "priimek"=>$podatki["txt_priimek"],
                "datumRojstva"=>$podatki["txt_datum"],
                "spol"=>$podatki["txt_spol"],
                "eNaslov"=> "",
                "vloga"=>"dijak",
                "uporabniskoIme"=>"",
                "geslo"=>$podatki["txt_geslo"],
                "Oddelek_idOddelek"=>$podatki["txt_oddelek"]
            );
            $podatki_array["uporabniskoIme"]=$this->prijavni_model->sestaviUporabniskoIme($podatki_array);
            $izid = $this->prijavni_model->pridobiKratice($podatki["txt_sola"]);
            $prava = $izid[0]["kratica"];
            $podatki_array["eNaslov"] = $this->prijavni_model->sestaviEmail($podatki_array, $prava);
            $podatki_array["geslo"] = hash('sha256', $podatki_array["geslo"]);

            echo print_r($podatki);

            if($this->prijavni_model->vstavljanjeUporabnika($podatki_array)){

                $IDosebe = $this->prijavni_model->iskanjeIDOsebe();

                $podatki_array2 = array(
                    "Sola_idSola" => $podatki["txt_sola"],
                    "Oseba_idOseba" => $IDosebe["idOseba"]
                );

                if($this->prijavni_model->vstavljanjeSolaHasOseba($podatki_array2)){

                    $this->session->set_flashdata("succes", "Dijak je bil uspešno dodan!");

                    redirect("prijava/dodajanje-dijak");

                }

                else{
                    
                    $this->session->set_flashdata("error", "Dijaka ni bilo mogoče kreirati!");

                    redirect("prijava/dodajanje-dijak");
                }
            }

            else{

               $this->session->set_flashdata("error", "Dijaka ni bilo mogoče kreirati!");

                redirect("prijava/dodajanje-dijak");

           }
           
        }
    }

    public function dodajanjeUporabnikov_profesor(){

        if($this->session->userdata("vloga") == "admin"){

            $vseOpcije["sole"] = $this->prijavni_model->pridobiSole();

            $this->load->view("vpis/profesor/dodajanje",$vseOpcije);
            
        }
        else{

            redirect("");

        }



    }

    public function dodajanje_submit_profesor(){

        if($this->session->userdata("vloga") != "admin"){
            redirect("");
        }

        //pravila, ki jih morajo vnešeni podatki upoštevati

        $config_pravila = array(
            array(
                "field"=>"txt_ime",
                "label"=>"Ime",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_priimek",
                "label"=>"Priimek",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_geslo",
                "label"=>"Geslo",
                "rules"=>"required|min_length[5]"
            ),
            array(
                "field"=>"txt_sola[]",
                "label"=>"Šola",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_spol",
                "label"=>"Spol",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_datum",
                "label"=>"Datum rojstva",
                "rules"=>"required"
            )
            
        );

        //|max_length[20]|trim in |is_unique[uporabniki.email]

        $this->form_validation->set_rules($config_pravila);

        if($this->form_validation->run()==FALSE){
            //dobili smo errorje
            $this->dodajanjeUporabnikov_profesor();
        }
        else{
            //uspešni submit obrazca
            //$data = $this->input->post();
            //echo "<h1>Form data</h1>";
            //echo $data["txt_name"]. " , " . $data["txt_email"];
            
            $podatki = $this->input->post();
            $podatki_array = array(
                "ime"=>$podatki["txt_ime"],
                "priimek"=>$podatki["txt_priimek"],
                "datumRojstva"=>$podatki["txt_datum"],
                "spol"=>$podatki["txt_spol"],
                "eNaslov"=> "",
                "vloga"=>"profesor",
                "uporabniskoIme"=>"",
                "geslo"=>$podatki["txt_geslo"],
            );
            $podatki_array["uporabniskoIme"]=$this->prijavni_model->sestaviUporabniskoIme($podatki_array);
            $izid = $this->prijavni_model->pridobiKratice($podatki["txt_sola"][0]);
            $prava = $izid[0]["kratica"];
            $podatki_array["eNaslov"] = $this->prijavni_model->sestaviEmail($podatki_array, $prava);
            $podatki_array["geslo"] = hash('sha256', $podatki_array["geslo"]);

            if($this->prijavni_model->vstavljanjeUporabnika($podatki_array)){

                $IDosebe = $this->prijavni_model->iskanjeIDOsebe();
                
                foreach ($podatki['txt_sola'] as $podatek){  
                    
                    $podatki_array2 = array(
                        "Sola_idSola" => $podatek,
                        "Oseba_idOseba" => $IDosebe["idOseba"]
                    );

                    $this->prijavni_model->vstavljanjeSolaHasOseba($podatki_array2);

                }

                $this->session->set_flashdata("succes", "Profesor je bil uspešno dodan!");

                redirect("prijava/dodajanje-profesor");

                }

                else{
                
                    $this->session->set_flashdata("error", "Profesorja ni bilo mogoče kreirati!");

                    redirect("prijava/dodajanje-profesor");
                }

        }
    }


    

}