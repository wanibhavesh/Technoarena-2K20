<?php
session_start();
 $sname=$_SESSION['adminId'];
if(!isset($_SESSION['adminId']))
{
    header('location:/admin/login.php');
    exit();
   
}
   

?>
<?php
    $id = $_GET['id'];
    include("../db/conn.php");
    $error = '';
    
    if(isset($_POST['submit']))
    {   
        $filename = $_FILES['myfile']['name'];
        
        $url="https://technoarena.gcoej.ac.in/uploads/".$filename;
        $id=$_POST['id'];
        $qwery="SELECT * FROM slider WHERE id='$id'";
        $peo=mysqli_query($sql,$qwery);
        $peorow=mysqli_fetch_array($peo);
        
        if($filename=="")
        {
            $caption = $_POST['caption'];
            $id = $_POST['id'];
            $url=$peorow['url'];
            $ins="UPDATE slider SET caption='$caption',url='$url' WHERE id='$id'; ";
            if(mysqli_query($sql,$ins)) 
            {
               $_SESSION['msg'] = 'success';
            }   
            else 
            {
                $_SESSION['msg'] = 'failed';
            }
            
        }
        else
        {
        
                $destination = '../uploads/' . $filename;
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                $file = $_FILES['myfile']['tmp_name'];
                $size = $_FILES['myfile']['size'];
            
                if (!in_array($extension, ['jpg','jpeg','png','JPG','JPEG','PNG'])) 
                {
                    $_SESSION['msg'] = 'fileext';
                } 
                else 
                {
                    if (move_uploaded_file($file, $destination)) 
                    {
                        
                        $caption = $_POST['caption'];
                        $id = $_POST['id'];
                        $ins='UPDATE slider SET caption="'.$caption.'",url="'.$url.'" WHERE id="'.$id.'"; ';
                        if(mysqli_query($sql,$ins)) 
                        {
                            $_SESSION['msg'] = 'success';
                        }   
                        else 
                        {
                            $_SESSION['msg'] = 'failed';
                        }
                    } 
                    else 
                    {
                        echo "<script>alert('Failed to upload file.')</script>";
                    }
                }
        }
                    
        
    }   
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Admin Panel</title>

  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <link href="css/sb-admin.css" rel="stylesheet">
 <script src="../editor/ckeditor/ckeditor.js"></script>

</head>

<body id="page-top">
 <?php

    if(isset($_SESSION['msg'])) {
        if($_SESSION['msg']=='success')   {
            echo '<script>alert("Registration Success")</script>';
            unset($_SESSION['msg']);
            header("location:/admin/slider.php");
        }
        else if ($_SESSION['msg']=='fileext')
        {
            echo "<script>confirm('You file extension must be .jpg, .JPG , .jpeg , .JPEG , .png , .PNG')<script>";
            unset($_SESSION['msg']);
            header("location:/admin/slider.php");
        }
        else {
            echo '<script>alert("Sorry :( Failed Registration)")</script>';
            unset($_SESSION['msg']);
            header("location:/admin/slider.php");
        }
    }
?> 





  <?php
        include('main/nav.php');
  ?>

  <div id="wrapper">

   <?php
        include('main/side.php');
  ?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a>Edit Slider Image</a>
          </li>
        </ol>
    <form method="POST" action="editslider.php" enctype="multipart/form-data">
    <?php
        $qwery="SELECT * FROM slider WHERE id='$id'";
        $gl=mysqli_query($sql,$qwery);
        $glrow=mysqli_fetch_array($gl);
    ?>

    <input value="<?php echo $id;?>" name="id" hidden>    

        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Caption</label>
            <div class="col-sm-10">
              <input type="text" name="caption" class="form-control"  placeholder="Caption-Information about image" value="<?php echo $glrow['caption']; ?>">
            </div>
        </div>
        
        <div class="form-group row">
            <label  class="col-sm-2 col-form-label">Change Photo</label>
            <div class="col-sm-10">
                <input type="file" name="myfile">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Previous Photo</label>
            <div class="col-sm-10">
              <div class="row no-gutters">
                    <div class="col-auto">
                        <img src="<?php echo $glrow['url']; ?>" class="img-fluid"  style="height:130px;width:220px;" alt="">
                    </div>
                </div>
            </div>
        </div>
    
        <div class="text-center" style="padding-bottom:30px;">
        <button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
    </form>
    
          
        
    </div> 
                  
    
      <!-- Sticky Footer -->
      <?php
            include("main/footer.php");
      ?>
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

   <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>
 
</body>

</html>