 
 <footer id="footer">

    <div class="text-box box">

      <h4 style="color: red">Internship Portal</h4>
<?php
$sql="SELECT * from tblpages where PageType='contactus'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
  <ul>
      <li> <i class="fa fa-phone"></i> <strong>+ 60<?php  echo htmlentities($row->MobileNumber);?></strong></li>

                    <li> <i class="fa fa-envelope-o"></i> <strong><?php  echo htmlentities($row->Email);?></strong> </li>

                    <li> <i class="fa fa-globe"></i> <strong><?php  echo htmlentities($row->PageDescription);?></strong> </li>
<?php $cnt=$cnt+1;}} ?></ul>
    </div>

    <div class="box">

      <h4>Quick Links</h4>

      <ul>

        <li><a href="about.php">About</a></li>

        <li><a href="contact.php">Contact</a></li>
        <li><a href="index.php">Home</a></li>
<?php if (strlen($_SESSION['jsid']==0)) {?>
        <li><a href="admin/index.php">Admin</a></li>

        <li><a href="my-profile.php">Student</a></li>

        <li><a href="employers/emp-login.php">Employer</a></li>
<?php } ?>
        

      </ul>

    </div>

    <div class="box">

      <h4>Internship Category</h4>

      <ul>
<?php
$sql="SELECT jobCategory,count(jobId) as totaljobs from tbljobs group by jobCategory";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

foreach($results as $row)
{               ?>
        <li><a href="view-categorywise-job.php?viewid=<?php echo htmlentities ($row->jobCategory);?>"><?php  echo htmlentities($row->jobCategory);?></a></li> <?php } ?> 
      </ul>

    </div>

   
   

    <div class="container">

      <div class="bottom-row"> <strong class="copyrights">FYP @ Anis</strong>

        <div class="footer-social">

          <ul>

            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>

            <li><a href="#"><i class="fa fa-twitter"></i></a></li>

            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>

            <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>

          </ul>

        </div>

      </div>

    </div>

  </footer>