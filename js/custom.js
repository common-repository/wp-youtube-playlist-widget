/**
 * Package: wp-youtube-playlist-widget
 * Author : Srikanth Lavudia
 * Description: This is the custom JS that generates the youtube link and dynamically creates & loads the video
 * to the JQuery UI dialog window.
*/
var $j = jQuery.noConflict();
$j(function(){
	$j('.play').live('click', function(e){
		var id = $j(this).data('video_id');
		var video_url = 'https://www.youtube.com/embed/'+id;
		$j('<div id="yuotube_dialog"><iframe class="youtube_embed" width="560" height="315" src="" frameborder="0" allowfullscreen></iframe></div>').dialog({
			width: 600,
			modal: true,
			position: { my: "center", at: "center", of: window },
			title: $j(this).attr('title'),
			close: function(event, ui) {
				//$j('.youtube_embed').attr('src', '');
				$j(this).dialog('destroy').remove()
			}
		});
		$j('.youtube_embed').attr('src', video_url);
		e.preventDefault();
	});
});