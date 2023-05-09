<?php
require_once "./include/db.php";
include_once "datetime.php";
require_once "./include/session.php";
require_once "./include/functions.php";
global $PostIdFromUrl;
global $postid;
if (isset($_POST["submit"])){
    $Name = ($_POST["Name"]);
    $Email= ($_POST['Email']);
    $Comment = ($_POST["Comment"]);
    
    if(isset($_GET['id'])){
    $postid = $_GET['id'];
    
}
    
    if(empty($Name) || empty($Email) || empty($Comment)){
        $_SESSION["ErrorMessage"]="All fields are required";
        
        
    }elseif(strlen("$Comment")>500){
        $_SESSION["ErrorMessage"]="Only 500 characters are allowed";
       
    }else{
        global $conn;
        $Query = "INSERT INTO comments (datetime,name, email, comment, status) VALUES ('$datetime','$Name','$Email','$Comment','OFF');";

        
        $execute = mysqli_query($conn,$Query,);
        
        if($execute){
            $_SESSION["SuccessMessage"]="Comments Added Successfully";
            
            redirect_to("FullPost.php?id={$postid}");
            
        }else{
            $_SESSION["ErrorMessage"]="something went wrong...Try Again!!";
            redirect_to("FullPost.php?id={$postid}");
            
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
<!--link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
-->
<link rel="stylesheet" href="./css/bootstrap.min.css">
<script src="./js/jquery-3.6.1.min.js"></script>
<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<link rel="stylesheet" href="./other_css/publicstyles.css">

<title>Full Blog page</title>
<script>
    var postid = '<?php echo $PostIdFromUrl; ?>';
    alert(postid);
</script>
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
        <li class="active"><a href="blog.php">Blog</a></li>
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

<div class="container"><!--container-->
    <div class="blog-header">
    <h1>the complete blog</h1>
    <p class="lead">The complete blog by Eric Kariuki</p>
    
</div>
<div class="row"><!--row-->
    <div class="col-sm-8"><!--main blog area-->
    
                <?php echo Message();
                echo SuccessMessage(); ?>
        <?php
        global $conn;
        if (isset($_GET["SearchButton"])){
            $search = $_GET["search"];
            $viewQuery = "SELECT * FROM admin_panel WHERE datetime LIKE '%$search%' OR title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%'";
        }else{
        if(isset($_GET['id'])){
        $PostIdFromUrl=$_GET['id'];}
        
        $viewQuery= "SELECT * FROM admin_panel WHERE id='$PostIdFromUrl' ORDER BY datetime desc" ;}
        $execute = mysqli_query($conn, $viewQuery);
        while($datarows=mysqli_fetch_array($execute)){
            $postid= $datarows["id"];
            $datetime =$datarows["datetime"];
            $title =$datarows["title"];
            $category =$datarows["category"];
            $admin =$datarows["author"];
            $image =$datarows["image"];
            $post = $datarows["post"];
        

        
        ?>
        <div class="blogpost thumbnail">
            <img class="img-responsive img-rounded" src="./Upload/<?php echo $image;?>" alt="posts">
            <div class="caption">
                <h1 id="heading"><?php echo htmlentities($title);?></h1>
                <p class="description">Category:<?php echo htmlentities($category) ; ?> Published on <?php echo htmlentities($datetime) ?></p>
                <p class="post"><?php 
                        
                        echo htmlentities($post); ?></p>
            </div>
            <div>
            <?php }?>
                <br><br>
                <span class="FieldInfo">share your thoughts about this post</span>
                <span class="FieldInfo">Comments</span>
                    <form action="FullPost.php" method="post" enctype="multipart/form-data">
                        <fieldset>
                                <div class="form-group">
                                <label for="name"><span class="FieldInfo">Name:</span> </label>
                                <input class="form-control" type="text" name="Name" id="name" placeholder="name">
                            
                                </div>
                                <div class="form-group">
                                <label for="email"><span class="FieldInfo">Email</span> </label>
                                <input class="form-control" type="text" name="Email" id="Email" placeholder="Email">
                            
                                </div>
                                
                                    
                                    
                                    
                                    <div class="form-group">
                                        <label class="FieldInfo" for="postarea">Comment</label>
                                        <textarea id="commentarea" class="form-control"  name="Comment">
                                           
                                        </textarea>
                                    </div>
                                
                                <br>
                                <input class="btn btn-primary btn-block" type="submit" value="submit" name="submit">
                               
                        </fieldset>
                        
                        <br>
                    </form>
                    
                </div> 
                   
        </div>
        
        
    </div><!--main blog area-->
    <div class="col-sm-3 col-sm-offset-1 side"><!--side area-->
        <h2>Test</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora sed quam veritatis, doloremque vel, quo dolorem culpa eum labore consequuntur aperiam eos provident recusandae quidem. Eius libero adipisci exercitationem dolorem.
        Totam, quisquam veritatis incidunt fuga eligendi quibusdam iure aliquid at qui natus vero, quasi rem animi accusantium dicta! Ducimus eveniet incidunt quod quasi vel, ex minima hic animi magnam fugit.</p>
    
    </div><!--side area ending-->
    </div><!--row ending-->
</div><!--container ending-->
<div id="Footer">
    <hr><p>Theme by | Eric Kariuki &copy;2022 ----all rights reserved</p>
    <a style="color: white; text-decoration: none; cursor: pointer; font-weight: bold;" href="#">
    <p>this site was developed by Eric Kariuki &copy; all rights reserved &trade; educational purposes</p></a>
</div><!--end of footer-->
<div style="height: 10px; background:#27aae1;"></div>

</body>
</html>