// $('#register').on('submit',function(e){
// 	e.preventDefault();	
// 	url: 'check/user', // Url to which the request is send
// 	type: "POST",             // Type of request to be send, called as method
// 	data: new FormData($('form[name="register"]')[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
// 	contentType: false,       // The content type used when sending data to the server.
// 	cache: false,             // To unable request pages to be cached
// 	processData:true,
// 	beforeSend:function(){
//     // this is where we append a loading image
//   },
//   success:function(data){
//   	// $('.content-area').html(data);
//     // successful request; do something with the data
//     alertify.alert(data['data']);
//   },
//   error:function(data){
//     // failed request; give feedback to user
// 	alertify.alert ("Oops","שגיאה.  נסה שוב מאוחר יותר..");
// 	}
// });

