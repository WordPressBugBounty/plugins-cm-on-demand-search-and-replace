<?php
ob_start();
include plugin_dir_path(__FILE__) . 'views/plugin_compare_table.php';
$plugin_compare_table = ob_get_contents();
ob_end_clean();
$cminds_plugin_config = array(
	'plugin-is-pro'						=> false,
	'plugin-has-addons'					=> TRUE,
	'plugin-version'					=> '1.5.1',
	'plugin-addons'        => array(
		array(
			'title' => 'Header and Footer Plugin',
			'description' => 'Add custom CSS and JavaScript to headers and footers on your site with the header and footer plugin for enhanced control and design.',
			'link' => 'https://wordpress.org/plugins/cm-header-footer-script-loader/',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPHeaderAndFooterScriptLoaderS.png',
		),
		array(
			'title' => 'Curated List Manager',
			'description' => 'Create and manage curated lists with this content curation plugin. Share & Organize content, resources, links, images and engage your audience.',
			'link' => 'https://wordpress.org/plugins/cm-curated-list-manager/',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPCuratedListManagerS.png',
		),
		array(
			'title' => 'Popup Banners',
			'description' => 'Create and customize popups. Display messages, Call to actions, promotions, or announcements to engage visitors and boost interaction.',
			'link' => 'https://wordpress.org/plugins/cm-pop-up-banners/',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPPopUpBannersS.png',
		),
		array(
			'title' => 'Business Directory Plugin',
			'description' => 'Create and manage a business directory with this business listings plugin. List businesses, add details, and help users find services.',
			'link' => 'https://wordpress.org/plugins/cm-business-directory/',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPBusinessDirectoryS.png',
		),
		array(
			'title' => 'Table of Contents Plugin',
			'description' => 'Create and display a table of contents for your posts and pages. Improve navigation with an easy-to-use TOC generator.',
			'link' => 'https://wordpress.org/plugins/cm-table-of-content/',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPTableOfContentS.png',
		),
		array(
			'title' => 'Context Product Recommendations',
			'description' => 'Display recommended products on your website post or pages based on the content of the post.',
			'link' => 'https://wordpress.org/plugins/cm-context-related-product-recommendations/',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPProductRecommendationsS.png',
		),
	),
	'plugin-specials'        => array(
		array(
			'title' => 'RSS Post Importer Plugin',
			'description' => 'Support importing and displaying external posts using RSS, Atom feeds and scraping tool to your WordPress site.',
			'link' => 'https://www.cminds.com/wordpress-plugins-library/rss-post-importer-plugin-wordpress-creativeminds/?discount=CMINDS10',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPRSSPostImporterS.png',
		),
		array(
			'title' => 'Questions and Answers Plugin',
			'description' => 'Experience a mobile-responsive discussion forum where members can post questions, answers, and comments, with integrated payment support.',
			'link' => 'https://www.cminds.com/cm-answer-store-page-content/?discount=CMINDS10',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPQuestionsAndAnswersS.png',
		),
		array(
			'title' => 'Reviews and Rating Plugin',
			'description' => 'Allow visitors and users to submit reviews and ratings, and display them on any product, posts, or pages.',
			'link' => 'https://www.cminds.com/wordpress-plugins-library/customer-reviews-plugin-wordpress/?discount=CMINDS10',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPCustomerReviewsS.png',
		),
		array(
			'title' => 'Booking Calendar',
			'description' => 'Enable customers to effortlessly schedule appointments and make payments directly through your website.',
			'link' => 'https://www.cminds.com/wordpress-plugins-library/schedule-appointments-manage-bookings-plugin-wordpress/?discount=CMINDS10',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPBookingCalendarS.png',
		),
		array(
			'title' => 'Map Locations Manager',
			'description' => 'Efficiently manage map locations and enable location finding using Google Maps. Includes support for detailed location descriptions, images, and videos.',
			'link' => 'https://www.cminds.com/wordpress-plugins-library/multiple-locations-google-maps/?discount=CMINDS10',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPMapLocationsandStoreLocaterS.png',
		),
		array(
			'title' => 'Site Access and Content Restriction',
			'description' => 'A robust membership solution and content restriction plugin that supports role-based access to content on your WordPress website.',
			'link' => 'https://www.cminds.com/wordpress-plugins-library/membership-plugin-for-wordpress/?discount=CMINDS10',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPSiteRestrictionS.png',
		),
	),
	'plugin-bundles'        => array(
		array(
			'title' => '99+ Free Pass Plugins Suite',
			'description' => 'Get all CM 99+ WordPress plugins and addons. Includes unlimited updates and one year of priority support.',
			'link' => 'https://www.cminds.com/wordpress-plugins-library/cm-wordpress-plugins-yearly-membership/',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPBundleWPSuiteS.png',
		),
		array(
			'title' => 'Essential Publishing Plugin Package',
			'description' => 'Enhance your WordPress publishing with a bundle of seven plugins that elevate content generation, presentation, and user engagement on your site.',
			'link' => 'https://www.cminds.com/wordpress-plugins-library/essential-wordpress-publishing-tools-bundle/',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPBundlePublishingS.png',
		),
		array(
			'title' => 'Essential Content Marketing Tools',
			'description' => 'Enhance your WordPress content marketing with seven plugins for improved content generation, presentation, and user engagement.',
			'link' => 'https://www.cminds.com/wordpress-plugins-library/essential-wordpress-content-marketing-tools-bundle/',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPBundleContentS.png',
		),
		array(
			'title' => 'Essential Security Plugins',
			'description' => 'Enhance your WordPress security with a bundle of five plugins that provide additional ways to protect your content and site from spammers, hackers, and exploiters.',
			'link' => 'https://www.cminds.com/wordpress-plugins-library/essential-wordpress-security-tools-plugin-bundle/',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPBundleSecurityS.png',
		),
	),
	'plugin-services'        => array(
		array(
			'title' => 'WordPress Custom Hourly Support',
			'description' => 'Hire our expert WordPress developers on an hourly basis, offering a-la-carte service to craft your custom WordPress solution.',
			'link' => 'https://www.cminds.com/wordpress-services/wordpress-custom-hourly-support-package/',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPServicesHourlySupportS.png',
		),
		array(
			'title' => 'Performance and Optimization Analysis',
			'description' => 'Receive a comprehensive review of your WordPress website with optimization suggestions to enhance its speed and performance.',
			'link' => 'https://www.cminds.com/wordpress-services/wordpress-performance-and-speed-optimization-analysis-service/',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPServicesPerformanceS.png',
		),
		array(
			'title' => 'WordPress Plugin Installation',
			'description' => 'We offer professional installation and configuration of plugins or add-ons on your site, tailored to your specified requirements.',
			'link' => 'https://www.cminds.com/wordpress-services/plugin-installation-service-for-wordpress-by-creativeminds/',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPServicesExtensionInstallationS.png',
		),
		array(
			'title' => 'WordPress Consulting',
			'description' => 'Purchase consulting hours to receive assistance in designing or planning your WordPress solution. Our expert consultants are here to help bring your vision to life.',
			'link' => 'https://www.cminds.com/wordpress-services/consulting-planning-hourly-support-service-wordpress-creativeminds/#description',
			'image' => plugin_dir_url( __FILE__ ) . 'views/icons/WPServicesConsultingS.png',
		),
	),
	'plugin-abbrev'						=> 'cmodsar',
	'plugin-short-slug'					=> 'search-and-replace',
	'plugin-parent-short-slug'			=> '',
	'plugin-file'						=> CMODSAR_PLUGIN_FILE,
    'plugin-campign'					=> '?utm_source=searchreplacefree&utm_campaign=freeupgrade',
    'plugin-affiliate'					=> '',
    'plugin-redirect-after-install'		=> admin_url( 'admin.php?page=cmodsar_settings' ),
    'plugin-show-guide'					=> TRUE,
	'plugin-upgrade-text'				=> 'Good Reasons to Upgrade to Pro',
    'plugin-upgrade-text-list'			=> array(
        array( 'title' => 'Introduction to the search and replace plugin', 'video_time' => '0:00' ),
        array( 'title' => 'Use in titles, comments and excerpts', 'video_time' => '0:58' ),
        array( 'title' => 'Time restricted search and replace', 'video_time' => '1:18' ),
        array( 'title' => 'Exclude specific pages', 'video_time' => '1:30' ),
        array( 'title' => 'Regex support', 'video_time' => 'More' ),
        array( 'title' => 'Import and export rules', 'video_time' => 'More' ),
        array( 'title' => 'ACF support', 'video_time' => 'More' ),
        array( 'title' => 'More support to Yoast and WooCommerce content', 'video_time' => 'More' ),
    ),
    'plugin-upgrade-video-height'		=> 240,
    'plugin-upgrade-videos'				=> array(
        array( 'title' => 'Search and Replace Premium Features', 'video_id' => '124893784' ),
    ),
    'plugin-guide-text'					=> '<div style="display:block">
        <ol>
         <li>This plugin allows you to setup the search & replace rules for the content of your site.</li>
        <li>You can set a <strong>textual string or HTML</strong> which should be found and the string/HTML that should be placed instead.</li>
        <li> You may also decide only to remove without replacing it (just leave the "To String" empty).</li>
        <li>This plugin and replacment tules <strong>does not change the content on the database</strong>. Instead it changes the content right before it is displayed.</li>
        <li><strong>Example:</strong>Create a rule, in the From String field type: "test" in the To String field: "passed"</li>
        <li>Create a new page, add some title (any), and write the "test" in the content</li>
        <li>Save the page and view it</li>
        <li>You should see the string "passed" in the content</li>
        <li>If there is still "test" displayed - it may mean that your theme is not using "the_content" filter.</li>
        </ol>
    </div>',
    'plugin-guide-video-height'          => 240,
    'plugin-guide-videos'            => array(
        array( 'title' => 'Installation tutorial', 'video_id' => '157541752' ),
    ),
	'plugin-dir-path'			 => plugin_dir_path( CMODSAR_PLUGIN_FILE ),
	'plugin-dir-url'			 => plugin_dir_url( CMODSAR_PLUGIN_FILE ),
	'plugin-basename'			 => plugin_basename( CMODSAR_PLUGIN_FILE ),
	'plugin-icon'				 => '',
	'plugin-name'				 => CMODSAR_NAME,
	'plugin-license-name'		 => CMODSAR_CANONICAL_NAME,
	'plugin-slug'				 => '',
	'plugin-menu-item'			 => CMODSAR_SETTINGS_OPTION,
	'plugin-textdomain'			 => CMODSAR_SLUG_NAME,
	'plugin-userguide-key'		 => '2244-cm-search-and-replace-cmsr-free-version-guide',
	'plugin-store-url'			 => 'https://www.cminds.com/wordpress-plugins-library/purchase-cm-on-demand-search-and-replace-plugin-for-wordpress?utm_source=searchreplacefree&utm_campaign=freeupgrade&upgrade=1',
	'plugin-support-url'		 => 'https://www.cminds.com/contact/',
	'plugin-review-url'			 => 'https://wordpress.org/support/view/plugin-reviews/cm-on-demand-search-and-replace',
	'plugin-changelog-url'		 => CMODSAR_RELEASE_NOTES,
	'plugin-licensing-aliases'	 => array( CMODSAR_LICENSE_NAME ),
	'plugin-compare-table'	 => $plugin_compare_table,
);