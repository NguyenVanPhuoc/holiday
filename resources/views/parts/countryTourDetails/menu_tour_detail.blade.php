<div class="container">
	<ul class="item-menu">
   		<li><a href="#" class="btn btn_itiner modal_itinerary">Itinerary brief</a></li>
   		<li><span class="btn btn_itiner">{{ $tour->number }} days</span></li>
   		<li><a href="{{ route('createPersonalize',['title'=>$tour->title]) }}" class="btn btn_perso" target="_blank">PERSONALIZE</a></li>
   		<li>
   			<a href="#" class="btn btn_itiner modal_price" >{{ $tour->price != '' ? 'From $'.$tour->price :  'From: On Request'}}</a>
   		</li>
   		<li><span class="btn btn_itiner" >{{ $cates->title }}</span></li>
   </ul>
</div>