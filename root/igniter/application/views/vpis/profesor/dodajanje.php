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
                    
                        <div class="cellContent border">
                            <?php echo form_open("prijava/dodajanje-submit-profesor");?>
                                <div class="form-group">
                                  <label for="txt_ime">Ime:</label>
                                  <input type="text" class="form-control" id="txt_ime" placeholder="Vnesite ime" name="txt_ime">
                                  <?php echo form_error("txt_ime", "<div class='error'>", "</div>"); ?>
                                </div>
                                <div class="form-group">
                                  <label for="txt_priimek">Priimek:</label>
                                  <input type="text" class="form-control" id="txt_priimek" placeholder="Vnesite priimek" name="txt_priimek">
                                  <?php echo form_error("txt_priimek", "<div class='error'>", "</div>"); ?>
                                </div>
                                <div class="form-group">
                                  <label for="txt_geslo">Geslo:</label>
                                  <input type="password" class="form-control" id="txt_geslo" placeholder="Vnesite geslo" name="txt_geslo">
                                  <?php echo form_error("txt_geslo", "<div class='error'>", "</div>"); ?>
                                </div>
                                <div class="form-group">
                                  <label for="txt_datum">Datum Rojstva:</label>
                                  <input type="date" class="form-control" id="txt_datum" placeholder="Vnesite datum rojstva" name="txt_datum">
                                  <?php echo form_error("txt_datum", "<div class='error'>", "</div>"); ?>
                                </div>
                                <div class="form-group">
                                  <label for="txt_spol">Spol:</label><br>
                                  <input type="radio" class="form-check-input" id="txt_spol" name="txt_spol" value="m">
                                  <label for="male">M</label><br>
                                  <input type="radio" class="form-check-input" id="txt_spol" name="txt_spol" value="f">
                                  <label for="male">Ž</label><br>
                                  <?php echo form_error("txt_spol", "<div class='error'>", "</div>"); ?>
                                </div>
                                <div class="form-group">
                                  <select  class="form-control" id="txt_sola"  name="txt_sola[]" multiple="multiple">
                                  <?php
                                   foreach($sole as $opcija){
                                      if($opcija["nazivSole"] != "0"){
                                        echo "<option value=" . $opcija["idSola"] . ">" . $opcija["nazivSole"] . "</option>";
                                     }

                                  }
                                  ?>
                                  </select>
                                  <?php echo form_error("txt_sola", "<div class='error'>", "</div>"); ?>
                                </div>
                                <button type="submit" class='btn btn-dark'>Ustvari</button>
                              <?php echo form_close() ?>
                        </div>
                    </div>
                        
                </div>

            </div>
            
        </main>

        <script>
        $(document).ready(function() {
          $('#txt_sola').multiselect({
          nonSelectedText: "Izberite šole",
            });
        });
        </script>
        
        <?php $this->load->view("footer"); ?>