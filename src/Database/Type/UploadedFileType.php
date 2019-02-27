<?php
namespace CakeUpload\Database\Type;

use Cake\Database\Type;
use Cake\Utility\Hash;
use Cake\Database\Driver;
use PDO;

/**
 * UploadedFileType class encapsulate functionality to cast flat PHP uploaded
 * file between PHP and Database to their appropriate type.
 *
 * @author Radoslav Cholakov <rdch@mail.bg>
 */
class UploadedFileType extends Type
{
    /**
     * Marshalls flat data into PHP object
     * 
     * @param array $value Single or multiple PHP uploaded files
     * @return array 
     */
    public function marshal($value)
    {
        return $value;
    }
    
    /**
     * Cast data to its Statement equivalent.
     * 
     * @param array|NULL $value
     * @param Driver $driver
     * @return PDO
     */
    public function toStatement($value, Driver $driver)
    {
        if (NULL === $value) {
            return PDO::PARAM_NULL;
        }
        
        return PDO::PARAM_STR;
    }
    
    /**
     * Casts data from a PHP type to one acceptable by a database.
     * 
     * The case when data is string is defined for convenience when find records
     * in DB, during validation process and etc. Its avoid the need to transform
     * data again.
     * 
     * @param array|string|NULL $value Single flat PHP uploaded files, file name or NULL.
     * @param Driver $driver
     * @return string|NULL File name or NULL
     */
    public function toDatabase($value, Driver $driver)
    {
        if (is_array($value)) {
            if (Hash::get($value, 'name') !== NULL) {
                return $value['name'];
            }
        }
        
        if (is_string($value)) {
            return $value;
        }
        
        return NULL;
    }
    
    /**
     * Casts data from a database type to PHP equivalent.
     * 
     * @param string|NULL $value
     * @param Driver $driver
     * @return string|NULL 
     */
    public function toPHP($value, Driver $driver)
    {
        return $value;
    }
}
