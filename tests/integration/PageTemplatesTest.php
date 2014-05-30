<?php

class FT_Page_Templates_Test extends FortyTwo_TestCase {
	public function test_archive_and_blog_page_templates_are_hidden() {
		$this->assertTrue( function_exists( 'ft_remove_page_templates' ), 'ft_remove_page_templates does not exist!' );
		add_filter( 'theme_page_templates', 'ft_remove_page_templates' );
		$templates = get_page_templates();

		$this->assertNotContains( 'page_archive.php', $templates, 'Archive page template still exists!' );
		$this->assertNotContains( 'page_blog.php', $templates, 'Archive page template still exists!' );
	}

	public function test_business_archive_is_present() {
		$templates = get_page_templates();
		$this->assertContains( 'templates/page-business.php', $templates );		
	}
}
