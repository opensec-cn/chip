<?php
define(
    'FUNCTION_WITH_CALLABLE', array (
    0 =>
        array (
            'function' => 'apcu_entry',
            'pos' => 1,
            'arg' => 'callable $generator',
        ),
    1 =>
        array (
            'function' => 'array_diff_uassoc',
            'pos' => -1,
            'arg' => 'callable $key_compare_func',
        ),
    2 =>
        array (
            'function' => 'array_diff_ukey',
            'pos' => -1,
            'arg' => 'callable $key_compare_func',
        ),
    3 =>
        array (
            'function' => 'array_filter',
            'pos' => 1,
            'arg' => 'callable $callback',
        ),
    4 =>
        array (
            'function' => 'array_intersect_uassoc',
            'pos' => -1,
            'arg' => 'callable $key_compare_func',
        ),
    5 =>
        array (
            'function' => 'array_intersect_ukey',
            'pos' => -1,
            'arg' => 'callable $key_compare_func',
        ),
    6 =>
        array (
            'function' => 'array_map',
            'pos' => 0,
            'arg' => 'callable $callback',
        ),
    7 =>
        array (
            'function' => 'array_reduce',
            'pos' => 1,
            'arg' => 'callable $callback',
        ),
    8 =>
        array (
            'function' => 'array_udiff_assoc',
            'pos' => -1,
            'arg' => 'callable $value_compare_func',
        ),
    9 =>
        array (
            'function' => 'array_udiff_uassoc',
            'pos' => -2,
            'arg' => 'callable $value_compare_func',
        ),
    10 =>
        array (
            'function' => 'array_udiff_uassoc',
            'pos' => -1,
            'arg' => 'callable $key_compare_func',
        ),
    11 =>
        array (
            'function' => 'array_udiff',
            'pos' => -1,
            'arg' => 'callable $value_compare_func',
        ),
    12 =>
        array (
            'function' => 'array_uintersect_assoc',
            'pos' => -1,
            'arg' => 'callable $value_compare_func',
        ),
    13 =>
        array (
            'function' => 'array_uintersect_uassoc',
            'pos' => -2,
            'arg' => 'callable $value_compare_func',
        ),
    14 =>
        array (
            'function' => 'array_uintersect_uassoc',
            'pos' => -1,
            'arg' => 'callable $key_compare_func',
        ),
    15 =>
        array (
            'function' => 'array_uintersect',
            'pos' => -1,
            'arg' => 'callable $value_compare_func',
        ),
    16 =>
        array (
            'function' => 'array_walk_recursive',
            'pos' => 1,
            'arg' => 'callable $callback',
        ),
    17 =>
        array (
            'function' => 'array_walk',
            'pos' => 1,
            'arg' => 'callable $callback',
        ),
    18 =>
        array (
            'function' => 'call_user_func_array',
            'pos' => 0,
            'arg' => 'callable $callback',
        ),
    19 =>
        array (
            'function' => 'call_user_func',
            'pos' => 0,
            'arg' => 'callable $callback',
        ),
    20 =>
        array (
            'function' => 'eio_busy',
            'pos' => 2,
            'arg' => 'callable $callback = NULL',
        ),
    21 =>
        array (
            'function' => 'eio_chmod',
            'pos' => 3,
            'arg' => 'callable $callback = NULL',
        ),
    22 =>
        array (
            'function' => 'eio_chown',
            'pos' => 4,
            'arg' => 'callable $callback = NULL',
        ),
    23 =>
        array (
            'function' => 'eio_close',
            'pos' => 2,
            'arg' => 'callable $callback = NULL',
        ),
    24 =>
        array (
            'function' => 'eio_custom',
            'pos' => 0,
            'arg' => 'callable $execute',
        ),
    25 =>
        array (
            'function' => 'eio_custom',
            'pos' => 2,
            'arg' => 'callable $callback',
        ),
    26 =>
        array (
            'function' => 'eio_dup2',
            'pos' => 3,
            'arg' => 'callable $callback = NULL',
        ),
    27 =>
        array (
            'function' => 'eio_fallocate',
            'pos' => 5,
            'arg' => 'callable $callback = NULL',
        ),
    28 =>
        array (
            'function' => 'eio_fchmod',
            'pos' => 3,
            'arg' => 'callable $callback = NULL',
        ),
    29 =>
        array (
            'function' => 'eio_fchown',
            'pos' => 4,
            'arg' => 'callable $callback = NULL',
        ),
    30 =>
        array (
            'function' => 'eio_fdatasync',
            'pos' => 2,
            'arg' => 'callable $callback = NULL',
        ),
    31 =>
        array (
            'function' => 'eio_fstat',
            'pos' => 2,
            'arg' => 'callable $callback',
        ),
    32 =>
        array (
            'function' => 'eio_fstatvfs',
            'pos' => 2,
            'arg' => 'callable $callback',
        ),
    33 =>
        array (
            'function' => 'eio_fsync',
            'pos' => 2,
            'arg' => 'callable $callback = NULL',
        ),
    34 =>
        array (
            'function' => 'eio_futime',
            'pos' => 4,
            'arg' => 'callable $callback = NULL',
        ),
    35 =>
        array (
            'function' => 'eio_grp',
            'pos' => 0,
            'arg' => 'callable $callback',
        ),
    36 =>
        array (
            'function' => 'eio_link',
            'pos' => 3,
            'arg' => 'callable $callback = NULL',
        ),
    37 =>
        array (
            'function' => 'eio_lstat',
            'pos' => 2,
            'arg' => 'callable $callback',
        ),
    38 =>
        array (
            'function' => 'eio_mkdir',
            'pos' => 3,
            'arg' => 'callable $callback = NULL',
        ),
    39 =>
        array (
            'function' => 'eio_mknod',
            'pos' => 4,
            'arg' => 'callable $callback = NULL',
        ),
    40 =>
        array (
            'function' => 'eio_nop',
            'pos' => 1,
            'arg' => 'callable $callback = NULL',
        ),
    41 =>
        array (
            'function' => 'eio_open',
            'pos' => 4,
            'arg' => 'callable $callback',
        ),
    42 =>
        array (
            'function' => 'eio_read',
            'pos' => 4,
            'arg' => 'callable $callback',
        ),
    43 =>
        array (
            'function' => 'eio_readahead',
            'pos' => 4,
            'arg' => 'callable $callback = NULL',
        ),
    44 =>
        array (
            'function' => 'eio_readdir',
            'pos' => 3,
            'arg' => 'callable $callback',
        ),
    45 =>
        array (
            'function' => 'eio_readlink',
            'pos' => 2,
            'arg' => 'callable $callback',
        ),
    46 =>
        array (
            'function' => 'eio_realpath',
            'pos' => 2,
            'arg' => 'callable $callback',
        ),
    47 =>
        array (
            'function' => 'eio_rename',
            'pos' => 3,
            'arg' => 'callable $callback = NULL',
        ),
    48 =>
        array (
            'function' => 'eio_rmdir',
            'pos' => 2,
            'arg' => 'callable $callback = NULL',
        ),
    49 =>
        array (
            'function' => 'eio_seek',
            'pos' => 4,
            'arg' => 'callable $callback = NULL',
        ),
    50 =>
        array (
            'function' => 'eio_sendfile',
            'pos' => 5,
            'arg' => 'callable $callback',
        ),
    51 =>
        array (
            'function' => 'eio_stat',
            'pos' => 2,
            'arg' => 'callable $callback',
        ),
    52 =>
        array (
            'function' => 'eio_statvfs',
            'pos' => 2,
            'arg' => 'callable $callback',
        ),
    53 =>
        array (
            'function' => 'eio_symlink',
            'pos' => 3,
            'arg' => 'callable $callback = NULL',
        ),
    54 =>
        array (
            'function' => 'eio_sync_file_range',
            'pos' => 5,
            'arg' => 'callable $callback = NULL',
        ),
    55 =>
        array (
            'function' => 'eio_sync',
            'pos' => 1,
            'arg' => 'callable $callback = NULL',
        ),
    56 =>
        array (
            'function' => 'eio_syncfs',
            'pos' => 2,
            'arg' => 'callable $callback = NULL',
        ),
    57 =>
        array (
            'function' => 'eio_unlink',
            'pos' => 2,
            'arg' => 'callable $callback = NULL',
        ),
    58 =>
        array (
            'function' => 'eio_utime',
            'pos' => 4,
            'arg' => 'callable $callback = NULL',
        ),
    59 =>
        array (
            'function' => 'event_timer_set',
            'pos' => 1,
            'arg' => 'callable $callback',
        ),
    60 =>
        array (
            'function' => 'fann_create_train_from_callback',
            'pos' => 3,
            'arg' => 'callable $user_function',
        ),
    61 =>
        array (
            'function' => 'fdf_enum_values',
            'pos' => 1,
            'arg' => 'callable $function',
        ),
    62 =>
        array (
            'function' => 'forward_static_call_array',
            'pos' => 0,
            'arg' => 'callable $function',
        ),
    63 =>
        array (
            'function' => 'forward_static_call',
            'pos' => 0,
            'arg' => 'callable $function',
        ),
    64 =>
        array (
            'function' => 'header_register_callback',
            'pos' => 0,
            'arg' => 'callable $callback',
        ),
    65 =>
        array (
            'function' => 'ibase_set_event_handler',
            'pos' => 0,
            'arg' => 'callable $event_handler',
        ),
    66 =>
        array (
            'function' => 'is_callable',
            'pos' => 2,
            'arg' => 'string &$callable_name ]]',
        ),
    67 =>
        array (
            'function' => 'iterator_apply',
            'pos' => 1,
            'arg' => 'callable $function',
        ),
    68 =>
        array (
            'function' => 'ldap_set_rebind_proc',
            'pos' => 1,
            'arg' => 'callable $callback',
        ),
    69 =>
        array (
            'function' => 'libxml_set_external_entity_loader',
            'pos' => 0,
            'arg' => 'callable $resolver_function',
        ),
    70 =>
        array (
            'function' => 'mailparse_msg_extract_part_file',
            'pos' => 2,
            'arg' => 'callable $callbackfunc ]',
        ),
    71 =>
        array (
            'function' => 'mailparse_msg_extract_part',
            'pos' => 2,
            'arg' => 'callable $callbackfunc ]',
        ),
    72 =>
        array (
            'function' => 'mailparse_msg_extract_whole_part_file',
            'pos' => 2,
            'arg' => 'callable $callbackfunc ]',
        ),
    73 =>
        array (
            'function' => 'mb_ereg_replace_callback',
            'pos' => 1,
            'arg' => 'callable $callback',
        ),
    74 =>
        array (
            'function' => 'newt_entry_set_filter',
            'pos' => 1,
            'arg' => 'callable $filter',
        ),
    75 =>
        array (
            'function' => 'newt_set_suspend_callback',
            'pos' => 0,
            'arg' => 'callable $function',
        ),
    76 =>
        array (
            'function' => 'ob_start',
            'pos' => 0,
            'arg' => 'callable $output_callback = NULL',
        ),
    77 =>
        array (
            'function' => 'pcntl_signal',
            'pos' => 1,
            'arg' => 'callable|int $handler',
        ),
    78 =>
        array (
            'function' => 'preg_replace_callback',
            'pos' => 1,
            'arg' => 'callable $callback',
        ),
    79 =>
        array (
            'function' => 'readline_callback_handler_install',
            'pos' => 1,
            'arg' => 'callable $callback',
        ),
    80 =>
        array (
            'function' => 'readline_completion_function',
            'pos' => 0,
            'arg' => 'callable $function',
        ),
    81 =>
        array (
            'function' => 'register_shutdown_function',
            'pos' => 0,
            'arg' => 'callable $callback',
        ),
    82 =>
        array (
            'function' => 'register_tick_function',
            'pos' => 0,
            'arg' => 'callable $function',
        ),
    83 =>
        array (
            'function' => 'session_set_save_handler',
            'pos' => 0,
            'arg' => 'callable $open',
        ),
    84 =>
        array (
            'function' => 'session_set_save_handler',
            'pos' => 1,
            'arg' => 'callable $close',
        ),
    85 =>
        array (
            'function' => 'session_set_save_handler',
            'pos' => 2,
            'arg' => 'callable $read',
        ),
    86 =>
        array (
            'function' => 'session_set_save_handler',
            'pos' => 3,
            'arg' => 'callable $write',
        ),
    87 =>
        array (
            'function' => 'session_set_save_handler',
            'pos' => 4,
            'arg' => 'callable $destroy',
        ),
    88 =>
        array (
            'function' => 'session_set_save_handler',
            'pos' => 5,
            'arg' => 'callable $gc',
        ),
    89 =>
        array (
            'function' => 'session_set_save_handler',
            'pos' => 6,
            'arg' => 'callable $create_sid',
        ),
    90 =>
        array (
            'function' => 'session_set_save_handler',
            'pos' => 7,
            'arg' => 'callable $validate_sid',
        ),
    91 =>
        array (
            'function' => 'session_set_save_handler',
            'pos' => 8,
            'arg' => 'callable $update_timestamp ]]]',
        ),
    92 =>
        array (
            'function' => 'set_error_handler',
            'pos' => 0,
            'arg' => 'callable $error_handler',
        ),
    93 =>
        array (
            'function' => 'set_exception_handler',
            'pos' => 0,
            'arg' => 'callable $exception_handler',
        ),
    94 =>
        array (
            'function' => 'spl_autoload_register',
            'pos' => 0,
            'arg' => 'callable $autoload_function',
        ),
    95 =>
        array (
            'function' => 'sqlite_create_aggregate',
            'pos' => 2,
            'arg' => 'callable $step_func',
        ),
    96 =>
        array (
            'function' => 'sqlite_create_aggregate',
            'pos' => 3,
            'arg' => 'callable $finalize_func',
        ),
    97 =>
        array (
            'function' => 'sqlite_create_function',
            'pos' => 2,
            'arg' => 'callable $callback',
        ),
    98 =>
        array (
            'function' => 'swoole_async_dns_lookup',
            'pos' => 1,
            'arg' => 'callable $callback',
        ),
    99 =>
        array (
            'function' => 'swoole_async_read',
            'pos' => 1,
            'arg' => 'callable $callback',
        ),
    100 =>
        array (
            'function' => 'swoole_async_readfile',
            'pos' => 1,
            'arg' => 'callable $callback',
        ),
    101 =>
        array (
            'function' => 'swoole_async_write',
            'pos' => 3,
            'arg' => 'callable $callback ]]',
        ),
    102 =>
        array (
            'function' => 'swoole_async_writefile',
            'pos' => 2,
            'arg' => 'callable $callback',
        ),
    103 =>
        array (
            'function' => 'swoole_event_add',
            'pos' => 1,
            'arg' => 'callable $read_callback',
        ),
    104 =>
        array (
            'function' => 'swoole_event_add',
            'pos' => 2,
            'arg' => 'callable $write_callback',
        ),
    105 =>
        array (
            'function' => 'swoole_event_defer',
            'pos' => 0,
            'arg' => 'callable $callback',
        ),
    106 =>
        array (
            'function' => 'swoole_event_set',
            'pos' => 1,
            'arg' => 'callable $read_callback',
        ),
    107 =>
        array (
            'function' => 'swoole_event_set',
            'pos' => 2,
            'arg' => 'callable $write_callback',
        ),
    108 =>
        array (
            'function' => 'swoole_timer_after',
            'pos' => 1,
            'arg' => 'callable $callback',
        ),
    109 =>
        array (
            'function' => 'swoole_timer_tick',
            'pos' => 1,
            'arg' => 'callable $callback',
        ),
    110 =>
        array (
            'function' => 'sybase_set_message_handler',
            'pos' => 0,
            'arg' => 'callable $handler',
        ),
    111 =>
        array (
            'function' => 'uasort',
            'pos' => 1,
            'arg' => 'callable $value_compare_func',
        ),
    112 =>
        array (
            'function' => 'uksort',
            'pos' => 1,
            'arg' => 'callable $key_compare_func',
        ),
    113 =>
        array (
            'function' => 'uopz_overload',
            'pos' => 1,
            'arg' => 'Callable $callable',
        ),
    114 =>
        array (
            'function' => 'usort',
            'pos' => 1,
            'arg' => 'callable $value_compare_func',
        ),
    115 =>
        array (
            'function' => 'xml_set_character_data_handler',
            'pos' => 1,
            'arg' => 'callable $handler',
        ),
    116 =>
        array (
            'function' => 'xml_set_default_handler',
            'pos' => 1,
            'arg' => 'callable $handler',
        ),
    117 =>
        array (
            'function' => 'xml_set_element_handler',
            'pos' => 1,
            'arg' => 'callable $start_element_handler',
        ),
    118 =>
        array (
            'function' => 'xml_set_element_handler',
            'pos' => 2,
            'arg' => 'callable $end_element_handler',
        ),
    119 =>
        array (
            'function' => 'xml_set_end_namespace_decl_handler',
            'pos' => 1,
            'arg' => 'callable $handler',
        ),
    120 =>
        array (
            'function' => 'xml_set_external_entity_ref_handler',
            'pos' => 1,
            'arg' => 'callable $handler',
        ),
    121 =>
        array (
            'function' => 'xml_set_notation_decl_handler',
            'pos' => 1,
            'arg' => 'callable $handler',
        ),
    122 =>
        array (
            'function' => 'xml_set_processing_instruction_handler',
            'pos' => 1,
            'arg' => 'callable $handler',
        ),
    123 =>
        array (
            'function' => 'xml_set_start_namespace_decl_handler',
            'pos' => 1,
            'arg' => 'callable $handler',
        ),
    124 =>
        array (
            'function' => 'xml_set_unparsed_entity_decl_handler',
            'pos' => 1,
            'arg' => 'callable $handler',
        ),
    )
);