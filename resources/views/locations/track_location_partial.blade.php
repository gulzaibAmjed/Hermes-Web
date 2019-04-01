<div id="map" style="width: 100%; height: 400px;"></div>
<script type="text/javascript">
	var map;
	$(document).ready(function(){
	      map = new GMaps({
	        el: '#map',
	        lat: {{$lat}},
	        lng: {{$lon}},
	        zoom: 10,
	        zoomControl : true,
	        zoomControlOpt: {
	            style : 'SMALL',
	            position: 'TOP_LEFT'
	        },
	        panControl : false,
	        streetViewControl : false,
	        mapTypeControl: false,
	        overviewMapControl: false
	      });
	      });
	
	@if(count($timeStamps)>0)
	@if($manager_id != 'all')
		@if(!is_null($timeStamps->user->manager) && !empty($timeStamps->user->manager) && !empty($timeStamps->latitude)  && !empty($timeStamps->longitude) && $timeStamps->longitude!=0 && $timeStamps->latitude!=0)
	        map.addMarker({
	            lat: {{ $timeStamps->latitude }},
	            lng: {{ $timeStamps->longitude }},
	            infoWindow: {
	              content: '<p>{{ $timeStamps->user->manager->name }}</p>'
	            }
	        });
			map.setCenter({
	            lat: {{ $timeStamps->latitude }},
	            lng: {{ $timeStamps->longitude }}
	        });
	    @endif
	@else
	@foreach($timeStamps as $timeStamp)

	    @if(!is_null($timeStamp->user->manager) && !empty($timeStamp->user->manager) && !empty($timeStamp->latitude)  && !empty($timeStamp->longitude) && $timeStamp->longitude!=0 && $timeStamp->latitude!=0)
	        map.addMarker({
	            lat: {{ $timeStamp->latitude }},
	            lng: {{ $timeStamp->longitude }},
	            infoWindow: {
	              content: '<p>{{ $timeStamp->user->manager->name }}</p>'
	            }
	        });
			map.setCenter({
	            lat: {{ $timeStamp->latitude }},
	            lng: {{ $timeStamp->longitude }}
	        });
	    @endif
	    @endforeach
	@endif
		@else
map.setCenter({
	            lat: {{ $lat }},
	            lng: {{ $lon }}
	        });
	@endif
</script>