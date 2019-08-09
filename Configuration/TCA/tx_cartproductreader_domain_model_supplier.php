<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_supplier',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'name,street,zipcode,place,country,email,telephone,products',
        'iconfile' => 'EXT:cartproductreader/Resources/Public/Icons/tx_cartproductreader_domain_model_supplier.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, street, zipcode, place, country, email, telephone, products',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, street, zipcode, place, country, email, telephone, products, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_cartproductreader_domain_model_supplier',
                'foreign_table_where' => 'AND tx_cartproductreader_domain_model_supplier.pid=###CURRENT_PID### AND tx_cartproductreader_domain_model_supplier.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
            ],
        ],
        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_supplier.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'street' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_supplier.street',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'zipcode' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_supplier.zipcode',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'place' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_supplier.place',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'country' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_supplier.country',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_supplier.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'nospace,email'
            ]
        ],
        'telephone' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_supplier.telephone',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'products' => [
            'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_supplier.products',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_cartproducts_domain_model_product_product',
                'foreign_field' => 'supplier'                
            ],
        ],
    ],
];
