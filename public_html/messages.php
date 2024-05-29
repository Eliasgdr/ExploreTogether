<?php
// messages.php

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Database connection parameters
include 'php/databaseConnection.php';

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve threads user is following from the database
    $stmt = $conn->prepare("SELECT * FROM threads WHERE threadID IN (SELECT threadID FROM threadSubscriptions WHERE userID = :user_id)");
    $stmt->bindParam(':user_id', $_SESSION['userID']);
    $stmt->execute();
    $threads = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize array to store thread information
    $threadInfo = array();
    // Store thread information
    foreach ($threads as $thread) {
        $lastMessageID = $thread['lastMessageID'];
        $stmt2 = $conn->prepare("SELECT * FROM message WHERE messageID = :lastMessageID");
        $stmt2->bindParam(':lastMessageID', $lastMessageID);
        $stmt2->execute();
        $message = $stmt2->fetch(PDO::FETCH_ASSOC);

        // Check if message exists
        if ($message) {
            // Store thread information in an array
            $threadData = array(
                'threadID' => $thread['threadID'],
                'lastMessage' => $message['body'],
                'lastMessageDate' => $message['Date']
            );
            // Push thread data into the thread info array
            $threadInfo[] = $threadData;
        } else {
            // Handle case where last message does not exist
            $threadData = array(
                'threadID' => $thread['threadID'],
                'lastMessage' => null,
                'lastMessageDate' => null
            );
            $threadInfo[] = $threadData;
        }
    }

} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Message Threads</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .thread {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }
        .thread h2 {
            margin: 0;
        }
        .thread p {
            margin: 5px 0;
        }
        .thread a {
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>

<h1>Your Message Threads</h1>

<?php if (!empty($threadInfo)): ?>
    <?php foreach ($threadInfo as $thread): ?>
        <div class="thread">
            <h2><a href="chat.php?thread_id=<?php echo htmlspecialchars($thread['threadID']); ?>">Thread ID: <?php echo htmlspecialchars($thread['threadID']); ?></a></h2>
            <p><strong>Last Message:</strong> <?php echo htmlspecialchars($thread['lastMessage']); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($thread['lastMessageDate']); ?></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>You are not part of any threads.</p>
<?php endif; ?>

</body>
</html>
