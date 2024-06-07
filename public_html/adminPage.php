<?php
include 'php/databaseConnection.php';

session_start();

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Fetch all the reports from the table
$sql = "SELECT * FROM reports";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>Reports</h2>

<!-- Step 3: Display the reports in a tabular format -->
<table>
    <tr>
        <th>Report ID</th>
        <th>From User ID</th>
        <th>Thread ID</th>
        <th>Content</th>
    </tr>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src='javascript/adminDatabaseRequest.js'></script>
    <script>
        function successCallback(response) {
            // Handle success here, for example, show a success message
            console.log("Request successful:", response);
            window.location.href="adminPage.php";
        }

        function errorCallback(error) {
            // Handle error here, for example, show an error message
            console.error("Request failed:", error);
        }
    </script>
    <?php
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["reportID"] . "</td>";
            echo "<td>" . $row["fromUserID"] . "</td>";
            //echo "<td>" . $row["aboutUserID"] . "</td>";
            echo "<td>" . $row["threadID"] . "</td>";
            //echo "<td>" . $row["messageID"] . "</td>";
            echo "<td>" . $row["content"] . "</td>";
            //echo "<td>" . $row["isDone"] . "</td>";
            // Add buttons for each action
            echo "<td>";
            echo "<button onclick=\"deleteReport(" . $row["reportID"] . ", successCallback, errorCallback)\">Delete Report</button>";
            echo "<button onclick=\"window.location.href='chat.php?thread_id=". $row["threadID"] ."'\">See thread</button>";
            //echo "<button onclick=\"deleteMessageAdmin(" . $row["messageID"] . ", successCallback, errorCallback)\">Delete Message</button>";
            //echo "<button onclick=\"AdmindeleteAccount(" . $row["aboutUserID"] . ", successCallback, errorCallback)\">Delete Account</button>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "0 reports";
    }
    ?>
</table>

<?php
// Close connection
$conn->close();
?>

</body>
</html>
