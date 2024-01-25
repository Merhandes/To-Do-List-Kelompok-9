<?php
	include 'database.php';

	// proses insert data
	if (isset($_POST['add'])) {
        $task = $_POST['task'];
        $due_date = $_POST['due_date'];
        $description = $_POST['description'];
        $status = $_POST['status'];
    
        $q_insert = "INSERT INTO tasks (tasklabel, taskstatus, due_date, description) VALUES (
            '$task',
            '$status',
            '$due_date',
            '$description'
        )";
        $run_q_insert = mysqli_query($conn, $q_insert);

        if($run_q_insert){
            header('Refresh:0; url=index.php');
        }
    }

    // Proses show data
    $q_select = "SELECT taskid, tasklabel, taskstatus, due_date, description FROM tasks ORDER BY taskid DESC";
    $run_q_select = mysqli_query($conn, $q_select);

    // Proses delete data
    if(isset($_GET['delete'])){
        $q_delete = "DELETE FROM tasks WHERE taskid = '".$_GET['delete']."' ";
        $run_q_delete = mysqli_query($conn, $q_delete);
        header('Refresh:0; url=index.php');
    }

    // Proses update data (close or open)
    if(isset($_GET['done'])){
        $status = 'close';
        if($_GET['status'] == 'open'){
            $status = 'close';
        }else{
            $status = 'open';
        }
        $q_update = "UPDATE tasks SET taskstatus = '".$status."' WHERE taskid = '".$_GET['done']."' ";
        $run_q_update = mysqli_query($conn, $q_update);
        header('Refresh:0; url=index.php');
    }
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
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

        .container {
            width: 590px;
            height: 100vh;
            margin:0 auto;
        }

        .header {
            padding: 20px;
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

        .card2 {
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .input-control {
            width: 100%;
            display: block;
            padding: 1rem;
            font-size: 1rem;
            margin-bottom: 10px;
            border: 1px solid #ccc;
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

        .btn.btn-warning {
        background-color: #ff6600;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        }

        .btn.btn-warning:hover {
            background-color: #ff9900;
        }

        .btn.btn-warning:active {
            background-color: #cc5500;
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

		<div class="content">
            <div class="card">
                <form action="" method="post">
                    <h3>Judul Task</h3><br>
                    <input type="text" name="task" class="input-control" placeholder="Add task">

                    <h3>Due Date</h3><br>
                    <input type="date" name="due_date" class="input-control" placeholder="Due Date">

                    <h3>Description</h3><br>
                    <textarea name="description" class="input-control" placeholder="Description"></textarea>

                    <h3>Status</h3><br>
                    <div class="input-control">
                        <select name="status" id="status">
                            <option value="not_started">Not Yet Started</option>
                            <option value="in_progress">In Progress</option>
                            <option value="waiting_on">Waiting On</option>
                        </select>
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" name="add">Add</button>
                    </div>
                </form>
            </div>

            <?php
                if (mysqli_num_rows($run_q_select) > 0) {
                while ($r = mysqli_fetch_array($run_q_select)) {
            ?>

            <div class="card2">
                <div class="task-item <?= $r['taskstatus'] == 'close' ? 'done' : '' ?>">
                    <div>
                        <input type="checkbox" onclick="window.location.href = '?done=<?= $r['taskid'] ?>&status=<?= $r['taskstatus'] ?>'" <?= $r['taskstatus'] == 'close' ? 'checked' : '' ?>>
                        <h2><?= $r['tasklabel'] ?></h2>
                        <p><strong>Due Date:</strong> <?= date('d F Y', strtotime($r['due_date'])) ?></p>
                        <p><strong>Status:</strong> <?= $r['taskstatus'] ?></p> <!-- Menampilkan status -->
                        <p><strong>Description:</strong> <?= $r['description'] ?></p>
                    </div>
                    <div>
                        <a href="edit.php?id=<?= $r['taskid'] ?>" class="text-orange" title="Edit"><i class="bx bx-edit"></i></a>
                        <a href="?delete=<?= $r['taskid'] ?>" class="text-red" title="Remove" onclick="return confirm('Are you sure ?')"><i class="bx bx-trash"></i></a>
                    </div>
                </div>
            </div>
            
            <?php }} else { ?>
                <div class="card">
                    <h2>Belum ada task</h2>
                </div>
            <?php } ?>
            
            <br>
            <a href="logout.php" class="btn btn-warning">Logout</a>
        </div>
    </div>
</body>
</html>