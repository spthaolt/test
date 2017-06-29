                <textarea class="input_message" name="message" placeholder="<?php echo ossn_print('message:placeholder'); ?>"></textarea>
                <?php 
                    if ($params['page'] == "group") { ?>
                        <input type="hidden" name="to" value="<?php echo $params['group']->guid; ?>"/>
                        <input type="hidden" name="type" value="group"/>
                <?php } else { ?>
                        <input type="hidden" name="to" value="<?php echo $params['user']->guid; ?>"/>
                <?php } ?>

                <div class="controls">
                    <?php 
                    //this form should be in OssnMessages/forms 
                    echo ossn_plugin_view('input/security_token'); 
                    ?>
                    <div class="ossn-loading ossn-hidden"></div>                               
                    <input type="submit" class="btn btn-primary" value="<?php echo ossn_print('send'); ?>"/>
                </div>