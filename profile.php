<?php
//This page display the profile of an user
include('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>User Profile</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Forum" /></a>
	    </div>
		<!-- Get Personal Message  
			 1. Check session for user login
			 2. if true, get the personal messages
			 3. if false, redirect to login page		
		-->		
		<div class="box">
			<div class="box_left">
				<a href="<?php echo $url_home; ?>">Home</a> &gt; <a href="users.php">List of users</a> &gt; User Profile
			</div>
			<div class="box_right">
				<?php 
				if(isset($_SESSION['username']))
				{
				$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"'));
				$nb_new_pm = $nb_new_pm['nb_new_pm'];
				?> 		
				<a href="list_pm.php">Your messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['userid']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Logout</a>)
				<?php
				}
				else
				{
				?>
				<a href="signup.php">Sign Up</a> - <a href="login.php">Login</a>
				<?php
				}	
				?>
			</div>
			<div class="clean"></div>
		</div>		
		<div class="content">
		<?php
		if(isset($_GET['id']))
		{
			$id = intval($_GET['id']);
			$dn = mysql_query('select username, email, avatar, signup_date from users where id="'.$id.'"');
			if(mysql_num_rows($dn)>0)
			{
				$dnn = mysql_fetch_array($dn);
		?>
		
		<?php echo htmlentities($dnn['username']); ?>'s Profile :
		
		<?php
		if($_SESSION['userid']==$id)
		{
		?>
		<br /><div class="center"><a href="edit_profile.php" class="button">Edit</a></div>
		<?php
		}
		?>
		
		<table style="width:400px;">
			<tr>
				<td colspan = "2"><?php
					if($dnn['avatar']!='')
					{
						echo '<img src="'.htmlentities($dnn['avatar'], ENT_QUOTES, 'UTF-8').'" alt="Avatar" style="max-width:100px;max-height:100px;" />';
					}
					else
					{
						echo 'No Photo.';
					}
					?>
				</td>
			</tr>
			<tr>
				<td colspan = "2">
					<h1><?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?></h1>
				</td>
			</tr>
			<tr>
				<td>
					Email :
				</td>
				<td>
					<?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?>
				</td>
			</tr>
			<tr>
				<td>
					Registration date :
				</td>
				<td>
					<?php echo date('Y/m/d',$dnn['signup_date']); ?>
				</td>
			</tr>
		</table>
		<!-- Send Personal Message  
			 1. Check User profile same as login user
			 2. if true, disable send message button
			 3. if false, enable send message button	
		-->		
		<?php
		if(isset($_SESSION['username']) and $_SESSION['username']!=$dnn['username'])
		{
		?>
		<br /><a href="new_pm.php?recip=<?php echo urlencode($dnn['username']); ?>" class="big">Envoyer un MP à "<?php echo htmlentities($dnn['username'], ENT_QUOTES, 'UTF-8'); ?>"</a>
		<?php
		}
			}
			else
			{
				echo 'This user does not exist.';
			}
		}
		else
		{
			echo 'The ID of this user is not defined.';
		}
		?>
		</div>
		<div class="foot"><?php echo $footer; ?></div>
	</body>
</html>