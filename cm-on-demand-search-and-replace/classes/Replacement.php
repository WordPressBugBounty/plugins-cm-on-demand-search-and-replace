<?php
class CMODSAR_Replacement {

	protected static $filePath	 = '';
	protected static $cssPath	 = '';
	protected static $jsPath	 = '';

	/**
	 * Adds the hooks
	 */
	public static function init() {
		self::$filePath	 = plugin_dir_url( __FILE__ );
		self::$cssPath	 = self::$filePath . 'assets/css/';
		self::$jsPath	 = self::$filePath . 'assets/js/';

		add_filter( 'cmodsar-settings-tabs-array', array( __CLASS__, 'addSettingsTabs' ) );
		add_filter( 'cmodsar-custom-settings-tab-content-1', array( __CLASS__, 'addSearchAndReplaceReplacementTabContent1' ) );
		add_filter( 'cmodsar-custom-settings-tab-content-2', array( __CLASS__, 'addSearchAndReplaceReplacementTabContent2' ) );
		add_filter( 'cmodsar-custom-settings-tab-content-3', array( __CLASS__, 'addSearchAndReplaceReplacementTabContent3' ) );
		add_filter( 'cmodsar-custom-settings-tab-content-4', array( __CLASS__, 'addSearchAndReplaceReplacementTabContent4' ) );

		add_action( 'cmodsar_save_options_after_on_save', array( __CLASS__, 'saveReplacement' ) );

		/*
		 * Search&replace in content
		 */
		add_action( 'the_content', array( __CLASS__, 'doCustomReplacement' ), 15000 );

		add_action( 'wp_ajax_cmodsar_add_replacement', array( __CLASS__, 'ajaxAddReplacement' ) );
		add_action( 'wp_ajax_cmodsar_delete_replacement', array( __CLASS__, 'ajaxDeleteReplacement' ) );
		add_action( 'wp_ajax_cmodsar_update_replacement', array( __CLASS__, 'ajaxUpdateReplacement' ) );
	}

	/**
	 * Add the new settings tabs
	 * @param array $settingsTabs
	 * @return type
	 */
	public static function addSettingsTabs( $settingsTabs ) {
		$settingsTabs[ '1' ] = 'Replacement Rules';
		$settingsTabs[ '2' ] = 'Settings';
		$settingsTabs[ '3' ] = 'Extensions';
		$settingsTabs[ '4' ] = 'Replacement Widget';
		return $settingsTabs;
	}

	/**
	 * @param array $content
	 * @return type
	 */
	public static function addSearchAndReplaceReplacementTabContent1( $content ) {
		ob_start();
		?>
		<div class="block">
			<h3>Replacement Rules</h3>
			<?php
			$repl = get_option( 'cmodsar_replacements', array() );
			self::outputReplacements( $repl, TRUE );			
			?>
		</div>
		<?php
		$content .= ob_get_clean();
		return $content;
	}
	
	public static function addSearchAndReplaceReplacementTabContent2( $content ) {
		ob_start();
		?>
		<div class="sblock" style="opacity:.5; pointer-events:none;">
			<div id="tabs-2" class="settings-tab" style=""><div class="cminds_settings_toggle_tabs cminds_settings_toggle-opened">Toggle All</div>        <div class="nblock" id="settings">
			                <h3 class="section-title"><span>Settings</span> <svg class="tab-arrow" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="#6BC07F">
                        <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z"></path>
                    </svg></h3>
						                <table class="floated-form-table form-table">
					        <tbody><tr valign="top" class=" cmodsar_search_and_replaceItemsPerPageSetting wrapper-select">
            <th scope="row">
                <div>Search &amp; Replace edit page display</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Choose between displaying all items on a single page or setting the number of items to see on a page."></div></th>
            <td class="field-select">
				<div><select name="cmodsar_search_and_replaceItemsPerPageSetting"><option value="showall" selected="selected">Show all items on a single page</option><option value="paginate">Paginate (set number of items to show on a page)</option></select><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Choose between displaying all items on a single page or setting the number of items to see on a page.</div></div>            </td>
            
        </tr>		        
		        <tr valign="top" class=" cmodsar_search_and_replaceOnPosttypes wrapper-multiselect">
            <th scope="row">
                <div>Search &amp; Replace post types</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select posts & pages where you'd like to exclude the Search & Replace replacement rules."></div></th>
            <td class="field-multiselect">
				<textarea style="width:100%;"></textarea><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select posts & pages where you'd like to exclude the Search & Replace replacement rules.</div></td>
            
        </tr>
		        <tr valign="top" class=" cmodsar_search_and_replaceExcludeIDs wrapper-multiselect" style="clear:both;">
            <th scope="row">
                <div>Search &amp; Replace excluded posts/pages</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select posts & pages where you'd like to exclude the Search & Replace replacement rules."></div></th>
            <td class="field-multiselect">
				<textarea style="width:100%;"></textarea><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select posts & pages where you'd like to exclude the Search & Replace replacement rules.</div></td>
            
        </tr>
		                </tbody></table>
			        </div>
		        <div class="nblock" id="search-replace-in">
			                <h3 class="section-title"><span>Search &amp; Replace in ...</span> <svg class="tab-arrow" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="#6BC07F">
                        <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z"></path>
                    </svg></h3>
						                <table class="floated-form-table form-table">
					        <tbody><tr valign="top" class=" cmodsar_search_and_replaceTermsInSiteTitle wrapper-bool">
            <th scope="row">
                <div>Site Title</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select this option if you want to Search & Replace in the site title."></div></th>
            <td class="field-bool">
				<label><input type="radio" name="cmodsar_search_and_replaceTermsInSiteTitle" id="cmodsar_search_and_replaceTermsInSiteTitle_1" value="1"> On&nbsp;&nbsp;</label><label><input type="radio" name="cmodsar_search_and_replaceTermsInSiteTitle" id="cmodsar_search_and_replaceTermsInSiteTitle_0" value="0" checked="checked"> Off</label><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select this option if you want to Search & Replace in the site title.</div>            </td>
            
        </tr>
		        <tr valign="top" class=" cmodsar_search_and_replaceTermsInTitle wrapper-bool">
            <th scope="row">
                <div>Post/Page Title</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select this option if you want to Search & Replace in the post/page title."></div></th>
            <td class="field-bool">
				<label><input type="radio" name="cmodsar_search_and_replaceTermsInTitle" id="cmodsar_search_and_replaceTermsInTitle_1" value="1"> On&nbsp;&nbsp;</label><label><input type="radio" name="cmodsar_search_and_replaceTermsInTitle" id="cmodsar_search_and_replaceTermsInTitle_0" value="0" checked="checked"> Off</label><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select this option if you want to Search & Replace in the post/page title.</div>            </td>
            
        </tr>
		        <tr valign="top" class=" cmodsar_search_and_replaceTermsInContent wrapper-bool">
            <th scope="row">
                <div>Post/Page Content</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select this option if you want to Search & Replace in the post/page content."></div></th>
            <td class="field-bool">
				<label><input type="radio" name="cmodsar_search_and_replaceTermsInContent" id="cmodsar_search_and_replaceTermsInContent_1" value="1"> On&nbsp;&nbsp;</label><label><input type="radio" name="cmodsar_search_and_replaceTermsInContent" id="cmodsar_search_and_replaceTermsInContent_0" value="0" checked="checked"> Off</label><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select this option if you want to Search & Replace in the post/page content.</div>            </td>
            
        </tr>
		        <tr valign="top" class=" cmodsar_search_and_replaceTermsInExcerpt wrapper-bool">
            <th scope="row">
                <div>Post/Page Excerpt</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select this option if you want to Search & Replace in the post/page excerpt."></div></th>
            <td class="field-bool">
				<label><input type="radio" name="cmodsar_search_and_replaceTermsInExcerpt" id="cmodsar_search_and_replaceTermsInExcerpt_1" value="1"> On&nbsp;&nbsp;</label><label><input type="radio" name="cmodsar_search_and_replaceTermsInExcerpt" id="cmodsar_search_and_replaceTermsInExcerpt_0" value="0" checked="checked"> Off</label><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select this option if you want to Search & Replace in the post/page excerpt.</div>            </td>
            
        </tr>
		        <tr valign="top" class=" cmodsar_search_and_replaceTermsInComments wrapper-bool">
            <th scope="row">
                <div>Post/Page Comments</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select this option if you want to Search & Replace in the post/page comments."></div></th>
            <td class="field-bool">
				<label><input type="radio" name="cmodsar_search_and_replaceTermsInComments" id="cmodsar_search_and_replaceTermsInComments_1" value="1"> On&nbsp;&nbsp;</label><label><input type="radio" name="cmodsar_search_and_replaceTermsInComments" id="cmodsar_search_and_replaceTermsInComments_0" value="0" checked="checked"> Off</label><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select this option if you want to Search & Replace in the post/page comments.</div>            </td>
            
        </tr>
		                </tbody></table>
			        </div>
		        <div class="nblock" id="log">
			                <h3 class="section-title"><span>Log</span> <svg class="tab-arrow" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="#6BC07F">
                        <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z"></path>
                    </svg></h3>
						                <table class="floated-form-table form-table">
					        <tbody><tr valign="top" class=" cmodsar_enable_log wrapper-bool">
            <th scope="row">
                <div>Enable Preview &amp; Log</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select this option if you want to enable preview & log."></div></th>
            <td class="field-bool">
				<label><input type="radio" name="cmodsar_enable_log" id="cmodsar_enable_log_1" value="1"> On&nbsp;&nbsp;</label><label><input type="radio" name="cmodsar_enable_log" id="cmodsar_enable_log_0" value="0" checked="checked"> Off</label><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select this option if you want to enable preview & log.</div>            </td>
            
        </tr>
		        <tr valign="top" class=" cmodsar_logCleanup wrapper-custom">
            <th scope="row">
                <div>Cleanup log</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Warning! All log items of Search & Replace will be erased. It cannot be reverted."></div></th>
            <td class="field-custom">
				<input type="hidden" id="cmodsarp_cleanuplog_form_nonce" name="cmodsarp_cleanuplog_form_nonce" value="1df9f43285"><input type="hidden" name="_wp_http_referer" value="/cminds/wp-admin/admin.php?page=cm-on-demand-search-and-replace">        <input onclick="return confirm( 'All log items of Search &amp; Replace will be erased. This cannot be reverted.' )" type="submit" name="cmodsar_logCleanup" value="Cleanup log" class="button cmf-cleanuplog-button"><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Warning! All log items of Search & Replace will be erased. It cannot be reverted.</div>
		            </td>
            
        </tr>
		                </tbody></table>
			        </div>
		        <div class="nblock" id="cleanup">
			                <h3 class="section-title"><span>Cleanup</span> <svg class="tab-arrow" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="#6BC07F">
                        <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z"></path>
                    </svg></h3>
						                <table class="floated-form-table form-table">
					        <tbody><tr valign="top" class=" cmodsar_pluginCleanup wrapper-custom">
            <th scope="row">
                <div>Cleanup database</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Warning! This option will completely erase all of the data stored by the Search & Replace in the database: items, options, synonyms etc. It cannot be reverted."></div></th>
            <td class="field-custom">
				<input type="hidden" id="cmodsarp_cleanupdb_form_nonce" name="cmodsarp_cleanupdb_form_nonce" value="58c3fe13ca"><input type="hidden" name="_wp_http_referer" value="/cminds/wp-admin/admin.php?page=cm-on-demand-search-and-replace">        <input onclick="return confirm( 'All database items of Search &amp; Replace (items, options etc.) will be erased. This cannot be reverted.' )" type="submit" name="cmodsar_pluginCleanup" value="Cleanup database" class="button cmf-cleanup-button"><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Warning! This option will completely erase all of the data stored by the Search & Replace in the database: items, options, synonyms etc. It cannot be reverted.</div>
		            </td>
            
        </tr>
		                </tbody></table>
			        </div>
		</div>
		</div>
		<?php
		$content .= ob_get_clean();
		return $content;
	}
	
	public static function addSearchAndReplaceReplacementTabContent3( $content ) {
		ob_start();
		?>
		<div class="sblock" style="opacity:.5; pointer-events:none;">
			<div id="tabs-3" class="settings-tab" style=""><div class="cminds_settings_toggle_tabs cminds_settings_toggle-opened">Toggle All</div>        <div class="nblock" id="search-replace-in">
			                <h3 class="section-title"><span>Search &amp; Replace in ...</span> <svg class="tab-arrow" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="#6BC07F">
                        <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z"></path>
                    </svg></h3>
						                <table class="floated-form-table form-table">
					        <tbody><tr valign="top" class=" cmodsar_search_and_replaceTermsInCMTooltip wrapper-bool">
            <th scope="row">
                <div>CM Tooltip Glossary Tooltips</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select this option if you want to Search & Replace in the CM Tooltip Glossary Tooltips."></div></th>
            <td class="field-bool">
				<label><input type="radio" name="cmodsar_search_and_replaceTermsInCMTooltip" id="cmodsar_search_and_replaceTermsInCMTooltip_1" value="1"> On&nbsp;&nbsp;</label><label><input type="radio" name="cmodsar_search_and_replaceTermsInCMTooltip" id="cmodsar_search_and_replaceTermsInCMTooltip_0" value="0" checked="checked"> Off</label><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select this option if you want to Search & Replace in the CM Tooltip Glossary Tooltips.</div>            </td>
            
        </tr>
		        <tr valign="top" class=" cmodsar_search_and_replaceTermsInACFFields wrapper-bool">
            <th scope="row">
                <div>ACF (Advanced Custom Fields)</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select this option if you want to Search & Replace in the ACF (Advanced Custom Fields)."></div></th>
            <td class="field-bool">
				<label><input type="radio" name="cmodsar_search_and_replaceTermsInACFFields" id="cmodsar_search_and_replaceTermsInACFFields_1" value="1"> On&nbsp;&nbsp;</label><label><input type="radio" name="cmodsar_search_and_replaceTermsInACFFields" id="cmodsar_search_and_replaceTermsInACFFields_0" value="0" checked="checked"> Off</label><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select this option if you want to Search & Replace in the ACF (Advanced Custom Fields).</div>            </td>
            
        </tr>
		        <tr valign="top" class=" cmodsar_search_and_replaceTermsInBBPress wrapper-bool">
            <th scope="row">
                <div>bbPress forums</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select this option if you want to Search & Replace in the bbPress forums."></div></th>
            <td class="field-bool">
				<label><input type="radio" name="cmodsar_search_and_replaceTermsInBBPress" id="cmodsar_search_and_replaceTermsInBBPress_1" value="1"> On&nbsp;&nbsp;</label><label><input type="radio" name="cmodsar_search_and_replaceTermsInBBPress" id="cmodsar_search_and_replaceTermsInBBPress_0" value="0" checked="checked"> Off</label><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select this option if you want to Search & Replace in the bbPress forums.</div>            </td>
            
        </tr>
		        <tr valign="top" class=" cmodsar_search_and_replaceTermsInWooAttributes wrapper-bool">
            <th scope="row">
                <div>WooCommerce Attribute Labels</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select this option if you want to Search & Replace in the WooCommerce Attribute Labels."></div></th>
            <td class="field-bool">
				<label><input type="radio" name="cmodsar_search_and_replaceTermsInWooAttributes" id="cmodsar_search_and_replaceTermsInWooAttributes_1" value="1"> On&nbsp;&nbsp;</label><label><input type="radio" name="cmodsar_search_and_replaceTermsInWooAttributes" id="cmodsar_search_and_replaceTermsInWooAttributes_0" value="0" checked="checked"> Off</label><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select this option if you want to Search & Replace in the WooCommerce Attribute Labels.</div>            </td>
            
        </tr>
		        <tr valign="top" class=" cmodsar_search_and_replaceTermsInYoastTitle wrapper-bool">
            <th scope="row">
                <div>Yoast SEO Title</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select this option if you want to Search & Replace in the Yoast SEO titles."></div></th>
            <td class="field-bool">
				<label><input type="radio" name="cmodsar_search_and_replaceTermsInYoastTitle" id="cmodsar_search_and_replaceTermsInYoastTitle_1" value="1"> On&nbsp;&nbsp;</label><label><input type="radio" name="cmodsar_search_and_replaceTermsInYoastTitle" id="cmodsar_search_and_replaceTermsInYoastTitle_0" value="0" checked="checked"> Off</label><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select this option if you want to Search & Replace in the Yoast SEO titles.</div>            </td>
            
        </tr>
		        <tr valign="top" class=" cmodsar_search_and_replaceTermsInYoastDesc wrapper-bool">
            <th scope="row">
                <div>Yoast SEO Description</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select this option if you want to Search & Replace in the Yoast SEO descriptions."></div></th>
            <td class="field-bool">
				<label><input type="radio" name="cmodsar_search_and_replaceTermsInYoastDesc" id="cmodsar_search_and_replaceTermsInYoastDesc_1" value="1"> On&nbsp;&nbsp;</label><label><input type="radio" name="cmodsar_search_and_replaceTermsInYoastDesc" id="cmodsar_search_and_replaceTermsInYoastDesc_0" value="0" checked="checked"> Off</label><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select this option if you want to Search & Replace in the Yoast SEO descriptions.</div>            </td>
            
        </tr>
		                </tbody></table>
			        </div>
		</div>
		</div>
		<?php
		$content .= ob_get_clean();
		return $content;
	}
	
	public static function addSearchAndReplaceReplacementTabContent4( $content ) {
		ob_start();
		?>
		<div class="sblock" style="opacity:.5; pointer-events:none;">
			<div id="tabs-4" class="settings-tab" style=""><div class="cminds_settings_toggle_tabs cminds_settings_toggle-opened">Toggle All</div>        <div class="nblock" id="settings">
			                <h3 class="section-title"><span>Settings</span> <svg class="tab-arrow" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="#6BC07F">
                        <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z"></path>
                    </svg></h3>
						                <table class="floated-form-table form-table">
					        <tbody><tr valign="top" class=" cmodsar_frontendDisableMode wrapper-select">
            <th scope="row">
                <div>Display Widget for:</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select what the widget should hide, just the replacements or the whole functionality."></div></th>
            <td class="field-select">
				<div><select name="cmodsar_frontendDisableMode"><option value="anyone">Show to anyone</option><option value="logged">Show to logged users</option><option value="admin" selected="selected">Show to admin only</option></select><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select what the widget should hide, just the replacements or the whole functionality.</div></div>            </td>
            
        </tr>
		        <tr valign="top" class=" cmodsar_search_and_replaceFrontendSaveButton wrapper-bool">
            <th scope="row">
                <div>Only admin can save changes to database</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Displays the button &quot;Save changes permanently to DB&quot; within the widget for admin user only."></div></th>
            <td class="field-bool">
				<label><input type="radio" name="cmodsar_search_and_replaceFrontendSaveButton" id="cmodsar_search_and_replaceFrontendSaveButton_1" value="1"> On&nbsp;&nbsp;</label><label><input type="radio" name="cmodsar_search_and_replaceFrontendSaveButton" id="cmodsar_search_and_replaceFrontendSaveButton_0" value="0" checked="checked"> Off</label><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Displays the button &quot;Save changes permanently to DB&quot; within the widget for admin user only.</div>            </td>
            
        </tr>
		                </tbody></table>
			        </div>
		        <div class="nblock" id="position">
			                <h3 class="section-title"><span>Position</span> <svg class="tab-arrow" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="#6BC07F">
                        <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z"></path>
                    </svg></h3>
						                <table class="floated-form-table form-table">
					        <tbody><tr valign="top" class=" cmodsar_replacementOnOffWidgetAddTop wrapper-bool">
            <th scope="row">
                <div>Add to the top of each post</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select this option if you want to automatically add the widget allowing to toggle the replacements ON/OFF on the top of each post/page (from the list from General Settings)."></div></th>
            <td class="field-bool">
				<label><input type="radio" name="cmodsar_replacementOnOffWidgetAddTop" id="cmodsar_replacementOnOffWidgetAddTop_1" value="1"> On&nbsp;&nbsp;</label><label><input type="radio" name="cmodsar_replacementOnOffWidgetAddTop" id="cmodsar_replacementOnOffWidgetAddTop_0" value="0" checked="checked"> Off</label><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select this option if you want to automatically add the widget allowing to toggle the replacements ON/OFF on the top of each post/page (from the list from General Settings).</div>            </td>
            
        </tr>
		        <tr valign="top" class=" cmodsar_replacementOnOffWidgetAddBottom wrapper-bool">
            <th scope="row">
                <div>Add to the bottom of each post</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select this option if you want to automatically add the widget allowing to toggle the replacements ON/OFF on the top of each post/page (from the list from General Settings)."></div></th>
            <td class="field-bool">
				<label><input type="radio" name="cmodsar_replacementOnOffWidgetAddBottom" id="cmodsar_replacementOnOffWidgetAddBottom_1" value="1"> On&nbsp;&nbsp;</label><label><input type="radio" name="cmodsar_replacementOnOffWidgetAddBottom" id="cmodsar_replacementOnOffWidgetAddBottom_0" value="0" checked="checked"> Off</label><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select this option if you want to automatically add the widget allowing to toggle the replacements ON/OFF on the top of each post/page (from the list from General Settings).</div>            </td>
            
        </tr>
		                </tbody></table>
			        </div>
		        <div class="nblock" id="labels">
			                <h3 class="section-title"><span>Labels</span> <svg class="tab-arrow" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="#6BC07F">
                        <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z"></path>
                    </svg></h3>
						                <table class="floated-form-table form-table">
					        <tbody><tr valign="top" class=" cmodsar_replacementOnOffWidgetLabel wrapper-string">
            <th scope="row">
                <div>Tooltip ON/OFF Widget label</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select the label for the Replacement Toggle Widget."></div></th>
            <td class="field-string">
				<input type="text" name="cmodsar_replacementOnOffWidgetLabel" value="Tooltip Widget Label"><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select the label for the Replacement Toggle Widget.</div>            </td>
            
        </tr>
		        <tr valign="top" class=" cmodsar_replacementOnOffWidgetDisableText wrapper-string">
            <th scope="row">
                <div>Tooltip ON/OFF Widget - disable text</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select the text for the link when the replacements are enabled."></div></th>
            <td class="field-string">
				<input type="text" name="cmodsar_replacementOnOffWidgetDisableText" value="Disable Replacements"><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select the text for the link when the replacements are enabled.</div>            </td>
            
        </tr>
		        <tr valign="top" class=" cmodsar_replacementOnOffWidgetEnableText wrapper-string">
            <th scope="row">
                <div>Tooltip ON/OFF Widget - enable text</div>
            <div class="cmodsar_field_help" title="(Only in Pro) Select the text for the link when the replacements are disabled."></div></th>
            <td class="field-string">
				<input type="text" name="cmodsar_replacementOnOffWidgetEnableText" value="Enable Replacements"><div style="margin-top:5px"><span class="cm_field_help_pro">(Only in Pro)</span> Select the text for the link when the replacements are disabled.</div>            </td>
            
        </tr>
		                </tbody></table>
			        </div>
		</div>
		</div>
		<?php
		$content .= ob_get_clean();
		return $content;
	}

	/**
	 * Adds the replacements with AJAX
	 */
	public static function ajaxAddReplacement() {
		$post			 = filter_input_array( INPUT_POST );
		$replacements	 = get_option( 'cmodsar_replacements', array() );

		if ( empty( $replacements ) ) {
			$replacements = array();
		}
		
		if(isset($post['nonce']) && wp_verify_nonce($post['nonce'], 'update-options')) {
			$replace_from = trim($post[ 'replace_from' ]);
			$replace[ 'from' ]	 = !empty( $replace_from ) ? $replace_from : '';
			$replace[ 'to' ]	 = !empty( $post[ 'replace_to' ] ) ? $post[ 'replace_to' ] : '';
			$replace[ 'case' ]	 = !empty( $post[ 'replace_case' ] ) ? 1 : 0;
			$replacements[] = $replace;
			update_option( 'cmodsar_replacements', $replacements );
		}

		self::outputReplacements( $replacements );
		die();
	}

	/**
	 * Updates the replacements with AJAX
	 */
	public static function ajaxUpdateReplacement() {
		$post			 = filter_input_array( INPUT_POST );
		$replacements	 = get_option( 'cmodsar_replacements', array() );

		if ( empty( $replacements ) ) {
			$replacements = array();
		}

		if(isset($post['nonce']) && wp_verify_nonce($post['nonce'], 'update-options')) {
			$replace_from = trim($post[ 'replace_from' ]);
			$id = $post[ 'replace_id' ];
			if ( isset( $replacements[ $id ] ) ) {
				$replace[ 'from' ]	 = isset( $replace_from ) ? $replace_from : '';
				$replace[ 'to' ]	 = isset( $post[ 'replace_to' ] ) ? $post[ 'replace_to' ] : '';
				$replace[ 'case' ]	 = !empty( $post[ 'replace_case' ] ) ? 1 : 0;
				$replacements[ $id ] = $replace;
			}
			update_option( 'cmodsar_replacements', $replacements );
		}

		self::outputReplacements( $replacements );
		die();
	}

	/**
	 * Deletes the replacement with AJAX
	 */
	public static function ajaxDeleteReplacement() {
		$repl = get_option( 'cmodsar_replacements', array() );
		if(isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'update-options')) {
			unset( $repl[ $_POST[ 'id' ] ] );
			update_option( 'cmodsar_replacements', $repl );
		}
		self::outputReplacements( $repl );
		die();
	}
	
	/**
	 * Outputs the replacements header
	 */
	public static function outputReplacementsHeader($count = 0, $addRow = false, $borderenable = 'no') {
		$border = '';
		if($borderenable == 'yes') {
			$border = 'border-bottom:2px solid purple;';
		}
		?>
		<thead>
			<tr>
				<th colspan="3" style="text-align:center;">&nbsp;</th>
				<th colspan="4" style="color:purple; text-align:center;">Available in pro version</th>
				<th style="text-align:center;">&nbsp;</th>
			</tr>
			<tr>
				<th class="cmodsar_from_input" style="text-align:center;">
					From String
				</th>
				<th class="cmodsar_to_input" style="text-align:center;">
					To String
				</th>
				<th class="cmodsar_case_input" style="text-align:center;">
					Case
					<div class="cmodsar_field_help" title="Select if you like the &quot;From String&quot; to be case-sensitive."></div>
				</th>
				<th class="cmodsar_case_input" style="opacity:0.4; text-align:center; border-top:2px solid purple; border-left:2px solid purple;<?php echo $border; ?>">Regex
					<div class="cmodsar_field_help" title="Select if you like to treat the &quot;From String&quot; as Regular Expression."></div>
				</th>
				<th class="cmodsar_pause_input" style="opacity:0.4; text-align:center; border-top:2px solid purple;<?php echo $border; ?>">Pause
					<div class="cmodsar_field_help" title="Select if you like to temporarily disable the rule without deleting it."></div>
				</th>
				<th class="cmodsar_time_input" style="opacity:0.4; text-align:center; border-top:2px solid purple;<?php echo $border; ?>">Restrictions
					<div class="cmodsar_field_help" title="Select the timeframes within which the Search &amp; Replace should work. The change will only take place within the timeframe. You can also disable Search &amp; Replace for given place: site title, title, content, excerpt, links, images, comments."></div>
				</th>
				<th class="cmodsar_location_input" style="opacity:0.4; text-align:center; border-top:2px solid purple; border-right:2px solid purple;<?php echo $border; ?>">Location
					<div class="cmodsar_field_help" title="Restrict the rule with Post/Page if needed Or you can select specific terms"></div>
				</th>
				<th class="cmodsar_options_input" style="text-align:center;">
					Options
				</th>
			</tr>
		</thead>
		<?php
	}

	/**
	 * Outputs the replacements table
	 * @param type $repl
	 * @param bool $addRow
	 */
	public static function outputReplacements( $repl, $addRow = false ) {
		?>
		<div class="cmodsar-custom-replacement-wrapper">
			<div class="cmodsar-custom-replacement-list">
				<table class="form-table cmodsar_replacements_list" style="overflow-x:auto;">
					<?php
					if(count($repl) == 0) {
						self::outputReplacementsHeader(count($repl), $addRow, 'yes');
					} else {
						self::outputReplacementsHeader(count($repl), $addRow, 'no');
					}
					?>
					<tbody>
						<?php
						if ( !empty( $repl ) && is_array( $repl ) ) {
							$couter = 1;
							foreach ( $repl as $k => $r ) {
								if(count($repl) == $couter) {
									self::_outputReplacementRow( $r, $k, 'yes');
								} else {
									self::_outputReplacementRow( $r, $k, 'no');
								}
								$couter++;
							}
						} else {
							echo '<tr><td colspan="5">' . CMODSAR_Base::__( 'No replacements. Please add using the form below.' ) . '</td></tr>';
						}
						?>
					</tbody>
				</table>
			</div>
			<?php
			if ( $addRow ) :
				?>
				<div class="cmodsar-custom-replacement-add" style="overflow-x:auto;">
					<table class="form-table">
						<?php
						echo self::outputReplacementsHeader(count($repl), false, 'no');
						echo self::_outputAddingRow();
						?>
					</table>
				</div>
				<?php
			endif;
			?>
		</div>
		<?php
	}

	/**
	 * Outputs the single replacement row
	 * @param type $replacementRow
	 * @param type $rowKey
	 */
	public static function _outputAddingRow() {
		?>
		<tr valign="top" class="cmodsar_new_replacement_row">
			<td class="cmodsar_from_input">
				<textarea rows="3" type="text" placeholder="From" name="cmodsar_custom_from_new" value=""></textarea>
			</td>
			<td class="cmodsar_to_input">
				<textarea rows="3" type="text" placeholder="To" name="cmodsar_custom_to_new" value=""></textarea>
			</td>
			<td class="cmodsar_case_input">
				<input type="hidden" name="cmodsar_custom_case_new" value="0" />
				<input type="checkbox" name="cmodsar_custom_case_new" value="1" />
			</td>
			<td class="cmodsar_regex_input" style="opacity:0.4; border-left:2px solid purple; border-bottom:2px solid purple;">
				<input type="checkbox">
			</td>
			<td class="cmodsar_pause_input" style="opacity:0.4; border-bottom:2px solid purple;">
				<input type="checkbox">
			</td>
			<td class="cmodsar_time_input" style=" opacity:0.4;border-bottom:2px solid purple;">
				<div class="cmodsar_time_restriction_wrapper">
					<table>
						<tbody>
						<tr style="display: none" class="to-copy">
							<td>From: <input disabled="disabled" type="datetime" class="datepicker" style="width:122px;font-size:10px;"></td>
							<td>To: <input disabled="disabled" type="datetime" class="datepicker" style="width:122px;font-size:10px;"></td>
							<td>&nbsp; <input type="button" value="Remove" class="button-secondary cmodsar-custom-delete-restriction" style="font-size:8px;"></td>
						</tr>
						</tbody>
					</table>
				</div>
				<div class="cmodsar_place_disable_wrapper">
					<table style="width:100%;">
						<tbody>
						<tr>
							<td style="width:33.33%;">
								<label style="font-size:13px;">
									Site Title:<br>
									<input type="checkbox">
								</label>
							</td>
							<td style="width:33.33%;">
								<label style="font-size:13px;">
									Title:<br>
									<input type="checkbox">
								</label>
							</td>
							<td style="width:33.33%;">
								<label style="font-size:13px;">
									Content:<br>
									<input type="checkbox">
								</label>
							</td>
						</tr>
						<tr>
							<td style="width:33.33%;">
								<label style="font-size:13px;">
									Excerpt:<br>
									<input type="checkbox">
								</label>
							</td>
							<td style="width:33.33%;">
								<label style="font-size:13px;">
									Links:<br>
									<input type="checkbox">
								</label>
							</td>
							<td style="width:33.33%;">
								<label style="font-size:13px;">
									Images:<br>
									<input type="checkbox">
								</label>
							</td>
						</tr>
						<tr>
							<td style="width:33.33%;">
								<label style="font-size:13px;">
									Comments:<br>
									<input type="checkbox">
								</label>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<input type="button" value="Add Timeframe" class="button-secondary cmodsar-custom-time-restriction-add-new">
				<input type="button" value="Add Exclusion (0/7)" class="button-secondary cmodsar-custom-place-restriction-add-new" id="cmodsar-custom-add-place-exclusion-btn">
			</td>
			<td class="cmodsar_location_input" style="opacity:0.4; border-bottom:2px solid purple; border-right:2px solid purple;">
				<select class="cmodsar_custom_postpage_new">
					<option value="">All</option>
					<option value="include">Include</option>
					<option value="exclude">Exclude</option>
					<option value="terms">Categories/Tags</option>
				</select>
				<br>
				<select class="cmodsar_custom_postpage_new_multiple" multiple="multiple">
					<?php
					$selected_ids = array();
					echo self::outputPostsPagesSelect( $selected_ids );
					?>
				</select>
				<select class="cmodsar_custom_cats_new_multiple" multiple="multiple">
					<?php
					$selected_ids = array();
					echo self::outputCatsSelect( $selected_ids );
					?>
				</select>
			</td>
			<td class="cmodsar_options_input">
				<input type="button" class="button-primary" value="Add Rule" id="cmodsar-custom-add-replacement-btn">
			</td>
		</tr>
		<?php
	}

	/**
	 * Outputs the single replacement row
	 * @param type $replacementRow
	 * @param type $rowKey
	 */
	public static function _outputReplacementRow( $replacementRow = array(), $rowKey = '', $borderenable = 'no') {
		$from	 = (isset( $replacementRow[ 'from' ] )) ? $replacementRow[ 'from' ] : '';
		$to		 = (isset( $replacementRow[ 'to' ] )) ? $replacementRow[ 'to' ] : '';
		$case	 = (isset( $replacementRow[ 'case' ] ) && $replacementRow[ 'case' ] == 1) ? 1 : 0;
		$border = '';
		if($borderenable == 'yes') {
			$border = 'border-bottom:2px solid purple;';
		}
		?>
		<tr valign="top" class="cmodsar_new_replacement_row">
			<td class="cmodsar_from_input">
				<textarea rows="3" placeholder="From" name="cmodsar_custom_from[<?php echo $rowKey; ?>]"><?php echo htmlentities($from); ?></textarea>
			</td>
			<td class="cmodsar_to_input">
				<textarea rows="3" placeholder="To" name="cmodsar_custom_to[<?php echo $rowKey; ?>]"><?php echo htmlentities($to); ?></textarea>
			</td>
			<td class="cmodsar_case_input">
				<input type="hidden" name="cmodsar_custom_case[<?php echo $rowKey; ?>]" value="0" />
				<input type="checkbox" name="cmodsar_custom_case[<?php echo $rowKey; ?>]" value="1" <?php echo checked( 1, $case ) ?> />
			</td>
			<td class="cmodsar_regex_input" style="opacity:0.4; border-left:2px solid purple;<?php echo $border; ?>">
				<input type="checkbox">
			</td>
			<td class="cmodsar_pause_input" style="opacity:0.4; <?php echo $border; ?>">
				<input type="checkbox">
			</td>
			<td class="cmodsar_time_input" style="opacity:0.4; <?php echo $border; ?>">
				<div class="cmodsar_time_restriction_wrapper">
					<table>
						<tbody>
						<tr style="display: none" class="to-copy">
							<td>From: <input disabled="disabled" type="datetime" class="datepicker" style="width:122px;font-size:10px;"></td>
							<td>To: <input disabled="disabled" type="datetime" class="datepicker" style="width:122px;font-size:10px;"></td>
							<td>&nbsp; <input type="button" value="Remove" class="button-secondary cmodsar-custom-delete-restriction" style="font-size:8px;"></td>
						</tr>
						</tbody>
					</table>
				</div>
				<div class="cmodsar_place_disable_wrapper">
					<table style="width:100%;">
						<tbody>
						<tr>
							<td style="width:33.33%;">
								<label style="font-size:13px;">
									Site Title:<br>
									<input type="checkbox">
								</label>
							</td>
							<td style="width:33.33%;">
								<label style="font-size:13px;">
									Title:<br>
									<input type="checkbox">
								</label>
							</td>
							<td style="width:33.33%;">
								<label style="font-size:13px;">
									Content:<br>
									<input type="checkbox">
								</label>
							</td>
						</tr>
						<tr>
							<td style="width:33.33%;">
								<label style="font-size:13px;">
									Excerpt:<br>
									<input type="checkbox">
								</label>
							</td>
							<td style="width:33.33%;">
								<label style="font-size:13px;">
									Links:<br>
									<input type="checkbox">
								</label>
							</td>
							<td style="width:33.33%;">
								<label style="font-size:13px;">
									Images:<br>
									<input type="checkbox">
								</label>
							</td>
						</tr>
						<tr>
							<td style="width:33.33%;">
								<label style="font-size:13px;">
									Comments:<br>
									<input type="checkbox">
								</label>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<input type="button" value="Add Timeframe" class="button-secondary cmodsar-custom-time-restriction-add-new">
				<input type="button" value="Add Exclusion (0/7)" class="button-secondary cmodsar-custom-place-restriction-add-new" id="cmodsar-custom-add-place-exclusion-btn">
			</td>
			<td class="cmodsar_location_input" style="opacity:0.4; border-right:2px solid purple;<?php echo $border; ?>">
				<select class="cmodsar_custom_postpage_new">
					<option value="">All</option>
					<option value="include">Include</option>
					<option value="exclude">Exclude</option>
					<option value="terms">Categories/Tags</option>
				</select>
				<br>
				<select class="cmodsar_custom_postpage_new_multiple" multiple="multiple">
					<?php
					$selected_ids = array();
					echo self::outputPostsPagesSelect( $selected_ids );
					?>
				</select>
				<select class="cmodsar_custom_cats_new_multiple" multiple="multiple">
					<?php
					$selected_ids = array();
					echo self::outputCatsSelect( $selected_ids );
					?>
				</select>
			</td>
			<td class="optionButtons">
				<input type="button" value="Update Rule" class="button-primary cmodsar-custom-update-replacement" data-uid="<?php echo $rowKey ?>" style="margin-bottom:4px;" />
				<div style="opacity:0.4; border:2px solid purple; padding:5px 5px 0px 5px; margin-bottom:5px;">
					<input type="button" value="Implement in DB" class="button-primary cmodsar-custom-updatedb-replacement-demo" title="Available in pro version" onclick="alert('This feature available in pro version.')" />
					<br>
					<input type="button" value="View Related Posts" class="button-primary cmodsar-custom-viewandupdatedb-replacement-demo" title="Available in pro version" onclick="alert('This feature available in pro version.')" />
				</div>
				<input type="button" value="Delete Rule" class="button-secondary cmodsar-custom-delete-replacement" data-rid="<?php echo $rowKey ?>" />
			</td>
		</tr>
		<?php
	}

	/**
	 * Save the info about replaced terms
	 */
	public static function saveReplacement( $post ) {
		/*
		 * Added code to update replacements while updating other options
		 */

		if ( isset( $post[ 'cmodsar_custom_from' ] ) && isset( $post[ 'cmodsar_custom_to' ] ) && isset( $post[ 'cmodsar_custom_case' ] ) ) {
			if ( is_array( $post[ 'cmodsar_custom_from' ] ) && is_array( $post[ 'cmodsar_custom_to' ] ) && is_array( $post[ 'cmodsar_custom_case' ] ) ) {
				$replacement_from	 = $post[ 'cmodsar_custom_from' ];
				$replacement_to		 = $post[ 'cmodsar_custom_to' ];
				$replacement_case	 = $post[ 'cmodsar_custom_case' ];

				$repl_array = array();
				foreach ( $replacement_from as $key => $value ) {
					if ( $replacement_from[ $key ] != '' && $replacement_to[ $key ] != '' ) {
						$repl_array[ $key ] = array(
							'from'	 => $replacement_from[ $key ],
							'to'	 => $replacement_to[ $key ],
							'case'	 => (isset( $replacement_case[ $key ] ) ? $replacement_case[ $key ] : 0)
						);
					}
				}

				// Ticket 56905 Adding "Add Rule" function
				$replace_from = trim($post[ 'cmodsar_custom_from_new' ]);

		 		$replace[ 'from' ]	 = !empty( $replace_from ) ? $replace_from : '';
		 		$replace[ 'to' ]	 = !empty( $post[ 'cmodsar_custom_to_new' ] ) ? $post[ 'cmodsar_custom_to_new' ] : '';
		 		$replace[ 'case' ]	 = !empty( $post[ 'cmodsar_custom_case_new' ] ) ? 1 : 0;
				
				if($replace[ 'from' ] != '') {
		 			$repl_array[] = $replace;
				}

				update_option( 'cmodsar_replacements', $repl_array );
			}
		}
	}

	/**
	 * Replaces the words within the text
	 * @param type $content
	 * @return type
	 */
	public static function doCustomReplacement( $content ) {
		global $post, $wp_query;

		if ( $post === NULL ) {
			return $content;
		}

		if ( !is_object( $post ) ) {
			$post = $wp_query->post;
		}

		$repl = get_option( 'cmodsar_replacements', array() );
		if ( !empty( $repl ) && is_array( $repl ) ) {
			foreach ( $repl as $r ) {
				if ( !empty( $r[ 'from' ] ) ) {
					// Ticket 56905
					$r[ 'from' ] = preg_replace( '/"(.*?)"/', '&#8221;$1&#8221;', $r[ 'from' ] );
					$r[ 'from' ] = preg_replace( "/'(.*?)'/", '&#8217;$1&#8217;', $r[ 'from' ] );
					$r[ 'from' ] = preg_replace( '/(.*?)"/', '$1&#8221;', $r[ 'from' ] );
					$r[ 'from' ] = preg_replace( "/(.*?)'/", '$1&#8217;', $r[ 'from' ] );

					$content = ($r[ 'case' ] == 1) ? str_replace( $r[ 'from' ], $r[ 'to' ], $content ) : str_ireplace( $r[ 'from' ], $r[ 'to' ], $content );
				}
			}
		}
		return $content;
	}
	
	public static function outputCatsSelect( $selectedIDs = array() ) {
		$options             = '';
		$selected_post_types = $selected_post_types = array('post', 'page');

		if ( ! is_array( $selected_post_types ) ) {
			$selected_post_types = array();
		}
		
		if ( ! is_array( $selectedIDs ) ) {
			$selectedIDs = array();
		}
		
		foreach ( $selected_post_types as $post_type ) {
			
			$taxonomies = get_object_taxonomies( $post_type, 'objects' );
						
			if ( ! empty( $taxonomies ) ) {
				foreach ( $taxonomies as $taxonomykey=>$taxonomy ) {
					
					$terms = get_terms(array(
						'taxonomy' => $taxonomykey,
						'hide_empty' => false,
					));
					
					if (!empty($terms) && !is_wp_error($terms)) {
						$options .= '<optgroup label="' . $taxonomy->label . '">';
						foreach ($terms as $term) {
							if ( in_array( $term->term_id, $selectedIDs ) ) {
								$options .= '<option value="'.$term->term_id.'" selected="selected">'.$term->name.'</option>';
							} else {
								$options .= '<option value="'.$term->term_id.'">'.$term->name.'</option>';
							}
						}
						$options .= '</optgroup>';
					}
					
				}
			}
			
		}
		return $options;
	}

	/**
	 * Outputs the list of posts, pages and custom posts to select exclusions
	 * @return string
	 */
	public static function outputPostsPagesSelect( $selectedIDs = array() ) {
		$options             = '';
		$selected_post_types = array('post', 'page');

		if ( ! is_array( $selectedIDs ) ) {
			$selectedIDs = array();
		}

		foreach ( $selected_post_types as $post_type ) {
			$args = array(
				'posts_per_page' => 10000,
				'orderby'        => 'title',
				'order'          => 'DESC',
				'post_type'      => $post_type,
				//'post_status'    => 'publish',	
				'post_status'    => 'any',			
				'fields'         => 'ids',
			);

			$posts = get_posts( $args );

			if ( $posts ) {

				$options .= '<optgroup label="' . $post_type . '">';

				foreach ( $posts as $postID ) {
					if ( in_array( $postID, $selectedIDs ) ) {
						$options .= '<option value="'.$postID.'" selected="selected">'.get_the_title($postID).' ('.ucwords(get_post_status($postID)).')</option>';
					} else {
						$options .= '<option value="'.$postID.'">'.get_the_title($postID).' ('.ucwords(get_post_status($postID)).')</option>';
					}
				}

				$options .= '</optgroup>';
			}
		}

		return $options;
	}
	
}