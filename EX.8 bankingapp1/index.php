<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password (usually empty)
$database = "b"; // Your database name

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Function to display customer information
function displayCustomers($connection) {
    $sql = "SELECT * FROM CUSTOMER";
    $result = $connection->query($sql);
    
    echo "<h2>Customer Information</h2>";
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>CID</th><th>Name</th></tr>'; // Table header
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["CID"] . "</td><td>" . $row["CNAME"] . "</td></tr>";
        }
        echo '</table>';
    } else {
        echo "<p>No customers found.</p>";
    }
}

// Function to display account information
function displayAccounts($connection) {
    $sql = "SELECT * FROM ACCOUNT";
    $result = $connection->query($sql);
    
    echo "<h2>Account Information</h2>";
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>Account No</th><th>Type</th><th>Balance</th></tr>'; // Table header
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["ANO"] . "</td><td>" . $row["ATYPE"] . "</td><td>" . $row["BALANCE"] . "</td></tr>";
        }
        echo '</table>';
    } else {
        echo "<p>No accounts found.</p>";
    }
}

// Insert Customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insertCustomer'])) {
    $customerName = $_POST['customerName'];
    
    $sql = "INSERT INTO CUSTOMER (CNAME) VALUES ('$customerName')";
    if ($connection->query($sql) === TRUE) {
        echo "<p class='success'>New customer added successfully.</p>";
    } else {
        echo "<p class='error'>Error: " . $connection->error . "</p>";
    }
}

// Insert Account
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insertAccount'])) {
    $accountType = $_POST['accountType'];
    $balance = $_POST['balance'];
    $customerId = $_POST['customerId'];

    // Check if the customer exists
    $customerCheck = "SELECT * FROM CUSTOMER WHERE CID = $customerId";
    $customerResult = $connection->query($customerCheck);
    
    if ($customerResult && $customerResult->num_rows > 0) {
        // Proceed to insert account
        $sql = "INSERT INTO ACCOUNT (ATYPE, BALANCE, CID) VALUES ('$accountType', $balance, $customerId)";
        if ($connection->query($sql) === TRUE) {
            echo "<p class='success'>New account added successfully.</p>";
        } else {
            echo "<p class='error'>Error: " . $connection->error . "</p>";
        }
    } else {
        echo "<p class='error'>Error: No customer found with CID $customerId. Please add the customer first.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking Application</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6; /* Light greenish background */
            color: #2c3e50; /* Dark blue-gray text color */
        }

        /* Container Styles */
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff; /* White background for content */
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Header Styles */
        h1 {
            text-align: center;
            color: #16a085; /* Teal color for headings */
            margin-bottom: 20px;
            font-size: 2.5em;
            font-weight: 700;
        }

        h2 {
            color: #34495e; /* Darker blue-gray */
            border-bottom: 2px solid #16a085;
            padding-bottom: 10px;
            font-size: 1.8em;
        }

        /* Form Styles */
        form {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #bdc3c7;
            border-radius: 8px;
            background: #ecf0f1; /* Light gray background for forms */
        }

        /* Label Styles */
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: 600; /* Bold text */
            color: #2980b9; /* Blue color for labels */
        }

        /* Input Styles */
        input[type="text"],
        input[type="number"],
        input[type="submit"] {
            width: calc(100% - 22px); /* Full width minus padding and border */
            padding: 12px;
            margin: 5px 0;
            border: 1px solid #bdc3c7; /* Light border for inputs */
            border-radius: 5px;
            box-sizing: border-box;
            transition: border 0.3s; /* Transition effect for border */
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #16a085; /* Change border color on focus */
            outline: none; /* Remove outline */
        }

        /* Button Styles */
        input[type="submit"] {
            background-color: #16a085; /* Teal background for buttons */
            color: white; /* White text color */
            border: none; /* Remove border */
            cursor: pointer; /* Pointer cursor for buttons */
            font-weight: bold; /* Bold text */
            transition: background-color 0.3s; /* Transition effect for background */
            padding: 14px;
            border-radius: 5px;
            font-size: 1.1em; /* Slightly larger font for buttons */
        }

        input[type="submit"]:hover {
            background-color: #1abc9c; /* Darker teal on hover */
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #bdc3c7;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #16a085; /* Teal background for header */
            color: white; /* White text for header */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray for even rows */
        }

        /* Message Styles */
        .success {
            color: #27ae60; /* Green for success messages */
            margin-top: 20px;
            font-weight: bold; /* Bold text */
        }

        .error {
            color: #e74c3c; /* Red for error messages */
            margin-top: 20px;
            font-weight: bold; /* Bold text */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Banking Application</h1>

        <!-- Form to insert customer -->
        <h2>Add Customer</h2>
        <form method="POST" action="">
            <label for="customerName">Customer Name:</label>
            <input type="text" name="customerName" required>
            <input type="submit" name="insertCustomer" value="Add Customer">
        </form>

        <!-- Form to insert account -->
        <h2>Add Account</h2>
        <form method="POST" action="">
            <label for="accountType">Account Type (S for Savings, C for Current):</label>
            <input type="text" name="accountType" required>
            <label for="balance">Balance:</label>
            <input type="number" step="0.01" name="balance" required>
            <label for="customerId">Customer ID:</label>
            <input type="number" name="customerId" required>
            <input type="submit" name="insertAccount" value="Add Account">
        </form>

        <!-- Display customer and account information -->
        <?php
        displayCustomers($connection);
        displayAccounts($connection);
        ?>
    </div>
</body>
</html>

<?php
// Close the database connection
$connection->close();
?>
