<?php
//This page let create a new Barber
include('config.php');
if(isset($_SESSION['username']) and $_SESSION['username']==$admin)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Create Barber</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Forum" /></a>
	    </div>
        
		<?php
		$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"'));
		$nb_new_pm = $nb_new_pm['nb_new_pm'];
		?>
		<div class="box">
			<div class="box_left">
				<a href="<?php echo $url_home; ?>">Home</a> &gt; Create Barber
			</div>
			<div class="box_right">
				<a href="list_pm.php">Your messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['userid']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Logout</a>)
			</div>
			<div class="clean"></div>
		</div>
		
		<?php
		if(isset($_POST['barbername'], $_POST['shop'], $_POST['gender'], $_POST['email'], $_POST['yearsofexperience'], $_POST['description']) and $_POST['barbername']!='')
		{			
			if(get_magic_quotes_gpc())
			{
				$_POST['barbername'] = stripslashes($_POST['barbername']);
				$_POST['shop'] = stripslashes($_POST['shop']);
				$_POST['gender'] = stripslashes($_POST['gender']);
				$_POST['yearsofexperience'] = stripslashes($_POST['yearsofexperience']);
				$_POST['email'] = stripslashes($_POST['email']);
				$_POST['description'] = stripslashes($_POST['description']);
			}
				
			$barbername = mysql_real_escape_string($_POST['barbername']);
			$shop = mysql_real_escape_string($_POST['shop']);
			$gender = mysql_real_escape_string($_POST['gender']);
			$yearsofexperience = mysql_real_escape_string($_POST['yearsofexperience']);
			$email = mysql_real_escape_string($_POST['email']);
			$description = mysql_real_escape_string($_POST['description']);
			
			$photo = $_FILES['photo']['tmp_name'];
			
			
			$barberquery = mysql_num_rows(mysql_query('select id from barber where name="'.$barbername.'"'));
			if($barberquery == 0)
			{
				$shopquery = mysql_num_rows(mysql_query('select id from shop where name="'.$shop.'"'));
				if($shopquery != 0)
				{			
					if(!isset($photo))
					{
						
					}
					else
					{
						$image = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
						$image_size = getimagesize($_FILES['photo']['tmp_name']);
						if ($image_size == FALSE)
						{
							echo "this is not an image.";
						}
					}
					if(mysql_query('insert into barber(shopid, name, gender, description, email, yearsofexperience, photo) 
									values ("'.$shopquery['id'].'", "'.$barbername.'", "'.$gender.'", "'.$description.'", "'.$email.'", "'.$yearsofexperience.'", "'.$image.'")'))
					{
						$form = false;
			?>
					<div class="message">The Barber have successfully been created.<br />
					<a href="<?php echo $url_home; ?>">Go to the Home Page</a></div>
			<?php
					}
					else
					{
						$form = true;
						$message = 'An error occurred while insert barber.';
					}
				}
				else
				{
					$form = true;
					$message = 'Barber Shop does not exist.';
				}
			}
			else
			{
				$form = true;
				$message = 'Another user already use this name.';
			}
		}
		else
		{
			$form = true;
		}
		
		
		if($form)
		{
			if(isset($message))
			{
				echo '<div class="message">'.$message.'</div>';
			}
		?>
		<div class="content">
			<form action="create_barber.php" method="post" enctype="multipart/form-data">
				<div class="center">
					<table>
						<tr>
							<td>
								<label for="barbername">Name</label>
							</td>
							<td>
								<input type="text" name="barbername" id="barbername" />
							</td>
						</tr>
						<tr>
							<td>
								<label for="shop">Shop</label>
							</td>
							<td>
								<input type="text" name="shop" id="shop" />
							</td>
						</tr>
						<tr>
							<td>
								<label for="gender">Gender</label>
							</td>
							<td>
								<input type="text" name="gender" id="gender" />
							</td>
						</tr>
						<tr>
							<td>
								<label for="email">Email</label>
							</td>
							<td>
								<input type="text" name="email" id="email" />
							</td>
						</tr>
						<tr>
							<td>
								<label for="yearsofexperience">Years of Experience</label>
							</td>
							<td>
								<input type="text" name="yearsofexperience" name="yearsofexperience" />
							</td>
						</tr>
						<tr>
							<td>
								<label for="description">Description</label>
							</td>
							<td>
								<textarea cols="40" rows="5" id="description" name="description"></textarea>
							</td>
						</tr>
						<tr>
							<td>
								<label for="photo">Photo</label>
							</td>
							<td>
								<input type="file" name="photo" id="photo" />
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="submit" value="Save" />
							</td>
						</tr>
					</table>
					
				</div>
			</form>
		</div>
		<?php
		}
		?>
		<div class="foot"><?php echo $footer; ?></div>
	</body>
</html>
<?php
}
else
{
	echo '<h2>You must be logged as an administrator to access this page: <a href="login.php">Login</a> - <a href="signup.php">Sign Up</a></h2>';
}
?>