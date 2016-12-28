if(typeof String.prototype.trim !== 'function') {

  String.prototype.trim = function() {

    return this.replace(/^\s+|\s+$/g, ''); 

  }

}



if( typeof String.prototype.split !== 'function' ){





String.prototype.split = function (r, limit) {

  var s = String(this),

      last = null,

      lastIndex = null,

      a = [];

  limit = (limit === undefined ? -1 : limit) >>> 0;

  if (!limit) {

    return a;

  }

  if (r === undefined) {

    return [s];

  }

  if (Object.prototype.toString.call(r) === '[object RegExp]') {

    r = new RegExp(r.source, (r.multiline ? 'm' : '') + (r.ignoreCase ? 'i' : '') + 'g');

  } else {

    r = new RegExp(String(r).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), 'g');

  }

  if (s === '') {

    return r.test('') ? [] : [''];

  }

  try {

    s.replace(r, function (p) {

      function push(x) {

        a.push(x);

        limit -= 1;

        if (!limit) {

          throw a;

        }

      }

      var length = arguments.length,

          index = arguments[length - 2],

          i;

      if (lastIndex !== index && !(!p && (last === index || index === 0 || index === s.length))) {

        push(s.slice(last || 0, index));

        last = index + p.length;

        lastIndex = index;

        for (i = 1; i < length - 2; i += 1) {

          push(arguments[i]);

        }

      }

    });

  } catch (e) {

    if (e !== a) {

      throw e;

    }

  }

  if (lastIndex !== s.length && limit) {

    a.push(s.slice(last || 0));

  }

  return a;

}





}

jQuery(function($){



	$.fn.tkugp_outerHTML = function(){

 

	    // IE, Chrome & Safari will comply with the non-standard outerHTML, all others (FF) will have a fall-back for cloning

	    return (!this.length) ? this : (this[0].outerHTML || (

	      function(el){

	          var div = document.createElement('div');

	          div.appendChild(el.cloneNode(true));

	          var contents = div.innerHTML;

	          div = null;

	          return contents;

	    })(this[0]));

	 

	}



	//tags list for autocomplete

	var tkugp_tags_haystack = [];



	//category list for autocomplete

	var tkugp_category_haystack = [];



	function tkugp_get_item_id(item_id, html_id, html_class){



		var current_count = $('.'+html_class).length;



		if( current_count < 1 ){



			item_id = 0;

		

		} else {



			var id_exist = $('#'+html_class+item_id).length;



			if( id_exist > 0  ){

				item_id = parseInt(current_count) + 1;

				tkugp_get_item_id(item_id, html_id, html_class);

			} else {

				return item_id;

			}



		}



		return item_id;

	}

	function tkugp_flash_element(obj){

		  

		  // do fading 3 times
		  for(i=0;i<3;i++) {
		    obj.fadeTo('slow', 0.3).fadeTo('slow', 1.0);
		  }

		
		  
	}		


$(document).on('click', '#tkugp_add_category_item',function(e){
		
		e.preventDefault();	

		var ret = false;
		$('.tkugp_new_category_item').each(function(index, el) {

			var thisID = $(this).attr('id').replace('tkugp_new_category_item_','');
			var title = $('#tkugp_category_item_title_'+thisID).val();
			var tag = $('#tkugp_category_item_tags_list_'+ID).html();
			
			if( title == '' ){
				alert('Please enter Title for previous category.');
				tkugp_flash_element($(this));
				ret = true;
				return false;
			}

			if( tag == '' ){

				alert('Please enter atleast one tag for previous category.');
				tkugp_flash_element($(this));
				ret = true;
				return false;
			}

		});

		if( ret )
			return false;

		var new_category_item = '';
		var item_id = $('#tkgup_category_item_count').val() || 0 ;
		var ID = tkugp_get_item_id( item_id, 'tkugp_new_category_item_', 'tkugp_new_category_item');

		new_category_item +='<div class="tkugp_new_category_item" id="tkugp_new_category_item_'+ID+'">';
		new_category_item +='<div class="tkugp_handlediv" title="Click to toggle"><br></div>';
		new_category_item +='<h3 class="tkugp_hndle ui-sortable-handle"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><span>Category item</span></h3>';
		new_category_item +='<div class="inside">';
		new_category_item +='<div class="form-field">';
		new_category_item +='<label>Title</label>';
		new_category_item +='<input type="text" value="" id="tkugp_category_item_title_'+ID+'" name="tkugp_category_item['+ID+'][title]" />';
		new_category_item +='</div>';
		new_category_item +='<div>';
		new_category_item +='<label>Add Tag</label>';
		new_category_item +='<input type="text" value="" class="tkugp_category_item_add_tag" id="tkugp_category_item_add_tag_'+ID+'" name="tkugp_category_item_add_tag['+ID+'][tag]" />';
		new_category_item +='<p class="description">Use "Enter" to Add Tags</p>';
		new_category_item +='</div>';
		new_category_item +='<div class="form-field">';
		new_category_item +='<span class="tkugp_added_tags_title">Added Tags List</span>';
		new_category_item +='<div id="tkugp_category_item_tags_list_'+ID+'" class="tkugp_category_item_tags_list"></div>';
		new_category_item +='</div>';

		new_category_item += '<div class="tkugp_alignright"><input type="button" id="tkugp_category_item_del_'+ID+'" class="tkugp_category_item_del button button-secondary" value="Delete Category"/></div>';
		new_category_item +='</div>';
		new_category_item +='</div>';

		$('#tkugp_category_item_wrap').prepend(new_category_item);

		var nextID = parseInt(ID) + 1;
		$('#tkgup_category_item_count').val(nextID)
	});	




$( "#tkugp_category_item_wrap" ).sortable();

function tkugp_tag_html(ID, tagid, tagname){

	var tag_html = '<span id="tkgup_categoryitem_tagitem_'+ID+'_'+tagid+'">';
	  	tag_html += '<a href="javascript:void(0);" class="ntdelbutton tkgup_categoryitem_tagitem_del" id="tkgup_categoryitem_tagitem_del_'+ID+'_'+tagid+'">X</a>&nbsp;'+tagname;
	  	tag_html += '<input type="hidden" name="tkugp_category_item['+ID+'][tag][]" value="'+tagid+'" /></span>';

	return tag_html;  	
}

function tkugp_assigntag_html(ID, key, value){
	var assign_tag = '';
	assign_tag ='<span class="tkugp_assign_tag" id="tkugp_assign_tag_'+ID+'_'+key+'"><input type="checkbox" value="'+key+'" name="tkugp_list_item['+ID+'][tag][]" />&nbsp;'+value+'</span>';
	return assign_tag;	
}


function tkugp_maybe_add_newtag(ID, tagid, tagname, type, catTitle, catID){

	var tag_html = tkugp_tag_html(ID, tagid, tagname);
	var tagitemfound = false
	$('.tkugp_new_category_item').each(function(index, el) {
		
		var $this = $(this);
		var thisID = $(this).attr('id').replace('tkugp_new_category_item_', '');
		if( $('#tkgup_categoryitem_tagitem_'+thisID+'_'+tagid).length > 0 ){
			tagitemfound = true;
		}
		
	});

	if( !tagitemfound ){

		$('#tkugp_category_item_tags_list_'+ID).append(tag_html);	
		
	} else {

		alert('This tag is already added to another category.');
		
	}

	//use by new list item
	if( $('#tkugp_categories_tags_list #tkugp_assign_tag_'+tagid).length < 1 ){
				
	  	///$('#tkugp_categories_tags_list').append('<span class="tkugp_assign_tag" id="tkugp_assign_tag_'+tagid+'">'+tagname+'</span>');
	  	var appendToTaglist = false
	 	$('#tkugp_categories_tags_list .tkugp_assign_tag_choice').each(function(indexTaglist, elTaglist) {
	 		if( $(this).attr('data-tkugpcatid') == catID ){
	 			$(this).append('<span class="tkugp_assign_tag" id="tkugp_assign_tag_'+tagid+'">'+tagname+'</span>');
	 			appendToTaglist = true;
	 		}
	 	});

	 	if( !appendToTaglist ){

	 		var assign_tags = '';
	 		assign_tags += '<div class="tkugp_assign_tag_choice" data-itemid="" data-tkugpcattitle="'+catTitle+'" data-tkugpcatid="'+catID+'">';
			assign_tags += '<span class="tkugp_assign_tag" id="tkugp_assign_tag_'+tagid+'">'+tagname+'</span>';		
			assign_tags += '</div>';
			$('#tkugp_categories_tags_list').append(assign_tags);		
	 	}
	 }

	//maybe add newtag to existed list item
	var newtag = tkugp_assigntag_html(ID, tagid, tagname);
	$('.tkugp_list_item').each(function(itemID, el) {

		var found = false;
		var $this = $(this);	
		$this.find('.tkugp_assign_tag').each(function(index, el) {
			
			var pieces = $(this).attr('id').replace('tkugp_assign_tag_', '');
			pieces = pieces.split('_');
			var assignid = pieces[1];
			if( assignid == tagid){
				found = true;
			}

		});

		if( !found ){

			$this.find('#category_item_tag_choice_'+itemID+'_'+catID).append(newtag);	
		
			if( $this.find('#category_item_tag_choice_'+itemID+'_'+catID).length > 0  ){

				$this.find('#category_item_tag_choice_'+itemID+'_'+catID).append(newtag);	
		
			} else {

				var assign_tags = '';
				assign_tags += '<div id="category_item_tag_choice_'+itemID+'_'+catID+'">';
				assign_tags += '<h5 class="category_item_tags_title">'+catTitle+'</h5>';
				assign_tags+= newtag;
				assign_tags +='</div>';	
				$this.find('.tkugp_assign_tags_list').append(assign_tags);
			}



		}

	});

}



	 /* remove category item */
	 $(document).on('click', '.tkugp_category_item_del',function(event){

	 	event.preventDefault();
	 	var $this = $(this);
	  	var ID = $this.attr('id').replace('tkugp_category_item_del_', '');
	  	$('#tkugp_new_category_item_'+ID).remove();
	  	$('.tkugp_list_item').each(function(itemIndex, item) {
	  		
	  		$(this).find('#category_item_tag_choice_'+itemIndex+'_'+ID).remove();
	  	});

	 });



	 /* remove tag */

	 $(document).on('click', '.tkgup_categoryitem_tagitem_del',function(event){

	 	event.preventDefault();
	 	var $this = $(this);
	  	var ID = $this.attr('id').replace('tkgup_categoryitem_tagitem_del_', '');
	  	var pieces = ID.split('_');
	  	ID = pieces[0];
	  	var tagid = pieces[1];
	  	$('#tkgup_categoryitem_tagitem_'+ID+'_'+tagid).remove();
	  	$('.tkugp_assign_tag').each(function(index, el) {
	  		var pieces = $(this).attr('id').replace('tkugp_assign_tag_', '');
	  		pieces = pieces.split('_');
	  		var assignid = pieces[1];
	  		if( assignid == tagid){
	  			$(this).remove();
	  		}
	  	});

	 });



	$(document).on('click', '.tkugp_list_item .tkugp_handlediv, .tkugp_list_item .tkugp_handlediv', function(e){
		
		$(this).closest('.tkugp_list_item').toggleClass('closed');

	});	



	$(document).on('click', '.tkugp_new_category_item .tkugp_handlediv, .tkugp_new_category_item .tkugp_handlediv', function(e){
		
		$(this).closest('.tkugp_new_category_item').toggleClass('closed');

	});	





	$(document).on('click','#tkugp-addnew-button', function(e){

		e.preventDefault();

		var ret = false;
		$('.tkugp_list_item').each(function(index, el) {
			var thisID = $(this).attr('id').replace('tkugp_list_item_','');
			var title = $('#tkugp_list_item_title_'+thisID).val();
			var tag = false;
			
			$(this).find('.tkugp_assign_tags_list .tkugp_assign_tag input').each(function(index, el) {
				
				var checked = $(this).prop('checked');
				if( checked ){
					tag = true;
				}
			});

			if( title == '' ){
				alert('Please enter Title for previous list Item.');
				tkugp_flash_element($(this));
				ret = true;
				return false;
			}

			if( !tag ){
				alert('Please assign atleast one tag for previous list Item.');
				tkugp_flash_element($(this));
				ret = true;
				return false;
			}

		});

		if( ret )
			return false;

		var item_html;
		var item_id = $('#tkgup_list_item_count').val() || 0;
		var ID = tkugp_get_item_id( item_id, 'tkugp_list_item_', 'tkugp_list_item');

		var assign_favrt = '';
		assign_favrt += '<span><input type="radio"  name="tkugp_list_item['+ID+'][favrt]" value="yes" /> Yes</span>';
		assign_favrt += '<span><input type="radio"  name="tkugp_list_item['+ID+'][favrt]" value="no" /> No</span>';


		var assign_tags = '';
		$('#tkugp_categories_tags_list .tkugp_assign_tag_choice').each(function(tags_choicek, el1) {


			assign_tags += '<div id="category_item_tag_choice_'+ID+'_'+tags_choicek+'">';
			assign_tags += '<h5 class="category_item_tags_title">'+$(this).attr('data-tkugpcattitle')+'</h5>';
			
			$(this).find('.tkugp_assign_tag').each(function(index, el) {
		
				var value = $(this).text();
				var key = $(this).attr('id').replace('tkugp_assign_tag_', '');
				assign_tags +='<span class="tkugp_assign_tag" id="tkugp_assign_tag_'+ID+'_'+key+'"><input type="checkbox" value="'+key+'" name="tkugp_list_item['+ID+'][tag][]" />&nbsp;'+value+'</span>';
			});

			assign_tags += '</div>';
		});

		item_html = '<div id="tkugp_list_item_'+ID+'" class="postbox tkugp_list_item">';

		item_html += '<div class="tkugp_handlediv" title="Click to toggle"><br></div><h3 class="tkugp_hndle hndle"><span>List Item</span></h3>';

		item_html += '<div class="inside postbox">';

		item_html += '<p>Add New List Item</p>';

		item_html += '<p>';

		item_html += '<label for="tkugp_list_item_title_'+ID+'">Title</label>';

		item_html += '<input type="text" name="tkugp_list_item['+ID+'][title]" class="tkugp_list_item_title" id="tkugp_list_item_title_'+ID+'" value="">';

		item_html += '</p>';	

		item_html += '<p>';

		item_html += '<label for="tkugp_list_item_content_'+ID+'">Content</label>';

		item_html += '<textarea name="tkugp_list_item['+ID+'][content]" class="tkugp_list_item_content" id="tkugp_list_item_content_'+ID+'"></textarea>';

		item_html += '</p>';	

		item_html += '<p>';

		item_html += '<label for="tkugp_list_item_image_'+ID+'">Image</label>';

		item_html += '<img id="tkugp_list_item_preview_'+ID+'" class="tkugp_list_item_preview" src="" alt="Image Preview" />';

		item_html += '<input type="text" name="tkugp_list_item['+ID+'][image]" class="tkugp_list_item_image" id="tkugp_list_item_image_'+ID+'" value="">';

		item_html += '<input type="button" name="tkugp_list_item_uploadimage_'+ID+'" class="button button-secondary tkugp_list_item_uploadimage" id="tkugp_list_item_uploadimage_'+ID+'" value="Upload Image">';

		item_html += '</p>';
		item_html += '<p class="tkugp_list_item_link_wrap">';
		item_html += '<p><label>Link Label:</label><input type="text"  class="tkugp_list_item_link" id="tkugp_list_item_link_'+ID+'" name="tkugp_list_item['+ID+'][link][title]" value="" /></p>';
		item_html += '<p><label>Link:</label><input type="text"  class="tkugp_list_item_link" id="tkugp_list_item_link_'+ID+'" name="tkugp_list_item['+ID+'][link][url]" value="" /></p>';
		item_html += '</p>';

		item_html += '<div><label>Assign Tags:</label><br><div class="tkugp_assign_tags_list">'+assign_tags+'</div></div>';

		item_html += '<div><label>Author Favorite:</label><br><div class="tkugp_assign_author_favrt">'+assign_favrt+'</div></div>';


		item_html += '<p class="tkugp_remove_item_wrap"><input type="button" class="button button-secondary tkugp_remove_item" id="tkugp_remove_item_'+ID+'" value="Remove Item" /></p>';

		item_html += '</div>';

		item_html += '</div>';


		$('.tkugp_list_item').addClass('closed');
		$('#tkugp_categoryitem_metabox').addClass('closed');
		$('#tkugp_addnew_button_metabox').before(item_html).hide().fadeIn();


		var nextID = parseInt(ID) + 1;
		$('#tkgup_list_item_count').val(nextID)

                $('.meta-box-sortables').sortable("refresh");
	});

	

	function tkugp_get_sub_id(item_id, sub_id, html_id, html_class){



		var current_count = $('#tkugp_list_item_'+item_id+' .'+html_class).length;



		if( current_count < 1 ){



			sub_id = 0;

		

		} else {



			var id_exist = $('#'+html_id+item_id+'_'+sub_id).length;



			if( id_exist > 0  ){

				sub_id = parseInt(current_count) + 1;

				tkugp_get_sub_id(sub_id, sub_id, html_id, html_class);

			} else {

				return sub_id;

			}



		}



		return sub_id;

	}

	



	/* Remove List Item */

	$(document).on('click', '.tkugp_remove_item', function(e){



		e.preventDefault();



		$(this).closest('.postbox').fadeOut().remove();

		

		var current_count = $('.tkugp_list_item').length;

		if( current_count < 1 ){

			var item_id = 0;

		} else {

			var item_id = current_count;

		}



		$('#tkgup_list_item_count').val(item_id);



	});





	/* Upload Image */

	 var tkugp_mediaUploader;

	 var tkupg_thismediaUploader;



	  $(document).on('click', '.tkugp_list_item_uploadimage', function(e) {

	    e.preventDefault();

	    var tkupg_thismediaUploader = $(this);

	    //get the id for current item

	    var ID = tkupg_thismediaUploader.attr('id').replace('tkugp_list_item_uploadimage_', '');



	    // If the uploader object has already been created, reopen the dialog

	    /*  if (tkugp_mediaUploader) {

	      tkugp_mediaUploader.open();

	      return;

	    }*/

	    // Extend the wp.media object

	    tkugp_mediaUploader = wp.media.frames.file_frame = wp.media({

	      title: 'Choose Image',

	      button: {

	      text: 'Choose Image'

	    }, multiple: false });



	    // When a file is selected, grab the URL and set it as the text field's value

	    tkugp_mediaUploader.on('select', function() {

	      attachment = tkugp_mediaUploader.state().get('selection').first().toJSON();

	      var ID = tkupg_thismediaUploader.attr('id').replace('tkugp_list_item_uploadimage_', '');

	      



	      $('#tkugp_list_item_image_'+ID).val(attachment.url);

	      $('#tkugp_list_item_preview_'+ID).attr('src', attachment.url);

	      if( $('#tkugp_list_item_imgdel_'+ID ).length < 1 ){	

	      	$('#tkugp_list_item_preview_'+ID).after('<span id="tkugp_list_item_imgdel_'+ID+'" title="Delete this Image" class="tkugp_list_item_imgdel">Delete Image</span>');

	      }

	      	

	    });

	    // Open the uploader dialog

	    tkugp_mediaUploader.open();



	  });

	

	/* Remove item image */

	$(document).on('click', '.tkugp_list_item_imgdel', function(event) {

		event.preventDefault();

		

		var ID = $(this).attr('id').replace('tkugp_list_item_imgdel_', '');

		$('#tkugp_list_item_image_'+ID).val('');

		 $('#tkugp_list_item_preview_'+ID).remove();

		 $(this).remove();



	});


	/* Hover Remove Option */
	$(document).on({
	    mouseenter: function (event) {
	        //stuff to do on mouse enter

	        event.preventDefault();

		 	var $this = $(this);
		  	var ID = $this.attr('id').replace('tkugp_category_item_del_', '');
		  	$('#tkugp_new_category_item_'+ID).addClass('tkuugp_option_type_del');

	    },
	    mouseleave: function (event) {
	        //stuff to do on mouse leave

	        event.preventDefault();

		 	var $this = $(this);
		  	var ID = $this.attr('id').replace('tkugp_category_item_del_', '');
		  	$('#tkugp_new_category_item_'+ID).removeClass('tkuugp_option_type_del');
		}

	    }, ".tkugp_category_item_del"); 

	 

	//tags array	
	$('#tkugp_tags_all li').each(function(index, el) {
		var tagid = $(this).attr('id').replace('tkgup_posttag_', '');
		var tagname = $(this).text();
		tkugp_tags_haystack.push(tagname);
	}); 

	

	var tkugp_list_item = false;



	if( $('.tkugp_list_item').length > 0 ){

		$('.tkugp_list_item').each(function(index, el) {

			

			var outer_html = $(this).html();

			var ID = $(this).attr('id').replace('tkugp_list_item_','');



				outer_html = '<div id="tkugp_list_item_'+ID+'" class="postbox tkugp_list_item closed">'+outer_html+'</div>';		

			$('#tkugp_addnew_button_metabox').before(outer_html).hide().fadeIn();

			$(this).remove();

			tkugp_list_item = true;



			if( tkugp_list_item ){

				$('.tkugp_post_settings').show();

			}



		}); 

	}	


$(document).on('keyup keypress', 'input.tkugp_category_item_add_tag', function(e){


		var code = e.keyCode || e.which;

  		if (code == 13) { 
    		e.preventDefault();
    		
    	var $this = $(this);
	  	var ID = $this.attr('id').replace('tkugp_category_item_add_tag_', '');
	  	var tag = $this.val();
	  		tag = tag.trim();
	  	var post = $('#post_ID').val();
	  	var cattitle = $('#tkugp_category_item_title_'+ID).val() || '';
	  	var catID = ID;
	  	
	  	if( tag == '' )
	  		return false;

	  	

	  	var ret = false;
	  	$this.prop('disabled', true);
	  	var break_loop = false ;

	  	$('#tkugp_tags_all li').each(function(index, el) {

			var tagid = $(this).attr('id').replace('tkgup_posttag_', '');
			var tagname = $(this).text();
				tagname = tagname.trim();
				
			if( tag.toLowerCase() == tagname.toLowerCase() ){

			
				
				if( !break_loop ){	
		  			tkugp_maybe_add_newtag(ID, tagid, tagname, 'loop', cattitle, catID);
		  			
		  			break_loop = true;

		  			ret = true;

		  			$this.prop('disabled', false);
		  			$this.val('');

		  			return false;
		  		}

			}

	
			if( break_loop )
				return false;
		}); 





	  	if( ret )
	  		return false;


	  	$.ajax({

	  		url: ajaxurl,
	  		type: 'POST',
	  		dataType: 'json',
	  		data: {action: 'tkugp_admin_addtag', postid:post, tagname:tag},
	  	})

	  	.done(function(response){

	  		$this.prop('disabled', false);
	  		$this.val('');


	  		if( response.status == 1 ){	
	  			
	  			//insert new tag
	  			tkugp_tags_haystack.push(tag);
	  			tkugp_maybe_add_newtag(ID, response.tagid, tag, cattitle, catID);

	  		} else if( response.status == 2 ) {

	  			//insert existed tag
	  			tkugp_tags_haystack.push(tag);
	  			tkugp_maybe_add_newtag(ID, response.tagid, tag, cattitle, catID);
	  		}	



	  	});

	  	
    		return false;
  		}/* code == 13 */

	});



$(document).on('keyup keypress', 'form#post input', function(e) {

	var code = e.keyCode || e.which;

	if (code == 13 && !$(this).is('textarea') ) { 

		e.preventDefault();

		return false;

	}




});



});/* dom loaded */