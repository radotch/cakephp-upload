<?php
namespace CakeUpload\Data\Path;

use Cake\ORM\Table;
use Cake\Utility\Hash;

/**
 * Description of PathManager
 *
 * @author Radoslav Cholakov <rdch@mail.bg>
 */
class PathManager
{
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
     * Default path relative to CakePHP webroot directory
     * 
     * @var string  
     */
    protected $_defaultPath;
    
    /**
     * Path relative to CakePHP webroot directory
     * 
     * @var string 
     */
    protected $_path;

    /**
     * Constructor
     * 
     * @param string $field
     * @param array $settings
     */
    public function __construct(Table $table, string $field, array $settings)
    {
        $this->_table = $table;
        $this->_field = $field;
        $this->_settings = $settings;
        
        $this->_defaultPath = 'files' . DS . $this->_table->getAlias() . DS . $field;
        $this->_path = Hash::get($settings, 'path');
    }
    
    /**
     * Get configured path for field without starting or trailing slashes.
     * When path is not configured, empty or NULL, default path is used.
     * 
     * @return string
     */
    public function getPath() : string
    {
        if (empty($this->_path)) {
            $this->_path = $this->_defaultPath;
        }
        
        return trim($this->_path, '/\\ ');
    }
    
    /**
     * Get default path for field without starting or trailing slashes.
     * 
     * Default path schema is: files/{$model}/{$field}
     * 
     * @return string
     */
    public function getDefaultPath() : string
    {
        return trim($this->_defaultPath, '/\\ ');
    }
}
