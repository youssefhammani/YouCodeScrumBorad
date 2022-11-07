

function  editTask(id)
{
    $("#task-save-btn").hide();
    $("#task-delete-btn").show();
    $("#task-update-btn").show();
    
    document.getElementById('task-id').value          = id;
    document.getElementById('task-date').value        = document.getElementById("datetime"+id).getAttribute('data');
    document.getElementById('task-title').value       = document.getElementById("title"+id).getAttribute('data');
    document.getElementById('task-status').value      = document.getElementById("status"+id).getAttribute('data');
    document.getElementById('task-priority').value    = document.getElementById("priority"+id).getAttribute('data');
    document.getElementById('task-description').value = document.getElementById("description"+id).getAttribute('data');

    if(document.getElementById("type"+id).getAttribute('data') == 1)
        document.getElementById('task-type-feature').checked = true;
    else
    document.getElementById('task-type-bug').checked = true;
}

function displayButton()
{
    $("#task-save-btn").show();
    $("#task-delete-btn").hide();
    $("#task-update-btn").hide();
    
    document.getElementById('form-task').reset();
}

function validateForm()
{
    var task_title       = document.forms["Form"]["task-title"].value;
    var task_date        = document.forms["Form"]["task-date"].value;
    var task_description = document.forms["Form"]["task-description"].value;
    
    if (task_title == null || task_title.trim() == "")
    {
        alert("Please Fill All Required Field");
        return false;
    }
    else if (task_date == null || task_date == "")
    {
        alert("Please Fill All Required Field");
        return false;
    }
    else if (task_description == null || task_description.trim() == "")
    {
        alert("Please Fill All Required Field");
        return false;
    }
}