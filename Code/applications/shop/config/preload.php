<?php

if (file_exists('/tmp/shop/cache/prod/CoolDevGuys_Applications_Shop_ShopKernelProdContainer.preload.php')) {
    require '/tmp/shop/cache/prod/CoolDevGuys_Applications_Shop_ShopKernelProdContainer.preload.php';
} else if (file_exists('/tmp/shop/cache/staging/CoolDevGuys_Applications_Shop_ShopKernelStagingContainer.preload.php')) {
    require '/tmp/shop/cache/staging/CoolDevGuys_Applications_Shop_ShopKernelStagingContainer.preload.php';
}
