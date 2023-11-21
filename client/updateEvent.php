<?php
session_start();
// print_r($_SESSION);

if (!isset($_SESSION['client'])) {
    echo '<script>
        alert("Please login to continue");
        window.location.href = "login.php";
        </script>';
}

include './connection.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET['id'];
$selectquery = "SELECT * FROM `events` WHERE event_id='$id'";
$showdata = mysqli_query($conn, $selectquery);

$arrdata = mysqli_fetch_array($showdata);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event</title>

    <!-- OWN CSS -->
    <link rel="stylesheet" type='text/css' media='screen' href="style.css">

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
    include './navbar.php';
    ?>

    <div class="container">
        <div class="registration p-5 my-5">
            <h3 class="mb-3">Update Event</h3>
            <form class="row g-3" id="eventForm">
                <!-- Existing event ID (hidden field) -->
                <input type="hidden" name="eventId" value="<?php echo $arrdata['event_id']; ?>">

                <!-- Event name -->
                <div class="col-md-6">
                    <label for="eventName" class="form-label">Event Name</label>
                    <input type="text" class="form-control" id="eventName" name="eventName" value="<?php echo $arrdata['event_name']; ?>" placeholder="Enter Event Name" required>
                    <div id="eventName-valid" class=""></div>
                </div>

                <!-- Event type -->
                <div class="col-md-6">
                    <label for="eventType" class="form-label">Event Type</label>
                    <select class="form-select" id="eventType" name="eventType" required>
                        <option selected="" value="Default">(Please select event type)</option>
                        <option value="Non-Competitive" <?php echo ($arrdata['event_type'] == 'Non-Competitive') ? 'selected' : ''; ?>>Non-Competitive</option>
                        <option value="Competitive" <?php echo ($arrdata['event_type'] == 'Competitive') ? 'selected' : ''; ?>>Competitive</option>
                    </select>
                    <div id="eventType-valid" class=""></div>
                </div>

                <!-- Event description -->
                <div class="col-12 d-grid ">
                    <label for="eventDescription" class="form-label">Event Description</label>
                    <textarea class="form-control" id="eventDescription" name="eventDescription" placeholder="Enter Event Description" required><?php echo $arrdata['event_description']; ?></textarea>
                    <div id="eventDescription-valid" class=""></div>
                </div>

                <!-- Event date -->
                <div class="col-md-6">
                    <label for="eventDate" class="form-label">Event Date</label>
                    <input type="date" class="form-control" id="eventDate" name="eventDate" value="<?php echo $arrdata['event_date']; ?>" required>
                    <div id="eventDate-valid" class=""></div>
                </div>

                <!-- Event time -->
                <div class="col-md-6">
                    <label for="eventTime" class="form-label">Event Time</label>
                    <input type="time" class="form-control" id="eventTime" name="eventTime" value="<?php echo $arrdata['event_time']; ?>" required>
                    <div id="eventTime-valid" class=""></div>
                </div>

                <!-- Venue -->
                <div class="col-md-6">
                    <label for="venue" class="form-label">Venue</label>
                    <input type="text" class="form-control" id="venue" name="venue" value="<?php echo $arrdata['venue']; ?>" placeholder="Enter Venue" required>
                    <div id="venue-valid" class=""></div>
                </div>

                <!-- Task section -->
                <div class="col-12 d-grid">
                    <h3 class="mb-3">Task Assignment</h3>
                    <div id="tasks-container">
                        <?php
                        // Fetch tasks for the event
                        $tasksQuery = "SELECT * FROM tasks WHERE event_id = $id";
                        $tasksResult = mysqli_query($conn, $tasksQuery);

                        while ($task = mysqli_fetch_assoc($tasksResult)) :
                            // Fetch assignees for each task
                            $taskId = $task['task_id'];
                            $assigneesQuery = "SELECT assignee_email FROM assignees WHERE task_id = $taskId";
                            $assigneesResult = mysqli_query($conn, $assigneesQuery);

                            $assigneeEmails = array();
                            while ($assignee = mysqli_fetch_assoc($assigneesResult)) {
                                $assigneeEmails[] = $assignee['assignee_email'];
                            }
                        ?>
                            <div class="task-pair">
                                <div class="task">
                                    <label for="task_description_<?php echo $task['task_id']; ?>" class="form-label">Task Description</label>
                                    <input type="text" class="form-control task-description" id="task_description_<?php echo $task['task_id']; ?>" name="tasks[<?php echo $task['task_id']; ?>][description]" value="<?php echo $task['task_description']; ?>" placeholder="Enter task description">
                                </div>
                                <div class="assignee">
                                    <label for="assignees_<?php echo $task['task_id']; ?>" class="form-label mt-2">Assignees (comma-separated emails)</label>
                                    <input type="text" class="form-control assignee-emails" id="assignees_<?php echo $task['task_id']; ?>" name="tasks[<?php echo $task['task_id']; ?>][assignees]" value="<?php echo implode(',', $assigneeEmails); ?>" placeholder="Enter assignee emails">
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <button type="button" class="btn btn-primary my-3" id="addTask">Add Task</button>
                </div>

                <!-- Submit button -->
                <div class="col-12 d-grid ">
                    <button type="submit" id="updateEvent" class="btn btn-primary">Update Event</button>
                </div>
            </form>
        </div>
    </div>

    <!-- footer-->
    <?php
    include './footer.php';
    ?>

    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"></script>
    <!-- own js -->
    <script src="./updateEvent.js"></script>
    <!-- own js -->
    <script src="./navbar.js"></script>

</body>

</html>