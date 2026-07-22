<?php

return [
    'title' => 'General Inventory',
    'subtitle' => 'Consolidated view of employees and equipment',
    'search_placeholder' => 'Search by name, registration, model, asset...',

    'stats' => [
        'total_notebooks' => 'Notebooks',
        'total_employees' => 'Employees',
        'allocated' => 'Allocated',
        'in_stock' => 'In Stock',
        'without_equipment' => 'Without Equipment',
    ],

    'filters' => [
        'all' => 'All',
        'allocated' => 'Allocated',
        'stock' => 'In Stock',
        'unassigned_employee' => 'Without Equipment',
    ],

    'table' => [
        'employee' => 'Employee',
        'matricula' => 'Registration',
        'centro_custo' => 'Cost Center',
        'projeto' => 'Project',
        'notebook' => 'Equipment',
        'serial' => 'Serial No.',
        'patrimonio' => 'Asset No.',
        'status' => 'Status',
    ],

    'empty' => 'No records found',
    'empty_hint' => 'Try adjusting the search filters.',
    'no_employee' => 'No employee',
    'no_notebook' => 'No equipment',
    'not_available' => '—',
];
