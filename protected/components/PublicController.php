<?php

/**
 * Base controller for the public-facing Samaj website. Deliberately does not
 * extend the legacy `Controller` base (protected/components/Controller.php),
 * which carries CRM/partner-slug specific beforeAction logic that has no
 * meaning for the public site.
 */
class PublicController extends CController
{
	public $layout = '//layouts/public';

	public function getSiteName()
	{
		return Setting::get('site_name', 'Bhadar Kathiya Ghanchi Samaj');
	}

	public function getSiteTagline()
	{
		return Setting::get('site_tagline', '');
	}

	public function getFooterText()
	{
		return Setting::get('footer_text', '');
	}
}
