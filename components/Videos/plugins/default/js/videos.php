Ossn.videoProgress = function($token) {
	Ossn.PostRequest({
		url: Ossn.site_url + 'video/progress/' + $token,
		callback: function(callback) {
			$('.progress-bar-conversion').css('width', callback + '%');
			$('.progress-bar-conversion').find('span').html(callback + '%');
		},
	});
}
Ossn.videoRound = function (value, precision, mode) {

  var m, f, isHalf, sgn; // helper variables
  precision |= 0; // making sure precision is integer
  m = Math.pow(10, precision);
  value *= m;
  sgn = (value > 0) | -(value < 0); // sign of the number
  isHalf = value % 1 === 0.5 * sgn;
  f = Math.floor(value);

  if (isHalf) {
    switch (mode) {
      case 'PHP_ROUND_HALF_DOWN':
        value = f + (sgn < 0); // rounds .5 toward zero
        break;
      case 'PHP_ROUND_HALF_EVEN':
        value = f + (f % 2 * sgn); // rouds .5 towards the next even integer
        break;
      case 'PHP_ROUND_HALF_ODD':
        value = f + !(f % 2); // rounds .5 towards the next odd integer
        break;
      default:
        value = f + (sgn > 0); // rounds .5 away from zero
    }
  }

  return (isHalf ? value : Math.round(value)) / m;
};
$(document).ready(function() {
	$('video').mediaelementplayer({
		success: function(player, node) {
			$('#' + node.id + '-mode').html('mode: ' + player.pluginType);
		}
	});
	$url = Ossn.site_url + 'action/video/add';
	Ossn.ajaxRequest({
		url: $url,
		action: true,
		xhr: function() {
			var xhr = new window.XMLHttpRequest();
			//Upload progress
			xhr.upload.addEventListener("progress", function(evt) {
				if (evt.lengthComputable) {
					var percentComplete = evt.loaded / evt.total;
                    $percentage = Ossn.videoRound((percentComplete*100));
					$('.video-upload').show();
					$('.video-upload').find('.progress').show();
                    $('.video-upload').find('.progress-bar').css('width', $percentage + '%');
                    $('.video-upload').find('.progress-bar span').html($percentage + '%');
				}
			}, false);
			return xhr;
		},
		containMedia: true,
		form: '#video-add',

		beforeSend: function(request) {
			$('.video-submit').hide();
			$('#video-add').find('.conversion').show();
			$('#video-add').find('.conversion').find('.progress').show();
		},
		callback: function(callback) {
			if (callback['success']) {
				Ossn.trigger_message(callback['success']);
				if (callback['data']['url']) {
					Ossn.redirect(callback['data']['url']);
				}
			}
			if (callback['error']) {
				Ossn.trigger_message(callback['error'], 'error');
			}
		}
	});
	$token = $('#video-add').find('input[name="vtk"]').val();
	setInterval(function() {
		Ossn.videoProgress($token);
	}, 3000);
});