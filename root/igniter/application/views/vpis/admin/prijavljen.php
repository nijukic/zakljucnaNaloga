<?php $this->load->view("assets"); ?>

    </head>

    <body class="d-flex flex-column min-vh-100">
        
        <main role="main" class="flex-shrink-0">
            
                <div class="wrapper">

                    <?php $this->load->view("meniAdmin"); ?>

                <div class="container-fluid">
                    <br>
                    <div class="container">
                        <?php echo form_open("dejavnost/iskanjeDogodkov");?>
                            <div class="form-group">
                                <label for="txt_iskalniNiz">Iščite dogodke:</label>
                                <input type="text" class="form-control" id="txt_iskalniNiz" placeholder="Vnesite naziv, ime, priimek ali stanje(zavrnjeno, odobreno, prošnja, ustvarjeno)" name="txt_iskalniNiz">
                                 <?php echo form_error("txt_iskalniNiz", "<div class='alert alert-danger error'>", "</div>"); ?>
                            </div>
                            <button type="submit" class="btn btn-dark">Išči</button>
                        <?php echo form_close() ?>
                    </div>
                    <br>
                    <div class="row">
                        
                        <?php
                        
                        if($obvestila == null){
                            echo "<h1>Ni dogodkov</h1>";
                        }
                        else{
                        /*    
                        $odobrena = array();
                        $zavrnjena = array();
                        $poslana = array();
                        $ustvarjena = array();    
                            
                        foreach($obvestila as $obvestilo){
                                    if($obvestilo["odobreno"] == 1){
                                        $odobrena[] = $obvestilo;
                                    }
                                    elseif($obvestilo["odobreno"] == 2){
                                        $zavrnjena[] = $obvestilo;
                                    }
                                    elseif($obvestilo["odobreno"] == 0 and isset($obvestilo["odobreno"]) == true){
                                        $poslana[] = $obvestilo;
                                    }
                                    else{
                                        $ustvarjena[] = $obvestilo;
                                  }
                        }
                        
                        #print_r($odobrena);
                        #echo "<br>";
                        #print_r($zavrnjena);
                        #echo "<br>";
                        #print_r($poslana);
                        #echo "<br>";
                        #print_r($ustvarjena);
                        #echo "<br>";
                        */ 
                    
                            
                        foreach($obvestila as $obvestilo){
                            echo "<div class='col-12 col-md-6 col-lg-4 col-xl-3 vsebina'>";
                                if($obvestilo["odobreno"] == 1){
                                    echo "<div class='prijavaOdobrena'>";
                                        echo "Prijava na dejavnost: " .  "<br>" . $obvestilo["naziv"] . " - odobrena, " .  "<br>" . "Čas dogodka: " . "<br>" .  $obvestilo["casVnosa"] . "<br>" . 
                                        "Ime in priimek dijaka: " . "<br>" .  $obvestilo["ime"] . " " .  $obvestilo["priimek"];
                                    echo "</div>";
                                }
                                elseif($obvestilo["odobreno"] == 2){
                                    echo "<div class='prijavaZavrnjena'>";
                                    echo "Prijava na dejavnost: " .  "<br>" . $obvestilo["naziv"] . " - zavrnjena, " . "<br>" . "Čas dogodka: " . "<br>" .  $obvestilo["casVnosa"] . "<br>" . 
                                    "Ime in priimek dijaka: " . "<br>" .  $obvestilo["ime"] . " " .  $obvestilo["priimek"];
                                    echo "</div>";
                                }
                                elseif($obvestilo["odobreno"] == 0 and isset($obvestilo["odobreno"]) == true){
                                    echo "<div class='prijavaPoslana'>";
                                    echo "Prijava na dejavnost: " .  "<br>" . $obvestilo["naziv"] . " - čaka na odobritev, " .  "<br>" . "Čas dogodka: " . "<br>" .  $obvestilo["casVnosa"] . "<br>" . 
                                    "Ime in priimek dijaka: " . "<br>" .  $obvestilo["ime"] . " " .  $obvestilo["priimek"];
                                    echo "</div>";
                                }
                                else{
                                echo "<div class='dejavnostUstvarjena'>";
                                    echo $obvestilo["naziv"] . " - dejavnost ustvarjena, " . "<br>" . "Čas dogodka: " . "<br>" .  $obvestilo["casVnosa"] . "<br>" .   
                                    "Mentor: " . $obvestilo["ime"] . " " .  $obvestilo["priimek"];
                                echo "</div>";
                            }
                            echo "</div>";
                        }
                    }
                        ?>
                    </div>

                </div>

            </div>
            
        </main>
        
        <?php $this->load->view("footer"); ?>