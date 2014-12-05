<?php

return [

    'sms'  => [
        'keyword'   => 'inqur',
        'provider'  => 'ideamart',
        'providers' => [
            'ideamart' => [
                'default'                 => 'ideamart',
                'registered_applications' => [
                    'APP_009076', 'APP_000001'
                ],
                'pasindu_test'            => [
                    'server'     => 'http://idea-sim.herokuapp.com/sms/1006',
                    'app_id'     => '1006',
                    'app_secret' => '5006'
                ],
                'ideamart'                => [
                    'server'     => 'https://api.dialog.lk/sms/send/',
                    'app_id'     => 'APP_009076',
                    'app_secret' => 'ec5051d5463877e904675deb7905640a',
                ],
                'simulator'               => [
                    'server'     => 'http://127.0.0.1:7000/sms/send/',
                    'app_id'     => 'APP_000001',
                    'app_secret' => 'password'
                ],
            ],
            'twilio'   => [
                'default'                 => 'standard',
                'registered_applications' => [
                    'APP_009076', 'APP_000001'
                ],
                'standard'                => [
                    'from'       => '+14155992671',
                    'app_id'     => 'AC77f719e77ba2e3ac9c3edbb2f3f5e72c',
                    'app_secret' => '5c0e6a723fd424a5a8bb98fc0cbe58f7'
                ]
            ],
            'wavecell' => [
                'default'                 => 'standard',
                'registered_applications' => [
                    'APP_008386', 'APP_000001'
                ],
                'standard'                => [
                    'server_url'   => 'http://wms1.wavecell.com/Send.asmx/SendMT',
                    'accountId'    => 'joomtrigg',
                    'subAccountId' => 'joomtrigg_std',
                    'password'     => 'joomla456'
                ]
            ]
        ]
    ],
    'ussd' => [
        'provider'  => 'ideamart',
        'providers' => [
            'simulator' => [
                'server'     => 'http://localhost:7000/ussd/send/',
                'app_id'     => 'APP_000001',
                'app_secret' => 'password'
            ],
            'ideamart'  => [
                'server'     => 'https://api.dialog.lk/ussd/send',
                'app_id'     => 'APP_009076',
                'app_secret' => 'ec5051d5463877e904675deb7905640a'
            ],
        ],
        'code'      => '',

        'interface' => 'master_menu',

        'menus'     => [
            'master_menu' => [
                'message'  => 'Welcome to BByer',
                'response' => 'mt-cont',
                'type'     => 'master_menu',
                'options'  => [
                    '1' => [
                        'title'    => 'Connect with ABC Bakery',
                        'type'     => 'sub_menu',
                        'action'   => null,
                        'response' => 'mt-cont',
                        'sub_menu' => [
                            'message'  => 'Register for Service',
                            'type'     => 'sub_menu',
                            'response' => 'mt-cont',
                            'action'   => null,
                            'options'  => [
                                '1' => [
                                    'title'    => 'Select Your Service Area',
                                    'action'   => null,
                                    'type'     => 'sub_menu',
                                    'response' => 'mt-cont',
                                    'sub_menu' => [
                                        'message'  => 'Type the number and send',
                                        'action'   => null,
                                        'type'     => 'sub_menu',
                                        'response' => 'mt-cont',
                                        'options'  => [
                                            '1' => [
                                                'title'     => 'Pirappankulam Road',
                                                'type'      => 'action',
                                                'action'    => 'BByer\Controllers\AreaController@setArea',
                                                'response'  => 'mt-cont',
                                                'variables' => [
                                                    'sourceAddress' => 'getSourceAddress',
                                                    'id'            => 1,
                                                ]
                                            ],

                                            '2' => [
                                                'title'     => 'Brown Road',
                                                'type'      => 'action',
                                                'action'    => 'BByer\Controllers\AreaController@setArea',
                                                'response'  => 'mt-cont',
                                                'variables' => [
                                                    'sourceAddress' => 'getSourceAddress',
                                                    'id'            => 2
                                                ]
                                            ],


                                            '3' => [
                                                'title'     => 'Navalar Road',
                                                'type'      => 'action',
                                                'action'    => 'BByer\Controllers\AreaController@setArea',
                                                'response'  => 'mt-cont',
                                                'variables' => [
                                                    'sourceAddress' => 'getSourceAddress',
                                                    'id'            => 3
                                                ]
                                            ],

                                            '4' => [
                                                'title'     => 'Hindu College Lane',
                                                'type'      => 'action',
                                                'action'    => 'BByer\Controllers\AreaController@setArea',
                                                'response'  => 'mt-cont',
                                                'variables' => [
                                                    'sourceAddress' => 'getSourceAddress',
                                                    'id'            => 4
                                                ]
                                            ]
                                        ]

                                    ]
                                ]
                            ]
                        ],

                    ],

                ]
            ]
        ],
    ],
    //],


];