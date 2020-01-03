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


plugin.tx_cartproductreader_cartproduct {
	view {
		templateRootPath = {$plugin.tx_cartproductreader_cartproduct.view.templateRootPath}
		partialRootPath = {$plugin.tx_cartproductreader_cartproduct.view.partialRootPath}
		layoutRootPath = {$plugin.tx_cartproductreader_cartproduct.view.layoutRootPath}
	}
	persistence {
		storagePid = {$module.tx_cartproductreader_cartproductreader.persistence.storagePid}                
	}        
	features {
		# uncomment the following line to enable the new Property Mapper.
		# rewrittenPropertyMapper = 1
	}
}

# Module configuration
module.tx_cartproductreader_cart_cartproductreadercartproductreader {
    view {
        templateRootPaths.0 = EXT:cartproductreader/Resources/Private/Backend/Templates/
        templateRootPaths.1 = {$module.tx_cartproductreader_cartproductreader.view.templateRootPath}
        partialRootPaths.0 = EXT:cartproductreader/Resources/Private/Backend/Partials/
        partialRootPaths.1 = {$module.tx_cartproductreader_cartproductreader.view.partialRootPath}
        layoutRootPaths.0 = EXT:cartproductreader/Resources/Private/Backend/Layouts/
        layoutRootPaths.1 = {$module.tx_cartproductreader_cartproductreader.view.layoutRootPath}
    }
    persistence {
        storagePid = {$module.tx_cartproductreader_cartproductreader.persistence.storagePid}
        feVariantOption = {$module.tx_cartproductreader_cartproductreader.persistence.feVariantOption}
        catTypesNumber = {$module.tx_cartproductreader_cartproductreader.persistence.catTypesNumber}
        fileUploadCharakter = {$module.tx_cartproductreader_cartproductreader.persistence.fileUploadCharakter}
    }
    colours {
        corporateColour = {$module.tx_cartproductreader_cartproductreader.colours.corporateColour}
        linkColourFontHover = {$module.tx_cartproductreader_cartproductreader.colours.linkColourFontHover}
        defaultButtonFontColour = {$module.tx_cartproductreader_cartproductreader.colours.defaultButtonFontColour}
        defaultButtonBackgroundColour = {$module.tx_cartproductreader_cartproductreader.colours.defaultButtonBackgroundColour}
        defaultButtonBorderColour = {$module.tx_cartproductreader_cartproductreader.colours.defaultButtonBorderColour}
        defaultButtonFontColourHover = {$module.tx_cartproductreader_cartproductreader.colours.defaultButtonFontColourHover}
        defaultButtonBackgroundColourHover = {$module.tx_cartproductreader_cartproductreader.colours.defaultButtonBackgroundColourHover}
        defaultButtonBorderColourHover = {$module.tx_cartproductreader_cartproductreader.colours.defaultButtonBorderColourHover}
        primaryButtonFontColour = {$module.tx_cartproductreader_cartproductreader.colours.primaryButtonFontColour}
        primaryButtonBackgroundColour = {$module.tx_cartproductreader_cartproductreader.colours.primaryButtonBackgroundColour}
        primaryButtonBorderColour = {$module.tx_cartproductreader_cartproductreader.colours.primaryButtonBorderColour}
        primaryButtonFontColourHover = {$module.tx_cartproductreader_cartproductreader.colours.primaryButtonFontColourHover}
        primaryButtonBackgroundColourHover = {$module.tx_cartproductreader_cartproductreader.colours.primaryButtonBackgroundColourHover}
        primaryButtonBorderColourHover = {$module.tx_cartproductreader_cartproductreader.colours.primaryButtonBorderColourHover}
    }
}

plugin.tx_cartproducts._CSS_DEFAULT_STYLE (	
        .tx-cart-products .griditem:hover {    
            background-color: {$module.tx_cartproductreader_cartproductreader.colours.corporateColour};
            color: {$module.tx_cartproductreader_cartproductreader.colours.linkColourFontHover};
        }
        .tx-cart-products .griditem:hover a {    
            color: {$module.tx_cartproductreader_cartproductreader.colours.linkColourFontHover};
        }
        .tx-cart .btn-default, .tx-cart-products .btn-default {
            color: {$module.tx_cartproductreader_cartproductreader.colours.defaultButtonFontColour};
            background-color: {$module.tx_cartproductreader_cartproductreader.colours.defaultButtonBackgroundColour};
            border-color:{$module.tx_cartproductreader_cartproductreader.colours.defaultButtonBorderColour};
        }
        .tx-cart .btn-default:hover, .tx-cart-products .btn-default:hover {
            color: {$module.tx_cartproductreader_cartproductreader.colours.defaultButtonFontColourHover};
            background-color: {$module.tx_cartproductreader_cartproductreader.colours.defaultButtonBackgroundColourHover};
            border-color: {$module.tx_cartproductreader_cartproductreader.colours.defaultButtonBorderColourHover};
        }
        .tx-cart .btn-primary, .tx-cart-products .btn-primary {
            color: {$module.tx_cartproductreader_cartproductreader.colours.primaryButtonFontColour};
            background-color: {$module.tx_cartproductreader_cartproductreader.colours.primaryButtonBackgroundColour};
            border-color: {$module.tx_cartproductreader_cartproductreader.colours.primaryButtonBorderColour};
        }
        .tx-cart .btn-primary:hover, .tx-cart-products .btn-primary:hover {
            color: {$module.tx_cartproductreader_cartproductreader.colours.primaryButtonFontColourHover};
            background-color: {$module.tx_cartproductreader_cartproductreader.colours.primaryButtonBackgroundColourHover};
            border-color: {$module.tx_cartproductreader_cartproductreader.colours.primaryButtonBorderColourHover};
        }
        .tx-cart a:hover, .tx-cart-products a :hover {
            color: {$module.tx_cartproductreader_cartproductreader.colours.linkColourFontHover};
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