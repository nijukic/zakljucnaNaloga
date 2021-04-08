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
    
                                foreach($dijaki as $opcija){
                                        echo "<div class='dejavnost'>";

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

                                        }


                                ?>
                                <?php echo form_open("dejavnost/rocnaPrijavaDijaki-submit");?>


                                <div class="form-group">
                                  <select id="txt_dijaki" name="txt_dijaki[]" multiple="multiple" class="form-control">
                                  <?php
                                   foreach($sezDijakov as $opcija){
                                        echo "<option value=" . $opcija["idOseba"] . ">" . $opcija["ime"] . " " . $opcija["priimek"] . "</option>";
                                  }
                                  ?>
                                  </select>
                                  <?php echo form_error("txt_dijaki", "<div class='error'>", "</div>"); ?>
                                </div>

                                <button type="submit" class='btn btn-dark' value="<?php echo $dijaki[0]['idDejavnost'];?>" name="gumb">Prijavi</button>
                              <?php echo form_close() ?>
                                    <br>
                        
                        </div>
                        
                    </div>
                        
                </div>

            </div>
            
        </main>
        
        <footer class="footer mt-auto py-3">
            <div class="container">
                <p class="footerText">Avtorja: Nik Jukič, Gašper Podbregar</p>
                <p class="footerText">Mentor: Žiga Podplatnik</p>
            </div>
        </footer>
        
        <script>
            /* Set the width of the side navigation to 250px */
            function openNav() {
              document.getElementById("mySidenav").style.width = "250px";
            }

            /* Set the width of the side navigation to 0 */
            function closeNav() {
              document.getElementById("mySidenav").style.width = "0";
            }
            $(document).ready(function(){

                $('#txt_dijaki').multiselect({
                nonSelectedText: "Izberite dijake, ki jih želite prijaviti na dejavnost",
                buttonWidth:"400px"

              });
              });

            var st = "<?php echo $dijaki[0]["moznaMesta"]; ?>";
            var verified = [];
            document.querySelector('select').onchange = function(e) {
              if (this.querySelectorAll('option:checked').length <= st) {
                  verified = Array.apply(null, this.querySelectorAll('option:checked'));
              } else {
                Array.apply(null, this.querySelectorAll('option')).forEach(function(e) {
                    e.selected = verified.indexOf(e) > -1;
                });
              }
            }

        </script>

    </body>
    
</html>
