
# Module configuration
module.tx_cartproductreader_cart_cartproductreadercartproductreader {
    persistence {
        storagePid = {$module.tx_cartproductreader_cartproductreader.persistence.storagePid}
    }
    view {
        templateRootPaths.0 = EXT:cartproductreader/Resources/Private/Backend/Templates/
        templateRootPaths.1 = {$module.tx_cartproductreader_cartproductreader.view.templateRootPath}
        partialRootPaths.0 = EXT:cartproductreader/Resources/Private/Backend/Partials/
        partialRootPaths.1 = {$module.tx_cartproductreader_cartproductreader.view.partialRootPath}
        layoutRootPaths.0 = EXT:cartproductreader/Resources/Private/Backend/Layouts/
        layoutRootPaths.1 = {$module.tx_cartproductreader_cartproductreader.view.layoutRootPath}
    }
}
