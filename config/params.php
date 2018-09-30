<?php

return [
    'adminEmail' => 'admin@example.com',
    'periodo_noturno' =>[
        'apurar' => true,
        'hr_inicio_hora_noturna' => '22:00',
        'hr_fim_hora_noturna' => '05:00',
        'hr_reduzida' => false,
        'hr_prorrogada' => false
    ],
    'dias_uteis' => [
        'dias' =>[
            1,2,3,4,5
        ],
        'feriado' => false
    ],
    'limite_carga_horaria' => [
        'mensal' => 220,
        'semanal' => 44,
        'ultimo_dia' => 6,
        'Sun' => '08:00',
        'Mon' => '08:00',
        'Tue' => '08:00',
        'Wed' => '08:00',
        'Thu' => '08:00',
        'Fri' => '08:00',
        'Sat' => '08:00'
    ]
];
