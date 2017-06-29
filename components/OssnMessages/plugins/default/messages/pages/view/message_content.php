<?php
	foreach ($params['data'] as $key => $data) {
		if ($params["page"] == "group") {
			if ($data->message_from == ossn_loggedin_user()->guid) {
				echo ossn_plugin_view('messages/pages/view/sender', $data);
			} else {
				echo ossn_plugin_view('messages/pages/view/recipient', $data);
			}	
		} else {
			if ($data->message_from == ossn_loggedin_user()->guid) {
				echo ossn_plugin_view('messages/pages/view/sender', $data);
			} else {
				echo ossn_plugin_view('messages/pages/view/recipient', $data);
			}
		}

		
	}
?>
