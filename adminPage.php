<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head> 

<?php
    session_start();
    include_once 'dbcon.php';

    $query = "SELECT * FROM users";
    $userList = mysqli_query($conn,$query);
    $userListLength = mysqli_num_rows($userList);
?>

<?php 
    //remove user
    if(isset($_GET['remUser'],$_GET['username'])){
        $userName = $_GET['username'];
        //remove user
        $query = "DELETE FROM users WHERE username='$userName'";
        mysqli_query($conn,$query);
        //remove user basket
        $query = "DELETE FROM user_basket WHERE username='$userName'";
        mysqli_query($conn,$query);

        header("Location:adminPage.php");
        exit();    
    }

    //add User
    if(isset($_GET['addUser'])){
        
        $newusername = $_GET['username'];
        $alreadyIS = false;

        //checking that is not same name in db
        while($row = mysqli_fetch_assoc($userList)){
            if($row['username']==$newusername){
                $alreadyIS = true;
            }
        }
        if($alreadyIS==false){
            $password = $_GET['password'];
            $firstname = $_GET['firstname'];
            $lastname = $_GET['lastname'];
            if(isset($_GET['isAdmin']) && $_GET['isAdmin']=='Yes'){
                $accesslevel = 0;
            }else{
                $accesslevel = 1;
            }
            $sql = "INSERT INTO users SET firstname='$firstname', lastname='$lastname', username='$newusername', password='$password', accesslevel='$accesslevel' ";
            $result = mysqli_query($conn,$sql);
            header("Location:adminPage.php");
            exit();
        }else{

            

            header("Location:adminPage.php");
            exit();
        }
    }
 
    //remove items of user
    if(isset($_GET['removeItem'],$_GET['prodId'],$_GET['usName'])){
        $prodid = $_GET['prodId'];
        $uname = $_GET['usName'];
        $query = "DELETE FROM user_basket WHERE product_id='$prodid' AND username='$uname'";
        mysqli_query($conn,$query);
        header("Location:adminPage.php");
        exit(); 
    }

    //remove item from storage
    if(isset($_GET['remStorItem'],$_GET['itemname'])){
        $iName = $_GET['itemname'];
        $query = "DELETE FROM products WHERE name='$iName'";
        mysqli_query($conn,$query);
        header("Location:adminPage.php");
        exit(); 
    }

    //add item to storage
    if(isset($_GET['add_item'])){

        $imageName = $_GET['img_name'];
        $itemNameS = $_GET['name'];
        $itemName = str_replace(" ","_",$itemNameS);
        $description = $_GET['desc'];
        $price = $_GET['price'];
        $amount = $_GET['amount'];
        
        $sql = "INSERT INTO products SET name='$itemName',description='$description',price='$price',amount_storage='$amount',image_address='$imageName'";
        $result = mysqli_query($conn,$sql);

        header("Location:adminPage.php");
        exit();
    }







?>


<body class="adminBody"> 
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
                        <input type="submit" name="logout" value="<?php echo $_SESSION['username'] ?> : Log out" class="submitBtn">
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
        <table class="panel" style="padding:10px;text-align:center">
            <tr >
                    <form action="adminPage.php" method="get">
                    <td><input type="text" name="username" value="username"></td>
                    <td><input type="text" name="firstname" value="firstname"></td>
                    <td><input type="text" name="lastname" value="lastname"></td>
                    <td><input type="text" name="password" value="password"></td>
                    <td><input type="checkbox" name="isAdmin" value="Yes">admin</td>
                    <td><input type="submit" name="addUser" value="add user" class="btn" style="height:40px"></td>
                </form>
            </tr>
    <?php if( $userListLength > 0 ){ ?> 
            <tr style="color:white"><td><u>USER NAME</td><td><u>FIRST NAME</td><td><u>LAST NAME</td><td><u>PASSWORD</td><td><u>ACCESS LEVEL</td><td></td></tr>
            <?php while($row = mysqli_fetch_assoc($userList)){ ?>
                    <tr>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['firstname'] ?></td>
                        <td><?php echo $row['lastname'] ?></td>
                        <td><?php echo $row['password'] ?></td>
                        <td><?php if($row['accesslevel']==0){echo 'admin';}else{echo 'user';} ?></td>
                        <form action="adminPage.php" method="get">
                            <input type="hidden" name="username" value=<?php echo $row['username'] ?>>
                            <?php if($row['accesslevel']!=0){ ?>
                                <td><input type="submit" name="remUser" value="delete user" class="btn_red" style="height:15px;"></td>
                            <?php }else{ echo "<td></td>";} ?>
                        </form>
                    </tr>
        <?php }
            } ?> 
        </table>


    </div>



    
    <div class="products">
    <table class="panel" style="padding:10px;text-align:center">
        <tr style="color:White">
            <td><u>USER NAME:</td>
            <td><u>ITEM:</td>
            <td><u>AMOUNT:</td>
            <td><u>PRICE:</td>
            <td></td>
        </tr>
        <?php
            $username = $_SESSION['username'];
            $query = "SELECT *
                    FROM user_basket
                    INNER JOIN products ON user_basket.product_id = products.id
                    ORDER BY username";
                    
            $result = mysqli_query($conn,$query);
            $resultCheck = mysqli_num_rows($result);
            if($resultCheck > 0 ){
                while($row = mysqli_fetch_assoc($result))
                {
                ?>
                    <tr style="font-size: 20px;">
                        <td><?php echo $row['username']?></td>
                        <td><?php echo $row['name']?></td>
                        <td><?php echo "Amount: " . $row['amount']?></td>
                        <td><?php echo "Price: " . $row['price'] . " $"?></td>
                        <form action="<?php $_PHP_SELF ?>" method="get">
                            <td style="text-align:right"><input type="submit" name="removeItem" value="remove" class="btn_red"></td>
                            <input type="hidden" name="prodId" value=<?php echo $row['id']?>>
                            <input type="hidden" name="usName" value=<?php echo $row['username']?>>
                        </form>

                        

                    </tr>
        <?php  } ?>
                    
            <?php }else{
                echo " <tr><td></td><td>SHOPPING CARDs ARE EMPTY.</td>";
            }   
            ?>
        </table>
    </div>




    <div class="products" >
        <table class="panel">
            <?php
                $sql = "SELECT * FROM products;";
                $result = mysqli_query($conn,$sql);
                $resultCheck = mysqli_num_rows($result);
            ?>



            <tr>
                <form action="adminPage.php" method="get">
                    <td></td>
                    <td><input type="text" name="img_name" value="skate.png"></td>
                    <td><input type="text" name="name" value="skate"></td>
                    <td><input type="text" name="desc" value="some description"></td>
                    <td><input type="number" name="price" value="0" style="width:70px"></td>
                    <td><input type="number" name="amount" value="0" style="width:70px"></td>
                    <td><input type="submit" name="add_item" value="add item" class="btn" style="height:40px"></td>
                </form>
            </tr>
                <tr STYLE="color:white"> 
                    <td><U>LOADED IMAGE:</td>
                    <td>IMAGE NAME:</td>
                    <td>ITEM NAME:</td>
                    <td>ITEM DESCRIPTION:</td>
                    <td>PRICE:</td>
                    <td>AMOUNT:</td>
                    <td></td>
                </tr>

            <?php  
                if($resultCheck > 0)
                {   
                    
                    while($row = mysqli_fetch_assoc($result))
                    {
            ?>
                <div style="text-align:center">
                    <tr style="font-size: 20px;">
                        <td><img alt="No Image" src="assets/images/<?php echo $row['image_address']?>" style="max-width:50px;max-height:50px;" ></td>
                        <td><?php echo $row['image_address']?></td>
                        <td name="nameP"><?php echo $row['name']?></td>
                        <td><?php echo $row['description']?></td>
                        <td><?php echo $row['price']." $" ?></td> 
                        <td><?php echo $row['amount_storage']." pc." ?></td>
                        <form action="adminPage.php" method="get"> 
                            <input type="hidden" name="itemname" value=<?php echo $row['name']?>>
                            <td><input type="submit" name="remStorItem" value="rem item" class="btn_red"></td>
                        </form>
                    </tr>
                </div>    
            <?php
                    }
                }
            ?>
        </table>
    </div>



























</body>




