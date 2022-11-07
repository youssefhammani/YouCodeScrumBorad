<?php
    //INCLUDE DATABASE FILE
    include('database.php');
    //SESSSION IS A WAY TO STORE DATA TO BE USED ACROSS MULTIPLE PAGES
    session_start();

    //ROUTING
    if(isset($_POST['save']))        saveTask();
    if(isset($_POST['update']))      updateTask();
    if(isset($_POST['delete']))      deleteTask();


    function checkIcon($status)
    {
        if ($status == 1)
            $icon_is = "fa-regular fa-circle-question";
        else if ($status == 2)
            $icon_is = "fas fa-circle-notch fa-spin";
        else if ($status == 3)
            $icon_is = "fa-regular fa-circle-check";
        return ($icon_is);
    }

    function getTasks($status)
    {
        global $link;
        
        //SQL SELECT
        $query  = "SELECT priorities.name AS prior, types.name AS type, tasks.*
            FROM `tasks`
            INNER JOIN priorities ON tasks.priority_id = priorities.id
            INNER JOIN types ON tasks.type_id = types.id";

        // CODE HERE
        if($result = mysqli_query($link, $query))
        {
            while ($rows = mysqli_fetch_assoc($result))
            {
                $i++;
                $id   = $rows['id'];
                $icon = checkIcon($status);
                
                if ($rows['status_id'] == $status)
                {
                    echo '
                        <div class="d-flex bg-white border-bottom mt-2 p-4">
                            <button href="#modal-task" data-bs-toggle="modal"class="d-flex w-100 bg-white border-0" onclick="editTask('.$id.')">
                                <div class="text-green fs-5 ps-3 py-2">
                                    <i class="'.$icon.'"></i>
                                </div>
                                <div class="text-start ps-4" id="status'.$id.'" data="'.$rows['status_id'].'">
                                    <div class="fs-5" id="title'.$id.'" data="'.$rows['title'].'">'.$rows['title'].'</div>
                                    <div class="py-2">
                                        <div class="fw-lighter py-2" id="datetime'.$id.'" data="'.$rows['task_datetime'].'">#'.$i.' created in '.$rows['task_datetime'].'</div>
                                        <div class="fw-light" id="description'.$id.'" data="'.$rows['description'].'">'.$rows['description'].'</div>
                                    </div>
                                    <div class="mt-2">
                                        <span class="bg-blue text-white rounded-3 px-2 py-1" id="priority'.$id.'" data="'.$rows['priority_id'].'">'.$rows['prior'].'</span>
                                        <span class="bg-gray-400 rounded-3 px-2 py-1" id="type'.$id.'" data="'.$rows['type_id'].'">'.$rows['type'].'</span>
                                    </div>
                                </div>
                            </button>
                        </div>
                    ';
                }
            }
            echo "Fetch all tasks";
        }
        else {
            echo "ERROR: Could not able to execute $query. " . mysqli_error($link);
        }
    }


    function saveTask()
    {
        global $link;

        // CODE HERE
        $type        = $_POST['task-type'];
        $status      = $_POST['task-status'];
        $priority    = $_POST['task-priority'];
        $date        = test_input($_POST['task-date']);
        $title       = test_input($_POST['task-title']);
        $description = test_input($_POST['task-description']);

        //SQL INSERT
        $query  = "INSERT INTO `tasks` VALUES (null, '$title', '$type', '$priority', '$status', '$date', '$description')";
        $result = mysqli_query($link, $query);

        // PROTECTION
        if (!isset($result))
            echo "ERROR: Could not able to execute $query. " . mysqli_error($link);
        else
            $_SESSION['message'] = "Task has been added successfully !";
        header('location: index.php');
    }

    function updateTask()
    {
        global $link;

        //CODE HERE
        $id          = $_POST['task-id'];
        $type        = $_POST['task-type'];
        $status      = $_POST['task-status'];
        $priority    = $_POST['task-priority'];
        $date        = test_input($_POST['task-date']);
        $title       = test_input($_POST['task-title']);
        $description = test_input($_POST['task-description']);

        //SQL UPDATE
        $query  = "UPDATE `tasks` SET `title` = '$title', `type_id` = '$type', `priority_id` = '$priority', `status_id` = '$status', `task_datetime`='$date',`description` = '$description' WHERE id = $id";

        // PROTECTION
        if(mysqli_query($link, $query)){
            $_SESSION['message'] = "Task has been updated successfully !";
		    header('location: index.php');
        } else{
            echo "ERROR: Could not able to execute $query. " . mysqli_error($link);
        }
    }

    function deleteTask()
    {
        global $link;
        
        //CODE HERE
        $id = $_POST["task-id"];

        //SQL DELETE
        $query  = "DELETE  FROM `tasks` WHERE id = $id";

        // PROTECTION
        if(mysqli_query($link, $query)){
            $_SESSION['message'] = "Task has been deleted successfully !";
            header('location: index.php');
        } else{
            echo "ERROR: Could not able to execute $query. " . mysqli_error($link);
        }
    }

    function caseCount($status)
    {
        global $link;

        $query  = "SELECT count(status_id) FROM tasks WHERE status_id = $status";
        $result = mysqli_query($link, $query);
        $count  = mysqli_fetch_column($result);

        return $count;
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }
?>