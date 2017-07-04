                <textarea class="input_message" name="message" placeholder="<?php echo ossn_print('message:placeholder'); ?>"></textarea>
                <?php if ($params['page'] == "group") {  ?> 
                    <input type="hidden" name="type" value="group"/>
                <?php } else { ?> 
                    <input type="hidden" name="type" value="individual"/>
                <?php } ?>
                <input type="hidden" class="group_message_last_id" name="last_id" value=""/>
                <input type="hidden" name="to" value="<?php echo $params['to_guid']; ?>"/>
                
                <input type="hidden" class="spam_check" value="true"/>
                
                <div class="controls">
                    <input type="submit" class="btn btn-primary" value="<?php echo ossn_print('send'); ?>" />
                    <div class="sqmessage ossn-comment-attach-photo" onclick="Ossn.Clk('#ossn-comment-image-file-<?php echo $params['to_guid']; ?>');"><i class="fa fa-camera"></i></div>
                    <?php 
                    //this form should be in OssnMessages/forms 
                    echo ossn_plugin_view('input/security_token'); 
                    ?>
                    <div class="ossn-loading ossn-hidden"></div>                               
                </div>

                <input type="file" name="file" style="display:none;" id="ossn-comment-image-file-<?php echo $params['to_guid']; ?>"/>
                <div class="image-data"></div>