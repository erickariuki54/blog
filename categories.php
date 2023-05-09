<?php
require_once "./include/db.php";
include_once "datetime.php";
require_once "./include/session.php";
require_once "./include/functions.php";


if (isset($_POST["submit"])){
    $category= ($_POST['Category']);
    
    echo $DateTime;
    $Admin = "Eric Kariuki";
   
    if(empty($category)){
        $_SESSION["ErrorMessage"]="All fields must be filled out";
        redirect_to("categories.php");
        exit;
    }elseif(strlen("$category")>99){
        $_SESSION["ErrorMessage"]="too long name";
        redirect_to("categories.php");
    }else{
        global $conn;
        $Query = "INSERT INTO category(datetime, name, creatorname) VALUES ('$DateTime', '$category', '$Admin')";
        
        $execute = mysqli_query($conn,$Query,);
        if($execute){
            $_SESSION["SuccessMessage"]="category added successfully";
            redirect_to("categories.php");
            
        }else{
            $_SESSION["ErrorMessage"]="Category faied to add";
            redirect_to("categories.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Latest compiled and minified CSS -->
<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
<link rel="stylesheet" href="./css/bootstrap.min.css">
<script src="./js/jquery-3.6.1.min.js"></script>

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<link rel="stylesheet" href="./other_css/adminstyles.css">
<title>categories &copy;</title>
</head>
<body>
    <div class="container-fluid ">
        <div class="row">
            <div class="col-sm-2">
                <h1>ROYAL TEC</h1>
                <ul id="side-menu" class="nav nav-pills nav-stacked">
                    <li><a href="Dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp; Dashboard</a> </li>
                    <li><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt" ></span> &nbsp;add new posts </a> </li>
                    <li class="active"><a href="categories.php"><span class="glyphicon glyphicon-tags" ></span> &nbsp;categories</a> </li>
                    <li><a href="#"><span class="glyphicon glyphicon-user" ></span>&nbsp;manage admins</a> </li>
                    <li><a href="#"><span class="glyphicon glyphicon-comment" ></span>&nbsp;comments</a> </li>
                    <li><a href="#"><span class="glyphicon glyphicon-equalizer" ></span>&nbsp;Live blog</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-log-out" ></span>&nbsp;logout</a> </li>
                </ul>

            </div><!--end if col-sm-2-->
            <div class="col-sm-10">
                
                <h1>manage categories </h1>
                <?php echo Message();
                echo SuccessMessage(); ?>
                <div>
                    <form action="categories.php" method="post">
                        <fieldset>
                                <div class="form-group">
                            <label for="categoryname">name</label>
                            <input class="form-control" type="text" name="Category" id="categoryname" placeholder="name">
                                </div>
                                <br>
                                <input class="btn btn-success btn-block" type="submit" value="add new category" name="submit">
                                
                        </fieldset>
                        <br>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Sr No.</th>
                            <th>Date and Time</th>
                            <th>Category name</th>
                            <th>creator name</th>
                        </tr>
                        <?php 
                        global $conn;
                        $viewquerry= "SELECT * FROM category  ORDER BY datetime desc ";
                        $Execute=mysqli_query($conn,$viewquerry);
                        $srno = 0;
                        while ($datarows = mysqli_fetch_array($Execute)){
                            $id =$datarows["id"];
                            $DateTime = $datarows["datetime"];
                            $categoryname=$datarows["name"];
                            $creatorname=$datarows["creatorname"];
                            $srno++;

                            echo '<tr>';
                            echo '<td>'.$id,' </td>';
                            echo '<td>'.$DateTime, '</td>';
                            echo '<td>'.$categoryname,'</td>';
                            echo '<td>'.$creatorname,'</td>';
                            echo '</tr>';
                        

                        }
                       
                        ?>
                        
                        
                    </table>
                </div>
                
            </div><!--end of col sm 10-->
        </div><!--end of row-->
        
    </div><!--end of container fluid-->
    <div id="Footer">
        <hr><p>Theme by | Eric Kariuki &copy;2022 ----all rights reserved</p>
        <a style="color: white; text-decoration: none; cursor: pointer; font-weight: bold;" href="#">
        <p>this site was developed by Eric Kariuki &copy; all rights reserved &trade; educational purposes</p></a>
    </div><!--end of footer-->
    <div style="height: 10px; background:#27aae1;"></div>
    

    


</body>
</html>