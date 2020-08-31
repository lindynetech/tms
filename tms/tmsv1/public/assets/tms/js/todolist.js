/**
 * LocalStorage based todo list
 */
$(document).ready(function() {

    // Reset
    $('#resetTodo').on('click', resetList);
    // Add
    $('#addItem').on('click', saveTask);

    var tasksArray = getTasksArray();

    for(var i = 0, count = tasksArray.length; i < count; i++) {
        var key = tasksArray[i];
        var value = JSON.parse(localStorage[key]);
        addTaskToDOM(key, value);
    }

    // Edit
    $('#todoList').on('click', '.fa-edit', function(){
        var el = $(this).parents("li").first();
        el.nextAll().hide();
        el.prevAll().hide();
        var key = el.attr('id');
        var originalContent = el.find('.text').text();

        el.find('.text').prop('contenteditable', true).focus();
        $(this).attr('class', 'fa fa-save');
        $('<i class="fa fa-remove" style="margin-right: 15px;"></i>').insertBefore($(this));

        el.on('click', '.fa-remove', { oc: originalContent }, function(e) {
            var contentSpan = el.find('.text');
            var cancelBtn = $(this);
            var saveBtn = cancelBtn.next();
            contentSpan.prop('contenteditable', false).text(e.data.oc);
            cancelBtn.remove();
            saveBtn.attr('class', 'fa fa-edit');
            el.nextAll().show();
            el.prevAll().show();
        });

        el.on('click', '.fa-save', function() {
            var contentSpan = el.find('.text');
            var newContent = contentSpan.text();
            var saveBtn = $(this);
            var cancelBtn = saveBtn.prev();

            contentSpan.prop('contenteditable', false).text(newContent);
            saveEditedTask(key, newContent);
            $('<i class="fa fa-edit" style="margin-right: 15px;"></i>').insertBefore(saveBtn);
            cancelBtn.remove();
            saveBtn.remove();
            el.nextAll().show();
            el.prevAll().show();
        });

        el.keypress(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        });
    });

    // Delete
    $('#todoList').on('click', '.fa-trash-o', function(){
        var el = $(this).parents("li").first();
        var key = el.attr('id');
        localStorage.removeItem(key);

        var tasksArray = getTasksArray();
        var startPos = tasksArray.indexOf(key);
        tasksArray.splice(startPos, 1);
        localStorage.setItem("tasksArray", JSON.stringify(tasksArray));

        el.remove();
    });

    // Mark done
    $(".todo-list").on('click', 'input', function() {
        var el = $(this).parents("li").first();
        var key = el.attr('id');
        var objTask = JSON.parse(localStorage[key]);
        var status =  el.children("input[type='checkbox']").prop( "checked");
        if(status == true) {
            markChecked(key);
        } else {
            markUnChecked(key);
        }
        el.toggleClass('done');

    });

}); //ready

function saveEditedTask(key, content) {
    var tasksArray = getTasksArray();
    var objTask = JSON.parse(localStorage[key]);
    objTask.content = '<span class="text">' + content + '</span>';
    localStorage.setItem(key, JSON.stringify(objTask));
}

function markChecked(key) {
    var objTask = JSON.parse(localStorage[key]);
    objTask.status = true;
    objTask.inputbox = '<input type="checkbox" checked>';
    localStorage.setItem(key, JSON.stringify(objTask));
}

function markUnChecked(key) {
    var objTask = JSON.parse(localStorage[key]);
    objTask.status = false;
    objTask.inputbox = '<input type="checkbox">';
    localStorage.setItem(key, JSON.stringify(objTask));
}

function saveTask() {
    var newtask = $('#newtask');
    if(newtask.val() !== '') {
        var postfix = new Date().getTime();
        var key = 'tasks_' + postfix;
        var content = '<span class="text">' + newtask.val() + '</span>';
        var inputbox = '<input type="checkbox">';
        var tools = '<div class="tools"><i class="fa fa-edit" style="margin-right: 15px;"></i><i class="fa fa-trash-o"></i></div>';
        var status = false;

        var tasksArray = getTasksArray();
        var taskObj = {
            content: content,
            status: status,
            inputbox: inputbox,
            tools: tools
        };
        localStorage.setItem(key, JSON.stringify(taskObj));
        tasksArray.push(key);
        localStorage.setItem('tasksArray', JSON.stringify(tasksArray));
        addTaskToDOM(key, taskObj);
        newtask.val('');
    }
}

function addTaskToDOM(key, obj) {
    var list = $('#todoList');
    if(obj.status === true) {
        list.append('<li class="done" id="' + key + '">' + obj.inputbox + obj.content + obj.tools + '</li>');
    } else {
        list.append('<li id="' + key + '">' + obj.inputbox + obj.content + obj.tools + '</li>');
    }
}

function resetList(e) {
    e.preventDefault();
    localStorage.clear();
    $('#todoList').empty();
}

function getTasksArray() {
    var tasksArray = localStorage["tasksArray"];
    if(!tasksArray) {
        tasksArray = [];
        localStorage.setItem("tasksArray", JSON.stringify(tasksArray));
    }
    else {
        tasksArray = JSON.parse(tasksArray);
    }
    return tasksArray;
}


