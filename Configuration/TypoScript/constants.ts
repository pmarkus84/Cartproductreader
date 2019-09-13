
module.tx_cartproductreader_cartproductreader {
    view {
        # cat=module.tx_cartproductreader_cartproductreader/file; type=string; label=Path to template root (BE)
        templateRootPath = EXT:cartproductreader/Resources/Private/Backend/Templates/
        # cat=module.tx_cartproductreader_cartproductreader/file; type=string; label=Path to template partials (BE)
        partialRootPath = EXT:cartproductreader/Resources/Private/Backend/Partials/
        # cat=module.tx_cartproductreader_cartproductreader/file; type=string; label=Path to template layouts (BE)
        layoutRootPath = EXT:cartproductreader/Resources/Private/Backend/Layouts/
    }
    persistence {
        # cat=module.tx_cartproductreader_cartproductreader//a; type=string; label=Default storage PID
        storagePid =
    }
}
