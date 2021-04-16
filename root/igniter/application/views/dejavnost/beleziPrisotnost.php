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

                    <?php 
                    if($this->session->userdata("vloga") == "admin"){
                        $this->load->view("meniAdmin"); 
                    }
                    elseif($this->session->userdata("vloga") == "profesor"){
                        $this->load->view("meniProfesor"); 
                    }
                    ?>
                    
                    <div class="container-fluid">
                        <div class="row">
                            
                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                              Beleži prisotnost
                            </button>
                            
                            <?php
                                if($udelezenci == null){
                                    echo "<h1>Ta dejavnost ni danes na urniku.</h1>";
                                }
                                else{ ?>
                            
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Vsi ucenci</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <div class="modal-body">
                                    <table class="table">
                            
                            <?php        
                                    $this->session->set_userdata("prisotnost", $udelezenci[0]["idDejavnost"]);
                                    $sez = array();
                                    $seznam = "";     
                                    foreach($udelezenci as $udelezenec){
                                        if(in_array($udelezenec["idOseba"], $sez) == false){
                                            array_push($sez, $udelezenec["idOseba"]);
                                            //echo "<div class='col-12 col-sm-5 col-md-3 col-lg-3 col-xl-2 cellContent border'>";
                                            echo form_open("dejavnost/beleziPrisotnost_submit");
                                            foreach($udelezenci as $primerjavaID){
    
                                                if($udelezenec["idOseba"] == $primerjavaID["idOseba"]){
                                                        //echo $primerjavaID["naziv"];
                                                        //echo "<br>"  . $udelezenec["ime"] . " " . $udelezenec["priimek"]; 
                                                        //echo "<br>"  . $primerjavaID["datum"] .  "<br>"; 
                                                        ?>
                                                            
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row"><?php echo $primerjavaID["naziv"]; ?></th>
                                                                <td><?php echo "<br>"  . $udelezenec["ime"] . " " . $udelezenec["priimek"]; ?></td>
                                                                <td><?php echo "<br>"  . $primerjavaID["datum"] .  "<br>"; ?></td>
                                                                <td><input type="radio" class="form-check-input" id="txt_prisoten<?php echo $udelezenec['idOseba']; ?>" name="txt_prisoten<?php echo $udelezenec['idOseba']; ?>" value="1" <?php if($primerjavaID["prisoten"] == 1){
                                                                    echo "checked='checked'";
                                                                } ?>>
                                                                <label for="Da">Da</label><br></td>
                                                                <td><input type="radio" class="form-check-input" id="txt_prisoten<?php echo $udelezenec['idOseba']; ?>" name="txt_prisoten<?php echo $udelezenec['idOseba']; ?>" value="0" <?php if($primerjavaID["prisoten"] == 0){
                                                                    echo "checked='checked'";
                                                                } ?>>
                                                                <label for="Ne">Ne</label><br></td>
                                                                <td><?php 
                                                                    echo "</div>"; ?></td>
                                                            </tr>
                                                        </tbody>
                
                                                        <?php  
                                                    
                                                }
            
 
            
                                            }
                                            $seznam .= $udelezenec["idOseba"] . ";";
                                
                                    }


                                        
    
                                    }
                                    
                                ?>      
                                        </table>    
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <?php
                                            echo "<button type='submit'  name='gumb' id='gumb' class='btn btn-dark' value=" . $seznam  . ">" . "Shrani</button>";
                                            echo form_close(); 
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>        
                                    
                                <?php    
                                }

                            ?>
                                <br>
                        
                    </div>
                </div>
            </div>
            
        </main>
        
        <?php $this->load->view("footer"); ?>