# Overwrite cart templates
plugin.tx_cart {
        view {
            templateRootPaths.100 = EXT:cartproductreader/Resources/Ext/cart/Templates/
            partialRootPaths.100 = EXT:cartproductreader/Resources/Ext/cart/Partials/
            layoutRootPaths.100 = EXT:cartproductreader/Resources/Ext/cart/Layouts/
        }
}

# Overwrite cart_products templates
plugin.tx_cartproducts {
        view {
            templateRootPaths.100 = EXT:cartproductreader/Resources/Ext/cartproducts/Templates/
            partialRootPaths.100 = EXT:cartproductreader/Resources/Ext/cartproducts/Partials/
            layoutRootPaths.100 = EXT:cartproductreader/Resources/Ext/cartproducts/Layouts/
        }
}

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

page {
    # Caching
#    noCache = 0 

    #config.cache.16 = tx_staffm_domain_model_mitarbeiter:42,tx_staffm_domain_model_kostenstelle:53

    includeCSS {        
        staffm1 = EXT:cartproductreader/Resources/Public/Css/style.css
    }

    includeJSFooter {
        # load own Javascript immediatelly with complete website
        jquery1 = EXT:cartproductreader/Resources/Public/Js/ownfunctions.js
    }
}