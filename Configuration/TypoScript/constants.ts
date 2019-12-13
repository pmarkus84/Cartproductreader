// Frontend-Plugins (tx, x steht für alle Plugins)
plugin.tx_cartproductreader_cartproduct {
	view {
		# cat=plugin.tx_cartproductreader/file; type=string; label=Path to template root (FE)
		templateRootPath = EXT:cartproductreader/Resources/Private/Templates/
		# cat=plugin.tx_cartproductreader/file; type=string; label=Path to template partials (FE)
		partialRootPath = EXT:cartproductreader/Resources/Private/Partials/
		# cat=plugin.tx_cartproductreader/file; type=string; label=Path to template layouts (FE)
		layoutRootPath = EXT:cartproductreader/Resources/Private/Layouts/
	}
	persistence {              
		# cat=plugin.tx_staffm//a; type=string; label=Default storage PID
		storagePid =                 
	}
}

#customcategory=mysite=Cartproductreader
# customsubcategory=config=LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:config
# customsubcategory=colours=LLL:EXT:cartproductreader/Resources/Private/Language/locallang.xlf:colours
module.tx_cartproductreader_cartproductreader {
    view {
        # cat=mysite/file/a; type=string; label=Path to template root (BE)
        templateRootPath = EXT:cartproductreader/Resources/Private/Backend/Templates/
        # cat=mysite/file/b; type=string; label=Path to template partials (BE)
        partialRootPath = EXT:cartproductreader/Resources/Private/Backend/Partials/
        # cat=mysite/file/c; type=string; label=Path to template layouts (BE)
        layoutRootPath = EXT:cartproductreader/Resources/Private/Backend/Layouts/
    }
    persistence {
        # cat=mysite/config/a; type=string; label=Default storage PID
        storagePid =

        # cat=mysite/config/b; type=boolean; label=FeVariant activated
        feVariantOption =

        # cat=mysite/config/b; type=int[2-3]; label=Category types number (2 = Category-Subcategory, 3 = Maincategory-Category-Subcategory)
        catTypesNumber =

        # cat=mysite/config/c; type=int[0-2]; label=File upload charakter (Normal = 0, LowerCase = 1, Utf8 = 2)
        fileUploadCharakter =
    }
    colours {
        # cat=mysite/colours/a; type=color; label=Corporate Colour
        corporateColour =

        # cat=mysite/colours/b; type=color; label=Colour font on mouse over
        linkColourFontHover = 

        # cat=mysite/colours/c; type=color; label=Default Button Font Colour
        defaultButtonFontColour =

        # cat=mysite/colours/d; type=color; label=Default Button Background Colour
        defaultButtonBackgroundColour =

        # cat=mysite/colours/e; type=color; label=Default Button Border Colour
        defaultButtonBorderColour =

        # cat=mysite/colours/f; type=color; label=Default Button Font Colour on mouse over
        defaultButtonFontColourHover =

        # cat=mysite/colours/g; type=color; label=Default Button Background Colour on mouse over
        defaultButtonBackgroundColourHover =

        # cat=mysite/colours/h; type=color; label=Default Button Border Colour on mouse over
        defaultButtonBorderColourHover =

        # cat=mysite/colours/i; type=color; label=Primary Button Font Colour
        primaryButtonFontColour =

        # cat=mysite/colours/j; type=color; label=Primary Button Background Colour
        primaryButtonBackgroundColour =

        # cat=mysite/colours/k; type=color; label=Primary Button Border Colour
        primaryButtonBorderColour =

        # cat=mysite/colours/l; type=color; label=Primary Button Font Colour on mouse over
        primaryButtonFontColourHover =

        # cat=mysite/colours/m; type=color; label=Primary Button Background Colour on mouse over
        primaryButtonBackgroundColourHover =

        # cat=mysite/colours/n; type=color; label=Primary Button Border Colour on mouse over
        primaryButtonBorderColourHover =
    }
}
