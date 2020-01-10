<?php
include ('operations.php');
session_start();

if(isset($_POST['save_admin']))
{
$qobj= new SystemQuery;

if($qobj->insertAdmin($_POST['fullnames'], $_POST['username'], $_POST['email'], $_POST['password']) =='1')
{
	echo "<script>alert('New Admin Added!'); </script>";
	echo "<script>window.location='index.php';</script>";

}else{
	echo "<center><h2>Failed to be added!</h2></center>";
}
}


if(isset($_SESSION['use'])){
    header("Location: system.php");
}


if(isset($_POST['login'])){
    $object = new SystemQuery;

    $stmt= $object->checkLogin();
    $urow= $stmt->FETCH(PDO::FETCH_ASSOC);

    if($_POST['email'] == $urow['email'] && $_POST['password'] == $urow['password'])
    {
        $_SESSION['use'] = $urow['fullnames'];
        echo '<script>window.open("system.php?home","_self"); </script>';
    }else{
        echo "<center><p style='color:red'>Invalid Username and Password!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>HOUSE RENTAL | FIRST PAGE</title>
	<style type="text/css">
		input{ height: 25px; width: 200px; padding: 3px; font-size: 18px; }
        a{font-size: 20px; color: blue; text-decoration: none;}
		a:hover{font-size: 20px; color: darkblue; text-decoration: underline;}
        .forlink{  font-size: 18px; font-family: georgia; }
        button{ font-family: verdana; font-size: 18px; 
        border: 2px solid #7d3c98; padding: 2px; background-color: #d5f5e3;
        color: blue; border-radius: 3px;
        }
        table td{ width: 200px;font-size: 18px; }
        .logdiv {width: 700px; height: 450px; overflow: auto; 
            border: 2px dotted red; padding: 5px; background-color: #fadbd8;}
        .heading {
            border: 4px solid #d35400; font-size: 18px;
            padding: 6px; width: 800px; height: 33px;
            color: brown; font-family: georgia;
            text-decoration: underline;
        }
	</style>
</head>
<body><center>
<div class="heading">Welcome to House rental Managemant Information System Login Page</div><br>


<div class="logdiv">
<?php
if(isset($_GET['regAdmin']))
{
?>
<h2>Admin Registration</h2><form method="POST">
<table border="1">
<tr><td>Full Name:</td><td><input type="text" name="fullnames"></td></tr>
<tr><td>Username</td><td><input type='text' name='username'></td></tr>
<tr><td>Email</td><td><input type='text' name='email'></td></tr>
<tr><td>Password</td><td><input type='text' name='password'></td></tr>
<tr><td colspan="2"><center><button type="submit" name="save_admin">Add Admin</button></center></td>
</table>
</form><hr>

<?php } ?>


<h2>Administrator Login</h2>
<form method="POST">
    <input type="text" name="email" placeholder="Your email"><br><br>
    <input type='password' name='password' placeholder="Your password"><br><br>
    <center><button type="submit" name="login">Login</button></center>
</table>
</form><br>

<div class="forlink">For new Admin, <a href="index.php?regAdmin">Here's a link to register</a></div>

</div>
</center>
<footer>Developed by Gad IRADUFASHA @ 2019</footer>
</body>
</html>
