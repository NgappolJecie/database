<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit']))
{

	require "/config.php";
	require "/common.php";

	try
	{
		$connection = new PDO($dsn, $username, $password, $options);

		$new_user = array(
			"topic" => $_POST['topic'],
      "name"     => $_POST['name'],
			"content"  => $_POST['content']
		);

		$sql = sprintf(
				"INSERT INTO %s (%s) values (%s)",
				"users",
				implode(", ", array_keys($new_user)),
				":" . implode(", :", array_keys($new_user))
		);

		$statement = $connection->prepare($sql);
		$statement->execute($new_user);
	}

	catch(PDOException $error)
	{
		echo $sql . "<br>" . $error->getMessage();
	}

}
?>

<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit']) && $statement)
{ ?>
	<blockquote><?php echo $_POST['topic']; ?> successfully added.</blockquote>
<?php
} ?>

<h2>Create Forum</h2>

<form method="post">
	<label for="topic">Topic</label>
	<input type="text" name="topic" id="topic">
	<label for="content">Content</label>
	<input type="text" name="content" id="content">
	<label for="name">Name</label>
	<input type="text" name="name" id="name">
	<input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to Home</a>

<?php require "templates/footer.php"; ?>
