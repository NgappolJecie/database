<?php

if (isset($_POST['submit']))
{

	try
	{
		require "/config.php";
		require "/common.php";

		$connection = new PDO($dsn, $username, $password, $options);

		$sql = "SELECT *
						FROM Topic
						WHERE name = :name";

		$name = $_POST['name'];

		$statement = $connection->prepare($sql);
		$statement->bindParam(':name', $name, PDO::PARAM_STR);
		$statement->execute();

		$result = $statement->fetchAll();
	}

	catch(PDOException $error)
	{
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>
<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit']))
{
	if ($result && $statement->rowCount() > 0)
	{ ?>
		<h2>Entries</h2>

		<table>
			<thead>
				<tr>
					<th>#</th>
					<th>Topic</th>
					<th>Content</th>
					<th>Name</th>
				</tr>
			</thead>
			<tbody>
	<?php
		foreach ($result as $row)
		{ ?>
			<tr>
				<td><?php echo escape($row["topic"]); ?></td>
				<td><?php echo escape($row["content"]); ?></td>
				<td><?php echo escape($row["name"]); ?></td>
			</tr>
		<?php
		} ?>
		</tbody>
	</table>


<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
