<?php

namespace Nabil\MVC\controller;

class ProductController
{
    // funtion categori, dengan param productId dan categoryId
    function categories(string $productId, string $categoryId): void
    {
        echo "PRODUCT $productId, CATEGORY $categoryId";
    }
}
