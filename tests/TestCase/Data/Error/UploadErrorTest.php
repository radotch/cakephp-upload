<?php
namespace CakeUpload\Test\TestCase\Data\Error;

use Cake\TestSuite\TestCase;
use CakeUpload\Data\Error\UploadError;
use ReflectionClass;
use Exception;
use ArgumentCountError;
use TypeError;

/**
 * Description of UploadErrorTest
 *
 * @author Radoslav Cholakov <rdch@mail.bg>
 */
class UploadErrorTest extends TestCase
{
    private $UploadError;
    
    /**
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        
        $this->UploadError = new UploadError();
    }
    
    /**
     * 
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UploadError);
        
        parent::tearDown();
    }
    
    /**
     * Test if method getMessage exists.
     * Test number of parameters.
     * 
     * @param none
     * @return void
     */
    public function testGetMessageMethodExists()
    {
        $class = new ReflectionClass($this->UploadError);
        
        $this->assertTrue($class->hasMethod('getMessage'));
        
        $method = $class->getMethod('getMessage');
        $params = $method->getParameters();
        
        $expected = 2;
        $numberOfParams = count($params);
        $message = sprintf('The method getMessage() must accept exactly %d parameters, but found %d', $expected, $numberOfParams);
        
        $this->assertEquals($expected, $numberOfParams, $message);
    }
    
    /**
     * Test returned value type.
     * 
     * @param none
     * @return void
     */
    public function testGetMessageMethodReturnsString()
    {
        $fileName = 'file.ext';
        $errCode = UPLOAD_ERR_OK;
        
        $result = $this->UploadError->getMessage($errCode, $fileName);
        
        $this->assertTrue(is_string($result), 'Method must return string, but return ' . gettype($result));
    }
    
    /**
     * Test method called without params. Expectation is to throw exception.
     * 
     * @param none
     * @return void
     */
    public function testGetMessageMethodThrowsExceptionWhenCalledWithoutParams()
    {
        $this->expectException(ArgumentCountError::class);
        
        $this->UploadError->getMessage();
    }
    
    /**
     * 
     * @param none
     * @return void
     */
    public function testGetMessageMethodThrowsExceptionWhenCalledWithOnlyOneParam()
    {
        $errCode = UPLOAD_ERR_OK;
        
        $this->expectException(ArgumentCountError::class);
        
        $this->UploadError->getMessage($errCode);
    }
    
    /**
     * Test method with wrong type of first parameter. Must rise exception of 
     * type TypeError
     * 
     * @param none
     * @return void
     */
    public function testGetMessageMethodThrowsExceptionWhenFirstParamIsNotInteger()
    {
        $wrongErrCode = 'blabla';
        $fileName = 'file.ext';
        
        $this->expectException(TypeError::class);
        
        $this->UploadError->getMessage($wrongErrCode, $fileName);
    }
    
    /**
     * Test method when second parameter has wrong type. Expect to rise exception
     * of type TypeError.
     * 
     * @param none
     * @return void
     */
    public function testGetMessageMethodThrowsExceptionWhenSecondParamIsNotString()
    {
        $wrongErrCode = UPLOAD_ERR_OK;
        $fileName = [25, 33];
        
        $this->expectException(TypeError::class);
        
        $this->UploadError->getMessage($wrongErrCode, $fileName);
    }
}
