<?php $this->load->view("assets"); ?>

    </head>

    <body class="d-flex flex-column min-vh-100">
        <?php
        if($this->session->flashdata("succes")){
            ?>
        <div class="btn btn-success" id="plsgoaway">
            <?php echo $this->session->flashdata("succes") ?>        
        </div>
        <?php        
            }
        elseif($this->session->flashdata("error")){
                ?>
        <div class="btn btn-danger" id="plsgoaway">
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
                    <?php $this->load->view("meniAdmin"); ?>
                </div>

                <div class="container">
                    
                    <div class="row">
                                                <?php
                            if($izbire == null){
                                echo "<h1>Ni dejavnosti!</h1>";
                            }        
                            foreach($izbire as $opcija){
                                echo "<div class='col-12 col-md-6 vsebina'>";
                                    echo "<div class='cellContent border'>";

                                    echo "<h1>" . $opcija["naziv"] . "</h1>" . "<br>";

                                    echo "<p>Mentor: " . $opcija["ime"] . " " . $opcija["priimek"] . "</p>" . "<br>";

                                    echo "<p>" . $opcija["opis"] . "</p>";

                                    echo "<p>" . "Mozna Mesta: " . $opcija["moznaMesta"] . "</p>";

                                    if($opcija["malica"] == 1){
                                        echo "<p>" . "Malica: " . "Malica je" . "</p>";
                                    }
                                    else{
                                        echo "<p>" . "Malica: " . "Malice ni" . "</p>";
                                    }


                                    echo "<p>" . "Datum začetka: " . $opcija["datumZacetek"] . "</p>";
                                    echo "<p>" . "Datum konca: " . $opcija["datumKonec"] . "</p>";

                                        foreach($opcija["povezava"] as $opcija2){
                                            $z=0;
                                            $vrednost="";
                                            $vrednost2="";


                                            foreach($opcija2 as $opcija3){


                                                if($z!=0){
                                                    if($opcija3["nazivSole"] == $vrednost){

                                                        if($opcija3["nazivPrograma"] == $vrednost2){

                                                            echo $opcija3["stevilka"] . "." . $opcija3["crka"] . "<br>";

                                                        }
                                                        else{
                                                            echo $opcija3["nazivPrograma"] . "<br>";

                                                            echo $opcija3["stevilka"] . "." . $opcija3["crka"] . "<br>";
                                                        }

                                                    }
                                                    else{
                                                        echo $opcija3["nazivSole"] . "<br>";

                                                        echo $opcija3["nazivPrograma"] . "<br>";

                                                        echo $opcija3["stevilka"] . "." . $opcija3["crka"] . "<br>";
                                                    }
                                                }
                                                else{
                                                    echo $opcija3["nazivSole"] . "<br>";

                                                    echo $opcija3["nazivPrograma"] . "<br>";

                                                    echo $opcija3["stevilka"] . "." . $opcija3["crka"] . "<br>";
                                                }
                                                $vrednost2 = $opcija3["nazivPrograma"];
                                                $vrednost = $opcija3["nazivSole"];
                                                $z++;

                                            }



                                    }

                                    
                                    echo "<br><br>".form_open("dejavnost/brisanjeDejavnosti");
                                    echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $opcija["idDejavnost"]  . ">Izbriši dejavnost</button>";
                                    echo form_close(); 

                                    echo "<br>";

                                    echo form_open("dejavnost/spreminjanjeDejavnosti");
                                    echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $opcija["idDejavnost"]  . ">Spremeni dejavnost</button>";
                                    echo form_close(); 

                                    echo "<br>";

                                    echo form_open("dejavnost/prikaziPrijavljene");
                                    echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $opcija["idDejavnost"]  . ">Udeleženci</button>";
                                    echo form_close(); 
                                    echo "</div>";
                            ?>
                                <br>

                            <?php

                                echo "</div><br>";

                            }


                        ?>


                    </div> 
                    
                </div>

            </div>
            
        </main>
       <?php $this->load->view("footer"); ?>