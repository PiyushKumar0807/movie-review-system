<?php
// Database connection parameters
$servername = "localhost";
$username = "root";  // your database username
$password = "";      // your database password
$dbname = "mrs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize a variable to store the search term
$searchTerm = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = $_POST["search"];
}

// SQL query to select data from movies table, with filtering
$sql = "SELECT * FROM movies";
if (!empty($searchTerm)) {
    $sql .= " WHERE movie_name LIKE '%" . $conn->real_escape_string($searchTerm) . "%'";
}
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Movie Review System</title>
    
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h2>Movie Review Records</h2>
    
    <!-- Search form -->
    <form method="post" action="">
        <label for="search">Search by Movie Name:</label>
        <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit">Search</button>
    </form>

    <?php
    if ($result->num_rows > 0) {
        // Output data in table format
        echo "<table>
                <tr>
                    <th>movie_id</th>
                    <th>movie_name</th>
                    <th>director_name</th>
                    <th>review</th>
                    <th>rating</th>
                    <th>image_path</th>
                    <th>release_year</th>
                    <th>duration</th>
                </tr>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["movie_id"] . "</td>
                    <td>" . $row["movie_name"] . "</td>
                    <td>" . $row["director_name"] . "</td>
                    <td>" . $row["review"] . "</td>
                    <td>" . $row["rating"] . "</td>
                    <td>" . $row["image_path"] . "</td>
                    <td>" . $row["release_year"] . "</td>
                    <td>" . $row["duration"] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No records found";
    }
    
    // Close connection
    $conn->close();
    ?>
    
</body>
</html>
