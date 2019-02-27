<?php
namespace CakeUpload\Test\TestCase\Model\Behavior;

use CakeUpload\Model\Behavior\UploadableBehavior;
use Cake\TestSuite\TestCase;

/**
 * CakeUpload\Model\Behavior\UploadableBehavior Test Case
 */
class UploadableBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \CakeUpload\Model\Behavior\UploadableBehavior
     */
    public $Uploadable;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Uploadable = new UploadableBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Uploadable);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
