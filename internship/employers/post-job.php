<?php
session_start();
//Database Configuration File
include('includes/config.php');
//error_reporting(0);
//verifying Session
if(strlen($_SESSION['emplogin'])==0)
  { 
header('location:emp-login.php');
}
else{

//Genrating CSRF Token
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if(isset($_POST['submit']))
{

//Verifying CSRF Token
if (!empty($_POST['csrftoken'])) {
if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {

$empid=$_SESSION['emplogin'];  
//Getting Post Values
$category=$_POST['category'];  
$jontitle=$_POST['jobtitle']; 
//$jobtype=$_POST['jobtype']; 
$salpackg=$_POST['salarypackage'];
$skills=$_POST['skills'];
$city=$_POST['city'];
$joblocation=$_POST['joblocation'];
$jobdesc=$_POST['description'];
$jed=$_POST['jed'];
$allowance_provide = $_POST['allowance_provide'];
$sector = $_POST['sector'];
$isactive=1;



$sql="INSERT INTO tbljobs(employerId,jobCategory,jobTitle,salaryPackage,skillsRequired,city,jobLocation,jobDescription,JobExpdate,isActive,allowance_provide,sector) VALUES(:empid,:category,:jontitle,:salpackg,:skills,:city,:joblocation,:jobdesc,:jed,:isactive, :allowance_provide,:sector)";
$query = $dbh->prepare($sql);
// Binding Post Values
$query->bindParam(':empid',$empid,PDO::PARAM_STR);
$query->bindParam(':category',$category,PDO::PARAM_STR);
$query->bindParam(':jontitle',$jontitle,PDO::PARAM_STR);
//$query->bindParam(':jobtype',$jobtype,PDO::PARAM_STR);
$query->bindParam(':salpackg',$salpackg,PDO::PARAM_STR);
$query->bindParam(':skills',$skills,PDO::PARAM_STR);
$query->bindParam(':city',$city,PDO::PARAM_STR);
$query->bindParam(':joblocation',$joblocation,PDO::PARAM_STR);
$query->bindParam(':jobdesc',$jobdesc,PDO::PARAM_STR);
$query->bindParam(':jed',$jed,PDO::PARAM_STR);
$query->bindParam(':isactive',$isactive,PDO::PARAM_STR);
$query->bindParam(':allowance_provide', $allowance_provide, PDO::PARAM_STR);
$query->bindParam(':sector',$sector,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Your job posted Successfully";
// unset( $_SESSION['token']);
}
else 
{
$error="Something went wrong.Please try again";
}


}}}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Employers | Internship Posting</title>
<link href="../css/custom.css" rel="stylesheet" type="text/css">
<link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="../css/color.css" rel="stylesheet" type="text/css">
<link href="../css/responsive.css" rel="stylesheet" type="text/css">
<link href="../css/owl.carousel.css" rel="stylesheet" type="text/css">
<link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../css/editor.css" type="text/css" rel="stylesheet"/>
<link href="../css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">

<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,500,700,900' rel='stylesheet' type='text/css'>


<body class="theme-style-1">
<div id="wrapper"> 
<!--HEADER START-->
 <?php include('includes/header.php');?>
<!--HEADER END--> 

  
  <!--INNER BANNER START-->
  <section id="inner-banner">

    <div class="container">

      <h1>Employers | Post an Internship</h1>

    </div>

  </section>

  <!--INNER BANNER END--> 

  

  <!--MAIN START-->

  <div id="main">
    <!--Signup FORM START-->
    <form name="empsignup" enctype="multipart/form-data" method="post">
<input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" /> 
 

    <section class="resum-form padd-tb">

      <div class="container">
    <!--Success and error message -->
     <?php if(@$error){ ?><div class="errorWrap">
        <strong>ERROR</strong> : <?php echo htmlentities($error);?></div><?php } ?>

        <?php if(@$msg){ ?><div class="succMsg">
        <strong>Success</strong> : <?php echo htmlentities($msg);?></div><?php } ?>

<div class="row">
<div class="col-md-6 col-sm-6" >
<label>Category*</label>
  <div class="selector">
       <select name='category' class="full-width">
  <?php 
$sqlt = "SELECT CategoryName FROM tblcategory order by CategoryName asc";
$queryt = $dbh -> prepare($sqlt);
$queryt -> execute();
$results = $queryt -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($queryt -> rowCount() > 0)
{
foreach($results as $result)
{?>
<option value="<?php echo htmlentities($result->CategoryName);?>"><?php echo htmlentities($result->CategoryName);?></option>
 <?php  }} ?>
              
</select>
</div>
</div>

<div class="col-md-6 col-sm-6">
<label>Job Title</label>
						<div class="selector">
                               <select class="form-select border-0 py-3" name="jobtitle">
                                                <option value="">Select Job Type</option>
												<option value="Java Developer">Java Developer</option>
												<option value="Software Application Developer">Software Application Developer</option>
												<option value="Designer">Designer</option>
												<option value="Chart Analysis">Chart Analysis</option>	
												<option value="IT Consultant">IT Consultant</option>		
												<option value="Database">Database</option>		
                                            </select>
                            </div>

</div>
</div>
      
          <div class="row">
          <div class="col-md-6 col-sm-6">

              <label>Allowance</label>
<input type="text" placeholder="e.g. 200" name="salarypackage">

            </div>

            <div class="col-md-6 col-sm-6">

              <label>Allowance Provide</label>
              <div class="selector">

              <select class="full-width" name="allowance_provide">
              <option value="Select City">Select Allowance</option>
              <option value="yes">Yes</option>
              <option value="no">No</option>
              </select>
            </div>
            </div>
          </div>


<div class="row">

<div class="col-md-6 col-sm-6">
<label>Skill Required</label>
<input type="text" placeholder="e.g. PHP, MySQL, HTML, CSS" name="skills" required>
</div>

<div class="col-md-6 col-sm-6">
 <label>City</label>

              <div class="selector">

                <select class="full-width" name="city">
				  <option value="Select City">Select City</option>
              
                </select>

              </div>

            </div>


</div>


<div class="row">



<div class="col-md-6 col-sm-6">
<label>State</label>
		<div class ="selector">
        <select class="full-width" name="joblocation">
                  <option value="">Select State</option>
											
										
								</select>
                            </div>

</div>
<div class="col-md-6 col-sm-6">
<label>Job Expiration Date</label>
<input type="date" placeholder="e.g. 0-5" name="jed" required class="form-control">
</div>
</div>

<div class="row">



<div class="col-md-6 col-sm-6">
<label>Sector</label>
		<div class ="selector">
        <select class="full-width" name="sector">
                  <option value="">Select Sector</option>
                  <option value="government">Government</option>
                  <option value="private">Private</option>
											
										
								</select>
                            </div>

</div>
</div>


<div class="row">
 <div class="col-md-12">
<h4>Job Description</h4>
<div class="text-editor-box">
<textarea  name="description" required></textarea>
</div>
</div>
</div>

            <div class="col-md-12">

              <div class="btn-col">

                <input type="submit" name="submit" value="Submit">

              </div>

            </div>

          </div>

    

      </div>

    </section>
    </form>
    <!--RESUME FORM END--> 

  </div>

  <!--MAIN END--> 

  

  <!--FOOTER START-->

  <?php include('includes/footer.php');?>
  <!--FOOTER END--> 

</div>


<script src="../js/jquery-1.11.3.min.js"></script>
<script src="../js/bootstrap.min.js"></script> 
<script src="../js/owl.carousel.min.js"></script> 
<script src="../js/jquery.velocity.min.js"></script> 
<script src="../js/jquery.kenburnsy.js"></script> 
<script src="../js/jquery.mCustomScrollbar.concat.min.js"></script> 
<script src="../js/editor.js"></script> 
<script src="../js/jquery.accordion.js"></script> 
<script src="../js/jquery.noconflict.js"></script> 
<script src="../js/theme-scripts.js"></script> 
<script src="../js/custom.js"></script>
<script src="../js/statecity.js"></script>


<script>
    var getStateCity = getStateCity();

    console.log(getStateCity);

    document.querySelector('select[name=joblocation]').addEventListener('change', (e) => {
  const val = e.currentTarget.value;
  document.querySelector('select[name=city]').innerHTML = '';

  Object.entries(getStateCity).forEach(([state, city]) => {
    if (state === val) {
      Object.entries(city).forEach(([k, v]) => {
        const option = document.createElement('option');
        option.text = v;
        option.value = v;
        document.querySelector('select[name=city]').appendChild(option);
      });
    }
  });
});

Object.entries(getStateCity).forEach(([k, v]) => {
  const option = document.createElement('option');
  option.text = k;
  option.value = k;
  document.querySelector('select[name=joblocation]').appendChild(option);
});
    
   
  </script>

</body>

</html>
<?php } ?>

