<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
// Database connection
$conn = new mysqli("localhost", "root", "mysql", "website_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $comment = $_POST["comment"];

    // Insert data into database
    $sql = "INSERT INTO comments (name, comment) VALUES ('$name', '$comment')";

    if ($conn->query($sql) === TRUE) {
        // ✅ Success message in HTML
        echo "
        <html>
        <head>
            <title>Comment Submitted</title>
            <style>
                body {
                    font-family: Arial;
                    background: #f5f5f5;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                }
                .box {
                    background: white;
                    padding: 30px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    text-align: center;
                }
                a {
                    color: white;
                    background: #007BFF;
                    padding: 10px 20px;
                    border-radius: 5px;
                    text-decoration: none;
                }
                a:hover {
                    background: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class='box'>
                <h2>✅ Thank you, $name!</h2>
                <p>Your comment was successfully submitted.</p>
                <a href='comments.html'>Go Back</a>
            </div>
        </body>
        </html>
        ";
    } else {
        echo "❌ Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>