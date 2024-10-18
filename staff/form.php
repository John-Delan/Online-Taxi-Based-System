<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        h2, h3 {
            color: #333;
            margin-bottom: 10px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input, select, textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #3e8e41;
        }
        .form-section {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <h2>Booking Form</h2>
    <form action="submit_booking.php" method="POST">
        <!-- Client Information -->
        <div class="form-section">
            <h3>Client Information</h3>
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required><br>
            <label for="middlename">Middle Name:</label>
            <input type="text" id="middlename" name="middlename"><br>
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required><br>
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select><br>
            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" required><br>
            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br>
        </div>

        <!-- Driver Selection -->
        <div class="form-section">
            <h3>Select Driver</h3>
            <label for="driver">Driver:</label>
            <select id="driver" name="driver" required>
                <?php
                    // Fetch available drivers with status = 1 from the database
                    $conn = new mysqli('localhost', 'root', '', 'cbsphp');
                    $query = "SELECT id, cab_driver FROM cab_list WHERE status = 1";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row['id']."'>".$row['cab_driver']."</option>";
                        }
                    } else {
                        echo "<option value=''>No drivers available</option>";
                    }
                    $conn->close();
                ?>
            </select><br>
        </div>

        <!-- Booking Information -->
        <div class="form-section">
            <h3>Booking Information</h3>
            <label for="pickup_zone">Pickup Zone:</label>
            <textarea id="pickup_zone" name="pickup_zone" required></textarea><br>

            <label for="drop_zone">Drop Zone:</label>
            <textarea id="drop_zone" name="drop_zone" required></textarea><br>

            <label for="cost">Cost:</label>
            <input type="number" id="cost" name="cost" required><br>

            <input type="submit" value="Submit Booking">
        </div>
    </form>
</body>
</html>