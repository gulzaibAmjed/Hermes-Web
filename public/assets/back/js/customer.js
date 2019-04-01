function getProfile() {
    $.ajax({
        type: 'GET',
        url: 'profile',
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            var content = "<li>עדכן פרופיל</li> <span class='fa fa-angle-left'></span><li><a href='dashboard'> &nbsp; הבית </a></li>";
            $('#page_path').html(content);
            $('.content-area').html(data);
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                position: "center",
                time: 10000
            });
        }
    });
}

// Function to make view of all orders...
function getOrders() {
    $.ajax({
        type: 'GET',
        url: 'orders',
        success: function (data) {
            // successful request; do something with the data
            var content = '<li>הזמנות</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
            $('#page_path').html(content);
            $('.content-area').html(data);
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
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
function editOrder(id) {
    $.ajax({
        type: 'GET',
        url: 'orders/' + id + '/edit',
        success: function (data) {
            // successful request; do something with the data

            if (data['response'] == RESPONSE_STATUS_SUCCESS) {
                $('.content-area').html(data['data']);
            }else{
                notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                position: "center",
                time: 10000
            });
            }
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                position: "center",
                time: 10000
            });
        }
    });
}

// Function to make view of edit...
function deleteOrder(id) {
    // $('form[name='+id+']').submit();
    $.ajax({
        type: 'DELETE',
        // data: { "_t  en": $('[name="_t   en"]').attr('content') },
        url: 'orders/' + id,
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            notif({
                type: "success",
                msg: data['data'],
                position: "center",
                fade: true
            });
            $('#view_order').click();
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                position: "center",
                time: 10000
            });
        }
    });
}

