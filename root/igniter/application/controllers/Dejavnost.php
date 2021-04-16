<?php

class Dejavnost extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model("dejavnost_model");
        $this->load->model("prijavni_model");
    }

    public function fetch_programe(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        echo $this->dejavnost_model->fetch_programe($this->input->post("sola_id"));
    }

    public function fetch_letnike(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        echo $this->dejavnost_model->fetch_letnike($this->input->post("program_id"));
    }

    public function fetch_oddelke(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        echo $this->dejavnost_model->fetch_oddelke($this->input->post("letnik_id"));
    }

    public function ustvari(){
        if($this->session->userdata("vloga") == "admin"){
            $rezultat["sole"] = $this->dejavnost_model->pridobiSoleAdmin();
            $this->load->view("dejavnost/ustvaritevAdmin", $rezultat);
        }
        elseif($this->session->userdata("vloga") == "profesor"){
            $rezultat["sole"] = $this->dejavnost_model->pridobiSole($this->session->userdata("idOseba"));
            $this->load->view("dejavnost/ustvaritevProfesor", $rezultat);
        }
        else{
            redirect("");
        }

    }

    public function ustvari_submit(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }

        $config_pravila = array(
            array(
                "field"=>"txt_naziv",
                "label"=>"Naziv dejavnosti",
                "rules"=>"required|is_unique[dejavnost.naziv]"
            ),
            array(
                "field"=>"txt_mesta",
                "label"=>"Možna mesta",
                "rules"=>"required|integer"
            ),
            array(
                "field"=>"txt_opis",
                "label"=>"Opis dejavnosti",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_malica",
                "label"=>"Malica",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_datumZacetek",
                "label"=>"Datum začetka",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_datumKonec",
                "label"=>"Datum konca",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_sola[]",
                "label"=>"Program",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_program[]",
                "label"=>"Program",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_letnik[]",
                "label"=>"Letnik",
                "rules"=>"required"
            ),
            array(
                "field"=>"txt_oddelek[]",
                "label"=>"Odddelek",
                "rules"=>"required"
            )
            
        );


        $this->form_validation->set_rules($config_pravila);

        $podatki = $this->input->post();

        if($this->form_validation->run()==FALSE){

            $this->ustvari();
        }
        elseif($podatki["txt_datumZacetek"]<= $podatki["txt_datumKonec"]){


            $niz="";

            foreach ($podatki['txt_sola'] as $podatek){
                $niz .= $podatek . ";";
            }


            $niz2="";

            foreach ($podatki['txt_program'] as $podatek){
                $niz2 .= $podatek . ";";
            }


            $niz3="";

            foreach ($podatki['txt_letnik'] as $podatek){
                $niz3 .= $podatek . ";";
            }

            $niz4="";

            foreach ($podatki['txt_oddelek'] as $podatek){
                $niz4 .= $podatek . ";";
            }
                    

            $podatki_array = array(
                "naziv"=>$podatki["txt_naziv"],
                "moznaMesta"=>$podatki["txt_mesta"],
                "opis"=>$podatki["txt_opis"],
                "datumZacetek"=>$podatki["txt_datumZacetek"],
                "datumKonec"=>$podatki["txt_datumKonec"],
                "malica"=>$podatki["txt_malica"],
                "mozneSole"=>$niz,
                "mozniProgrami"=>$niz2,
                "mozniLetniki"=>$niz3,
                "mozniOddelki"=>$niz4
            );


            if($this->dejavnost_model->vstavljanjeDejavnosti($podatki_array)){

                $idDejavnosti = $this->dejavnost_model->iskanjeID();

                $podatki_array2 = array(
                    "Oseba_idOseba"=>$this->session->userdata("idOseba"),
                    "Dejavnost_idDejavnost"=>$idDejavnosti["idDejavnost"],
                    "avtor"=>1
                );

                if($this->dejavnost_model->vstavljanjeAvtorja($podatki_array2)){

                    $this->session->set_flashdata("succes", "Dejavnost je bila uspešno ustvarjena!");
                    
                    redirect("dejavnost/ustvari");

                }
                else{

                    
                    $this->session->set_flashdata("error", "Dejavnosti ni bilo možno ustvariti!");

                    redirect("dejavnost/ustvari");

                }

            }
            else{

               $this->session->set_flashdata("error", "Dejavnosti ni bilo možno ustvariti!");

                redirect("dejavnost/ustvari");

           }
        }
        else{
            $this->session->set_flashdata("error", "Konec dejavnosti ne more biti pred začetkom!");

            redirect("dejavnost/ustvari");
        }
    }
    
    public function mojeDejavnosti(){
        if($this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        $rezultat["izbire"] = $this->dejavnost_model->mojeDejavnosti($this->session->userdata("idOseba"));
        $st=0;
        #print_r($rezultat["izbire"]);
        if($rezultat["izbire"] != NULL){
        foreach($rezultat["izbire"] as $opcija){
            $rezultat["izbire"][$st]["mozneSole"] = explode(";", $opcija["mozneSole"]);
            $rezultat["izbire"][$st]["mozniProgrami"] = explode(";", $opcija["mozniProgrami"]);
            $rezultat["izbire"][$st]["mozniLetniki"] = explode(";", $opcija["mozniLetniki"]);
            $rezultat["izbire"][$st]["mozniOddelki"] = explode(";", $opcija["mozniOddelki"]);

            $key = array_search("", $rezultat["izbire"][$st]["mozneSole"]);
            unset($rezultat["izbire"][$st]["mozneSole"][$key]);
    
            $key = array_search("", $rezultat["izbire"][$st]["mozniProgrami"]);
            unset($rezultat["izbire"][$st]["mozniProgrami"][$key]);
    
            $key = array_search("", $rezultat["izbire"][$st]["mozniLetniki"]);
            unset($rezultat["izbire"][$st]["mozniLetniki"][$key]);
    
            $key = array_search("", $rezultat["izbire"][$st]["mozniOddelki"]);
            unset($rezultat["izbire"][$st]["mozniOddelki"][$key]);
            $st++;
        }
        #print_r($rezultat["izbire"]);
        if($rezultat["izbire"] != NULL){
        for($x=min(array_keys($rezultat["izbire"])); $x<max(array_keys($rezultat["izbire"]))+1; $x++){
            #echo $rezultat["izbire"][$x]["naziv"];

            $y=0;
            foreach($rezultat["izbire"][$x]["mozneSole"] as $nekaj){
                foreach($rezultat["izbire"] as $opcija){
                    if(array_key_exists($y, $rezultat["izbire"][$x]["mozneSole"])){
                        $rezultat["izbire"][$x]["naziv"] . $rezultat["izbire"][$x]["mozneSole"][$y] . "<br>";
                        $rezultat["izbire"][$x]["povezava"][$y] = $this->dejavnost_model->poveziVse($rezultat["izbire"][$x]["mozneSole"][$y], 
                        $rezultat["izbire"][$x]["mozniProgrami"],
                        $rezultat["izbire"][$x]["mozniLetniki"],
                        $rezultat["izbire"][$x]["mozniOddelki"]);
                        $y=$y+1;
                    }
    
                }
            }

            
        }
        #print_r($rezultat);
            $this->load->view("dejavnost/moje", $rezultat);
            }
            else{
                $this->load->view("dejavnost/moje", $rezultat);
            }  
            //print_r($rezultat["izbire"]);
    
    
    
            //$st=0;
            //foreach($rezultat["izbire"] as $opcija){
            //    $rezultat["izbire"][$st]["imenaSol"] = $this->dejavnost_model->imenaSol($opcija["mozneSole"]);
            //    $rezultat["izbire"][$st]["imenaProgramov"] = $this->dejavnost_model->imenaProgramov($opcija["mozniProgrami"]);
            //    $rezultat["izbire"][$st]["imenaLetnikov"] = $this->dejavnost_model->imenaLetnikov($opcija["mozniLetniki"]);
            //    $rezultat["izbire"][$st]["imenaOddelkov"] = $this->dejavnost_model->imenaOddelkov($opcija["mozniOddelki"]);
            //    $st++;
            //}
        }

    else{
        $this->load->view("dejavnost/moje", $rezultat);
    
    }
        
    
    }

    public function mojeDejavnostiDijak(){
        if($this->session->userdata("vloga") != "dijak"){
            redirect("");
        }
        $rezultat["izbire"] = $this->dejavnost_model->mojeDejavnostiDijak($this->session->userdata("idOseba"));
        $rezultat["vloga"] = "dijakPotrjene";
        $st=0;
                #print_r($rezultat["izbire"]);
                if($rezultat["izbire"] != NULL){
                    foreach($rezultat["izbire"] as $opcija){
                        $rezultat["izbire"][$st]["mozneSole"] = explode(";", $opcija["mozneSole"]);
                        $rezultat["izbire"][$st]["mozniProgrami"] = explode(";", $opcija["mozniProgrami"]);
                        $rezultat["izbire"][$st]["mozniLetniki"] = explode(";", $opcija["mozniLetniki"]);
                        $rezultat["izbire"][$st]["mozniOddelki"] = explode(";", $opcija["mozniOddelki"]);
            
                        $key = array_search("", $rezultat["izbire"][$st]["mozneSole"]);
                        unset($rezultat["izbire"][$st]["mozneSole"][$key]);
                
                        $key = array_search("", $rezultat["izbire"][$st]["mozniProgrami"]);
                        unset($rezultat["izbire"][$st]["mozniProgrami"][$key]);
                
                        $key = array_search("", $rezultat["izbire"][$st]["mozniLetniki"]);
                        unset($rezultat["izbire"][$st]["mozniLetniki"][$key]);
                
                        $key = array_search("", $rezultat["izbire"][$st]["mozniOddelki"]);
                        unset($rezultat["izbire"][$st]["mozniOddelki"][$key]);
                        $st++;
                    }
                    #print_r($rezultat["izbire"]);
                    if($rezultat["izbire"] != NULL){
                    for($x=min(array_keys($rezultat["izbire"])); $x<max(array_keys($rezultat["izbire"]))+1; $x++){
                        #echo $rezultat["izbire"][$x]["naziv"];
            
                        $y=0;
                        $rezultat["izbire"][$x]["mentor"] = $this->dejavnost_model->pridobiMentorja($rezultat["izbire"][$x]["Dejavnost_idDejavnost"]);
                        foreach($rezultat["izbire"][$x]["mozneSole"] as $nekaj){
                            foreach($rezultat["izbire"] as $opcija){
                                if(array_key_exists($y, $rezultat["izbire"][$x]["mozneSole"])){
                                    $rezultat["izbire"][$x]["naziv"] . $rezultat["izbire"][$x]["mozneSole"][$y] . "<br>";
                                    $rezultat["izbire"][$x]["povezava"][$y] = $this->dejavnost_model->poveziVse($rezultat["izbire"][$x]["mozneSole"][$y], 
                                    $rezultat["izbire"][$x]["mozniProgrami"],
                                    $rezultat["izbire"][$x]["mozniLetniki"],
                                    $rezultat["izbire"][$x]["mozniOddelki"]);
                                    $y=$y+1;
                                }
                
                            }
                        }
            
                        
                    }
                    #print_r($rezultat);
            $this->load->view("dejavnost/mojeDijak", $rezultat);
        }
        else{
            $this->load->view("dejavnost/mojeDijak", $rezultat);
        }
        
        }
        else{
            $this->load->view("dejavnost/mojeDijak", $rezultat);
        }
        //print_r($rezultat["izbire"]);



        //$st=0;
        //foreach($rezultat["izbire"] as $opcija){
        //    $rezultat["izbire"][$st]["imenaSol"] = $this->dejavnost_model->imenaSol($opcija["mozneSole"]);
        //    $rezultat["izbire"][$st]["imenaProgramov"] = $this->dejavnost_model->imenaProgramov($opcija["mozniProgrami"]);
        //    $rezultat["izbire"][$st]["imenaLetnikov"] = $this->dejavnost_model->imenaLetnikov($opcija["mozniLetniki"]);
        //    $rezultat["izbire"][$st]["imenaOddelkov"] = $this->dejavnost_model->imenaOddelkov($opcija["mozniOddelki"]);
        //    $st++;
        //}
        



        
    }


    public function prijavaNaDejavnost(){
        if($this->session->userdata("vloga") != "dijak"){
            redirect("");
        }
        if($this->session->userdata("vloga") == "dijak"){
            $rezultat["izbire"] = $this->dejavnost_model->pridobiDejavnosti($this->session->userdata("idOseba"));
            $rezultat["vloga"] = "dijak";
            $st=0;
            if($rezultat["izbire"] != NULL){
                foreach($rezultat["izbire"] as $opcija){
                    $rezultat["izbire"][$st]["mozneSole"] = explode(";", $opcija["mozneSole"]);
                    $rezultat["izbire"][$st]["mozniProgrami"] = explode(";", $opcija["mozniProgrami"]);
                    $rezultat["izbire"][$st]["mozniLetniki"] = explode(";", $opcija["mozniLetniki"]);
                    $rezultat["izbire"][$st]["mozniOddelki"] = explode(";", $opcija["mozniOddelki"]);
        
                    $key = array_search("", $rezultat["izbire"][$st]["mozneSole"]);
                    unset($rezultat["izbire"][$st]["mozneSole"][$key]);
            
                    $key = array_search("", $rezultat["izbire"][$st]["mozniProgrami"]);
                    unset($rezultat["izbire"][$st]["mozniProgrami"][$key]);
            
                    $key = array_search("", $rezultat["izbire"][$st]["mozniLetniki"]);
                    unset($rezultat["izbire"][$st]["mozniLetniki"][$key]);
            
                    $key = array_search("", $rezultat["izbire"][$st]["mozniOddelki"]);
                    unset($rezultat["izbire"][$st]["mozniOddelki"][$key]);
                    $st++;
                }
                #print_r($rezultat["izbire"]);
                if($rezultat["izbire"] != NULL){
                for($x=min(array_keys($rezultat["izbire"])); $x<max(array_keys($rezultat["izbire"]))+1; $x++){
                    #echo $rezultat["izbire"][$x]["naziv"];
        
                    $y=0;
                    foreach($rezultat["izbire"] as $opcija){
                        if(array_key_exists($y, $rezultat["izbire"][$x]["mozneSole"])){
                            #echo $rezultat["izbire"][$x]["naziv"] . $rezultat["izbire"][$x]["mozneSole"][$y] . "<br>";
                            $rezultat["izbire"][$x]["povezava"][$y] = $this->dejavnost_model->poveziVse($rezultat["izbire"][$x]["mozneSole"][$y], 
                            $rezultat["izbire"][$x]["mozniProgrami"],
                            $rezultat["izbire"][$x]["mozniLetniki"],
                            $rezultat["izbire"][$x]["mozniOddelki"]);
                            $y=$y+1;
                        }
        
                    }
                    
                }
                #print_r($rezultat);
                        $this->load->view("dejavnost/mojeDijak", $rezultat);
                    }

                    else{
                        $this->load->view("dejavnost/mojeDijak", $rezultat);
                        }
                    }
                else{
                    $this->load->view("dejavnost/mojeDijak", $rezultat);
                }


            }
        
            else{
                    $this->load->view("dejavnost/mojeDijak", $rezultat);
                }
        
    }
    

    public function prijavaNaDejavnost_submit(){
        if($this->session->userdata("vloga") != "dijak"){
            redirect("");
        }
        $prosnja = array(
            "Oseba_idOseba" => $this->session->userdata("idOseba"),
            "Dejavnost_idDejavnost" => $this->input->post("gumb"),
            "avtor" => 0,
            "odobreno" => 0
        );

        if($this->dejavnost_model->preveriRazpoložljivost($prosnja["Dejavnost_idDejavnost"]) and $this->dejavnost_model->preveriObstojProsnje($prosnja) == false){

            if($this->dejavnost_model->prosnjaZaPrijavo($prosnja)){

                $this->session->set_flashdata("succes", "Prošnja za prijavo je bila uspešno poslana!");
    
                redirect("dejavnost/prijavaNaDejavnost");
            }

            else{

                $this->session->set_flashdata("error", "Prošnje za prijavo ni bilo mogoče poslati!");
    
                redirect("dejavnost/prijavaNaDejavnost");
            }
        }
        else{

            $this->session->set_flashdata("error", "Prošnje za prijavo ni bilo mogoče poslati!");

            redirect("dejavnost/prijavaNaDejavnost");
        }
    }

    public function brisanjeDejavnosti(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }

        $id=$this->input->post("gumb");

        if($this->dejavnost_model->brisiDejavnost($id)){
            if($this->session->userdata("vloga") == "admin"){

                $this->session->set_flashdata("succes", "Dejavnost je bila uspešno izbrisana");
    
                redirect("dejavnost/vseDejavnosti");
            }

            elseif($this->session->userdata("vloga") == "profesor"){

            $this->session->set_flashdata("succes", "Dejavnost je bila uspešno izbrisana");
    
            redirect("dejavnost/mojeDejavnosti");
            }
        }
        else{
            if($this->session->userdata("vloga") == "admin"){

                $this->session->set_flashdata("error", "Dejavnost ni bilo mogoče izbrisati");
    
                redirect("dejavnost/vseDejavnosti");
            }

            elseif($this->session->userdata("vloga") == "profesor"){

                $this->session->set_flashdata("error", "Dejavnost ni bilo mogoče izbrisati");
    
                redirect("dejavnost/mojeDejavnosti");
            }
            
    
            
        }
    }

    public function prosnjeDijakov(){
        if($this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        $id = $this->input->post("gumb");
        $prosnjeUcencev["prosnje"] = $this->dejavnost_model->pridobiProsnjeDejavnost($this->session->userdata("idOseba"), $id);

        if($prosnjeUcencev["prosnje"] != NULL){
            for($x=0; $x<sizeof($prosnjeUcencev["prosnje"]); $x++){
                $sez[$x] = $prosnjeUcencev["prosnje"][$x]["Dejavnost_idDejavnost"]; 
            }
            $prosnjeUcencev["prosnje"] = $this->dejavnost_model->pridobiProsnjeUcenec($sez);
            //print_r($prosnjeUcencev["prosnje"]);
            if($prosnjeUcencev["prosnje"] != NULL){
            for($x=0; $x<sizeof($prosnjeUcencev["prosnje"]); $x++){

                if($prosnjeUcencev["prosnje"][$x]["odobreno"] != 0){

                    unset($prosnjeUcencev["prosnje"][$x]);
                }
            }
            if($prosnjeUcencev["prosnje"] != NULL){
            for($x=0; $x<sizeof($prosnjeUcencev["prosnje"]); $x++){
                $koncna["prosnje"][$x] = $this->dejavnost_model->dijaKiJePoslalProsnjo($prosnjeUcencev["prosnje"][$x]["Oseba_idOseba"],$prosnjeUcencev["prosnje"][$x]["Dejavnost_idDejavnost"]);
            }

            if($koncna["prosnje"] != NULL){
            $this->load->view("dejavnost/prosnje", $koncna);
            }

            else{
                $this->load->view("dejavnost/prosnje", $koncna);
            }
        }
        else{
            $koncna["prosnje"] = array();
            $this->load->view("dejavnost/prosnje", $koncna);
        }
        }
        else{
            $koncna["prosnje"] = array();
            $this->load->view("dejavnost/prosnje", $koncna);
        }
    }
    else{
        $koncna["prosnje"] = array();
        $this->load->view("dejavnost/prosnje", $koncna);
    }


        
    }

    public function spreminjanjeDejavnosti(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        if($this->session->userdata("spreminjanje") != NULL){
            
            if($this->session->userdata("vloga") == "admin"){
                $izbira["select"] = $this->session->userdata("spreminjanje");
                $this->load->view("dejavnost/spreminjanjeAdmin", $izbira);

            }
            else if($this->session->userdata("vloga") == "profesor"){
                $izbira["select"] = $this->session->userdata("spreminjanje");
                $this->load->view("dejavnost/spreminjanjeProfesor", $izbira);
            }
    
        }
        else{
            $id = $this->input->post("gumb");

            $dejavnost["select"] = $this->dejavnost_model->spreminjanjeDejavnosti($id);
            $dejavnost["select"][0]["idDejavnost"] = $id;
            if($this->session->userdata("vloga") == "admin"){
                $this->load->view("dejavnost/spreminjanjeAdmin", $dejavnost);
            }
            else if($this->session->userdata("vloga") == "profesor"){
                $this->load->view("dejavnost/spreminjanjeProfesor", $dejavnost);
            }
        }



    }

    public function spreminjanjeDejavnosti_submit(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        else{
            $config_pravila = array(
                array(
                    "field"=>"txt_naziv",
                    "label"=>"Naziv dejavnosti",
                    "rules"=>"required"
                ),
                array(
                    "field"=>"txt_mesta",
                    "label"=>"Možna mesta",
                    "rules"=>"required|integer"
                ),
                array(
                    "field"=>"txt_opis",
                    "label"=>"Opis dejavnosti",
                    "rules"=>"required"
                ),
                array(
                    "field"=>"txt_malica",
                    "label"=>"Malica",
                    "rules"=>"required"
                ),
                array(
                    "field"=>"txt_datumZacetek",
                    "label"=>"Datum začetka",
                    "rules"=>"required"
                ),
                array(
                    "field"=>"txt_datumKonec",
                    "label"=>"Datum Konca",
                    "rules"=>"required"
                )
                
            );
    
    
            $this->form_validation->set_rules($config_pravila);

            $podatki = $this->input->post();
    
            if($this->form_validation->run()==FALSE){
    
                $this->spreminjanjeDejavnosti();
            }
            elseif($podatki["txt_datumZacetek"]<=$podatki["txt_datumKonec"]){
                
                $podatki_array = array(
                    "naziv"=>$podatki["txt_naziv"],
                    "moznaMesta"=>$podatki["txt_mesta"],
                    "opis"=>$podatki["txt_opis"],
                    "datumZacetek"=>$podatki["txt_datumZacetek"],
                    "datumKonec"=>$podatki["txt_datumKonec"],
                    "malica"=>$podatki["txt_malica"],
                    "idDejavnost"=>$podatki["idDejavnost"]
                );
    
                if($dejavnost["select"] = $this->dejavnost_model->posodobitevDejavnosti($podatki_array)){

                    
    
                    if($this->session->userdata("vloga") == "admin"){
                        $this->session->set_flashdata("succes", "Dejavnost je bila uspešno spremenjena");
                        $this->dejavnost_model->spreminjanjeUstvariPrisotnost($podatki["idDejavnost"]);
                        $this->session->unset_userdata("spreminjanje");                       
                        redirect("dejavnost/vseDejavnosti");
                    }
                    else if($this->session->userdata("vloga") == "profesor"){
                        $this->session->set_flashdata("succes", "Dejavnost je bila uspešno spremenjena");
                        $this->dejavnost_model->spreminjanjeUstvariPrisotnost($podatki["idDejavnost"]);
                        $this->session->unset_userdata("spreminjanje");
                        redirect("dejavnost/mojeDejavnosti");
                    }
                    
    
                }
                else{
                    if($this->session->userdata("vloga") == "admin"){
                        $this->session->set_flashdata("error", "Dejavnosti ni bilo mogoče spremeniti");
                        $this->session->unset_userdata("spreminjanje");
                        redirect("dejavnost/vseDejavnosti");
                    }
                    else if($this->session->userdata("vloga") == "profesor"){
                        $this->session->set_flashdata("error", "Dejavnosti ni bilo mogoče spremeniti");
                        $this->session->unset_userdata("spreminjanje");
                        redirect("dejavnost/mojeDejavnosti");
                    }
                }
            }
            else{
                if($this->session->userdata("vloga") == "admin"){
                    $this->session->set_flashdata("error", "Konec dejavnosti ne more biti pred začetkom!");
    
                    redirect("dejavnost/spreminjanjeDejavnosti");
                }
                else if($this->session->userdata("vloga") == "profesor"){
                    $this->session->set_flashdata("error", "Konec dejavnosti ne more biti pred začetkom!");
    
                    redirect("dejavnost/spreminjanjeDejavnosti");
                }
            }
        }



    }



    public function potrditevPrijave(){
        if($this->session->userdata("vloga") != "profesor"){
            redirect("");
        }

        $id = $this->input->post("gumb");

        $id = explode(";", $id);

        if($this->dejavnost_model->preveriRazpoložljivost($id[0])){
            $this->db->set("odobreno", 1);
            $this->db->where("Dejavnost_idDejavnost", $id[0]);
            $this->db->where("Oseba_idOseba", $id[1]);
            $this->db->update("oseba_has_dejavnost");

            $this->db->set("casVnosa", "NOW()", FALSE);
            $this->db->where("Dejavnost_idDejavnost", $id[0]);
            $this->db->where("Oseba_idOseba", $id[1]);
            $this->db->update("oseba_has_dejavnost");
    
            $this->db->set("moznaMesta", "moznaMesta-1", FALSE);
            $this->db->where("idDejavnost", $id[0]);
            $this->db->update("dejavnost");

            $this->dejavnost_model->potrditevUstvariPrisotnost($id[0],$id[1]);
    
            $this->session->set_flashdata("succes", "Prošnja je bila odobrena!");
        
            redirect("dejavnost/prosnjeDijakov");
        }
        else{
            $this->session->set_flashdata("error", "Prošnje ni bilo mogoče odobriti!");
        
            redirect("dejavnost/prosnjeDijakov");
        }

    }

    public function zavrnitevPrijave(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        $id = $this->input->post("gumb");

        $id = explode(";", $id);

        if($this->session->userdata("vloga") == "profesor"){
            $this->db->set("odobreno", 2, FALSE);
            $this->db->where("Dejavnost_idDejavnost", $id[0]);
            $this->db->where("Oseba_idOseba", $id[1]);
            $this->db->update("oseba_has_dejavnost");

            $this->db->set("casVnosa", "NOW()", FALSE);
            $this->db->where("Dejavnost_idDejavnost", $id[0]);
            $this->db->where("Oseba_idOseba", $id[1]);
            $this->db->update("oseba_has_dejavnost");
    
            $this->session->set_flashdata("succes", "Prijava je bila zavrnjena!");
        }
        
        if($this->session->userdata("vloga") == "admin"){
            $this->dejavnost_model->izbrisiPrisotnostZaOsebo($id[0],$id[1]);

            $this->db->where("Dejavnost_idDejavnost", $id[0]);
            $this->db->where("Oseba_idOseba", $id[1]);
            $this->db->delete("oseba_has_dejavnost");

            $this->db->set("moznaMesta", "moznaMesta+1", FALSE);
            $this->db->where("idDejavnost", $id[0]);
            $this->db->update("dejavnost");
            $this->session->set_flashdata("succes", "Prijava je bila izbrisana!");
        }

        if($this->session->userdata("vloga") == "admin"){
            redirect("dejavnost/izbrisPrijave");
        }
        else{
            redirect("dejavnost/prosnjeDijakov");
        }

    }

    public function izbrisPrijave(){
        if($this->session->userdata("vloga") != "admin"){
            redirect("");
        }
        else{
            $id = $this->input->post("gumb");
            $prosnjeUcencev["prosnje"] = $this->dejavnost_model->pridobiProsnjeDejavnostAdmin($id);
            if($prosnjeUcencev["prosnje"] != NULL){
                for($x=0; $x<sizeof($prosnjeUcencev["prosnje"]); $x++){
                    $sez[$x] = $prosnjeUcencev["prosnje"][$x]["Dejavnost_idDejavnost"]; 
                }
    
                $prosnjeUcencev["prosnje"] = $this->dejavnost_model->pridobiProsnjeUcenecAdmin($sez);
                if($prosnjeUcencev["prosnje"] != NULL){
                for($x=0; $x<sizeof($prosnjeUcencev["prosnje"]); $x++){
                    $koncna["prosnje"][$x] = $this->dejavnost_model->dijaKiJePoslalProsnjo($prosnjeUcencev["prosnje"][$x]["Oseba_idOseba"],$prosnjeUcencev["prosnje"][$x]["Dejavnost_idDejavnost"]);
                }
    
                if($prosnjeUcencev["prosnje"] != NULL){
                    $this->load->view("dejavnost/prijave", $koncna);
                }
    
                else{
                    $koncna["prosnje"] = array();
                    $this->load->view("dejavnost/prijave", $koncna);
                }
                }
                else{
                    $koncna["prosnje"] = array();
                    $this->load->view("dejavnost/prijave", $koncna);
                }
    
            }
            else{
                $koncna["prosnje"] = array();
                $this->load->view("dejavnost/prijave", $koncna);
            }    
        }



        
    }

    public function vseDejavnosti(){
        if($this->session->userdata("vloga") != "admin"){
            redirect("");
        }
        
        $rezultat["izbire"] = $this->dejavnost_model->vseDejavnosti();
        $st=0;
        #print_r($rezultat["izbire"]);
        if($rezultat["izbire"] != NULL){
        foreach($rezultat["izbire"] as $opcija){
            $rezultat["izbire"][$st]["mozneSole"] = explode(";", $opcija["mozneSole"]);
            $rezultat["izbire"][$st]["mozniProgrami"] = explode(";", $opcija["mozniProgrami"]);
            $rezultat["izbire"][$st]["mozniLetniki"] = explode(";", $opcija["mozniLetniki"]);
            $rezultat["izbire"][$st]["mozniOddelki"] = explode(";", $opcija["mozniOddelki"]);

            $key = array_search("", $rezultat["izbire"][$st]["mozneSole"]);
            unset($rezultat["izbire"][$st]["mozneSole"][$key]);
    
            $key = array_search("", $rezultat["izbire"][$st]["mozniProgrami"]);
            unset($rezultat["izbire"][$st]["mozniProgrami"][$key]);
    
            $key = array_search("", $rezultat["izbire"][$st]["mozniLetniki"]);
            unset($rezultat["izbire"][$st]["mozniLetniki"][$key]);
    
            $key = array_search("", $rezultat["izbire"][$st]["mozniOddelki"]);
            unset($rezultat["izbire"][$st]["mozniOddelki"][$key]);
            $st++;
        }
        #print_r($rezultat["izbire"]);
        if($rezultat["izbire"] != NULL){
        for($x=min(array_keys($rezultat["izbire"])); $x<max(array_keys($rezultat["izbire"]))+1; $x++){
            #echo $rezultat["izbire"][$x]["naziv"];

            $y=0;
            foreach($rezultat["izbire"] as $opcija){
                if(array_key_exists($y, $rezultat["izbire"][$x]["mozneSole"])){
                    #echo $rezultat["izbire"][$x]["naziv"] . $rezultat["izbire"][$x]["mozneSole"][$y] . "<br>";
                    $rezultat["izbire"][$x]["povezava"][$y] = $this->dejavnost_model->poveziVse($rezultat["izbire"][$x]["mozneSole"][$y], 
                    $rezultat["izbire"][$x]["mozniProgrami"],
                    $rezultat["izbire"][$x]["mozniLetniki"],
                    $rezultat["izbire"][$x]["mozniOddelki"]);
                    $y=$y+1;
                }

            }
            
        }
        #print_r($rezultat);
        $this->load->view("dejavnost/vseDejavnosti", $rezultat);
    }
    else{
        $this->load->view("dejavnost/vseDejavnosti", $rezultat);
    }
        
    }
    else{
        $this->load->view("dejavnost/vseDejavnosti", $rezultat);

    }
        //print_r($rezultat["izbire"]);



        //$st=0;
        //foreach($rezultat["izbire"] as $opcija){
        //    $rezultat["izbire"][$st]["imenaSol"] = $this->dejavnost_model->imenaSol($opcija["mozneSole"]);
        //    $rezultat["izbire"][$st]["imenaProgramov"] = $this->dejavnost_model->imenaProgramov($opcija["mozniProgrami"]);
        //    $rezultat["izbire"][$st]["imenaLetnikov"] = $this->dejavnost_model->imenaLetnikov($opcija["mozniLetniki"]);
        //    $rezultat["izbire"][$st]["imenaOddelkov"] = $this->dejavnost_model->imenaOddelkov($opcija["mozniOddelki"]);
        //    $st++;
        //}
        


    }

    public function dodajanjeDijakov(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        if($this->session->userdata("vloga") == "admin"){
            $rezultat["izbire"] = $this->dejavnost_model->rocnaPrijava();
        }    
        else if($this->session->userdata("vloga") == "profesor"){
            $rezultat["izbire"] = $this->dejavnost_model->rocnaPrijavaProfesor($this->session->userdata("idOseba"));
        }    
            $st=0;
            if($rezultat["izbire"] != NULL){
                foreach($rezultat["izbire"] as $opcija){
                    $rezultat["izbire"][$st]["mozneSole"] = explode(";", $opcija["mozneSole"]);
                    $rezultat["izbire"][$st]["mozniProgrami"] = explode(";", $opcija["mozniProgrami"]);
                    $rezultat["izbire"][$st]["mozniLetniki"] = explode(";", $opcija["mozniLetniki"]);
                    $rezultat["izbire"][$st]["mozniOddelki"] = explode(";", $opcija["mozniOddelki"]);
        
                    $key = array_search("", $rezultat["izbire"][$st]["mozneSole"]);
                    unset($rezultat["izbire"][$st]["mozneSole"][$key]);
            
                    $key = array_search("", $rezultat["izbire"][$st]["mozniProgrami"]);
                    unset($rezultat["izbire"][$st]["mozniProgrami"][$key]);
            
                    $key = array_search("", $rezultat["izbire"][$st]["mozniLetniki"]);
                    unset($rezultat["izbire"][$st]["mozniLetniki"][$key]);
            
                    $key = array_search("", $rezultat["izbire"][$st]["mozniOddelki"]);
                    unset($rezultat["izbire"][$st]["mozniOddelki"][$key]);
                    $st++;
                }
                #print_r($rezultat["izbire"]);
                if($rezultat["izbire"] != NULL){
                for($x=min(array_keys($rezultat["izbire"])); $x<max(array_keys($rezultat["izbire"]))+1; $x++){
                    #echo $rezultat["izbire"][$x]["naziv"];
        
                    $y=0;
                    foreach($rezultat["izbire"] as $opcija){
                        if(array_key_exists($y, $rezultat["izbire"][$x]["mozneSole"])){
                            #echo $rezultat["izbire"][$x]["naziv"] . $rezultat["izbire"][$x]["mozneSole"][$y] . "<br>";
                            $rezultat["izbire"][$x]["povezava"][$y] = $this->dejavnost_model->poveziVse($rezultat["izbire"][$x]["mozneSole"][$y], 
                            $rezultat["izbire"][$x]["mozniProgrami"],
                            $rezultat["izbire"][$x]["mozniLetniki"],
                            $rezultat["izbire"][$x]["mozniOddelki"]);
                            $y=$y+1;
                        }
        
                    }
                    
                }
            if($this->session->userdata("vloga") == "admin"){
                $this->load->view("dejavnost/vseDejavnosti", $rezultat);
            }
            elseif($this->session->userdata("vloga") == "profesor"){
                $this->load->view("dejavnost/moje", $rezultat);
            }

        }
        else{
            if($this->session->userdata("vloga") == "admin"){
                $this->load->view("dejavnost/vseDejavnosti", $rezultat);
            }
            elseif($this->session->userdata("vloga") == "profesor"){
                $this->load->view("dejavnost/moje", $rezultat);
            }

        }
            //print_r($rezultat["izbire"]);
    
    
    
            //$st=0;
            //foreach($rezultat["izbire"] as $opcija){
            //    $rezultat["izbire"][$st]["imenaSol"] = $this->dejavnost_model->imenaSol($opcija["mozneSole"]);
            //    $rezultat["izbire"][$st]["imenaProgramov"] = $this->dejavnost_model->imenaProgramov($opcija["mozniProgrami"]);
            //    $rezultat["izbire"][$st]["imenaLetnikov"] = $this->dejavnost_model->imenaLetnikov($opcija["mozniLetniki"]);
            //    $rezultat["izbire"][$st]["imenaOddelkov"] = $this->dejavnost_model->imenaOddelkov($opcija["mozniOddelki"]);
            //    $st++;
            //}
            

        }
        else{
            if($this->session->userdata("vloga") == "admin"){
                $this->load->view("dejavnost/vseDejavnosti", $rezultat);
            }
            elseif($this->session->userdata("vloga") == "profesor"){
                $this->load->view("dejavnost/moje", $rezultat);
            }

        }

        

    }

    public function rocnaPrijavaDijaki(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        else{
            $id = $this->input->post("gumb");

            $dejavnost["dijaki"] = $this->dejavnost_model->spreminjanjeDejavnosti($id);
            $dejavnost["dijaki"][0]["idDejavnost"] = $id;
    
            $dejavnost["dijaki"][0]["mozniOddelki"] = explode(";",  $dejavnost["dijaki"][0]["mozniOddelki"]);
            $key = array_search("", $dejavnost["dijaki"][0]["mozniOddelki"]);
            unset($dejavnost["dijaki"][0]["mozniOddelki"][$key]);
            $dejavnost["sezDijakov"] = $this->dejavnost_model->mozniDijaki($dejavnost["dijaki"][0]["mozniOddelki"], $id);
    
            if($this->session->userdata("vloga") == "admin"){
                $this->load->view("dejavnost/rocnaPrijavaDijakiAdmin", $dejavnost);
            }
            elseif($this->session->userdata("vloga") == "profesor"){
                $this->load->view("dejavnost/rocnaPrijavaDijakiProfesor", $dejavnost);
            }   
        }
 




    }

    public function rocnaPrijavaDijaki_submit(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        else{
            $izbor = $this->input->post("txt_dijaki[]");
            $id = $this->input->post("gumb");
    
            $st=0;
            $uspeh = 1;
            foreach($izbor as $idDijak){
                $prosnja[$st] = array(
                    "Oseba_idOseba" => $idDijak,
                    "Dejavnost_idDejavnost" => $id,
                    "avtor" => 0,
                    "odobreno" => 1
                );
    
    
                $this->dejavnost_model->izbrisiProsnjoCeObstaja($prosnja[$st]);
                $st++;
            }
    
            $stMest = $this->dejavnost_model->avtomatskaPrijavaPridobiMoznaMesta($id);
            if($stMest < $st){
                $uspeh = 0;
            }
    
            if($uspeh == 1){
    
                foreach($prosnja as $x){
    
                $this->dejavnost_model->prosnjaZaPrijavoPotrjeno($x, $id);
    
                $this->dejavnost_model->potrditevUstvariPrisotnost($x["Dejavnost_idDejavnost"],$x["Oseba_idOseba"]);
    
                }
    
                
                $this->session->set_flashdata("succes", "Dijaki so bili uspešno prijavljeni");
            
                redirect("dejavnost/dodajanjeDijakov");
    
            }
            else{
    
                $this->session->set_flashdata("error", "Dejavnost ima premalo mest!");
        
                redirect("dejavnost/dodajanjeDijakov");
            }
        }



    }
    
    public function avtomatskaPrijava(){
        if($this->session->userdata("vloga") != "admin"){
            redirect("");
        }
        else{
            $id = $this->input->post("gumb");
            $oddelki = $this->dejavnost_model->avtomatskaPrijavaPridobiLetnike($id);
            $moznaMesta = $this->dejavnost_model->avtomatskaPrijavaPridobiMoznaMesta($id);
            $moznaMesta = $moznaMesta[0]["moznaMesta"];
            echo $moznaMesta;
            $oddelki = explode(";", $oddelki[0]["mozniOddelki"]);
            unset($oddelki[count($oddelki)-1]);
            $dijakiKiUstrezajoPrijavi = $this->dejavnost_model->avtomatskaPrijavaPridobiDijake($oddelki, $moznaMesta);
            #print_r($dijakiKiUstrezajoPrijavi);
            if($dijakiKiUstrezajoPrijavi == null){
                $this->session->set_flashdata("succes", "Vsi dijaki so že prijavljeni");
                redirect("dejavnost/dodajanjeDijakov");
            }
            else{
                foreach($dijakiKiUstrezajoPrijavi as $dijak){
                    $relacija = array(
                        "Oseba_idOseba" => $dijak["idOseba"],
                        "Dejavnost_idDejavnost" => $id,
                        "avtor" => 0,
                        "odobreno" => 1
                    );
                    $this->dejavnost_model->avtomatskaPrijavaUstvariRelacijo($id, $relacija);
    
                    $this->dejavnost_model->potrditevUstvariPrisotnost($relacija["Dejavnost_idDejavnost"],$relacija["Oseba_idOseba"]);
                }
                $this->session->set_flashdata("succes", "Dijaki so bili uspešno prijavljeni");
                redirect("dejavnost/dodajanjeDijakov");
            }

        }

    }

    public function izbrisPrijaveProfesor(){
        if($this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        else{
        $id = $this->input->post("gumb");
        $prosnjeUcencev["prosnje"] = $this->dejavnost_model->pridobiProsnjeDejavnostProfesor($this->session->userdata("idOseba"), $id);
        if($prosnjeUcencev["prosnje"] != NULL){
            for($x=0; $x<sizeof($prosnjeUcencev["prosnje"]); $x++){
                $sez[$x] = $prosnjeUcencev["prosnje"][$x]["Dejavnost_idDejavnost"]; 
            }

            $prosnjeUcencev["prosnje"] = $this->dejavnost_model->pridobiProsnjeUcenecAdmin($sez);
            if($prosnjeUcencev["prosnje"] != NULL){
            for($x=0; $x<sizeof($prosnjeUcencev["prosnje"]); $x++){
                $koncna["prosnje"][$x] = $this->dejavnost_model->dijaKiJePoslalProsnjo($prosnjeUcencev["prosnje"][$x]["Oseba_idOseba"],$prosnjeUcencev["prosnje"][$x]["Dejavnost_idDejavnost"]);
            }

            if($prosnjeUcencev["prosnje"] != NULL){
                $this->load->view("dejavnost/prijaveProfesor", $koncna);
            }

            else{
                $koncna["prosnje"] = array();
                $this->load->view("dejavnost/prijaveProfesor", $koncna);
            }
            }
            else{
                $koncna["prosnje"] = array();
                $this->load->view("dejavnost/prijaveProfesor", $koncna);
            }

        }
        else{
            $koncna["prosnje"] = array();
            $this->load->view("dejavnost/prijaveProfesor", $koncna);
        }
    }  


        
    }

    public function izbrisiRelacijo(){
        if($this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        else{
        $id = $this->input->post("gumb");

        $id = explode(";", $id);

        $this->dejavnost_model->izbrisiPrisotnostZaOsebo($id[0],$id[1]);

        $this->db->where("Dejavnost_idDejavnost", $id[0]);
        $this->db->where("Oseba_idOseba", $id[1]);
        $this->db->delete("oseba_has_dejavnost");
        
        $this->db->set("moznaMesta", "moznaMesta+1", FALSE);
        $this->db->where("idDejavnost", $id[0]);
        $this->db->update("dejavnost");

        $this->session->set_flashdata("succes", "Prijava je bila izbrisana");

        redirect("dejavnost/izbrisPrijaveProfesor");
    }
    }

    public function prosnjeDijakovAdmin(){
        if($this->session->userdata("vloga") != "admin"){
            redirect("");
        }
        else{
            $id = $this->input->post("gumb");
            $prosnjeUcencev["prosnje"] = $this->dejavnost_model->pridobiProsnjeDejavnost($this->session->userdata("idOseba"), $id);

            if($prosnjeUcencev["prosnje"] != NULL){
                for($x=0; $x<sizeof($prosnjeUcencev["prosnje"]); $x++){
                    $sez[$x] = $prosnjeUcencev["prosnje"][$x]["Dejavnost_idDejavnost"]; 
                }
                $prosnjeUcencev["prosnje"] = $this->dejavnost_model->pridobiProsnjeUcenec($sez);
                if($prosnjeUcencev["prosnje"] != NULL){
                for($x=0; $x<sizeof($prosnjeUcencev["prosnje"]); $x++){

                    if($prosnjeUcencev["prosnje"][$x]["odobreno"] != 0){

                        unset($prosnjeUcencev["prosnje"][$x]);
                    }
                }
                    if($prosnjeUcencev["prosnje"] != NULL){
                    for($x=0; $x<sizeof($prosnjeUcencev["prosnje"]); $x++){
                        $koncna["prosnje"][$x] = $this->dejavnost_model->dijaKiJePoslalProsnjo($prosnjeUcencev["prosnje"][$x]["Oseba_idOseba"],$prosnjeUcencev["prosnje"][$x]["Dejavnost_idDejavnost"]);
                    }

                        if($koncna["prosnje"] != NULL){
                            $this->load->view("dejavnost/prosnjeAdmin", $koncna);
                        }

                        else{
                            $this->load->view("dejavnost/prosnjeAdmin", $koncna);
                        }
                    }
                    else{
                    $koncna["prosnje"] = array();
                    $this->load->view("dejavnost/prosnjeAdmin", $koncna);
                    }
                }
                else{
                $koncna["prosnje"] = array();
                $this->load->view("dejavnost/prosnjeAdmin", $koncna);
                    }
            }
            else{
                $koncna["prosnje"] = array();
                $this->load->view("dejavnost/prosnjeAdmin", $koncna);
            }

        }
    }

    public function potrditevPrijaveAdmin(){
        if($this->session->userdata("vloga") != "admin"){
            redirect("");
        }

        $id = $this->input->post("gumb");

        $id = explode(";", $id);

        if($this->dejavnost_model->preveriRazpoložljivost($id[0])){
            $this->db->set("odobreno", 1);
            $this->db->where("Dejavnost_idDejavnost", $id[0]);
            $this->db->where("Oseba_idOseba", $id[1]);
            $this->db->update("oseba_has_dejavnost");

            $this->db->set("casVnosa", "NOW()", FALSE);
            $this->db->where("Dejavnost_idDejavnost", $id[0]);
            $this->db->where("Oseba_idOseba", $id[1]);
            $this->db->update("oseba_has_dejavnost");
    
            $this->db->set("moznaMesta", "moznaMesta-1", FALSE);
            $this->db->where("idDejavnost", $id[0]);
            $this->db->update("dejavnost");

            $this->dejavnost_model->potrditevUstvariPrisotnost($id[0],$id[1]);
    
            $this->session->set_flashdata("succes", "Prošnja je bila odobrena!");
        
            redirect("dejavnost/prosnjeDijakovAdmin");
        }
        else{
            $this->session->set_flashdata("error", "Prošnje ni bilo mogoče odobriti!");
        
            redirect("dejavnost/prosnjeDijakovAdmin");
        }
    }

    public function zavrnitevPrijaveAdmin(){
        if($this->session->userdata("vloga") != "admin"){
            redirect("");
        }
        else{
            $id = $this->input->post("gumb");

            $id = explode(";", $id);
    
            $this->db->set("odobreno", 2, FALSE);
            $this->db->where("Dejavnost_idDejavnost", $id[0]);
            $this->db->where("Oseba_idOseba", $id[1]);
            $this->db->update("oseba_has_dejavnost");

            $this->db->set("casVnosa", "NOW()", FALSE);
            $this->db->where("Dejavnost_idDejavnost", $id[0]);
            $this->db->where("Oseba_idOseba", $id[1]);
            $this->db->update("oseba_has_dejavnost");
        
            $this->session->set_flashdata("succes", "Prijava je bila zavrnjena!");
    
            redirect("dejavnost/prosnjeDijakovAdmin");
        }

    }

    public function prikaziPrijavljene(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        else{
            $id = $this->input->post("gumb");
            $udelezenci["udelezenci"] = $this->dejavnost_model->pridobiUdelezence($id);
            $this->load->view("dejavnost/udelezenci", $udelezenci);
        }

    }

    public function beleziPrisotnost(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        else{
            if($this->session->userdata("prisotnost") != NULL){
            
                $id = $this->session->userdata("prisotnost");
                $udelezenci["udelezenci"] = $this->dejavnost_model->pridobiPrisotnost($id);
                $this->load->view("dejavnost/beleziPrisotnost", $udelezenci);
        
            }
            else{
                $id = $this->input->post("gumb");
                $udelezenci["udelezenci"] = $this->dejavnost_model->pridobiPrisotnost($id);
                $this->load->view("dejavnost/beleziPrisotnost", $udelezenci);
            }
        }


    }

    public function beleziPrisotnost_submit(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        else{
            
            $date = new DateTime("now");
            $curr_date = $date->format('Y-m-d ');
    
            $idDijakov = $this->input->post("gumb");
            $idDijakov = explode(";", $idDijakov);
            print_r($idDijakov);

            echo "<br><br>";

            print_r($dijaki = $this->input->post());

            echo $id[0] = $this->session->userdata("prisotnost");
            $st=0;
            foreach($dijaki as $dijak){
                if($st<count($dijaki)-1){
                    echo $dijak;
                    echo $id[1] = $idDijakov[$st];
                    $bool = $dijak;
                        
                    $this->db->set("prisoten", $bool);
                    $this->db->where("idDejavnost", $id[0]);
                    $this->db->where("idOseba", $id[1]);
                    $this->db->where("datum", $curr_date);
                    $this->db->update("prisotnost");
                }
                $st++;
            }

            $this->session->set_flashdata("succes", "Prisotnost je bil shranjena");
            $this->session->unset_userdata("prisotnost");
            
            redirect("dejavnost/beleziPrisotnost");
        }

    }
    public function isciDejavnost($niz){
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

    public function iskanjeDejavnosti(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        else{           
            $iskalniNiz = $this->input->post("txt_iskalniNiz");
            if($this->session->userdata("vloga") == "admin"){
                $dejavnosti["izbire"] = $this->dejavnost_model->isciDejavnostiAdmin($iskalniNiz);
                $this->load->view("dejavnost/vseDejavnosti", $dejavnosti);                
            }
            elseif($this->session->userdata("vloga") == "profesor"){
                $dejavnosti["izbire"] = $this->dejavnost_model->isciDejavnostiProfesor($iskalniNiz, $this->session->userdata("idOseba"));
                $this->load->view("dejavnost/moje", $dejavnosti); 
            }
        }
    }

    public function iskanjeDogodkov(){
        if($this->session->userdata("vloga") != "admin" and $this->session->userdata("vloga") != "profesor"){
            redirect("");
        }
        else{           
            $iskalniNiz = $this->input->post("txt_iskalniNiz");
            if($iskalniNiz == "odobreno"){
                $iskalniNiz = 1;
            }
            elseif($iskalniNiz == "zavrnjeno"){
                $iskalniNiz = 2;
            }
            elseif($iskalniNiz == "ustvarjeno"){
                $iskalniNiz = null;
            }
            elseif($iskalniNiz == "prošnja"){
                $stop = "prosnja";
                $iskalniNiz = 0;
            }
            if($this->session->userdata("vloga") == "admin"){
                $obvestila["obvestila"] = $this->dejavnost_model->isciRelacijeAdmin($iskalniNiz);
                if(isset($iskalniNiz) and $iskalniNiz == 0 and !isset($stop)){
                    for($x=min(array_keys($obvestila["obvestila"])); $x<max(array_keys($obvestila["obvestila"]))+1; $x++){
                        if($obvestila["obvestila"][$x]["odobreno"] == 0){
                            unset($obvestila["obvestila"][$x]);
                            if(empty($obvestila["obvestila"])){
                                break;
                            }
                        }
                    }                    
                }
  
                $this->load->view("vpis/admin/prijavljen", $obvestila);                
            }
            elseif($this->session->userdata("vloga") == "profesor"){
                $obvestila["obvestila"] = $this->dejavnost_model->isciRelacijeProfesor($iskalniNiz, $this->session->userdata("idOseba"));
                if(isset($iskalniNiz) and $iskalniNiz == 0 and !isset($stop)){
                    for($x=min(array_keys($obvestila["obvestila"])); $x<max(array_keys($obvestila["obvestila"]))+1; $x++){
                        if($obvestila["obvestila"][$x]["odobreno"] == 0){
                            unset($obvestila["obvestila"][$x]);
                            if(empty($obvestila["obvestila"])){
                                break;
                            }
                        }
                    }                    
                }
                $this->load->view("vpis/profesor/prijavljen", $obvestila); 
            }
        }
    }
    

}