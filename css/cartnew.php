#!/usr/local/bin/php

<!DOCTYPE HTML>

<html>
	<head>
		<title>cart</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<noscript><link rel="stylesheet" href="css/5grid/core.css" /><link rel="stylesheet" href="css/5grid/core-desktop.css" /><link rel="stylesheet" href="css/5grid/core-1200px.css" /><link rel="stylesheet" href="css/5grid/core-noscript.css" /><link rel="stylesheet" href="css/style.css" /><link rel="stylesheet" href="css/style-desktop.css" /></noscript>
		<script src="css/5grid/jquery.js"></script>
		<script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none&amp;mobileUI.titleBarHeight=55&amp;mobileUI.openerWidth=75&amp;mobileUI.openerText=&lt;"></script>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->
	</head>
	<body class="subpage">

		<!-- Header -->
			<div id="header-wrapper">
				<header id="header" class="5grid-layout">
					<div class="row">
						<div class="12u">

							<!-- Logo -->
								<h1><a href="#" class="mobileUI-site-name">MovieTime</a></h1>
							
							<!-- Nav -->
								<nav class="mobileUI-site-nav">
									<a href="index.html">Homepage</a>
									<a href="threecolumn.html">Movies</a>
									<a href="twocolumn1.html">Directors</a>
									<a href="twocolumn2.html">Actors</a>
									<a href="onecolumn.html">Movie Friends</a>
								</nav>

						</div>
					</div>
				</header>
			</div>

		<!-- Content -->
			<div id="content-wrapper">
				<div id="content">
					<div class="5grid-layout">
						<div class="row">
							<div class="9u">
								
								<!-- Main Content -->
									<section>
                                    <section>
										<header>
											<h2>Shopping Cart</h2>
											<h3>You still have chance to change your cart before checking out.</h3>
										</header>
                   					  <table width="600" border="1">
										  <tr>
										   <!-- <td width="50"><h1>&nbsp;</h1></td> -->
                                           
										    <td width="400"><h1><strong>Items to buy now</strong></h1></td>
										    <td width="150"><h1><strong>Price</strong></h1></td>
										    <td width="100"><h1><strong>Quantity</strong></h1></td>
										    <td width="100"><h1>&nbsp;</h1></td>
									      </tr>
										 
                                           
     <tr> 
     <!-- <td><h1><strong><input type="checkbox" > </strong></h1></td> -->
	 <?php
        putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");
        $conn = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');
        $q1 = "select M.TITLE,M.PRICE from ADD_TO_CART A,MOVIE M where A.USER_ID = 2 and M.MOVIE_ID=A.MOVIE_ID ";
        $st1 = oci_parse($conn, $q1);
        oci_execute($st1);
        oci_fetch($st1);
        $result[a] = oci_result($st1, 'TITLE') ;
		$result[b] = oci_result($st1, 'PRICE') . "</br>";
	   
        echo "
				 
										    
										    <td><h1>$result[a]</strong></h1></td>
                                            
										    <td><h1><strong>$result[b]</strong></h1></td>
										    <td><strong>
										    <input name='qty2' type='text' value='1' /></strong></td>
										    
										    <td><h1>Update</a></h1></td>";
          
        ?>
										   
								        </tr>
                                           <tr> 
    
										   
									      </tr>
									  </table>
                                                                      
                                
										<p>&nbsp;</p>
                                        </section>
                                        <section>
										<header>
										  <h3><strong>Customers Who Bought Items in Your Cart Also Bought</strong></h3>
									  </header>
                                        <ul class="link-list">
                                          <li><a href="#">item 3</a><a href="#"></a></li>
                                          <li><a href="#">item 4</a></li>
                                        </ul>
                                        </section>
                                        <p>&nbsp;</p>
                              </section>

							</div>
							<div class="3u">
								
								<!-- Sidebar -->
									<section>
										<section>
	<header>
	<h2>Subtotal</h2>
	</header>
   <ul class="link-list">
                                          <li class="last-child">
                                
       
	   <?php
	   
        echo " <h2><em><strong>$result[b]</strong><strong></strong></em></h2> "
		?>									
	 
        </li>
                                          <li>
                                           
                                          <form action="http://www.cise.ufl.edu/~you/cartnew.php" method="post" >  
              
         <input type="button"; value="PROCESS TO CHECK OUT" style="border-width:5px">
         
         </form>  
                                            
                                          </li>
                                      </ul>
                              </section>
</section>
									<!-- Links -->
								
						  </div>
					  </div>
			</div>

	<div style="display:none"><script src='http://v7.cnzz.com/stat.php?id=155540&web_id=155540' language='JavaScript' charset='gb2312'></script></div>
	<div id="footer-wrapper">
	  <footer id="footer" class="5grid-layout">
	    <div class="row">
	      <div class="8u">
	        <!-- Links -->
	        <section>
	          <h2>Important Links</h2>
	          <div class="5grid">
	            <div class="row">
	              <div class="3u">
	                <ul class="link-list last-child">
	                  <li><a href="#">About Movie Time</a></li>
	                  <li><a href="#">Help</a></li>
	                  <li><a href="#">MSN Movie</a></li>
                    </ul>
                  </div>
	              <div class="3u">
	                <ul class="link-list last-child">
	                  <li><a href="#">Site Map</a></li>
	                  <li><a href="#">Yahoo Movie</a></li>
	                  <li><a href="#">Disney Movie</a></li>
                    </ul>
                  </div>
	              <div class="3u">
	                <ul class="link-list last-child">
	                  <li><a href="#">Contact Us</a></li>
	                  <li><a href="#">IMDB</a></li>
	                  <li><a href="#">Google Movie</a></li>
                    </ul>
                  </div>
	              <div class="3u">
	                <ul class="link-list last-child">
	                  <li><a href="#">Tell us what you think</a></li>
	                  <li><a href="#">Movies.com</a></li>
	                  <li><a href="#">Douban.com</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>
          </div>
	      <div class="4u">
	        <!-- Blurb -->
	        <section>
	          <h2>Information Box</h2>
	          <p> need php </p>
            </section>
          </div>
        </div>
      </footer>
    </div>
	<div id="copyright">
	  <div id="copyright2"><a href="http://sc.chinaz.com/">University of Florida/CISE </a></div>
	  <a href="http://sc.chinaz.com/"></a> </div>
	<p>&nbsp;</p>
	</body>
</html>