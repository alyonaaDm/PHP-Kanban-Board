
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function allowDrop(ev) {
    ev.preventDefault();
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.currentTarget.appendChild(document.getElementById(data));
    const conditionName = ev.target.id;
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "http://127.0.0.1:8000/task/change-condition", true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    xhr.send(JSON.stringify({
        conditionName: conditionName,
        taskId: document.getElementById(data).id.split('-')[1]
    }));
}

function createTask(){
    var x = document.getElementById("In process");
    var y = document.getElementById("Completed");
    var z = document.getElementById("create-new-task-block");
    if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "block";
        z.style.display = "none";
    } else {
        x.style.display = "none";
        y.style.display = "none";
        z.style.display = "flex";
    }
}

function saveTask(){
    const taskName = document.getElementById("task-name").value;
    const taskDescription = document.getElementById("task-description").value;
    const taskUrgency = document.getElementById("task-urgency").value;
    const taskDeadline = document.getElementById("task-deadline").value;

    const xhr = new XMLHttpRequest();
    xhr.withCredentials = true;
    xhr.open("POST", "http://127.0.0.1:8000/task/add", true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    xhr.send(JSON.stringify({
        taskName: taskName,
        taskDescription: taskDescription,
        taskUrgency: taskUrgency,
        taskDeadline: taskDeadline
    }));
    xhr.onload = () => {
        document.getElementById("task-name").value = '';
        document.getElementById("task-description").value = '';
        document.getElementById("task-urgency").value = 'low';
        document.getElementById("task-deadline").value = '';

        const newTask = JSON.parse(xhr.response);

        const todo = document.getElementById("Unassigned");
        todo.innerHTML += `
                <div class="task" id="task-${newTask.id}" draggable="true" ondragstart="drag(event)" onclick="remove(${newTask.id}, '${newTask.name}')">
                    <span>${newTask.name}</span>
                </div>
                `
        createTask();
    }

}

function remove(taskId, taskName) {
    const xhr = new XMLHttpRequest();
    xhr.withCredentials = true;
    xhr.open("POST", "http://127.0.0.1:8000/task/delete", true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    xhr.send(JSON.stringify({
        taskId: taskId,
    }));
    xhr.onload = () => {
        const taskElem = document.getElementById(`task-${taskId}`);
        console.log(taskElem.innerText)
        taskElem.parentNode.removeChild(taskElem)
    }
}