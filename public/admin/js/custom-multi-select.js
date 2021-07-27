$(document ).ready(function(){	

	if($('.multi-select').length){
		//remove class active of list select
		$(window).click(function(e){
			if($(e.target).closest('.multi-select').html() == undefined && !$(e.target).is('input')){
				$('.multi-select .wrap-list-select').removeClass('active');
			}
		});

		$('.multi-select .box-selected input').click(function(){ 
			$('.multi-select .wrap-list-select').removeClass('active');
			
			$(this).closest('.multi-select').find('.wrap-list-select').toggleClass('active');

			//active item selected in list select
			$(this).closest('.multi-select').find('.box-selected li').each(function(){
				var id = $(this).attr('data-id');
				$(this).closest('.multi-select').find('').find('.list-select li.item-' + id).addClass('selected');
			});
		});
	}

	$(document).on('click', '.multi-select .list-select li', function(){
		var html = '';
		var title = $(this).attr('title');
		var id = $(this).attr('data-id');
		if(!$(this).hasClass('selected')){
			$(this).addClass('selected');
			position = $(this).closest('.multi-select').find('.box-selected li.item-selected').length + 1;
			html += '<li class="item-selected item-'+ id +' add" data-id="'+ id +'" data-position="'+ position +'" title="'+ title +'">';
				html += '<span class="remove">x</span>';
				html += title;
			html += '</li>';

			$(html).insertBefore($(this).closest('.multi-select').find('.box-selected li.search-select'));
		}

		$(this).closest('.multi-select').find('.wrap-list-select').removeClass('active');
	});

	$(document).on('click', '.multi-select .box-selected li.add .remove', function(){
		var id = $(this).closest('li').attr('data-id');
		$(this).closest('.multi-select').find('.list-select li.item-' + id).removeClass('selected');
		$(this).closest('li').remove();
	});

	$('.multi-select .box-selected input').on('input', function(){

		clearTimeout(this.delay);
	   	this.delay = setTimeout(function(){
	      	console.log($(this).val());
	      	/* call ajax request here */
	      	//var keyword = this.value;
	      	var _token = $('input[name=_token]').val();
	      	var keyword = $(this).val();
	      	var link = $(this).closest('.multi-select').find('input.search-action').val(); 
	      	var itemAppend = $(this).closest('.multi-select').find('ul.list-select');
	      	var itemListSelected = $(this).closest('.multi-select').find('.box-selected');

	      	$.ajax({
	            type:'POST',            
	            url: link,
	            cache: false,
	            data:{
	                '_token' : _token,
	                'keyword' : keyword
	            },
	            success:function(data){
	            	if(data.msg == 'success'){ 
	            		itemAppend.html(data.html);
	            		//active item selected in list select
	            		itemListSelected.find('li').each(function(){ console.log('sdsa');
	            			var id = $(this).attr('data-id');
							$(this).closest('.multi-select').find('.list-select li.item-' + id).addClass('selected');
	            		});

	            		
	            	}
	            }
	        });
	      	
	   	}.bind(this), 1000);
	});

	if($('.multi-select').length){
   		$(".multi-select .sortable" ).sortable({
	   		start: function (event, ui) 
	        {
	        	var width = ui.item.outerWidth();
	        	ui.item.css('width', width);
	        	console.log(ui.item.placeholder);
	        } ,
	        stop: function (event, ui) 
	        {
	        },   			
		    update: function(e, ui) {
		    	var index = ui.item.index() + 1;
		    	var length_item = $(this).closest('.sortable').find('li').length;
		    	if(index == length_item){
		    		$( this ).sortable( "cancel" );
		    	}
		    	else{
			        var count = 0;
			        var route_count = 0;
			        var routes = new Array();
			        $(".sortable > .item-selected").each(function(){
			        	if(!$(this).hasClass('delete')){
				        	count = count + 1;
				        	$(this).attr("data-position",count);
				        	routes[route_count] = {
								'id' : $(this).attr("data-value"),						
								'position' : $(this).attr("data-position")
							}
							route_count = route_count + 1;

							//rewrite number position item
							var number_item = count;
						}
			        });		  
			    }        	
		    }     
		});	

		$('.multi-select').each(function(){ 
			$(this).find('.box-selected li.item-selected').each(function(){ 
				var id = $(this).attr('data-id'); 
				$(this).closest('.multi-select').find('.list-select li.item-' + id).addClass('selected');
			});
		});

		//remove item selected
		$('.multi-select .box-selected li.edit .remove').click(function(){
			var count = 0;
	        var route_count = 0;
	        var routes = new Array();
			$(this).closest('li').removeClass('edit').addClass('delete').hide();
			$(this).closest('.multi-select').find(".box-selected .item-selected").each(function(){ 
	        	if(!$(this).hasClass('delete')){
		        	count = count + 1;
		        	$(this).attr("data-position",count);
		        	routes[route_count] = {
						'id' : $(this).attr("data-value"),						
						'position' : $(this).attr("data-position")
					}
					route_count = route_count + 1;

					//rewrite number position item
					var number_item = count;
				}
	        });		
		});
   	}

});