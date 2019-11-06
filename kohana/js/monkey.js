function send_info() {
	var pdata = {
		'social_site_name':             '',
		'social_site_category':         '',
		'social_site_url':              '',
		'social_site_desc':             '',
		'social_site_alexa_rank':       '',
		'social_site_compete_rank':     '',
		'social_site_compete_volume':   '',
		'social_site_majestic_domains': '',
		'social_site_majestic_links':   '',
		'social_knowem_path':           document.location.pathname,
		'tags[]':                         []
	};
	
	pdata.social_site_name = $('h1').text();
	
	$("span.titleTag + p").each(function(idx) {
		if(idx == 0) {
			pdata.social_site_category = $(this).text();
		} else if(idx == 1) {
			pdata.social_site_url = $(this).text();
		} else if(idx == 2) {
			pdata.social_site_desc = $(this).text();
		}
	});
	
	$('div.graphInnerLarge').each(function(idx) {
		if(idx == 0) {
			pdata.social_site_alexa_rank = parseInt($(this).css('width'));
		} else if(idx == 1) {
			pdata.social_site_compete_rank = parseInt($(this).css('width'));
		} else if(idx == 2) {
			pdata.social_site_compete_volume = parseInt($(this).css('width'));
		} else if(idx == 3) {
			pdata.social_site_majestic_domains = parseInt($(this).css('width'));
		} else if(idx == 4) {
			pdata.social_site_majestic_links = parseInt($(this).css('width'));
		}
	});
	
	$('a[href*="tags"]').each(function() {
		pdata['tags[]'].push($(this).text());
	});
	
	//console.debug(decodeURIComponent($.param(pdata)));
	
	$.ajax({
		url: 'http://favsub.com/monkey',
		dataType: 'jsonp',
		data: pdata,
		success: function(rdata) {
			if(rdata.next_url != 'nope')
			{
				setTimeout( "window.location.href = '"+rdata.next_url+"'", 5*1000 );
			}
		}
	});
	
}

send_info();