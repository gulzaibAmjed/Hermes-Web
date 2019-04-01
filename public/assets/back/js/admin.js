// Function to make view of all orders...
function getOrders() {
    $.ajax({
        type: 'GET',
        url: 'orders',
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            var content = '<li>הזמנות</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
            $('#page_path').html(content);
            $('.content-area').html(data);
        },
        error: function (data) {
            // failed request; give feedback to user.
            notif({
                msg: "שגיאה.  נסה שוב מאוחר יותר..",
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
function approve(id,plus) {
    $.ajax({
        type: 'POST',
        url: 'orders/approve',
        data: {"id": id,"plus":plus},
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            notif({
                msg: "<b>Note:</b>" + data['data'],
                position: "center",
                time: 10000
            });
            $('#view_orders').click();
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                position: "center",
                time: 10000
            });
            $('#view_orders').click();
        }
    });
}

// Function to make view of edit...
function reject(id) {
    // $('form[name='+id+']').submit();
    $.ajax({
        type: 'POST',
        url: 'orders/reject',
        data: {"id": id},
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            notif({
                msg: "<b>Note:</b>" + data['data'],
                position: "center",
                time: 10000
            });
            $('#view_orders').click();
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                position: "center",
                time: 10000
            });
            $('#view_orders').click();
        }
    });
}

// Function to make view of edit...
function assignManager(manager, order) {
    $.ajax({
        type: 'POST',
        url: 'orders/assignManager',
        data: {"manager": manager, "order": order},
        beforeSend: function () {
            // this is where we append a loading image...
        },
        success: function (data) {
            // successful request; do something with the data...
            notif({
                msg: "<b>Note:</b>" + data['data'],
                position: "center",
                time: 10000
            });
            $('#view_orders').click();
        },
        error: function (data) {
            // failed request; give feedback to user...
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                position: "center",
                time: 10000
            });
            $('#view_orders').click();
        }
    });
}

// Function to make view of edit...
function setPriority(value,order) {
    $.ajax({
        type: 'POST',
        url: 'orders/setPriority',
        data: {"value": value, "order": order},

        beforeSend: function () {
            // this is where we append a loading image...
        },
        success: function (data) {
            // successful request; do something with the data...
            notif({
                msg: "<b>Note:</b>"+ data['data'],
                position: "center",
                time: 10000
            });
            $('#view_orders').click();
        },
        error: function (data) {
            // failed request; give feedback to user...
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר., .",
                position: "center",
                time: 10000
            });
        }
    });
}

// Function to make view of edit...
function setDropPriority(value,order) {
    $.ajax({
        type: 'POST',
        url: 'orders/setDropPriority',
        data: {"value": value, "order": order},

        beforeSend: function () {
            // this is where we append a loading image...
        },
        success: function (data) {
            // successful request; do something with the data...
            notif({
                msg: "<b>Note:</b> "+ data['data'],
                position: "center",
                time: 10000
            });
            $('#view_orders').click();
        },
        error: function (data) {
            // failed request; give feedback to user...
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר.,.",
                position: "center",
                time: 10000
            });
        }
    });
}


// Function to show get manager form...
function getCustomers() {
    $.ajax({
        type: 'GET',
        url: 'customers',
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            var content = '<li>צפה בכל הלקוחות</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
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

// Function to show get manager form...
function getManagers() {
    $.ajax({
        type: 'GET',
        url: 'managers',
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            var content = '<li>צפה בכל השליחים</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
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

// Function to show create manager form...
function createManagerView() {
    $.ajax({
        type: 'GET',
        url: 'managers/create',
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            var content = '<li>הוסף שליח</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
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

// Function to show create manager form...
function editManagerView(id) {
    $.ajax({
        type: 'GET',
        url: 'managers/' + id + '/edit',
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            var content = '<li> עדכן שליחים</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
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

if ($('#addManager').length) {
    $('#addManager').validate({// initialize the plugin
        rules: {
            name: "required",
            email: "required",
            password: "required",
            from: "required",
            to: "required",
            address: "required",
            area: "required"
        },
        submitHandler: function (form) {
            $.ajax({
                type: 'POST',
                url: 'managers',
                data: new FormData($('form[name="addManager"]')[0]),
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                beforeSend: function () {
                    // this is where we append a loading image...
                },
                success: function (data) {
                    // successful request; do something with the data...
                    notif({
                        msg: data["data"],
                        position: "center",
                        time: 10000
                    });
                },
                error: function (data) {
                    // failed request; give feedback to user...
                    notif({
                        msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                        position: "center",
                        time: 10000
                    });
                }
            });
        }
    });
}
// Function to create manager form...
$('form[name="addManager"]').on('submit', function (event) {
    event.preventDefault();
});

if ($('#editManager').length) {
    $('#editManager').validate({// initialize the plugin
        rules: {
            name: "required",
            password: "required",
            from: "required",
            to: "required",
            address: "required",
            area: "required"
        },
        submitHandler: function (form) {
            id = $('#id').val();
            $.ajax({
                type: 'POST',
                url: 'managers/update',
                // data: "here",
                data: new FormData($('form[name="editManager"]')[0]),
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                beforeSend: function () {
                    // this is where we append a loading image...
                },
                success: function (data) {
                    // successful request; do something with the data...//need to change for this alert
                    notif({
                        msg: "<b>Note:</b> "+data['data'],
                        position: "center",
                        time: 10000
                    });
                        $('#all_managers').click();
                },
                error: function (data) {
                    // failed request; give feedback to user...
                    notif({
                        msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                        position: "center",
                        time: 10000
                    });
                }
            });
        }
    });
}
// Function to create manager form...
$('form[name="editManagers"]').on('submit', function (event) {
    event.preventDefault();
});


$(document).on('change','#priority',function(){
  var parent = $(this).parent();
  var value = $(this).val();
    setPriority(value,parent.attr('name'));
});

$(document).on('change','#drop_priority',function(){
    var parent = $(this).parent();
    var value = $(this).val();
    setDropPriority(value,parent.attr('name'));
});

$(document).on('change', '#orderAction', function () {
var parent = $(this).parent();
    var value = $(this).val();
    if (value != 2) {
        approve(parent.attr('name'),$(this).val());
    } else if (value == 2) {
        reject(parent.attr('name'));
    } else {
        notif({
            msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
            position: "center",
            time: 10000
        });
    }
});

$(document).on('change', '#assignManager', function () {
    var parent = $(this).parent();
    var value = $(this).val();
    assignManager(value, parent.attr('name'));
});

function filterOrders() {
    $.ajax({
        type: 'POST',
        url: 'search/orders',
        // data: "here",
        data: new FormData($('form[name="editManager"]')[0]),
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData: false,

        beforeSend: function () {
            // this is where we append a loading image...
        },
        success: function (data) {
            // successful request; do something with the data...
            notif({
                msg: "<b>Note:</b> "+ data['data'],
                position: "center",
                time: 10000
            });
                $('#all_managers').click();
        },
        error: function (data) {
            // failed request; give feedback to user...
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר.,.",
                position: "center",
                time: 10000
            });
        }
    });
}

function viewAllLocations() {
    $.ajax({
        type: 'GET',
        url: 'locations',
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            if (data['response'] == RESPONSE_STATUS_SUCCESS) {
                var content = '<li>צפה בכל האיזורים</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; עמוד הבית </a></li>';
                $('#page_path').html(content);
                $('.content-area').html(data['data']);
            }else{
                notif({
                msg: "<b>Oops:</b> "+data['data']+".",
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

function createLocation() {
    $.ajax({
        type: 'GET',
        url: 'locations/create',
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            var content = '<li> צור איזור חדש</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
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

function editLocation(id) {
    $.ajax({
        type: 'GET',
        url: 'locations/'+id+'/edit',
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            if (data['response'] == RESPONSE_STATUS_SUCCESS) {
                var content = '<li> עדכן איזור</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
                $('#page_path').html(content);
                $('.content-area').html(data['data']);    
            }else{
                notif({
                msg: "<b>Oops:</b> "+data['data'],
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

function bulkLocations() {
    $.ajax({
        type: 'GET',
        url: 'bulk/locations',
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
                var content = '<li>הוסף מספר איזורים</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
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


$(document).on('submit','#addLocation',function(event){
    event.preventDefault();
});
if ($('#addLocation').length) {
    $('#addLocation').validate({// initialize the plugin
        rules: {
            city: "required",
            neighbourhood: "required",
            street: "required"
        },
        submitHandler: function (form) {
        $.ajax({
        type: 'POST',
        url: 'locations',
        data: new FormData($('form[name="addLocation"]')[0]),
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false,
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            if (data['response'] == RESPONSE_STATUS_SUCCESS) {
                notif({
                msg: data['data'],
                position: "center",
                time: 10000
            });
            }else{
                notif({
                msg: "<b>Oops:</b> "+data['data']+".",
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
    });
}

$(document).on('submit','#updateLocation',function(event){
    event.preventDefault();
});
if ($('#updateLocation').length) {
    $('#updateLocation').validate({// initialize the plugin
        rules: {
            city: "required",
            neighbourhood: "required",
            street: "required"
        },
        submitHandler: function (form) {
        $.ajax({
        type: 'POST',
        url: 'locations/update',
        data: new FormData($('form[name="updateLocation"]')[0]),
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false,
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            if (data['response'] == RESPONSE_STATUS_SUCCESS) {
                notif({
                msg: data['data'],
                position: "center",
                time: 10000
            });
            }else{
                notif({
                msg: "<b>Oops:</b> "+data['data']+".",
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
    });
}

$(document).on('change','#bulkFile',function(){
    $('#bulkLocations').submit();
});

$(document).on('submit','#bulkLocations',function(event){
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'bulk/locations',
        data: new FormData($('form[name="bulkLocations"]')[0]),
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false,
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            if (data['response'] == RESPONSE_STATUS_SUCCESS) {
                notif({
                msg: data['data'],
                position: "center",
                time: 10000
            });
            }else{
                notif({
                msg: "<b>Oops:</b> "+data['data']+".",
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
})

function priceList(){
    $.ajax({
        type: 'GET',
        url: 'prices',
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            if(data['response'] == RESPONSE_STATUS_SUCCESS){
                var content = '<li>רשימת מחירים</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
                $('#page_path').html(content);
                $('.content-area').html(data['data']);
            }else{
                notif({
                    msg: "<b>Oops:</b>"+data['data']+".",
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
// Function to show get manager form...
function pricing(managerId) {
    if(managerId!=''){
    $.ajax({
        type: 'GET',
        url: 'prices/'+managerId,
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            if(data['response'] == RESPONSE_STATUS_SUCCESS){
                var content = '<li>רשימת מחירים</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
                $('#page_path').html(content);
                $('.table-section').html(data['data']);
            }else{
                notif({
                msg: "<b>Oops:</b>"+data['data']+".",
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
}

$(document).on('blur','.price',function(){
    _this = $(this);

    var id = _this.attr('id');
    var value = _this.val();
    var lid = _this.attr('lid');
    var mid = _this.attr('mid');
    $.ajax({
            url: 'updatePrice',
            data: {'id':id, 'value':value, 'lid':lid, 'mid':mid},
            type: 'post',
            success: function (data) {
                if(data['response'] == RESPONSE_STATUS_SUCCESS){
                    _this.attr('id',data['id']);
                    notif({
                    msg: "Price updated successfully.",
                    position: "center",
                    time: 10000
                });
                }else{
                    notif({
                        msg: data['data'],
                        position: "center",
                        time: 10000
                    });
                }
            },
            error: function (data) {
                notif({
                    msg: "<b>Oops!</b> שגיאה.  נסה שוב מאוחר יותר..",
                    position: "center",
                    time: 10000
                });
            },
        });
});

function employeeReport(){
    $.ajax({
        type: 'GET',
        url: 'employeeReport',
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            if(data['response'] == RESPONSE_STATUS_SUCCESS){
                var content = '<li>דוח עובדים</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
                $('#page_path').html(content);
                $('.content-area').html(data['data']);
            }else{
                notif({
                    msg: "<b>Oops:</b>"+data['data']+".",
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

function ordersReport(){
    $.ajax({
        type: 'GET',
        url: 'getOrdersReport',
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            if(data['response'] == RESPONSE_STATUS_SUCCESS){
                var content = '<li>דוח הזמנות</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
                $('#page_path').html(content);
                $('.content-area').html(data['data']);
            }else{
                notif({
                    msg: "<b>Oops:</b>"+data['data']+".",
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

function managerLocation(){
    $.ajax({
        type: 'GET',
        url: 'getManagerLocation',
        beforeSend: function () {
            // this is where we append a loading image
        },
        success: function (data) {
            // successful request; do something with the data
            if(data['response'] == RESPONSE_STATUS_SUCCESS){
                var content = '<li>מעקב שליחים</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
                $('#page_path').html(content);
                $('.content-area').html(data['data']);
            }else{
                notif({
                    msg: "<b>Oops:</b>"+data['data']+".",
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

function findLocation (manager_id) {
    $.ajax({
        type: 'POST',
        url: 'findLocation',
        data: {"id": manager_id},
        success: function (data) {
            // successful request; do something with the data
            if (data['response'] == RESPONSE_STATUS_SUCCESS) {
                $('.table-section').html(data['data']);
            }else{
                notif({
                    msg: "משהו לא בסדר עם האתר, אנא נסה שוב",
                    position: "center",
                    time: 10000
                });
            }
            // $('#view_orders').click();
        },
        error: function (data) {
            // failed request; give feedback to user
            notif({
                msg: "<b>Oops:</b> שגיאה.  נסה שוב מאוחר יותר..",
                position: "center",
                time: 10000
            });
            // $('#view_orders').click();
        }
    });
}

function createOrderAdmin () {
    $.ajax({
        type: 'GET',
        url: 'getOrderAdminCreate',
        success: function (data) {
            // successful request; do something with the data
            if(data['response'] == RESPONSE_STATUS_SUCCESS){
                var content = '<li>הוסף הזמנה</li> <span class="fa fa-angle-left"></span><li><a href="dashboard"> &nbsp; הבית </a></li>';
                $('#page_path').html(content);
                $('.content-area').html(data['data']);
            }else{
                notif({
                    msg: "<b>Oops:</b>"+data['data']+".",
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

function updateCustomer(id){

}