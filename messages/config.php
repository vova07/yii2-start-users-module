<?php

return [
    'sourcePath' => dirname(__DIR__),
    'messagePath' => __DIR__,
    'languages' => ['de', 'en', 'it', 'pt-BR', 'ru'],
    'translator' => 'Module::t',
    'sort' => false,
    'overwrite' => true,
    'removeUnused' => true,
    'only' => ['*.php'],
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
    ],
    'format' => 'php'
];
