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
                    
                </nav><br>
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
                                    echo "<h1>Prijav na dejavnosti ni!</h1>";
                                }      
                                foreach($udelezenci as $opcija){

                                    echo "<div class='col-12 col-sm-5 col-md-3 col-lg-3 col-xl-2 cellContent border'>";

                                    echo "<h1>" . $opcija["naziv"] . "</h1>" . "<br>";

                                    echo "<p>"  . $opcija["ime"] . " " . $opcija["priimek"] . ", " . $opcija["stevilka"] . "." . $opcija["crka"] .  "</p>"; 

                                    echo "<p>" . $opcija["nazivPrograma"] . "</p>";

                                    echo "<p>"  . $opcija["nazivSole"] .  "</p>";      
                                }
                            ?>
                                <br>
                        
                    </div>
                </div>
            </div>
            
        </main>
        
        <?php $this->load->view("footer"); ?>