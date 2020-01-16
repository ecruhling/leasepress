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
		$classes[] = 'L_PostTypes';
		$classes[] = 'L_CMB';
		$classes[] = 'L_Cron';
		$classes[] = 'L_FakePage';
		$classes[] = 'L_Template';
		$classes[] = 'L_Widgets';
		$classes[] = 'L_Rest';
		$classes[] = 'L_Transient';
 		$classes[] = 'L_Ajax';
 		$classes[] = 'L_Ajax_Admin';
		$classes[] = 'L_Pointers';
		$classes[] = 'L_ContextualHelp';
		$classes[] = 'L_Admin_ActDeact';
		$classes[] = 'L_Admin_Notices';
		$classes[] = 'L_Admin_Settings_Page';
		$classes[] = 'L_Admin_Enqueue';
		$classes[] = 'L_Admin_ImpExp';
		$classes[] = 'L_Enqueue';
		$classes[] = 'L_Extras';

		$this->assertTrue( is_admin() );
		$this->assertEquals( $classes, $sut->classes );
	}

}
