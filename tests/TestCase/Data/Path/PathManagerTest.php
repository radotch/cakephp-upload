<?php
namespace CakeUpload\Test\TestCase\Data\Path;

use Cake\ORM\Table;
use CakeUpload\File\Path\DefaultPathManager;
use Cake\TestSuite\TestCase;

/**
 * Description of DefaultPathManagerTest
 *
 * @author Radoslav Cholakov <rdch@mail.bg>
 */
class PathManagerTest extends TestCase
{
    /**
     * DefaultPathManager instance
     * 
     * @var DefaultPathManager 
     */
    protected $DefaultPathManager;
    
    /**
     * Table instance
     * 
     * @var Table 
     */
    protected $_table;
    
    /**
     * Field name
     * 
     * @var string 
     */
    protected $_field;
    
    /**
     * Field settings
     * 
     * @var array 
     */
    protected $_settings;
    
    /**
     * setUp hook
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        
        $this->_table = new Table(['alias' => 'TestTable']);
        $this->_field = 'testField';
        $this->_settings = ['path' => 'path/where/to/move'];
        
        $this->DefaultPathManager = new DefaultPathManager($this->_table, $this->_field, $this->_settings);
    }
    
    /**
     * tearDown hook
     * 
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DefaultPathManager);
        
        parent::tearDown();
    }
    
    /**
     * 
     */
    public function testGetPath()
    {
        $path = $this->DefaultPathManager->getPath();
        
        $this->assertTrue(is_string($path), __d('upload-plugin', 'Method must return string, but got {0}', gettype($path)));
        $this->assertEquals($this->_settings['path'], $path);
    }
    
    /**
     * 
     */
    public function testGetPathMethodReturnDefaultPathWhenPathIsNotConfigured()
    {
        $this->DefaultPathManager = new DefaultPathManager($this->_table, $this->_field, []);
        
        $expected = $this->DefaultPathManager->getDefaultPath();
        $path = $this->DefaultPathManager->getPath();
        
        $this->assertEquals($expected, $path, __d('upload-plugin', 'Failed to return default path when path is not in field configuration.'));
    }
    
    /**
     * Test that method return default path when path in field configuration is NULL
     * 
     * @param none
     * @return void
     */
    public function testGetPathMethodReturnDefaultPathWhenPathIsNull()
    {
        $this->DefaultPathManager = new DefaultPathManager($this->_table, $this->_field, ['path' => NULL]);
        
        $expected = $this->DefaultPathManager->getDefaultPath();
        $path = $this->DefaultPathManager->getPath();
        
        $this->assertEquals($expected, $path, __d('upload-plugin', 'Failed to return default path when path is NULL.'));
    }
    
    /**
     * Test that method return default path when path in field configuration is empty
     * 
     * @param none
     * @return void
     */
    public function testGetPathMethodReturnDefaultPathWhenPathIsEmpty()
    {
        $this->DefaultPathManager = new DefaultPathManager($this->_table, $this->_field, ['path' => '']);
        
        $expected = $this->DefaultPathManager->getDefaultPath();
        $path = $this->DefaultPathManager->getPath();
        
        $this->assertEquals($expected, $path, __d('upload-plugin', 'Failed to return default path when path is empty.'));
    }
    
    /**
     * Test that method return default return string without starting or trailing directory separator
     * 
     * @param none
     * @return void
     */
    public function testGetPathMethodReturnValueWithoutStartingOrTrailingDirectorySeparator()
    {
        $this->DefaultPathManager = new DefaultPathManager($this->_table, $this->_field, ['path' => '/path/to/move/']);
        $path = $this->DefaultPathManager->getPath();
        
        $this->assertStringStartsNotWith('/', $path, __d('upload-plugin', 'Default path MUST NOT starts with slash'));
        $this->assertStringEndsNotWith('/', $path, __d('upload-plugin', 'Default path MUST NOT ends with slash'));
        
        $this->DefaultPathManager = new DefaultPathManager($this->_table, $this->_field, ['path' => '\\path/to/move\\']);
        $path = $this->DefaultPathManager->getPath();
        
        $this->assertStringStartsNotWith('\\', $path, __d('upload-plugin', 'Default path MUST NOT starts with backslash'));
        $this->assertStringEndsNotWith('\\', $path, __d('upload-plugin', 'Default path MUST NOT ends with backslash'));
    }
    
    /**
     * 
     */
    public function testGetDefaultPath()
    {
        $defaultPath = $this->DefaultPathManager->getDefaultPath();
        
        $this->assertTrue(is_string($defaultPath), __d('upload-plugin', 'Must return string but got {0}', gettype($defaultPath)));
    }
    
    /**
     * 
     */
    public function testGetDefaultPathMethodReturnsValueDefinition()
    {
        $defaultPath = $this->DefaultPathManager->getDefaultPath();
        $expected = 'files' . DS . $this->_table->getAlias() . DS . $this->_field;
        
        $this->assertEquals($expected, $defaultPath, __d('upload-plugin', 'Default path definition must be "files/{$model}/{$field}"'));
        
    }
    
    /**
     * 
     */
    public function testGetDefaultPathMethodReturnsValueWitoutStartingOrTrailingDirectorySeparator()
    {
        $this->DefaultPathManager = new DefaultPathManager($this->_table, $this->_field, []);
        $defaultPath = $this->DefaultPathManager->getDefaultPath();
        
        $this->assertStringStartsNotWith('/', $defaultPath, __d('upload-plugin', 'Default path MUST NOT starts with slash'));
        $this->assertStringEndsNotWith('/', $defaultPath, __d('upload-plugin', 'Default path MUST NOT ends with slash'));
        
        $this->assertStringStartsNotWith('\\', $defaultPath, __d('upload-plugin', 'Default path MUST NOT starts with backslash'));
        $this->assertStringEndsNotWith('\\', $defaultPath, __d('upload-plugin', 'Default path MUST NOT ends with backslash'));
    }
}
