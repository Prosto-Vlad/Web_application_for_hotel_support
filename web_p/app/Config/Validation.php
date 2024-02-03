<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

use App\Models\ServiceModel;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public $customer = [
        'first_name' => [
            'rules' => 'required|regex_match[/^[\p{Cyrillic} \-]+$/u]',
            'errors' => [
                'regex_match' => 'The first name field may only contain Cyrillic alphabet characters, spaces, and dashes.'
            ]
        ],
        'middle_name' => [
            'rules' => 'required|regex_match[/^[\p{Cyrillic} \-]+$/u]',
            'errors' => [
                'regex_match' => 'The middle name field may only contain Cyrillic alphabet characters, spaces, and dashes.'
            ]
        ],
        'last_name' => [
            'rules' => 'required|regex_match[/^[\p{Cyrillic} \-]+$/u]',
            'errors' => [
                'regex_match' => 'The last name field may only contain Cyrillic alphabet characters, spaces, and dashes.'
            ]
        ],
        'phone_number' => 'required|numeric',
        'pseudonym' => [
            'rules' => 'regex_match[/^[\p{Cyrillic} \-]+$/u]',
            'errors' => [
                'regex_match' => 'The pseudonym field may only contain Cyrillic alphabet characters, spaces, and dashes.'
            ]
        ]
    ];

    public $register = [
        'room_num' => 'required|numeric',
        'worker_id' => [
            'rules' => 'required|is_not_unique[worker.id]',
            'errors' => [
                'is_not_unique' => 'The worker_id field must correspond to an existing worker.'
            ]
        ],

    ];

    public $worker = [
        'first_name' => [
            'rules' => 'required|regex_match[/^[\p{Cyrillic} \-]+$/u]',
            'errors' => [
                'regex_match' => 'The first name field may only contain Cyrillic alphabet characters, spaces, and dashes.'
            ]
        ],
        'middle_name' => [
            'rules' => 'regex_match[/^[\p{Cyrillic} \-]+$/u]',
            'errors' => [
                'regex_match' => 'The middle name field may only contain Cyrillic alphabet characters, spaces, and dashes.'
            ]
        ],
        'last_name' => [
            'rules' => 'required|regex_match[/^[\p{Cyrillic} \-]+$/u]',
            'errors' => [
                'regex_match' => 'The last name field may only contain Cyrillic alphabet characters, spaces, and dashes.'
            ]
        ],
        'salary' => 'numeric',
        'phone_number' => 'required|numeric',
        'login' => 'required|is_unique[worker.login_w]',
        'password' => 'required',
        'position' => [
            'rules' => 'required|is_not_unique[position.id]',
            'errors' => [
                'is_not_unique' => 'The position field must correspond to an existing position.'
            ]
        ],
        'role' => [
            'rules' => 'required|is_not_unique[role.id]',
            'errors' => [
                'is_not_unique' => 'The role field must correspond to an existing role.'
            ]
        ],
        'schedule_id' => [
            'rules' => 'required|is_not_unique[schedule.id]',
            'errors' => [
                'is_not_unique' => 'The schedule_id field must correspond to an existing schedule.'
            ]
        ]
    ];

    public $service = [
        'name' => 'required|is_unique[service.name]',
        'cost' => 'required|numeric',
    ];

    public $order = [
        'worker_id' => [
            'rules' => 'required|is_not_unique[worker.id]',
            'errors' => [
                'is_not_unique' => 'The worker_id field must correspond to an existing worker.'
            ]
        ],
        'is_payed' => 'required|in_list[true,false]',
        'is_finish' => 'required|in_list[true,false]',
        'create_date' => 'required',
        'room_id' => [
            'rules' => 'required|is_not_unique[room.id]',
            'errors' => [
                'is_not_unique' => 'The room_id field must correspond to an existing room.'
            ]
        ]
    ];
}
