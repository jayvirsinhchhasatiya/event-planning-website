<?php
session_start();
// print_r($_SESSION);

if (!isset($_SESSION['client'])) {

    echo '<script>
        alert("Please login to continue");
        window.location.href = "login.php";
        </script>';
    // header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- OWN CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- jquery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>


</head>

<body>

    <!-- navbar -->
    <?php
    include 'navbar.php';
    ?>

    <div class="container mt-5">
        <h2>User Profile</h2>

        <!-- Display User Details -->

        <div class="card mt-3">
            <div class="card-header">
                <h5>User Details</h5>
            </div>
            <div class="card-body">

                <?php

                include './connection.php';

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $email = $_SESSION['client'];
                $selectquery = "select * from users where email='$email'";

                $query = mysqli_query($conn, $selectquery);

                $userDetails = mysqli_fetch_array($query);

                ?>
                <p>Firstname: <?php echo $userDetails['first_name']; ?></p>
                <p>Lastname: <?php echo $userDetails['last_name']; ?></p>
                <p>Username: <?php echo $userDetails['username']; ?></p>
                <p>Email: <?php echo $userDetails['email']; ?></p>
                <p>User Type: <?php echo $userDetails['user_type']; ?></p>
            </div>
        </div>

        <!-- Display Events Table -->
        <?php
        $organizerId = $userDetails['user_id'];

        // Get events for the organizer
        $selectEventsQuery = "SELECT * FROM events WHERE organizer_id='$organizerId'";
        $eventsQuery = mysqli_query($conn, $selectEventsQuery);
        $events = mysqli_fetch_all($eventsQuery, MYSQLI_ASSOC);
        ?>

        <!-- Display Events Table or "No event created" -->
        <div class="card my-5">
            <div class="card-header">
                <h5>Events</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($events)) : ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Event Name</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Venue</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($events as $event) : ?>
                                <tr>
                                    <td><?php echo $event['event_name']; ?></td>
                                    <td><?php echo $event['event_date']; ?></td>
                                    <td><?php echo $event['event_time']; ?></td>
                                    <td><?php echo $event['venue']; ?></td>
                                    <td>
                                        <button class="btn btn-primary" onclick="showEvent(<?php echo $event['event_id']; ?>)">Show</button>
                                        <button class="btn btn-warning" onclick="updateEvent(<?php echo $event['event_id']; ?>)">Update</button>
                                        <button class="btn btn-danger" onclick="deleteEvent(<?php echo $event['event_id']; ?>, '<?php echo $event['event_date']; ?>')">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No event created</p>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- footer-->
    <?php
    include 'footer.php';
    ?>

    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"></script>
    <!-- own js -->
    <script src="navbar.js"></script>
    <script src="deleteEvent.js"></script>
</body>

</html>