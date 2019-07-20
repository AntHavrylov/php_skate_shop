<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head> 
<body class="loginBody">
<div class="navbar">
        <ul>
            <li>
                <a href="index.php">Main page</a> 
            </li>
            <li>
                <a href="createUser.php">Create user</a> 
            </li>
            <li class="active">
                <a href="loginCart.php">Login</a> 
            </li>        
        </ul>
    </div>
    <div class="panel" style="width: 50%;margin-top:12%;margin-left:25%;margin-right:25%; padding:20px; text-align:center">
      <form action="loginCart.php" method="get">
      <h1 style="text-align:center">Sign in</h1>
        <div style="font-size:24px">
          <div>User name:  <input type="text" name="username"></div>
          <div>Password:   <input type="password" name="password"></div>
        </div>
        <input type="submit" name="login" value="LOG IN" class="btn" style="width:80%;height:40px;margin-top:20px">
      </form>
    </div>
  <?php
  include_once 'dbcon.php';
  if(isset($_GET['login'])) {
      $username = $_GET['username'];
      $password = $_GET['password'];
      if ($username && $password) {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            if($password == $row['password']){
              session_start();
              $_SESSION["username"] = $username;
              $_SESSION["accesslevel"] = $row['accesslevel'];
              header('Location: index.php');
            }else{
              echo "WRONG PASS";
            }
          }
      } else {
          echo "0 results";
      }
      $conn->close();
      }
    }
  ?>
</body>
