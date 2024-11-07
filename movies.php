<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Review System</title>
    <link rel="stylesheet" href="movies.css">
</head>
<body>

    <header>
        <div class="logo">
            <img src="logoo.jpg" height="50" >
        </div>
        <nav>
            <ul>
                <li><a href="mrs.php">Home</a></li>
                <li><a href="#">Movies</a></li>
                <li><a href="#">Top Rated</a></li>
                <li><a href="#">Reviews</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </nav>
        <?php
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
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

        <!-- Search form -->
        <form method="post" action="">
            <label for="search">Search by Movie Name:</label>
            <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit">Search</button>
        </form>
        </header>
        <?php
        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>movie_id</th>
                        <th>movie_name</th>
                        <th>director_name</th>
                        <th>review</th>
                        <th>rating</th>
                        <th>release_year</th>
                        <th>duration</th>
                    </tr>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["movie_id"] . "</td>
                        <td>" . $row["movie_name"] . "</td>
                        <td>" . $row["director_name"] . "</td>
                        <td>" . $row["review"] . "</td>
                        <td>" . $row["rating"] . "</td>
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
    </section>