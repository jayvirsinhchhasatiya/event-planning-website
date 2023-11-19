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
    <title>Event Planning</title>

    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- OWN CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- navbar -->
    <?php
    include 'navbar.php';
    ?>

    <!-- section-1 top-banner -->
    <section id="home">
        <div class="container-fluid px-0 top-banner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <h1>Elevate your events with seamless organizer tools and attendee experiences.</h1>
                        <div class="mt-4">
                            <a href="createEvent.php" class="main-btn">Create now <i class="fa-solid fa-calendar-check ps-3"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- section-2 upcoming events -->
    <section id="upcoming-events">
        <div class="upcoming-events-section wrapper">
            <div class="container">
                <h1>Upcoming Events</h1>

                <?php
                include './connection.php';

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $query = "SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC, event_time ASC";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    $count = 0;

                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($count % 3 == 0) {
                            echo '<div class="row">';
                        }
                ?>
                        <div class="col-lg-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="card-title"><?php echo $row['event_name']; ?></h2>
                                    <p class="card-text"><?php echo $row['event_description']; ?></p>
                                    <p class="card-text">Date: <?php echo $row['event_date']; ?></p>
                                    <p class="card-text">Time: <?php echo $row['event_time']; ?></p>
                                    <p class="card-text">Venue: <?php echo $row['venue']; ?></p>
                                </div>
                            </div>
                        </div>
                <?php
                        if ($count % 3 == 2) {
                            echo '</div>';
                        }

                        $count++;
                    }

                    if ($count % 3 != 0) {
                        echo '</div>';
                    }

                    mysqli_free_result($result);
                } else {
                    echo "Error: " . mysqli_error($conn);
                }

                mysqli_close($conn);
                ?>
            </div>

        </div>
    </section>



    <!-- section-9 footer-->
    <?php
    include 'footer.php';
    ?>

    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"></script>
    <!-- own js -->
    <script src="index.js"></script>
</body>

</html>