<?php
	include 'database.php';

	if(isset($_GET['id'])) {
		$taskid = mysqli_real_escape_string($conn, $_GET['id']);

		// select data yang akan diedit
		$q_select = "SELECT * FROM tasks WHERE taskid = '$taskid'";
		$run_q_select = mysqli_query($conn, $q_select);

		if ($run_q_select) {
			$d = mysqli_fetch_object($run_q_select);
		} else {
			echo "Failed to retrieve task data.";
		}
	}

	// proses edit data
	if(isset($_POST['edit'])){
		$task = mysqli_real_escape_string($conn, $_POST['task']);
		$due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
		$description = mysqli_real_escape_string($conn, $_POST['description']);
		
		$q_update = "UPDATE tasks SET tasklabel = '$task', due_date = '$due_date', description = '$description' WHERE taskid = '$taskid'";
		$run_q_update = mysqli_query($conn, $q_update);

		if ($run_q_update) {
			header('Location: index.php');
			exit;
		} else {
			echo "Failed to update task.";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>To Do List</title>
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<style type="text/css">
    	@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
    	* {
        	padding:0;
        	margin:0;
        	box-sizing: border-box;
    	}
    	body {
        	font-family: 'Roboto', sans-serif;
    	}
    	.container {
        	width: 590px;
        	height: 100vh;
        	margin:0 auto;
    	}
    	.header {
        	padding: 15px;
    	}
    	.header .title {
        	display: flex;
        	align-items: center;
        	margin-bottom: 7px;
    	}
    	.header .title i {
        	font-size: 24px;
        	margin-right: 10px;
    	}
    	.header .title span {
        	font-size: 18px;
    	}
    	.header .description {
            font-size: 15px;
            font-weight: bold;
		}
    	.content {
        	padding: 15px;
    	}
    	.card {
        	background-color: #fff;
        	padding: 15px;
        	border-radius: 10px;
        	margin-bottom: 10px;
        	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    	}
    	.input-control {
        	width: 100%;
        	display: block;
        	padding: 0.5rem;
        	font-size: 1rem;
        	margin-bottom: 10px;
        	border: 1px solid #ccc; /* Border ringan */
        	border-radius: 5px;
    	}
    	.text-center {
        	text-align: center;
    	}
    	button {
        	padding: 0.5rem 1rem;
        	font-size: 1rem;
        	cursor: pointer;
        	background: #64b5f6;
        	color: #fff;
        	border: none;
        	border-radius: 5px;
        	transition: background-color 0.3s;
    	}
    	button:hover {
        	background: #1e88e5;
    	}
    	.task-item {
        	display: flex;
        	justify-content: space-between;
    	}
    	.text-orange {
        	color: orange;
    	}
    	.text-red {
        	color: red;
    	}
    	.task-item.done span {
        	text-decoration: line-through;
        	color: #ccc;
    	}
    	@media (max-width: 768px){
        		.container {
            	width: 100%;
        	}
    	}
		#background-video{
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            z-index: -1;
        }
	</style>
</head>

<video id="background-video" autoplay loop muted poster="Video/Background.mp4">
    <source src="video/Background.mp4" type="video/mp4">
</video>

<body>
<div class="container">
	<div class="header">
			<div class="title">
				<h1 class='bx bx-sun'></h1>
				<h1>To Do List</h1>
			</div>

			<div class="description">
				<?=date("l, d F Y") ?>
			</div>

			<div class="description">
				<span id="clock">Time: <?php echo date("H:i:s"); ?></span>
			</div>

			<script>
				function updateClock() {
					const clockElement = document.getElementById('clock');
					const now = new Date();
					const hours = String(now.getHours()).padStart(2, '0');
					const minutes = String(now.getMinutes()).padStart(2, '0');
					const seconds = String(now.getSeconds()).padStart(2, '0');
					const timeString = 'Time: ' + hours + ':' + minutes + ':' + seconds;
					clockElement.textContent = timeString;
				}
				setInterval(updateClock, 1000);
			</script>
	</div>
	
    <div class="header">
        <div class="title">
            <a href="index.php"><i class='bx bx-chevron-left'></i></a>
            <span>Back</span>
        </div>
    </div>

    <div class="content">
		<div class="card">
    		<form action="" method="post">
				<h3>Judul Task</h3><br>
        		<input type="text" name="task" class="input-control" placeholder="Edit task" value="<?= isset($d->tasklabel) ? $d->tasklabel : '' ?>">
        		
				<h3>Due Date</h3><br>
				<input type="date" name="due_date" class="input-control" placeholder="Due Date" value="<?= isset($d->due_date) ? $d->due_date : '' ?>">
        		
				<h3>Decription</h3><br>
				<textarea name="description" class="input-control" placeholder="Description"><?= isset($d->description) ? $d->description : '' ?></textarea>

        		<h3>Status</h3><br>
				<div class="input-control">
            		<select name="status" id="status">
                		<option value="not_started" <?= isset($d->taskstatus) && $d->taskstatus == 'not_started' ? 'selected' : '' ?>>Not Yet Started</option>
                		<option value="in_progress" <?= isset($d->taskstatus) && $d->taskstatus == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                		<option value="waiting_on" <?= isset($d->taskstatus) && $d->taskstatus == 'waiting_on' ? 'selected' : '' ?>>Waiting On</option>
           	 		</select>
        		</div>
        		<div class="text-center">
            		<button type="submit" name="edit">Edit</button>
        		</div>
    		</form>
		</div>
    </div>
</div>
</body>
</html>