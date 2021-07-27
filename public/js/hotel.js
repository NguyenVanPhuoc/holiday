$(document ).ready(function(){

	$('.hotel-content').on('change', '#sidebar .list-filter-hotel li input', function(e){ 
		var per_page = $('.filter-top .chose-value').text(); 
        filterHotel(per_page);
    });

    $('.filter-top .popup-filter li').click(function(){
    	var current_per_page = $('.filter-top .chose-value').text();
    	var per_page = $(this).text();
    	if(per_page != current_per_page)
    		filterHotel(per_page);
    });

    $('#content').on('click', '.pagination .page-item > a', function(e){
    	e.preventDefault();
    	var per_page = $('.filter-top .chose-value').text();
    	var current_page = parseInt($('.pagination .page-item.active span').text());
    	if($(this).hasClass('page-next')){
    		var page = current_page + 1;
    	}
    	else if($(this).hasClass('page-prev')){
    		var page = current_page - 1;
    	}
    	else{
    		var page = $(this).text();
    	}
    	
    	filterHotel(per_page, page);
    });


	//filter hotel (accommodation)
	function filterHotel(per_page = null, page = null){
		if($('.hotel-content').length){
			var _token = $('input[name=_token]').val();
			var link = $('input[name=filter_hotel]').val();
			var current_country = $('input[name=current_country]').val(); 
			//var per_page = $('.filter-top .chose-value').text();
			var data_send = $('#sidebar form').serialize() + '&current_country=' + current_country + '&_token=' + _token;
			if(per_page != null)
				data_send += '&per_page=' + per_page;
			if(page != null)
				data_send += '&page=' + page;
			$.ajax({
				type:'POST',            
				url: link,
				cache: false,
				data: data_send,
				beforeSend: function () { 
	       			$('#overlay').fadeIn();
	       			$('img.loading').fadeIn();
	            },
	            success:function(data){
	            	$('#overlay').fadeOut();
       				$('img.loading').fadeOut();
	            	if(data.msg === 'success'){ 
	            		var arrayCity = data.count_city;
	            		var arrayStar = data.count_star;
	            		var arrayLocation = data.count_location;
	            		var arraySpecial = data.count_special;
	            		$('.content-list-hotel').html(data.html);
	            		$.each( arrayCity, function( index, item ){ 
	            			$('.city-' + item.id + ' .count-post').text('(' + item.value + ')');
						});
						$.each( arrayStar, function( index, item ){
	            			$('.star-' + item.id + ' .count-post').text('(' + item.value + ')');
						});
						$.each( arrayLocation, function( index, item ){
	            			$('.location-' + item.id + ' .count-post').text('(' + item.value + ')');
						});
						$.each( arraySpecial, function( index, item ){
	            			$('.special-' + item.id + ' .count-post').text('(' + item.value + ')');
						});
						if(data.url != undefined && data.url != '')
							window.history.pushState("object or string", "Title", data.url);
						$('.filter-top .result .value').text(data.total);
	            	}
	            }
			});

		}
	}
});