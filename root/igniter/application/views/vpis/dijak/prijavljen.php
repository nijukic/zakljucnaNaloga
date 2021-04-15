<?php $this->load->view("assets"); ?>

    </head>

    <body class="d-flex flex-column min-vh-100">
        
        <main role="main" class="flex-shrink-0">
            
                <div class="wrapper">

                    <?php $this->load->view("meniDijak"); ?>

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
                                            echo "Prijava na dejavnost: " .  "<br>" . $obvestilo["naziv"] . " - odobrena, " .  "<br>" . $obvestilo["casVnosa"];
                                        echo "</div>";
                                    }
                                    elseif($obvestilo["odobreno"] == 2){
                                        echo "<div class='prijavaZavrnjena'>";
                                            echo "Prijava na dejavnost:  " .  "<br>" . $obvestilo["naziv"] . " - zavrnjena, " .  "<br>" . $obvestilo["casVnosa"];
                                        echo "</div>";
                                    }
                                    elseif($obvestilo["odobreno"] == 0){
                                        echo "<div class='prijavaPoslana'>";
                                            echo "Prijava na dejavnost:  " .  "<br>" . $obvestilo["naziv"] . " - čaka na odobritev, " .  "<br>" . $obvestilo["casVnosa"];
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