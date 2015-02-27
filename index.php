<?php
//This page displays the list of the forum's categories
include('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Forum</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Forum"/></a>
	    </div>
        
		<!-- Get Personal Message  
			 1. Check session for user login
			 2. if true, get the personal messages
			 3. if false, redirect to login page		
		-->		
		<div class="box">
			<div class="box_left">
				<a href="<?php echo $url_home; ?>">Home</a>
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
		if(isset($_SESSION['username']) and $_SESSION['username']==$admin)
		{
		?>
			<a href="Create_barber.php" class="button">Add Barber</a>
		<?php
		}
		?>	
		<?php
			//$arr = array("value1","value2","value3","value4");
			//echo "<table>";
			//$rows = array_chunk($arr,3);
			//foreach($rows as $row) {
			//  echo "<tr>";
			// foreach($row as $cell) {
			//	echo "<td>".$cell."</td>";
			//  }
			//  echo "</tr>";
			//}
			//echo "</table>";
		?>
		<?php
			//$input_array = array('a', 'b', 'c', 'd', 'e','f','g');
			//$new_array = array_chunk($input_array, 3);

			//$table = '<table border="1">';
			//foreach($new_array as $value){
			//$table .= '<tr><td>'.$value[0].'</td><td>'.$value[1].'</td><td>'.$value[2].'</td>    </tr>';
			//}
			//$table.='</table>';

			//echo $table;
		?>
		
		<?php
			$barberquerys = mysql_query('SELECT id, name FROM barber');
			$barberarray = array(); 
			
			while($row = mysql_fetch_array($barberquerys))
			{
				$rows[] = $row['id']; 
			}
			$new_array = array_chunk($rows, 3);
			echo "<table>";
			foreach($new_array as $value){
				
				echo "<tr>";
		?>		
				<td>		
					<img src="get.php?id=<?php echo $value[0]?>" width="150" />
				</td>
				<td>
					<img src="get.php?id=<?php echo $value[1]?>" width="150" />
				</td>
				<td>
					<img src="get.php?id=<?php echo $value[2]?>" width="150" />
				</td>
		<?php		
				echo "</tr>";
			}
			echo "</table>";
		?>		
				
		</div>
		
		<div class="content">
		<?php
		if(isset($_SESSION['username']) and $_SESSION['username']==$admin)
		{
		?>
			<a href="new_category.php" class="button">Add Category</a>
		<?php
		}
		?>
		
		<table class="categories_table">
			<tr>
				<th class="forum_cat">Category</th>
				<th class="forum_ntop">Topics</th>
				<th class="forum_nrep">Replies</th>
				<?php
				if(isset($_SESSION['username']) and $_SESSION['username']==$admin)
				{
				?>
				<th class="forum_act">Action</th>
				<?php
				}
				?>
			</tr>
			
			<?php
			$dn1 = mysql_query('select c.id, c.name, c.description, c.position, (select count(t.id) from topics as t where t.parent=c.id and t.id2=1) as topics, (select count(t2.id) from topics as t2 where t2.parent=c.id and t2.id2!=1) as replies from categories as c group by c.id order by c.position asc');
			$nb_cats = mysql_num_rows($dn1);
			while($dnn1 = mysql_fetch_array($dn1))
			{
			?>
			
			<tr>
				<td class="forum_cat"><a href="list_topics.php?parent=<?php echo $dnn1['id']; ?>" class="title"><?php echo htmlentities($dnn1['name'], ENT_QUOTES, 'UTF-8'); ?></a>
				<div class="description"><?php echo $dnn1['description']; ?></div></td>
				<td><?php echo $dnn1['topics']; ?></td>
				<td><?php echo $dnn1['replies']; ?></td>
				<?php
				if(isset($_SESSION['username']) and $_SESSION['username']==$admin)
				{
				?>
						<td><a href="delete_category.php?id=<?php echo $dnn1['id']; ?>"><img src="<?php echo $design; ?>/images/delete.png" alt="Delete" /></a>
						<?php if($dnn1['position']>1){ ?><a href="move_category.php?action=up&id=<?php echo $dnn1['id']; ?>"><img src="<?php echo $design; ?>/images/up.png" alt="Move Up" /></a><?php } ?>
						<?php if($dnn1['position']<$nb_cats){ ?><a href="move_category.php?action=down&id=<?php echo $dnn1['id']; ?>"><img src="<?php echo $design; ?>/images/down.png" alt="Move Down" /></a><?php } ?>
						<a href="edit_category.php?id=<?php echo $dnn1['id']; ?>"><img src="<?php echo $design; ?>/images/edit.png" alt="Edit" /></a></td>
				<?php
				}
				?>
			</tr>
			<?php
			}
			?>
		</table>

		</div>
		<div class="foot"><?php echo $footer; ?></div>
	</body>
</html>