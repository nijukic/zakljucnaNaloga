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
                    
                    <div class="iskalnik">
                        <br>
                        <?php echo form_open("prijava/iskanjeUporabnikov");?>
                            <div class="form-group">
                                <label for="txt_iskalniNiz">Iščite uporabnike:</label>
                                <input type="text" class="form-control" id="txt_iskalniNiz" placeholder="Vnesite ime, priimek ali vlogo" name="txt_iskalniNiz">
                                 <?php echo form_error("txt_iskalniNiz", "<div class='alert alert-danger error'>", "</div>"); ?>
                            </div>
                            <button type="submit" class="btn btn-dark">Išči</button>
                        <?php echo form_close() ?>

                    </div>

                    <div class="row">
                        <?php
                        if($uporabniki == null){
                            echo "<br><h3>V bazi ni uporabnikov, ki ustrezajo tem pogojem!</h3>";
                        }
                        foreach($uporabniki as $uporabnik){
                            if($uporabnik["vloga"] != "admin"){
                            echo "<div class='col-12 col-md-6 vsebina'>";
                            echo "<div class='cellContent border'>";
                            if($uporabnik["vloga"] == "profesor"){
                            echo "prof." . " " . $uporabnik["priimek"] . " " . $uporabnik["ime"] . ", " . $uporabnik["eNaslov"];
                            }
                            elseif($uporabnik["spol"] == "m"){
                                echo "dijak - " . " " . $uporabnik["priimek"] . " " . $uporabnik["ime"] . ", " . $uporabnik["eNaslov"];
                            }
                            elseif($uporabnik["spol"] == "f"){
                                echo "dijakinja - " . " " . $uporabnik["priimek"] . " " . $uporabnik["ime"] . ", " . $uporabnik["eNaslov"];
                            }
                            echo form_open("prijava/spremeniGeslo");?>
                            <br>
                            <div class="form-group">
                                <input type="password" class="form-control" id="txt_geslo" placeholder="Vnesite novo geslo" name="txt_geslo">
                                <?php echo form_error("txt_geslo", "<div class='alert alert-danger error'>", "</div>"); ?>
                            </div>
                            <?php
                            echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $uporabnik["idOseba"]  . ">Shrani</button>";
                            ?>                            
                            <?php echo form_close();
                            echo "</div>";
                            echo "</div><br>";
                            }
                        }

                        ?>
                    </div>

                    <div>
                    
                    </div> 
                    
                </div>

            </div>
            
        </main>
