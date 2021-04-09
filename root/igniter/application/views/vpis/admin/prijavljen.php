<?php $this->load->view("assets"); ?>

    </head>

    <body class="d-flex flex-column min-vh-100">
        
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
                    <br><br>
                    <?php $this->load->view("meniAdmin"); ?>
                    <a href="javascript:void(0)" class="closebtn" aria-label="Close" onclick="closeNav()"><img src="/igniter/assets/img/x.svg"></a>
                </div>

                <div class="container-fluid">
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
                                            echo "Prijava na dejavnost: " . $obvestilo["naziv"] . " - odobrena, " .  "<br>" . $obvestilo["casVnosa"] . "<br>" . 
                                            $obvestilo["ime"] . " " .  $obvestilo["priimek"];
                                        echo "</div>";
                                    }
                                    elseif($obvestilo["odobreno"] == 2){
                                        echo "<div class='prijavaZavrnjena'>";
                                            echo "Prijava na dejavnost:  " .  "<br>" . $obvestilo["naziv"] . " - zavrnjena, " .  "<br>" . $obvestilo["casVnosa"] . "<br>" . 
                                            $obvestilo["ime"] . " " .  $obvestilo["priimek"];
                                        echo "</div>";
                                    }
                                    elseif($obvestilo["odobreno"] == 0 and isset($obvestilo["odobreno"]) == true){
                                        echo "<div class='prijavaPoslana'>";
                                            echo "Prijava na dejavnost:  " .  "<br>" . $obvestilo["naziv"] . " - čaka na odobritev, " .  "<br>" . $obvestilo["casVnosa"] . "<br>" . 
                                            $obvestilo["ime"] . " " .  $obvestilo["priimek"];
                                        echo "</div>";
                                    }
                                    else{
                                      echo "<div class='dejavnostUstvarjena'>";
                                          echo $obvestilo["naziv"] . " - dejavnost ustvarjena, " .  "<br>" . $obvestilo["casVnosa"] . "<br>" . 
                                          $obvestilo["ime"] . " " .  $obvestilo["priimek"];
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