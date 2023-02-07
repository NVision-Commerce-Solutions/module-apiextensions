<?php

namespace Commerce365\MagentoApiExtensions\Plugin;

use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Catalog\Model\Attribute as AttributeModel;

class ProductAttributeExtensionAttributes
{
    public function afterGetAttributes(
        \Magento\Catalog\Api\ProductAttributeManagementInterface $subject, 
        $searchResult
    ) {
        foreach ($searchResult as &$attribute) {
            $extensionAttributes = $attribute->getExtensionAttributes();
            if($attribute->getAttributeGroupId()){
                $extensionAttributes->setAttributeGroupId($attribute->getAttributeGroupId()); 
                $extensionAttributes->setEntityAttributeId($attribute->getEntityAttributeId()); 
                $extensionAttributes->setSortOrder($attribute->getSortOrder()); 
            }
            $attribute->setExtensionAttributes($extensionAttributes);
        }
        return $searchResult;
    }
}
