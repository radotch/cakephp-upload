<?php
namespace CakeUpload\Data\DataManager;

use Cake\ORM\Table;
use Cake\ORM\Entity;

/**
 *
 * @author Radoslav Cholakov <rdch@mail.bg>
 */
interface DataManagerInterface
{
    public function __construct(Table $table, Entity $entity, array $data, string $path, string $field, array $settings);
    
    /**
     * Build data in proper format
     */
    public function build() : array;
}
