<?php
session_start();
error_reporting(0);

include('includes/config.php');
?>
<!doctype html>

<html>

<head>

  <meta charset="utf-8">
  <title>Internship Portal || Home Page</title>
  <!--CUSTOM CSS-->
  <link href="css/custom.css" rel="stylesheet" type="text/css">
  <!--BOOTSTRAP CSS-->
  <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
  <!--COLOR CSS-->
  <link href="css/color.css" rel="stylesheet" type="text/css">
  <!--RESPONSIVE CSS-->
  <link href="css/responsive.css" rel="stylesheet" type="text/css">
  <!--OWL CAROUSEL CSS-->
  <link href="css/owl.carousel.css" rel="stylesheet" type="text/css">
  <!--FONTAWESOME CSS-->
  <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!--SCROLL FOR SIDEBAR NAVIGATION-->
  <link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">
  <!--GOOGLE FONTS-->
  <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,500,700,900' rel='stylesheet' type='text/css'>
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        select[name=jobtitle] , select[name=location], select[name=city], select[name=allowance], select[name=sector] {
          width: 100%;
          margin-bottom: 10px;
        }

    </style>
</head>



<body class="theme-style-1">

  <!--WRAPPER START-->
  <div id="wrapper">
    <!--HEADER START-->
    <?php include_once('includes/header.php'); ?>
    <!--HEADER END-->
    <!--BANNER START-->

    <div class="banner-outer">
      <div id="banner" class="element"> </div>
      <div class="caption">
        <div class="holder">
          <h1>Search Online Internship</h1>
          <!-- Search Start -->
          <form method="post" action="job-search.php" style="padding:0">
          <div class="container-fluid bg-dark mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
              <div class="container">
                <div class="row g-2">
                      <div class="col-md-2">
                        <select class="form-select border-0" name="jobtitle">
                          <option value="">Select Job Type</option>
                          <option value="Java Developer">Java Developer</option>
                          <option value="Software Application Developer">Software Application Developer</option>
                          <option value="Designer">Designer</option>
                          <option value="Chart Analysis">Chart Analysis</option>
                          <option value="IT Consultant">IT Consultant</option>
                          <option value="Database">Database</option>
                        </select>
                      </div>

                      <div class="col-md-2 pl-0">
                        <select class="form-select border-0 py-3" name="location">
                          <option value="">Select State</option>
                          
                        </select>
                      </div>

                      <div class="col-md-2">
                        <select class="form-select border-0 py-3 w-100" name="city">
                          <option value="">Select City</option>
                        </select>
                      </div>

                      <div class="col-md-2">
                        <select class="form-select border-0 py-3 w-100" name="allowance">
                          <option value="">Select Allowance</option>
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </div>

                      <div class="col-md-2">
                        <select class="form-select border-0 py-3 w-100" name="sector">
                          <option value="">Select Sector</option>
                          <option value="government">Government </option>
                          <option value="private">Private</option>
                        </select>
                      </div>

                      <div class="col-md-2">
                        <button type="submit" name="search" class="btn btn-success">Search</button>
                    </div>

                    </div>
                  </div>

                  
               
            
          </div>
          </form>
          <!-- Search End -->


          <?php if (strlen($_SESSION['jsid'] == 0)) { ?>
            <div class="btn-row"> <a href="sign-up.php"><i class="fa fa-user"></i>I???m a Student</a> <a href="employers/emp-login.php"><i class="fa fa-building-o"></i>I???m an Employer</a> </div>
          <?php } ?>
        </div>

      </div>

      <div class="browse-job-section">


      </div>

    </div>



    <div id="main">



      <section class="popular-categories">

        <div class="container">

          <div class="clearfix">

            <h2>Popular Internship Categories</h2>

            <a href="#" class="btn-style-1">Explore All Internship</a>
          </div>

          <div class="row">
            <?php
            $sql = "SELECT jobCategory,count(jobId) as totaljobs from tbljobs group by jobCategory";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            foreach ($results as $row) {               ?>
              <div class="col-md-3 col-sm-6">

                <div class="box"> <img src="images/jobs.jpg" alt="img" width="68" height="68">

                  <h4><a href="view-categorywise-job.php?viewid=<?php echo htmlentities($row->jobCategory); ?>"><?php echo htmlentities($row->jobCategory); ?></a></h4>

                  <strong><?php echo htmlentities($row->totaljobs); ?></strong>



                </div>

              </div>
            <?php } ?>



          </div>

        </div>

      </section>



      <section class="recent-row padd-tb">

        <div class="container">

          <div class="row">

            <div class="col-md-12 col-sm-8">

              <div id="content-area">

                <h2>Recent Hot Internship</h2>

                <ul id="myList">

                  <li>
                    <?php
                    if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
                      $page_no = $_GET['page_no'];
                    } else {
                      $page_no = 1;
                    }
                    // Formula for pagination
                    $no_of_records_per_page = 5;
                    $offset = ($page_no - 1) * $no_of_records_per_page;
                    $previous_page = $page_no - 1;
                    $next_page = $page_no + 1;
                    $adjacents = "2";
                    $ret = "SELECT jobId FROM tbljobs";
                    $query1 = $dbh->prepare($ret);
                    $query1->execute();
                    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                    $total_rows = $query1->rowCount();
                    $total_no_of_pages = ceil($total_rows / $no_of_records_per_page);
                    $second_last = $total_no_of_pages - 1; // total page minus 1
                    $sql = "SELECT tbljobs.*,tblemployers.CompnayLogo,tblemployers.CompnayName from tbljobs join tblemployers on tblemployers.id=tbljobs.employerId order by tbljobs.salaryPackage desc LIMIT $offset, $no_of_records_per_page ";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    $cnt = 1;
                    if ($query->rowCount() > 0) {
                      foreach ($results as $row) {               ?>
                        <div class="box">

                          <div class="thumb"><a href="jobs-details.php?jid=<?php echo ($row->jobId); ?>"><img src="employers/employerslogo/<?php echo $row->CompnayLogo; ?>" width="100" height="100"></a></div>

                          <div class="text-col">
                            <h4><a href="jobs-details.php?jid=<?php echo ($row->jobId); ?>"><?php echo htmlentities($row->jobTitle); ?></a></h4>
                            <p><?php echo htmlentities($row->CompnayName); ?></p>
                            <a href="jobs-details.php?jid=<?php echo ($row->jobId); ?>" class="text"><i class="fa fa-map-marker"></i><?php echo htmlentities($row->jobLocation.','.$row->city); ?></a> <a href="#" class="text"><i class="fa fa-calendar"></i><?php echo htmlentities($row->postinDate); ?> </a>
                          </div>

                          <?php if($row->salaryPackage){
                        echo ' <strong class="price">
                        <i class="fa fa-money"></i>'.$row->salaryPackage.'
                      </strong>';
                      }?>
                          <?php if ($row->jobType == "Full Time") { ?><a href="jobs-details.php?jid=<?php echo ($row->jobId); ?>" class="btn-1 btn-color-2 ripple"><?php echo htmlentities($row->jobType); ?></a>
                          <?php }
                          if ($row->jobType == "Contract") { ?>
                            <a href="jobs-details.php?jid=<?php echo ($row->jobId); ?>" class="btn-1 btn-color-4 ripple"><?php echo htmlentities($row->jobType); ?></a>
                          <?php }
                          if ($row->jobType == "Freelance") { ?>
                            <a href="jobs-details.php?jid=<?php echo ($row->jobId); ?>" class="btn-1 btn-color-3 ripple"><?php echo htmlentities($row->jobType); ?></a>
                          <?php }
                          if ($row->jobType == "Part Time") { ?>
                            <a href="jobs-details.php?jid=<?php echo ($row->jobId); ?>" class="btn-1 btn-color-1 ripple"><?php echo htmlentities($row->jobType); ?></a>

                          <?php } ?>
                        </div>

                  </li>

              <?php $cnt = $cnt + 1;
                      }
                    } ?>


                </ul>

                <div align="left">
                  <ul class="pagination">

                    <li <?php if ($page_no <= 1) {
                          echo "class='disabled'";
                        } ?>>
                      <a <?php if ($page_no > 1) {
                            echo "href='?page_no=$previous_page'";
                          } ?>>Previous</a>
                    </li>

                    <?php
                    if ($total_no_of_pages <= 10) {
                      for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                        if ($counter == $page_no) {
                          echo "<li class='active'><a>$counter</a></li>";
                        } else {
                          echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                        }
                      }
                    } elseif ($total_no_of_pages > 10) {

                      if ($page_no <= 4) {
                        for ($counter = 1; $counter < 8; $counter++) {
                          if ($counter == $page_no) {
                            echo "<li class='active'><a>$counter</a></li>";
                          } else {
                            echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                          }
                        }
                        echo "<li><a>...</a></li>";
                        echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                        echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                      } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                        echo "<li><a href='?page_no=1'>1</a></li>";
                        echo "<li><a href='?page_no=2'>2</a></li>";
                        echo "<li><a>...</a></li>";
                        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                          if ($counter == $page_no) {
                            echo "<li class='active'><a>$counter</a></li>";
                          } else {
                            echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                          }
                        }
                        echo "<li><a>...</a></li>";
                        echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
                        echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                      } else {
                        echo "<li><a href='?page_no=1'>1</a></li>";
                        echo "<li><a href='?page_no=2'>2</a></li>";
                        echo "<li><a>...</a></li>";

                        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                          if ($counter == $page_no) {
                            echo "<li class='active'><a>$counter</a></li>";
                          } else {
                            echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                          }
                        }
                      }
                    }
                    ?>

                    <li <?php if ($page_no >= $total_no_of_pages) {
                          echo "class='disabled'";
                        } ?>>
                      <a <?php if ($page_no < $total_no_of_pages) {
                            echo "href='?page_no=$next_page'";
                          } ?>>Next</a>
                    </li>
                    <?php if ($page_no < $total_no_of_pages) {
                      echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
                    } ?>
                  </ul>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>



      <section class="call-action-section">

        <div class="container">

          <div class="text-box">
            <h2>Better Results with Standardized Hiring Process</h2>
            <p>Your quality of hire increases when you treat everyone fairly and equally. Having multiple recruiters
              working on your hiring is beneficial.</p>
          </div>
          <a href="sign-up.php" class="btn-get">Get Registered &amp; Try Now</a>
        </div>
      </section>
    </div>

    <?php include_once('includes/footer.php'); ?>

  </div>
  <script src="js/jquery-1.11.3.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.velocity.min.js"></script>
  <script src="js/jquery.kenburnsy.js"></script>
  <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="js/custom.js"></script>
  <script src='js/statecity.js'></script>

  <script>
    var getStateCity = getStateCity();

    $.each(getStateCity, (k,v) => {
      $('select[name=location]').append(
        $('<option>').text(k).val(k)
      )
    });

    $('select[name=location]').change((e)=>{
      var val = $(e.currentTarget).val();
      $('select[name=city]').empty();
      
      $.each(getStateCity, (state,city) => {
        if(state == val){
          $.each(city, (k,v)=> {
            $('select[name=city]').append(
              $('<option>').text(v).val(v)
            )
          })
        }
      });
    })
    
   
  </script>

</body>

</html>