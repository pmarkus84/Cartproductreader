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

plugin.tx_cart {
#    shippings {
#        countries {
#            de {
#               preset = 1
#               options {
#                   1 {
#                       title = Standard
#                       extra = 0.00
#                       taxClassId = 1
#                       status = open
#                   }
#                   2 {
#                       title = Express
#                       extra = 3.50
#                       taxClassId = 1
#                       status = closed
#                   }
#               }
#            }
#            at < .de
#            ch < .de
#        }
#    }
}

# Module configuration
module.tx_cartproductreader_cart_cartproductreadercartproductreader {
    persistence {
        storagePid = {$module.tx_cartproductreader_cartproductreader.persistence.storagePid}
        feVariantOption = {$module.tx_cartproductreader_cartproductreader.persistence.feVariantOption}
        fileUploadCharakter = {$module.tx_cartproductreader_cartproductreader.persistence.fileUploadCharakter}
        corporateColour = {$module.tx_cartproductreader_cartproductreader.persistence.corporateColour}
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

plugin.tx_cartproducts._CSS_DEFAULT_STYLE (	
        .griditem:hover {    
            background-color: {$module.tx_cartproductreader_cartproductreader.persistence.corporateColour};
        }
)

page {
    # Caching
#    noCache = 0 

    #config.cache.16 = tx_staffm_domain_model_mitarbeiter:42,tx_staffm_domain_model_kostenstelle:53

    includeCSS {        
        cartproductreader = EXT:cartproductreader/Resources/Public/Css/style.css
    }

    includeJSFooter {
        # load own Javascript immediatelly with complete website
        jquery1 = EXT:cartproductreader/Resources/Public/Js/ownfunctions.js
    }
}