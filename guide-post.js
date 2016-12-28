var tkugp_classes = [];
var tkugp_subclasses = [];
var tkugp_mainclasses = [];
var tkugp_selected = [];
var tkugp_selected_classes = '';
var tkugp_sortclasses = [];

jQuery(function($){

function tkugp_sort_items(){
	
	//sorting
	var class_names = [];

	$('.tkugp-ol:first').each(function(){
		
		$(this).find('li.tkugp-selected').each(function(){
				var id  = $(this).attr('data-tkugptag');
				if( id == 'undefined')
					id  = $(this).attr('data-tkugpfavrt');
				
				var class_name = 'tkugp-tag-'+id;
				class_names.push(class_name);
				console.log('aaaa');
		});
						
	});

	
    var priorityClassNames = class_names;
    var $list = $('#tkugp-items');

    // Simple comparison function that sorts by class
    var startSorting = function (a, b, c, i, ch, r) {
    	

        if( i > ch.length )
        	return r;

        if ($(a).hasClass(c) && !($(b).hasClass(c)))
            r = -1; 
        // b comes first since it has class but a doesn't
        else if (!$(a).hasClass(c) && ($(b).hasClass(c)))
            r = 1; 
        // Both have same class -- sory by next criterion
        else {
        	i++;
        	return startSorting(a, b, c, i, ch, r);
        }
    };

    //iterate throgh classs
    var sortByClass = function (a, b) {
        var $a = $(a);
        var $b = $(b);
        var comparisonResult = 0;
        var className;
        $.each(priorityClassNames, function(index, el) {
            className = this;
            

                   	var ch = priorityClassNames;
                	var i = index;
                	var r = 0;
                	var c = className;
                	comparisonResult = startSorting(a, b, c, i, ch, r);
               
                return false; // break out of $.each
        });

        return comparisonResult;
    };

   
    $list.children(".tkugp-listitem-single")
    // Sort jQuery object with <li> elements
    .sort(sortByClass)
    // Take them out of the DOM
    .detach()
    // Put them back (in order)
    .appendTo($list);




}


	$('.tkugp-listitem-single').each(function(index, el) {
		
		var $this = $(this);
			
		$this.find('.tkugp-item-terms span.tkugp-item-term').each(function(i, e) {
				

	

				var term='', term_id='';

				if( $(this).hasClass('tkugp-term-category') ){

					term = 'tkugp-category';
					term_id = $(this).attr('data-itemterm');

				} else if ( $(this).hasClass('tkugp-term-tag') ){

					term = 'tkugp-tag';
					term_id = $(this).attr('data-itemterm');


				} else if ( $(this).hasClass('tkugp-term-favrt') ){

					term = 'tkugp-favrt';
					term_id = $(this).attr('data-itemterm');


				}


					var this_class = term+'-'+term_id;
					
					if( !$this.hasClass(this_class))
						$this.addClass(this_class);

					if( term == 'tkugp-favrt' ){
							

						term = 'tkugp-tag';
						var this_class = term+'-'+term_id;

						if( !$this.hasClass(this_class))
							$this.addClass(this_class);

					}

		});

	});

	$(document).on('click', '.tkugp-category-list li', function(event) {
		event.preventDefault();
		
	
		if($(this).hasClass('tkugp-selected'))
			$(this).removeClass('tkugp-selected');
		else 
			$(this).addClass('tkugp-selected');

		var id = $(this).attr('data-tkugpcat');

		
		
	});


	$(document).on('click', '.tkugp-tag-list li.tkugp-tag', function(event) {
		event.preventDefault();
		
	
		if($(this).hasClass('tkugp-selected'))
			$(this).removeClass('tkugp-selected');
		else 
			$(this).addClass('tkugp-selected');


		
		
	});

	$(document).on('click', '.tkugp-favrt-list li', function(event) {
		event.preventDefault();
		
		

		if($(this).hasClass('tkugp-selected')){

			$(this).removeClass('tkugp-selected');
		
		} else {
			$('.tkugp-favrt-list li').removeClass('tkugp-selected');
			$(this).addClass('tkugp-selected');
		}



		var id = $(this).attr('data-tkugpfavrt');

		
		
	});


function tkugp_compare_two(a, b, r, self){

	for (var i=0; i < a.length; i++) { 
		for (var j=0; j < b.length; j++) { 
			

			if( self.hasClass(a[i]) && self.hasClass(b[j]) )
				r = true;
		}
	}

	return r;

}

function tkugp_compare(choices, length, index, res, self, show){

	if( index > length )
		return show;
	
	for (var i=index + 1; i < choices.length; i++) { 

		var a = choices[index];
		var b = choices[i];
		var res = false;
		res = tkugp_compare_two(a , b, res, self);
		show.push(res);
	}
	
	index++;

	return tkugp_compare(choices, length, index, res, self, show);
	
}

function tkugp_display_item(self, choices, length){

		var show = [];
		var display = false;



		if( choices.length > 1 ){


			show = tkugp_compare(choices, length, 0, false, self, show);
			display = true;
			for (var i = 0; i < show.length; i++) {
				if( !show[i] )
					display = false;
			}
			
		} else {

			var a = choices[0];
			for (var i = 0; i < a.length; i++) {

				if( self.hasClass(a[i]) )
					display = true;
			};
		}

		


		var favrt = $('ol.tkugp-favrt-list.tkupg-option-slected li.tkugp-selected').attr('data-tkugptag');
		if( favrt  == 'yes' && !self.hasClass('tkugp-favrt-yes'))
				display = false;


		return display;
}


$(document).on('click', '.tkugp-ol li', function(event) {

		event.preventDefault();
		tkugp_classes = [];
		tkugp_subclasses = [];
		tkugp_mainclasses = [];
		tkugp_sortclasses = [];
		tkugp_selected_classes = '';
		var sort_i = 0;
		
		$('.tkugp-ol').removeClass('tkupg-option-slected');

		$('.tkugp-ol li').each(function(index, el) {
				

				if( $(this).hasClass('tkugp-selected') ){
					
					var class_name = '';
					$(this).closest('.tkugp-ol').addClass('tkupg-option-slected');

					if( $(this).hasClass('tkugp-tag') ){

						var id  = $(this).attr('data-tkugptag');
						class_name = 'tkugp-tag-'+id;
						tkugp_classes.push(class_name);
						tkugp_selected_classes += '.'+'tkugp-tag-'+id+',';

					} else if( $(this).hasClass('tkugp-favrt tkugp-selected') ){
						//if( $(this).attr('data-tkugpfavrt') != 'no' ){
							var id  = $(this).attr('data-tkugpfavrt');
							class_name = 'tkugp-favrt-'+id;
							tkugp_classes.push(class_name);
							tkugp_selected_classes += '.'+'tkugp-favrt-'+id+',';
						//}
					}

					if( $(this).hasClass('tkugp-main-tag-0')){

						tkugp_mainclasses.push(class_name);

					} else {
						tkugp_subclasses.push(class_name);
					
					}



		
				}



			});

		var choices = [];

		$('ol.tkugp-ol.tkupg-option-slected').not('.tkugp-favrt-list').each(function(choiceindex, e) {

			var sel_option = [];
			$(this).find('li.tkugp-selected').each(function(j, k) {
				
				var id  = $(this).attr('data-tkugptag');
				var class_name = 'tkugp-tag-'+id;
				
				sel_option.push(class_name);

			});

			choices[choiceindex] = sel_option;

		});


		var choices_length = choices.length;
			choices_length = parseInt(choices_length) - 1;

		$('.tkugp-listitem-single').each(function(itemindex, el) {

				var $this = $(this);
				$this.hide();

				tkugp_selected = [];
				
				if( tkugp_display_item($this, choices, choices_length) ){
						
						$this.show();

						for (var i = tkugp_classes.length - 1; i >= 0; i--) {
							var selected_term = 'tkugp-termnone';

							if ( tkugp_classes[i].indexOf("tag")  > 0  ){

								//selected_term = 'tkugp-term-tag';
								selected_term = tkugp_classes[i]
								tkugp_selected.push(selected_term);
							} 

							 if (  tkugp_classes[i].indexOf("favrt")  > 0  ){

								//selected_term = 'tkugp-term-favrt';
								selected_term = tkugp_classes[i];
								tkugp_selected.push(selected_term);
							}

							
							
							$this.find('.tkugp-item-terms span').removeClass('tkugp-selected-term');

							for (var j = tkugp_selected.length - 1; j >= 0; j--) {

								$this.find('.tkugp-item-terms span.'+tkugp_selected[j]).addClass('tkugp-selected-term');
							}
							
							
						};	
					}

		});
	
		tkugp_sort_items();

	});




});