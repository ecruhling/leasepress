<?php

class InitializeAdminTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * @var string
	 */
	protected $root_dir;

	public function setUp() {
		parent::setUp();

		// your set up methods here
		$this->root_dir = dirname( dirname( dirname( __FILE__ ) ) );

        $user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		$user = wp_set_current_user( $user_id );
		set_current_screen( 'edit.php' );
	}

	public function tearDown() {
		parent::tearDown();
	}

	private function make_instance() {
		return new L_Initialize();
	}

	/**
	 * @test
	 * it should be admin
	 */
	public function it_should_be_admin() {
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
 		$classes[] = 'LP_Ajax_Admin';
		$classes[] = 'LP_Pointers';
		$classes[] = 'LP_ContextualHelp';
		$classes[] = 'LP_Admin_ActDeact';
		$classes[] = 'LP_Admin_Notices';
		$classes[] = 'LP_Admin_Settings_Page';
		$classes[] = 'LP_Admin_Enqueue';
		$classes[] = 'LP_Admin_ImpExp';
		$classes[] = 'LP_Enqueue';
		$classes[] = 'LP_Extras';

		$this->assertTrue( is_admin() );
		$this->assertEquals( $classes, $sut->classes );
	}

}
