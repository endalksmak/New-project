<?php
// Basic admin login (for demo)
session_start();
if (!isset($_SESSION['admin'])) {
  if (isset($_POST['password'])) {
    if ($_POST['password'] === 'admin123') { // change this password
      $_SESSION['admin'] = true;
      header("Location: admin_comments.php");
      exit;
    } else {
      echo "Wrong password!";
    }
  }
  echo '<form method="POST"><input type="password" name="password" placeholder="Admin Password"><button>Login</button></form>';
  exit;
}

// Database connection
$conn = new mysqli("localhost", "root", "", "website_db");
if ($conn->connect_error) die("DB error");

// Approve or delete comment
if (isset($_GET['approve'])) {
  $id = intval($_GET['approve']);
  $conn->query("UPDATE comments SET status='approved' WHERE id=$id");
}
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM comments WHERE id=$id");
}

// Fetch comments
$result = $conn->query("SELECT * FROM comments ORDER BY created_at DESC");

echo "<h1>All Comments</h1>";
echo "<a href='logout.php'>Logout</a><hr>";

while ($row = $result->fetch_assoc()) {
  $id = $row['id'];
  $name = htmlspecialchars($row['name']);
  $email = htmlspecialchars($row['email']);
  $comment = nl2br(htmlspecialchars($row['comment']));
  $status = $row['status'];
  $time = $row['created_at'];

  echo "<div style='border:1px solid #ddd;padding:10px;margin:8px;'>
          <strong>$name</strong> ($email) — <small>$time</small><br>
          <p>$comment</p>
          <p>Status: <b>$status</b></p>";

  if ($status === 'pending') {
    echo "<a href='?approve=$id'>✅ Approve</a> | ";
  }
  echo "<a href='?delete=$id' onclick='return confirm(\"Delete comment?\")'>🗑 Delete</a>";
  echo "</div>";
}
$conn->close();
?>