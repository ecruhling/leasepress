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
		$this->assertInstanceOf( 'LP_Initialize', $sut );
	}

	/**
	 * @test
	 * it should be front
	 */
	public function it_should_be_front() {
		$sut = $this->make_instance();

		$classes   = array();
		$classes[] = 'LP_PostTypes';
		$classes[] = 'LP_CMB';
		$classes[] = 'LP_Cron';
		$classes[] = 'LP_FakePage';
		$classes[] = 'LP_Template';
		$classes[] = 'LP_Widgets';
		$classes[] = 'LP_Rest';
		$classes[] = 'LP_Transient';
		$classes[] = 'LP_Ajax';
		$classes[] = 'LP_Enqueue';
		$classes[] = 'LP_Extras';

		$this->assertEquals( $classes, $sut->classes );
	}

}
