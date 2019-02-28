<?php
namespace CakeUpload\Data\DataManager;

use CakeUpload\Data\DataManager\DataManagerInterface;
use Psr\Http\Message\UploadedFileInterface;
use Cake\ORM\Table;
use Cake\ORM\Entity;

use function \Zend\Diactoros\createUploadedFile;

/**
 * Description of DefaultDataManager
 *
 * @author Radoslav Cholakov <rdch@mail.bg>
 */
class DataManager implements DataManagerInterface
{
    /**
     * Table instance
     * 
     * @var Table 
     */
    protected $_table;
    
    /**
     * Entity instance
     * 
     * @var Entity 
     */
    protected $_entity;
    
    /**
     * Array of Upload data
     * 
     * @var array 
     */
    protected $_data;
    
    /**
     * Path relative to CakePHP webroot directory
     * 
     * @var string 
     */
    protected $_path;
    
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
     * Constructor
     *  
     * @param Table $table Table instance
     * @param Entity $entity Entity instance
     * @param array $data Upload data contained in field
     * @param string $path Path relative to CakePHP webroot directory
     * @param string $field Field name
     * @param array $settings Field settings
     * @return void
     */
    public function __construct(Table $table, Entity $entity, array $data, string $path, string $field, array $settings)
    {
        $this->_table = $table;
        $this->_entity = $entity;
        $this->_data = $data;
        $this->_path = $path;
        $this->_field = $field;
        $this->_settings = $settings;
    }
    
    /**
     * Build data
     * 
     * @param none
     * @return array array with PSR-7 Uploaded Files
     */
    public function build() : array
    {
        return $this->_build();
    }
    
    /**
     * Build data as array with PSR-7 Uploaded Files.
     * 
     * @param none
     * @return array
     */
    protected function _build() : array
    {
        $data = $this->_data;
        $file = $this->_convertUploadedFile($data);
        
        $builtData[] = $file;
        
        return $builtData;
    }
    
    /**
     * Cast flat PHP uploaded file to PSR-7 Uploaded File object.
     * 
     * @param array $file
     * @return UploadedFileInterface
     */
    protected function _convertUploadedFile(array $file) : UploadedFileInterface
    {
        return createUploadedFile($file);
    }
}
