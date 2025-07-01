<?php
$tasksFile = 'tasks.json';

if (!file_exists($tasksFile)) {
    file_put_contents($tasksFile, json_encode([]));
}

$tasks = json_decode(file_get_contents($tasksFile), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['task'])) {
        $tasks[] = htmlspecialchars($_POST['task']);
        file_put_contents($tasksFile, json_encode($tasks));
    }
    if (isset($_POST['delete'])) {
        unset($tasks[$_POST['delete']]);
        $tasks = array_values($tasks);
        file_put_contents($tasksFile, json_encode($tasks));
    }
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Task Manager</h1>
    <form method="POST">
        <input type="text" name="task" placeholder="Enter new task" required>
        <button type="submit">Add Task</button>
    </form>
    <ul>
        <?php foreach ($tasks as $index => $task): ?>
            <li>
                <?php echo $task; ?>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="delete" value="<?php echo $index; ?>">
                    <button type="submit">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
