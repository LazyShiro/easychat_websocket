<?php

return ['fdToUser' => ['size' => 1024 * 5, 'columns' => ['uid' => ['type' => \Swoole\Table::TYPE_INT, 'size' => 4,],],], 'userToFd' => ['size' => 1024 * 5, 'columns' => ['fdList' => ['type' => \Swoole\Table::TYPE_STRING, 'size' => 1024 * 5,],],], 'subjectFdToUser' => ['size' => 1024 * 5, 'columns' => ['uid' => ['type' => \Swoole\Table::TYPE_INT, 'size' => 4,],],], 'subjectUserToFd' => ['size' => 1024 * 5, 'columns' => ['fd' => ['type' => \Swoole\Table::TYPE_INT, 'size' => 4,],],], 'subjectToUser' => ['size' => 1024 * 5, 'columns' => ['uid' => ['type' => \Swoole\Table::TYPE_STRING, 'size' => 40,],],], 'userToSubject' => ['size' => 1024 * 5, 'columns' => ['subject' => ['type' => \Swoole\Table::TYPE_STRING, 'size' => 32,],],],];