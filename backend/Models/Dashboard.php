<?php

namespace App\Models;

use App\DB\RepositoryModel;
use App\Exceptions\TooFewArgumentsSupplied;
use App\Exceptions\TooManyArgsException;

class Dashboard extends RepositoryModel
{

    // TODO: add total current online users counter
    public function totalOrders(): bool|string|int
    {
        return Order::count();
    }

    /**
     * @throws TooManyArgsException|TooFewArgumentsSupplied
     */
    public function totalCompletedOrders(): bool|string|int
    {
        return Order::count(['completed' => '1']);
    }

    /**
     * @throws TooManyArgsException
     * @throws TooFewArgumentsSupplied
     */
    public function totalPendingOrders()
    {
        return Order::count(['completed' => '0']);
    }

    public function clientsCount() {
        return Client::count(['deleted' => '0']);
    }

    public function usersCount()
    {
        return User::count(['deleted' => '0']);
    }

}