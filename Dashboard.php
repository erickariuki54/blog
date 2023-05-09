<?php 
require_once "./include/db.php";
require_once "./include/session.php";
require_once "./include/functions.php";
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
<script src="./js/bootstrap.min.js"></script>

<script src="./js/popper.min.js"></script>
<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<link rel="stylesheet" href="./other_css/adminstyles.css">
<title>Dashboard &copy;</title>

</head>
<body>
<div style="height:10px; background:#27aae1;"></div>
<nav class="navbar navbar-inverse" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
                <span class="sr-only">toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="blog.php" class="navbar-brand">
            <img style="margin-top:-12px ;" src="./images/htmllogo.png" alt="logo" width="20%" >
        </a>
    </div>
    <div class="collapse navbar-collapse" id="collapse">
    <ul class="nav navbar-nav">
        <li><a href="#">Home</a></li>
        <li class="active"><a href="blog.php" target="_blank">Blog</a></li>
        <li><a href="#">About us</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact us</a></li>
        <li><a href="#">Feature</a></li>
    </ul>
    <form class="navbar-form navbar-right" action="blog.php" method="get">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="search" name="search">
        </div>
        <button class="btn btn-default" name="SearchButton">Go</button>
    </form></div>

        
    </div>
</nav>
<div class="line" style="height:10px; background:#27aae1;"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <br><br>
                <ul id="side-menu" class="nav nav-pills nav-stacked">
                    <li class="active"><a href="Dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp; Dashboard</a> </li>
                    <li><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt" ></span> &nbsp;add new posts </a> </li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tags" ></span> &nbsp;categories</a> </li>
                    <li><a href="#"><span class="glyphicon glyphicon-user" ></span>&nbsp;manage admins</a> </li>
                    <li><a href="#"><span class="glyphicon glyphicon-comment" ></span>&nbsp;comments</a> </li>
                    <li><a href="#"><span class="glyphicon glyphicon-equalizer" ></span>&nbsp;Live blog</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-log-out" ></span>&nbsp;logout</a> </li>
                </ul>

            </div><!--end if col-sm-2-->
            <div class="col-sm-10"><!--main area-->
                <div><?php echo Message();
                echo SuccessMessage(); ?></div>
                <h1>Admin Dashboard</h1>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>No</th>
                            <th>Post Title</th>
                            <th>Date & Time</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Actions</th>
                            <th>Details</th>
                        </tr>
                        <?php
                        $conn;
                        $ViewQuery= "SELECT * FROM admin_panel ORDER BY datetime desc;";
                        $execute =mysqli_query($conn, $ViewQuery);
                        $SrNo = 0;
                        while($DataRows = mysqli_fetch_array($execute)){
                            $Id =$DataRows['id'];
                            $DateTime = $DataRows['datetime'];
                            $Title =$DataRows['title'];
                            $Category = $DataRows['category'];
                            $Admin = $DataRows['author'];
                            $Image = $DataRows['image'];
                            $Post = $DataRows['post'];
                            $SrNo++;

                        ?>
                        <tr>
                            <td><?php echo $SrNo; ?></td>
                            <td style="color:#5e5eff ;"><?php 
                            if(strlen($Title)>20){
                                $Title = substr($Title,0,20).'...';
                            }
                            echo $Title; ?></td>
                            <td><?php 
                            if(strlen($DateTime)>11){
                                $DateTime = substr($DateTime,0,11).'...';
                            }
                            echo  $DateTime; ?></td>
                            <td><?php 
                             if(strlen($Admin)>6){
                                $Admin = substr($Admin,0,6).'...';
                            }
                            echo $Admin;?></td>
                            <td><?php echo $Category; ?></td>
                            <td><img src="./Upload/<?php echo $Image;?>" alt="images" width="120px" height="90px"></td>
                            <td>processing</td>
                            <td>
                                <a href="EditPost.php?Edit=<?php echo $Id;?>">
                                <span class="btn btn-warning ">Edit</span>
                                </a>  
                                 <a href="DeletePost.php?Delete=<?php echo $Id;?>">
                               <span class="btn btn-danger ">Delete </span></a> </td>
                            <td><a href="FullPost.php?id=<?php echo $Id;?>"> <span class="btn btn-primary">Live Preview</span></a></td>
                            
                            
                        </tr>    

                        <?php } ?>
                        
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