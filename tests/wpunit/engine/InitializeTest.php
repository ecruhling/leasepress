<?php

class InitializeTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @var string
	 */
	protected $root_dir;

	public function setUp() {
		parent::setUp();

		// your set up methods here
		$this->root_dir = dirname( dirname( dirname( __FILE__ ) ) );

        wp_set_current_user(0);
        wp_logout();
        wp_safe_redirect(wp_login_url());
	}

	public function tearDown() {
		parent::tearDown();
	}

	private function make_instance() {
		return new L_Initialize();
	}

	/**
	 * @test
	 * it should be instantiatable
	 */
	public function it_should_be_instantiatable() {
		$sut = $this->make_instance();
		$this->assertInstanceOf( 'L_Initialize', $sut );
	}

	/**
	 * @test
	 * it should be front
	 */
	public function it_should_be_front() {
		$sut = $this->make_instance();

		$classes   = array();
		$classes[] = 'L_PostTypes';
		$classes[] = 'L_CMB';
		$classes[] = 'L_Cron';
		$classes[] = 'L_FakePage';
		$classes[] = 'L_Template';
		$classes[] = 'L_Widgets';
		$classes[] = 'L_Rest';
		$classes[] = 'L_Transient';
		$classes[] = 'L_Ajax';
		$classes[] = 'L_Enqueue';
		$classes[] = 'L_Extras';

		$this->assertEquals( $classes, $sut->classes );
	}

}
