<?php
session_start();

// Initialize the students array if not set in session
if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

// Handle add, edit, and delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        // Add new student
        $name = $_POST['name'];
        $age = $_POST['age'];
        $class = $_POST['class'];
        $_SESSION['students'][] = ['name' => $name, 'age' => $age, 'class' => $class];
    } elseif (isset($_POST['edit'])) {
        // Edit student
        $index = $_POST['index'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $class = $_POST['class'];
        $_SESSION['students'][$index] = ['name' => $name, 'age' => $age, 'class' => $class];
    } elseif (isset($_POST['delete'])) {
        // Delete student
        $index = $_POST['index'];
        array_splice($_SESSION['students'], $index, 1);
    }
}

// Get the current list of students
$students = $_SESSION['students'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom Management</title>
    <style>
        /* Styling for better UI */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
        }
        .form-container {
            margin-bottom: 20px;
        }
        .btn {
            padding: 8px 12px;
            margin: 5px;
            cursor: pointer;
        }
        .btn-edit {
            background-color: #4CAF50;
            color: white;
        }
        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            table, th, td {
                font-size: 14px;
            }
            .form-container input, .form-container button {
                width: 100%;
                margin-bottom: 10px;
            }
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <h2>Classroom Management</h2>

<!-- Form to add a new student -->
<div class="form-container">
    <h3>Add New Student</h3>
    <form method="POST">
        <input type="text" name="name" placeholder="Student Name" required>
        <input type="text" name="age" placeholder="Age" required>
        <input type="text" name="class" placeholder="Class" required>
        <button type="submit" name="add" class="btn">Add Student</button>
    </form>
</div>

<!-- Display All Students -->
<h3>All Students</h3>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Class</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($students as $index => $student): ?>
            <tr>
                <td><?= htmlspecialchars($student['name']) ?></td>
                <td><?= htmlspecialchars($student['age']) ?></td>
                <td><?= htmlspecialchars($student['class']) ?></td>
                <td>
                    <!-- Edit Student Form -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="index" value="<?= $index ?>">
                        <input type="text" name="name" placeholder="New Name" required>
                        <input type="text" name="age" placeholder="New Age" required>
                        <input type="text" name="class" placeholder="New Class" required>
                        <button type="submit" name="edit" class="btn btn-edit">Edit</button>
                    </form><br><br>

                    <!-- Delete Student Form -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="index" value="<?= $index ?>">
                        <button type="submit" name="delete" class="btn btn-delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    </div>
   
</body>
</html>