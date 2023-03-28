<?php
namespace Commerce365\MagentoApiExtensions\Model;
use Commerce365\MagentoApiExtensions\Api\CategoryManagementInterface;
 
class Category implements CategoryManagementInterface
{

    /**
     * Put category position (within tree)
     *
     * @api
     * @param int $categoryId 
     * @param int $new
     * @return boolean
     */    
    public function updatePosition($categoryId, $new){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $category = $objectManager->create('Magento\Catalog\Model\Category')->load($categoryId);

        if (!$category->getId())
            throw new \Exception("Category does not exist");

        $category->setPosition($new);

        $objectManager->get('\Magento\Catalog\Api\CategoryRepositoryInterface')->save($category);

        return true;
    }
    
}
