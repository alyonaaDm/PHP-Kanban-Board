function saveCondition() {
    const conditionName = document.getElementById("condition-name").value;
    document.getElementById("condition-name").value = '';

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "http://127.0.0.1:8000/board/add", true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
    xhr.send(JSON.stringify({
        conditionName: conditionName
    }));
    xhr.onload = () => {
        const newCondition = JSON.parse(xhr.response);
        const conditions = document.querySelector('#all-conditions');
        conditions.innerHTML += `
                    <div class="kanban-block kanban-block-${conditions.children.length + 1} ${newCondition.name}" id="${newCondition.name}">
                        <strong>${newCondition.name}</strong>
                    </div>
                `;
    }
}