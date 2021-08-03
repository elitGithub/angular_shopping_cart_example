<?php

namespace App\Models;

use App\DB\RepositoryModel;
use App\Exceptions\TooFewArgumentsSupplied;
use App\Exceptions\TooManyArgsException;

class Dashboard extends RepositoryModel
{

    // TODO: add total current online users counter
    public function getTotalOrders(): bool|string|int
    {
        return Order::count();
    }

    /**
     * @throws TooManyArgsException|TooFewArgumentsSupplied
     */
    public function getTotalCompletedOrders(): bool|string|int
    {
        return Order::count(['completed' => '1']);
    }

    /**
     * @throws TooManyArgsException
     * @throws TooFewArgumentsSupplied
     */
    public function getTotalPending()
    {
        return Order::count(['completed' => '0']);
    }

    public function getTotalClients() {
        return Client::count(['deleted' => '0']);
    }

    public function getTotalUsers()
    {
        return User::count(['deleted' => '0']);
    }

}