<?php
namespace CakeUpload\Test\TestCase\Data\Path;

use Cake\ORM\Table;
use CakeUpload\Data\Path\PathManager;
use Cake\TestSuite\TestCase;

/**
 * Description of PathManagerTest
 *
 * @author Radoslav Cholakov <rdch@mail.bg>
 */
class PathManagerTest extends TestCase
{
    /**
     * PathManager instance
     * 
     * @var PathManager 
     */
    protected $PathManager;
    
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
        
        $this->PathManager = new PathManager($this->_table, $this->_field, $this->_settings);
    }
    
    /**
     * tearDown hook
     * 
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PathManager);
        
        parent::tearDown();
    }
    
    /**
     * 
     */
    public function testGetPath()
    {
        $path = $this->PathManager->getPath();
        
        $this->assertTrue(is_string($path), __d('upload-plugin', 'Method must return string, but got {0}', gettype($path)));
        $this->assertEquals($this->_settings['path'], $path);
    }
    
    /**
     * 
     */
    public function testGetPathMethodReturnDefaultPathWhenPathIsNotConfigured()
    {
        $this->PathManager = new PathManager($this->_table, $this->_field, []);
        
        $expected = $this->PathManager->getDefaultPath();
        $path = $this->PathManager->getPath();
        
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
        $this->PathManager = new PathManager($this->_table, $this->_field, ['path' => NULL]);
        
        $expected = $this->PathManager->getDefaultPath();
        $path = $this->PathManager->getPath();
        
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
        $this->PathManager = new PathManager($this->_table, $this->_field, ['path' => '']);
        
        $expected = $this->PathManager->getDefaultPath();
        $path = $this->PathManager->getPath();
        
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
        $this->PathManager = new PathManager($this->_table, $this->_field, ['path' => '/path/to/move/']);
        $path = $this->PathManager->getPath();
        
        $this->assertStringStartsNotWith('/', $path, __d('upload-plugin', 'Default path MUST NOT starts with slash'));
        $this->assertStringEndsNotWith('/', $path, __d('upload-plugin', 'Default path MUST NOT ends with slash'));
        
        $this->PathManager = new PathManager($this->_table, $this->_field, ['path' => '\\path/to/move\\']);
        $path = $this->PathManager->getPath();
        
        $this->assertStringStartsNotWith('\\', $path, __d('upload-plugin', 'Default path MUST NOT starts with backslash'));
        $this->assertStringEndsNotWith('\\', $path, __d('upload-plugin', 'Default path MUST NOT ends with backslash'));
    }
    
    /**
     * 
     */
    public function testGetDefaultPath()
    {
        $defaultPath = $this->PathManager->getDefaultPath();
        
        $this->assertTrue(is_string($defaultPath), __d('upload-plugin', 'Must return string but got {0}', gettype($defaultPath)));
    }
    
    /**
     * 
     */
    public function testGetDefaultPathMethodReturnsValueDefinition()
    {
        $defaultPath = $this->PathManager->getDefaultPath();
        $expected = 'files' . DS . $this->_table->getAlias() . DS . $this->_field;
        
        $this->assertEquals($expected, $defaultPath, __d('upload-plugin', 'Default path definition must be "files/{$model}/{$field}"'));
        
    }
    
    /**
     * 
     */
    public function testGetDefaultPathMethodReturnsValueWitoutStartingOrTrailingDirectorySeparator()
    {
        $this->PathManager = new PathManager($this->_table, $this->_field, []);
        $defaultPath = $this->PathManager->getDefaultPath();
        
        $this->assertStringStartsNotWith('/', $defaultPath, __d('upload-plugin', 'Default path MUST NOT starts with slash'));
        $this->assertStringEndsNotWith('/', $defaultPath, __d('upload-plugin', 'Default path MUST NOT ends with slash'));
        
        $this->assertStringStartsNotWith('\\', $defaultPath, __d('upload-plugin', 'Default path MUST NOT starts with backslash'));
        $this->assertStringEndsNotWith('\\', $defaultPath, __d('upload-plugin', 'Default path MUST NOT ends with backslash'));
    }
}
