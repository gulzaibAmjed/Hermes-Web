// Function to make view of all orders...
function viewStartJob() {
    $.ajax({
        type: 'GET',
        url: 'startJobView',
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            var content = '<li>התחל דיווח</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
            $('#page_path').html(content);
            $('.main-content').html(data);
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops!</b> שגיאה.  נסה שוב מאוחר יותר..",
                position: "center",
                time: 10000
            });
        }
    });
}

// Function to make view of edit...
function changeStatus(status,id) {
    $.ajax({
        type: 'post',
        url: 'orders/changeStatus',
        data: {"id": id,"status":status},

        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            notif({
                msg: data['data'],
                position: "center",
                time: 10000
            });
            $('#view_jobs').click();
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "משהו לא בסדר עם האתר, אנא נסה שוב",
                position: "center",
                time: 10000
            });
        }
    });
}

// Function to make view of all jobs...
function viewJobs() {
    $.ajax({
        type: 'GET',
        url: 'orders',

        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            var content = '<li>דיווח</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
            $('#page_path').html(content);
            $('.main-content').html(data);
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר.,.",
                position: "center",
                time: 10000
            });
        },
        complete: function(){
            initializeTimer();
        }
    });
}

// Function to make view of edit...
function acceptJob(id) {
    $.ajax({
        type: 'post',
        url: 'orders/acceptJob',
        data: {"id": id},

        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            notif({
                msg: "<b>Note:</b> "+ data['data'],
                position: "center",
                time: 10000
            });
            $('#view_jobs').click();
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר.,.",
                   position: "center",
                time: 10000
            });
        }
    });
}

// Function to make view of edit...
function rejectJob(id) {
    $.ajax({
        type: 'post',
        url: 'orders/rejectJob',
        data: {"id": id},

        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            notif({
                msg: "<b>Note:</b> "+ data['data'],
                position: "center",
                time: 10000
            });
            $('#view_jobs').click();
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר.,.",
                position: "center",
                time: 10000
            });
        }
    });
}

function startJob(){
    $.ajax({
        type: 'get',
        url: 'startJob',
        success: function (data) {
            // successful request; do something with the data
            notif({
                msg: "<b>Note:</b> "+ data['data'],
                position: "center",
                time: 10000
            });
            $('#view_jobs').click();
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר.,.",
                position: "center",
                time: 10000
            });
        }
    });
}

function stopJob(id){
    $.ajax({
        type: 'post',
        url: 'stopJob',
        data: {id : id},
        success: function (data) {
            // successful request; do something with the data
            notif({
                msg: "<b>Note:</b> "+ data['data'],
                position: "center",
                time: 10000
            });
            $('#view_jobs').click();
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר.,.",
                position: "center",
                time: 10000
            });
        }
    });
}

function cancelStatus(id){
    $.ajax({
        type: 'post',
        url: 'cancelStatus',
        data: {id : id},
        success: function (data) {
            // successful request; do something with the data
            notif({
                msg: "<b>Note:</b> "+ data['data'],
                position: "center",
                time: 10000
            });
            $('#view_jobs').click();
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר.,.",
                position: "center",
                time: 10000
            });
        }
    });
}