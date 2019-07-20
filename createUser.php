<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head> 
<body class="createUserBody">
<div class="navbar">
        <ul>
            <li>
                <a href="index.php">Main page</a> 
            </li>
            <li class="active">
                <a href="createUser.php">Create user</a> 
            </li>
            <li>
                <a href="loginCart.php">Login</a> 
            </li>        
        </ul>
    </div>
    <div class="panel" style="width: 50%;margin-top:8%;margin-left:25%;margin-right:25%; padding:20px;text-align:center">
      <form action="createUser.php" method="get">
      <h1 style="text-align:center">Create user</h1>
        <div style="font-size:24px">
          <div>User name:  <input type="text" name="username"></div>
          <div>Password:   <input type="password" name="password"></div>
          <div>First name: <input type="text" name="firstname"></div>
          <div>Last name:  <input type="text" name="lastname"></div>
        </div>
        <input type="submit" name="createU" value="CREATE USER" class="btn" style="width:80%;height:40px;margin-top:20px">
      </form>
    </div>
  <?php
  include_once 'dbcon.php';
  if(isset($_GET['createU'])) {
      $username = $_GET['username'];
      $password = $_GET['password'];
      $firstname = $_GET['firstname'];
      $lastname = $_GET['lastname'];
      $accesslevel = "1";
      if ($firstname && $lastname && $username && $password && $accesslevel) {
        $query = "SELECT * FROM users WHERE username='$username'";
        $res=mysqli_query($conn,$query);
        
        // make sure it worked!
        if (!$res) {
          mysql_error();
          exit;
        }
        $sql = "INSERT INTO users SET firstname='$firstname', lastname='$lastname', username='$username', password='$password', accesslevel='$accesslevel' ";
        $result = mysqli_query($conn,$sql);
        
        if (! $res) {
          echo mysql_error();
          exit;
        } else {       
          header('Location: loginCart.php');
        }
      }
    }
  ?>
</body>