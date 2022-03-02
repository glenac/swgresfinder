<?php

include 'config/init.php';


$resourcesClass = new Resource();
$groups = $resourcesClass->getAllGroups();

$categoryClass = new Category();

$categories = $categoryClass->getCategoriesByDepth();

?>

<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        
        <title>SWGEmu Resource Finder - by Glenac</title>
        
        
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-J90VCK892E"></script>
        
        <?php 
            /**
             * Google Analytics & Google Tag Manager
             * Replace with your IDs
             */
            
                /*
                  <script>
                      window.dataLayer = window.dataLayer || [];
                      function gtag(){dataLayer.push(arguments);}
                      gtag('js', new Date());        
                      gtag('config', 'G-J90VCK892E');
                    </script>
                    <!-- Google Tag Manager -->
                    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                        })(window,document,'script','dataLayer','GTM-5TPXJT3');
                   	</script>
                    <!-- End Google Tag Manager -->              
                 
                 
                 */
        ?>
         
        
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js">  </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <!-- Select2 -->
        <script src="plugins/select2/js/select2.full.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
	   <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">                
        
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
        <link href="css/bootstrapCustom.min.css" rel="stylesheet" />         
        <link href="css/styles.css" rel="stylesheet" />         
        
	</head>
    <body id="page-top">
    
    	<!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5TPXJT3"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">
               <a class="navbar-brand mx-auto" href="#page-top" ><img src="https://www.swgemu.com/forums/images/Styles/Blackend/misc/logo_yellow.png" height="100px"></a>
                 <!-- <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button> -->
               <?php 
               
               /*
                    <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav ms-auto">
                            <!-- <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#portfolio">Portfolio</a></li> -->
                            <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#about">A propos</a></li>
                            <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#contact">Contact</a></li>
                        </ul>
                    </div>
                */
                
              ?>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead bg-primary text-white text-center">
            <div class="container d-flex align-items-center flex-column">                
                <!-- Masthead Heading-->
                <h1 class="masthead-heading text-uppercase mb-0">Resource Finder</h1>
                <h2 class="text-uppercase mb-0 mt-3"><i class="fab fa-galactic-republic"></i> Finalizer <i class="fab fa-rebel"></i></h2>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon">v2.0</div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- Masthead Subheading-->     
            </div>
        </header>
        
        <!-- Portfolio Section-->
        <section class="page-section portfolio" id="portfolio">
            <div class="container">
                <!-- Portfolio Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Find</h2>
                
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-search"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                

                <?php 
               
                    /*
                     *  <p class="text-center mt-4"><b>Important</b>: Resources are not yet synchronized with GH on v2. This is for testing purpose until it's fully released.</p>
                        <div class="help-window alert alert-primary">
                        <h4 class="text-center">Recruiting Volunteers</h4>
                        <p class="">
                        Im looking for volunteers to help me build the trees in my database format and launch v2.0. Im currently using an online software to make things easier, but it takes time as the tree is very large.
                        <br>Basicaly, it's only copy pasting the names from <b><a target="_blank" href="http://swgcraft.co.uk/dev/resource_tree.php?server=106&planet=0&mode=full">this page</a></b> to my tool, so anyone can do this.
                         		<br>Please contact me via discord (<b class="text-green">Glenac#3962</b>) or email (<a href="mailto:contact@swgresfinder.com">contact@swgresfinder.com</a>) if you want to help.
                      		</p>
                      	</div>
                    */
                ?>
                
                <!-- Portfolio Grid Items-->
                <div class="row justify-content-center">
                    <div class="row">
                    	<div class="col-lg-12 mx-auto mt-5">
                    	
                    		<nav>
                            	<div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                                	<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Search by class</button>
                                	<button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Resource Tree</button>
                                	<!-- <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Resources Unavailable</button> -->
                             	</div>
                            </nav>
                                                        
                            <div class="tab-content" id="nav-tabContent">
                              <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="nav-home-tab">
                                 <div class="col-lg-12 mx-auto mt-5">
                                 	

                                 	<div class="col-lg-4 mx-auto">
                                     	<select id="tableGroupSelect" class="form-select select2"  aria-label="Default select example" searchable="Search here..">
                                			<option value="0">-- Select --</option>
                                			<?php 
                                			     foreach($groups as $group){
                                			         echo '<option value="'.$group.'">'.ucwords(str_replace('_', ' ', $group)).'</option>';
                                			     }
                                			?>
                                		</select>
                                 	</div>
                            		
                            		
                            		<table id="resourceTable1" class="resourceTable table table-responsive table-hover table-striped mt-3 align-middle">
                            			<thead>
                            				<tr>
                                				<th data-field="name">name</th>
                                				<th data-field="type_name">Type</th>
                                				<th data-field="CR">CR</th>
                                				<th data-field="CD">CD</th>
                                				<th data-field="DR">DR</th>
                                				<th data-field="FL">FL</th>
                                				<th data-field="HR">HR</th>
                                				<th data-field="MA">MA</th>
                                				<th data-field="PE">PE</th>
                                				<th data-field="OQ">OQ</th>
                                				<th data-field="SR">SR</th>
                                				<th data-field="UT">UT</th>
                                				<th data-field="ER">ER</th>
                                				<th data-field="enter_date">Age</th>
                                				<th data-field="planet">Planet</th>
                            				</tr>                    				
                            			</thead>                   		
                            		</table>               		
                    		  	</div>
                              </div>
                              <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="nav-profile-tab">                              
                               
                               <div class="treeview-animated w-20 border mx-auto mx-4-lg my-4 col-md-8">
                                	<h6 class="pt-3 pl-3 mx-3">Resources Tree</h6>
                                	<hr>
                                  	<ul id="resourcesTreeView" class="treeview-animated-list mb-3">
                                  	 <?php
                                  	     $categories = $categoryClass->getCategoriesByDepth();
                                  	     foreach($categories as  $key1 => $category_1){
                                  	      //   print_r($category_1);
                                  	         echo '<li class="menu_'.$category_1['id_category'].'">
                                                        <a class="categoryTreeLink categoryTreeLink_'.$category_1['id_category'].($category_1['children'] == 0 ? ' type-last-item' : '').'"
                                                           href="javascript:void(0);"
                                                           data-level="'.$category_1['level_depth'].'"
                                                           data-parent="'.$category_1['id_category'].'">
                                                        <i class="bi '.($category_1['children'] > 0 ? 'bi-arrow-right-circle' : 'bi-circle').'"></i>'.ucwords($category_1['name']).'</a>
                                                    </li>';
                                  	     }
                                  	 //print_r($categories->getCategoriesByDepth()) //
                                  	 
                                  	 ?>
                                  	</ul>
    							</div>
    							
    							<table id="resourceTable2" class="resourceTable table table-responsive table-hover table-striped mt-3 align-middle">
                        			<thead>
                        				<tr>
                            				<th data-field="name">name</th>
                            				<th data-field="type_name">Type</th>
                            				<th data-field="CR">CR</th>
                            				<th data-field="CD">CD</th>
                            				<th data-field="DR">DR</th>
                            				<th data-field="FL">FL</th>
                            				<th data-field="HR">HR</th>
                            				<th data-field="MA">MA</th>
                            				<th data-field="PE">PE</th>
                            				<th data-field="OQ">OQ</th>
                            				<th data-field="SR">SR</th>
                            				<th data-field="UT">UT</th>
                            				<th data-field="ER">ER</th>
                            				<th data-field="enter_date">Age</th>
                            				<th data-field="planet">Planet</th>
                        				</tr>                    				
                        			</thead>                   		
                        		</table>
                              </div>
                              <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="nav-profile-tab">
                               
                               <p class="text-center mt-4">Not working yet</p>
                               <div class="treeview-animated w-20 border mx-auto mx-4-lg my-4 col-md-8">
                                	<h6 class="pt-3 pl-3 mx-3">Resources Tree</h6>
                                	<hr>
                                  	<ul id="resourcesTreeViewDisabled" class="treeview-animated-list mb-3">
                                  	 <?php
                                  	 /*
                                  	     $categories = $categoryClass->getCategoriesByDepth();
                                  	     foreach($categories as  $key1 => $category_1){
                                  	      //   print_r($category_1);
                                  	         echo '<li class="menu_'.$category_1['id_category'].'">
                                                        <a class="categoryTreeLink categoryTreeLink_'.$category_1['id_category'].($category_1['children'] == 0 ? ' type-last-item' : '').'"
                                                           href="javascript:void(0);"
                                                           data-level="'.$category_1['level_depth'].'"
                                                           data-parent="'.$category_1['id_category'].'">
                                                        <i class="bi '.($category_1['children'] > 0 ? 'bi-arrow-right-circle' : 'bi-circle').'"></i>'.ucwords($category_1['name']).'</a>
                                                    </li>';
                                  	     }*/
                                  	 //print_r($categories->getCategoriesByDepth()) //
                                  	 
                                  	 ?>
                                  	</ul>
    							</div>
    							
    							<table id="resourceTable3" class="resourceTable table table-responsive table-hover table-striped mt-3 align-middle">
                        			<thead>
                        				<tr>
                            				<th data-field="name">name</th>
                            				<th data-field="type_name">Type</th>
                            				<th data-field="CR">CR</th>
                            				<th data-field="CD">CD</th>
                            				<th data-field="DR">DR</th>
                            				<th data-field="FL">FL</th>
                            				<th data-field="HR">HR</th>
                            				<th data-field="MA">MA</th>
                            				<th data-field="PE">PE</th>
                            				<th data-field="OQ">OQ</th>
                            				<th data-field="SR">SR</th>
                            				<th data-field="UT">UT</th>
                            				<th data-field="ER">ER</th>
                            				<th data-field="enter_date">Age</th>
                            				<th data-field="planet">Planet</th>
                        				</tr>                    				
                        			</thead>                   		
                        		</table>
                              </div>                              
                            </div>                              		
                    	</div> 
					</div>	
                </div>
            </div>
        </section>        

	  <section class="page-section bg-primary text-white mb-0" id="about">
		<div class="col-md-8 mx-auto my-0">
	  		<p class="text-center my-0">Data are updated once per day. There may be a delay between Galaxyharvester and this website.</p>
	  	</div>
	  </section>
      <footer class="footer text-center">
            <div class="container">
            	<div class="col-md-8 mx-auto mb-5">
                    <p class="text-center mt-4">Please report any bug or suggestion to: <a href="mailto:contact@swgresfinder.com">contact@swgresfinder.com</a></p>
	  			</div>
                <div class="row" id="footer_row">            	
                	<h2 class="page-section-heading text-center text-uppercase text-white">CREDITS</h2>
                	 <!-- Icon Divider-->
                    <div class="divider-custom divider-light">
                        <div class="divider-custom-line"></div>
                        <div class="divider-custom-icon"><i class="fa fa-atom"></i></div>
                        <div class="divider-custom-line"></div>
                    </div>
                	<div class="col-xs-12 col-md-6 mt-4 mt-lg-3">
                		<a href="https://galaxyharvester.net/" class="clearfix"><img class="img-responsive" src="https://galaxyharvester.net/images/headers/lothal01.png"></a>
                		
                	</div>
                	<div class="col-xs-12 col-md-6 mt-5 mt-lg-3">
                		<a href="https://www.swgemu.com/" class="clearfix"><img  class="img-responsive" src="https://www.swgemu.com/forums/images/Styles/Blackend/misc/logo_yellow.png" height="100px"></a>
                	</div>
       			</div>
       		</div>
       			
       
       </footer>
        <!-- Copyright Section-->
        <div class="copyright py-4 text-center text-white">
            <div class="container">contact: <a href="mailto:contact@swgresfinder.com">contact@swgresfinder.com</a></div>
            <div class="container">Character Name (Finalizer): <b class="text-green">Glenac Smodre</b></div>
            <div class="container"><small>Copyright - swgresfinder.com &copy; 2022</small></div> 
        </div>

           <!-- Portfolio Modal 5-->
        <div class="portfolio-modal modal fade" id="planetModal" tabindex="-1" aria-labelledby="planetModal" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
                    <div class="modal-body text-center pb-5">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <!-- Portfolio Modal - Title-->
                                    <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Planets</h2>
                                    <!-- Icon Divider-->
                                    <div class="divider-custom">
                                        <div class="divider-custom-line"></div>
                                        <div class="divider-custom-icon"><i class="fas fa-globe"></i></div>
                                        <div class="divider-custom-line"></div>
                                    </div>
                                    <h3 class="text-uppercase mb-0" id="modalResName">Res NAme</h3>
                                    <!-- Portfolio Modal - Text-->
                                    <p class="mb-4"></p>
                                    <ul id="planetList" class="list-group list-group-horizontal-lg my-3">
                                    	                                   
                                    </ul>
                                    <button class="btn btn-primary" href="javascript:void(0)" data-bs-dismiss="modal">
                                        <i class="fas fa-times fa-fw"></i>
                                        Close Window
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
        
    </body>
</html>
