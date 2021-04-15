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

                    <?php $this->load->view("meniAdmin"); ?>

                <div class="container-fluid">
                    
                    <div class="row">
                    
                        <?php
                            if($izbire == null){
                                echo "<h1>V bazi ni dejavnosti!</h1>";
                            }                                   
                            foreach($izbire as $opcija){
                                    echo "<div class='col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3'>";
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

                                                        echo $opcija3["stevilka"] . "." . $opcija3["crka"] . ", ";

                                                    }
                                                    else{
                                                        echo "<br>" . $opcija3["nazivPrograma"] . "<br>";

                                                        echo $opcija3["stevilka"] . "." . $opcija3["crka"] . ", ";
                                                    }

                                                }
                                                else{
                                                    echo $opcija3["nazivSole"] . "<br>";

                                                    echo $opcija3["nazivPrograma"] . "<br>";

                                                    echo $opcija3["stevilka"] . "." . $opcija3["crka"] . ", ";
                                                }
                                            }
                                            else{
                                                echo "<br>" .  "<br>" . $opcija3["nazivSole"] . "<br>";

                                                echo $opcija3["nazivPrograma"] . "<br>";

                                                echo $opcija3["stevilka"] . "." . $opcija3["crka"] . ", ";
                                            }
                                            $vrednost2 = $opcija3["nazivPrograma"];
                                            $vrednost = $opcija3["nazivSole"];
                                            $z++;

                                        }



                                }

                                    echo "<br><br>";
                                    echo form_open("dejavnost/rocnaPrijavaDijaki");
                                    echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $opcija["idDejavnost"]  . ">Prijavi dijake</button>";
                                    echo form_close(); 

                                    echo "<br>";

                                    echo form_open("dejavnost/avtomatskaPrijava");
                                    echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $opcija["idDejavnost"]  . ">Avtomatsko prijavi dijake</button>";
                                    echo form_close(); 
                            ?>
                                <br>

                            <?php

                                echo "</div></div><br>";

                            }


                        ?>
                        
                    </div>
                        
                </div>

            </div>
            
        </main><br>
        
        <?php $this->load->view("footer"); ?>