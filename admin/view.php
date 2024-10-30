<?php settings_errors(); 
?>
<div class="wrap">
    <h2>Localize Integration Settings</h2>

    <p>Translate your WordPress site into multiple languages in minutes.</p>
    <p>To use this plugin, login to your <a target="_blank" href="https://app.localizejs.com/project">Localize Dashboard</a> to get your Project Key.</p>
    <p>Don't have an account? <a target="_blank" href="https://localizejs.com/signup">Signup for a Free Trial</a></p>

    <form method="post" action="options.php">
        <?php settings_fields( 'localize-settings-group' ); ?>
        <?php do_settings_sections( 'localize-settings-group' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Project Key</th>
                <td><input type="text" name="project_key" placeholder="Enter Project Key" value="<?php echo esc_attr( get_option('project_key') ); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Select SEO Options </th>
                <td>
                    <?php $url_options = esc_attr( get_option('localizejs_settings_url_options') ); 
                    $allow_inline_break_tags = esc_attr( get_option('localizejs_settings_allow_inline_break_tags') ); 
					$auto_approve = esc_attr( get_option('localizejs_settings_auto_approve') ); 
					$retranslate_on_new_phrases = get_option('localizejs_settings_retranslate_on_new_phrases'); 
					?>
                    <p><label for="options_none"><input type="radio" <?php echo ($url_options==0)?'checked="checked"':"" ?> id="options_none" name="localizejs_settings_url_options" value="0" class="defaultState">SEO Disabled - Add Localize to your site without one of the following SEO options.</label></p>
                    <p><label for="options_subdirectory"><input type="radio" <?php echo ($url_options==1)?'checked="checked"':"" ?> id="options_subdirectory" name="localizejs_settings_url_options" value="1" class="defaultState">Subdirectory - Add Localize to your site using language-specific subdirectories (e.g. https://example.com/es/).</label></p>
                    <p><label for="options_subdomain"><input type="radio" <?php echo ($url_options==2)?'checked="checked"':"" ?> id="options_subdomain" name="localizejs_settings_url_options" value="2" class="defaultState">Subdomain - Add Localize to your site using language-specific subdomains (e.g. https://es.example.com/).</label></p>
                </td>
            </tr>
            <tr valign="top">
            	<th scope="row">Select Initialization Options</th>
            	<td>
            		<p>
            			<input type="checkbox" id="localizejs_settings_allow_inline_break_tags" name="localizejs_settings_allow_inline_break_tags" value="true" <?php echo ($allow_inline_break_tags==true)?'checked="checked"':"" ?>  />
            			<label for="localizejs_settings_allow_inline_break_tags">allowInlineBreakTags - If checked, whenever you have a &lt;BR&gt; element in your content,
            			Localize will not break up the parent element's content.
            			</label>
            		</p>
            		<p>
            			<input type="checkbox" id="localizejs_settings_auto_approve" name="localizejs_settings_auto_approve" value="true" <?php echo ($auto_approve==true)?'checked="checked"':"" ?>  />
            			<label for="localizejs_settings_auto_approve">autoApprove - If checked and you have machine translations enabled, any new phrases found on
            			your website will be automatically translated.
            			</label>
            		</p>
            		<p>
            			<input type="checkbox" id="localizejs_settings_retranslate_on_new_phrases" name="localizejs_settings_retranslate_on_new_phrases" value="true" <?php echo ($retranslate_on_new_phrases=='true')?'checked="checked"':"" ?>  />
            			<label for="localizejs_settings_retranslate_on_new_phrases">retranslateOnNewPhrases - If checked, Localize will automatically update your web page with newly translated content.
            			</label>
            		</p>
            	</td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>

    <a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/localizejs?rate=5#postform">
        <?php _e( 'Love Localize? Help spread the word by rating us 5* on WordPress.org', 'localizejs' ); ?>
    </a>
</div>