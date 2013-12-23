#!/usr/local/bin/php

<?php
session_start();
if (!session_is_registered(curuserid)) {
    $reg = 0;
} else {
    $reg = 1;
}
?>

<html>

    <head>
    <head>
        <title>Register</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <noscript><link rel="stylesheet" href="css/5grid/core.css" /><link rel="stylesheet" href="css/5grid/core-desktop.css" /><link rel="stylesheet" href="css/5grid/core-1200px.css" /><link rel="stylesheet" href="css/5grid/core-noscript.css" /><link rel="stylesheet" href="css/style.css" /><link rel="stylesheet" href="css/style-desktop.css" /></noscript>
        <script src="css/5grid/jquery.js"></script>
        <script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none&amp;mobileUI.titleBarHeight=55&amp;mobileUI.openerWidth=75&amp;mobileUI.openerText=&lt;"></script>
        <!--[if lte IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->
    </head>
</head>

<body>
    <?php
    $e_username = $_POST['username'];
    $e_password = $_POST['password'];
    $e_name = $_POST['name'];

    if (!$e_username OR !$e_password OR !$e_password) {
        ?>
        <script>alert("Sorry!\nUsername/Password/Name can't be empty!\nPlease Try again!")</script>
        <?php
    } else {
        putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");
        $conn = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');


        $q_check = "select username from muser where username='$e_username'";
        $st1 = oci_parse($conn, $q_check);
        oci_execute($st1);
        $result = oci_fetch_array($st1, OCI_BOTH);
        oci_free_statement($st1);
        if ($result) {
            ?>
            <script>alert("The username you entered already exists!\nPlease try another one!");</script>
            <?php
            oci_close($conn);
        } else {
            $q_maxid = "select MAX(user_id) from muser";
            $st2 = oci_parse($conn, $q_maxid);
            oci_execute($st2);
            $maxid = oci_fetch_array($st2, OCI_BOTH);
            //echo $maxid[0];
            $new_id = intval($maxid[0]) + 1;
            oci_free_statement($st2);

            $e_email = $_POST['email'];
            $e_mon = $_POST['month'];
            $e_day = $_POST['day'];
            $e_year = $_POST['year'];
            $e_street = $_POST['street'];
            $e_city = $_POST['city'];
            $e_state = $_POST['state'];
            $e_zip = $_POST['zip'];
            $p1 = $_POST['p1'];
            $p2 = $_POST['p2'];
            $p3 = $_POST['p3'];
            $q_insert = "insert into muser values ($new_id,'$e_password','$e_name','$e_email',TO_DATE('$e_mon-$e_day-$e_year', 'MON-DD-RRRR'),'$e_street','$e_city','$e_state','$e_zip','$e_username')";
            $st3 = oci_parse($conn, $q_insert);
            oci_execute($st3);
            oci_free_statement($st3);

            $q_insert_p1 = "insert into prefer values ($new_id,'$p1',1)";
            $pre1 = oci_parse($conn, $q_insert_p1);
            oci_execute($pre1);
            oci_free_statement($pre1);

            $q_insert_p2 = "insert into prefer values ($new_id,'$p2',2)";
            $pre2 = oci_parse($conn, $q_insert_p2);
            oci_execute($pre2);
            oci_free_statement($pre2);

            $q_insert_p3 = "insert into prefer values ($new_id,'$p3',3)";
            $pre3 = oci_parse($conn, $q_insert_p3);
            oci_execute($pre3);
            oci_free_statement($pre3);

            oci_close($conn);
            ?>
            <script>alert("Congratulations!\nYou have successfully registered!\nPlease wait for redirecting......");</script>
            <?php
            echo "<meta http-equiv=refresh content=0.01;URL=http://www.cise.ufl.edu/~you/log_in_session.php?userid=$new_id>";
        }
    }
    ?>


<body>

    <!-- Header -->
    <div id="header-wrapper">
        <header id="header" class="5grid-layout">
            <div class="row">
                <div class="12u">

                    <!-- Logo -->
                    <h1><a href="/~you/index.php" class="mobileUI-site-name"><strong>MovieTime</strong></a></h1>

                    <nav class="mobileUI-site-nav" style="position:absolute; top: 0px; right: 0px; font-size: 15px;">
                        <?php
                        if ($reg) {
                            echo "<a href=#>Hi, XXX! | <a href=http://www.cise.ufl.edu/~you/log_out_session.php>LogOut</a>";
                        } else {
                            echo "<a href=http://www.cise.ufl.edu/~you/login.php>LogIn</a>";
                            echo "|<a href=http://www.cise.ufl.edu/~you/register.php>Register</a>";
                        }
                        ?>
                    </nav>

                    <!-- Nav -->
                    <nav class="mobileUI-site-nav">
                        <a href="index.php">Homepage</a>
                        <a href="ranking.php">TOPS</a>
                        <a href="friendlist.php">Movie Friend</a>
                        <a href="cart.php">My Cart</a>
                        <a href="UserProfile.php">My Time</a>
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
                    <div class="6u" style="position:relative; left:318px;">

                        <!-- Main Content -->
                        <section>
                            <header>
                                <h2 style="text-align:center;">Becoming a Movie Timer!</h2>
                            </header>

                            <p>
                            <form action="http://www.cise.ufl.edu/~you/registercheck.php" method="post">
                                <p style="position:relative; left: 40px; font-size: 1.2em;">Username*:<br/>
                                    <input type="text" name="username" size="60" value="<?php echo $e_username; ?>" />
                                </p>
                                <p style="position:relative; left: 40px; font-size: 1.2em;">Password*:<br/>
                                    <input type="password" name="password" size="60" value="<?php echo $e_password; ?>" />
                                </p>
                                <p style="position:relative; left: 40px; font-size: 1.2em;">Full Name*:<br/>
                                    <input type="text" name="name" size="60" value="<?php echo $e_name; ?>" />
                                </p>         
                                <p style="position:relative; left: 40px; font-size: 1.2em;">Email:<br/>
                                    <input type="text" name="email" size="60" value="" />
                                </p>
                                <p style="position:relative; left: 40px; font-size: 1.2em;">Birthday:</br>
                                    Month:&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="month" value="Jan">
                                        <option value="Jan">Jan</option>
                                        <option value="Feb">Feb</option>
                                        <option value="Mar">Mar</option>
                                        <option value="Apr">Apr</option>
                                        <option value="May">May</option>
                                        <option value="Jun">Jun</option>
                                        <option value="Jul">Jul</option>
                                        <option value="Aug">Aug</option>
                                        <option value="Sep">Sep</option>
                                        <option value="Oct">Oct</option>
                                        <option value="Nov">Nov</option>
                                        <option value="Dec">Dec</option>
                                    </select>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    Day:&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php
                                    echo "<select name=day>";
                                    for ($i = 1; $i <= 31; $i++) {
                                        echo "<option value=$i>$i</option>"; ////if (isset($_POST['month'])) {
                                    }
                                    echo "</select>";
                                    ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    Year:&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php
                                    echo "<select name=year>";
                                    for ($i = 2013; $i >= 1900; $i--) {
                                        echo "<option value=$i>$i</option>"; ////if (isset($_POST['month'])) {
                                    }
                                    echo "</select>";
                                    ?>
                                </p>
                                <p style="position:relative; left: 40px; font-size: 1.2em;">Your Movie Stytle:</br>
                                    First Choice:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="p1" style="width:15em;">
                                        <option value="Music">Music</option>
                                        <option value="Documentary">Documentary</option>
                                        <option value="Comedy">Comedy</option>
                                        <option value="Animation">Animation</option>
                                        <option value="Drama">Drama</option>
                                        <option value="Western">Western</option>
                                        <option value="Fantasy">Fantasy</option>
                                        <option value="TV Classics">TV Classics</option>
                                        <option value="Thriller">Thriller</option>
                                        <option value="Mystery/Suspense">Mystery/Suspense</option>
                                        <option value="Horror">Horror</option>
                                        <option value="Foreign">Foreign</option>
                                        <option value="Action/Adventure">Action/Adventure</option>
                                        <option value="SciFi">SciFi</option>
                                        <option value="Sports">Sports</option>
                                        <option value="War">War</option>
                                        <option value="History Channel">History Channel</option>
                                        <option value="Dance/Ballet">Dance/Ballet</option>
                                    </select>
                                    </br>
                                    Second Choice:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="p2" style="width:15em;">
                                        <option value="Documentary">Documentary</option>
                                               <option value="Music">Music</option>
                                        
                                        <option value="Comedy">Comedy</option>
                                        <option value="Animation">Animation</option>
                                        <option value="Drama">Drama</option>
                                        <option value="Western">Western</option>
                                        <option value="Fantasy">Fantasy</option>
                                        <option value="TV Classics">TV Classics</option>
                                        <option value="Thriller">Thriller</option>
                                        <option value="Mystery/Suspense">Mystery/Suspense</option>
                                        <option value="Horror">Horror</option>
                                        <option value="Foreign">Foreign</option>
                                        <option value="Action/Adventure">Action/Adventure</option>
                                        <option value="SciFi">SciFi</option>
                                        <option value="Sports">Sports</option>
                                        <option value="War">War</option>
                                        <option value="History Channel">History Channel</option>
                                        <option value="Dance/Ballet">Dance/Ballet</option>
                                    </select>
                                    </br>
                                    Third Choice:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="p3" style="width:15em;">
                                        <option value="Comedy">Comedy</option>
                                               <option value="Music">Music</option>
                                        <option value="Documentary">Documentary</option>
                                        
                                        <option value="Animation">Animation</option>
                                        <option value="Drama">Drama</option>
                                        <option value="Western">Western</option>
                                        <option value="Fantasy">Fantasy</option>
                                        <option value="TV Classics">TV Classics</option>
                                        <option value="Thriller">Thriller</option>
                                        <option value="Mystery/Suspense">Mystery/Suspense</option>
                                        <option value="Horror">Horror</option>
                                        <option value="Foreign">Foreign</option>
                                        <option value="Action/Adventure">Action/Adventure</option>
                                        <option value="SciFi">SciFi</option>
                                        <option value="Sports">Sports</option>
                                        <option value="War">War</option>
                                        <option value="History Channel">History Channel</option>
                                        <option value="Dance/Ballet">Dance/Ballet</option>
                                    </select>
                                </p>
                                <p style="position:relative; left: 40px; font-size: 1.2em;">Street:<br/>
                                    <input type="text" name="street" size="60" value="" />
                                </p>
                                <p style="position:relative; left: 40px; font-size: 1.2em;">City:<br/>
                                    <input type="text" name="city" size="60" value="" />
                                </p>
                                <p style="position:relative; left: 40px; font-size: 1.2em;">State:<br/>
                                    <input type="text" name="state" size="60" value="" />
                                </p>
                                <p style="position:relative; left: 40px; font-size: 1.2em;">Zip-code:<br/>
                                    <input type="text" name="zip" size="60" value="" />
                                </p>

                                <p style="position:relative; left: 130px;">
                                    <input style="padding: 0.8px 42px; font-size: 1.5em;" class="button-big" type="submit" name="submit" value="Creat Account" />
                                </p>
                                <p style="position:relative; left: 219px;font-size: 1.6em;">
                                    OR
                                </p>
                            </form>
                            <p style="position:relative; left: 115px">
                                <button style="padding: 5px 25px; font-size: 1.5em;" class="button-big" onclick="location.href='http://www.cise.ufl.edu/~you/login.php'">Back To Log In</button>
                            </p>

                        </section>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
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
                                        <li><a href="#">About Movie Time </a></li>
                                        <li><a href="#">Help </a></li>
                                        <li><a href="http://movies.msn.com/" target="_blank">MSN Movie</a></li>

                                    </ul>
                                </div>
                                <div class="3u">
                                    <ul class="link-list last-child">
                                        <li><a href="/~you/site_map.html">Site Map</a></li>
                                        <li><a href="http://movies.yahoo.com/" target="_blank">Yahoo Movie </a></li>
                                        <li><a href="http://movies.disney.com/" target="_blank">Disney Movie</a></li>

                                    </ul>
                                </div>
                                <div class="3u">
                                    <ul class="link-list last-child">
                                        <li><a href="/~you/contact.php">Contact us</a></li>
                                        <li><a href="http://www.imdb.com/" target="_blank">IMDB</a></li>
                                        <li><a href="http://www.google.com/movies" target="_blank">Google Movie</a></li>

                                    </ul>
                                </div>
                                <div class="3u">
                                    <ul class="link-list last-child">
                                        <li><a href="/~you/contact.php">Tell us what you think</a></li>
                                        <li><a href="http://www.movies.com/" target="_blank">Movies.com</a></li>
                                        <li><a href="http://www.mtime.com/">Mtime</a></li>

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
                       
                        <p>Copyright ©2013 G6. All Rights Reserved.

                        </p>
                    </section>

                </div>
            </div>
        </footer>
    </div>

    <!-- Copyright -->
    <div id="copyright">
        <a href="http://www.ufl.edu/" target="_blank">University of Florida</a> / <a href="http://www.cise.ufl.edu/" target="_blank">CISE</a>
    </div>



</body>
</html>

