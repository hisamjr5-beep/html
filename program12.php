
<?php
$errors = [];
$success = "";
$name = $email = $phone = $dob = $qualification = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $dob = $_POST["dob"] ?? "";
    $qualification = $_POST["qualification"] ?? "";
    $pass = $_POST["password"] ?? "";
    $confirm = $_POST["confirm"] ?? "";
    if (!preg_match("/^[a-zA-Z ]{2,100}$/", $name))
        $errors["name"] = "Enter a valid name.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors["email"] = "Enter a valid email.";
    if (!preg_match("/^[0-9]{10}$/", $phone))
        $errors["phone"] = "Enter exactly 10 digits.";
    if (!$dob || $dob > date("Y-m-d"))
        $errors["dob"] = "Enter a valid date of birth.";
    if (!in_array($qualification, ["SSLC", "Plus Two", "Diploma", "Degree", "Postgraduate"]))
        $errors["qualification"] = "Select your qualification.";
    if (strlen($pass) < 8 ||
        !preg_match("/[A-Z]/", $pass) ||
        !preg_match("/[a-z]/", $pass) ||
        !preg_match("/[0-9]/", $pass) ||
        !preg_match("/[^a-zA-Z0-9]/", $pass))
        $errors["password"] = "Use 8+ characters with uppercase, lowercase, number and symbol.";
    if (empty($confirm) || $pass !== $confirm)
        $errors["confirm"] = "Passwords do not match.";
    if (!$errors) {
        $success = "Registration completed successfully!";
        $name = $email = $phone = $dob = $qualification = "";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Registration Form</title>
<style>
* { box-sizing: border-box; }
body {
    font-family: Arial;
    background: #99cc99;
    margin: 0;
    padding: 35px 15px;
}
.container {
    max-width: 420px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 14px;
    box-shadow: 0 5px 25px #0002;
}
h2 {
    text-align: center;
    color: #26364a;
    margin-bottom: 25px;
}
label {
    display: block;
    margin: 14px 0 7px;
    font-weight: bold;
    color: #444;
}
input, select {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    outline: none;
    background: white;
}
input:focus, select:focus { border-color: #007bff; }
button {
    width: 100%;
    padding: 13px;
    margin-top: 22px;
    border: none;
    border-radius: 6px;
    background: #007bff;
    color: white;
    font-size: 16px;
    cursor: pointer;
}
button:hover { background: green; }
.error { color: red; font-size: 13px; }
.success {
    color: green;
    text-align: center;
    font-weight: bold;
}
</style>
</head>
<body>
<div class="container">
<h2>Registration Form</h2>
<?php if ($success): ?>
<p class="success"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>
<form method="POST">
<?php
$fields = [
    "name" => "Full Name",
    "email" => "Email Address",
    "phone" => "Phone Number",
    "dob" => "Date of Birth"
];

foreach ($fields as $key => $label):
?>
<label><?= $label ?></label>
<input type="<?= $key == "dob" ? "date" : ($key == "email" ? "email" : "text") ?>"
name="<?= $key ?>"
value="<?= htmlspecialchars($$key) ?>"
required>
<?php if (isset($errors[$key])): ?>
<p class="error"><?= htmlspecialchars($errors[$key]) ?></p>
<?php endif; ?>
<?php endforeach; ?>
<label>Qualification</label>
<select name="qualification" required>
<option value="">Select Qualification</option>
<?php foreach (["SSLC", "Plus Two", "Diploma", "Degree", "Postgraduate"] as $q): ?>
<option value="<?= $q ?>" <?= $qualification == $q ? "selected" : "" ?>><?= $q ?></option>
<?php endforeach; ?>
</select>
<?php if (isset($errors["qualification"])): ?>
<p class="error"><?= htmlspecialchars($errors["qualification"]) ?></p>
<?php endif; ?>
<?php foreach (["password" => "Password", "confirm" => "Confirm Password"] as $key => $label): ?>
<label><?= $label ?></label>
<input type="password" name="<?= $key ?>" required>
<?php if (isset($errors[$key])): ?>
<p class="error"><?= htmlspecialchars($errors[$key]) ?></p>
<?php endif; ?>
<?php endforeach; ?>
<button type="submit">Register</button>
</form>
</div>
</body>
</html>

