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
                    <?php $this->load->view("meniAdmin"); ?>
                </div>

                <div class="container">
                    
                    <div class="col-12">
                    
                        <div>
                            
                            <?php    

                                if($prosnje == null){
                                    echo "<h1>Ni prošenj za odobriti.</h1>";
                                }   
                                foreach($prosnje as $opcija){

                                    echo "<div class='cellContent border'>";

                                    echo "<h1>" . $opcija["naziv"] . "</h1>" . "<br>";

                                    echo "<p>Opis: "  . $opcija["opis"] . "</p>";

                                    echo "<p>" . "Ime in priimek učenca: " . $opcija["ime"] . " " . $opcija["priimek"] .  "</p>"; 

                                    $seznam = $opcija["idDejavnost"] . ";" . $opcija["idOseba"];

                            ?>
                                <br>
                                <?php 
                                    echo form_open("dejavnost/potrditevPrijaveAdmin");
                                    echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $seznam  . ">Odobri prošnjo</button>";
                                    echo form_close();

                                    echo "<br><br>";

                                    echo form_open("dejavnost/zavrnitevPrijaveAdmin");
                                    echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $seznam  . ">Zavrni prošnjo</button>";
                                    echo form_close(); 
                            ?> 

                            <?php

                                echo "</div><br>";

                                }




                            ?>
                            
                        </div>
                        
                    </div>
                        
                </div>

            </div>
            
        </main>
        
        <?php $this->load->view("footer"); ?>

