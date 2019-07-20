<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head> 

<body style="createUserBody">
    <?php
        include_once 'dbcon.php';
        session_start();
        if(isset($_GET['logout'])){
            // remove all session variables
            session_unset();
        }
        if(isset($_GET['addbtn'],$_GET['product_id'])){
            $username = $_SESSION['username'];
            $prodouctId = $_GET['product_id'];
            if($username && $prodouctId){
                $query = "SELECT * FROM user_basket WHERE username='$username' and product_id='$prodouctId'";
                $result = mysqli_query($conn,$query);
                $resultCheck = mysqli_num_rows($result);
                if($resultCheck > 0){
                    $row = mysqli_fetch_assoc($result);
                    $prod_amount = $row['amount'] + 1 ;
                    $query = "UPDATE user_basket SET amount='$prod_amount' WHERE username='$username' AND product_id='$prodouctId'";
                    $result = mysqli_query($conn,$query);
                }else{
                    $query = "INSERT INTO user_basket SET username='$username', product_id='$prodouctId',amount=1";
                    $result = mysqli_query($conn,$query);
                }
            }
        }
    ?>
    <div class="navbar">
        <ul>
            <li class="active">
                <a href="index.php">Main page</a> 
            </li>
            <?php 
            //USER LOGINED
                if(isset($_SESSION['username'])){ ?>
                <li>
                    <form action="index.php" method="get">   
                        <input type="submit" name="logout" value=" <?php echo $_SESSION['username'] ?> : Log out" class="submitBtn">
                    </form>
                </li>
                <?php
                    $accLvl = $_SESSION['accesslevel'];
                    if($accLvl==0){ ?>
                        <li>
                            <a href="adminPage.php">ADMINISTRATION</a>
                        </li>
                        
                    <?php 
                } ?>
                <li style="float:right">
                    <a href="viewCart.php"><img alt="basket" src="assets/images/shopping-cart.png" style="height:20px;width:20px"/></a>
                </li>
            <?php } 
            //HAVE NO USER LOGINED
                else {
            ?>
            <li>
                <a href="createUser.php">Create user</a> 
            </li>
            <li>
                <a href="loginCart.php">Login</a> 
            </li> 
            <?php } ?>
        </ul>
    </div>


    
    <div class="products" >
        <table class="panel">
            <?php
                $sql = "SELECT * FROM products;";
                $result = mysqli_query($conn,$sql);
                $resultCheck = mysqli_num_rows($result);
                if($resultCheck > 0)
                {   
                    
                    while($row = mysqli_fetch_assoc($result))
                    {
            ?>
                <div style="text-align:center">
                    <tr style="height:150px;font-size: 20px;">
                            <td><img alt="No Image" src="assets/images/<?php echo $row['image_address']?>" style="max-width:150px;max-height:150px;" ></td>
                            <td name="nameP"><?php echo $row['name']?></td>
                            <td style="text-align:center"><?php echo $row['description']?></td>
                            <td style="text-align:center"><?php echo $row['price']." $" ?>
                            <?php if(isset($_SESSION['username'])){ ?>               
                                <form action="<?php $_PHP_SELF ?>" method="get">
                                    <input type="hidden" name="product_id" value=<?php echo $row['id']?>>
                                    <input type="hidden" name="productname" value=<?php echo $row['name']?>>
                                    <input type="submit" name="addbtn" value="ADD to cart" class="btn" style="height:40px;width:100px">   
                                </form>
                            <?php } ?>
                        </td>   
                    </tr>
                </div>    
            <?php
                    }
                }
            ?>
        </table>
    </div>
</body>