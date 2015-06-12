(function($,Contao){$(function(){
	var request = false,
		intervall = 0,
		toggle = false,
		titleData = '',
		window_focus = true,
		title = $('title').html(),
		artistRequest = false,
		songRequest = false,
		messagesInterval = false,
		replaceElementWith = false,
		replaceInnerHTMLWith = false,
		aktiveSelector = false,
		limitOffset = 1,
		newWhishes = $('#newWhishes'),
		selectCount = $('.whish_count select'),
		firstWhish = (typeof $('#newWhishes')[0] != 'undefined' ? $('#newWhishes').children().eq(0).attr('id') : null);

	function ajaxFunctions(data) {
		var scrollRequest = false;
		data.find('a.granting').click(function(e){
			var link = $(this);
			e.preventDefault();

			$.ajax({
				type: "POST",
				url: "ajax.php",
				data: { toggleGrant: 1, whish: link.data('whish'), REQUEST_TOKEN: Contao.request_token },
				success: function(txt,status){
					var data;
					if(txt)
						link.html($($.parseJSON(txt).content));
				}
			});
		});

		$(window).scroll(function(){
			/*
			if(!scrollRequest && ($(window).scrollTop()+$(window).height()) >= Math.round(data.last().offset().top)) {
				var scrollFilter = $('.whish_filter .active');

				if(typeof scrollFilter[0] != 'undefined')
					scrollFilter = scrollFilter.data('filter');
				else scrollFilter = '';

				scrollRequest = $.ajax({
					type: "POST",
					url: "ajax.php",
					data: { getNewWhishes: 1, pageid: newWhishes.data('pageid'), filter: scrollFilter, count: selectCount.val(), limitOffset: (selectCount.val()*limitOffset), REQUEST_TOKEN: Contao.request_token },
					success: function(txt,status){
						data = $($.parseJSON(txt).content).insertAfter(newWhishes.children().last());
						scrollRequest = false;
						limitOffset++;
					}
				});
			}
				/**/
		});

		data.find('a.artistSong').click(function(e){
			var link = $(this),
				entryID = link.parents('[id^=whish_]').eq(0).data('artistsong');
			e.preventDefault();

			$.ajax({
				type: "POST",
				url: "ajax.php",
				data: { toggleArtistSong: 1, whish: link.data('whish'), REQUEST_TOKEN: Contao.request_token },
				success: function(txt,status){
					var data;
					if(txt)
						$('[data-artistsong="'+entryID+'"] a.artistSong').html($($.parseJSON(txt).content));
				}
			});
		});

		data.find('li').click(function(e){
			var outerHTML = false,
				toReplace = '',
				parentDiv = $(this).parents('[id^=whish_]').eq(0);
			if($(this).is('.artist,.song')) {
				e.stopPropagation();

				if(replaceElementWith) {
					replaceElementWith.html(replaceInnerHTMLWith);
					replaceElementWith = replaceInnerHTMLWith = false;
				}

				replaceElementWith = $(this);
				replaceInnerHTMLWith = replaceElementWith.html();

				outerHTML = replaceElementWith.children('span')[0].outerHTML;
				toReplace = replaceElementWith.contents().eq(1).text();

				replaceElementWith.html('');

				$(outerHTML).appendTo(replaceElementWith);
				$('<input type="text" data-typo="'+toReplace+'" name="corectTypo" value="'+toReplace+'">').appendTo(replaceElementWith);

				$(this).find('input').click(function(e){
					e.stopPropagation();
				}).keyup(function(e){
					var input = $(this);
					if(e.keyCode == '13') {
						e.preventDefault();
						replaceElementWith.html(replaceInnerHTMLWith.replace(input.data('typo'),input.val()));
						$.ajax({
							type: "POST",
							url: "ajax.php",
							data: { updateTypo: 1, type: replaceElementWith.data('type'), search: input.data('typo'), replace: input.val(), whish: parentDiv.data('whish'), REQUEST_TOKEN: Contao.request_token },
							success: function(txt,status){
								parentDiv.find('a.artistSong').html($($.parseJSON(txt).content));
							}
						});
						replaceElementWith = replaceInnerHTMLWith = false;
					}
				});
			}
		});
	}

	function toggleTitle() {
		if(toggle) {
			var interpret = titleData.find('li.artist').text().split(':'),
				song = titleData.find('li.song').text().split(':');

			$('title').html(interpret[1]+': '+song[1]);
		}
		else
			$('title').html(title);
		toggle = !toggle;
	} 

	function getNewMessages() {
		intervall++;

		if(titleData)
			toggleTitle();

		if(intervall < 30 && request)
			return;

		intervall = 0;
		
		if(request)
			request.abort();

		request = $.ajax({
			type: "POST",
			url: "ajax.php",
			data: { getNewWhishes: 1, pageid: newWhishes.data('pageid'), filter: newWhishes.data('filter'), count: (selectCount.val()*limitOffset), REQUEST_TOKEN: Contao.request_token },
			success: function(txt,status){
				var data = null,
					last = newWhishes.find('[id^=whish_]').first().prev();
				
				last.nextAll().remove();
				data = $($.parseJSON(txt).content).insertAfter(last);

				ajaxFunctions(data);
				if(data.eq(0).attr('id') != firstWhish) {
					titleData = data.eq(0);
				}
			}
		});
	}

	$(window).focus(function() {
	    $('title').html(title);
	    titleData = false;
		firstWhish = $('#newWhishes').children('div').eq(0).attr('id');
	});

	if(typeof newWhishes[0] != 'undefined'){
		getNewMessages();
		messagesInterval = setInterval(getNewMessages,2000);
		$('.whish_filter li').click(function(){
			var filter = $(this),
				filterWrapper = newWhishes.find('[id^=whish_]').first().prev();

			if(typeof filterWrapper[0] === 'undefined')
				filterWrapper = newWhishes.children().last();

			$('.whish_filter .active').removeClass('active');
			filter.addClass('active');
			newWhishes.data('filter',filter.data('filter'));

			$.ajax({
				type: "POST",
				url: "ajax.php",
				data: { getNewWhishes: 1, pageid: newWhishes.data('pageid'), 'filter': newWhishes.data('filter'), count: (selectCount.val()*limitOffset), REQUEST_TOKEN: Contao.request_token },
				success: function(txt,status){
					filterWrapper.nextAll().remove();
					data = $($.parseJSON(txt).content).insertAfter(filterWrapper);
					ajaxFunctions(data);
				}
			});
		});

		selectCount.change(function(){
			var select = $(this),
				wrapper = newWhishes.find('[id^=whish_]').first().prev();

			if(typeof wrapper[0] === 'undefined')
				wrapper = newWhishes.children().last();

			$.ajax({
				type: "POST",
				url: "ajax.php",
				data: { getNewWhishes: 1, pageid: newWhishes.data('pageid'), count: (selectCount.val()*limitOffset), REQUEST_TOKEN: Contao.request_token },
				success: function(txt,status){
					wrapper.nextAll().remove();
					data = $($.parseJSON(txt).content).insertAfter(wrapper);
					ajaxFunctions(data);
				}
			});
		});
	}

	$(document.body).click(function(){
		$('body > .mod_artist,body > .mod_songs').remove();
		aktiveSelector = false;
		if(replaceElementWith) {
			replaceElementWith.html(replaceInnerHTMLWith);
			replaceElementWith = replaceInnerHTMLWith = false;
		}
	});

	$(window).keydown(function(event){
		if(event.keyCode == 13 && aktiveSelector) {
			event.preventDefault();
			return false;
		}
	});

	var li = false,
		interpret = -1,
		interpretData = false,
		interpretDirektion = 'down';

	function loadSelector(input,e,classes) {
		var selectorData = arguments[3]||{};

		if(input.val() == ''){
			$('body > '+classes).remove();
			aktiveSelector = false;
		}
		switch(e.keyCode) {
			case 13:
				input.val(li.eq(interpret).text());
				e.preventDefault();
				if(interpretData)
					interpretData.remove();
			break;
			case 40:
				/* DOWN */
				if(!li) break;

				interpret++;
				if(interpret>(li.length-1))
					interpret = 0;

				li.removeClass('active').eq(interpret).addClass('active');
			break;
			case 38:
				/* UP */
				if(!li) break;

				interpret--;
				if(interpret < 0)
					interpret = (li.length-1);

				li.removeClass('active').eq(interpret).addClass('active');
			break;
			default:


				if(artistRequest)
					artistRequest.abort();

				if(input.val() != '') {
					artistRequest = $.ajax({
						type: "POST",
						url: "ajax.php",
						data: $.extend(selectorData,{ value: input.val(), REQUEST_TOKEN: Contao.request_token }),
						success: function(txt,status){

							$('body > '+classes).remove();

							interpretData = $($.parseJSON(txt).content).appendTo('body').css({
								top: input.offset().top + input.height() + 10,
								left: input.offset().left,
								width: input.width() - 14
							});

							li = interpretData.find('li');

							li.click(function(){
								input.val($(this).text());
								interpretData.remove();
							});

							interpretData.click(function(e){
								e.preventDefault();
								e.stopPropagation();
							});
							aktiveSelector = true;
						}
					});
				}
			break;
		}
	}

	$('[name="Interpret"]').focus(function(){
		$(this).attr('autocomplete', 'off');
	}).keyup(function(e){
		loadSelector($(this),e,'.mod_artist',{getArtists: 1});
	});
	$('[name="Lied"]').focus(function(){
		$(this).attr('autocomplete', 'off');
	}).keyup(function(e){
		loadSelector($(this),e,'.mod_songs',{getSongs: 1});
	});

});})(jQuery,Contao);
