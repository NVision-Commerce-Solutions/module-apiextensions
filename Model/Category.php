<?php

namespace Commerce365\MagentoApiExtensions\Model;

use Commerce365\MagentoApiExtensions\Api\CategoryManagementInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;

class Category implements CategoryManagementInterface
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Put category position (within tree)
     *
     * @api
     * @param int $categoryId
     * @param int $new
     * @return boolean
     */
    public function updatePosition($categoryId, $new)
    {
        $category = $this->categoryRepository->get($categoryId);
        $category->setPosition($new);
        $this->categoryRepository->save($category);

        return true;
    }

}
