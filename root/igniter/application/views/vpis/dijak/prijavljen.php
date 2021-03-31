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
                    <br>
                    <?php $this->load->view("meniDijak"); ?>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 vsebina">
                            <div class="cellContent border">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris dignissim condimentum molestie. Etiam nec vehicula enim, ac vulputate nibh. Phasellus interdum urna sed ullamcorper vehicula. Aenean sed tristique ante, luctus cursus nulla. Suspendisse non ante id libero molestie mattis at vitae sem. Mauris nec libero facilisis, dictum velit non, interdum ipsum. Suspendisse neque ligula, volutpat non nulla hendrerit, vulputate gravida leo. Fusce congue quam nisl, non pulvinar felis suscipit nec. Vestibulum ullamcorper nec libero vel tempor. Etiam facilisis ultrices dolor, mattis rutrum lectus posuere vel.</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 vsebina">
                            <div class="cellContent border">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris dignissim condimentum molestie. Etiam nec vehicula enim, ac vulputate nibh. Phasellus interdum urna sed ullamcorper vehicula. Aenean sed tristique ante, luctus cursus nulla. Suspendisse non ante id libero molestie mattis at vitae sem. Mauris nec libero facilisis, dictum velit non, interdum ipsum. Suspendisse neque ligula, volutpat non nulla hendrerit, vulputate gravida leo. Fusce congue quam nisl, non pulvinar felis suscipit nec. Vestibulum ullamcorper nec libero vel tempor. Etiam facilisis ultrices dolor, mattis rutrum lectus posuere vel.</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12 vsebina">
                            <div class="cellContent border">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris dignissim condimentum molestie. Etiam nec vehicula enim, ac vulputate nibh. Phasellus interdum urna sed ullamcorper vehicula. Aenean sed tristique ante, luctus cursus nulla. Suspendisse non ante id libero molestie mattis at vitae sem. Mauris nec libero facilisis, dictum velit non, interdum ipsum. Suspendisse neque ligula, volutpat non nulla hendrerit, vulputate gravida leo. Fusce congue quam nisl, non pulvinar felis suscipit nec. Vestibulum ullamcorper nec libero vel tempor. Etiam facilisis ultrices dolor, mattis rutrum lectus posuere vel.</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            
        </main>
        
       <?php $this->load->view("footer"); ?>