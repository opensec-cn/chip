<?php
define(
    'FUNCTION_WITH_CALLABLE',
    [
        [
            'function' => 'apcu_entry',
            'pos' => '1',
            'arg' => 'callable $generator',
        ],
        [
            'function' => 'array_diff_uassoc',
            'pos' => '-1',
            'arg' => 'callable $key_compare_func',
        ],
        [
            'function' => 'array_diff_ukey',
            'pos' => '-1',
            'arg' => 'callable $key_compare_func',
        ],
        [
            'function' => 'array_filter',
            'pos' => '1',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'array_intersect_uassoc',
            'pos' => '-1',
            'arg' => 'callable $key_compare_func',
        ],
        [
            'function' => 'array_intersect_ukey',
            'pos' => '-1',
            'arg' => 'callable $key_compare_func',
        ],
        [
            'function' => 'array_map',
            'pos' => '0',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'array_reduce',
            'pos' => '1',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'array_udiff_assoc',
            'pos' => '-1',
            'arg' => 'callable $value_compare_func',
        ],
        [
            'function' => 'array_udiff_uassoc',
            'pos' => '-2',
            'arg' => 'callable $value_compare_func',
        ],
        [
            'function' => 'array_udiff_uassoc',
            'pos' => '-1',
            'arg' => 'callable $key_compare_func',
        ],
        [
            'function' => 'array_udiff',
            'pos' => '-1',
            'arg' => 'callable $value_compare_func',
        ],
        [
            'function' => 'array_uintersect_assoc',
            'pos' => '-1',
            'arg' => 'callable $value_compare_func',
        ],
        [
            'function' => 'array_uintersect_uassoc',
            'pos' => '-2',
            'arg' => 'callable $value_compare_func',
        ],
        [
            'function' => 'array_uintersect_uassoc',
            'pos' => '-1',
            'arg' => 'callable $key_compare_func',
        ],
        [
            'function' => 'array_uintersect',
            'pos' => '-1',
            'arg' => 'callable $value_compare_func',
        ],
        [
            'function' => 'array_walk_recursive',
            'pos' => '1',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'array_walk',
            'pos' => '1',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'call_user_func_array',
            'pos' => '0',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'call_user_func',
            'pos' => '0',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'eio_busy',
            'pos' => '2',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_chmod',
            'pos' => '3',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_chown',
            'pos' => '4',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_close',
            'pos' => '2',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_custom',
            'pos' => '0',
            'arg' => 'callable $execute',
        ],
        [
            'function' => 'eio_custom',
            'pos' => '2',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'eio_dup2',
            'pos' => '3',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_fallocate',
            'pos' => '5',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_fchmod',
            'pos' => '3',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_fchown',
            'pos' => '4',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_fdatasync',
            'pos' => '2',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_fstat',
            'pos' => '2',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'eio_fstatvfs',
            'pos' => '2',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'eio_fsync',
            'pos' => '2',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_futime',
            'pos' => '4',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_grp',
            'pos' => '0',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'eio_link',
            'pos' => '3',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_lstat',
            'pos' => '2',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'eio_mkdir',
            'pos' => '3',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_mknod',
            'pos' => '4',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_nop',
            'pos' => '1',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_open',
            'pos' => '4',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'eio_read',
            'pos' => '4',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'eio_readahead',
            'pos' => '4',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_readdir',
            'pos' => '3',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'eio_readlink',
            'pos' => '2',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'eio_realpath',
            'pos' => '2',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'eio_rename',
            'pos' => '3',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_rmdir',
            'pos' => '2',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_seek',
            'pos' => '4',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_sendfile',
            'pos' => '5',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'eio_stat',
            'pos' => '2',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'eio_statvfs',
            'pos' => '2',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'eio_symlink',
            'pos' => '3',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_sync_file_range',
            'pos' => '5',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_sync',
            'pos' => '1',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_syncfs',
            'pos' => '2',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_unlink',
            'pos' => '2',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'eio_utime',
            'pos' => '4',
            'arg' => 'callable $callback = NULL',
        ],
        [
            'function' => 'event_timer_set',
            'pos' => '1',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'fann_create_train_from_callback',
            'pos' => '3',
            'arg' => 'callable $user_function',
        ],
        [
            'function' => 'fdf_enum_values',
            'pos' => '1',
            'arg' => 'callable $function',
        ],
        [
            'function' => 'forward_static_call_array',
            'pos' => '0',
            'arg' => 'callable $function',
        ],
        [
            'function' => 'forward_static_call',
            'pos' => '0',
            'arg' => 'callable $function',
        ],
        [
            'function' => 'header_register_callback',
            'pos' => '0',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'ibase_set_event_handler',
            'pos' => '0',
            'arg' => 'callable $event_handler',
        ],
        [
            'function' => 'is_callable',
            'pos' => '2',
            'arg' => 'string &$callable_name ]]',
        ],
        [
            'function' => 'iterator_apply',
            'pos' => '1',
            'arg' => 'callable $function',
        ],
        [
            'function' => 'ldap_set_rebind_proc',
            'pos' => '1',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'libxml_set_external_entity_loader',
            'pos' => '0',
            'arg' => 'callable $resolver_function',
        ],
        [
            'function' => 'mailparse_msg_extract_part_file',
            'pos' => '2',
            'arg' => 'callable $callbackfunc ]',
        ],
        [
            'function' => 'mailparse_msg_extract_part',
            'pos' => '2',
            'arg' => 'callable $callbackfunc ]',
        ],
        [
            'function' => 'mailparse_msg_extract_whole_part_file',
            'pos' => '2',
            'arg' => 'callable $callbackfunc ]',
        ],
        [
            'function' => 'mb_ereg_replace_callback',
            'pos' => '1',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'mbereg_replace_callback',
            'pos' => '1',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'newt_entry_set_filter',
            'pos' => '1',
            'arg' => 'callable $filter',
        ],
        [
            'function' => 'newt_set_suspend_callback',
            'pos' => '0',
            'arg' => 'callable $function',
        ],
        [
            'function' => 'ob_start',
            'pos' => '0',
            'arg' => 'callable $output_callback = NULL',
        ],
        [
            'function' => 'pcntl_signal',
            'pos' => '1',
            'arg' => 'callable|int $handler',
        ],
        [
            'function' => 'preg_replace_callback',
            'pos' => '1',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'readline_callback_handler_install',
            'pos' => '1',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'readline_completion_function',
            'pos' => '0',
            'arg' => 'callable $function',
        ],
        [
            'function' => 'register_shutdown_function',
            'pos' => '0',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'register_tick_function',
            'pos' => '0',
            'arg' => 'callable $function',
        ],
        [
            'function' => 'session_set_save_handler',
            'pos' => '0',
            'arg' => 'callable $open',
        ],
        [
            'function' => 'session_set_save_handler',
            'pos' => '1',
            'arg' => 'callable $close',
        ],
        [
            'function' => 'session_set_save_handler',
            'pos' => '2',
            'arg' => 'callable $read',
        ],
        [
            'function' => 'session_set_save_handler',
            'pos' => '3',
            'arg' => 'callable $write',
        ],
        [
            'function' => 'session_set_save_handler',
            'pos' => '4',
            'arg' => 'callable $destroy',
        ],
        [
            'function' => 'session_set_save_handler',
            'pos' => '5',
            'arg' => 'callable $gc',
        ],
        [
            'function' => 'session_set_save_handler',
            'pos' => '6',
            'arg' => 'callable $create_sid',
        ],
        [
            'function' => 'session_set_save_handler',
            'pos' => '7',
            'arg' => 'callable $validate_sid',
        ],
        [
            'function' => 'session_set_save_handler',
            'pos' => '8',
            'arg' => 'callable $update_timestamp ]]]',
        ],
        [
            'function' => 'set_error_handler',
            'pos' => '0',
            'arg' => 'callable $error_handler',
        ],
        [
            'function' => 'set_exception_handler',
            'pos' => '0',
            'arg' => 'callable $exception_handler',
        ],
        [
            'function' => 'spl_autoload_register',
            'pos' => '0',
            'arg' => 'callable $autoload_function',
        ],
        [
            'function' => 'sqlite_create_aggregate',
            'pos' => '2',
            'arg' => 'callable $step_func',
        ],
        [
            'function' => 'sqlite_create_aggregate',
            'pos' => '3',
            'arg' => 'callable $finalize_func',
        ],
        [
            'function' => 'sqlite_create_function',
            'pos' => '2',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'swoole_async_dns_lookup',
            'pos' => '1',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'swoole_async_read',
            'pos' => '1',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'swoole_async_readfile',
            'pos' => '1',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'swoole_async_write',
            'pos' => '3',
            'arg' => 'callable $callback ]]',
        ],
        [
            'function' => 'swoole_async_writefile',
            'pos' => '2',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'swoole_event_add',
            'pos' => '1',
            'arg' => 'callable $read_callback',
        ],
        [
            'function' => 'swoole_event_add',
            'pos' => '2',
            'arg' => 'callable $write_callback',
        ],
        [
            'function' => 'swoole_event_defer',
            'pos' => '0',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'swoole_event_set',
            'pos' => '1',
            'arg' => 'callable $read_callback',
        ],
        [
            'function' => 'swoole_event_set',
            'pos' => '2',
            'arg' => 'callable $write_callback',
        ],
        [
            'function' => 'swoole_timer_after',
            'pos' => '1',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'swoole_timer_tick',
            'pos' => '1',
            'arg' => 'callable $callback',
        ],
        [
            'function' => 'sybase_set_message_handler',
            'pos' => '0',
            'arg' => 'callable $handler',
        ],
        [
            'function' => 'uasort',
            'pos' => '1',
            'arg' => 'callable $value_compare_func',
        ],
        [
            'function' => 'uksort',
            'pos' => '1',
            'arg' => 'callable $key_compare_func',
        ],
        [
            'function' => 'uopz_overload',
            'pos' => '1',
            'arg' => 'Callable $callable',
        ],
        [
            'function' => 'usort',
            'pos' => '1',
            'arg' => 'callable $value_compare_func',
        ],
        [
            'function' => 'xml_set_character_data_handler',
            'pos' => '1',
            'arg' => 'callable $handler',
        ],
        [
            'function' => 'xml_set_default_handler',
            'pos' => '1',
            'arg' => 'callable $handler',
        ],
        [
            'function' => 'xml_set_element_handler',
            'pos' => '1',
            'arg' => 'callable $start_element_handler',
        ],
        [
            'function' => 'xml_set_element_handler',
            'pos' => '2',
            'arg' => 'callable $end_element_handler',
        ],
        [
            'function' => 'xml_set_end_namespace_decl_handler',
            'pos' => '1',
            'arg' => 'callable $handler',
        ],
        [
            'function' => 'xml_set_external_entity_ref_handler',
            'pos' => '1',
            'arg' => 'callable $handler',
        ],
        [
            'function' => 'xml_set_notation_decl_handler',
            'pos' => '1',
            'arg' => 'callable $handler',
        ],
        [
            'function' => 'xml_set_processing_instruction_handler',
            'pos' => '1',
            'arg' => 'callable $handler',
        ],
        [
            'function' => 'xml_set_start_namespace_decl_handler',
            'pos' => '1',
            'arg' => 'callable $handler',
        ],
        [
            'function' => 'xml_set_unparsed_entity_decl_handler',
            'pos' => '1',
            'arg' => 'callable $handler',
        ],
    ]
);