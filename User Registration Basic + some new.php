<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form with CSS</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
    }
    .form-container {
      margin: 50px auto;
      padding: 30px;
      border: 1px solid #ced4da;
      border-radius: 10px;
      background-color: #ffffff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 600px;
    }
    .form-container h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #343a40;
    }
    label {
      font-weight: bold;
    }
    .form-check-label {
      padding-left: 25px;
      position: relative;
      cursor: pointer;
    }
    .form-check-label:before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      width: 20px;
      height: 20px;
      border: 1px solid #ced4da;
      border-radius: 3px;
      background-color: #ffffff;
    }
    .form-check-input:checked ~ .form-check-label:before {
      background-color: #007bff;
      border-color: #007bff;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
    .form-control:focus {
      border-color: #80bdff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
  </style>
</head>
<body>

  <div class="container form-container">
    <h1>Registration Form</h1>
    <form method="post">
      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label for="validationDefault01">First name</label>
          <input type="text" class="form-control" id="validationDefault01" name="FirstN" placeholder="First name" value="Mark" required>
        </div>
        <div class="col-md-4 mb-3">
          <label for="validationDefault02">Last name</label>
          <input type="text" class="form-control" id="validationDefault02" name="LastN" placeholder="Last name" value="Otto" required>
        </div>
        <div class="col-md-4 mb-3">
          <label for="validationDefaultUsername">Username</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroupPrepend2">@</span>
            </div>
            <input type="text" class="form-control" id="validationDefaultUsername" name="usern" placeholder="Username" aria-describedby="inputGroupPrepend2" required>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label for="validationDefault03">City</label>
          <input type="text" class="form-control" id="validationDefault03" name="city" placeholder="City" required>
        </div>
        <div class="col-md-3 mb-3">
          <label for="validationDefault04">State</label>
          <input type="text" class="form-control" id="validationDefault04" name="state" placeholder="State" required>
        </div>
        <div class="col-md-3 mb-3">
          <label for="validationDefault05">Zip</label>
          <input type="text" class="form-control" id="validationDefault05" name="zip" placeholder="Zip" required>
        </div>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
          <label class="form-check-label" for="invalidCheck2">
            Agree to terms and conditions
          </label>
        </div>
      </div>
      <button class="btn btn-primary" type="submit">Submit form</button>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $fn = filter_var($_POST['FirstN'], FILTER_SANITIZE_STRING);
      $ln = filter_var($_POST['LastN'], FILTER_SANITIZE_STRING);
      $usern = filter_var($_POST['usern'], FILTER_SANITIZE_STRING);
      $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
      $state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
      $zip = filter_var($_POST['zip'], FILTER_SANITIZE_STRING);

      $servername = "localhost";
      $username = "root";
      $password = "";
      $database = "manthan4";

      $conn = new mysqli($servername, $username, $password, $database);

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Check if the username already exists
      $stmt = $conn->prepare("SELECT UserName FROM `data` WHERE UserName = ?");
      $stmt->bind_param("s", $usern);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows > 0) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Username already exists. Please choose a different username.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
      } else {
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO `data` (`FirstName`, `LastName`, `UserName`, `City`, `State`, `Zip`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fn, $ln, $usern, $city, $state, $zip);

        if ($stmt->execute()) {
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> Your information has been submitted successfully!
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
        } else {
          echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error!</strong> There was a problem submitting your information.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>';
        }
      }

      $stmt->close();
      $conn->close();
    }
    ?>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
