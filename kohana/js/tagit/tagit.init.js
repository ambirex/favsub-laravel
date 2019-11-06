$(function(){
	$(".tagit").tagit({
		tagSource: fav_sub_tags,
		select: true,
		triggerKeys: ['enter', 'comma', 'tab'],
		minLength: 3,
	});
	
	$("button.tag-add").click(function() {
		$(".tagit").tagit("add", $(this).text());
		$(this).remove();
		if($("button.tag-add").length == 0) {
			$("button.tag-add-all").hide();
		}
	});
	
	$("button.tag-add-all").click(function() {
		$("button.tag-add").each(function(idx, el) {
			$(el).click();
		});
	});
	
	$("button.diffbot-replace-title").click(function() {
		var diffbot_title = $("#diffbot-title").text();
		$("#favsub-form-title").val(diffbot_title);
	});
	
	$("button.diffbot-replace-url").click(function() {
		var diffbot_url = $("#diffbot-url").text();
		$("#favsub-form-url").val(diffbot_url);
	});
});