<?php
include './connection.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET['id'];

// Fetch event details
$eventQuery = "SELECT * FROM events WHERE event_id = $id";
$eventResult = mysqli_query($conn, $eventQuery);

if ($eventResult) {
    // Check if the event with the given ID exists
    if (mysqli_num_rows($eventResult) == 0) {
        // Event not found, show alert and redirect
        echo "<script>
            alert('Invalid event ID');
            window.location.href = 'login.php';
            </script>";
        exit; // Add exit to stop further execution
    }

    $eventDetails = mysqli_fetch_assoc($eventResult);

    // Fetch tasks for the event
    $tasksQuery = "SELECT * FROM tasks WHERE event_id = $id";
    $tasksResult = mysqli_query($conn, $tasksQuery);

    $eventDetails['tasks'] = array();

    while ($task = mysqli_fetch_assoc($tasksResult)) {
        // Fetch assignees for each task
        $taskId = $task['task_id'];
        $assigneesQuery = "SELECT * FROM assignees WHERE task_id = $taskId";
        $assigneesResult = mysqli_query($conn, $assigneesQuery);

        $task['assignees'] = array();

        while ($assignee = mysqli_fetch_assoc($assigneesResult)) {
            $task['assignees'][] = $assignee;
        }

        $eventDetails['tasks'][] = $task;
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $eventDetails['event_name']; ?> Details</title>

        <!-- OWN CSS -->
        <link rel="stylesheet" href="style.css">

        <!-- bootstrap CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- jquery CDN -->
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

        <style>
        .nav-link {
            font-size: 0.9375rem;
            font-weight: 600;
            text-transform: capitalize;
            color: var(--secondry-color);
            letter-spacing: 1px;
        }
    </style>
    </head>

    <body>

        <!-- navbar -->
        <?php
        include 'navbar.php';
        ?>

        <!-- display all the details here -->
        <div class="container mt-5">
            <h2>All Event Details</h2>
            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="card-title"><?php echo $eventDetails['event_name']; ?></h3>
                    <p class="card-text"><strong>Description:</strong> <?php echo $eventDetails['event_description']; ?></p>
                    <p class="card-text"><strong>Date:</strong> <?php echo date_format(date_create($eventDetails['event_date']), 'd/m/Y'); ?></p>
                    <p class="card-text"><strong>Time:</strong> <?php echo $eventDetails['event_time']; ?></p>
                    <p class="card-text"><strong>Venue:</strong> <?php echo $eventDetails['venue']; ?></p>
                    <p class="card-text"><strong>Type:</strong> <?php echo $eventDetails['event_type']; ?></p>
                    <p class="card-text"><strong>Created Date:</strong> <?php echo date_format(date_create($eventDetails['event_created_date']), 'd/m/Y H:i:s'); ?></p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <h3 class="card-title">Tasks:</h3>
                    <?php foreach ($eventDetails['tasks'] as $task) : ?>
                        <p class="card-text"><?php echo $task['task_description']; ?></p>
                        <ul>
                            <?php foreach ($task['assignees'] as $assignee) : ?>
                                <li class="card-text"><?php echo $assignee['assignee_email']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endforeach; ?>
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
    </body>

    </html>
<?php
} else {
    // Handle the case where the event ID is not valid
    echo "<script>
        alert('Error fetching event details: " . mysqli_error($conn) . "');
        window.location.href = 'login.php';
        </script>";
    exit; // Add exit to stop further execution
}
?>