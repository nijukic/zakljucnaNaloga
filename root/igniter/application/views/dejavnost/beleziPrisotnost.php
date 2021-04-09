<?php $this->load->view("assets"); ?>

    </head>

    <body class="d-flex flex-column min-vh-100">
        <?php
        if($this->session->flashdata("succes")){
            ?>
        <div class="btn btn-success">
            <?php echo $this->session->flashdata("succes") ?>        
        </div>
        <?php        
            }
        elseif($this->session->flashdata("error")){
                ?>
        <div class="btn btn-danger">
            <?php echo $this->session->flashdata("error") ?>        
        </div>
        <?php        
            }
            ?>

        
        <main role="main" class="flex-shrink-0">
            
                <div class="wrapper">

               <nav class="navbar navigacija sticky-top">
                    
                    <a href="#" class="link" onclick="openNav()">
                      <svg class="settings-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                       <g class="settings-icon__group settings-icon__group--1">
                         <line class="settings-icon__line" x1="80" y1="15" x2="80" y2="85"/>
                         <rect class="settings-icon__rect" x="75" y="25" width="15" height="15"/>
                        </g>
                       <g class="settings-icon__group settings-icon__group--2">
                         <line class="settings-icon__line" x1="50" y1="15" x2="50" y2="85"/>
                         <rect class="settings-icon__rect" x="42" y="60" width="15" height="15"/>
                       </g>
                       <g class="settings-icon__group settings-icon__group--3">
                         <line class="settings-icon__line" x1="20" y1="15" x2="20" y2="85"/>
                         <rect class="settings-icon__rect" x="13" y="35" width="15" height="15"/>
                       </g>
                      </svg>
                     </a>
                    
                    <h1 class="welcome">Prijavljeni ste kot <?php  echo $this->session->userdata("ime")?>

                    </h1>
                    <?php echo "<a class=logout href=". site_url() . "/prijava/izpis" . ">Odjava</a>" ?>  
                    
                </nav>
                <div id="mySidenav" class="sidenav">
                    <br>
                    <?php 
                    if($this->session->userdata("vloga") == "admin"){
                        $this->load->view("meniAdmin"); 
                    }
                    elseif($this->session->userdata("vloga") == "profesor"){
                        $this->load->view("meniProfesor"); 
                    }
                    ?>
                </div>

                    
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                                if($udelezenci == null){
                                    echo "<h1>Ta dejavnost ni danes na urniku.</h1>";
                                }
                                else{
                                    $this->session->set_userdata("prisotnost", $udelezenci[0]["idDejavnost"]);
                                    $sez = array();      
                                    foreach($udelezenci as $udelezenec){
                                        if(in_array($udelezenec["idOseba"], $sez) == false){
                                            array_push($sez, $udelezenec["idOseba"]);
                                            echo "<div class='col-12 col-sm-5 col-md-3 col-lg-3 col-xl-2 cellContent border'>";
                                            echo form_open("dejavnost/beleziPrisotnost_submit");
                                            foreach($udelezenci as $primerjavaID){
    
                                                if($udelezenec["idOseba"] == $primerjavaID["idOseba"]){
                                                        echo $primerjavaID["naziv"];
                                                        echo "<br>"  . $udelezenec["ime"] . " " . $udelezenec["priimek"]; 
                                                        echo "<br>"  . $primerjavaID["datum"] .  "<br>"; 
                                                        ?>
                                                        
                                                        <input type="radio" class="form-check-input" id="txt_prisoten" name="txt_prisoten" value="1" <?php if($primerjavaID["prisoten"] == 1){
                                                            echo "checked='checked'";
                                                        } ?>>
                                                        <label for="Da">Da</label><br>
                                                        <input type="radio" class="form-check-input" id="txt_prisoten" name="txt_prisoten" value="0" <?php if($primerjavaID["prisoten"] == 0){
                                                            echo "checked='checked'";
                                                        } ?>>
                                                        <label for="Ne">Ne</label><br>
                
                                                        <?php  
                                                    
                                                }
            
 
            
                                            }
                                                $seznam = $udelezenec["idDejavnost"] . ";" . $udelezenec["idOseba"];
                                                echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $seznam  . ">" . "Shrani</button>";
                                                echo form_close();
                                                echo "</div>";
                                    }


                                        
    
                                    }
                                    
                                }

                            ?>
                                <br>
                        
                    </div>
                </div>
            </div>
            
        </main>
        
        <?php $this->load->view("footer"); ?>