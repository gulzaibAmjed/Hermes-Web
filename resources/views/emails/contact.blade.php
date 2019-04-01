<h1>Hi Admin!</h1>
<h2>You have just received a query from {{$data['name']}}.</h2>
<h3>Name: {{$data['name']}}</h3>
<h3>Email: {{$data['email']}}</h3>
<h3>Message:</h3> <p>{{$data['message']}}</p>
<h4>For further information.<a href="{{url('/')}}">Click here!</a></h4>