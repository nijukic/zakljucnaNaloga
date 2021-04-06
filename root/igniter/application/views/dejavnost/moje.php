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

                    <button class="btn btn-outline-dark" type="button">
                        <span onclick="openNav()" style="color:black"><img src="/igniter/assets/img/Hamburger_icon.svg.png" style="width:30px;"></span>
                        <a href="javascript:void(0)" class="closebtn" aria-label="Close" onclick="closeNav()"><img src="/igniter/assets/img/x.svg"></a>
                    </button>

                    <h1 class="welcome">Prijavljeni ste kot <?php  echo $this->session->userdata("ime")?>

                    </h1>
                    <?php echo "<a class=logout href=". site_url() . "/prijava/izpis" . ">Odjava</a>" ?>  
                    
                </nav>
                <div id="mySidenav" class="sidenav">
                    <br>
                    <?php $this->load->view("meniProfesor"); ?>
                </div>

                <div class="container">
                    
                    <div class="col-12">
                        
                            <?php
                            if($izbire == null){
                                echo "<h1>Niste še ustvarili dejavnosti!</h1>";
                            }     
                                foreach($izbire as $opcija){
                                    if($vloga == "dijakPotrjene"){
                                        if($opcija["odobreno"] == 1){
                                            echo "<div class='cellContent border'>";

                                            echo "<h1>" . $opcija["naziv"] . "</h1>" . "<br>";

                                            echo "<p>" . "Opis: " . $opcija["opis"] . "</p>";

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
                                    ?>
                                        <br>
                                        <?php 
                                        if($vloga == "dijak"){
                                            echo form_open("dejavnost/prijavaNaDejavnost-submit");
                                            echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $opcija["idDejavnost"]  . ">Prijavi se na dejavnost</button>";
                                            echo form_close(); 
                                        }
                                    ?> 

                                    <?php

                                        echo "</div><br>";
                                        }

                                    }
                                    else{        echo "<div class='cellContent border'>";

                                        echo "<h1>" . $opcija["naziv"] . "</h1>" . "<br>";

                                        echo "<p>" . "Opis: " . $opcija["opis"] . "</p>";

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


                                        echo form_open("dejavnost/brisanjeDejavnosti");
                                        echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $opcija["idDejavnost"]  . ">Izbriši dejavnost</button>";
                                        echo form_close(); 

                                        echo "<br><br>";

                                        echo form_open("dejavnost/spreminjanjeDejavnosti");
                                        echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $opcija["idDejavnost"]  . ">Spremeni dejavnost</button>";
                                        echo form_close();

                                        
                                        echo "<br><br>";

                                        echo form_open("dejavnost/prikaziPrijavljene");
                                        echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $opcija["idDejavnost"]  . ">Udeleženci</button></div>";
                                        echo form_close(); 

                                        }
                                ?>
                                    <br>
                                    <?php 
                                    if($vloga == "dijak"){
                                        echo form_open("dejavnost/prijavaNaDejavnost-submit");
                                        echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $opcija["idDejavnost"]  . ">Prijavi se na dejavnost</button>";
                                        echo form_close(); 
                                    }
                                ?> 

                                <?php

                                    echo "<br>";}




                                }


                            ?>
                    </div>
                        
                </div>

            </div>
            
        </main>
        
        <?php $this->load->view("footer"); ?>
