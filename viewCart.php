<?php
    session_start();
    include_once 'dbcon.php';
    $sum=0;
    $ids="";
?>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="viewCartBody">
    <div class="navbar">
            <ul>
                <li>
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
                        
                    <?php } ?>
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
    <div class="panel" style="width: 60%;margin-top:15%;margin-left:20%;margin-right:20%; text-align:center">
        <table class="panel" style="padding-top: 10px;padding-left: 10px;padding-right: 10px;padding-bottom: 10px;color:lightblue">
        <tr style="color:CYAN">
            <td>Item:</td>
            <td>Amount:</td>
            <td>Price:</td>
            <td></td>
        </tr>
        <?php
            $username = $_SESSION['username'];
            $query = "SELECT *
                    FROM user_basket
                    INNER JOIN products ON user_basket.product_id = products.id
                    AND user_basket.username = '$username'";
            $result = mysqli_query($conn,$query);
            $resultCheck = mysqli_num_rows($result);
            if($resultCheck > 0 ){
                while($row = mysqli_fetch_assoc($result))
                {
                    $ids .= "product_id=".$row['id'] .=' or ';
                ?>
                    <tr style="font-size: 20px;">
                        <td><?php echo $row['name']?></td>
                        <td><?php echo "Amount: " . $row['amount']?></td>
                        <td><?php echo "Price: " . $row['price'] . " $"?></td>
                        <?php $sum += ($row['amount'] * $row['price']); ?>
                        <form action="<?php $_PHP_SELF ?>" method="get">
                            <td style="text-align:right"><input type="submit" name="removeItem" value="remove" class="btn_red"></td>
                            <input type="hidden" name="prodId" value=<?php echo $row['id']?>>
                        </form>

                        <?php 
                            if(isset($_GET['removeItem'],$_GET['prodId'])){
                                $prodid = $_GET['prodId'];
                                $query = "DELETE FROM user_basket WHERE product_id='$prodid'";
                                mysqli_query($conn,$query);
                                header("Location:viewCart.php");
                                exit(); 
                            }
                        ?>

                    </tr>
        <?php  } ?>
                    <tr style='font-size:15px'>
                        <td style='border-bottom: 0px'></td>
                        <td style='border-bottom: 0px'></td>
                        <td style='color:CYAN;font-size:20px;border-bottom: 0px'> <?php echo "SUM: " . $sum . " $"?> </td>
                        <form action="viewCart.php" method="get">
                            <td style="text-align:right ;border-bottom: 0px"> <input type="submit" name="buybtn" value="Make order" class="btn" style="height:30px;width:100px"></td>
                            <?php 
                                $ids = substr($ids,0,-3); 
                                if(isset($_GET['buybtn'])){
                                    $query = "DELETE FROM user_basket WHERE username = '$username' AND ( $ids )";
                                    mysqli_query($conn,$query);
                                    header("Location:viewCart.php");
                                    exit(); 
                                }

                                
                            ?>
                        </form>
                    </tr>
            <?php }else{
                
                echo " <tr><td></td><td>SHOPPING CARD IS EMPTY.</td>";
            }   
            ?>
        </table>
    </div>
</body>
