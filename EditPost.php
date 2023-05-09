<?php
require_once "./include/db.php";
include_once "datetime.php";
require_once "./include/session.php";
require_once "./include/functions.php";

global $TitleToBeUpdated;
global $CategoryToBeUpdated;
global $ImageToBeUpdated;
global $PostToBeUpdated;
global $authorToBeUpdated;
global $searchQueryParameter;

if (isset($_POST["submit"])){
    $Title = ($_POST["title"]);
    $category= ($_POST['Category']);
    $post = ($_POST["Post"]);
    
    echo $DateTime;
    
    $Image=$_FILES["Image"]['name'];
    $target = "Upload/".basename($_FILES["Image"]['name']);
   
    if(empty($Title)){
        $_SESSION["ErrorMessage"]="Title cannot be empty";
        redirect_to("AddNewPost.php");
        exit;
    }elseif(strlen("$Title")<2){
        $_SESSION["ErrorMessage"]="Title should be atleast 2 characters";
        redirect_to("AddNewPost.php");
    }else{
        global $conn;
        if (isset($_GET['Edit'])){
        $EditFromUrl=$_GET['Edit'];}
        $Query = "UPDATE admin_panel SET datetime='$DateTime', title='$Title', category='$category', image='$Image', post='$post' where id='$EditFromUrl'";

        
        $execute = mysqli_query($conn,$Query,);
        copy($_FILES["Image"]["tmp_name"], $target);
        if($execute){
            $_SESSION["SuccessMessage"]="Post updated Successfully";
            redirect_to("Dashboard.php");
            
        }else{
            $_SESSION["ErrorMessage"]="something went wrong...Try Again!!";
            redirect_to("Dashboard.php");
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
<link rel="stylesheet" href="./css/bootstrap.min.css">
<script src="./js/jquery-3.6.1.min.js"></script>
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">-->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<link rel="stylesheet" href="./other_css/adminstyles.css">
<title>Edit Post &copy;</title>
</head>
<body>
    <div class="container-fluid ">
        <div class="row">
            <div class="col-sm-2">
                <h1>ROYAL TEC</h1>
                <ul id="side-menu" class="nav nav-pills nav-stacked">
                    <li><a href="Dashboard.php"><span class="glyphicon glyphicon-th"></span>&nbsp; Dashboard</a> </li>
                    <li class="active"><a href="AddNewPost.php"><span class="glyphicon glyphicon-list-alt" ></span> &nbsp;add new posts </a> </li>
                    <li><a href="categories.php"><span class="glyphicon glyphicon-tags" ></span> &nbsp;categories</a> </li>
                    <li><a href="#"><span class="glyphicon glyphicon-user" ></span>&nbsp;manage admins</a> </li>
                    <li><a href="#"><span class="glyphicon glyphicon-comment" ></span>&nbsp;comments</a> </li>
                    <li><a href="#"><span class="glyphicon glyphicon-equalizer" ></span>&nbsp;Live blog</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-log-out" ></span>&nbsp;logout</a> </li>
                </ul>

            </div><!--end if col-sm-2-->
            <div class="col-sm-10">
                
                <h1>Update Post</h1>
                <?php echo Message();
                echo SuccessMessage(); ?>
                <div>
                    <?php 
                    $conn;
                    if(isset($_GET['Edit'])){
                    $searchQueryParameter= $_GET['Edit'];}
                    $Query = "SELECT * FROM admin_panel WHERE id='$searchQueryParameter'";
                    $execute = mysqli_query($conn,$Query);
                    while ($datarows=mysqli_fetch_array($execute)){
                        $TitleToBeUpdated = $datarows['title'];
                        $CategoryToBeUpdated = $datarows['category'];
                        $ImageToBeUpdated = $datarows['image'];
                        $PostToBeUpdated = $datarows['post'];
                        $authorToBeUpdated = $datarows['author'];
                    }
                    ?>
                    <form action="EditPost.php?Edit=<?php echo htmlentities($searchQueryParameter); ?>" method="post" enctype="multipart/form-data">
                        <fieldset>
                                <div class="form-group">
                            <label for="title"><span class="FieldInfo">Title</span> </label>
                            <input value="<?php echo $TitleToBeUpdated; ?>" class="form-control" type="text" name="title" id="title" placeholder="Title">
                            
                                </div>
                                <div class="form-group">
                                    
                                <span class="FieldInfo">Existing Category: </span>
                                    <?php echo $CategoryToBeUpdated;?>
                                    <label for="categoryselect"><span class="FieldInfo">Category</span></label>
                                    <select name="Category" id="categoryselect" class="form-control">
                                    <?php 
                                    
                                    global $conn;
                                    $viewquerry= "SELECT * FROM category  ORDER BY datetime desc ";
                                    $Execute=mysqli_query($conn,$viewquerry);
                                    while ($datarows = mysqli_fetch_array($Execute)){
                                    $id =$datarows["id"];
                                    $categoryname=$datarows["name"];
                                    ?>
                                    <option>
                                        <?php echo $categoryname ?>
                                    </option>
                                    <?php }?>

                                    </select>
                                    <div class="form-group">
                                    <span class="FieldInfo">Existing Image: </span>
                                    <img src="./Upload/<?php echo $ImageToBeUpdated;?>" alt="" width="70" height="70px"> 
                                        <label for="Imageselect">select Image</label>
                                        <input id="Imageselect" class="form-control" type="file" name="Image">
                                    </div>
                                    <div class="form-group">
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="postarea">Post</label>
                                        <textarea id="postarea" class="form-control"  name="Post">
                                        <?php echo $PostToBeUpdated; ?>
                                        </textarea>
                                    </div>
                                </div>
                                <br>
                                <input class="btn btn-success btn-block" type="submit" value=" Update" name="submit">
                                
                        </fieldset>
                        <br>
                    </form>
                </div>
                
                       
                        
                        
                    </table>
                
                
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