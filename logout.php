<?php
$conn = new mysqli("localhost", "root", "", "website_db");
$res = $conn->query("SELECT * FROM comments WHERE status='approved' ORDER BY created_at DESC");

echo "<h3>Comments:</h3>";
while ($row = $res->fetch_assoc()) {
  $name = htmlspecialchars($row['name']);
  $comment = nl2br(htmlspecialchars($row['comment']));
  $time = $row['created_at'];
  echo "<div style='margin-bottom:10px;border:1px solid #ccc;padding:8px;'>
          <strong>$name</strong> <small>($time)</small><br>
          <p>$comment</p>
        </div>";
}
$conn->close();
?>