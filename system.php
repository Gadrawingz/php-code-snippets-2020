<?php
include ('operations.php');
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>System Homepage</title>
	<link rel="stylesheet" type="text/css" href="contents/mystyles.css">
	<style type="text/css">
		a{font-size: 22px; color: #ba4a00; padding: 5px; }
		select, input{ font-size: 20px; padding: 4px; width: 200px;}
	</style>
</head>
<body>
	<div class="page">
		<div class="hor_menus">
			<ul class="top">
				<li id="topitem"><a class="active" href="system.php?AddRent">Add Rentals</a></li>
				<li id="topitem"><a href="system.php?ManageRent">Manage Rentals</a></li>
				<li id="topitem"><a class="active" href="system.php?AddTenant">Manage Clients</a></li>
				<li id="topitem"><a href="system.php?ViewAg">Agreements</a></li>
				<li id="topitem"><a href="system.php?ViewAll">View All</a></li>
				<li id="topitem" style="float:right"><a class="active" href="system.php?LogOut">Log Out</a></li>
			</ul>
		</div>

		</div>
		<div class="content">
			<?php
			if(!isset($_SESSION['use'])){
				header("Location:index.php");
			}else{
				echo "<u><p class='hello'>Hello ".$_SESSION['use']." - You are logged In!</u></p>";
			} ?>

		<center><p class="welcome">
		This system named (House Rental Management System) is developed by using
		Html, Some CSS, and PHP especially PDO instead of Procedular method as it is 
		current chapter we are studying. This homepage will be managed by 
	    Registered user or the house owner.</p>



			<?php
			   if (isset($_GET['AddRent'])) {
			   	 if(isset($_POST['add_house']))
			   	 {
			   	 	$qobj= new SystemQuery;
			   	 	$check= $qobj->registerHouse($_POST['house_number'], $_POST['features'], 
			   	 	$_POST['house_size'], $_POST['rent_fees'], $_POST['house_status']);

			   	 	if($check){
			   	 		echo "<script>alert('HOUSE ADDED TO DB!')</script>";
			   	 		echo "<script>window.location='system.php'</script>";
			   	 	}else{echo "<script>alert('ROOM CAN'T BE ADDED!')</script>";}
			   	 }			   	
			?>

			<div class="insert_tbl"><h3>Add new house for rent</h3>
                <form method="POST" action="">
                <input type="text" name="house_number" placeholder="H Number"><br>
                <input type="text" name="features" placeholder="Features"><br>
                <select name="house_size" >
                	<option value="Large">Large</option>
                	<option value="Medium">Medium</option>
                	<option value="Small">Small</option>
                </select><br>
                <input type="text" name="rent_fees" placeholder="FEES"><br>
                <select name="house_status" >
                	<option value="Occupied">Occupied</option>
                	<option value="Available">Available</option>
                </select><hr>
                <input type="submit" name="add_house" id="submitbtn" value="Add House">
                </form>
            </div></center>
            <?php } ?>




            <?php
            if(isset($_GET['ManageRent']))
            { ?>
            	<fieldset><h2>View of all houses for Renting</h2><table class="view_tbl">
            		<tr><th>ID</th><th>House Number</th><th>House Features</th><th>House Size</th>
            		<th>House Price</th><th>House Status</th><th colspan="2">LINKS</th></tr>

            		<?php
            	    $qobj= new SystemQuery;
                    $statement= $qobj->viewHouses();
                    $hid= 1;
                    while($rows= $statement->FETCH(PDO::FETCH_ASSOC)){
                    ?>

                    <tr><td><?php echo $hid; ?></td> 
                    <td><?php echo $rows['house_number']; ?></td> 
                    <td><?php echo $rows['features']; ?></td> 
                    <td><?php echo $rows['house_size']; ?></td>
                    <td><?php echo $rows['rent_fees']; ?></td>
                    <td><?php echo $rows['house_status']; ?></td>
                    <td><a href="system.php?UpdHouse=<?php echo $rows['house_id']; ?>">Update</a></td>
                    <td><a href="system.php?DelHouse=<?php echo $rows['house_id']; ?>">Delete </a></td>
                    </tr>
                    <?php $hid++; } } ?></table></fieldset>



            <?php
            if (isset($_GET['UpdHouse']))
            { 
            	$updhs= new SystemQuery;
            	$stmt= $updhs->viewOneHouse($_GET['UpdHouse']);
            	$hrow= $stmt->FETCH(PDO::FETCH_ASSOC);

            	?>

                <div class="insert_tbl"><h3>Edit House Rental information</h3>
                <form method="POST" action="">
                <input type="hidden" name="house_id" value="<?php echo $hrow['house_id']; ?>"><br>
                <input type="text" name="house_number" value="<?php echo $hrow['house_number']; ?>"><br>
                <input type="text" name="features" value="<?php echo $hrow['features']; ?>"><br>
                <select name="house_size" >
                	<option value="<?php echo $hrow['house_size']; ?>"><?php echo $hrow['house_size']; ?></option>
                	<option value="Large">Large</option>
                	<option value="Medium">Medium</option>
                	<option value="Small">Small</option>
                </select><br>
                <input type="text" name="rent_fees" value="<?php echo $hrow['rent_fees']; ?>"><br>
                <select name="house_status" >
                	<option value="<?php echo $hrow['house_status']; ?>"><?php echo $hrow['house_status']; ?></option>
                	<option value="Occupied">Occupied</option>
                	<option value="Available">Available</option>
                </select><br><hr>
                <input type="submit" name="upd_house" id="submitbtn" value="Edit">
                </form>
            </div></center>
            
            <?php
            
            if(isset($_POST['upd_house']))
            {
            	$upd=$updhs->updateHouse($_POST['house_id'], $_POST['house_number'], $_POST['features'], 
            		$_POST['house_size'], $_POST['rent_fees'], $_POST['house_status']);
            if($upd== '1'){
            	echo "<script>alert('HOUSE DATA UPDATED!')</script>";
            	echo "<script>window.location='system.php?ManageRent'</script>";
            }else{
            	echo "<script>alert('EITHER NO CHANGE MADE OR CAN\'T UPDATE')</script>";
            }}
            } 
            ?>


            <!---CLIENT(VACANT) STUFFS-->

            <?php if(isset($_GET['AddTenant']))
            {
			   	 if(isset($_POST['save_tenant']))
			   	 {
			   	 	$qobj= new SystemQuery;
			   	 	$hfees= $_POST['house_number'];
			   	 	switch ($hfees) {
			   	 		case 'A22':
			   	 			echo $hf="90000";
			   	 			break;

			   	 		case 'A78':
			   	 			echo $hf="66000";
			   	 			break;

			   	 		case 'A10':
			   	 			echo $hf="80000";
			   	 			break;

			   	 		case 'B50':
			   	 			echo $hf="50000";
			   	 			break;

			   	 		default:
			   	 			echo $hf="0";
			   	 			break;
			   	 			}			   	

			   	 	$checkin= $qobj->addTenants($_POST['full_name'], $_POST['gender'], 
			   	 		$_POST['national_id'], $_POST['phone_number'], $_POST['email'], 
			   	 		$_POST['house_number'], $hf, $_POST['date_in'], $_POST['date_out'] );

			   	 	if($checkin){
			   	 		echo "<script>alert('CLIENT BOOKED A HOUSE!')</script>";
			   	 		echo "<script>window.location='system.php?addTenant'</script>";
			   	 	}else{echo "<script>alert('CLIENT CAN'T BOOK HOUSE!')</script>";}
			   	 }
			 ?>			   	
            	
            	<center><div style="color: green; border:1px dotted green; font-size: 20px; width: 800px; padding: 8px;">
            		<h2>ADD INFORMATION ABOUT NEW CLIENT/ VACANT</h2>
                <form method="POST" action="">
                <table>
                	<tr><td><input type="text" name="full_name" placeholder="Full names" required></td>
                		<td><select name="gender" >
                	<option value="Male">Male</option>
                	<option value="Female">Female</option>
                    </select></td></tr>

                <tr><td><input type="text" name="national_id" placeholder="Input National ID" required></td>
                <td><input type="text" name="phone_number" placeholder="Tel Number" required></td></tr>
                
                <tr><td><input type="text" name="email" placeholder="Email address" required></td>
                <td>
                <select name="house_number" required="">
                <?php $x= new SystemQuery;
                $stmt= $x->viewHouses();
                while($rs= $stmt->FETCH(PDO::FETCH_ASSOC)){ ?>
                <option value="<?php echo $rs['house_number']; ?>"><?php echo $rs['house_number']; ?></option>
                <?php } ?>
                </select></td></tr>

                <tr><td><input type="date" name="date_in" placeholder="DATE IN" required></td>
                <td><input type="date" name="date_out" placeholder="DATE OUT" required></td></tr>

                <tr><td colspan="2">
                	<center><input type="submit" name="save_tenant" id="submitbtn" value="Add Client"></center></td></tr>
                </table></form>
                <a href="system.php?showClients">Show All Tenants</a>
                <?php } ?>

                

                <?php if(isset($_GET['showClients'])) { ?>
             
            	<fieldset>
            		<h2>List of all houses for Renting</h2><table class="view_tbl">
            		<tr><th>ID</th><th>Full Name</th><th>Gender</th><th>Nat ID</th>
            		<th>Phone No</th><th>Email</th><th>House N<sup>o</sup></th><th>Fees</th><th>Reg Date</th>
            		<th>Exit Date</th><th colspan="2">LINKS</th></tr>

            		<?php
            	    $qobj= new SystemQuery;
                    $statement= $qobj->viewAllTenants();
                    while($rows= $statement->FETCH(PDO::FETCH_ASSOC)){
                    ?>

                    <tr><td><?php echo $rows['tenant_id']; ?></td> 
                    <td><?php echo $rows['full_name']; ?></td> 
                    <td><?php echo $rows['gender']; ?></td> 
                    <td><?php echo $rows['national_id']; ?></td>
                    <td><?php echo $rows['phone_number']; ?></td>
                    <td><?php echo $rows['email']; ?></td>
                    <td><?php echo $rows['house_number']; ?></td>
                    <td><?php echo $rows['rent_fees']; ?></td>
                    <td><?php echo $rows['reg_date']; ?></td>
                    <td><?php echo $rows['exit_date']; ?></td>
                    <td><a href="system.php?UpdClient=<?php echo $rows['tenant_id']; ?>">Update</a></td>
                    <td><a href="system.php?DelClient=<?php echo $rows['tenant_id']; ?>">Delete </a></td>
                    </tr><?php } ?>
                    </table><a href="system.php?AddTenant">Hide This list</a></fieldset>

            </div></center>
            <?php } ?>



                    <?php
                    if(isset($_GET['LogOut'])){
                    	session_destroy();
                    	header("Location:index.php");
                    }
                    ?>

		</div>
		<footer>
			<center><p class="foot">This system belongs to ICTL3A as Assignment &copy; 2019 - Built by Gad Iradufasha.</p></center>
		</footer>
	</div>
</body>
</html>
