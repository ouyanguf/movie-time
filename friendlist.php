#!/usr/local/bin/php



<?php
session_start();
if (!session_is_registered(curuserid)) {
    $reg = 0;
    header("location:login.php");
} else {
    $reg = 1;
}
?>

<!DOCTYPE HTML>

<html>
    <head>
        <title>Fridend List</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <noscript><link rel="stylesheet" href="css/5grid/core.css" /><link rel="stylesheet" href="css/5grid/core-desktop.css" /><link rel="stylesheet" href="css/5grid/core-1200px.css" /><link rel="stylesheet" href="css/5grid/core-noscript.css" /><link rel="stylesheet" href="css/style.css" /><link rel="stylesheet" href="css/style-desktop.css" /></noscript>
        <script src="css/5grid/jquery.js"></script>
        <script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none&amp;mobileUI.titleBarHeight=55&amp;mobileUI.openerWidth=75&amp;mobileUI.openerText=&lt;"></script>
        <!--[if lte IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->
    </head>
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
                                echo "<a href=UserProfile.php>Hi, There! | <a href=http://www.cise.ufl.edu/~you/log_out_session.php>LogOut</a>";
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

            <div id="banner" style="margin: 2px; padding: 2px;">
                <div class="5grid-layout">
                    <div class="row">
                        <div class="12u">

                            <!-- Banner Copy -->
                            <form style="text-align:right;" action="http://www.cise.ufl.edu/~you/search_result.php" method="post">
                                <input style="height: 25px; vertical-align:middle;" type="text" name="s_content" size="50" value="" />&nbsp;&nbsp;&nbsp;&nbsp;
                                <select style="vertical-align:middle;font-size:22px;" name="domain">
                                    <option value="title">Movie Title</option>
                                    <option value="r_year">Release Year&nbsp;&nbsp;&nbsp;</option>
                                    <option value="company">Company</option>
                                    <option value="genre">Genre</option>
                                    <option value="director">Director</option>
                                    <option value="actor">Actor</option>
                                </select> &nbsp;&nbsp;&nbsp;
                                <input  style="padding: 1px 20px; font-size: 1em; vertical-align:middle;" class="button-big" type="submit" name="submit" value="Search" />
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div id="content-wrapper">
            <div id="content">
                <div class="5grid-layout">
                    <div class="row">
                        <div class="8u">

                            <!-- Main Content -->
                            <section>
                                <header>
                                    <h2>Your Friends: </h2>
                                    <h3>from Movie Time User List</h3>
                                </header>                
                                <?php
                                //$toname = $_POST['friendname'];
                                $userid = $_SESSION['curuserid'];

                                putenv("ORACLE_HOME=/usr/local/libexec/oracle/app/oracle/product/11.2.0/client_1");
                                $conn = oci_connect('you', '246246abc', '//oracle.cise.ufl.edu/orcl');

                                // $q_findfriend = "select * from muser where username like '%$toname%' union select * from muser where name like'%$toname%'";

                                $q_friends = " select Name, user_id
                                    from add_friend, muser
                                    where from_id=$userid and
                                        to_id = user_id
                                        
                                        union
                                        
                                        select Name, user_id
                                        from add_friend, muser
                                        where to_id=$userid and
                                            from_id = user_id";

                                $statement = oci_parse($conn, $q_friends);
                                oci_execute($statement);

                                if (!oci_fetch_object($statement)) {
                                    echo "<p>Sorry! No records found! Try another one?</p>";
                                } else {
                                    oci_execute($statement);
                                    echo "<table border=1> <tr align=left>
                        <th width=50>No.</th>
                        <th width=100>Friend Name</th>
                        </tr>";
                                    $i = 1;
                                    while (oci_fetch_object($statement) and $i <= 100) {
                                        $friendresult = oci_result($statement, 'NAME');
                                        $send = oci_result($statement, 'USER_ID');
                                        echo "<tr>
                 	  <td>$i</td>
                  	  <td><a href=/~you/frienddisplay.php?USER_ID=$send>$friendresult</a></td>
                       </tr>";
                                        $i++;
                                    }
                                    echo "</table>";
                                    oci_free_statement($statement);
                                }
                                ?>     

                            </section>

                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!--Friend Rec-->
        <div id="content-wrapper">
            <div id="content">
                <div class="5grid-layout">
                    <div class="row">
                        <div class="4u">

                            <!-- Friend Recommendation By Common Friend -->
                            <section>
                                <header>
                                    <h2>Friend You May Know:</h2>										
                                </header>
                                <?php
                                //Friend Recommendation By Common Friend

                                $q1 = "select user_id, name,count(from_id) f
                                       from add_friend, muser
                                       where from_id in (select distinct from_id
                                                         from add_friend
                                                         where to_id=$userid and
                                                         from_id <> $userid)
                                             and
                                             to_id not in(select distinct to_id
                                                          from add_friend
                                                          where from_id=$userid)
                                             and
                                             to_id <> $userid
                                             and to_id=user_id
                                       group by name, user_id
                                       order by f desc
                                       ";
                                $st1 = oci_parse($conn, $q1);
                                oci_execute($st1);
                                echo "<table>
                        <tr>
                        <th>Rank</th>
                        <th width=200 align=center>New Friend</th>
                        <th align=right>Same Friend</th>
                        </tr>
                        ";
                                $i1 = 1;
                                while (oci_fetch_object($st1) and $i1 <= 15) {
                                    $n1 = oci_result($st1, 'NAME');
                                    $send1 = oci_result($st1, 'USER_ID');
                                    $c1 = oci_result($st1, 'F');
                                    echo "<tr>
                        <td align=center>$i1</td>
                        <td align=center><a href=/~you/frienddisplay.php?USER_ID=$send1>$n1</a></td>
                        <td align=right>$c1</td>
                        </tr>";
                                    $i1++;
                                }
                                echo "</table>";
                                oci_free_statement($st1);
                                ?>
                            </section>

                        </div>
                        <div class="4u">

                            <!-- Friend recommendation by Rating Score: -->
                            <section>
                                <header>
                                    <h2>People Who Like The Same Movies As You:</h2>											
                                </header>
                                <?php
                                $q2 = "select u.user_id, name, count(distinct movie_id) sm
                                       from rate r,muser u
                                       where r.user_id = u.user_id and 
                                       score >= 8 and
                                       u.user_id <> $userid and
					    u.user_id not in  (select distinct to_id
                                                          from add_friend
                                                          where from_id=$userid) and
                                       r.movie_id in ( select movie_id
                                                     from rate
                                                     where user_id = $userid and
                                                     score >= 8)
                                       group by name, u.user_id
                                       order by sm desc";
                                $st2 = oci_parse($conn, $q2);
                                oci_execute($st2);
                                echo "<table border=1>
                                  <tr>
                                  <th width=35 align=center>Rank</th>
                                  <th width=200 align=center>New Friend</th>
                                  <th align=right>Same Movies</th>
                                  </tr>
                                  ";
                                $ib = 1;
                                while (oci_fetch_object($st2) and $ib <= 10) {
                                    $n2 = oci_result($st2, 'NAME');
                                    $c2 = oci_result($st2, 'SM');
                                    $send2 = oci_result($st2, 'USER_ID');
                                    echo "<tr>
                                  <td align=center>$ib</td>
                                  <td align=center><a href=/~you/frienddisplay.php?USER_ID=$send2>$n2</a></td>
                                  <td align=right>$c2</td>
                                  </tr>";
                                    $ib++;
                                }
                                echo "</table>";
                                oci_free_statement($st2);
                                ?>

                            </section>

                        </div>
                        <div class="4u">

                            <!-- Recommendation By No. of Same Preference Genre: -->
                            <section>
                                <header>
                                    <h2>People Of The Same Movie Style:</h2>											
                                </header>
                                <?php
//Recommendation By No. of Same Preference Genre
                                $q3 = "select u.user_id, u.name,count(distinct g_name) g
                                       from prefer p, muser u
                                       where p.user_id = u.user_id and
                                             p.user_id <> $userid and
                                             g_name in (select g_name
                                                        from prefer
                                                        where user_id = $userid) and
					    u.user_id not in  (select distinct to_id
                                                          from add_friend
                                                          where from_id=$userid)
                                       group by u.user_id, u.name
                                       order by g desc
                                    ";
                                $st3 = oci_parse($conn, $q3);
                                oci_execute($st3);
                                echo "<table border=1>
                        <tr>
                        <th width=35 align=center>Rank</th>
                        <th width=200 align=center>New Friend</th>
                        <th align=right>Same Genres</th>
                        </tr>
                        ";
                                $i_income = 1;
                                while (oci_fetch_object($st3) and $i_income <= 10) {
                                    $n3 = oci_result($st3, 'NAME');
                                    $c3 = oci_result($st3, 'G');

                                    $send3 = oci_result($st3, 'USER_ID');
                                    echo "<tr>
                        <td align=center>$i_income</td>
                        <td align=center><a href=/~you/frienddisplay.php?USER_ID=$send3>$n3</a></td>
                        <td align=right>$c3</td>
                        </tr>";
                                    $i_income++;
                                }
                                echo "</table>";
                                oci_free_statement($st3);
                                ?>

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