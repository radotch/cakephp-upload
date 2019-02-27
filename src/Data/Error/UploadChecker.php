<?php
namespace CakeUpload\Data\Error;

use Cake\ORM\Entity;
use Cake\Utility\Hash;
use CakeUpload\Data\Error\UploadError;

/**
 * UploadChecker
 *
 * @author Radoslav Cholakov <rdch@mail.bg>
 */
class UploadChecker
{
    /**
     * Entity instance
     * 
     * @var Entity 
     */
    protected $_entity;
    
    /**
     * Field names 
     * 
     * @var array  
     */
    protected $_fields;
    
    /**
     * Upload data errors 
     * 
     * @var array Empty or array with errors
     */
    protected $_errors;
    
    /**
     * Constructor 
     * 
     * @param Entity $entity
     * @param array $fields Array with field names 
     */
    public function __construct(Entity $entity, array $fields)
    {
        $this->_entity = $entity;
        $this->_fields = $fields;
        $this->_errors = [];
        
        $this->_check();
    }
    
    /**
     * Check uploaded data if contains upload error. The method is able to check
     * single or multiple uploaded files.
     * 
     * @return $this
     */
    protected function _check()
    {
        $errorManager = new UploadError();
        foreach ($this->_fields as $field) {
            $upload = $this->_entity->get($field);
            if ($upload === NULL) {
                continue;
            }
            
            if (Hash::get($upload, 'error') !== NULL) {
                $tmpUpload[] = $upload;
                $upload = $tmpUpload;
            }
            
            foreach ($upload as $file) {
                if ($file['error'] === UPLOAD_ERR_OK) {
                    continue;
                }
                
                $this->_errors[$field][] = $errorManager->getMessage($file['error'], $file['name']);
            }
        }
        
        return $this;
    }
    
    /**
     * Indicate are there any errors found in uploaded files.
     * 
     * @return boolean TRUE if found errors in the uploaded files, otherwise FALSE
     */
    public function hasErrors()
    {
        if (empty($this->_errors)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Get upload data errors associated to fields.
     * 
     * @return array Empty or array with errors.
     */
    public function getErrors()
    {
        return $this->_errors;
    }
}
