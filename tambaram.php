<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP
$database = "submissions";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $branch = $_POST['branch']; // Branch value from the form
    $transactionId = $_POST['transactionId'];
    $studentId = $_POST['studentId'];
    $proofImage = $_FILES['proofImage']['tmp_name'];

    // Validate uploaded file
    if ($proofImage) {
        $proofImageData = addslashes(file_get_contents($proofImage)); // Convert the file to binary

        // Insert data into the database
        $sql = "INSERT INTO submissions (transaction_id, student_id, branch, proof_image)
                VALUES ('$transactionId', '$studentId', '$branch', '$proofImageData')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Submission successful!'); window.location.href='thank-you.html';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Please upload a valid proof image.";
    }
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coimbatore - Fees Payment</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Pay Fees - tambaram</h1>
    <div class="qr-section">
      <h3>Scan the QR Code or Use UPI ID</h3>
      <img id="qrCode" src="coimbatore-qr.png" alt="QR Code" style="max-width: 200px;">
      <p><strong>UPI ID:</strong> coimbatore@upi</p>
      <button onclick="copyUPI()">Copy UPI ID</button>
      <button onclick="downloadQRCode()">Download QR Code</button>
    </div>

    <form id="paymentForm" action="" method="POST" enctype="multipart/form-data">
      <!-- Read-only Branch Name -->
      <div>
        <label for="branch">Branch Name:</label>
        <input type="text" id="branch" value="coimbatore" readonly>
        <input type="hidden" name="branch" value="coimbatore">
      </div>

      <!-- Transaction ID Field -->
      <div>
        <label for="transactionId">Transaction ID:</label>
        <input type="text" id="transactionId" name="transactionId" placeholder="Enter Transaction ID" required>
      </div>

      <!-- Student ID Field -->
      <div>
        <label for="studentId">Student ID:</label>
        <input type="text" id="studentId" name="studentId" placeholder="Enter Student ID" required>
      </div>

      <!-- Proof Image Upload -->
      <div>
        <label for="proofImage">Upload Proof of Payment:</label>
        <input type="file" id="proofImage" name="proofImage" accept="image/*" required>
      </div>

      <!-- Submit Button -->
      <button type="submit">Submit</button>
    </form>
  </div>

  <script>
    // Copy UPI ID to clipboard
    function copyUPI() {
      const upiId = "coimbatore@upi";
      navigator.clipboard.writeText(upiId).then(() => {
        alert("UPI ID copied to clipboard!");
      });
    }

    // Download the QR code
    function downloadQRCode() {
      const qrCode = document.getElementById("qrCode").src;
      const link = document.createElement("a");
      link.href = qrCode;
      link.download = "coimbatore-qr.png";
      link.click();
    }
  </script>
</body>
</html>
