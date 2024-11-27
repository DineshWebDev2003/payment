<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP
$database = "coimbatore_fees";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transactionId = $_POST['transactionId'];
    $studentId = $_POST['studentId'];
    $proofImage = $_FILES['proofImage']['tmp_name'];
    $branch = $_POST['branch'];

    // Validate uploaded file
    if ($proofImage) {
        $proofImageData = addslashes(file_get_contents($proofImage)); // Convert the file to binary

        // Insert data into the database
        $sql = "INSERT INTO submissions (transaction_id, student_id, proof_image)
                VALUES ('$transactionId', '$studentId', '$proofImageData')";

        if ($conn->query($sql) === TRUE) {
            echo "Submission successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Please upload a valid proof image.";
    }

    $conn->close();
}
?>


<form id="paymentForm" action="submit.php" method="POST" enctype="multipart/form-data">

<div>
        <label for="branch">Branch Name:</label>
        <input type="text" id="branch" name="branch" value="coimbatore" readonly>
      </div>
  

<div>
    <label for="transactionId">Transaction ID:</label>
    <input type="text" id="transactionId" name="transactionId" placeholder="Enter Transaction ID" required>
  </div>
  <div>
    <label for="studentId">Student ID:</label>
    <input type="text" id="studentId" name="studentId" placeholder="Enter Student ID" required>
  </div>
  <div>
    <label for="proofImage">Upload Proof of Payment:</label>
    <input type="file" id="proofImage" name="proofImage" accept="image/*" required>
  </div>
  <button type="submit">Submit</button>
</form>

