<?php $this->load->view("assets"); ?>

    </head>

    <body class="d-flex flex-column min-vh-100">
        
        <main role="main" class="flex-shrink-0">
            
                <div class="wrapper">

                    <?php $this->load->view("meniProfesor"); ?>

                <div class="container-fluid">

                    <div class="iskalnik">
                        <br>
                        <?php echo form_open("dejavnost/iskanjeDogodkov");?>
                            <div class="form-group">
                                <label for="txt_iskalniNiz">Iščite dogodke:</label>
                                <input type="text" class="form-control" id="txt_iskalniNiz" placeholder="Vnesite naziv, ime, priimek ali stanje(zavrnjeno, odobreno, prošnja, ustvarjeno)" name="txt_iskalniNiz">
                                 <?php echo form_error("txt_iskalniNiz", "<div class='alert alert-danger error'>", "</div>"); ?>
                            </div>
                            <button type="submit" class="btn btn-dark">Išči</button>
                        <?php echo form_close() ?>
                        <br>
                    </div>

                    <div class="row">
                        <?php
                        if($obvestila == null){
                            echo "<h1>Ni dogodkov</h1>";
                        }
                        else{
                            foreach($obvestila as $obvestilo){
                                echo "<div class='col-12 col-md-6 col-lg-4 vsebina'>";
                                        if($obvestilo["odobreno"] == 1){
                                            echo "<div class='prijavaOdobrena'>";
                                                echo "Prijava na dejavnost: " .  "<br>" . $obvestilo["naziv"] . " - odobrena, " .  "<br>" . "Čas dogodka: " . $obvestilo["casVnosa"] . "<br>" . 
                                                "Ime in priimek dijaka: " . $obvestilo["ime"] . " " .  $obvestilo["priimek"];
                                            echo "</div>";
                                        }
                                        elseif($obvestilo["odobreno"] == 2){
                                            echo "<div class='prijavaZavrnjena'>";
                                            echo "Prijava na dejavnost: " .  "<br>" . $obvestilo["naziv"] . " - zavrnjena, " .  "<br>" . "Čas dogodka: " . $obvestilo["casVnosa"] . "<br>" . 
                                            "Ime in priimek dijaka: " . $obvestilo["ime"] . " " .  $obvestilo["priimek"];
                                            echo "</div>";
                                        }
                                        elseif($obvestilo["odobreno"] == 0 and isset($obvestilo["odobreno"]) == true){
                                            echo "<div class='prijavaPoslana'>";
                                            echo "Prijava na dejavnost: " .  "<br>" . $obvestilo["naziv"] . " - čaka na odobritev, " .  "<br>" . "Čas dogodka: " . $obvestilo["casVnosa"] . "<br>" . 
                                            "Ime in priimek dijaka: " . $obvestilo["ime"] . " " .  $obvestilo["priimek"];
                                            echo "</div>";
                                        }
                                        else{
                                          echo "<div class='dejavnostUstvarjena'>";
                                              echo $obvestilo["naziv"] . " - dejavnost ustvarjena, " . "<br>" . "Čas dogodka: " . $obvestilo["casVnosa"];
                                          echo "</div>";
                                      }
                                echo "</div>";
                            }
                        }    

                        ?>
                    </div>

                </div>
                    
                        
                        
                    </div>
                        
                </div>

            </div>
            
        </main>
        
<?php $this->load->view("footer"); ?>
