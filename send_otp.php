 <?php
session_start();

// 1. Database connection
$conn = new mysqli('localhost', 'root', '', 'easybuy_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Form data receive karo POST se
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // 3. Check karo user pehle se exist karta hai ya nahi
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR mobile = ?");
    $stmt->bind_param("ss", $email, $mobile);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "User already registered. Login karo.";
        exit;
    }

    // 4. OTP generate karo
    $otp = rand(100000, 999999);
    $expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));

    // 5. OTP ko otp_verification table mein insert karo
    $stmt = $conn->prepare("INSERT INTO otp_verification (mobile, otp_code, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $mobile, $otp, $expiry);
    $stmt->execute();

    // 6. Signup data ko session mein temporarily store karo
    $_SESSION['signup_data'] = [
        'fullname' => $fullname,
        'email' => $email,
        'mobile' => $mobile,
        'password' => $password
    ];

    // 7. OTP ko screen pe dikhana (testing ke liye)
    echo "<h2>OTP sent to your mobile number: $mobile</h2>";
    echo "<p>Your OTP is: <strong>$otp</strong></p>";

    // 8. OTP verify karne ke liye form dikhao
    echo '
    <form method="POST" action="verify_otp.php">
      <label>Enter OTP:</label>
      <input type="text" name="otp" pattern="[0-9]{6}" required />
      <button type="submit">Verify OTP</button>
    </form>
    ';
} else {
    echo "Invalid request method.";
}
?>
