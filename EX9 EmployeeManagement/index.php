<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password (usually empty)
$database = "employee_db"; // Your database name

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Insert Employee Details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insertEmployee'])) {
    $employeeName = $_POST['employeeName'];
    $designation = $_POST['designation'];
    $department = $_POST['department'];
    $doj = $_POST['doj'];
    $salary = $_POST['salary'];

    $sql = "INSERT INTO EMPDETAILS (ENAME, DESIG, DEPT, DOJ, SALARY) VALUES ('$employeeName', '$designation', '$department', '$doj', $salary)";
    
    if ($connection->query($sql) === TRUE) {
        echo "<p class='success'>New employee added successfully.</p>";
    } else {
        echo "<p class='error'>Error: " . $connection->error . "</p>";
    }
}

// Function to display employee details
function displayEmployees($connection) {
    $sql = "SELECT * FROM EMPDETAILS";
    $result = $connection->query($sql);
    
    echo "<h2>Employee Details</h2>";
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>Emp ID</th><th>Name</th><th>Designation</th><th>Department</th><th>Date of Joining</th><th>Salary</th></tr>';
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["EMPID"] . "</td><td>" . $row["ENAME"] . "</td><td>" . $row["DESIG"] . "</td><td>" . $row["DEPT"] . "</td><td>" . $row["DOJ"] . "</td><td>" . $row["SALARY"] . "</td></tr>";
        }
        echo '</table>';
    } else {
        echo "<p>No employees found.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9ecef; /* Light grey background */
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px; /* Max width of the content */
            margin: auto;
            background: #ffffff; /* White background for the container */
            padding: 20px; /* Inner padding */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        h1 {
            text-align: center; /* Centered heading */
            color: #343a40; /* Dark text color */
        }

        form {
            margin-bottom: 20px; /* Space below the form */
            padding: 20px;
            background-color: #f8f9fa; /* Light background for the form */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        .form-group {
            margin-bottom: 15px; /* Space between form fields */
        }

        label {
            display: block; /* Labels on new lines */
            margin-bottom: 5px; /* Space below the label */
            font-weight: bold; /* Bold labels */
            color: #495057; /* Dark label color */
        }

        input[type="text"],
        input[type="date"],
        input[type="number"] {
            width: 100%; /* Full width inputs */
            padding: 10px; /* Inner padding */
            border: 1px solid #ced4da; /* Border color */
            border-radius: 5px; /* Rounded corners */
            transition: border-color 0.3s; /* Transition for border color */
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="number"]:focus {
            border-color: #007bff; /* Change border color on focus */
            outline: none; /* Remove default outline */
        }

        button {
            background-color: #007bff; /* Blue button color */
            color: white; /* White text color */
            padding: 10px 15px; /* Inner padding */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor */
            font-size: 16px; /* Font size */
            transition: background-color 0.3s; /* Transition for background color */
        }

        button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        table {
            width: 100%; /* Full width table */
            border-collapse: collapse; /* Collapse borders */
            margin-top: 20px; /* Space above table */
        }

        th, td {
            padding: 12px; /* Inner padding for cells */
            text-align: left; /* Left align text */
            border-bottom: 1px solid #dee2e6; /* Bottom border */
        }

        th {
            background-color: #007bff; /* Header background color */
            color: white; /* Header text color */
        }

        tr:hover {
            background-color: #f1f1f1; /* Highlight row on hover */
        }

        .success {
            color: green; /* Green text for success messages */
            margin-top: 20px; /* Space above success message */
        }

        .error {
            color: red; /* Red text for error messages */
            margin-top: 20px; /* Space above error message */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Employee Management System</h1>

        <!-- Form to insert employee -->
        <form action="" method="POST">
            <div class="form-group">
                <label for="employeeName">Employee Name:</label>
                <input type="text" name="employeeName" required>
            </div>
            <div class="form-group">
                <label for="designation">Designation:</label>
                <input type="text" name="designation" required>
            </div>
            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" name="department" required>
            </div>
            <div class="form-group">
                <label for="doj">Date of Joining:</label>
                <input type="date" name="doj" required>
            </div>
            <div class="form-group">
                <label for="salary">Salary:</label>
                <input type="number" name="salary" required>
            </div>
            <button type="submit" name="insertEmployee">Add Employee</button>
        </form>

        <!-- Display employee details -->
        <?php displayEmployees($connection); ?>

    </div>
</body>
</html>
