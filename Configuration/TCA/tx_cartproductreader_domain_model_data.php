<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_data',
        'label' => 'supplier',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        //'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'file, supplier, registered',
        'iconfile' => 'EXT:cartproductreader/Resources/Public/Icons/tx_cartproductreader_domain_model_other.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, file, supplier, registered, hidden',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, file, supplier, registered, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, hidden, starttime, endtime'],
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
                'foreign_table' => 'tx_cartproductreader_domain_model_data',
                'foreign_table_where' => 'AND tx_cartproductreader_domain_model_data.pid=###CURRENT_PID### AND tx_cartproductreader_domain_model_data.sys_language_uid IN (-1,0)',
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
        'file' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_data.file',
            'config' => [
                'type' => 'group',
                'internal_type' => 'file',
                'uploadfolder' => 'uploads/tx_cartproductreader',
                'size' => 1,
                'allowed' => 'xlsx',
                'disallowed' => '',
            ],
        ],
        'supplier' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_data.supplier',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_cartproductreader_domain_model_supplier',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'registered' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_data.registered',
            'config' => [
                'type' => 'check',
                'items' => [
                    ['Yes', ''],
                ],
            ]
        ],
        'datetime_registered' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:forms/Resources/Private/Language/locallang_db.xlf:tx_forms_domain_model_form.changedate',
            'config' => [
                'dbType' => 'datetime',
                'type' => 'input',
                'size' => 12,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => '0000-00-00 00:00:00'
            ],
        ],
        'images_assigned' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:cartproductreader/Resources/Private/Language/locallang_db.xlf:tx_cartproductreader_domain_model_data.images_assigned',
            'config' => [
                'type' => 'check',
                'items' => [
                    ['Yes', ''],
                ],
            ]
        ],
    ],
];
